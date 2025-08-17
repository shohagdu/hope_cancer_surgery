<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'qualifications',
        'special_training',
        'positions',
        'facebook',
        'twitter',
        'instagram',
        'linkedin',
        'tiktok',
        'youtube',
        'display_position',
        'is_active',
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];
}
