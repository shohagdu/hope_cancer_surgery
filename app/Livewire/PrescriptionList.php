<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
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


    public $currentMedicineIndex = null;

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
                'id' => $medicine->id,
                'name' => $medicine->name,
                'type' => $medicine->dosage_id, // You can load type if stored
                'strength' => $medicine->strength,
                'generic' => $medicine->generic,
            ]);
        }
        $this->searchTerm = '';
        $this->medicineSuggestions = [];
    }


    public function remove($id)
    {
        Patient_medicine::where('id', $id)->delete();
        PatientMedicineDosage::where('patient_medicine_id', $id)->delete();

        $this->prescriptionsMedicine = collect($this->prescriptionsMedicine)
            ->reject(fn ($med) => $med['id'] == $id)
            ->values()
            ->toArray();
        $this->prescriptionsMedicine = collect($this->selectedMedicines)
            ->reject(fn ($med) => $med['id'] == $id)
            ->values()
            ->toArray();



    }

    public function updateOrder($orderedItems)
    {

        $this->prescriptionsMedicine = collect($orderedItems)
            ->map(fn ($item, $index) => array_merge(
                collect($this->prescriptionsMedicine)->firstWhere('id', $item['value']) ?? [],
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
            'serial_number' => $newId,
            'id' => $newId,
            "medicine" => [
                "id" => $drug['id'],
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

//    public function updateMedicine($index, $field, $value)
//    {
//        $this->selectedMedicines[$index][$field] = $value;
//    }

    public function searchTerm()
    {
        dd($this->searchTerm);
    }

    public function saveMedicine()
    {
        $prescription= $this->selectedMedicines;
        try {
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

            //  dd($prescription);
            // Upsert medicines and their dosages
            foreach ($prescription ?? [] as $medicine) {
                $medicineID = $medicine['medicine']['id'] ?? null;

                // Base record data for both create and update
                $medicineRecord = [
                    'patient_prescription_id' => $this->prescription_id,
                    'medicine_id' => $medicineID,
                    'custom_time_instruction' => $medicine['custom_time_instruction'] ?? null,
                    'medicine_serial' => $medicine['serial_number'] ?? null,
                    'created_by' => auth()->id(), // Set on creation
                    'created_ip' => request()->ip(), // Set on creation
                    // updated_by and updated_ip will be set based on the operation
                ];

                // Attributes to uniquely identify the record
                $keyAttributes = [
                    'medicine_id' => $medicineID,
                    'patient_prescription_id' => $this->prescription_id
                ];

                // Attempt to update or create
                $patientMedicine = Patient_medicine::updateOrCreate($keyAttributes, $medicineRecord);

                if (!$patientMedicine->wasRecentlyCreated) {
                    // Record was UPDATED
                    $patientMedicine->updated_by = auth()->id();
                    $patientMedicine->updated_ip = request()->ip();
                    $patientMedicine->save(); // Save the changes
                } else {
                    $patientMedicine->updated_by = null;
                    $patientMedicine->updated_ip = null;
                    $patientMedicine->save();
                }


                $patientMedicineId = $patientMedicine->id;

                $dosages = $medicine['dosages'] ?? [];

                foreach ($dosages as $dosage) {
                    $existing = PatientMedicineDosage::where('patient_medicine_id', $patientMedicineId)
//                    ->where('dosage_time', $dosage['dosage_time'] ?? null)
                        ->first();

                    if ($existing) {
                        // Update existing record
                        $existing->update([
                            'dosage_morning' => $dosage['dosage_morning'] ?? null,
                            'dosage_noon' => $dosage['dosage_noon'] ?? null,
                            'dosage_afternoon' => $dosage['dosage_afternoon'] ?? null,
                            'dosage_night' => $dosage['dosage_night'] ?? null,

                            'drug_taking_quantity_unit' => $dosage['drug_taking_quantity_unit'] ?? null,
                            'meal_time_select' => $dosage['meal_time_select'] ?? null,
                            'duration' => $dosage['duration'] ?? null,
                            'duration_unit_check' => $dosage['duration_unit_check'] ?? null,

                            'updated_by' => auth()->id(),
                            'updated_ip' => request()->ip(),
                            'updated_at' => now(),
                        ]);
                    } else {
                        // Create new record
                        PatientMedicineDosage::create([
                            'patient_medicine_id' => $patientMedicineId,
//                        'dosage_time' => $dosage['dosage_time'] ?? null,
                            'dosage_morning' => $dosage['dosage_morning'] ?? null,
                            'dosage_noon' => $dosage['dosage_noon'] ?? null,
                            'dosage_afternoon' => $dosage['dosage_afternoon'] ?? null,
                            'dosage_night' => $dosage['dosage_night'] ?? null,

                            'drug_taking_quantity_unit' => $dosage['drug_taking_quantity_unit'] ?? null,
                            'meal_time_select' => $dosage['meal_time_select'] ?? null,
                            'duration' => $dosage['duration'] ?? null,
                            'duration_unit_check' => $dosage['duration_unit_check'] ?? null,

                            'created_by' => auth()->id(),
                            'created_ip' => request()->ip(),
                            'created_at' => now(),
                        ]);
                    }
                }
            }

            $this->dispatch('swal:success', [
                'title' => 'Updated!',
                'text' => 'Appointment updated successfully.',
            ]);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', [
                'title' => 'Error!',
                'text' => $e->getMessage(),
            ]);
        }

    }

    public $dosage_morning = false;
    public $dosage_noon = false;
    public $dosage_before_sleep = false;
    public $dosage_night = false;
    public $medicineDosage_morning = '',$medicineDosage_noon,$medicineDosage_night,$medicineDosage_before_sleep;

    public function openEditModal($index)
    {
        $this->currentMedicineIndex = $index;
        $medicine = $this->prescriptionsMedicine[$index] ?? null;
        $dosage = $medicine['dosages'][0] ?? [];
        /*
        array:17 [▼ // app/Livewire/PrescriptionList.php:303
          "id" => 1
          "patient_medicine_id" => 1
          "dosage_morning" => "1"
          "dosage_noon" => "0"
          "dosage_afternoon" => "1"
          "dosage_night" => "0"
          "drug_taking_quantity_unit" => null
          "meal_time_select" => null
          "duration" => null
          "duration_unit_check" => null
          "is_active" => 1
          "created_by" => null
          "created_ip" => null
          "updated_by" => null
          "updated_ip" => null
          "created_at" => "2025-10-09T08:15:53.000000Z"
          "updated_at" => "2025-10-09T08:15:53.000000Z"
        ]
        */
        $dosageKeys = [
            'morning' => 'dosage_morning',
            'noon' => 'dosage_noon',
            'afternoon' => 'dosage_afternoon',
            'night' => 'dosage_night',
        ];

        foreach ($dosageKeys as $propSuffix => $arrayKey) {
            $property = "medicineDosage_".$propSuffix;
            $this->$property = $dosage[$arrayKey] ?? null;
            $this->$arrayKey = $dosage[$arrayKey]>0?true:null;
        }
        $this->showEditModal = true;
    }


    public function prescriptionMedicineSave()
    {
        if ($this->currentMedicineIndex === null) {
            return;
        }

        // Get the current medicine data
        $medicine = $this->prescriptionsMedicine[$this->currentMedicineIndex];


        // Prepare dosage data
        $dosageData = [
            'dosage_morning'    =>  $this->medicineDosage_morning ?? 0,
            'dosage_noon'       =>$this->medicineDosage_noon ?? 0 ,
            'dosage_afternoon'  => $this->medicineDosage_before_sleep ?? 0,
            'dosage_night'      => $this->medicineDosage_night ?? 0,
        ];


        // Prepare the full medicine data
        if (isset($medicine['dosages'][0])) {
            // Update existing dosage
            $medicine['dosages'][0] = array_merge($medicine['dosages'][0], $dosageData);
        } else {
            // Create new dosage entry if it doesn't exist
            $medicine['dosages'][0] = $dosageData;
        }

       // dd($medicine);
        // Update the prescriptionsMedicine array
       // $this->prescriptionsMedicine[$this->currentMedicineIndex] = $medicine;


        PatientMedicineDosage::updateOrCreate(
            [
                'id' => $medicine['dosages'][0]->id ?? null,
            ],$medicine['dosages'][0]);

        // Close modal and reset
        $this->showEditModal = false;
        $this->currentMedicineIndex = null;

        // Success message
        session()->flash('message', 'Medicine updated successfully!');
    }

    public function render()
    {
        return view('livewire.prescription');
    }
}
