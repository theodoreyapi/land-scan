<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class CustomAuthController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function customLogin(Request $request)
    {
        $roles = [
            'email' => 'required',
            'password' => 'required',
        ];
        $customMessages = [
            'email.required' => "Veuillez saisir son adresse email.",
            'password.required' => "Veuillez saisir son mot de passe.",
        ];

        $request->validate($roles, $customMessages);

        $credentials = $request->only('email', 'password');
        $user = User::where('email', $credentials['email'])->first();

        if ($user && Hash::check($credentials['password'], $user->password)) {

            if ($user->status == 'Active') {
                Auth::login($user);
                return redirect()->intended('index');
            } else {
                return back()->withErrors(['Votre compte est désactivé. Veuillez contacter l\'administrateur.']);
            }
        } else {
            return back()->withErrors( ['E-mail ou mot de passe incorrect.']);
        }
    }

    public function dashboard()
    {
        if (Auth::check()) {

            

            return view('dashboard.index');
        } else {
            return view('auth.login');
        }
    }

    public function signOut()
    {
        Session::flush();
        Auth::logout();
        return Redirect('/');
    }
}
