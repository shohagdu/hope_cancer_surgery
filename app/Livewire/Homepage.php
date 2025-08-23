<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Doctors;
use App\Models\Webpage_content;
use App\Models\OrganizationInfo;

class Homepage extends Component
{
    public function render()
    {
        $doctors                    =   Doctors::where(['is_active'=> 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $whyChooseHighlightItem = Webpage_content::where(['type' => 1, 'is_active' => 1,'is_highlight_item'=> 1])
            ->orderBy('display_position', 'DESC')
            ->first();
        $whyChooseItem = Webpage_content::where(['type' => 1, 'is_active' => 1,'is_highlight_item'=> 0])
            ->orderBy('display_position', 'Asc')
            ->limit(3)
            ->get();

        $aboutUsHighlightItem = Webpage_content::where(['type' => 2, 'is_active' => 1,'is_highlight_item'=> 1])
            ->orderBy('display_position', 'DESC')
            ->first();
        $aboutUsItem = Webpage_content::where(['type' => 2, 'is_active' => 1,'is_highlight_item'=> 0])
            ->orderBy('display_position', 'Asc')
            ->limit(3)
            ->get();
        $service_treatment = Webpage_content::where(['type' => 3, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $service_emergency = Webpage_content::where(['type' => 4, 'is_active' => 1])->orderBy('display_position', 'Asc')
            ->get();
        $faqInfo = Webpage_content::where(['type' => 5, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $testimonial = Webpage_content::where(['type' => 6, 'is_active' => 1])
            ->orderBy('display_position', 'Asc')
            ->get();
        $organizationInfo = OrganizationInfo::orderBy('id', 'DESC')->first();

        return view('livewire.web.homepage',
            [
                'doctors' => $doctors,
                'whyChooseHighlightItem' => $whyChooseHighlightItem,
                'whyChooseItem' => $whyChooseItem,
                'aboutUsHighlightItem' => $aboutUsHighlightItem,
                'aboutUsItem' => $aboutUsItem,
                'service_treatment' => $service_treatment,
                'service_emergency' => $service_emergency,
                'faqInfo' => $faqInfo,
                'testimonial' => $testimonial,
                'organizationInfo' => $organizationInfo,
            ]
        )
            ->layout('layouts.web_app',
                [
                    'title' => 'Homepage :: ' . config('app.name'),
                    'meta_description' => 'Homepage of ' . config('app.name'),
                    'organizationInfo' => $organizationInfo,
                ]);
    }

}
