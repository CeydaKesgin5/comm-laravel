<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $primaryKey = 'event_id';
    
    protected $fillable = [
        'title',
        'description',
        'date',
        'location',
        'image_url',
        'status'
    ];
    
    protected $casts = [
        'date' => 'datetime',
    ];

    public function getRouteKeyName(): string
    {
        return 'event_id';
    }
}
