<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrganizationInfo extends Model
{
    use HasFactory;

    protected $table = 'company_infos';

    // Fillable fields for mass assignment
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'address',
        'google_map_embed',
        'google_map_link',
        'testimonials',
        'testimonials_heading',
        'testimonials_subtext',
        'mobile',
        'email',
        'fb',
        'twitter',
        'linkedin',
        'tiktok',
        'youtube',
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
    ];

    // Cast types
    protected $casts = [
        'created_by'   => 'integer',
        'updated_by'   => 'integer',
        'testimonials' => 'array',
    ];
}
