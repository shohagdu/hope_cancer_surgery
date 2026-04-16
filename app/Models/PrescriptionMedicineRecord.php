<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrescriptionMedicineRecord extends Model
{
    use HasFactory;

    protected $table = "prescription_medicine_record";

    protected $fillable = [
        'manufacturer_id',
        'dosage_id',
        'name',
        'generic',
        'strength',
        'price',
        'use_for',
        'DAR',
        'is_active',
    ];

    public function manufacturer()
    {
        return $this->belongsTo(PrescripDrugManufacturer::class, 'manufacturer_id');
    }

    public function drugType()
    {
        return $this->belongsTo(PrescripDrugType::class, 'dosage_id');
    }
}
