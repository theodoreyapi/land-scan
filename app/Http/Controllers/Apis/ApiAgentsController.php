<?php

namespace App\Http\Controllers\Apis;

use App\Http\Controllers\Controller;
use App\Models\Agents;
use App\Models\Associations;
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


    public function getEventFive($id)
    {
        $events = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->leftJoin('portes', 'associations.port_id', '=', 'portes.porte_id')
            ->where('associations.agence_id', '=', $id)
            ->where('tickets.ticket_status', '=', 'Active')
            ->select(
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name',
                DB::raw('COUNT(tickets.ticket_id) as total_tickets'),
                DB::raw("SUM(CASE WHEN tickets.ticket_status = 'UTILISE' THEN 1 ELSE 0 END) as tickets_scannes")
            )
            ->groupBy(
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name'
            )
            ->get()
            ->map(function ($event) {
                return [
                    'event_id'         => $event->event_id,
                    'event_image'      => $event->event_image == null ? URL::asset('assets/img/users/user-36.jpg') : URL::asset('events') . '/' . $event->event_image,
                    'event_name'       => $event->event_name,
                    'event_lieu'       => $event->event_lieu,
                    'event_date'       => $event->event_date,
                    'event_time'       => $event->event_time,
                    'porte_name'       => $event->porte_name,
                    'total_tickets'    => (int) $event->total_tickets,
                    'tickets_scannes'  => (int) $event->tickets_scannes,
                ];
            });

        if ($events) {
            return response()->json($events, 200);
        } else {
            return response()->json([
                'message' => "Pas d'évènement attribué."
            ], 401);
        }
    }

    public function getEvent($id)
    {
        $events = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->leftJoin('portes', 'associations.port_id', '=', 'portes.porte_id')
            ->where('associations.agence_id', '=', $id)
            ->where('tickets.ticket_status', '=', 'UTILISE')
            ->select(
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name',
                DB::raw('COUNT(tickets.ticket_id) as total_tickets'),
                DB::raw("SUM(CASE WHEN tickets.ticket_status = 'UTILISE' THEN 1 ELSE 0 END) as tickets_scannes")
            )
            ->groupBy(
                'events.event_id',
                'events.event_image',
                'events.event_name',
                'events.event_lieu',
                'events.event_date',
                'events.event_time',
                'portes.porte_name'
            )
            ->get()
            ->map(function ($event) {
                return [
                    'event_id'         => $event->event_id,
                    'event_image'      => $event->event_image == null ? URL::asset('assets/img/users/user-36.jpg') : URL::asset('events') . '/' . $event->event_image,
                    'event_name'       => $event->event_name,
                    'event_lieu'       => $event->event_lieu,
                    'event_date'       => $event->event_date,
                    'event_time'       => $event->event_time,
                    'porte_name'       => $event->porte_name,
                    'total_tickets'    => (int) $event->total_tickets,
                    'tickets_scannes'  => (int) $event->tickets_scannes,
                ];
            });

        if ($events) {
            return response()->json($events, 200);
        } else {
            return response()->json([
                'message' => "Pas d'évènement attribué."
            ], 401);
        }
    }

    public function getStats($id)
    {
        $stats = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->join('associations', 'tickets.ticket_id', '=', 'associations.tickets_id')
            ->where('associations.agence_id', '=', $id)
            ->select(
                DB::raw('COUNT(DISTINCT events.event_id) as total_evenements'),
                DB::raw('COUNT(tickets.ticket_id) as total_tickets'),
                DB::raw("COUNT(CASE WHEN tickets.ticket_status = 'UTILISE' THEN 1 END) as tickets_scannes")
            )
            ->groupBy('associations.agence_id')
            ->first();

        if ($stats) {
            return response()->json($stats, 200);
        } else {
            return response()->json([
                'total_evenements' => 0,
                'total_tickets'   => 0,
                'tickets_scannes' => 0
            ], 401);
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
            'agent.required' => 'Veuillez vous reconnecter pour mener a bien cette opération.',
        ];

        $validator = Validator::make($request->all(), $rules, $messages);

        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->errors(),
            ], 422);
        }

        $ticket = Tickets::where('ticket_code', $request->code)->first();

        if ($ticket) {
            if ($ticket->ticket_status == 'Active') {
                $asso = Associations::where('agence_id', $request->agent)->where('tickets_id', $ticket->ticket_id)->first();
                if ($asso) {

                    $ticket->ticket_status = 'UTILISE';
                    if ($ticket->save()) {
                        return response()->json([
                            'message' => "Ticket validé avec success."
                        ], 200);
                    } else {
                        return response()->json([
                            'message' => "Impossible de valider le ticket. Veuillez réessayer!!!"
                        ], 401);
                    }
                } else {

                    $agent = Associations::join('tickets', 'associations.tickets_id', '=', 'tickets.ticket_id')
                        ->join('agents', 'associations.agence_id', '=', 'agents.agent_id')
                        ->join('portes', 'associations.port_id', '=', 'portes.porte_id')
                        ->where('tickets.ticket_code', '=', $request->code)
                        ->select('portes.porte_name')
                        ->first();

                    return response()->json([
                        'message' => "Le ticket n'est pas a la bonne porte. Indiquez lui la porte " . $agent,
                    ], 401);
                }
            } else {
                return response()->json([
                    'message' => "Le ticket est déjà utilisé."
                ], 401);
            }
        } else {
            return response()->json([
                'message' => "Le ticket n'existe pas."
            ], 401);
        }
    }
}
