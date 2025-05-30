<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Associations extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'tickets_id',
        'agence_id',
        'port_id',
    ];

    protected $table = 'associations';

    protected $primaryKey = 'association_id';
}
