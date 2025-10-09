<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Patient Prescription</h2>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add New</button>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-3 bg-gray-100 p-2 rounded">
        <span>Name: harun</span>
        <span> 17 Years | Male | Date: 23-09-2025</span>
    </div>
    <div class="grid grid-cols-[30%_69%] gap-2 mt-2">
        <div class="bg-gray-100 p-2 rounded">
            <div>
                <div class="grid grid-cols-1">
                    <div >
                       <span class="font-semibold"> Patient Complaints</span>
                        <button wire:click="$set('showModal', true)"
                                class="px-3  ">
                            ➕
                        </button>
                    </div>
                </div>
                <ul >
                    @foreach ($complaints as $index => $item)
                        <li  >
                             <div > <span class="text-gray-700"> {{ $item['label'] }}</span> - <span  class="text-white-700"> {{ $item['Note'] }}</span> <button class="px-1 rounded font-semibold  text-red-500 ">-</button></div>
                        </li>
                    @endforeach
                </ul>
            </div>
            <div class="mt-4" >
                <div class="grid grid-cols-1">
                    <div >
                       <span class="font-semibold"> Patient Complaints</span>
                        <button wire:click="$set('showModal', true)"
                                class="px-3  ">
                            ➕
                        </button>
                    </div>
                </div>
                <ul >
                    @foreach ($complaints as $index => $item)
                        <li  >
                             <div > <span class="text-gray-700"> {{ $item['label'] }}</span> - <span  class="text-white-700"> {{ $item['Note'] }}</span> <button class="px-1 rounded font-semibold  text-red-500 ">-</button></div>
                        </li>
                    @endforeach
                </ul>
            </div>

        </div>
        <div class="bg-red-100 p-1 rounded">
            <div class="w-full mx-auto p-2 bg-white shadow rounded-lg">
                <div class="  flex items-center justify-between mb-2">
                    <span class="text-2xl font-bold">Rx</span>
                    <button wire:click="$set('showModal', true)"
                            class="px-3 py-1 rounded bg-green-500 text-white hover:bg-green-600">
                        ➕ Add
                    </button>
                </div>


                <!-- Drag & Drop List -->
{{--                <ul wire:sortable="updateOrder" class="space-y-2">--}}
{{--                wire:sortable.item="{{ $med['medicine_serial']?? $med['id'] }}" wire:key="prescription-{{ $med['id'] }}"--}}

                <ul  class="space-y-2">
                    @foreach ($prescriptionsMedicine as $index => $med)
                        <li
                            class="border-b pb-21 cursor-move bg-gray-50 p-2 rounded">

                            <div class="flex justify-between items-start">
                                <div>
                                    <span class="">
                                        {{ $index + 1 }}. Tab.
                                        <span class="font-bold text-gray-800">{{ $med['medicine']['name'] }}  {{ $med['medicine']['strength'] }}</span>
                                        <i> [{{ $med['medicine']['generic'] }}]</i>
                                    </span>
                                    @if(!empty($med['dosages']))
                                        @foreach($med['dosages'] as  $dosage)
                                            <div class="grid grid-cols-[30%_50%_17%] gap-4 mt-1">
                                                <div>
                                                    @if($dosage['dosage_afternoon']>0)
                                                        {{ $dosage['dosage_morning']??'0' }} + {{ $dosage['dosage_noon']??'0' }} + {{ $dosage['dosage_afternoon']??'0' }}+ {{ $dosage['dosage_night']??'0' }}
                                                    @else
                                                        {{ $dosage['dosage_morning']??'0' }} + {{ $dosage['dosage_noon']??'0' }} + {{ $dosage['dosage_night']??'0' }}
                                                    @endif
                                                </div>
                                                <div>
                                                    --- {{ $dosage['meal_time_selected']??'' }}
                                                </div>
                                                <div > {{ $dosage['duration']??NULL }}</div>
                                            </div>
                                            <div >{{ $dosage['instruction']??NULL }}</div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="openEditModal({{ $index }})" class="p-2 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 hover:text-blue-800">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                                        </svg>
                                    </button>
                                    <button wire:click="remove('{{ $med['id'] }}')"
                                            class="p-1 rounded-full bg-red-100 hover:bg-red-200 text-red-600">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                    </button>

                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Modal -->
                <div x-data="{ open: @entangle('showModal') }">
                    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                            <div class="bg-white rounded-lg w-full max-w-7xl h-[90vh] flex flex-col shadow-2xl">
                                <!-- Modal Header -->
                                <div class="flex items-center justify-between p-4 border-b">
                                    <h2 class="text-xl font-semibold text-gray-900">Add Medicine</h2>
                                    <button @click="open = false" class="text-gray-400 hover:text-gray-600 text-2xl">
                                        ✕
                                    </button>
                                </div>

                                <!-- Modal Body -->
                                <div class="flex flex-1 overflow-hidden">
                                    <!-- Left Sidebar - Commonly Used Drugs -->
                                    <div class="w-80 bg-gray-50 border-r flex flex-col">
                                        <div class="p-2 border-b">
                                            <h3 class="font-medium text-gray-900">Commonly used drugs</h3>
                                        </div>
                                        <div class="flex-1 overflow-y-auto p-4 space-y-2">

                                            @foreach($commonDrugs as $drug)
                                                <button wire:click="addMedicine({{ json_encode($drug) }})"
                                                        class="text-blue-600 hover:text-blue-800 hover:underline text-left block">
                                                    {{ $drug['name'] }}  ({{ $drug['type'] }}{{ $drug['strength'] ? ', ' . $drug['strength'] : '' }})
                                                </button>
                                            @endforeach
                                        </div>
                                    </div>

                                    <!-- Main Content Area -->
                                    <div class="flex-1 flex flex-col">
                                        <!-- Medicine Search -->
                                        <div class="p-4 border-b">
                                            <div class="flex items-center justify-between ">
                                                <h3 class="font-medium text-gray-900">Medicine</h3>
                                                <div class="text-sm">
                                                    <span class="text-gray-600">Medicine Missing?</span>
                                                    <button class="text-blue-600 hover:underline ml-1">Add</button>
                                                </div>
                                            </div>
                                            <div class="relative mb-1 mt-1">
                                                <input
                                                        wire:model.live="searchTerm"
                                                        type="text"
                                                        placeholder="Type medicine name..."
                                                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">

                                                @if(!empty($medicineSuggestions))
                                                    <ul class="absolute left-0 w-full z-50 bg-white border border-gray-200 rounded-md mt-1 max-h-60 overflow-y-auto shadow-md">
                                                        @foreach($medicineSuggestions as $med)
                                                            <li wire:click="selectMedicine({{ $med->id }})"
                                                                class="px-4 py-2 cursor-pointer hover:bg-blue-100">
                                                                <span class="font-bold text-gray-800">{{ $med['name'] }}  ({{ $med['strength'] }})</span>
                                                                <i> [{{ $med['generic'] }}]</i>
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @endif
                                            </div>


                                        </div>

                                        <!-- Selected Medicines List -->
                                        <div class="flex-1 overflow-y-auto p-4">

                                            @foreach($selectedMedicines as $index => $medicine)
                                                <div class="mb-2 p-2 border border-gray-200 rounded-lg bg-white shadow-sm">
                                                    <div class="flex items-start justify-between">
                                                        <div class="flex-1">
                                                            <!-- Medicine Header -->
                                                            <div class="grid grid-cols-[95%,5%] gap-1 ">
                                                                <div class="flex items-center mb-3">
                                                                    <span class="text-gray-600 mr-2">{{ $loop->iteration }}.</span>
                                                                    <span class="font-medium">{{ $medicine['medicine']['dosage_id'] }}. {{ $medicine['medicine']['name'] }}</span>
                                                                    @if($medicine['medicine']['strength'])
                                                                        <span class="text-gray-600 ml-2">{{ $medicine['medicine']['strength'] }}</span>
                                                                    @endif
                                                                    @if($medicine['medicine']['generic'])
                                                                        <div class="text-gray-600 ml-2">[{{ $medicine['medicine']['generic'] }}]</div>
                                                                    @endif
                                                                </div>
                                                                <div>
{{--                                                                    <button class="p-2 text-blue-600 hover:text-blue-800 hover:bg-blue-50 rounded">--}}
{{--                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>--}}
{{--                                                                        </svg>--}}
{{--                                                                    </button>--}}
                                                                    <button wire:click="removeMedicine({{ $index }})"
                                                                            class="p-2 text-red-600 hover:text-red-800 hover:bg-red-50 rounded">
                                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                                                        </svg>
                                                                    </button>
                                                                </div>
                                                            </div>

                                                            <!-- Instructions Grid -->
                                                            <div class="grid grid-cols-[35%,20%,43%] gap-2">
                                                                <!-- Dosage Checkboxes -->
                                                                <div >
                                                                    <div class="flex items-center space-x-2 mb-1">
                                                                        @foreach(['morning' => 'সকাল', 'noon' => 'দুপুর', 'night' => 'রাত', 'before_sleep' => 'বিকাল'] as $key => $label)
                                                                            <div class="flex items-center space-x-2">
                                                                                <input type="checkbox" id="{{ $key }}_{{ $index }}"
                                                                                       {{ isset($medicine['dosage'][$key]) && $medicine['dosage'][$key] > 0 ? 'checked' : '' }}
                                                                                       class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                                                <label for="{{ $key }}_{{ $index }}" class="text-sm">{{ $label }}</label>
                                                                            </div>
                                                                        @endforeach
                                                                    </div>
                                                                    <div class="flex items-center space-x-2">
                                                                        <div class="flex">
                                                                            @foreach(['morning', 'noon', 'night', 'before_sleep'] as $key)
                                                                                <input wire:model.live="selectedMedicines.{{ $index }}.dosage.{{ $key }}"
                                                                                       wire:change="updateInstructions({{ $index }})"
                                                                                       type="text" min="0" max="10"
                                                                                       class="w-12 px-2 py-1 text-center border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                                                                              {{ $loop->first ? 'rounded-l-md' : '' }}
                                                                                              {{ $loop->last ? 'rounded-r-md' : 'border-r-0' }}">
                                                                            @endforeach
                                                                        </div>

                                                                        <select class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                            <option value="" selected>N/A</option>
                                                                            @foreach(['চামচ', 'ফোঁটা', 'মিলি', 'পাফস', 'ইউনিট'] as $option)
                                                                                <option value="{{ $option }}">{{ $option }}</option>
                                                                            @endforeach
                                                                        </select>
                                                                    </div>
                                                                    <div>
                                                                        <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">+ Add more</button>
                                                                    </div>

                                                                </div>

                                                                <!-- Timing Dropdown -->
                                                                <div>
                                                                    <select wire:model.live="selectedMedicines.{{ $index }}.timing"
                                                                            class="w-full py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                                        @foreach(['খাবারের পরে', 'খাবারের আগে', 'খাবারের সাথে'] as $timing)
                                                                            <option value="{{ $timing }}">{{ $timing }}</option>
                                                                        @endforeach
                                                                    </select>
                                                                    <label class="flex items-center gap-1 text-sm text-gray-700 whitespace-nowrap mt-1">
                                                                        <input type="checkbox"

                                                                               class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                                        Custom Instruction
                                                                    </label>
                                                                </div>

                                                                <!-- Take For and Duration -->
                                                                <div class=" p-2 border border-gray-200 ">
                                                                    <!-- Take For Section -->
                                                                    <div class="flex items-center justify-between mb-2">

                                                                        <div class="flex items-center gap-2">
                                                                            <span class="text-sm font-semibold text-gray-700">Take For:</span>
                                                                            @foreach([1, 5, 7, 14, 30] as $days)
                                                                                <label for="take_for_{{ $days }}_{{ $index }}" class="flex items-center gap-1 text-xs font-medium text-gray-600">
                                                                                    <input wire:model.live="selectedMedicines.{{ $index }}.take_for.{{ $days }}"
                                                                                           wire:change="updateTakeFor({{ $index }}, {{ $days }}, $event.target.checked)"
                                                                                           type="checkbox"
                                                                                           id="take_for_{{ $days }}_{{ $index }}"
                                                                                           class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                                                    {{ $days }}
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>

                                                                    <!-- Duration Section -->
                                                                    <div class="grid grid-cols-[22%,78%] gap-2 items-center">
                                                                        <input type="text"
                                                                               wire:model.live="selectedMedicines.{{ $index }}.duration"
                                                                               placeholder="Duration"
                                                                               class="w-full px-2 py-1 text-center border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                                                        <div class="flex items-center gap-2">
                                                                            @foreach(['দিন', 'মাস', 'চলবে', 'N/A'] as $type)
                                                                                <label class="flex items-center gap-1 text-sm text-gray-700">
                                                                                    <input wire:model.live="selectedMedicines.{{ $index }}.duration_type"
                                                                                           type="radio"
                                                                                           value="{{ $type }}"
                                                                                           class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                                                    {{ $type }}
                                                                                </label>
                                                                            @endforeach
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="mt-1"  style="display: none">
                                                                <input type="text" wire:model.live="selectedMedicines.{{ $index }}.custom_instruction"
                                                                       placeholder="Instruction or custom time"
                                                                       class="rounded border border-gray-300 px-2 py-1 w-full text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                            </div>



                                                        </div>


                                                    </div>
                                                </div>
                                            @endforeach

                                            @if(empty($selectedMedicines))
                                                <div class="text-center py-8 text-gray-500">
                                                    No medicines added yet. Select from the commonly used drugs or search for a medicine.
                                                </div>
                                            @endif
                                        </div>

                                        <!-- Modal Footer -->
                                        <div class="border-t p-4 bg-gray-50">
                                            <div class="flex justify-end space-x-3">
                                                <button wire:click="saveMedicine()" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                    Save Medicines
                                                </button>
                                                <button @click="open = false" class="px-4 py-2 text-gray-700 bg-white border border-gray-300 rounded-md hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-blue-500">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div x-data="{ open: @entangle('showEditModal') }">
                     <div x-show="open"
                          class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
                          x-cloak>
                         <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6">

                             <!-- Header -->
                             <div class="flex justify-between items-center border-b pb-3">
                                 <h3 class="text-lg font-semibold">
                                     Tab. {{ $prescriptionsMedicine[$currentMedicineIndex]['medicine']['name']??null }}
                                 </h3>
                                 <button @click="open = false" class="text-gray-400 hover:text-gray-600">✖</button>
                             </div>

                             @if($currentMedicineIndex !== null)
                                 @php
                                     $medicine = $prescriptionsMedicine[$currentMedicineIndex];
                                     $dosage = $medicine['dosages'][0] ?? [];
//                                     [id] => 1
//                                    [patient_medicine_id] => 1
//                                    [dosage_morning] => 1
//                                    [dosage_noon] => 0
//                                    [dosage_afternoon] => 1
//                                    [dosage_night] => 0
//                                    [drug_taking_quantity_unit] =>
//                                    [meal_time_select] =>
//                                    [duration] =>
//                                    [duration_unit_check] =>
                                 @endphp

                                 <div class="mt-4" >
                             <!-- Body -->
                                     <div class="grid grid-cols-[35%,20%,43%] gap-2">
                                         <!-- Dosage Checkboxes -->
                                         <div >
                                             <div class="flex items-center space-x-2 mb-1">
                                                 @foreach(['morning' => 'সকাল', 'noon' => 'দুপুর', 'night' => 'রাত', 'before_sleep' => 'বিকাল'] as $key => $label)
                                                     <div class="flex items-center space-x-2">
                                                         <input type="checkbox" id="{{ $key }}_{{ $index }}"
                                                                @if($key=='morning' && $dosage['dosage_morning']>0)
                                                                    {{ 'checked' }}
                                                                @elseif($key=='noon' && $dosage['dosage_noon']>0)
                                                                    {{ 'checked' }}
                                                                @elseif($key=='before_sleep' && $dosage['dosage_afternoon']>0)
                                                                    {{ 'checked' }}
                                                                @elseif($key=='night' && $dosage['dosage_night']>0)
                                                                    {{ 'checked' }}
                                                                @else

                                                                @endif

                                                                class="w-4 h-4 text-blue-600 rounded border-gray-300 focus:ring-blue-500">
                                                         <label for="{{ $key }}_{{ $index }}" class="text-sm">{{ $label }}</label>
                                                     </div>
                                                 @endforeach
                                             </div>
                                             <div class="flex items-center space-x-2">
                                                 <div class="flex">
                                                     @foreach(['morning', 'noon', 'night', 'before_sleep'] as $key)
                                                         <input wire:model.live="selectedMedicines.{{ $index }}.dosage.{{ $key }}"
                                                                wire:change="updateInstructions({{ $index }})"
                                                                type="text" min="0" max="10"
                                                                class="w-12 px-2 py-1 text-center border border-gray-300 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                                                                                                      {{ $loop->first ? 'rounded-l-md' : '' }}
                                                                                                      {{ $loop->last ? 'rounded-r-md' : 'border-r-0' }}">
                                                     @endforeach
                                                 </div>

                                                 <select class="px-3 py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                     <option value="" selected>N/A</option>
                                                     @foreach(['চামচ', 'ফোঁটা', 'মিলি', 'পাফস', 'ইউনিট'] as $option)
                                                         <option value="{{ $option }}">{{ $option }}</option>
                                                     @endforeach
                                                 </select>
                                             </div>
                                             <div>
                                                 <button class="text-blue-600 hover:text-blue-800 text-sm font-medium">+ Add more</button>
                                             </div>

                                         </div>

                                         <!-- Timing Dropdown -->
                                         <div>
                                             <select wire:model.live="selectedMedicines.{{ $index }}.timing"
                                                     class="w-full py-1 border border-gray-300 rounded text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                                                 @foreach(['খাবারের পরে', 'খাবারের আগে', 'খাবারের সাথে'] as $timing)
                                                     <option value="{{ $timing }}">{{ $timing }}</option>
                                                 @endforeach
                                             </select>
                                             <label class="flex items-center gap-1 text-sm text-gray-700 whitespace-nowrap mt-1">
                                                 <input type="checkbox"

                                                        class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                 Custom Instruction
                                             </label>
                                         </div>

                                         <!-- Take For and Duration -->
                                         <div class=" p-2 border border-gray-200 ">
                                             <!-- Take For Section -->
                                             <div class="flex items-center justify-between mb-2">

                                                 <div class="flex items-center gap-2">
                                                     <span class="text-sm font-semibold text-gray-700">Take For:</span>
                                                     @foreach([1, 5, 7, 14, 30] as $days)
                                                         <label for="take_for_{{ $days }}_{{ $index }}" class="flex items-center gap-1 text-xs font-medium text-gray-600">
                                                             <input wire:model.live="selectedMedicines.{{ $index }}.take_for.{{ $days }}"
                                                                    wire:change="updateTakeFor({{ $index }}, {{ $days }}, $event.target.checked)"
                                                                    type="checkbox"
                                                                    id="take_for_{{ $days }}_{{ $index }}"
                                                                    class="w-4 h-4 text-blue-600 border-gray-300 rounded focus:ring-blue-500">
                                                             {{ $days }}
                                                         </label>
                                                     @endforeach
                                                 </div>
                                             </div>

                                             <!-- Duration Section -->
                                             <div class="grid grid-cols-[22%,78%] gap-2 items-center">
                                                 <input type="text"
                                                        wire:model.live="selectedMedicines.{{ $index }}.duration"
                                                        placeholder="Duration"
                                                        class="w-full px-2 py-1 text-center border border-gray-300 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">

                                                 <div class="flex items-center gap-2">
                                                     @foreach(['দিন', 'মাস', 'চলবে', 'N/A'] as $type)
                                                         <label class="flex items-center gap-1 text-sm text-gray-700">
                                                             <input wire:model.live="selectedMedicines.{{ $index }}.duration_type"
                                                                    type="radio"
                                                                    value="{{ $type }}"
                                                                    class="w-4 h-4 text-blue-600 border-gray-300 focus:ring-blue-500">
                                                             {{ $type }}
                                                         </label>
                                                     @endforeach
                                                 </div>
                                             </div>
                                         </div>
                                     </div>
                                </div>
                             @endif

                             <!-- Footer -->
                             <div class="flex justify-end gap-2 mt-6">
                                 <button @click="open = false" class="px-4 py-2 bg-gray-200 rounded hover:bg-gray-300">Close</button>
                                 <button wire:click="save" class="px-4 py-2 bg-green-600 text-white rounded hover:bg-green-700">
                                     {{ isset($editId) ? 'Update' : 'Add' }}
                                 </button>
                             </div>
                         </div>
                     </div>
                </div>

            </div>


{{--            <div class="bg-green-100 p-2 rounded">--}}
{{--                <label class="block">Other</label>--}}
{{--            </div>--}}
        </div>
</div>
<script>
    window.addEventListener('swal:success', event => {
        Swal.fire({
            icon: 'success',
            title: event.detail[0].title,
            text: event.detail[0].text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
        }).then((result) => {
            console.log(result);
            if (result.isConfirmed) {
                // Close modal (assuming Bootstrap 5 modal)
                const modalEl = document.getElementById('prescriptionModal');
                if (modalEl) {
                    const modal = bootstrap.Modal.getInstance(modalEl) || new bootstrap.Modal(modalEl);
                    modal.hide();
                }

                // Option 1: Reload page
                location.reload();

                // Option 2: Refresh Livewire component dynamically
                // Livewire.emit('refreshPrescriptions');
            }
        });
    });

    window.addEventListener('swal:error', event => {
        Swal.fire({
            icon: 'error',
            title: event.detail[0].title,
            text: event.detail[0].text,
            confirmButtonColor: '#d33',
            confirmButtonText: 'OK'
        });
    });
</script>
