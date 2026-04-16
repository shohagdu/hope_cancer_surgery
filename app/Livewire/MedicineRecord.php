<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\PrescriptionMedicineRecord;
use App\Models\PrescripDrugManufacturer;
use App\Models\PrescripDrugType;

class MedicineRecord extends Component
{
    use WithPagination;

    protected $paginationTheme = 'tailwind';

    // Filters
    public string $search       = '';
    public string $filterStatus = '';

    // Modal state
    public bool $isShowModal = false;
    public ?int $editId      = null;

    // Form fields
    public string  $name            = '';
    public string  $generic         = '';
    public string  $strength        = '';
    public string  $use_for         = '';
    public string  $DAR             = '';
    public int     $is_active       = 1;
    public ?int    $manufacturer_id = null;
    public ?int    $dosage_id       = null;

    protected function rules(): array
    {
        return [
            'name'            => 'required|string|max:255|unique:prescription_medicine_record,name' . ($this->editId ? ",{$this->editId}" : ''),
            'generic'         => 'nullable|string|max:800',
            'strength'        => 'nullable|string|max:800',
            'use_for'         => 'nullable|string|max:100',
            'DAR'             => 'nullable|string|max:100',
            'is_active'       => 'required|in:0,1',
            'manufacturer_id' => 'nullable|exists:prescrip_drug_manufacturers,id',
            'dosage_id'       => 'nullable|exists:prescrip_drug_type,id',
        ];
    }

    public function mount(): void
    {
        $this->isShowModal = false;
    }

    public function updatingSearch(): void       { $this->resetPage(); }
    public function updatingFilterStatus(): void { $this->resetPage(); }

    public function openCreate(): void
    {
        $this->resetValidation();
        $this->resetForm();
        $this->isShowModal = true;
    }

    public function openEdit(int $id): void
    {
        $this->resetValidation();
        $med = PrescriptionMedicineRecord::findOrFail($id);
        $this->editId          = $med->id;
        $this->name            = $med->name;
        $this->generic         = $med->generic        ?? '';
        $this->strength        = $med->strength       ?? '';
        $this->use_for         = $med->use_for        ?? '';
        $this->DAR             = $med->DAR            ?? '';
        $this->is_active       = (int) $med->is_active;
        $this->manufacturer_id = $med->manufacturer_id ? (int) $med->manufacturer_id : null;
        $this->dosage_id       = $med->dosage_id      ? (int) $med->dosage_id       : null;
        $this->isShowModal     = true;
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name'            => $this->name,
            'generic'         => $this->generic        ?: null,
            'strength'        => $this->strength       ?: null,
            'use_for'         => $this->use_for        ?: null,
            'DAR'             => $this->DAR            ?: null,
            'is_active'       => $this->is_active,
            'manufacturer_id' => $this->manufacturer_id ?: null,
            'dosage_id'       => $this->dosage_id       ?: null,
        ];

        if ($this->editId) {
            PrescriptionMedicineRecord::findOrFail($this->editId)->update($data);
            $this->dispatch('swal:success', title: 'Updated!', text: 'Medicine updated successfully.');
        } else {
            PrescriptionMedicineRecord::create($data);
            $this->dispatch('swal:success', title: 'Added!', text: 'Medicine added successfully.');
        }

        $this->resetForm();
        $this->isShowModal = false;
    }

    public function toggleStatus(int $id): void
    {
        $med = PrescriptionMedicineRecord::findOrFail($id);
        $med->update(['is_active' => $med->is_active ? 0 : 1]);
        $this->dispatch('swal:success', title: 'Updated!', text: 'Status changed.');
    }

    public function delete(int $id): void
    {
        PrescriptionMedicineRecord::findOrFail($id)->delete();
        $this->dispatch('swal:success', title: 'Deleted!', text: 'Medicine deleted.');
    }

    private function resetForm(): void
    {
        $this->editId          = null;
        $this->name            = '';
        $this->generic         = '';
        $this->strength        = '';
        $this->use_for         = '';
        $this->DAR             = '';
        $this->is_active       = 1;
        $this->manufacturer_id = null;
        $this->dosage_id       = null;
    }

    public function render()
    {
        $records = PrescriptionMedicineRecord::with(['manufacturer', 'drugType'])
            ->when($this->search, fn($q) =>
                $q->where('name', 'like', "%{$this->search}%")
                  ->orWhere('generic', 'like', "%{$this->search}%")
                  ->orWhere('strength', 'like', "%{$this->search}%")
            )
            ->when($this->filterStatus !== '', fn($q) =>
                $q->where('is_active', (int) $this->filterStatus)
            )
            ->orderBy('name')
            ->paginate(20);

        $manufacturers = PrescripDrugManufacturer::where('is_active', 1)->orderBy('name')->get();
        $drugTypes     = PrescripDrugType::where('is_active', 1)->orderBy('name')->get();

        return view('livewire.medicine-record', compact('records', 'manufacturers', 'drugTypes'));
    }
}
