<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Doctors;

class DoctorInformation extends Component
{
    use WithFileUploads;

    public $doctor_id;
    public $name, $picture, $qualifications, $special_training, $positions;
    public $mobile, $email;
    public $facebook, $twitter, $instagram, $linkedin, $tiktok, $youtube;
    public $display_position = 0, $is_active = 1;

    protected $rules = [
        'name' => 'required|string|max:255',
        'picture' => 'nullable|image|max:2048',
        'qualifications' => 'nullable|string|max:255',
        'special_training' => 'nullable|string|max:255',
        'positions' => 'nullable|string|max:255',
        'mobile' => 'nullable|string|max:30',
        'email' => 'nullable|email|max:150',
        'facebook' => 'nullable|url',
        'twitter' => 'nullable|url',
        'instagram' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'tiktok' => 'nullable|url',
        'youtube' => 'nullable|url',
        'display_position' => 'integer|min:0',
        'is_active' => 'boolean',
    ];

    public function save()
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'qualifications' => $this->qualifications,
            'special_training' => $this->special_training,
            'positions' => $this->positions,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'facebook' => $this->facebook,
            'twitter' => $this->twitter,
            'instagram' => $this->instagram,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
            'display_position' => $this->display_position,
            'is_active' => $this->is_active,
        ];

        if ($this->picture) {
            $data['picture'] = $this->picture->store('doctors', 'public');
        }

        if ($this->doctor_id) {
            Doctors::findOrFail($this->doctor_id)->update($data);
            $this->dispatch('swal:success', ['title' => 'Updated!', 'text' => 'Doctor updated successfully.']);
        } else {
            Doctors::create($data);
            $this->dispatch('swal:success', ['title' => 'Created!', 'text' => 'Doctor created successfully.']);
        }

        $this->reset();
    }

    public function render()
    {
        return view('livewire.doctor-information');
    }
}
