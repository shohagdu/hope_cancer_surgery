<div class="max-w-7xl mx-auto p-3 bg-white shadow rounded" id="prescription-page">

    {{-- ── Header ──────────────────────────────────────────────────────────── --}}
    <div class="flex justify-between items-center mb-3 no-print">
        <h2 class="text-xl font-bold text-gray-800">Patient Prescription</h2>
        <button onclick="window.print()"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition">
            🖨️ Print
        </button>
    </div>

    {{-- Patient info bar --}}
    <div class="grid grid-cols-2 gap-4 mt-2 bg-gray-100 p-2 rounded font-semibold text-sm">
        <span>Name: {{ $patient?->patient_name ?? '—' }}</span>
        <span>
            Date: {{ date('d-m-Y') }}
            &nbsp;|&nbsp;
            Next Visit:
            <input type="date" wire:model.live="next_visit_date"
                   class="border-b border-gray-400 bg-transparent text-sm focus:outline-none no-print">
            <span class="print-only">{{ $next_visit_date ? \Carbon\Carbon::parse($next_visit_date)->format('d-m-Y') : '—' }}</span>
        </span>
    </div>

    {{-- ── Two-column layout ───────────────────────────────────────────────── --}}
    <div class="grid grid-cols-[30%_69%] gap-2 mt-2">

        {{-- ── LEFT: Clinical sections ─────────────────────────────────────── --}}
        <div class="bg-gray-50 p-2 rounded text-sm space-y-3">

            @php
            $sections = [
                ['key' => 'complaints',      'label' => 'Chief Complaints'],
                ['key' => 'onExamination',   'label' => 'On Examination'],
                ['key' => 'pastHistory',     'label' => 'Past History'],
                ['key' => 'drugHistory',     'label' => 'Drug History'],
                ['key' => 'investigation',   'label' => 'Investigations'],
                ['key' => 'diagnosis',       'label' => 'Diagnosis'],
                ['key' => 'treatmentPlan',   'label' => 'Treatment Plan'],
                ['key' => 'operationNote',   'label' => 'Operation Notes'],
                ['key' => 'advice',          'label' => 'Advice'],
                ['key' => 'nextPlan',        'label' => 'Next Plan'],
                ['key' => 'hospitalizations','label' => 'Hospitalizations'],
            ];
            @endphp

            @foreach($sections as $sec)
                <div>
                    <div class="flex items-center justify-between">
                        <span class="font-semibold text-gray-700">{{ $sec['label'] }}</span>
                        <button wire:click="openLeftbarModal('{{ $sec['key'] }}')"
                                class="text-blue-500 hover:text-blue-700 text-lg leading-none no-print">➕</button>
                    </div>
                    <ul class="mt-1 space-y-0.5">
                        @foreach($this->{$sec['key']} as $i => $item)
                            <li class="flex items-start justify-between gap-1">
                                <span>• <strong>{{ $item['label'] }}</strong>
                                    @if(!empty($item['note'])) — {{ $item['note'] }} @endif
                                </span>
                                <button wire:click="removeLeftbarItem('{{ $sec['key'] }}', {{ $i }})"
                                        class="text-red-400 hover:text-red-600 text-xs no-print flex-shrink-0">✕</button>
                            </li>
                        @endforeach
                    </ul>
                </div>
            @endforeach
        </div>

        {{-- ── RIGHT: Rx ───────────────────────────────────────────────────── --}}
        <div class="bg-white border rounded p-2">
            <div class="flex items-center justify-between mb-2">
                <span class="text-2xl font-bold text-gray-700">℞</span>
                <button wire:click="$set('showModal', true)"
                        class="px-3 py-1 rounded bg-green-500 text-white hover:bg-green-600 text-sm no-print">
                    ➕ Add Medicine
                </button>
            </div>

            {{-- Saved prescription medicines --}}
            <ul class="space-y-2">
                @forelse ($prescriptionsMedicine as $idx => $med)
                    <li class="border-b pb-1">
                        <div class="flex justify-between items-start">
                            <div>
                                <span class="font-semibold">{{ $idx + 1 }}. {{ $med['medicine']['name'] ?? '' }}</span>
                                <span class="text-gray-500 text-sm"> {{ $med['medicine']['strength'] ?? '' }}</span>
                                @if(!empty($med['medicine']['generic']))
                                    <i class="text-gray-400 text-xs"> [{{ $med['medicine']['generic'] }}]</i>
                                @endif
                                @foreach($med['dosages'] ?? [] as $dosage)
                                    <div class="text-sm mt-0.5 text-gray-700">
                                        @php
                                            $parts = array_filter([
                                                $dosage['dosage_morning']   > 0 ? $dosage['dosage_morning']   : null,
                                                $dosage['dosage_noon']      > 0 ? $dosage['dosage_noon']      : null,
                                                $dosage['dosage_afternoon'] > 0 ? $dosage['dosage_afternoon'] : null,
                                                $dosage['dosage_night']     > 0 ? $dosage['dosage_night']     : null,
                                            ], fn($v) => $v !== null);
                                        @endphp
                                        {{ implode(' + ', $parts ?: ['—']) }}
                                        @if(!empty($dosage['meal_time_select'])) — {{ $dosage['meal_time_select'] }} @endif
                                        @if(!empty($dosage['duration'])) — {{ $dosage['duration'] }} {{ $dosage['duration_unit_check'] ?? '' }} @endif
                                    </div>
                                @endforeach
                                @if(!empty($med['custom_time_instruction']))
                                    <div class="text-xs text-blue-600 italic">{{ $med['custom_time_instruction'] }}</div>
                                @endif
                            </div>
                            <button wire:click="removeSavedMedicine({{ $med['id'] }})"
                                    class="text-red-400 hover:text-red-600 no-print">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                    </li>
                @empty
                    <li class="text-gray-400 text-sm text-center py-4">No medicines added yet.</li>
                @endforelse
            </ul>
        </div>
    </div>

    {{-- ════════════════════════════════════════════════════════════════════════
         MODAL 1: Leftbar Section (Complaints, Examination, etc.)
         ════════════════════════════════════════════════════════════════════════ --}}
    @if($showLeftbarModal)
        <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 overflow-hidden flex flex-col max-h-[90vh]">

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-3 border-b bg-gray-50">
                    <h3 class="text-lg font-semibold text-gray-800">
                        @php
                            $sectionLabels = [
                                'complaints'=>'Chief Complaints','onExamination'=>'On Examination',
                                'pastHistory'=>'Past History','drugHistory'=>'Drug History',
                                'investigation'=>'Investigations','diagnosis'=>'Diagnosis',
                                'treatmentPlan'=>'Treatment Plan','operationNote'=>'Operation Notes',
                                'advice'=>'Advice','nextPlan'=>'Next Plan','hospitalizations'=>'Hospitalizations',
                            ];
                        @endphp
                        {{ $sectionLabels[$modalSection] ?? $modalSection }}
                    </h3>
                    <button wire:click="$set('showLeftbarModal', false)" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
                </div>

                <div class="flex-1 overflow-y-auto p-5 space-y-4">

                    {{-- Search + presets --}}
                    <div>
                        <input wire:model.live="itemSearch" type="text" placeholder="Search..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2">
                        <div class="flex flex-wrap gap-2">
                            @foreach($sectionPresets as $preset)
                                <button wire:click="addPresetItem('{{ addslashes($preset) }}')"
                                        class="px-2 py-1 text-xs bg-gray-100 hover:bg-blue-100 border rounded-lg">
                                    {{ $preset }}
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Add form --}}
                    <div class="flex gap-2 items-end">
                        <div class="flex-1">
                            <label class="text-xs text-gray-500 mb-0.5 block">Item</label>
                            <input wire:model="newItemLabel" type="text" placeholder="e.g. Fever"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div class="flex-1">
                            <label class="text-xs text-gray-500 mb-0.5 block">Note (optional)</label>
                            <input wire:model="newItemNote" type="text" placeholder="e.g. since 3 days"
                                   class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <button wire:click="addLeftbarItem()"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 whitespace-nowrap">
                            + Add
                        </button>
                    </div>

                    {{-- Current items --}}
                    @if(count($this->{$modalSection}))
                        <div class="border rounded-lg divide-y">
                            @foreach($this->{$modalSection} as $i => $item)
                                <div class="flex items-center justify-between px-3 py-2">
                                    <span class="text-sm">
                                        <strong>{{ $item['label'] }}</strong>
                                        @if(!empty($item['note'])) — <span class="text-gray-500">{{ $item['note'] }}</span> @endif
                                    </span>
                                    <button wire:click="removeLeftbarItem('{{ $modalSection }}', {{ $i }})"
                                            class="text-red-400 hover:text-red-600 text-sm">✕</button>
                                </div>
                            @endforeach
                        </div>
                    @else
                        <p class="text-gray-400 text-sm text-center py-2">No items added yet.</p>
                    @endif
                </div>

                <div class="border-t px-5 py-3 bg-gray-50 flex justify-end">
                    <button wire:click="$set('showLeftbarModal', false)"
                            class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                        Done
                    </button>
                </div>
            </div>
        </div>
    @endif

    {{-- ════════════════════════════════════════════════════════════════════════
         MODAL 2: Add Medicine
         ════════════════════════════════════════════════════════════════════════ --}}
    <div x-data="{ open: @entangle('showModal') }">
        <div x-show="open" class="fixed inset-0 bg-black/40 flex items-center justify-center z-50">
            <div class="bg-white rounded-xl w-full max-w-6xl h-[90vh] flex flex-col shadow-2xl">

                {{-- Header --}}
                <div class="flex items-center justify-between px-5 py-3 border-b">
                    <h2 class="text-lg font-semibold">Add Medicine</h2>
                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-2xl">✕</button>
                </div>

                <div class="flex flex-1 overflow-hidden">

                    {{-- Sidebar: common drugs --}}
                    <div class="w-56 bg-gray-50 border-r flex flex-col">
                        <div class="p-3 border-b text-sm font-semibold text-gray-700">Commonly Used</div>
                        <div class="flex-1 overflow-y-auto p-3 space-y-1">
                            @foreach($commonDrugs as $drug)
                                <button wire:click="addMedicine({{ json_encode($drug) }})"
                                        class="text-blue-600 hover:text-blue-800 hover:underline text-left text-sm block w-full">
                                    {{ $drug['name'] }} ({{ $drug['strength'] }})
                                </button>
                            @endforeach
                        </div>
                    </div>

                    {{-- Main area --}}
                    <div class="flex-1 flex flex-col overflow-hidden">

                        {{-- Search --}}
                        <div class="p-4 border-b">
                            <div class="relative">
                                <input wire:model.live="searchTerm" type="text"
                                       placeholder="Type medicine name to search..."
                                       class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400">
                                @if(!empty($medicineSuggestions))
                                    <ul class="absolute left-0 w-full z-50 bg-white border border-gray-200 rounded-lg mt-1 max-h-48 overflow-y-auto shadow-lg">
                                        @foreach($medicineSuggestions as $med)
                                            <li wire:click="selectMedicine({{ $med->id }})"
                                                class="px-4 py-2 cursor-pointer hover:bg-blue-50 text-sm">
                                                <span class="font-semibold">{{ $med->name }}</span>
                                                <span class="text-gray-500"> {{ $med->strength }}</span>
                                                <i class="text-gray-400"> [{{ $med->generic }}]</i>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </div>

                        {{-- Selected medicines --}}
                        <div class="flex-1 overflow-y-auto p-4 space-y-3">
                            @forelse($selectedMedicines as $index => $medicine)
                                @php
                                    $initDosages  = $medicine['dosages'] ?? [['dosage_morning'=>0,'dosage_noon'=>0,'dosage_afternoon'=>0,'dosage_night'=>0]];
                                    $initDuration = $medicine['duration'] ?? '';
                                    $initCustom   = !empty($medicine['custom_instruction']);
                                @endphp
                                <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-sm"
                                     x-data="{
                                         showCustom: {{ $initCustom ? 'true' : 'false' }},
                                         dosages: @js($initDosages),
                                         duration: '{{ $initDuration }}',
                                         syncDosages() { $wire.set('selectedMedicines.{{ $index }}.dosages', this.dosages); },
                                         toggleTime(dIdx, key, checked) {
                                             let cur = Number(this.dosages[dIdx][key]) || 0;
                                             this.dosages[dIdx][key] = checked ? (cur > 0 ? cur : 1) : 0;
                                             this.syncDosages();
                                         },
                                         setVal(dIdx, key, val) { this.dosages[dIdx][key] = val; this.syncDosages(); },
                                         addDosage() {
                                             this.dosages.push({dosage_morning:0,dosage_noon:0,dosage_afternoon:0,dosage_night:0});
                                             this.syncDosages();
                                         },
                                         setTakeFor(days, checked) {
                                             if (checked) { this.duration = days; $wire.set('selectedMedicines.{{ $index }}.duration', days); }
                                             else if (this.duration == days) { this.duration = ''; $wire.set('selectedMedicines.{{ $index }}.duration', ''); }
                                         }
                                     }">

                                    {{-- Medicine name row --}}
                                    <div class="flex items-center justify-between mb-2">
                                        <div class="flex items-center gap-2 flex-wrap">
                                            <span class="text-gray-500 text-sm">{{ $loop->iteration }}.</span>
                                            <span class="font-semibold">{{ $medicine['medicine']['name'] }}</span>
                                            @if(!empty($medicine['medicine']['strength']))
                                                <span class="text-gray-500 text-sm">{{ $medicine['medicine']['strength'] }}</span>
                                            @endif
                                            @if(!empty($medicine['medicine']['generic']))
                                                <span class="text-gray-400 text-xs italic">[{{ $medicine['medicine']['generic'] }}]</span>
                                            @endif
                                        </div>
                                        <button wire:click="removeMedicine({{ $index }})" class="text-red-400 hover:text-red-600">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                            </svg>
                                        </button>
                                    </div>

                                    {{-- Dosage grid --}}
                                    <div class="grid grid-cols-[40%,20%,38%] gap-2">

                                        {{-- Dosage rows --}}
                                        <div>
                                            <template x-for="(dosage, dIdx) in dosages" :key="dIdx">
                                                <div class="mb-2">
                                                    {{-- Time checkboxes --}}
                                                    <div class="flex gap-3 mb-1">
                                                        @foreach(['dosage_morning'=>'সকাল','dosage_noon'=>'দুপুর','dosage_afternoon'=>'বিকাল','dosage_night'=>'রাত'] as $dkey => $dlabel)
                                                            <label class="flex items-center gap-1 text-xs cursor-pointer">
                                                                <input type="checkbox"
                                                                       :checked="Number(dosage.{{ $dkey }}) > 0"
                                                                       @change="toggleTime(dIdx, '{{ $dkey }}', $event.target.checked)"
                                                                       class="w-3.5 h-3.5 text-blue-600 rounded border-gray-300">
                                                                {{ $dlabel }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    {{-- Quantity inputs --}}
                                                    <div class="flex gap-1 items-center">
                                                        <input type="text" :value="dosage.dosage_morning"   @input="setVal(dIdx,'dosage_morning',$event.target.value)"   class="w-10 px-1 py-1 text-center border border-gray-300 rounded-l text-sm">
                                                        <input type="text" :value="dosage.dosage_noon"      @input="setVal(dIdx,'dosage_noon',$event.target.value)"      class="w-10 px-1 py-1 text-center border-t border-b border-gray-300 text-sm">
                                                        <input type="text" :value="dosage.dosage_afternoon" @input="setVal(dIdx,'dosage_afternoon',$event.target.value)" class="w-10 px-1 py-1 text-center border-t border-b border-gray-300 text-sm">
                                                        <input type="text" :value="dosage.dosage_night"     @input="setVal(dIdx,'dosage_night',$event.target.value)"     class="w-10 px-1 py-1 text-center border border-gray-300 rounded-r text-sm">
                                                    </div>
                                                </div>
                                            </template>
                                            <button type="button" @click="addDosage()" class="text-blue-500 hover:text-blue-700 text-xs mt-1">+ Add more</button>
                                        </div>

                                        {{-- Timing + custom --}}
                                        <div>
                                            <select wire:model.live="selectedMedicines.{{ $index }}.timing"
                                                    class="w-full py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                                @foreach(['খাবারের পরে','খাবারের আগে','খাবারের সাথে'] as $t)
                                                    <option value="{{ $t }}">{{ $t }}</option>
                                                @endforeach
                                            </select>
                                            <label class="flex items-center gap-1 text-xs text-gray-600 mt-1.5 cursor-pointer">
                                                <input type="checkbox" :checked="showCustom"
                                                       @change="showCustom = $event.target.checked"
                                                       class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded">
                                                Custom
                                            </label>
                                        </div>

                                        {{-- Take for + duration --}}
                                        <div class="p-2 border border-gray-200 rounded">
                                            <div class="flex flex-wrap gap-2 mb-1.5">
                                                <span class="text-xs font-semibold text-gray-600">Take For:</span>
                                                @foreach([1,5,7,14,30] as $days)
                                                    <label class="flex items-center gap-1 text-xs cursor-pointer">
                                                        <input type="checkbox"
                                                               :checked="Number(duration) === {{ $days }}"
                                                               @change="setTakeFor({{ $days }}, $event.target.checked)"
                                                               class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                                                        {{ $days }}
                                                    </label>
                                                @endforeach
                                            </div>
                                            <div class="grid grid-cols-[30%,70%] gap-1 items-center">
                                                <input type="text" x-model="duration"
                                                       @input="$wire.set('selectedMedicines.{{ $index }}.duration', $event.target.value)"
                                                       placeholder="Days"
                                                       class="w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                                <div class="flex gap-1 flex-wrap">
                                                    @foreach(['দিন','মাস','চলবে','N/A'] as $type)
                                                        <label class="flex items-center gap-1 text-xs">
                                                            <input wire:model.live="selectedMedicines.{{ $index }}.duration_type"
                                                                   type="radio" value="{{ $type }}"
                                                                   class="w-3 h-3 text-blue-600 border-gray-300">
                                                            {{ $type }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    {{-- Custom instruction --}}
                                    <div x-show="showCustom" x-cloak class="mt-2">
                                        <textarea wire:model.live="selectedMedicines.{{ $index }}.custom_instruction"
                                                  rows="2" placeholder="Custom instruction..."
                                                  class="w-full border border-gray-300 rounded px-2 py-1 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"></textarea>
                                    </div>
                                </div>
                            @empty
                                <div class="text-center py-8 text-gray-400 text-sm">
                                    Search or select a medicine from the left panel.
                                </div>
                            @endforelse
                        </div>

                        {{-- Footer --}}
                        <div class="border-t p-4 bg-gray-50 flex justify-end gap-3">
                            <button wire:click="saveMedicine()"
                                    class="px-5 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 text-sm">
                                Save Prescription
                            </button>
                            <button @click="open = false"
                                    class="px-5 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg hover:bg-gray-50 text-sm">
                                Close
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    {{-- ── SweetAlert ──────────────────────────────────────────────────────────── --}}
    <script>
        window.addEventListener('swal:success', e => {
            Swal.fire({ icon: 'success', title: e.detail[0]?.title ?? e.detail.title, text: e.detail[0]?.text ?? e.detail.text })
                .then(() => location.reload());
        });
        window.addEventListener('swal:error', e => {
            Swal.fire({ icon: 'error', title: e.detail[0]?.title ?? e.detail.title, text: e.detail[0]?.text ?? e.detail.text });
        });
    </script>

    {{-- ── Print styles ────────────────────────────────────────────────────────── --}}
    <style>
    @media print {
        body * { visibility: hidden; }
        #prescription-page, #prescription-page * { visibility: visible; }
        #prescription-page { position: fixed; top: 0; left: 0; width: 100%; }
        .no-print { display: none !important; }
        .print-only { display: inline !important; }
        input[type="date"] { display: none !important; }
    }
    @media screen {
        .print-only { display: none; }
    }
    </style>
</div>
