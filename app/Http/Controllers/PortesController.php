<?php

namespace App\Http\Controllers;

use App\Models\Portes;
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
        $portes = Portes::all();
        return view('events.portes', compact('portes'));
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
            'libelle' => 'required|unique:portes,porte_name',
        ];
        $customMessages = [
            'libelle.unique' => $request->libelle . " existe déjà. Veuillez essayer une autre.",
            'libelle.required' => "Veuillez saisir le libelle de la porte.",
        ];

        $request->validate($roles, $customMessages);

        $porte = new Portes();
        $porte->porte_name = $request->libelle;
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
            'libelle' => 'required',
        ];
        $customMessages = [
            'libelle.required' => "Veuillez saisir le libelle de la porte.",
        ];

        $request->validate($roles, $customMessages);

        if ($porte->porte_name !== $request->libelle) {
            $porte->porte_name = $request->libelle;
        }

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
