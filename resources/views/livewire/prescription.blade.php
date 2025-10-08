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
                <ul wire:sortable="updateOrder" class="space-y-2">
                    @foreach ($prescriptionsMedicine as $index => $med)
                        <li wire:sortable.item="{{ $med['id'] }}" wire:key="prescription-{{ $med['id'] }}"
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
                                                <div >{{ $dosage['dosage_morning']??'0' }} + {{ $dosage['dosage_noon']??'0' }} + {{ $dosage['dosage_afternoon']??'0' }}+ {{ $dosage['dosage_night']??'0' }} --- {{ $dosage['meal_time_selected']??'' }} </div>
                                                <div >{{ $dosage['instruction']??NULL }}</div>
                                                <div > {{ $dosage['duration']??NULL }}</div>
                                            </div>
                                        @endforeach
                                    @endif




                                </div>
                                <div class="flex gap-2">
                                    <button wire:click="$set('showEditModal', true)" class="p-2 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600 hover:text-blue-800  rounded">
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
{{--                                            <input wire:model.live="searchTerm"--}}
{{--                                                   type="text"--}}
{{--                                                   placeholder="Type medicine name..."--}}
{{--                                                   class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500">--}}

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
                                     Tab. {{ $name }} {{ $strength }}
                                 </h3>
                                 <button @click="open = false" class="text-gray-400 hover:text-gray-600">✖</button>
                             </div>
                            <div class="mt-4" title="Name: {{ $name }}  {{ $strength }}">
                             <!-- Body -->
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
                            </div>

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
<!--
<div>
    <div id="drug-container">
        <span class='h1'>Rx</span>
        <span class="text-success newDrugBtn" title="add medicine" onclick="openDrugModal()">
        <i class="fa fa-plus-circle"></i>
    </span>
        <ol id='drug-list' class="mt-4">
            <li class="drug-list-item border-bottom" data-id="12060" data-pdid="294870" data-serial="1" title="Move up-down to change serial">
                <div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="full_drug">
                            <span>Supp.</span>
                            <span class="drug_brand"><strong> Napa</strong></span>
                            <span>500 mg</span>
                        </div>
                        <div>
                            <span class="text-primary editDrugBtn" title="edit medicine"><i class="fa fa-edit"></i></span>
                            <span class="text-danger deleteDrugBtn" title="delete medicine" data-id="294870"><i class="fa fa-minus-circle"></i></span>
                        </div>
                    </div>
                    <span>Paracetamol</span><br>

                    <table class="w-100">
                        <tr class="w-100">
                            <td style="width: 40%;">
                                ১ + ০ + ১
                            </td>
                            <td style="width: 40%; text-align:center;">

                            </td>
                            <td style="width: 20%; text-align:center;">
                                ৫ দিন
                            </td>
                        </tr>

                        <div id="additionalAttributesHtml294870" class="d-none">
                            <script>
                                document.querySelectorAll('input[type="checkbox"].checked').forEach(function(checkbox) {
                                    checkbox.checked = true;
                                });
                            </script>            </div>
                    </table>
                </div>

                <div class="d-none" id="drugAttrs294870">
                    <p class="taking_time">1 + 0 + 1</p>
                    <p class="taking_time_custom"></p>
                    <p class="duration">5</p>
                    <p class="duration_unit">দিন</p>
                    <p class="quantity">1</p>
                    <p class="quantity_unit">টা</p>
                    <p class="meal_time"></p>
                    <p class="instruction">১ কাটি জ্বর ১০২°F বা এর বেশি হলে, পায়ু পথে দিবেন</p>
                    <p class="is_default">0</p>
                </div>

                <p class="instruction text-dark mb-0">১ কাটি জ্বর ১০২°F বা এর বেশি হলে, পায়ু পথে দিবেন</p>
            </li>                <li class="drug-list-item border-bottom" data-id="620" data-pdid="294866" data-serial="2" title="Move up-down to change serial">
                <div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="full_drug">
                            <span>Tab.</span>
                            <span class="drug_brand"><strong> Alice</strong></span>
                            <span>6 mg</span>
                        </div>
                        <div>
                            <span class="text-primary editDrugBtn" title="edit medicine"><i class="fa fa-edit"></i></span>
                            <span class="text-danger deleteDrugBtn" title="delete medicine" data-id="294866"><i class="fa fa-minus-circle"></i></span>
                        </div>
                    </div>
                    <span>Ivermectin</span><br>

                    <table class="w-100">
                        <tr class="w-100">
                            <td style="width: 40%;">
                                ০ + ০ + ১
                            </td>
                            <td style="width: 40%; text-align:center;">
                                খাবারের পরে
                            </td>
                            <td style="width: 20%; text-align:center;">

                            </td>
                        </tr>

                        <div id="additionalAttributesHtml294866" class="d-none">
                            <script>
                                document.querySelectorAll('input[type="checkbox"].checked').forEach(function(checkbox) {
                                    checkbox.checked = true;
                                });
                            </script>            </div>
                    </table>
                </div>

                <div class="d-none" id="drugAttrs294866">
                    <p class="taking_time">0 + 0 + 1</p>
                    <p class="taking_time_custom"></p>
                    <p class="duration"></p>
                    <p class="duration_unit"></p>
                    <p class="quantity">1</p>
                    <p class="quantity_unit">টা</p>
                    <p class="meal_time">খাবারের পরে</p>
                    <p class="instruction"></p>
                    <p class="is_default">0</p>
                </div>

                <p class="instruction text-dark mb-0"></p>
            </li>                <li class="drug-list-item border-bottom" data-id="5893" data-pdid="294868" data-serial="3" title="Move up-down to change serial">
                <div>
                    <div class="d-flex justify-content-between align-items-end">
                        <div class="full_drug">
                            <span>Tab.</span>
                            <span class="drug_brand"><strong> Ebasten</strong></span>
                        </div>
                        <div>
                            <span class="text-primary editDrugBtn" title="edit medicine"><i class="fa fa-edit"></i></span>
                            <span class="text-danger deleteDrugBtn" title="delete medicine" data-id="294868"><i class="fa fa-minus-circle"></i></span>
                        </div>
                    </div>
                    <span>Ebastine</span><br>

                    <table class="w-100">
                        <tr class="w-100">
                            <td style="width: 40%;">
                                ০ + ০ + ১
                            </td>
                            <td style="width: 40%; text-align:center;">
                                খাবারের পরে
                            </td>
                            <td style="width: 20%; text-align:center;">
                                ১ মাস
                            </td>
                        </tr>

                        <div id="additionalAttributesHtml294868" class="d-none">
                            <script>
                                document.querySelectorAll('input[type="checkbox"].checked').forEach(function(checkbox) {
                                    checkbox.checked = true;
                                });
                            </script>            </div>
                    </table>
                </div>

                <div class="d-none" id="drugAttrs294868">
                    <p class="taking_time">0 + 0 + 1</p>
                    <p class="taking_time_custom"></p>
                    <p class="duration">30</p>
                    <p class="duration_unit">দিন</p>
                    <p class="quantity">1</p>
                    <p class="quantity_unit">টা</p>
                    <p class="meal_time">খাবারের পরে</p>
                    <p class="instruction"></p>
                    <p class="is_default">0</p>
                </div>

                <p class="instruction text-dark mb-0"></p>
            </li>                    </ol>
    </div>
    <div class="modal fade" id="drugModal" data-bs-keyboard="false" data-bs-backdrop="static">
        <div class="modal-dialog modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title mb-0">Add Medicine</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div id="commonDrugsArea">
                            <p class="text-muted mb-0">Commonly used drugs</p>
                            <div class="d-flex flex-wrap justify-content-start mt-1" style="max-height: 90%; overflow-y:scroll; scrollbar-width: thin;">
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='1934' data-brand='Azithin' data-drugtype='Tablet' data-drugweight='500 mg' data-generic='Azithromycin Dihydrate' data-defaultmealtime='1' data-unit="1">
                                    &#x2022; Azithin
                                    <small>(Tablet, 500 mg)</small>
                                </a>
                                <div id="prescribed_drug_1934" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">টা</span><br />
                                    <span class="instruction"></span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='1' data-brand='Zinc' data-drugtype='Syrup' data-drugweight='4.05 mg/5 ml' data-generic='Zinc Sulfate Monohydrate' data-defaultmealtime='1' data-unit="2">
                                    &#x2022; Zinc
                                    <small>(Syrup, 4.05 mg/5 ml)</small>
                                </a>
                                <div id="prescribed_drug_1" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">চামচ</span><br />
                                    <span class="instruction">2 চামুচ করে ৩ বার</span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='12070' data-brand='Napa One' data-drugtype='Tablet' data-drugweight='1000 mg' data-generic='Paracetamol' data-defaultmealtime='1' data-unit="1">
                                    &#x2022; Napa One
                                    <small>(Tablet, 1000 mg)</small>
                                </a>
                                <div id="prescribed_drug_12070" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">টা</span><br />
                                    <span class="instruction">জ্বর থাকলে</span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='605' data-brand='Algicon' data-drugtype='Oral Suspension' data-drugweight='(500 mg+100 mg)/5 ml' data-generic='Sodium Alginate + Potassium Bicarbonate' data-defaultmealtime='1' data-unit="2">
                                    &#x2022; Algicon
                                    <small>(Oral Suspension, (500 mg+100 mg)/5 ml)</small>
                                </a>
                                <div id="prescribed_drug_605" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">চামচ</span><br />
                                    <span class="instruction"></span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='12012' data-brand='Naafboost' data-drugtype='Syrup' data-drugweight='' data-generic='Multivitamin &amp; Cod Liver Oil' data-defaultmealtime='1' data-unit="2">
                                    &#x2022; Naafboost
                                    <small>(Syrup, )</small>
                                </a>
                                <div id="prescribed_drug_12012" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">চামচ</span><br />
                                    <span class="instruction"></span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='12060' data-brand='Napa' data-drugtype='Suppository' data-drugweight='500 mg' data-generic='Paracetamol' data-defaultmealtime='1' data-unit="1">
                                    &#x2022; Napa
                                    <small>(Suppository, 500 mg)</small>
                                </a>
                                <div id="prescribed_drug_12060" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">টা</span><br />
                                    <span class="instruction">১ কাটি জ্বর ১০২°F বা এর বেশি হলে, পায়ু পথে দিবেন</span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='25520' data-brand='Beximco' data-drugtype='Tab' data-drugweight='250' data-generic='Beximco' data-defaultmealtime='0' data-unit="">
                                    &#x2022; Beximco
                                    <small>(Tab, 250)</small>
                                </a>
                                <div id="prescribed_drug_25520" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">0</span><br />
                                    <span class="quantity"></span><br />
                                    <span class="quantity_unit"></span><br />
                                    <span class="instruction"></span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='12062' data-brand='Napa' data-drugtype='Tablet' data-drugweight='500 mg' data-generic='Paracetamol' data-defaultmealtime='1' data-unit="1">
                                    &#x2022; Napa
                                    <small>(Tablet, 500 mg)</small>
                                </a>
                                <div id="prescribed_drug_12062" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">টা</span><br />
                                    <span class="instruction">জ্বর থাকলে</span><br />
                                </div>
                                <a class="me-1 commonDrugBtn" href="javascript:void(0)" data-id='12226' data-brand='Nebilol' data-drugtype='Tablet' data-drugweight='5 mg' data-generic='Nebivolol Hydrochloride' data-defaultmealtime='1' data-unit="1">
                                    &#x2022; Nebilol
                                    <small>(Tablet, 5 mg)</small>
                                </a>
                                <div id="prescribed_drug_12226" class="d-none">
                                    <span class="taking_time"></span><br />
                                    <span class="taking_time_custom"></span><br />
                                    <span class="take_for_qty"></span><br />
                                    <span class="take_for_unit_id"></span><br />
                                    <span class="meal_time">1</span><br />
                                    <span class="quantity">1</span><br />
                                    <span class="quantity_unit">1</span><br />
                                    <span class="instruction"></span><br />
                                </div>
                            </div>
                        </div>
                        <div id="drugEditArea">
                            <div id="drugInputArea">
                                <div class="d-flex justify-content-between mb-2">
                                    <label class="font-weight-bold">Medicine</label>
                                    <div>
                                        <span class="text-muted">Medicine Missing?</span><a href="javascript:void(0)" class="text-primary" onclick="$('#newMedicineFormArea').toggle();"> Add</a>
                                    </div>
                                </div>

                                <div id="newMedicineFormArea" style="display: none;">
                                    <form id="newMedicineForm">
                                        <div class="row">
                                            <div class="col-md-4 mb-2">
                                                <label class="mb-0">Company</label>
                                                <input type="text" name="company" class="form-control" id="newMedCompany" placeholder="ex: Company / Unknown">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="mb-0">Brand</label>
                                                <input type="text" name="brand" class="form-control" id="newMedBrand">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="mb-0">Generic</label>
                                                <input type="text" name="generic" class="form-control" id="newMedGeneric">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="mb-0">Type</label>
                                                <input type="text" name="type" class="form-control" id="newMedType" placeholder="ex: Tablet / Syrup">
                                            </div>
                                            <div class="col-md-4 mb-2">
                                                <label class="mb-0">Weight</label>
                                                <input type="text" name="weight" class="form-control" id="newMedWeight" placeholder="ex: 250 mg">
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center">
                                                <button type="button" class="btn btn-info btn-sm mt-3 text-white" id="saveNewDrugBtn">Save Medicine</button>
                                            </div>
                                        </div>
                                        <p class="text-danger mb-1 d-none" id="newMedicineError"></p>
                                    </form>
                                    <hr>
                                </div>
                                <input type="text" id="drugInput" class="form-control drugInput mb-3" placeholder="Type medicine name..." autocomplete="off">
                            </div>
                            <div class="pe-3" style="max-height: 650px; overflow-y:scroll; scrollbar-width: thin;">
                                <ol id="msd" class="my-3"></ol>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
-->
