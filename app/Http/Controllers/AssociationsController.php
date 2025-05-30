<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use App\Models\Associations;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class AssociationsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $all = Agents::select(
            'agents.*',
            DB::raw('(SELECT COUNT(*) FROM associations WHERE associations.agence_id = agents.agent_id) AS total')
        )->get();

        return view('events.associations', compact('all'));
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

        $ticketId = $request->input('tickets', []);
        $agentId = $request->input('agents', []);
        $porteId = $request->input('portes', []);

        if (empty($ticketId) || empty($agentId) || empty($porteId)) {
            return back()->withErrors(["Au moins un agent, une porte et un ticket doivent être sélectionnés."]);
        }

        foreach ($ticketId as $ticket) {
            foreach ($agentId as $agent) {
                foreach ($porteId as $porte) {
                    $association = new Associations();
                    $association->tickets_id = $ticket;
                    $association->agence_id = $agent;
                    $association->port_id = $porte;
                    $association->save();
                }
            }
        }

        return back()->with('succes',  "Association avec succès");
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
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
