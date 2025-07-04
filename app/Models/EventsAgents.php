<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class EventsAgents extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'agents_id',
        'events_id',
        'portes_id',
    ];

    protected $table = 'events_agents';

    protected $primaryKey = 'event_agent_id';
}
