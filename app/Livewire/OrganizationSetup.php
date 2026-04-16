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
    public $address, $google_map_embed, $google_map_link, $mobile, $email, $fb, $twitter, $linkedin, $tiktok, $youtube;
    public $testimonials_heading, $testimonials_subtext;
    public $testimonials = [];   // array of {name, role, picture_url, rating, message}
    public $isShowModal = false;

    // Temporary upload slot for a single testimonial photo
    public $testimonial_photo_upload;

    public $search = '';
    public $perPage = 10;

    protected $rules = [
        'name'                   => 'required|string|max:255',
        'slug'                   => 'required|string|max:255|unique:company_infos,slug',
        'logo_local'                  => 'nullable|image|max:2048',
        'testimonial_photo_upload'    => 'nullable|image|max:2048',
        'address'                => 'nullable|string|max:255',
        'google_map_embed'       => 'nullable|string',
        'google_map_link'        => 'nullable|url|max:500',
        'mobile'                 => 'nullable|string|max:20',
        'email'                  => 'nullable|email|max:150',
        'fb'                     => 'nullable|url',
        'twitter'                => 'nullable|url',
        'linkedin'               => 'nullable|url',
        'tiktok'                 => 'nullable|url',
        'youtube'                => 'nullable|url',
        'testimonials_heading'   => 'nullable|string|max:255',
        'testimonials_subtext'   => 'nullable|string',
        'testimonials'           => 'nullable|array',
        'testimonials.*.name'    => 'required|string|max:150',
        'testimonials.*.role'    => 'nullable|string|max:150',
        'testimonials.*.picture_url' => 'nullable|string|max:500',
        'testimonials.*.rating'  => 'nullable|integer|min:1|max:5',
        'testimonials.*.message' => 'nullable|string|max:1000',
    ];

    public function mount(): void
    {
        $this->isShowModal = false;
        $this->testimonials = [];
    }

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
            $this->company_id           = $company->id;
            $this->name                 = $company->name;
            $this->slug                 = $company->slug;
            $this->logo                 = $company->logo;
            $this->address              = $company->address;
            $this->google_map_embed     = $company->google_map_embed;
            $this->google_map_link      = $company->google_map_link;
            $this->mobile               = $company->mobile;
            $this->email                = $company->email;
            $this->fb                   = $company->fb;
            $this->twitter              = $company->twitter;
            $this->linkedin             = $company->linkedin;
            $this->tiktok               = $company->tiktok;
            $this->youtube              = $company->youtube;
            $this->testimonials_heading = $company->testimonials_heading;
            $this->testimonials_subtext = $company->testimonials_subtext;
            $this->testimonials         = $company->testimonials ?? [];
        }

        $this->isShowModal = true;
    }

    /** Called from Alpine before save to sync testimonials array */
    public function setTestimonials(array $items): void
    {
        $this->testimonials = $items;
    }

    /**
     * Upload a testimonial photo for a specific row index.
     * Dispatches 'testimonial-photo-uploaded' back to Alpine with the stored path.
     */
    public function uploadTestimonialPhoto(int $idx): void
    {
        $this->validateOnly('testimonial_photo_upload', [
            'testimonial_photo_upload' => 'required|image|max:2048',
        ]);

        $path = $this->testimonial_photo_upload->store('testimonial_photos', 'public');

        $this->dispatch('testimonial-photo-uploaded', idx: $idx, url: $path);
        $this->testimonial_photo_upload = null;
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

        // Sanitise testimonials
        $testimonials = collect($this->testimonials)
            ->filter(fn($t) => !empty($t['name']))
            ->map(fn($t) => [
                'name'        => strip_tags($t['name'] ?? ''),
                'role'        => strip_tags($t['role'] ?? ''),
                'picture_url' => $t['picture_url'] ?? '',
                'rating'      => (int) ($t['rating'] ?? 5),
                'message'     => strip_tags($t['message'] ?? ''),
            ])
            ->values()
            ->toArray();

        $data = [
            'name'                   => $this->name,
            'slug'                   => $this->slug,
            'logo'                   => $path,
            'address'                => $this->address,
            'google_map_embed'       => $this->google_map_embed,
            'google_map_link'        => $this->google_map_link,
            'mobile'                 => $this->mobile,
            'email'                  => $this->email,
            'fb'                     => $this->fb,
            'twitter'                => $this->twitter,
            'linkedin'               => $this->linkedin,
            'tiktok'                 => $this->tiktok,
            'youtube'                => $this->youtube,
            'testimonials'           => $testimonials ?: null,
            'testimonials_heading'   => $this->testimonials_heading,
            'testimonials_subtext'   => $this->testimonials_subtext,
        ];

        if ($this->company_id) {
            OrganizationInfo::findOrFail($this->company_id)->update($data);
            $this->dispatch('swal:success', title: 'Updated!', text: 'Company info updated successfully');
        } else {
            OrganizationInfo::create($data);
            $this->dispatch('swal:success', title: 'Created!', text: 'Company info created successfully');
        }

        $this->resetForm();
        $this->isShowModal = false;
    }

    public function delete($id)
    {
        OrganizationInfo::findOrFail($id)->delete();
        $this->dispatch('swal:success', title: 'Deleted!', text: 'Company info deleted successfully');
    }

    public function resetForm()
    {
        $this->company_id = null;
        $this->name = $this->slug = $this->logo = $this->logo_local = null;
        $this->address = $this->google_map_embed = $this->google_map_link = null;
        $this->mobile = $this->email = null;
        $this->fb = $this->twitter = $this->linkedin = $this->tiktok = $this->youtube = null;
        $this->testimonials_heading = $this->testimonials_subtext = null;
        $this->testimonials = [];
        $this->testimonial_photo_upload = null;
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
