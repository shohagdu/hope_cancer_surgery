<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctors;
use App\Models\OnlineAppointment;
use App\Models\PatientPrescriptionRecord;

class DoctorDashboard extends Component
{
    public function render()
    {
        $doctor = Doctors::where('user_id', auth()->id())->first();

        $todayPatients  = 0;
        $totalPatients  = 0;
        $recentPatients = collect();

        if ($doctor) {
            $patientIds = OnlineAppointment::where('doctor_id', $doctor->id)->pluck('id');

            $todayPatients = PatientPrescriptionRecord::whereIn('patient_id', $patientIds)
                ->whereDate('visit_date', today())
                ->count();

            $totalPatients = PatientPrescriptionRecord::whereIn('patient_id', $patientIds)
                ->distinct('patient_id')
                ->count('patient_id');

            $recentPatients = OnlineAppointment::where('doctor_id', $doctor->id)
                ->whereHas('patientPrescriptionRecords')
                ->with(['patientPrescriptionRecords' => fn($q) => $q->latest()->limit(1)])
                ->latest()
                ->limit(8)
                ->get();
        }

        return view('livewire.doctor-dashboard', compact('doctor', 'todayPatients', 'totalPatients', 'recentPatients'))
            ->layout('layouts.app');
    }
}
