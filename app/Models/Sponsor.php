<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sponsor extends Model
{
    protected $primaryKey = 'sponsor_id';
    
    protected $fillable = [
        'name',
        'sponsorship_type',
        'image_url'
    ];
}
