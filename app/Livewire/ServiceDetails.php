<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webpage_content;
use App\Models\OrganizationInfo;
use Illuminate\Support\Str;

class ServiceDetails extends Component
{
    public $service;
    public $relatedItems;

    public function mount(int $id, string $slug)
    {
        $this->service = Webpage_content::findOrFail($id);

        // Redirect if slug is wrong
        if ($slug !== Str::slug($this->service->title)) {
            return redirect()->route('service.details', [
                'id'   => $this->service->id,
                'slug' => Str::slug($this->service->title),
            ]);
        }

        // Related items from same type, excluding current
        $this->relatedItems = Webpage_content::where('type', $this->service->type)
            ->where('id', '!=', $this->service->id)
            ->where('is_active', 1)
            ->orderBy('display_position')
            ->limit(6)
            ->get();
    }

    public function render()
    {
        $organizationInfo = OrganizationInfo::orderBy('id', 'DESC')->first();

        $typeLabel = match((int)$this->service->type) {
            3 => 'Cancer Treatment & Consultation',
            4 => 'Emergency Services',
            default => 'Service',
        };

        return view('livewire.service-details', compact('organizationInfo', 'typeLabel'))
            ->layout('layouts.web_app', [
                'title'            => $this->service->title . ' :: ' . config('app.name'),
                'meta_description' => $this->service->short_description ?? $this->service->title,
                'organizationInfo' => $organizationInfo,
            ]);
    }
}
