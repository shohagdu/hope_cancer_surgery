<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PatientFollowHistory extends Model
{
    use HasFactory;

    protected $fillable = [
       'patient_id', 'clinical_features', 'investigation', 'followup_description','created_by','created_ip','updated_by','updated_ip'
    ];
}
