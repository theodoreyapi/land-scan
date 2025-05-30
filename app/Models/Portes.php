<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Portes extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'porte_name',
    ];

    protected $table = 'portes';

    protected $primaryKey = 'porte_id';
}
