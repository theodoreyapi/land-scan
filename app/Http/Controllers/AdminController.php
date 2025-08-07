<?php

namespace App\Http\Controllers;

use App\Models\Associations;
use App\Models\Events;
use App\Models\EventsAgents;
use App\Models\Portes;
use App\Models\Tickets;
use ConsoleTVs\Charts\Commands\ChartsCommand;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return view('auth.login');
        }

        $events = $user->hasRole('observateur')
            ? $user->visibleEvents()->where('event_status', 'Active')->get()
            : Events::where('event_status', 'Active')->get();

        return view('dashboard.index', compact('events'));
    }

    public function eventStats($id)
    {
        try {
            $event = Events::where('event_id', $id)->first();

            if (!$event) {
                return response()->json(['error' => 'Événement introuvable'], 404);
            }

            $ticketIds = Tickets::where('evenment_id', $id)->pluck('ticket_id');
            $porteIds = Associations::whereIn('tickets_id', $ticketIds)->pluck('port_id')->unique();
            $stadeIds = Portes::whereIn('porte_id', $porteIds)->pluck('stades_id')->unique();
            $nbAgents = EventsAgents::where('events_id', $id)->count();

            // ✅ Nombre de tickets validés (status = UTILISE) par agent pour l'événement
            $ticketsParAgent = DB::table('events_agents')
                ->join('agents', 'agents.agent_id', '=', 'events_agents.agents_id')
                ->join('portes', 'portes.porte_id', '=', 'events_agents.portes_id')
                ->join('associations', 'associations.port_id', '=', 'portes.porte_id')
                ->join('tickets', function ($join) use ($id) {
                    $join->on('tickets.ticket_id', '=', 'associations.tickets_id')
                        ->where('tickets.ticket_status', 'UTILISE')
                        ->where('tickets.evenment_id', $id);
                })
                ->where('events_agents.events_id', $id)
                ->select(
                    'agents.agent_id',
                    'agents.agent_name',
                    DB::raw('COUNT(tickets.ticket_id) as tickets_valides')
                )
                ->groupBy('agents.agent_id', 'agents.agent_name')
                ->get();

            // ✅ Total des tickets validés pour l'événement
            $totalTicketsValides = Tickets::where('evenment_id', $id)
                ->where('ticket_status', 'UTILISE')
                ->count();

            $stats = [
                'nbTickets' => $ticketIds->count(),
                'nbPortes'  => $porteIds->count(),
                'nbStades'  => $stadeIds->count(),
                'nbAgents'  => $nbAgents,
                'totalTicketsValides' => $totalTicketsValides,
                'ticketsParAgent' => $ticketsParAgent,
            ];

            // Données fictives du graphe (tu peux les adapter avec tes vraies données)
            $chartData = [
                'labels' => ['Tickets', 'Portes', 'Stades', 'Agents', 'Tickets Validés'],
                'values' => [
                    $stats['nbTickets'],
                    $stats['nbPortes'],
                    $stats['nbStades'],
                    $stats['nbAgents'],
                    $stats['totalTicketsValides'],
                ],
            ];

            return response()->json([
                'stats' => $stats,
                'chart' => $chartData,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Erreur interne',
                'message' => $e->getMessage(),
            ], 500);
        }
    }
}
