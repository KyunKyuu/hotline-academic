<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LandingSetting extends Model
{
    use HasFactory;

    protected $fillable = [
        'hero_type',
        'hero_image',
        'hero_video',
        'hero_title',
        'hero_subtitle',
    ];
}
