<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient_medicine extends Model
{
    use HasFactory;
    protected $table = "patient_medicine";
    protected $fillable = [
        'patient_prescription_id',
        'medicine_id',
        'custom_time_instruction',
        'medicine_serial',
        'is_active',
        'created_by',
        'updated_by',
        'created_ip',
        'updated_ip',
    ];

    public function medicine()
    {
        return $this->belongsTo(PrescriptionMedicineRecord::class, 'medicine_id');
    }
    public function dosages()
    {
        return $this->hasMany(PatientMedicineDosage::class, 'patient_medicine_id');
    }

}
