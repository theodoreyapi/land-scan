<?php

namespace App\Http\Controllers;

use App\Models\Events;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{

    public function create()
    {
        $roles = Role::all(); // 'admin', 'superviseur', 'observateur'
        $events = Events::where('event_status', 'Active')->get(); // pour assigner aux observateurs

        return view('admin.users.create', compact('roles', 'events'));
    }

    public function store(Request $request)
    {

         $roles = [
            'name' => 'required',
            'prenom' => 'required',
            'role' => 'required|exists:roles,name',
            'email' => 'required|unique:users,email',
            'phone' => 'nullable|unique:users,phone',
            'password' => 'required',
            'events' => 'array',
        ];
        $customMessages = [
            'name.required' => "Veuillez saisir son nom.",
            'prenom.required' => "Veuillez saisir son prénom.",
            'role.required' => "Veuillez sélectionner son rôle.",
            'email.required' => "Veuillez saisir son adresse email.",
            'email.unique' => "L'adresse email existe deja.",
            'phone.unique' => "Le Numero de téléphone existe deja.",
            'password.required' => "Veuillez saisir son mot de passe.",
        ];

        $request->validate($roles, $customMessages);

        $user = User::create([
            'name' => $request->name,
            'last_name' => $request->prenom,
            'email' => $request->email,
            'phone' => $request->phone,
            'type' => $request->role,
            'password' => Hash::make($request->password),
            'status' => 'Active',
        ]);

        $user->assignRole($request->role);

        // Si le rôle est observateur, assigner les événements
        if ($request->role === 'observateur' && $request->has('events')) {
            $user->visibleEvents()->sync($request->events);
        }

        return back()->with('succes', 'Utilisateur créé avec succès.');
    }
}
