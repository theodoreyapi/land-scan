<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Agents extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'agent_photo',
        'agent_name',
        'agent_email',
        'agent_phone',
        'agent_password',
        'agent_status',
    ];

    protected $table = 'agents';

    protected $primaryKey = 'agent_id';
}
