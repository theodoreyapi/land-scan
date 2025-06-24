<?php

namespace App\Http\Controllers;

use App\Models\Stades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StadeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

        if (!Auth::check()) {
            return view('auth.login');
        }

        $all = Stades::select(
            'stades.*',
            DB::raw('(SELECT COUNT(*) FROM portes WHERE portes.stades_id = stades.stade_id) AS total')
        )->get();

        return view('events.stades', compact('all'));
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
            'photo' => 'required',
            'libelle' => 'required',
            'adresse' => '',
            'statut' => 'required',
        ];
        $customMessages = [
            'photo.required' => "Veuillez sélectionner la photo du stade.",
            'libelle.required' => "Veuillez saisir le libelle du stade.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
        $imageevent = 'photo_stade_' . time() . '_' . '.' . $fileStadeWithExtension;
        $request->file('photo')->move(public_path('/stades-image'), $imageevent);

        $event = new Stades();
        $event->stade_image = $imageevent;
        $event->stade_name = $request->libelle;
        $event->stade_address = $request->adresse;
        $event->stade_status = $request->statut;
        if ($event->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->libelle);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->libelle . ". Veuillez réessayer!!"]);
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
        $event = Stades::findOrFail($id);

        $roles = [
            'photo' => '',
            'libelle' => 'required',
            'adresse' => '',
            'statut' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle du stade.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('photo') == null) {

            $event->stade_name = $request->libelle;
            $event->stade_address = $request->adresse;
            $event->stade_status = $request->statut;
            if ($event->save()) {
                return back()->with('succes', "Vous avez modifier avec succès.");
            } else {
                return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
            }
        } else {
            $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
            $imageevent = 'photo_event_' . time() . '_' . '.' . $fileStadeWithExtension;
            $request->file('photo')->move(public_path('/stades-image'), $imageevent);

            $event->stade_image = $imageevent;
            $event->stade_name = $request->libelle;
            $event->stade_address = $request->adresse;
            $event->stade_status = $request->statut;
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
        Stades::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
