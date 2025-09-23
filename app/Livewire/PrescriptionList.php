<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Str;

class PrescriptionList extends Component
{
    public $prescriptionsMedicine = [];
    public $showModal = false;
    public $showEditModal = false;

    // Form inputs
    public $name, $strength, $generic, $dose, $instruction, $duration;
    public array $complaints = [
        ['label' => 'Fever',   'Note'=>'98 F',  'checked' => true],
        ['label' => 'Headache','Note'=>'Onek',  'checked' => false],
        ['label' => 'Cough',  'Note'=>'Large',   'checked' => true],
    ];
    public function mount()
    {
        $this->prescriptionsMedicine = [
            [
                "id" => 1,
                "name" => "Cefotil",
                "strength" => "500 mg",
                "generic" => "Cefuroxime Axetil",
                "dose" => "১ + ০ + ১",
                "instruction" => "খাবারের পরে",
                "duration" => "৭ দিন",
            ],
            [
                "id" => 2,
                "name" => "Docopa",
                "strength" => "200 mg",
                "generic" => "Doxophylline",
                "dose" => "০ + ০ + ১",
                "instruction" => "খাবারের পরে",
                "duration" => "১ মাস",
            ],[
                "id" => 3,
                "name" => "Napa One",
                "strength" => "200 mg",
                "generic" => "Doxophylline",
                "dose" => "০ + ০ + ১",
                "instruction" => "খাবারের পরে",
                "duration" => "১ মাস",
            ],[
                "id" =>4,
                "name" => "Miyolux",
                "strength" => "200 mg",
                "generic" => "Doxophylline",
                "dose" => "০ + ০ + ১",
                "instruction" => "খাবারের পরে",
                "duration" => "১ মাস",
            ],
        ];
    }

    public function addPrescription()
    {
        $this->validate([
            'name' => 'required|string',
            'strength' => 'nullable|string',
            'generic' => 'nullable|string',
            'dose' => 'required|string',
            'instruction' => 'required|string',
            'duration' => 'required|string',
        ]);

        $this->prescriptionsMedicine[] = [
            "id" => Str::uuid()->toString(),
            "name" => $this->name,
            "strength" => $this->strength,
            "generic" => $this->generic,
            "dose" => $this->dose,
            "instruction" => $this->instruction,
            "duration" => $this->duration,
        ];

        $this->reset(['name', 'strength', 'generic', 'dose', 'instruction', 'duration', 'showModal']);
    }

    public function remove($id)
    {
        $this->prescriptionsMedicine = collect($this->prescriptionsMedicine)
            ->reject(fn ($med) => $med['id'] == $id)
            ->values()
            ->toArray();
    }

    public function updateOrder($orderedItems)
    {
        $this->prescriptionsMedicine = collect($orderedItems)
            ->map(fn ($item, $index) => array_merge(
                collect($this->prescriptionsMedicine)->firstWhere('id', $item['value']),
                ['order' => $index + 1] // Automatically update order number
            ))
            ->filter()
            ->values()
            ->toArray();
    }
    public function toggle(int $index): void
    {
        $this->complaints[$index]['checked'] = ! $this->complaints[$index]['checked'];
    }

    public function render()
    {
        return view('livewire.prescription');
    }
}
