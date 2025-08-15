<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Agents;
use App\Models\Associations;
use App\Models\Events;
use App\Models\EventsAgents;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Validator;

class ApiAgentsController extends Controller
{
    public function postLoginAgent(Request $request)
    {
        $rules = [
            'login' => 'required',
            'password' => 'required'
        ];

        $messages = [
            'login.required' => 'Veuillez saisir votre identifiant.',
            'password.required' => 'Veuillez saisir votre mot de passe.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $user = Agents::where('agent_phone', $request->login)->first();

        if ($user && Hash::check($request->password, $user->agent_password)) {

            if ($user->agent_status !== 'Active') {
                return response()->json([
                    'message' => "Votre compte est désactivé. Contactez l'admin pour la gestion de votre compte."
                ], 401);
            }

            // Vérifier le nombre de connexions actives
            $connectedCount = Agents::where('agent_connected', true)->count();

            if (!$user->agent_connected && $connectedCount >= 60) {
                return response()->json([
                    'message' => "Le nombre maximal de connexions simultanées a été atteint. Veuillez réessayer plus tard."
                ], 403);
            }

            // Marquer l'utilisateur comme connecté
            $user->agent_connected = true;
            $user->save();

            return response()->json([
                'identifiant' => $user->agent_id,
                'nom' => $user->agent_name,
                'phone' => $user->agent_phone,
                'email' => $user->agent_email ?? "",
                'photo' => $user->agent_photo == null ? "" : URL::asset('agents') . '/' . $user->agent_photo ?? "",
            ], 200);
        } else {
            return response()->json([
                'message' => "Identifiant ou mot de passe incorrect."
            ], 401);
        }
    }

    public function logoutAgent($id)
    {
        $user = Agents::find($id);

        if ($user) {
            $user->agent_connected = false;
            $user->save();

            return response()->json([
                'message' => "Déconnexion réussie."
            ], 200);
        }

        return response()->json([
            'message' => "Agent non trouvé."
        ], 404);
    }

    public function getEventFive($agentId)
    {
        $rawEvents = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->join('portes', 'associations.port_id', '=', 'portes.porte_id')
            ->join('events_agents', 'events.event_id', '=', 'events_agents.events_id')
            ->where('events_agents.agents_id', '=', $agentId)
            ->where('tickets.ticket_status', '=', 'Active')
            ->select(
                'tickets.ticket_id',
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name',
                'tickets.ticket_status'
            )
            ->distinct() // On évite les doublons dès la requête
            ->get();

        // Regroupement par événement
        $grouped = $rawEvents->groupBy('event_id');

        $events = $grouped->map(function ($items, $eventId) {
            $first = $items->first();

            // Liste des portes uniques
            $portes = $items->pluck('porte_name')->unique()->values();

            // Comptage des tickets uniques
            $uniqueTickets = $items->pluck('ticket_id')->unique();

            return [
                'event_id'         => $eventId,
                'event_image'      => $first->event_image == null
                    ? URL::asset('assets/img/users/user-36.jpg')
                    : URL::asset('events/' . $first->event_image),
                'event_name'       => $first->event_name,
                'event_lieu'       => $first->event_lieu,
                'event_date'       => $first->event_date,
                'event_time'       => $first->event_time,
                'portes'           => $portes, // Tableau de portes
                'total_tickets'    => $uniqueTickets->count(),
                'tickets_scannes'  => $items->where('ticket_status', 'UTILISE')->pluck('ticket_id')->unique()->count(),
            ];
        })->values();

        if ($events->count() > 0) {
            return response()->json($events, 200);
        } else {
            return response()->json([
                'message' => "Pas d'événement attribué à cet agent."
            ], 404);
        }
    }

    public function getEvent($agentId)
    {
        $rawEvents = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->join('portes', 'associations.port_id', '=', 'portes.porte_id')
            ->join('events_agents', 'events.event_id', '=', 'events_agents.events_id')
            ->where('events_agents.agents_id', '=', $agentId)
            ->where('tickets.ticket_status', '=', 'UTILISE')
            ->select(
                'tickets.ticket_id',
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name',
                'tickets.ticket_status'
            )
            ->distinct() // On évite les doublons dès la requête
            ->get();

        // Regroupement par événement
        $grouped = $rawEvents->groupBy('event_id');

        $events = $grouped->map(function ($items, $eventId) {
            $first = $items->first();

            // Liste des portes uniques
            $portes = $items->pluck('porte_name')->unique()->values();

            // Comptage des tickets uniques
            $uniqueTickets = $items->pluck('ticket_id')->unique();

            return [
                'event_id'         => $eventId,
                'event_image'      => $first->event_image == null
                    ? URL::asset('assets/img/users/user-36.jpg')
                    : URL::asset('events/' . $first->event_image),
                'event_name'       => $first->event_name,
                'event_lieu'       => $first->event_lieu,
                'event_date'       => $first->event_date,
                'event_time'       => $first->event_time,
                'portes'           => $portes, // Tableau de portes
                'total_tickets'    => $uniqueTickets->count(),
                'tickets_scannes'  => $items->where('ticket_status', 'UTILISE')->pluck('ticket_id')->unique()->count(),
            ];
        })->values();

        if ($events->count() > 0) {
            return response()->json($events, 200);
        } else {
            return response()->json([
                'message' => "Pas d'événement scanne."
            ], 404);
        }
    }

    public function getStats($agentId)
    {
        $stats = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('events_agents', 'events.event_id', '=', 'events_agents.events_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->where('events_agents.agents_id', '=', $agentId)
            ->select(
                DB::raw('COUNT(DISTINCT events.event_id) as total_evenements'),
                DB::raw('COUNT(tickets.ticket_id) as total_tickets'),
                DB::raw("COUNT(CASE WHEN tickets.ticket_status = 'UTILISE' THEN 1 END) as tickets_scannes")
            )
            ->first();

        if ($stats) {
            return response()->json($stats, 200);
        } else {
            return response()->json([
                'total_evenements' => 0,
                'total_tickets'    => 0,
                'tickets_scannes'  => 0
            ], 200); // 200 pour éviter une erreur côté frontend
        }
    }

    public function postScanCode(Request $request)
    {
        $rules = [
            'code' => 'required',
            'agent' => 'required'
        ];

        $messages = [
            'code.required' => 'Impossible de récupérer le code du ticket.',
            'agent.required' => 'Veuillez vous reconnecter pour mener à bien cette opération.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $agents = Agents::where('agent_id', '=', $request->agent)
            ->where('agent_status', '=', 'Active')
            ->first();

        if (!$agents) {
            return response()->json([
                'message' => "Votre compte est désactivé. Vous ne pouvez pas scanner un ticket. Veuillez contacter l'administrateur."
            ], 404);
        }

        $verifEvent = Events::join('tickets', 'events.event_id', '=', 'tickets.evenment_id')
            ->where('tickets.ticket_code', '=', $request->code)
            ->first();

        if (!$verifEvent) {
            return response()->json([
                'message' => "L'evenement n'est plus disponible. Vous ne pouvez pas valider ce ticket"
            ], 404);
        }

        $ticket = Tickets::where('ticket_code', $request->code)->first();

        if (!$ticket) {
            return response()->json([
                'message' => "Le ticket n'existe pas."
            ], 404);
        }

        if ($ticket->ticket_status !== 'Active') {
            return response()->json([
                'message' => "Le ticket est déjà utilisé."
            ], 400);
        }

        // Vérification si l'agent est bien lié à l'événement du ticket
        $isLinked = EventsAgents::where('events_id', $ticket->evenment_id)
            ->where('agents_id', $request->agent)
            ->exists();

        if (!$isLinked) {
            return response()->json([
                'message' => "Vous n’êtes pas autorisé à scanner ce ticket. Événement non assigné à cet agent."
            ], 403);
        }

        // Vérification que le ticket est scanné par une porte assignée à cet agent (via Associations)
        $association = Associations::join('portes', 'associations.port_id', '=', 'portes.porte_id')
            ->join('events_agents', function ($join) use ($request) {
                $join->on('portes.porte_id', '=', 'events_agents.portes_id')
                    ->where('events_agents.agents_id', '=', $request->agent);
            })
            ->where('associations.tickets_id', $ticket->ticket_id)
            ->select('portes.porte_name')
            ->first();

        if (!$association) {
            // Le ticket est valide mais pas scanné à la bonne porte
            $expectedPorte = Associations::join('portes', 'associations.port_id', '=', 'portes.porte_id')
                ->where('associations.tickets_id', $ticket->ticket_id)
                ->select('portes.porte_name')
                ->first();

            return response()->json([
                'message' => "Le ticket n'est pas à la bonne porte. Veuillez l’orienter vers la porte : " . ($expectedPorte->porte_name ?? "inconnue") . ".",
            ], 403);
        }

        // Tout est OK, on valide le ticket
        $ticket->ticket_status = 'UTILISE';

        if ($ticket->save()) {
            return response()->json([
                'message' => "Ticket validé avec succès."
            ], 200);
        } else {
            return response()->json([
                'message' => "Impossible de valider le ticket. Veuillez réessayer."
            ], 500);
        }
    }
}
