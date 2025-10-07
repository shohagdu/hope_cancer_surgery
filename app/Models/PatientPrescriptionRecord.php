<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PatientPrescriptionRecord extends Model
{
    protected $table = 'patients_prescription_record';


    public function patient_medicine_record(){
        return $this->hasMany(Patient_medicine::class, 'patient_prescription_id');
    }
}
