<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PrescripDrugManufacturer extends Model
{
    protected $table    = 'prescrip_drug_manufacturers';
    protected $fillable = ['name', 'is_active'];
}
