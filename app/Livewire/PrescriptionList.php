<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\PrescriptionMedicineRecord;
use App\Models\OnlineAppointment;
use App\Models\Patient_medicine;
use App\Models\PatientPrescriptionRecord;
use App\Models\PatientMedicineDosage;

class PrescriptionList extends Component
{
    // Patient & prescription IDs
    public $id, $prescription_id;
    public $patient = null;

    // Prescription header
    public $visit_date;
    public $next_visit_date;

    // Leftbar sections (arrays of ['label'=>'', 'note'=>''])
    public array $complaints     = [];
    public array $onExamination  = [];
    public array $pastHistory    = [];
    public array $drugHistory    = [];
    public array $investigation  = [];
    public array $diagnosis      = [];
    public array $treatmentPlan  = [];
    public array $operationNote  = [];
    public array $advice         = [];
    public array $nextPlan       = [];
    public array $hospitalizations = [];

    // Leftbar modal
    public bool  $showLeftbarModal = false;
    public string $modalSection   = 'complaints';
    public string $newItemLabel   = '';
    public string $newItemNote    = '';
    public string $itemSearch     = '';

    // Medicine modal
    public bool $showModal     = false;
    public bool $showEditModal = false;

    // Medicine search
    public string $searchTerm         = '';
    public        $medicineSuggestions = [];
    public        $selectedMedicineId  = null;

    // Medicines
    public array $prescriptionsMedicine = [];
    public array $selectedMedicines     = [];
    public array $commonDrugs = [
        ['id' => null, 'name' => 'Azithromycin',  'type' => 'Tablet', 'strength' => '500 mg', 'generic' => 'Azithromycin'],
        ['id' => null, 'name' => 'Napa',           'type' => 'Tablet', 'strength' => '500 mg', 'generic' => 'Paracetamol'],
        ['id' => null, 'name' => 'Omeprazole',     'type' => 'Capsule','strength' => '20 mg',  'generic' => 'Omeprazole'],
        ['id' => null, 'name' => 'Metformin',      'type' => 'Tablet', 'strength' => '500 mg', 'generic' => 'Metformin HCl'],
        ['id' => null, 'name' => 'Amlodipine',     'type' => 'Tablet', 'strength' => '5 mg',   'generic' => 'Amlodipine Besilate'],
        ['id' => null, 'name' => 'Ciprofloxacin',  'type' => 'Tablet', 'strength' => '500 mg', 'generic' => 'Ciprofloxacin HCl'],
    ];

    // Edit modal
    public $currentMedicineIndex = null;

    // Preset complaint suggestions per section
    private array $presets = [
        'complaints'    => ['Fever','Headache','Cough','Fatigue','Nausea','Vomiting','Chest pain','Back pain','Abdominal pain','Shortness of breath','Weight loss','Loss of appetite','Swelling','Dizziness'],
        'onExamination' => ['BP Normal','BP High','BP Low','Pulse Normal','Temp Normal','Temp High','Jaundice','Pallor','Oedema','Tenderness'],
        'pastHistory'   => ['Diabetes','Hypertension','Asthma','TB','Heart Disease','Kidney Disease','Liver Disease','Cancer','Surgery','None'],
        'drugHistory'   => ['No known allergy','Aspirin allergy','Penicillin allergy','Sulfa allergy','NSAID allergy'],
        'investigation' => ['CBC','Blood Sugar','Creatinine','HbA1c','Liver Function Test','X-Ray','USG Abdomen','ECG','Urine R/E','Biopsy'],
        'diagnosis'     => ['Hypertension','Diabetes Mellitus','Dyslipidemia','GERD','UTI','Pneumonia','Cancer','COPD','IHD'],
        'treatmentPlan' => ['Surgical','Medical','Conservative','Radiotherapy','Chemotherapy','Palliative'],
        'operationNote' => [],
        'advice'        => ['Take medicine regularly','Low salt diet','Low fat diet','Exercise daily','Avoid smoking','Avoid alcohol','Drink plenty of water','Follow up after 1 month'],
        'nextPlan'      => ['Review after 1 week','Review after 2 weeks','Review after 1 month','Follow-up with reports'],
        'hospitalizations' => ['Required','Not required'],
    ];

    public function mount($id = null)
    {
        $this->visit_date = date('Y-m-d');

        if (!empty($id)) {
            $this->id      = $id;
            $this->patient = OnlineAppointment::find($id);

            $prescription           = PatientPrescriptionRecord::where('patient_id', $id)->orderBy('id', 'DESC')->first();
            $this->prescription_id  = $prescription?->id;

            if ($prescription) {
                $this->visit_date      = $prescription->visit_date ?? date('Y-m-d');
                $this->next_visit_date = $prescription->next_visit_date;
                $this->complaints      = $prescription->complaints     ?? [];
                $this->onExamination   = $prescription->on_examination ?? [];
                $this->pastHistory     = $prescription->pastHistory    ?? [];
                $this->drugHistory     = $prescription->drugHistory    ?? [];
                $this->investigation   = $prescription->investigation  ?? [];
                $this->diagnosis       = $prescription->diagnosis      ?? [];
                $this->treatmentPlan   = $prescription->treatmentPlan  ?? [];
                $this->operationNote   = $prescription->operationNote  ?? [];
                $this->advice          = $prescription->advice         ?? [];
                $this->nextPlan        = $prescription->nextPlan       ?? [];
                $this->hospitalizations = $prescription->hospitalizations ?? [];
            }

            $prescriptionInfo = $this->prescription_id
                ? PatientPrescriptionRecord::with('patient_medicine_record.medicine', 'patient_medicine_record.dosages')
                    ->find($this->prescription_id)
                : null;

            $medicines = $prescriptionInfo?->patient_medicine_record ?? collect();
            $this->prescriptionsMedicine = $medicines->toArray();
            $this->selectedMedicines     = $medicines->toArray();
        }
    }

    // ─── Leftbar Modal ────────────────────────────────────────────────────────

    public function openLeftbarModal(string $section): void
    {
        $this->modalSection  = $section;
        $this->newItemLabel  = '';
        $this->newItemNote   = '';
        $this->itemSearch    = '';
        $this->showLeftbarModal = true;
    }

    public function addPresetItem(string $label): void
    {
        $this->newItemLabel = $label;
    }

    public function addLeftbarItem(): void
    {
        $label = trim($this->newItemLabel);
        if (!$label) return;

        $item = ['label' => $label, 'note' => trim($this->newItemNote)];
        $this->{$this->modalSection}[] = $item;

        $this->newItemLabel = '';
        $this->newItemNote  = '';
        $this->saveLeftbarSection();
    }

    public function removeLeftbarItem(string $section, int $index): void
    {
        array_splice($this->{$section}, $index, 1);
        $this->saveLeftbarSection($section);
    }

    private function saveLeftbarSection(string $section = null): void
    {
        $s = $section ?? $this->modalSection;

        $map = [
            'complaints'     => 'complaints',
            'onExamination'  => 'on_examination',
            'pastHistory'    => 'pastHistory',
            'drugHistory'    => 'drugHistory',
            'investigation'  => 'investigation',
            'diagnosis'      => 'diagnosis',
            'treatmentPlan'  => 'treatmentPlan',
            'operationNote'  => 'operationNote',
            'advice'         => 'advice',
            'nextPlan'       => 'nextPlan',
            'hospitalizations' => 'hospitalizations',
        ];

        $record = PatientPrescriptionRecord::updateOrCreate(
            ['id' => $this->prescription_id ?? 0],
            [
                'patient_id' => $this->id,
                'visit_date' => $this->visit_date ?? date('Y-m-d'),
                $map[$s]     => $this->{$s},
                'created_by' => auth()->id(),
                'updated_by' => auth()->id(),
                'created_ip' => request()->ip(),
                'updated_ip' => request()->ip(),
            ]
        );
        $this->prescription_id = $record->id;
    }

    public function getPresetsForSection(): array
    {
        $presets = $this->presets[$this->modalSection] ?? [];
        if ($this->itemSearch) {
            $q = strtolower($this->itemSearch);
            $presets = array_values(array_filter($presets, fn($p) => str_contains(strtolower($p), $q)));
        }
        return $presets;
    }

    // ─── Medicine Search ──────────────────────────────────────────────────────

    public function updatedSearchTerm(): void
    {
        $this->selectedMedicineId = null;
        $this->medicineSuggestions = PrescriptionMedicineRecord::where('name', 'like', '%' . $this->searchTerm . '%')
            ->limit(10)
            ->get(['id', 'name', 'strength', 'generic']);
    }

    public function selectMedicine(int $id): void
    {
        $medicine = PrescriptionMedicineRecord::find($id);
        if ($medicine) {
            $this->addMedicine([
                'id'       => $medicine->id,
                'name'     => $medicine->name,
                'strength' => $medicine->strength,
                'generic'  => $medicine->generic,
                'dosage_id'=> $medicine->dosage_id,
            ]);
        }
        $this->searchTerm = '';
        $this->medicineSuggestions = [];
    }

    public function addMedicine(array $drug): void
    {
        // Resolve DB id if commonDrug without id
        if (empty($drug['id'])) {
            $found = PrescriptionMedicineRecord::where('name', $drug['name'])->first();
            if (!$found) return;
            $drug['id']      = $found->id;
            $drug['generic'] = $found->generic;
            $drug['strength']= $found->strength;
        }

        // Prevent duplicates
        foreach ($this->selectedMedicines as $m) {
            if (($m['medicine']['id'] ?? null) == $drug['id']) return;
        }

        $newSerial = count($this->selectedMedicines) + 1;
        $this->selectedMedicines[] = [
            'serial_number'      => $newSerial,
            'id'                 => $newSerial,
            'medicine'           => [
                'id'       => $drug['id'],
                'name'     => $drug['name'],
                'generic'  => $drug['generic']  ?? null,
                'strength' => $drug['strength'] ?? null,
                'dosage_id'=> $drug['dosage_id'] ?? null,
            ],
            'dosages' => [[
                'dosage_morning'   => 0,
                'dosage_noon'      => 0,
                'dosage_afternoon' => 0,
                'dosage_night'     => 0,
            ]],
            'timing'             => 'খাবারের পরে',
            'duration'           => '',
            'duration_type'      => 'দিন',
            'custom_instruction' => '',
        ];
    }

    public function removeMedicine(int $index): void
    {
        unset($this->selectedMedicines[$index]);
        $this->selectedMedicines = array_values($this->selectedMedicines);
    }

    public function updateTakeFor(int $index, int $days, bool $checked): void
    {
        if ($checked) {
            $this->selectedMedicines[$index]['duration'] = $days;
        } elseif (($this->selectedMedicines[$index]['duration'] ?? null) == $days) {
            $this->selectedMedicines[$index]['duration'] = '';
        }
    }

    // ─── Save Medicines ───────────────────────────────────────────────────────

    public function saveMedicine(): void
    {
        try {
            $record = PatientPrescriptionRecord::updateOrCreate(
                ['id' => $this->prescription_id ?? 0],
                [
                    'patient_id'  => $this->id,
                    'visit_date'  => $this->visit_date ?? date('Y-m-d'),
                    'complaints'  => $this->complaints,
                    'on_examination' => $this->onExamination,
                    'pastHistory' => $this->pastHistory,
                    'drugHistory' => $this->drugHistory,
                    'investigation'  => $this->investigation,
                    'diagnosis'   => $this->diagnosis,
                    'treatmentPlan'  => $this->treatmentPlan,
                    'operationNote'  => $this->operationNote,
                    'advice'      => $this->advice,
                    'nextPlan'    => $this->nextPlan,
                    'hospitalizations' => $this->hospitalizations,
                    'next_visit_date'  => $this->next_visit_date ?: null,
                    'created_by'  => auth()->id(),
                    'updated_by'  => auth()->id(),
                    'created_ip'  => request()->ip(),
                    'updated_ip'  => request()->ip(),
                ]
            );
            $this->prescription_id = $record->id;

            foreach ($this->selectedMedicines as $medicine) {
                $medicineId = $medicine['medicine']['id'] ?? null;
                if (!$medicineId) continue;

                $patientMed = Patient_medicine::updateOrCreate(
                    ['medicine_id' => $medicineId, 'patient_prescription_id' => $this->prescription_id],
                    [
                        'patient_prescription_id' => $this->prescription_id,
                        'medicine_id'             => $medicineId,
                        'custom_time_instruction' => $medicine['custom_instruction'] ?? null,
                        'medicine_serial'         => $medicine['serial_number'] ?? null,
                        'created_by' => auth()->id(),
                        'updated_by' => auth()->id(),
                        'created_ip' => request()->ip(),
                        'updated_ip' => request()->ip(),
                    ]
                );

                $dosages = $medicine['dosages'] ?? [];
                foreach ($dosages as $dosage) {
                    $existing = PatientMedicineDosage::where('patient_medicine_id', $patientMed->id)->first();
                    $dosageData = [
                        'dosage_morning'   => $dosage['dosage_morning']   ?? 0,
                        'dosage_noon'      => $dosage['dosage_noon']      ?? 0,
                        'dosage_afternoon' => $dosage['dosage_afternoon'] ?? 0,
                        'dosage_night'     => $dosage['dosage_night']     ?? 0,
                        'meal_time_select' => $medicine['timing']         ?? null,
                        'duration'         => $medicine['duration']       ?? null,
                        'duration_unit_check' => $medicine['duration_type'] ?? null,
                        'updated_by'  => auth()->id(),
                        'updated_ip'  => request()->ip(),
                    ];
                    if ($existing) {
                        $existing->update($dosageData);
                    } else {
                        PatientMedicineDosage::create(array_merge($dosageData, [
                            'patient_medicine_id' => $patientMed->id,
                            'created_by' => auth()->id(),
                            'created_ip' => request()->ip(),
                        ]));
                    }
                }
            }

            // Reload from DB
            $info = PatientPrescriptionRecord::with('patient_medicine_record.medicine', 'patient_medicine_record.dosages')
                ->find($this->prescription_id);
            $meds = $info?->patient_medicine_record ?? collect();
            $this->prescriptionsMedicine = $meds->toArray();
            $this->selectedMedicines     = $meds->toArray();
            $this->showModal = false;

            $this->dispatch('swal:success', ['title' => 'Saved!', 'text' => 'Prescription saved successfully.']);
        } catch (\Exception $e) {
            $this->dispatch('swal:error', ['title' => 'Error!', 'text' => $e->getMessage()]);
        }
    }

    // ─── Remove saved medicine ────────────────────────────────────────────────

    public function removeSavedMedicine(int $id): void
    {
        Patient_medicine::where('id', $id)->delete();
        PatientMedicineDosage::where('patient_medicine_id', $id)->delete();
        $this->prescriptionsMedicine = collect($this->prescriptionsMedicine)
            ->reject(fn($m) => $m['id'] == $id)->values()->toArray();
    }

    public function render()
    {
        return view('livewire.prescription', [
            'sectionPresets' => $this->getPresetsForSection(),
        ]);
    }
}
