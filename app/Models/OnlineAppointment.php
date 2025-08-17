<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineAppointment extends Model
{
    use HasFactory;

    protected $table = 'online_appointments';

    protected $fillable = [
        'date_time',
        'doctor_id',
        'patient_name',
        'mobile',
        'gender',
        'patient_type',
        'created_by',
        'created_ip',
        'updated_by',
        'updated_ip',
    ];

    protected $casts = [
        'date_time' => 'datetime',
        'doctor_id' => 'integer',
        'patient_type' => 'integer',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    // Optional: Relationship with Doctor
    public function doctor()
    {
        return $this->belongsTo(Doctors::class);
    }
}
