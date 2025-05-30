<?php

namespace App\Http\Controllers;

use App\Imports\TicketImport;
use App\Models\Events;
use App\Models\Tickets;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Facades\Excel;

class TicketsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $events = Events::where('event_status', '=', 'Active')->get();
        $all = Tickets::join('events', 'tickets.evenment_id', '=', 'events.event_id')
            ->select('tickets.*', 'events.event_name')
            ->get();

        return view('events.tickets', compact('all', 'events'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if ($request->file('fichier') != null) {
            try {
                $import = new TicketImport($request->event);

                Excel::import($import, $request->file('fichier'));

                return back()->with('succes', "{$import->count} tickets ont été importés avec succès.");
            } catch (\Maatwebsite\Excel\Validators\ValidationException $e) {
                // Si tu utilises les règles de validation dans ton import
                $failures = $e->failures();

                // Tu peux logguer ou afficher les lignes erronées
                return back()->withErrors(['Importation échouée. Des erreurs ont été trouvées dans le fichier.' . $failures]);
            } catch (\Exception $e) {
                // Pour toute autre erreur (ex: fichier corrompu, mauvaise extension...)
                Log::error('Erreur lors de l\'importation : ' . $e->getMessage());

                return back()->withErrors(['Une erreur est survenue lors de l\'importation.'. $e->getMessage()]);
            }
        } else {
            $roles = [
                'code' => 'required|unique:tickets,ticket_code',
                'st' => 'required',
                'free' => 'required',
                'seas' => '',
                'passed' => '',
            ];
            $customMessages = [
                'code.required' => "Veuillez saisir le code du ticket.",
                'code.unique' => $request->code . " existe déjà. Veuillez essayer un autre code.",
                'st.required' => "Veuillez saisir le ST du ticket.",
                'free.required' => "Veuillez saisir free du ticket.",
            ];

            $request->validate($roles, $customMessages);

            $ticket = new Tickets();
            $ticket->ticket_code = $request->code;
            $ticket->ticket_st = $request->st;
            $ticket->ticket_free = $request->free;
            $ticket->ticket_seas = $request->seas;
            $ticket->ticket_passed = $request->passed;
            $ticket->evenment_id = $request->event;
            if ($ticket->save()) {
                return back()->with('succes',  "Vous avez ajouter " . $request->code);
            } else {
                return back()->withErrors(["Impossible d'ajouter " . $request->code . ". Veuillez réessayer!!"]);
            }
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $ticket = Tickets::findOrFail($id);

        $roles = [
            'st' => 'required',
            'free' => 'required',
            'seas' => '',
            'passed' => '',
        ];
        $customMessages = [
            'st.required' => "Veuillez sélectionner le statut du département.",
            'free.required' => "Veuillez sélectionner le département.",
        ];

        $request->validate($roles, $customMessages);

        if ($ticket->evenment_id !== $request->event) {
            $ticket->evenment_id = $request->event;
        }
        if ($ticket->ticket_status !== $request->statut) {
            $ticket->ticket_status = $request->statut;
        }
        if ($ticket->ticket_passed !== $request->passed) {
            $ticket->ticket_passed = $request->passed;
        }
        $ticket->ticket_st = $request->st;
        $ticket->ticket_free = $request->free;
        $ticket->ticket_seas = $request->seas;

        if ($ticket->save()) {
            return back()->with('succes', "Vous avez modifier avec succès.");
        } else {
            return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Tickets::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }

    public function getByEvent($id)
    {
        $tickets = Tickets::where('evenment_id', $id)->get();

        return response()->json($tickets);
    }
}
