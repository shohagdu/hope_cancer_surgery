<?php

namespace App\Livewire;

use App\Models\Doctors;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Illuminate\Support\Facades\Hash;

class DoctorInformation extends Component
{
    use WithPagination, WithFileUploads;

    // Basic info
    public $doctorId, $name, $email, $mobile, $positions, $qualifications, $special_training, $doctor_profile, $display_position, $is_active = 1;
    public $picture, $newPicture;

    // Login credentials
    public string $loginEmail    = '';
    public string $loginPassword = '';
    public ?int   $linkedUserId  = null;   // existing user linked to this doctor

    // Stats & dynamic fields
    public string $hero_tag          = '';
    public string $stat_experience   = '';
    public string $stat_publications = '';
    public string $stat_patients     = '';
    public string $stat_success_rate = '';
    public string $expertiseText     = '';
    public array  $chambers          = [];

    // Social
    public $facebook, $youtube, $linkedin, $tiktok, $instagram;

    public $showModal = false;
    public $isEdit    = false;

    protected function rules(): array
    {
        return [
            'name'             => 'required|string|max:255',
            'email'            => 'nullable|email',
            'mobile'           => 'required|string|max:20',
            'positions'        => 'nullable|string|max:255',
            'hero_tag'         => 'nullable|string|max:255',
            'qualifications'   => 'nullable|string|max:255',
            'special_training' => 'nullable|string|max:255',
            'doctor_profile'   => 'nullable|string',
            'display_position' => 'nullable|integer',
            'is_active'        => 'boolean',
            'newPicture'       => 'nullable|image|max:2048',
            'facebook'         => 'nullable|url|max:255',
            'youtube'          => 'nullable|url|max:255',
            'linkedin'         => 'nullable|url|max:255',
            'tiktok'           => 'nullable|url|max:255',
            'instagram'        => 'nullable|url|max:255',
            'stat_experience'  => 'nullable|string|max:50',
            'stat_publications'=> 'nullable|string|max:50',
            'stat_patients'    => 'nullable|string|max:50',
            'stat_success_rate'=> 'nullable|string|max:50',
            'loginEmail'       => 'required|email',
            'loginPassword'    => $this->isEdit ? 'nullable|min:6' : 'nullable|min:6',
        ];
    }

    protected array $validationAttributes = [
        'loginEmail'    => 'login email',
        'loginPassword' => 'login password',
    ];

    public function render()
    {
        $doctors = Doctors::with('user')->latest()->paginate(10);
        return view('livewire.doctor-information', compact('doctors'));
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $doctor = Doctors::with('user')->findOrFail($id);
            $this->doctorId         = $doctor->id;
            $this->name             = $doctor->name;
            $this->email            = $doctor->email;
            $this->mobile           = $doctor->mobile;
            $this->positions        = $doctor->positions;
            $this->hero_tag         = $doctor->hero_tag ?? '';
            $this->qualifications   = $doctor->qualifications;
            $this->special_training = $doctor->special_training;
            $this->doctor_profile   = $doctor->doctor_profile;
            $this->display_position = $doctor->display_position;
            $this->is_active        = $doctor->is_active;
            $this->picture          = $doctor->picture;
            $this->facebook         = $doctor->facebook;
            $this->youtube          = $doctor->youtube;
            $this->linkedin         = $doctor->linkedin;
            $this->tiktok           = $doctor->tiktok;
            $this->instagram        = $doctor->instagram;
            $this->stat_experience   = $doctor->stat_experience ?? '';
            $this->stat_publications = $doctor->stat_publications ?? '';
            $this->stat_patients     = $doctor->stat_patients ?? '';
            $this->stat_success_rate = $doctor->stat_success_rate ?? '';
            $this->expertiseText    = implode("\n", $doctor->expertise ?? []);
            $this->chambers         = $doctor->chambers ?? [];

            // Linked user
            if ($doctor->user) {
                $this->linkedUserId = $doctor->user->id;
                $this->loginEmail   = $doctor->user->email;
            }

            $this->isEdit = true;
        }

        $this->showModal = true;
        $this->dispatch('init-profile-editor', content: $this->doctor_profile ?? '');
        $this->dispatch('init-chambers', chambers: $this->chambers);
    }

    public function store()
    {
        $this->validate();

        $user = $this->resolveUser($this->loginEmail, $this->loginPassword);

        $data = $this->getDoctorData();
        $data['user_id'] = $user->id;

        if ($this->newPicture) {
            $data['picture'] = $this->newPicture->store('doctors', 'public');
        }

        Doctors::create($data);

        $this->closeModal();
        $message = $user->wasRecentlyCreated ? 'Doctor and new login account created.' : 'Doctor created and linked to existing account.';
        $this->dispatch('swal:success', title: 'Saved!', text: $message);
    }

    public function update()
    {
        $this->validate();

        $doctor = Doctors::findOrFail($this->doctorId);
        $data   = $this->getDoctorData();

        if ($this->newPicture) {
            $data['picture'] = $this->newPicture->store('doctors', 'public');
        }

        if ($this->linkedUserId) {
            // Already linked — just update email/name/password
            $userUpdate = ['email' => $this->loginEmail, 'name' => $this->name];
            if (!empty($this->loginPassword)) {
                $userUpdate['password'] = Hash::make($this->loginPassword);
            }
            User::where('id', $this->linkedUserId)->update($userUpdate);
        } else {
            // Not linked yet — find existing user by email or create new
            $user = $this->resolveUser($this->loginEmail, $this->loginPassword);
            $data['user_id'] = $user->id;
        }

        $doctor->update($data);

        $this->closeModal();
        $this->dispatch('swal:success', title: 'Updated!', text: 'Doctor updated successfully.');
    }

    /**
     * Find user by email (and link them) or create a brand-new one.
     * If the user already exists, update their role to doctor.
     * If they don't exist, create with the given password.
     */
    private function resolveUser(string $email, ?string $password): User
    {
        $existing = User::where('email', $email)->first();

        if ($existing) {
            $updateData = ['role' => 'doctor', 'name' => $this->name];
            if (!empty($password)) {
                $updateData['password'] = Hash::make($password);
            }
            $existing->update($updateData);
            return $existing;
        }

        return User::create([
            'name'              => $this->name,
            'email'             => $email,
            'password'          => Hash::make($password ?? \Illuminate\Support\Str::random(16)),
            'role'              => 'doctor',
            'email_verified_at' => now(),
        ]);
    }

    public function confirmDelete($id)
    {
        $this->dispatch('swal:confirm', title: 'Are you sure?', text: 'This doctor will be deleted!', id: $id);
    }

    public function delete($id)
    {
        Doctors::findOrFail($id)->delete();
        $this->dispatch('swal:success', title: 'Deleted!', text: 'Doctor deleted successfully.');
    }

    public function setChambers(array $chambers): void
    {
        $this->chambers = $chambers;
    }

    private function getDoctorData(): array
    {
        $expertise = array_values(array_filter(
            array_map('trim', explode("\n", $this->expertiseText))
        ));

        return [
            'name'             => $this->name,
            'email'            => $this->email,
            'mobile'           => $this->mobile,
            'positions'        => $this->positions,
            'hero_tag'         => $this->hero_tag,
            'qualifications'   => $this->qualifications,
            'special_training' => $this->special_training,
            'doctor_profile'   => $this->doctor_profile,
            'display_position' => $this->display_position,
            'is_active'        => $this->is_active,
            'facebook'         => $this->facebook,
            'youtube'          => $this->youtube,
            'linkedin'         => $this->linkedin,
            'tiktok'           => $this->tiktok,
            'instagram'        => $this->instagram,
            'stat_experience'  => $this->stat_experience,
            'stat_publications'=> $this->stat_publications,
            'stat_patients'    => $this->stat_patients,
            'stat_success_rate'=> $this->stat_success_rate,
            'expertise'        => $expertise,
            'chambers'         => $this->chambers,
        ];
    }

    public function resetForm()
    {
        $this->doctorId          = null;
        $this->name              = '';
        $this->email             = '';
        $this->mobile            = '';
        $this->positions         = '';
        $this->hero_tag          = '';
        $this->qualifications    = '';
        $this->special_training  = '';
        $this->doctor_profile    = '';
        $this->display_position  = '';
        $this->is_active         = 1;
        $this->picture           = null;
        $this->newPicture        = null;
        $this->facebook          = '';
        $this->youtube           = '';
        $this->linkedin          = '';
        $this->tiktok            = '';
        $this->instagram         = '';
        $this->stat_experience   = '';
        $this->stat_publications = '';
        $this->stat_patients     = '';
        $this->stat_success_rate = '';
        $this->expertiseText     = '';
        $this->chambers          = [];
        $this->loginEmail        = '';
        $this->loginPassword     = '';
        $this->linkedUserId      = null;
        $this->isEdit            = false;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->resetForm();
    }
}
