<?php

namespace App\Livewire;

use Livewire\Component;

class PrescriptionSettings extends Component
{
    public array $pdfSettings = [
        'margin_top'     => 1.0,
        'margin_bottom'  => 1.0,
        'margin_left'    => 1.0,
        'medicine_width' => 69,
        'font_family'    => 'serif',
        'font_size'      => 13,
    ];

    public array $sectionVisibility = [
        'complaints'      => true,
        'onExamination'   => true,
        'pastHistory'     => true,
        'drugHistory'     => true,
        'investigation'   => true,
        'diagnosis'       => true,
        'treatmentPlan'   => true,
        'operationNote'   => true,
        'advice'          => true,
        'nextPlan'        => true,
        'hospitalizations'=> true,
    ];

    public function loadSettings(array $data): void
    {
        if (!empty($data['pdfSettings'])) {
            $this->pdfSettings = array_merge($this->pdfSettings, $data['pdfSettings']);
        }
        if (!empty($data['sectionVisibility'])) {
            $this->sectionVisibility = array_merge($this->sectionVisibility, $data['sectionVisibility']);
        }
    }

    public function save(): void
    {
        $this->dispatch('rx-settings-saved', [
            'pdfSettings'       => $this->pdfSettings,
            'sectionVisibility' => $this->sectionVisibility,
        ]);
        session()->flash('success', 'Settings saved successfully.');
    }

    public function render()
    {
        return view('livewire.prescription-settings')
            ->layout('layouts.app');
    }
}
