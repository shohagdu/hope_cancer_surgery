<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use HasFactory;
    protected $table = "patient_info";
    protected $fillable = [
        'patient_id', 'name', 'age', 'gender', 'district_id',
        'address', 'religion',
        'occupation', 'education_status', 'monthly_income', 'pt_contact_number', 'blood_group',
        'hospital_reg_no', 'unit', 'ward_no', 'bed_no', 'admission_date', 'discharge_date','created_by','created_ip'
//        'diagnosis', 'present_illness', 'past_illness', 'comorbidities', 'family_history',
//        'drug_history', 'previous_drug_history', 'clinical_findings', 'cbc_result',
//        's_electrolytes', 's_creatinine', 's_urea', 'lft', 's_bilirubin', 'sgpt', 'sgot',
//        'ggt', 'ast', 's_albumin', 's_lipase', 's_amylase', 'blood_glucose', 'x_ray', 'ecg',
//        'usg', 'ct_scan', 'mri', 'mrcp', 'ercp', 'endoscopy', 'colonoscopy', 'fnac',
//        'histopathology', 'immuno_histochemistry', 'genetic_analysis', 'others',
//        'name_of_surgeon', 'name_of_surgeon_assistant', 'name_of_operation', 'date_of_operation',
//        'name_of_anesthesia', 'operative_findings', 'date_of_death', 'causes_death',
    ];
}
