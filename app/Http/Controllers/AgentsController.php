<?php

namespace App\Http\Controllers;

use App\Models\Agents;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AgentsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $agents = Agents::all();
        $total = Agents::count();
        $active = Agents::where('agent_status','=', 'Active')->count();
        $inactive = Agents::where('agent_status','=', 'Inactive')->count();
        return view('events.agents', compact('agents', 'total', 'active', 'inactive'));
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
            'phone' => 'required|unique:agents,agent_phone',
            'email' => 'unique:agents,agent_email',
            'photo' => '',
            'nom' => 'required',
            'password' => 'required',
            'statut' => 'required',
        ];
        $customMessages = [
            'phone.unique' => $request->phone . " existe déjà. Veuillez essayer un autre.",
            'phone.required' => "Veuillez saisir son numéro de téléphone.",
            'email.unique' => $request->email . " existe déjà. Veuillez essayer un autre.",
            'nom.required' => "Veuillez saisir son nom complet.",
            'password.required' => "Veuillez saisir son mot de passe.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('photo') == null) {
            $agent = new Agents();
            $agent->agent_name = $request->nom;
            $agent->agent_email = $request->email;
            $agent->agent_phone = $request->phone;
            $agent->agent_status = $request->statut;
            $agent->agent_password = hash::make($request->password);
            if ($agent->save()) {
                return back()->with('succes',  "Vous avez ajouter " . $request->nom);
            } else {
                return back()->withErrors(["Impossible d'ajouter " . $request->nom . ". Veuillez réessayer!!"]);
            }
        } else {
            $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
            $imageAgent = 'photo_agent_' . time() . '_' . '.' . $fileStadeWithExtension;
            $request->file('photo')->move(public_path('/agents'), $imageAgent);

            $agent = new Agents();
            $agent->agent_photo = $imageAgent;
            $agent->agent_name = $request->nom;
            $agent->agent_email = $request->email;
            $agent->agent_phone = $request->phone;
            $agent->agent_status = $request->statut;
            $agent->agent_password = hash::make($request->password);
            if ($agent->save()) {
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
        $agent = Agents::findOrFail($id);

        $roles = [
            'phone' => 'required',
            'email' => '',
            'photo' => '',
            'nom' => 'required',
            'password' => '',
            'statut' => 'required',
        ];
        $customMessages = [
            'phone.required' => "Veuillez saisir son numéro de téléphone.",
            'nom.required' => "Veuillez saisir son nom complet.",
            'statut.required' => "Veuillez sélectionner son statut.",
        ];

        $request->validate($roles, $customMessages);

        if ($request->file('photo') == null) {

            if ($agent->agent_email !== $request->email) {
                $agent->agent_email = $request->email;
            }
            if ($agent->agent_phone !== $request->phone) {
                $agent->agent_phone = $request->phone;
            }
            $agent->agent_name = $request->nom;
            $agent->agent_status = $request->statut;
            if ($agent->save()) {
                return back()->with('succes', "Vous avez modifier avec succès.");
            } else {
                return back()->withErrors(["Problème lors de la modification. Veuillez réessayer!!"]);
            }
        } else {
            $fileStadeWithExtension = $request->file('photo')->getClientOriginalName();
            $imageAgent = 'photo_agent_' . time() . '_' . '.' . $fileStadeWithExtension;
            $request->file('photo')->move(public_path('/agents'), $imageAgent);

            if ($agent->agent_email !== $request->email) {
                $agent->agent_email = $request->email;
            }
            if ($agent->agent_phone !== $request->phone) {
                $agent->agent_phone = $request->phone;
            }
            $agent->agent_photo = $imageAgent;
            $agent->agent_name = $request->nom;
            $agent->agent_status = $request->statut;
            if ($agent->save()) {
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
        Agents::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
