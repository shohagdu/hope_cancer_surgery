<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescripDrugType extends Model
{
    protected $table    = 'prescrip_drug_type';
    protected $fillable = ['name', 'is_active'];
}
