<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\OnlineAppointment;
use App\Models\Doctors;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;

class OnlineAppointmentManager extends Component
{
    use WithPagination;

    public $date_time, $doctor_id, $patient_name, $mobile, $gender, $patient_type;
    public $age, $message, $remarks, $status = 1;
    public $appointment_id;
    public $isEditing = false;
    public $search = '';
    public $filterStatus = '';
    public $perPage = 10;
    public $showAdminOnlineAppointment = false;
    protected $paginationTheme = 'tailwind';

    public $statusLabels = [
        1 => 'Pending',
        2 => 'Confirmed',
        3 => 'Cancelled',
    ];

    protected $rules = [
        'date_time'    => 'required|date',
        'doctor_id'    => 'required|integer|exists:doctors,id',
        'patient_name' => 'required|string|max:255',
        'mobile'       => 'required|string|max:20',
        'gender'       => 'nullable|in:male,female,other',
        'patient_type' => 'required|in:1,2',
        'age'          => 'nullable|string|max:10',
        'status'       => 'required|in:1,2,3',
        'message'      => 'nullable|string|max:2000',
        'remarks'      => 'nullable|string|max:500',
    ];

    public function updatingSearch()  { $this->resetPage(); }
    public function updatingFilterStatus() { $this->resetPage(); }

    public function render()
    {
        $appointments = OnlineAppointment::with('doctor')
            ->when($this->search, fn($q) =>
                $q->where('patient_name', 'like', "%{$this->search}%")
                  ->orWhere('mobile', 'like', "%{$this->search}%")
            )
            ->when($this->filterStatus !== '', fn($q) =>
                $q->where('status', $this->filterStatus)
            )
            ->latest()
            ->paginate($this->perPage);

        $doctors = Doctors::where('is_active', 1)->get();

        return view('livewire.online-appointment-manager', [
            'appointments' => $appointments,
            'doctors' => $doctors,
        ]);
    }

    public function store()
    {
        $this->validate();

        try {
            OnlineAppointment::create([
                'date_time'    => $this->date_time,
                'doctor_id'    => $this->doctor_id,
                'patient_name' => $this->patient_name,
                'mobile'       => $this->mobile,
                'gender'       => $this->gender,
                'patient_type' => $this->patient_type,
                'age'          => $this->age,
                'message'      => $this->message,
                'remarks'      => $this->remarks,
                'status'       => $this->status,
                'created_by'   => Auth::id() ?? null,
                'created_ip'   => Request::ip(),
            ]);

            $this->resetForm();
            $this->showAdminOnlineAppointment = false;
            $this->dispatch('swal:success', [
                'title' => 'Saved!',
                'text'  => 'Appointment created successfully.',
            ]);

        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function edit($id)
    {
        $this->showAdminOnlineAppointment = true;
        $appointment = OnlineAppointment::findOrFail($id);
        $this->appointment_id = $appointment->id;
        $this->date_time      = $appointment->date_time->format('Y-m-d\TH:i');
        $this->doctor_id      = $appointment->doctor_id;
        $this->patient_name   = $appointment->patient_name;
        $this->mobile         = $appointment->mobile;
        $this->gender         = $appointment->gender;
        $this->patient_type   = $appointment->patient_type;
        $this->age            = $appointment->age;
        $this->message        = $appointment->message;
        $this->remarks        = $appointment->remarks;
        $this->status         = $appointment->status ?? 1;
        $this->isEditing      = true;
    }

    public function update()
    {
        $this->validate();

        try {
            $appointment = OnlineAppointment::findOrFail($this->appointment_id);
            $appointment->update([
                'date_time'    => $this->date_time,
                'doctor_id'    => $this->doctor_id,
                'patient_name' => $this->patient_name,
                'mobile'       => $this->mobile,
                'gender'       => $this->gender,
                'patient_type' => $this->patient_type,
                'age'          => $this->age,
                'message'      => $this->message,
                'remarks'      => $this->remarks,
                'status'       => $this->status,
                'updated_by'   => Auth::id() ?? null,
                'updated_ip'   => Request::ip(),
            ]);

            $this->resetForm();
            $this->showAdminOnlineAppointment = false;
            $this->dispatch('swal:success', [
                'title' => 'Updated!',
                'text' => 'Appointment updated successfully.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function delete($id)
    {
        try {
            OnlineAppointment::findOrFail($id)->delete();
            $this->dispatch('swal:success', [
                'title' => 'Deleted!',
                'text' => 'Appointment deleted successfully.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }
    }

    public function resetForm()
    {
        $this->date_time      = '';
        $this->doctor_id      = '';
        $this->patient_name   = '';
        $this->mobile         = '';
        $this->gender         = '';
        $this->patient_type   = '';
        $this->age            = '';
        $this->message        = '';
        $this->remarks        = '';
        $this->status         = 1;
        $this->appointment_id = null;
        $this->isEditing      = false;
    }
    public function toggleAdminView()
    {

        $this->resetForm();
        if($this->showAdminOnlineAppointment == false) {
            $this->showAdminOnlineAppointment = true;
        }else{
            $this->showAdminOnlineAppointment = false;
        }
    }
    public function prescription($id)
    {
        return redirect()->route('prescription.new_patient', $id);
    }
}
