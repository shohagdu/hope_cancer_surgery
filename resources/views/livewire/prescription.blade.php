<div class="max-w-7xl mx-auto p-3 bg-white shadow rounded" id="prescription-page">

    {{-- ── Dynamic prescription styles (re-rendered on settings change) ──── --}}
    @php
        $leftPct  = 100 - $pdfSettings['medicine_width'] - 1;
        $rightPct = $pdfSettings['medicine_width'];
        $ff       = $pdfSettings['font_family'];
        $fs       = (int) $pdfSettings['font_size'];
        $mt       = (float) $pdfSettings['margin_top'];
        $mb       = (float) $pdfSettings['margin_bottom'];
        $ml       = (float) $pdfSettings['margin_left'];
    @endphp
    {{-- Live settings carrier — Livewire re-renders this element, JS reads from it --}}
    <div id="rx-pdf-meta"
         data-mt="{{ $mt }}"
         data-mb="{{ $mb }}"
         data-ml="{{ $ml }}"
         style="display:none;"></div>

    <style>
        #rx-content { font-family: {{ $ff }}, sans-serif; font-size: {{ $fs }}px; }
        @media print {
            @page { margin: {{ $mt }}in 0.5in {{ $mb }}in {{ $ml }}in; }
        }
        .generating-pdf .no-print { display: none !important; }
    </style>

    {{-- ── Header ──────────────────────────────────────────────────────────── --}}
    <div class="flex justify-between items-center mb-3 no-print">
        <h2 class="text-xl font-bold text-gray-800">Patient Prescription</h2>
        <div class="flex gap-2">
            <button wire:click="$set('showSettingsModal', true)"
                    class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-4 py-2 rounded-lg shadow-sm transition text-sm">
                ⚙️ Settings
            </button>
            <button onclick="downloadPrescriptionPdf()"
                    class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-lg shadow-sm transition text-sm">
                ⬇️ PDF
            </button>
            <button onclick="window.print()"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg shadow-sm transition text-sm">
                🖨️ Print
            </button>
        </div>
    </div>

    {{-- Patient info bar --}}
    <div class="mt-2 bg-gradient-to-r from-blue-50 to-indigo-50 border border-blue-100 rounded-lg px-4 py-2.5">
        <div class="flex flex-wrap items-center gap-x-1 gap-y-1 text-sm text-gray-700">
            <div class="flex items-center gap-1.5 pr-4 border-r border-blue-200">
                <span class="text-gray-500 text-sm font-medium">Name:</span>
                <span class="font-bold text-gray-900">{{ $patient?->patient_name ?? '—' }}</span>
            </div>
            <div class="flex items-center gap-1.5 px-4 border-r border-blue-200">
                <span class="text-gray-500 text-sm font-medium">Age:</span>
                <span class="font-semibold text-gray-800">{{ $patient?->age ? $patient->age . ' Years' : '—' }}</span>
            </div>
            <div class="flex items-center gap-1.5 px-4 border-r border-blue-200">
                <span class="text-gray-500 text-sm font-medium">Sex:</span>
                @php $g = strtolower($patient?->gender ?? ''); @endphp
                <span @class([
                    'font-semibold',
                    'text-blue-600'  => $g === 'male',
                    'text-pink-600'  => $g === 'female',
                    'text-gray-700'  => !in_array($g, ['male','female']),
                ])>{{ ucfirst($patient?->gender ?? '—') }}</span>
            </div>
            <div class="flex items-center gap-1.5 pl-4">
                <span class="text-gray-500 text-sm font-medium">Date:</span>
                <span class="font-semibold text-gray-800">
                    {{ $visit_date ? \Carbon\Carbon::parse($visit_date)->format('d M Y') : date('d M Y') }}
                </span>
            </div>
        </div>
    </div>

    {{-- ── Two-column layout ───────────────────────────────────────────────── --}}
    <div id="rx-content" class="grid gap-2 mt-2" style="grid-template-columns: {{ $leftPct }}fr {{ $rightPct }}fr">

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
                @if($sectionVisibility[$sec['key']] ?? true)
                @php $hasItems = count($this->{$sec['key']}) > 0; @endphp
                <div @class(['rx-section-empty' => !$hasItems])>
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
                @endif
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
                                            $m = (int)($dosage['dosage_morning']   ?? 0);
                                            $n = (int)($dosage['dosage_noon']      ?? 0);
                                            $a = (int)($dosage['dosage_afternoon'] ?? 0);
                                            $ni = (int)($dosage['dosage_night']    ?? 0);
                                            $parts = $a > 0
                                                ? [$m, $n, $a, $ni]
                                                : [$m, $n, $ni];
                                        @endphp
                                        {{ implode('+', $parts) }}
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

            {{-- Next Visit --}}
            <div class="mt-4 pt-2 border-t border-dashed border-gray-200">
                {{-- Screen: always show compact picker --}}
                <div class="no-print flex items-center justify-end gap-2">
                    <span class="text-xs font-medium text-gray-500 whitespace-nowrap">Next Visit:</span>
                    <input type="date" wire:model.live="next_visit_date"
                           class="border border-gray-300 rounded px-2 py-0.5 text-xs text-gray-700 focus:outline-none focus:ring-1 focus:ring-blue-400 bg-white w-32">
                </div>
                {{-- Print/PDF: only show when date is set --}}
                @if($next_visit_date)
                <div class="print-only flex items-center justify-end gap-2" style="display:none;">
                    <span class="text-sm font-semibold text-gray-700">Next Visit:</span>
                    <span class="text-sm font-semibold text-gray-900 border-b border-dotted border-gray-500 min-w-[140px] pb-0.5 text-center">
                        {{ \Carbon\Carbon::parse($next_visit_date)->format('d M Y') }}
                    </span>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- ── Doctor Signature (print/PDF only — fixed at page bottom-right) ── --}}
    <div id="rx-signature" class="print-only" style="display:none;">
        <div style="text-align: center; min-width: 200px;">
            <div style="height: 40px;"></div>
            <div style="border-top: 2px dotted #374151; padding-top: 6px;">
                <p style="font-weight: 600; font-size: 13px; margin: 0;">
                    {{ $doctor?->name ?? auth()->user()->name }}
                </p>
            </div>
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
                                    $initDosages = $medicine['dosages'] ?? [[
                                        'dosage_morning'=>0,'dosage_noon'=>0,'dosage_afternoon'=>0,'dosage_night'=>0,
                                        'timing'=>'খাবারের পরে','duration'=>'','duration_type'=>'দিন',
                                    ]];
                                    $initCustom = !empty($medicine['custom_instruction']);
                                @endphp
                                <div class="p-3 border border-gray-200 rounded-lg bg-white shadow-sm"
                                     x-data="{
                                         showCustom: {{ $initCustom ? 'true' : 'false' }},
                                         dosages: @js($initDosages),
                                         syncDosages() { $wire.set('selectedMedicines.{{ $index }}.dosages', this.dosages); },
                                         toggleTime(dIdx, key, checked) {
                                             let cur = Number(this.dosages[dIdx][key]) || 0;
                                             this.dosages[dIdx][key] = checked ? (cur > 0 ? cur : 1) : 0;
                                             this.syncDosages();
                                         },
                                         setVal(dIdx, key, val) { this.dosages[dIdx][key] = val; this.syncDosages(); },
                                         addDosage() {
                                             this.dosages.push({
                                                 dosage_morning:0, dosage_noon:0, dosage_afternoon:0, dosage_night:0,
                                                 timing:'খাবারের পরে', duration:'', duration_type:'দিন'
                                             });
                                             this.syncDosages();
                                         },
                                         removeDosage(dIdx) {
                                             if (this.dosages.length <= 1) return;
                                             this.dosages = this.dosages.filter((_, i) => i !== dIdx);
                                             this.syncDosages();
                                         },
                                         setTakeFor(dIdx, days, checked) {
                                             if (checked) { this.dosages[dIdx].duration = String(days); }
                                             else if (this.dosages[dIdx].duration == days) { this.dosages[dIdx].duration = ''; }
                                             this.syncDosages();
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

                                    {{-- Dosage sections (one per dosage row) --}}
                                    <template x-for="(dosage, dIdx) in dosages" :key="dIdx">
                                        <div class="border border-gray-100 rounded-md p-2 mb-2 bg-gray-50 relative">

                                            {{-- Remove dosage button --}}
                                            <button type="button"
                                                    x-show="dosages.length > 1"
                                                    @click="removeDosage(dIdx)"
                                                    class="absolute top-1 right-1 text-red-400 hover:text-red-600 text-xs leading-none font-bold">✕</button>

                                            <div class="grid grid-cols-[40%_20%_38%] gap-2">

                                                {{-- Col 1: Time checkboxes + quantity inputs --}}
                                                <div>
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
                                                    <div class="flex gap-1 items-center">
                                                        <input type="text" :value="dosage.dosage_morning"   @input="setVal(dIdx,'dosage_morning',$event.target.value)"   class="w-10 px-1 py-1 text-center border border-gray-300 rounded-l text-sm">
                                                        <input type="text" :value="dosage.dosage_noon"      @input="setVal(dIdx,'dosage_noon',$event.target.value)"      class="w-10 px-1 py-1 text-center border-t border-b border-gray-300 text-sm">
                                                        <input type="text" :value="dosage.dosage_afternoon" @input="setVal(dIdx,'dosage_afternoon',$event.target.value)" class="w-10 px-1 py-1 text-center border-t border-b border-gray-300 text-sm">
                                                        <input type="text" :value="dosage.dosage_night"     @input="setVal(dIdx,'dosage_night',$event.target.value)"     class="w-10 px-1 py-1 text-center border border-gray-300 rounded-r text-sm">
                                                    </div>
                                                </div>

                                                {{-- Col 2: Timing select --}}
                                                <div>
                                                    <select x-model="dosage.timing" @change="syncDosages()"
                                                            class="w-full py-1.5 border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                                        @foreach(['খাবারের পরে','খাবারের আগে','খাবারের সাথে'] as $t)
                                                            <option value="{{ $t }}">{{ $t }}</option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                {{-- Col 3: Take For + Duration + Duration type --}}
                                                <div class="p-1.5 border border-gray-200 rounded">
                                                    <div class="flex flex-wrap gap-1.5 mb-1">
                                                        <span class="text-xs font-semibold text-gray-600">Take For:</span>
                                                        @foreach([1,5,7,14,30] as $days)
                                                            <label class="flex items-center gap-1 text-xs cursor-pointer">
                                                                <input type="checkbox"
                                                                       :checked="Number(dosage.duration) === {{ $days }}"
                                                                       @change="setTakeFor(dIdx, {{ $days }}, $event.target.checked)"
                                                                       class="w-3 h-3 text-blue-600 border-gray-300 rounded">
                                                                {{ $days }}
                                                            </label>
                                                        @endforeach
                                                    </div>
                                                    <div class="grid grid-cols-[30%_68%] gap-1 items-center">
                                                        <input type="text"
                                                               x-model="dosage.duration"
                                                               @input="syncDosages()"
                                                               placeholder="Days"
                                                               class="w-full px-2 py-1 text-center border border-gray-300 rounded text-sm focus:outline-none focus:ring-1 focus:ring-blue-400">
                                                        <div class="flex gap-1 flex-wrap">
                                                            @foreach(['দিন','মাস','চলবে','N/A'] as $type)
                                                                <label class="flex items-center gap-1 text-xs cursor-pointer">
                                                                    <input type="radio"
                                                                           :checked="dosage.duration_type === '{{ $type }}'"
                                                                           @change="dosage.duration_type = '{{ $type }}'; syncDosages()"
                                                                           class="w-3 h-3 text-blue-600 border-gray-300">
                                                                    {{ $type }}
                                                                </label>
                                                            @endforeach
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </template>

                                    {{-- Add dosage button --}}
                                    <button type="button" @click="addDosage()"
                                            class="text-blue-500 hover:text-blue-700 text-xs mt-1">
                                        + Add Dose
                                    </button>

                                    {{-- Custom instruction (medicine-level) --}}
                                    <div class="mt-1.5 flex items-center gap-2">
                                        <label class="flex items-center gap-1 text-xs text-gray-600 cursor-pointer">
                                            <input type="checkbox" :checked="showCustom"
                                                   @change="showCustom = $event.target.checked"
                                                   class="w-3.5 h-3.5 text-blue-600 border-gray-300 rounded">
                                            Custom instruction
                                        </label>
                                    </div>
                                    <div x-show="showCustom" x-cloak class="mt-1">
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


    {{-- ════════════════════════════════════════════════════════════════════════
         MODAL 3: PDF / Print Settings
         ════════════════════════════════════════════════════════════════════════ --}}
    @if($showSettingsModal)
    <div class="fixed inset-0 bg-black/50 flex items-center justify-center z-50">
        <div class="bg-white rounded-xl shadow-2xl w-full max-w-2xl mx-4 flex flex-col max-h-[92vh] overflow-hidden">

            <div class="flex items-center justify-between px-5 py-3 border-b bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-800">⚙️ Prescription Settings</h3>
                <button wire:click="$set('showSettingsModal', false)" class="text-gray-400 hover:text-gray-600 text-xl">✕</button>
            </div>

            <div class="flex-1 overflow-y-auto p-5 space-y-6">

                {{-- ── Page Margins & Layout ── --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Page Margins & Layout</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Top Space (inches)</label>
                            <input type="number" step="0.1" min="0" max="5"
                                   wire:model.live="pdfSettings.margin_top"
                                   class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Bottom Space (inches)</label>
                            <input type="number" step="0.1" min="0" max="5"
                                   wire:model.live="pdfSettings.margin_bottom"
                                   class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Left Margin (inches)</label>
                            <input type="number" step="0.1" min="0" max="5"
                                   wire:model.live="pdfSettings.margin_left"
                                   class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Medicine Column Width (%)</label>
                            <input type="number" step="1" min="40" max="85"
                                   wire:model.live="pdfSettings.medicine_width"
                                   class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                </div>

                {{-- ── Typography ── --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Typography</h4>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Font Family</label>
                            <select wire:model.live="pdfSettings.font_family"
                                    class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                                <option value="serif">Serif (Times New Roman)</option>
                                <option value="sans-serif">Sans-serif (Arial)</option>
                                <option value="Arial">Arial</option>
                                <option value="Times New Roman">Times New Roman</option>
                                <option value="Georgia">Georgia</option>
                                <option value="Tahoma">Tahoma</option>
                                <option value="Verdana">Verdana</option>
                                <option value="Courier New">Courier New</option>
                                <option value="SolaimanLipi">SolaimanLipi (Bengali)</option>
                                <option value="Kalpurush">Kalpurush (Bengali)</option>
                            </select>
                        </div>
                        <div>
                            <label class="text-xs text-gray-500 block mb-1">Font Size (px)</label>
                            <input type="number" step="1" min="8" max="24"
                                   wire:model.live="pdfSettings.font_size"
                                   class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                        </div>
                    </div>
                    <p class="text-xs text-gray-400 mt-2" style="font-family: {{ $pdfSettings['font_family'] }}; font-size: {{ $pdfSettings['font_size'] }}px;">
                        Preview: The quick brown fox jumps over the lazy dog. রোগীর প্রেসক্রিপশন।
                    </p>
                </div>

                {{-- ── Section Visibility ── --}}
                <div>
                    <h4 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Show / Hide Sections</h4>
                    <div class="grid grid-cols-2 gap-2">
                        @foreach([
                            'complaints'      => 'Chief Complaints',
                            'onExamination'   => 'On Examination',
                            'pastHistory'     => 'Past History',
                            'drugHistory'     => 'Drug History',
                            'investigation'   => 'Investigations',
                            'diagnosis'       => 'Diagnosis',
                            'treatmentPlan'   => 'Treatment Plan',
                            'operationNote'   => 'Operation Notes',
                            'advice'          => 'Advice',
                            'nextPlan'        => 'Next Plan',
                            'hospitalizations'=> 'Hospitalizations',
                        ] as $key => $label)
                        <label class="flex items-center gap-2 text-sm cursor-pointer select-none">
                            <input type="checkbox"
                                   wire:model.live="sectionVisibility.{{ $key }}"
                                   class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                            {{ $label }}
                        </label>
                        @endforeach
                    </div>
                </div>

            </div>

            <div class="border-t px-5 py-3 bg-gray-50 flex justify-end gap-3">
                <button wire:click="$set('showSettingsModal', false)"
                        class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-lg text-sm hover:bg-gray-50">
                    Cancel
                </button>
                <button wire:click="saveSettings()"
                        class="px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700">
                    Save Settings
                </button>
            </div>
        </div>
    </div>
    @endif

    {{-- ── SweetAlert ──────────────────────────────────────────────────────────── --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.10.1/html2pdf.bundle.min.js"></script>
    <script>
        // ── SweetAlert events ────────────────────────────────────────────────
        window.addEventListener('swal:success', e => {
            const d = e.detail[0] ?? e.detail;
            Swal.fire({ icon: 'success', title: d.title, text: d.text })
                .then(() => {
                    window.location.href = d.redirect ?? window.location.pathname;
                });
        });
        window.addEventListener('swal:error', e => {
            Swal.fire({ icon: 'error', title: e.detail[0]?.title ?? e.detail.title, text: e.detail[0]?.text ?? e.detail.text });
        });

        // ── Persist settings to localStorage ────────────────────────────────
        window.addEventListener('rx-settings-saved', e => {
            const data = e.detail[0] || e.detail;
            localStorage.setItem('rx_prescription_settings', JSON.stringify(data));
        });

        // ── Load settings from localStorage on init ──────────────────────────
        document.addEventListener('livewire:initialized', () => {
            const saved = localStorage.getItem('rx_prescription_settings');
            if (saved) {
                try { @this.call('loadSettings', JSON.parse(saved)); } catch(e) {}
            }
        });

        // ── PDF Download ─────────────────────────────────────────────────────
        function downloadPrescriptionPdf() {
            const meta = document.getElementById('rx-pdf-meta');
            const mt   = parseFloat(meta.dataset.mt) || 1;
            const mb   = parseFloat(meta.dataset.mb) || 1;
            const ml   = parseFloat(meta.dataset.ml) || 1;

            const contentHeightPx = Math.floor((11.69 - mt - mb) * 96);
            const page = document.getElementById('prescription-page');
            const sig  = document.getElementById('rx-signature');

            // ── Show print-only, hide no-print ──────────────────────────────
            const printOnly = page.querySelectorAll('.print-only');
            const noPrint   = page.querySelectorAll('.no-print');
            printOnly.forEach(el => el.style.setProperty('display', 'block', 'important'));
            noPrint.forEach(el   => el.style.setProperty('display', 'none',  'important'));

            // ── Signature: push to page bottom ──────────────────────────────
            sig.style.setProperty('display', 'flex', 'important');
            sig.style.justifyContent = 'flex-end';
            sig.style.paddingRight   = '16px';
            sig.style.position       = 'relative';

            const spacer = document.createElement('div');
            spacer.style.flexGrow = '1';
            page.insertBefore(spacer, sig);
            page.style.display       = 'flex';
            page.style.flexDirection = 'column';
            page.style.minHeight     = contentHeightPx + 'px';

            html2pdf().set({
                margin:      [mt, 0.5, mb, ml],
                filename:    'prescription_{{ $patient?->patient_name ?? "patient" }}.pdf',
                image:       { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2, useCORS: true },
                jsPDF:       { unit: 'in', format: 'a4', orientation: 'portrait' }
            }).from(page).save().then(() => {
                // ── Revert everything ────────────────────────────────────────
                printOnly.forEach(el => el.style.removeProperty('display'));
                noPrint.forEach(el   => el.style.removeProperty('display'));
                sig.style.removeProperty('display');
                sig.style.justifyContent = '';
                sig.style.paddingRight   = '';
                sig.style.position       = '';
                spacer.remove();
                page.style.display       = '';
                page.style.flexDirection = '';
                page.style.minHeight     = '';
            });
        }
    </script>

    {{-- ── Print styles ────────────────────────────────────────────────────────── --}}
    <style>
    @media print {
        body * { visibility: hidden; }
        #prescription-page, #prescription-page * { visibility: visible; }
        #prescription-page { position: fixed; top: 0; left: 0; width: 100%; }
        .no-print { display: none !important; }
        .print-only { display: block !important; }
        input[type="date"] { display: none !important; }
        .rx-section-empty { display: none !important; }
        #rx-signature {
            position: fixed;
            bottom: 0.5in;
            right: 0.5in;
            display: block !important;
        }
    }
    @media screen {
        .print-only { display: none; }
    }
    .generating-pdf .rx-section-empty { display: none !important; }
    .generating-pdf .no-print { display: none !important; }
    </style>
</div>
