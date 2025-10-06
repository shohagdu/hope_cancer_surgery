<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\PrescriptionMedicineRecord;
use App\Models\OnlineAppointment;
use App\Models\Patient_medicine;




class PrescriptionList extends Component
{
    public $prescriptionsMedicine = [];
    public $showModal = false;
    public $showEditModal = false;
    public $searchTerm = '';
    public $medicineSuggestions = [];
    public $selectedMedicineId = null;

    // Form inputs
    public $name, $strength, $generic, $dose, $instruction, $duration;
    public array $complaints = [
        ['label' => 'Fever',   'Note'=>'98 F',  'checked' => true],
        ['label' => 'Headache','Note'=>'Onek',  'checked' => false],
        ['label' => 'Cough',  'Note'=>'Large',   'checked' => true],
    ];

    public $selectedMedicines = [];
    public $commonDrugs = [
        ['name' => 'Azithin', 'type' => 'Tablet', 'strength' => '500 mg'],
        ['name' => 'Napa One', 'type' => 'Tablet', 'strength' => '1000 mg'],
        ['name' => 'Algicon', 'type' => 'Oral Suspension', 'strength' => '(500 mg+100 mg)/5 ml'],
        ['name' => 'Zinc', 'type' => 'Syrup', 'strength' => '4.05 mg/5 ml'],
        ['name' => 'Naafboost', 'type' => 'Syrup', 'strength' => ''],
        ['name' => 'Napa', 'type' => 'Suppository', 'strength' => '500 mg'],
        ['name' => 'Napa Extend', 'type' => 'Tablet (Extended Release)', 'strength' => '665 mg'],
        ['name' => 'Nebilol', 'type' => 'Tablet', 'strength' => '5 mg'],
        ['name' => 'Tabis', 'type' => 'Tablet', 'strength' => '2.5 mg'],
        ['name' => 'Sabitar', 'type' => 'Tablet', 'strength' => '97 mg+103 mg'],
        ['name' => 'Met', 'type' => 'Tablet', 'strength' => '500 mg'],
        ['name' => 'Bexімco', 'type' => 'Tab', 'strength' => '250'],
        ['name' => 'Labecard', 'type' => 'IV Injection or Infusion', 'strength' => '5 mg/ml'],
        ['name' => 'Napa', 'type' => 'Tablet', 'strength' => '500 mg'],
        ['name' => 'Acical-M', 'type' => 'Tablet', 'strength' => ''],
        ['name' => 'Absol', 'type' => 'Syrup', 'strength' => '2 mg/5 ml'],
    ];
    public function mount($id=NULL)
    {
        if(!empty($id)){
            $this->id = $id;
        }else{
            $this->id= '';
        }
//        $this->prescriptionsMedicine = [
//            [
//                "id" => 1,
//                "name" => "Cefotil",
//                "strength" => "500 mg",
//                "generic" => "Cefuroxime Axetil",
//                "dose" => "১ + ০ + ১",
//                "instruction" => "খাবারের পরে",
//                "duration" => "৭ দিন",
//            ],
//            [
//                "id" => 2,
//                "name" => "Docopa",
//                "strength" => "200 mg",
//                "generic" => "Doxophylline",
//                "dose" => "০ + ০ + ১",
//                "instruction" => "খাবারের পরে",
//                "duration" => "১ মাস",
//            ],[
//                "id" => 3,
//                "name" => "Napa One",
//                "strength" => "200 mg",
//                "generic" => "Doxophylline",
//                "dose" => "০ + ০ + ১",
//                "instruction" => "খাবারের পরে",
//                "duration" => "১ মাস",
//            ],[
//                "id" =>4,
//                "name" => "Miyolux",
//                "strength" => "200 mg",
//                "generic" => "Doxophylline",
//                "dose" => "০ + ০ + ১",
//                "instruction" => "খাবারের পরে",
//                "duration" => "১ মাস",
//            ],
//        ];

//        $this->selectedMedicines = [
//            [
//                'id' => 1,
//                'name' => 'Sabitar',
//                'type' => 'Tab',
//                'strength' => '97 mg+103 mg',
//                'generic' => 'Sacubitril + Valsartan',
//                'instructions' => 'খাবারের পরে',
//                'duration' => ''
//            ],
//            [
//                'id' => 2,
//                'name' => 'Napa',
//                'type' => 'Supp',
//                'strength' => '500 mg',
//                'generic' => 'Paracetamol',
//                'instructions' => '১ + ১ + ১ + ০ \n১ কটি জর ১০১°F রা এর বেশি হলে, পায়ু পথে দিবেন',
//                'duration' => '৫ দিন'
//            ],
//            [
//                'id' => 3,
//                'name' => 'Napa Extend',
//                'type' => 'Tab',
//                'strength' => '',
//                'generic' => 'Paracetamol',
//                'instructions' => '১ + ১ + ১ + ০ \nভীর মাথা ব্যাথা হলে খাবেন',
//                'duration' => '৭ দিন'
//            ]
//        ];
    }

    public function updatedSearchTerm()
    {
        $this->selectedMedicineId = null; // reset if user types again
        $this->medicineSuggestions = PrescriptionMedicineRecord::where('name', 'like', '%' . $this->searchTerm . '%')
            ->limit(10)
            ->get(['id', 'name','strength','generic']);
    }

    public function selectMedicine($id)
    {
        $medicine = PrescriptionMedicineRecord::find($id);

        if ($medicine) {
            $this->selectedMedicineId = $medicine->id;
            $this->searchTerm = $medicine->name; // show name in input
            $this->medicineSuggestions = []; // clear dropdown

            // Optional: auto-add to selectedMedicines
            $this->addMedicine([
                'name' => $medicine->name,
                'type' => '', // You can load type if stored
                'strength' => '',
            ]);
        }
        $this->searchTerm = '';
        $this->medicineSuggestions = [];
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

    public function addMedicine($drug)
    {
        $newId = count($this->selectedMedicines) + 1;
        $this->selectedMedicines[] = [
            'id' => $newId,
            'name' => $drug['name'],
            'type' => $drug['type'],
            'strength' => $drug['strength'],
            'generic' => '',
            'instructions' => '',
            'duration' => ''
        ];
    }

    public function removeMedicine($index)
    {
        unset($this->selectedMedicines[$index]);
        $this->selectedMedicines = array_values($this->selectedMedicines);
    }

    public function updateMedicine($index, $field, $value)
    {
        $this->selectedMedicines[$index][$field] = $value;
    }

    public function searchTerm()
    {
        dd($this->searchTerm);
    }

    public function render()
    {
        $patient            = !empty($this->id)? OnlineAppointment::with('medicines')-> find($this->id) :'';
        dd($patient);
        return view('livewire.prescription');
    }
}
