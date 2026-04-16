<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OnlineAppointment;
use App\Models\PatientPrescriptionRecord;
use App\Models\Doctors;

class PatientListPage extends Component
{
    use WithPagination;

    public string $search  = '';
    public string $perPage = '15';
    protected $paginationTheme = 'tailwind';

    // New patient modal
    public bool $showCreateModal = false;
    public array $newPatient = [
        'patient_name'   => '',
        'age'            => '',
        'mobile'         => '',
        'gender'         => '',
        'address'        => '',
        'referer_doctor' => '',
        'remarks'        => '',
    ];

    protected array $rules = [
        'newPatient.patient_name' => 'required|string|max:255',
        'newPatient.age'          => 'required|string|max:50',
        'newPatient.mobile'       => 'required|string|max:20',
        'newPatient.gender'       => 'required|in:male,female,other',
        'newPatient.address'      => 'nullable|string|max:255',
        'newPatient.referer_doctor' => 'nullable|string|max:255',
        'newPatient.remarks'      => 'nullable|string|max:255',
    ];

    protected array $messages = [
        'newPatient.patient_name.required' => 'Patient name is required.',
        'newPatient.age.required'          => 'Age is required.',
        'newPatient.mobile.required'       => 'Mobile is required.',
        'newPatient.gender.required'       => 'Please select a gender.',
    ];

    public function updatingSearch() { $this->resetPage(); }

    public function openCreateModal(): void
    {
        $this->reset('newPatient');
        $this->newPatient = [
            'patient_name'   => '',
            'age'            => '',
            'mobile'         => '',
            'gender'         => '',
            'address'        => '',
            'referer_doctor' => '',
            'remarks'        => '',
        ];
        $this->resetValidation();
        $this->showCreateModal = true;
    }

    public function createPatient(): void
    {
        $this->validate();

        // Determine doctor_id
        $doctorId = null;
        if (auth()->user()->isDoctor()) {
            $doctor = Doctors::where('user_id', auth()->id())->first();
            $doctorId = $doctor?->id;
        }

        $patient = OnlineAppointment::create([
            'date_time'      => now(),
            'doctor_id'      => $doctorId ?? 0,
            'patient_name'   => $this->newPatient['patient_name'],
            'age'            => $this->newPatient['age'],
            'mobile'         => $this->newPatient['mobile'],
            'gender'         => $this->newPatient['gender'],
            'address'        => $this->newPatient['address'] ?? null,
            'referer_doctor' => $this->newPatient['referer_doctor'] ?? null,
            'remarks'        => $this->newPatient['remarks'] ?? null,
            'patient_type'   => 1,
            'created_by'     => auth()->id(),
        ]);

        // Redirect to prescription page for the new patient (doctor role)
        if (auth()->user()->isDoctor()) {
            $this->redirectRoute('prescription.new_patient', ['id' => $patient->id]);
            return;
        }

        $this->showCreateModal = false;
        $this->reset('newPatient');
        session()->flash('success', 'Patient created successfully.');
    }

    public function render()
    {
        $query = OnlineAppointment::query()
            ->addSelect([
                'online_appointments.*',
                'last_visit_date' => PatientPrescriptionRecord::select('visit_date')
                    ->whereColumn('patient_id', 'online_appointments.id')
                    ->orderByDesc('visit_date')
                    ->limit(1),
                'prescription_count' => PatientPrescriptionRecord::selectRaw('count(*)')
                    ->whereColumn('patient_id', 'online_appointments.id'),
            ])
            ->when($this->search, fn($q) =>
                $q->where('patient_name', 'like', "%{$this->search}%")
                  ->orWhere('mobile', 'like', "%{$this->search}%")
            );

        // Doctors only see their own patients
        if (auth()->user()->isDoctor()) {
            $doctor = Doctors::where('user_id', auth()->id())->first();
            if ($doctor) {
                $query->where('doctor_id', $doctor->id);
            } else {
                $query->whereRaw('0 = 1');
            }
        }

        $patients = $query->latest()->paginate((int) $this->perPage);

        return view('livewire.patient-list-page', compact('patients'))
            ->layout('layouts.app');
    }
}
