<?php

namespace App\Http\Controllers;

use App\Models\Events;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class EvenementsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $all = Events::select(
            'events.*',
            DB::raw('(SELECT COUNT(*) FROM tickets WHERE tickets.evenment_id = events.event_id) AS total')
        )->get();

        return view('events.events', compact('all'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $roles = [
            'libelle' => 'required',
            'lieu' => 'required',
            'date' => 'required',
            'time' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de l'évènement.",
            'lieu.required' => "Veuillez saisir le lieu de l'évènement.",
            'date.required' => "Veuillez choisir la date de l'évènement.",
            'time.required' => "Veuillez choisir l'heure de l'évènement.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('photo') == null) {
            $event = new Events();
            $event->event_name = $request->libelle;
            $event->event_lieu = $request->lieu;
            $event->event_date = $request->date;
            $event->event_time = $request->time;
            $event->event_status = $request->statut;
            if ($event->save()) {
                return back()->with('succes',  "Vous avez ajouter " . $request->nom);
            } else {
                return back()->withErrors(["Impossible d'ajouter " . $request->nom . ". Veuillez réessayer!!"]);
            }
        } else {
            $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
            $imageevent = 'photo_event_' . time() . '_' . '.' . $fileStadeWithExtension;
            $request->file('photo')->move(public_path('/events'), $imageevent);

            $event = new Events();
            $event->event_image = $imageevent;
            $event->event_name = $request->libelle;
            $event->event_lieu = $request->lieu;
            $event->event_date = $request->date;
            $event->event_time = $request->time;
            $event->event_status = $request->statut;
            if ($event->save()) {
                return back()->with('succes',  "Vous avez ajouter " . $request->nom);
            } else {
                return back()->withErrors(["Impossible d'ajouter " . $request->nom . ". Veuillez réessayer!!"]);
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
        $event = Events::findOrFail($id);

        $roles = [
            'libelle' => 'required',
            'lieu' => 'required',
            'date' => 'required',
            'time' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de l'évènement.",
            'lieu.required' => "Veuillez saisir le lieu de l'évènement.",
            'date.required' => "Veuillez choisir la date de l'évènement.",
            'time.required' => "Veuillez choisir l'heure de l'évènement.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('photo') == null) {

            $event->event_name = $request->libelle;
            $event->event_lieu = $request->lieu;
            $event->event_date = $request->date;
            $event->event_time = $request->time;
            $event->event_status = $request->statut;
            if ($event->save()) {
                return back()->with('succes', "Vous avez modifier avec succès.");
            } else {
                return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
            }
        } else {
            $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
            $imageevent = 'photo_event_' . time() . '_' . '.' . $fileStadeWithExtension;
            $request->file('photo')->move(public_path('/events'), $imageevent);

            $event->event_image = $imageevent;
            $event->event_name = $request->libelle;
            $event->event_lieu = $request->lieu;
            $event->event_date = $request->date;
            $event->event_time = $request->time;
            $event->event_status = $request->statut;
            if ($event->save()) {
                return back()->with('succes', "Vous avez modifier avec succès.");
            } else {
                return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Events::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
