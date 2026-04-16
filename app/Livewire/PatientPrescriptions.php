<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\OnlineAppointment;
use App\Models\PatientPrescriptionRecord;

class PatientPrescriptions extends Component
{
    public $patientId;
    public $patient;

    public function mount(int $id): void
    {
        $this->patientId = $id;
        $this->patient   = OnlineAppointment::findOrFail($id);
    }

    public function render()
    {
        $prescriptions = PatientPrescriptionRecord::where('patient_id', $this->patientId)
            ->withCount('patient_medicine_record as medicine_count')
            ->orderByDesc('visit_date')
            ->get();

        return view('livewire.patient-prescriptions', compact('prescriptions'))
            ->layout('layouts.app');
    }
}
