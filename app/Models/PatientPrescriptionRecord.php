<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionRecord extends Model
{
    protected $table = 'patients_prescription_record';

    // Mass assignable fields
    protected $fillable = [
        'patient_id',
        'visit_date',
        'complaints',
        'on_examination',
        'pastHistory',
        'drugHistory',
        'investigation',
        'diagnosis',
        'treatmentPlan',
        'operationNote',
        'advice',
        'nextPlan',
        'hospitalizations',
        'next_visit_date',
        'created_by',
        'updated_by',
        'created_ip',
        'updated_ip',
    ];

    public function patient_medicine_record(){
        return $this->hasMany(Patient_medicine::class, 'patient_prescription_id');
    }
}
