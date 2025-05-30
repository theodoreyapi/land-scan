<?php

use App\Http\Controllers\AgentsController;
use App\Http\Controllers\AssociationsController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\EvenementsController;
use App\Http\Controllers\PortesController;
use App\Http\Controllers\TicketsController;
use App\Models\Agents;
use App\Models\Events;
use App\Models\Portes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('index', [CustomAuthController::class, 'dashboard']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin']);
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->intended('index');
    }
    return view('auth.login');
});


//error
Route::fallback(function () {
    return response()->view('errors.error-404', [], 404);
});

//Profile
Route::get('profile', function () {
    return view('profile.profile');
});
Route::get('profile-settings', function () {
    return view('profile.profile-settings');
});
Route::get('security-settings', function () {
    return view('profile.security-settings');
});
Route::get('sms-settings', function () {
    return view('profile.sms-settings');
});
Route::get('sms-template', function () {
    return view('profile.sms-template');
});
Route::get('email-template', function () {
    return view('profile.email-template');
});
Route::get('email-settings', function () {
    return view('profile.email-settings');
});

//CRM
Route::get('activity', function () {
    return view('crm.activity');
});

//Users Management
Route::get('users', function () {
    return view('roles.users');
});

//Repports
Route::get('attendance-report', function () {
    return view('reports.attendance-report');
});
Route::get('daily-report', function () {
    return view('reports.daily-report');
});
Route::get('leave-report', function () {
    return view('reports.leave-report');
});
Route::get('employee-report', function () {
    return view('reports.employee-report');
});

// HRM
Route::resource('agences', AgentsController::class);
Route::get('agent-details', function () {
    return view('events.agent-details');
});
Route::get('add-associate', function () {
    $events = Events::where('event_status', '=', 'Active')->get();
    $agents = Agents::where('agent_status', '=', 'Active')->get();
    $portes = Portes::all();
    return view('events.add-associate', compact('events', 'agents', 'portes'));
});
Route::resource('departments', EvenementsController::class);
Route::get('/tickets/event/{id}', [TicketsController::class, 'getByEvent']);
Route::resource('designations', TicketsController::class);
Route::resource('associations', AssociationsController::class);
Route::resource('portes', PortesController::class);
