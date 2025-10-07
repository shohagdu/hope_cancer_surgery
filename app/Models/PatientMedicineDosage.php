<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientMedicineDosage extends Model
{
    protected $table = 'patient_medicine_dosage';

    protected $fillable = [
        'patient_medicine_id',
        'dosage_morning',
        'dosage_noon',
        'dosage_afternoon',
        'dosage_night',
        'drug_taking_quantity_unit',
        'meal_time_select',
        'duration',
        'duration_unit_check',
    ];

    public function patient_medicine()
    {
        return $this->belongsTo(Patient_medicine::class, 'patient_medicine_id');
    }
}
