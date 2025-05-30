<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Events extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'event_image',
        'event_name',
        'event_lieu',
        'event_date',
        'event_time',
        'event_status',
    ];

    protected $table = 'events';

    protected $primaryKey = 'event_id';
}
