<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (!Auth::check()) {
            return view('auth.login');
        }

        $users = User::all();
        return view('roles.users', compact('users'));
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
            'name' => 'required',
            'prenom' => 'required',
            'role' => 'required',
            'email' => 'required|unique:users,email',
            'phone' => 'nullable|unique:users,phone',
            'password' => 'required',
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

        $user = new User();
        $user->name = $request->name;
        $user->last_name = $request->prenom;
        $user->type = $request->role;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->assignRole($request->role);
        if ($user->save()) {
            return back()->with('succes',  "Vous avez ajouter " . $request->name);
        } else {
            return back()->withErrors(["Impossible d'ajouter " . $request->name . ". Veuillez réessayer!!"]);
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
        $user = User::findOrFail($id);

        $roles = [
            'name' => 'required',
            'prenom' => 'required',
            //'role' => 'required',
            'email' => [
                'required',
                Rule::unique('users', 'email')->ignore($user->id),
            ],
            'phone' => [
                'nullable',
                Rule::unique('users', 'phone')->ignore($user->id),
            ],
            'password' => 'nullable',
        ];
        $customMessages = [
            'name.required' => "Veuillez saisir son nom.",
            'prenom.required' => "Veuillez saisir son prénom.",
            //'role.required' => "Veuillez sélectionner son rôle.",
            'email.required' => "Veuillez saisir son adresse email.",
            'email.unique' => "L'adresse email existe deja.",
            'phone.unique' => "Le Numero de téléphone existe deja.",
        ];

        $request->validate($roles, $customMessages);

        if ($user->email !== $request->email) {
            $user->email = $request->email;
        }
        if ($user->phone !== $request->phone) {
            $user->phone = $request->phone;
        }
        // if ($user->type !== $request->role) {
        //     $user->type = $request->role;
        //     $user->syncRoles($request->role);
        // }

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->name = $request->name;
        $user->last_name = $request->prenom;

        if ($user->save()) {
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
        User::findOrFail($id)->delete();

        return back()->with('succes', "La suppression a été effectué");
    }
}
