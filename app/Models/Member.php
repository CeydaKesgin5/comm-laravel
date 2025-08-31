<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    protected $primaryKey = 'member_id';
    
    protected $fillable = [
        'name',
        'email',
        'role',
        'image_url',
        'team'
    ];

    public function getRouteKeyName(): string
    {
        return 'member_id';
    }
}
