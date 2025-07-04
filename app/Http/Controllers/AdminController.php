<?php

namespace App\Http\Controllers;

use App\Models\Associations;
use App\Models\Events;
use App\Models\EventsAgents;
use App\Models\Portes;
use App\Models\Tickets;
use ConsoleTVs\Charts\Commands\ChartsCommand;
use Illuminate\Support\Facades\Auth;

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

            $stats = [
                'nbTickets' => $ticketIds->count(),
                'nbPortes'  => $porteIds->count(),
                'nbStades'  => $stadeIds->count(),
                'nbAgents'  => $nbAgents,
            ];

            // $chart = ChartsCommand::multi('bar', 'highcharts')
            //     ->title("Évolution des participants")
            //     ->colors(['#3490dc'])
            //     ->labels(['Jour 1', 'Jour 2', 'Jour 3'])
            //     ->dataset('Participants', [3, 5, 2]);

            $stats = [
                'nbTickets'  => $ticketIds->count(),
                'nbPortes'   => $porteIds->count(),
                'nbStades'   => $stadeIds->count(),
                'nbAgents'   => $nbAgents,
            ];

            // Données fictives du graphe (tu peux les adapter avec tes vraies données)
            $chartData = [
                'labels' => ['Tickets', 'Portes', 'Stades', 'Agents'],
                'values' => [
                    $stats['nbTickets'],
                    $stats['nbPortes'],
                    $stats['nbStades'],
                    $stats['nbAgents'],
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
