<?php
namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use App\Models\OrganizationInfo;

class OrganizationSetup extends Component
{
    use WithPagination, WithFileUploads;

    protected $paginationTheme = 'tailwind';

    public $company_id;
    public $name, $slug, $logo, $logo_local;
    public $address, $mobile, $email, $fb, $twitter, $linkedin, $tiktok, $youtube;
    public $isShowModal = false;

    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'name' => 'required|string|max:255',
        'slug' => 'required|string|max:255|unique:company_infos,slug',
        'logo_local' => 'nullable|image|max:2048',
        'address' => 'nullable|string|max:255',
        'mobile' => 'nullable|string|max:20',
        'email' => 'nullable|email|max:150',
        'fb' => 'nullable|url',
        'twitter' => 'nullable|url',
        'linkedin' => 'nullable|url',
        'tiktok' => 'nullable|url',
        'youtube' => 'nullable|url',
    ];

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function openModal($id = null)
    {
        $this->resetValidation();
        $this->resetForm();

        if ($id) {
            $company = OrganizationInfo::findOrFail($id);
            $this->company_id = $company->id;
            $this->name = $company->name;
            $this->slug = $company->slug;
            $this->logo = $company->logo;
            $this->address = $company->address;
            $this->mobile = $company->mobile;
            $this->email = $company->email;
            $this->fb = $company->fb;
            $this->twitter = $company->twitter;
            $this->linkedin = $company->linkedin;
            $this->tiktok = $company->tiktok;
            $this->youtube = $company->youtube;
        }

        $this->isShowModal = true;
    }

    public function save()
    {
        $rules = $this->rules;

        // Ignore unique rule if updating
        if ($this->company_id) {
            $rules['slug'] = 'required|string|max:255|unique:company_infos,slug,' . $this->company_id;
        }

        $this->validate($rules);

        $path = $this->logo ?? null;
        if ($this->logo_local) {
            $path = $this->logo_local->store('company_logos', 'public');
        }

        $data = [
            'name' => $this->name,
            'slug' => $this->slug,
            'logo' => $path,
            'address' => $this->address,
            'mobile' => $this->mobile,
            'email' => $this->email,
            'fb' => $this->fb,
            'twitter' => $this->twitter,
            'linkedin' => $this->linkedin,
            'tiktok' => $this->tiktok,
            'youtube' => $this->youtube,
        ];

        if ($this->company_id) {
            OrganizationInfo::findOrFail($this->company_id)->update($data);
            $this->dispatch('swal:success', ['title' => 'Updated!', 'text' => 'Company info updated successfully']);
        } else {
            OrganizationInfo::create($data);
            $this->dispatch('swal:success', ['title' => 'Created!', 'text' => 'Company info created successfully']);
        }

        $this->resetForm();
        $this->isShowModal = false;
    }

    public function delete($id)
    {
        OrganizationInfo::findOrFail($id)->delete();
        $this->dispatch('swal:success', ['title' => 'Deleted!', 'text' => 'Company info deleted successfully']);
    }

    public function resetForm()
    {
        $this->company_id = null;
        $this->name = $this->slug = $this->logo = $this->logo_local = null;
        $this->address = $this->mobile = $this->email = null;
        $this->fb = $this->twitter = $this->linkedin = $this->tiktok = $this->youtube = null;
    }

    public function render()
    {
        $companies = OrganizationInfo::query()
            ->when($this->search, fn($q) =>
            $q->where('name', 'like', "%{$this->search}%")
                ->orWhere('slug', 'like', "%{$this->search}%")
            )
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.organization-setup', [
            'companies' => $companies,
        ]);
    }
}
