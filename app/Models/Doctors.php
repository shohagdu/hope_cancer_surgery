<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Doctors extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'picture',
        'qualifications',
        'special_training',
        'positions',
        'hero_tag',
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
        'stat_experience',
        'stat_publications',
        'stat_patients',
        'stat_success_rate',
        'expertise',
        'chambers',
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
    ];

    protected $casts = [
        'expertise' => 'array',
        'chambers'  => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'user_id');
    }
}
