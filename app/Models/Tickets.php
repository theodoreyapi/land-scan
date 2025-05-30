<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tickets extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'ticket_code',
        'ticket_st',
        'ticket_free',
        'ticket_seas',
        'ticket_passed',
        'ticket_status',
        'evenment_id',
    ];

    protected $table = 'tickets';

    protected $primaryKey = 'ticket_id';
}
