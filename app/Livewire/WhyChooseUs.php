<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Webpage_content;
use App\Models\OrganizationInfo;

class WhyChooseUs extends Component
{
    public function render()
    {
        $highlight        = Webpage_content::where(['type' => 1, 'is_active' => 1, 'is_highlight_item' => 1])
            ->orderBy('display_position', 'DESC')->first();

        $items            = Webpage_content::where(['type' => 1, 'is_active' => 1, 'is_highlight_item' => 0])
            ->orderBy('display_position', 'ASC')->get();

        $organizationInfo = OrganizationInfo::orderBy('id', 'DESC')->first();

        return view('livewire.why-choose-us', compact('highlight', 'items', 'organizationInfo'))
            ->layout('layouts.web_app', [
                'title'            => 'Why Choose Us :: ' . config('app.name'),
                'meta_description' => 'Why Choose Hope Centre for Cancer Surgery and Research',
                'organizationInfo' => $organizationInfo,
            ]);
    }
}
