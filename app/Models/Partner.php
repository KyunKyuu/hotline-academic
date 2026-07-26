<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Partner extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'name',
        'tagline',
        'logo',
        'profile',
        'activities',
    ];

    protected $casts = [
        'activities' => 'array',
    ];
}
