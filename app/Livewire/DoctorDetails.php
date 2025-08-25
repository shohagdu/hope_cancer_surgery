<?php

namespace App\Livewire;

use App\Models\OrganizationInfo;
use Livewire\Component;
use App\Models\Doctors;
use Illuminate\Support\Str;

class DoctorDetails extends Component
{
    public $doctor;

    public function mount($id, $slug)
    {
        $this->doctor = Doctors::findOrFail($id);

        // Redirect to correct slug if user types wrong one
        if ($slug !== Str::slug($this->doctor->name)) {
            return redirect()->route('doctor.details', [
                'id'   => $this->doctor->id,
                'slug' => Str::slug($this->doctor->name),
            ]);
        }
    }

    public function render()
    {
        $organizationInfo = OrganizationInfo::orderBy('id', 'DESC')->first();
        return view('livewire.doctor-details') ->layout('layouts.web_app',
            [
                'title' => 'Doctor ::  '.$this->doctor->name . config('app.name'),
                'meta_description' => 'Homepage of Hope centre for cancer surgery and research ' . config('app.name'),
                'organizationInfo' => $organizationInfo,
            ]);;
    }
}

