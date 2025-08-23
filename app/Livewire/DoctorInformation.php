<?php

namespace App\Livewire;

use App\Models\Doctors;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;

class DoctorInformation extends Component
{
    use WithPagination, WithFileUploads;

    public $doctorId, $name, $email, $mobile, $positions, $qualifications, $special_training,$doctor_profile, $display_position, $is_active = 1;
    public $picture, $newPicture;
    public $showModal = false;
    public $isEdit = false;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'nullable|email',
        'mobile' => 'required|string|max:20',
        'positions' => 'nullable|string|max:255',
        'qualifications' => 'nullable|string|max:255',
        'special_training' => 'nullable|string|max:255',
        'doctor_profile' => 'nullable|string',
        'display_position' => 'nullable|integer',
        'is_active' => 'boolean',
    ];

    public function render()
    {
        $doctors = Doctors::latest()->paginate(10);
        return view('livewire.doctor-information', compact('doctors'));
    }

    // ---------------- CREATE ----------------
    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $doctor = Doctors::findOrFail($id);
            $this->doctorId = $doctor->id;
            $this->name = $doctor->name;
            $this->email = $doctor->email;
            $this->mobile = $doctor->mobile;
            $this->positions = $doctor->positions;
            $this->qualifications = $doctor->qualifications;
            $this->special_training = $doctor->special_training;
            $this->doctor_profile = $doctor->doctor_profile;
            $this->display_position = $doctor->display_position;
            $this->is_active = $doctor->is_active;
            $this->picture = $doctor->picture;
            $this->isEdit = true;
        }

        $this->showModal = true;
    }

    // ---------------- STORE ----------------
    public function store()
    {
        $this->validate();

        $data = $this->getDoctorData();

        if ($this->newPicture) {
            $data['picture'] = $this->newPicture->store('doctors', 'public');
        }

        Doctors::create($data);

        $this->closeModal();
        $this->dispatch('swal:success', title: 'Saved!', text: 'Doctor created successfully.');
    }

    // ---------------- UPDATE ----------------
    public function update()
    {
        $this->validate();

        $doctor = Doctors::findOrFail($this->doctorId);

        $data = $this->getDoctorData();

        if ($this->newPicture) {
            $data['picture'] = $this->newPicture->store('doctors', 'public');
        }

        $doctor->update($data);

        $this->closeModal();
        $this->dispatch('swal:success', title: 'Updated!', text: 'Doctor updated successfully.');
    }

    // ---------------- DELETE ----------------
    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', title: 'Are you sure?', text: 'This doctor will be deleted!', id: $id);
    }

    public function delete($id)
    {
        $doctor = Doctors::findOrFail($id);
        $doctor->delete(); // Soft delete if model uses SoftDeletes
        $this->dispatch('swal:success', title: 'Deleted!', text: 'Doctor deleted successfully.');
    }

    // ---------------- Helpers ----------------
    private function getDoctorData()
    {
        return [
            'name' => $this->name,
            'email' => $this->email,
            'mobile' => $this->mobile,
            'positions' => $this->positions,
            'qualifications' => $this->qualifications,
            'special_training' => $this->special_training,
            'doctor_profile' => $this->doctor_profile,
            'display_position' => $this->display_position,
            'is_active' => $this->is_active,
        ];
    }

    public function resetForm()
    {
        $this->doctorId = null;
        $this->name = '';
        $this->email = '';
        $this->mobile = '';
        $this->positions = '';
        $this->qualifications = '';
        $this->special_training = '';
        $this->doctor_profile = '';
        $this->display_position = '';
        $this->is_active = 1;
        $this->picture = null;
        $this->newPicture = null;
        $this->isEdit = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }
}
