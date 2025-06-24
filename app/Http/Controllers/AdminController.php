<?php

namespace App\Http\Controllers;

use App\Models\Events;
use ConsoleTVs\Charts\Commands\ChartsCommand;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return view('auth.login');
        }

        $events = $user->hasRole('observateur')
            ? $user->visibleEvents()->where('event_status', 'Active')->get()
            : Events::where('event_status', 'Active')->get();

        return view('dashboard.index', compact('events'));
    }

    public function eventStats($id)
    {
        $event = Events::with('participants', 'observers')->findOrFail($id);

        // Statistiques de base
        $stats = [
            'nbParticipants' => $event->participants->count(),
            'nbObservateurs' => $event->observers->count(),
        ];

        // Exemple : graphe participants par jour
        $chart = ChartsCommand::multi('bar', 'highcharts')
            ->title("Évolution des participants")
            ->colors(['#3490dc'])
            ->labels(['Jour 1', 'Jour 2', 'Jour 3']) // remplace par dates réelles
            ->dataset('Participants', [3, 5, 2]);     // à remplacer dynamiquement

        return response()->json([
            'stats' => $stats,
            'chart' => $chart->api(),
        ]);
    }
}
