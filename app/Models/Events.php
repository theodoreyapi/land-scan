<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Events extends Model
{
    protected $fillable = [
        'event_image',
        'event_name',
        'event_lieu',
        'event_date',
        'event_time',
        'event_date_fin',
        'event_time_fin',
        'event_status',
    ];

    protected $table = 'events';

    protected $primaryKey = 'event_id';

    public function observers()
    {
        return $this->belongsToMany(User::class);
    }
}
