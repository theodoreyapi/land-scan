<?php

namespace App\Http\Controllers;

use App\Models\Portes;
use App\Models\Stades;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PortesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }
        $stades = Stades::where('stade_status', '=', 'Active')->get();
        $portes = Portes::join('stades', 'portes.stades_id', '=', 'stades.stade_id')
            ->select('portes.*', 'stades.stade_name')
            ->get();
        return view('events.portes', compact('portes', 'stades'));
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
            'stade' => 'required',
            'statut' => 'required',
            'libelle' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de la porte.",
            'stade.required' => "Veuillez sélectionner le stade de la porte.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        $porte = new Portes();
        $porte->porte_name = $request->libelle;
        $porte->porte_status = $request->statut;
        $porte->stades_id = $request->stade;
        if ($porte->save()) {
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
        $porte = Portes::findOrFail($id);

        $roles = [
            'stade' => 'required',
            'statut' => 'required',
            'libelle' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de la porte.",
            'stade.required' => "Veuillez sélectionner le stade de la porte.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($porte->porte_name !== $request->libelle) {
            $porte->porte_name = $request->libelle;
        }

        $porte->porte_status = $request->statut;
        $porte->stades_id = $request->stade;

        if ($porte->save()) {
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
        Portes::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
