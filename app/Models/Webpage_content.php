<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webpage_content extends Model
{
    use HasFactory;

    // Table name (optional if Laravel can guess it from the model name)
    protected $table = 'webpage_contents';

    // Allow mass assignment for these fields
    protected $fillable = [
        'type',
        'icon',
        'title',
        'short_description',
        'description',
        'storage_type',
        'file_path',
        'display_position',
        'is_highlight_item',
        'is_active',
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
    ];

    // Cast fields to correct types
//    protected $casts = [
////        'is_active' => 'integer', // keep it as integer
////        'is_highlight_item' => 'integer', // if also 0/1
//    ];
}
