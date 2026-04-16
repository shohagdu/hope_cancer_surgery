<?php

namespace App\Livewire;

use App\Models\Doctors;
use Livewire\Component;
use Livewire\WithFileUploads;

class DoctorProfile extends Component
{
    use WithFileUploads;

    public ?Doctors $doctor = null;

    // Read-only basic info (only admin can edit these)
    public string $name        = '';
    public string $email       = '';
    public string $mobile      = '';
    public ?string $picture    = null;

    // Doctor-editable fields
    public string $hero_tag         = '';
    public string $qualifications   = '';
    public string $special_training = '';
    public string $positions        = '';
    public string $doctor_profile   = '';
    public string $stat_experience  = '';
    public string $stat_publications = '';
    public string $stat_patients    = '';
    public string $stat_success_rate = '';
    public string $expertiseText    = '';
    public array  $chambers         = [];
    public string $facebook         = '';
    public string $youtube          = '';
    public string $linkedin         = '';
    public string $tiktok           = '';
    public string $instagram        = '';

    protected array $rules = [
        'hero_tag'          => 'nullable|string|max:255',
        'qualifications'    => 'nullable|string|max:255',
        'special_training'  => 'nullable|string|max:255',
        'positions'         => 'nullable|string|max:1000',
        'doctor_profile'    => 'nullable|string',
        'stat_experience'   => 'nullable|string|max:50',
        'stat_publications' => 'nullable|string|max:50',
        'stat_patients'     => 'nullable|string|max:50',
        'stat_success_rate' => 'nullable|string|max:50',
        'facebook'          => 'nullable|url|max:255',
        'youtube'           => 'nullable|url|max:255',
        'linkedin'          => 'nullable|url|max:255',
        'tiktok'            => 'nullable|url|max:255',
        'instagram'         => 'nullable|url|max:255',
    ];

    public function mount(): void
    {
        $this->doctor = Doctors::where('user_id', auth()->id())->first();

        if ($this->doctor) {
            $this->name             = $this->doctor->name ?? '';
            $this->email            = $this->doctor->email ?? '';
            $this->mobile           = $this->doctor->mobile ?? '';
            $this->picture          = $this->doctor->picture;
            $this->hero_tag         = $this->doctor->hero_tag ?? '';
            $this->qualifications   = $this->doctor->qualifications ?? '';
            $this->special_training = $this->doctor->special_training ?? '';
            $this->positions        = $this->doctor->positions ?? '';
            $this->doctor_profile   = $this->doctor->doctor_profile ?? '';
            $this->stat_experience  = $this->doctor->stat_experience ?? '';
            $this->stat_publications = $this->doctor->stat_publications ?? '';
            $this->stat_patients    = $this->doctor->stat_patients ?? '';
            $this->stat_success_rate = $this->doctor->stat_success_rate ?? '';
            $this->expertiseText    = implode("\n", $this->doctor->expertise ?? []);
            $this->chambers         = $this->doctor->chambers ?? [];
            $this->facebook         = $this->doctor->facebook ?? '';
            $this->youtube          = $this->doctor->youtube ?? '';
            $this->linkedin         = $this->doctor->linkedin ?? '';
            $this->tiktok           = $this->doctor->tiktok ?? '';
            $this->instagram        = $this->doctor->instagram ?? '';
        }
    }

    public function setChambers(array $chambers): void
    {
        $this->chambers = $chambers;
    }

    public function save(): void
    {
        if (!$this->doctor) {
            session()->flash('error', 'No doctor profile linked to your account. Please contact admin.');
            return;
        }

        $this->validate();

        $expertise = array_values(array_filter(
            array_map('trim', explode("\n", $this->expertiseText))
        ));

        $this->doctor->update([
            'hero_tag'          => $this->hero_tag,
            'qualifications'    => $this->qualifications,
            'special_training'  => $this->special_training,
            'positions'         => $this->positions,
            'doctor_profile'    => $this->doctor_profile,
            'stat_experience'   => $this->stat_experience,
            'stat_publications' => $this->stat_publications,
            'stat_patients'     => $this->stat_patients,
            'stat_success_rate' => $this->stat_success_rate,
            'expertise'         => $expertise,
            'chambers'          => $this->chambers,
            'facebook'          => $this->facebook,
            'youtube'           => $this->youtube,
            'linkedin'          => $this->linkedin,
            'tiktok'            => $this->tiktok,
            'instagram'         => $this->instagram,
        ]);

        $this->dispatch('swal:success', title: 'Saved!', text: 'Your profile has been updated.');
        $this->dispatch('init-profile-editor', content: $this->doctor_profile ?? '');
    }

    public function render()
    {
        return view('livewire.doctor-profile')
            ->layout('layouts.app');
    }
}
