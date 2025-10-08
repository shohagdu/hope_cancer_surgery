<?php

namespace App\Livewire;

use Livewire\Attributes\On;
use Livewire\Component;
use Illuminate\Support\Str;
use App\Models\PrescriptionMedicineRecord;
use App\Models\OnlineAppointment;
use App\Models\Patient_medicine;
use App\Models\PatientPrescriptionRecord;
use App\Models\PatientMedicineDosage;




class PrescriptionList extends Component
{
    public $prescriptionsMedicine = [];
    public $showModal = false;
    public $showEditModal = false;
    public $searchTerm = '';
    public $medicineSuggestions = [];
    public $selectedMedicineId = null;
    public $id,$prescription_id;
    public $patient = [];

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

            $patient_id =  isset($this->id)? $this->id:NULL;
            $this->patient          =   OnlineAppointment::find($patient_id);
            $prescription           = PatientPrescriptionRecord::where('patient_id',$patient_id)->orderBy('id','DESC')->first();
            $this->prescription_id  =  $prescription->id;
            $prescripiton_infos = !empty($this->prescription_id)
                ? PatientPrescriptionRecord::with('patient_medicine_record.medicine', 'patient_medicine_record.dosages')
                    ->find($this->prescription_id)
                : null;

            $prescriptionsMedicine= !empty($prescripiton_infos->patient_medicine_record)?$prescripiton_infos->patient_medicine_record:null;
            $this->prescriptionsMedicine    = $prescriptionsMedicine->toArray();
            $this->selectedMedicines        = $prescriptionsMedicine->toArray();

        }else{
            $this->id= '';
        }
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
            "medicine" => [
                "id" => 1,
                "name" => $drug['name'],
                "generic" => $drug['generic']??null,
                "strength" => $drug['strength']??null,
                "dosage_id" => $drug['dosage_id']??null,
            ],
            "dosages" => [
                [
                    "dosage_morning" => "1",
                    "dosage_noon" => "0",
                    "dosage_afternoon" => "1",
                    "dosage_night" => "0",
                ]
            ]
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

    public function saveMedicine()
    {
       // dd($this->selectedMedicines);
        $prescription= $this->selectedMedicines;
        $prescriptionInfo=[
            'patient_id' => $this->id,
            'visit_date' => $prescription['visit_date']??date("Y-m-d"),
            'complaints' => $prescription['complaints']??null,
            'on_examination' => $prescription['on_examination']??null,
            'pastHistory' => $prescription['pastHistory']??null,
            'drugHistory' => $prescription['drugHistory']??null,
            'investigation' => $prescription['investigation']??null,
            'diagnosis' => $prescription['diagnosis']??null,
            'treatmentPlan' => $prescription['treatmentPlan']??null,
            'operationNote' => $prescription['operationNote']??null,
            'advice' => $prescription['advice']??null,
            'nextPlan' => $prescription['nextPlan']??null,
            'hospitalizations' => $prescription['hospitalizations']??null,
            'next_visit_date' => $prescription['next_visit_date']??null,
            'created_by' => auth()->id(),
            'updated_by' => auth()->id(),
            'created_ip' => request()->ip(),
            'updated_ip' => request()->ip(),
        ];

        $prescription_record = PatientPrescriptionRecord::updateOrCreate(
            ['id' => $this->prescription_id ?? null],
            $prescriptionInfo
        );

        // Upsert medicines and their dosages
        foreach ($prescription ?? [] as $medicine) {
            $medicineID = rand(1,100);
           $medicineRecord= [
                'patient_prescription_id' => $this->prescription_id,
                'medicine_id' => $medicineID,
                'custom_time_instruction' => $medicine['custom_time_instruction']??null,
                'medicine_serial' => rand(1,100),
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_ip' => request()->ip(),
                'updated_ip' => request()->ip(),
            ];
            Patient_medicine::updateOrCreate(['medicine_id' => $medicineID ?? null,'patient_prescription_id'=>$this->prescription_id],$medicineRecord);
        }
    }
    public function render()
    {
        return view('livewire.prescription');
    }
}
