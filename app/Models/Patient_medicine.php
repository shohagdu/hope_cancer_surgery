<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient_medicine extends Model
{
    use HasFactory;
    protected $table = "patient_medicine";
//    protected $fillable = ['patient_id', 'medicine_id', 'dose', 'instruction'];

}
