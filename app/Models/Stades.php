<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Stades extends Model
{
    protected $fillable = [
        'stade_image',
        'stade_name',
        'stade_address',
        'stade_status',
    ];

    protected $table = 'stades';

    protected $primaryKey = 'stade_id';
}
