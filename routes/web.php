<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AgentsController;
use App\Http\Controllers\AssociationsController;
use App\Http\Controllers\CustomAuthController;
use App\Http\Controllers\EvenementsController;
use App\Http\Controllers\ObservateurController;
use App\Http\Controllers\PortesController;
use App\Http\Controllers\StadeController;
use App\Http\Controllers\SuperviseurController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\UserController;
use App\Models\Agents;
use App\Models\Events;
use App\Models\Portes;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('index', [CustomAuthController::class, 'dashboard']);
Route::post('custom-login', [CustomAuthController::class, 'customLogin']);
Route::get('logout', [CustomAuthController::class, 'signOut'])->name('logout');

Route::get('/', [CustomAuthController::class, 'dashboard']);

// Admin
Route::middleware(['role:admin'])->group(function () {
    Route::get('/admin', [AdminController::class, 'index'])->name('admin.dashboard');
});
// Superviseur
Route::middleware(['role:superviseur'])->group(function () {
    Route::get('/evenements', [AdminController::class, 'index'])->name('superviseur.dashboard');
});
// Observateur
Route::middleware(['role:observateur'])->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('observateur.dashboard');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard/event/{id}/stats', [AdminController::class, 'eventStats'])->name('dashboard.event.stats');
});


// Create admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/users/create', [AdminUserController::class, 'create'])->name('admin.users.create');
    Route::post('/admin/users', [AdminUserController::class, 'store'])->name('admin.users.store');
});

//error
Route::fallback(function () {
    return response()->view('errors.error-404', [], 404);
});

//Profile
Route::get('profile', function () {
    return view('profile.profile');
});

//CRM
Route::get('activity', function () {
    return view('crm.activity');
});

//Users Management
Route::resource('users', UserController::class);

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
Route::resource('stades', StadeController::class);
Route::resource('portes', PortesController::class);
