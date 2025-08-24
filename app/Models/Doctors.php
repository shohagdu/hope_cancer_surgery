<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'picture',
        'qualifications',
        'special_training',
        'positions',
        'doctor_profile',
        'mobile',
        'email',
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


}

