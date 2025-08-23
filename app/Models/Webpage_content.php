<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Webpage_content extends Model
{
    use HasFactory;

    // Explicit table name (optional if Laravel can infer it)
    protected $table = 'webpage_contents';

    // Mass assignable fields
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

    // Fields hidden from JSON/array output
    protected $hidden = [
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
        'created_at',
        'updated_at',
    ];

    /**
     * Automatically append custom attributes
     */
    protected $appends = [
        'file_url',
    ];

    /**
     * Accessor for full file URL
     */
    public function getFileUrlAttribute()
    {
        return $this->file_path
            ? asset('storage/' . $this->file_path)
            : null;
    }
}
