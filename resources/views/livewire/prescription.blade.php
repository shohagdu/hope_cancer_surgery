<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Patient Prescription</h2>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add New</button>
    </div>
    <div class="grid grid-cols-2 gap-4 mt-3 bg-gray-100 p-2 rounded">
        <span>Name: harun</span>
        <span> 17 Years | Male | Date: 23-09-2025</span>
    </div>
    <div class="grid grid-cols-[30%_50%_17%] gap-4 mt-3">
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
            <div class="max-w-3xl mx-auto p-6 bg-white shadow rounded-lg">
                <div class="  flex items-center justify-between mb-6">
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
                                        <span class="font-bold text-gray-800">{{ $med['name'] }}  {{ $med['strength'] }}</span>
                                        <i> [{{ $med['generic'] }}]</i>
                                    </span>
                                    <div class="grid grid-cols-[30%_50%_17%] gap-4 mt-1">
                                        <div >{{ $med['dose'] }}</div>
                                        <div >{{ $med['instruction'] }}</div>
                                        <div > {{ $med['duration'] }}</div>
                                    </div>

                                </div>
                                <div class="flex gap-2">
                                    <button class="p-1 rounded-full bg-blue-100 hover:bg-blue-200 text-blue-600" wire:click="$set('showEditModal', true)">✏️</button>
                                    <button wire:click="remove('{{ $med['id'] }}')"
                                            class="p-1 rounded-full bg-red-100 hover:bg-red-200 text-red-600">❌</button>
                                </div>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <!-- Modal -->
                <div x-data="{ open: @entangle('showModal') }">
                    <div x-show="open" class="fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                        <div class="bg-white w-full max-w-lg p-6 rounded-lg shadow">
                            <h3 class="text-lg font-semibold mb-4">Add Prescription</h3>

                            <form wire:submit.prevent="addPrescription" class="space-y-4">
                                <div>
                                    <label class="block text-sm font-medium">Medicine Name</label>
                                    <input type="text" wire:model="name" class="w-full border rounded p-2">
                                    @error('name') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Strength</label>
                                    <input type="text" wire:model="strength" class="w-full border rounded p-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Generic</label>
                                    <input type="text" wire:model="generic" class="w-full border rounded p-2">
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Dose</label>
                                    <input type="text" wire:model="dose" class="w-full border rounded p-2">
                                    @error('dose') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Instruction</label>
                                    <input type="text" wire:model="instruction" class="w-full border rounded p-2">
                                    @error('instruction') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>
                                <div>
                                    <label class="block text-sm font-medium">Duration</label>
                                    <input type="text" wire:model="duration" class="w-full border rounded p-2">
                                    @error('duration') <span class="text-red-500 text-xs">{{ $message }}</span>@enderror
                                </div>

                                <div class="flex justify-end gap-2 mt-4">
                                    <button type="button" @click="open = false"
                                            class="px-4 py-2 rounded bg-gray-200 hover:bg-gray-300">
                                        Cancel
                                    </button>
                                    <button type="submit"
                                            class="px-4 py-2 rounded bg-green-500 text-white hover:bg-green-600">
                                        Save
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                 <div x-data="{ open: @entangle('showEditModal') }">
                     <div x-show="open"
                          class="fixed inset-0 bg-gray-900 bg-opacity-50 flex items-center justify-center z-50"
                          x-cloak>
                         <div class="bg-white rounded-lg shadow-lg w-full max-w-3xl p-6">

                             <!-- Header -->
                             <div class="flex justify-between items-center border-b pb-3">
                                 <h3 class="text-lg font-semibold">
                                     Tab. {{ $name }} {{ $strength }}
                                 </h3>
                                 <button @click="open = false" class="text-gray-400 hover:text-gray-600">✖</button>
                             </div>

                             <!-- Body -->
                             <div class="mt-4 space-y-4">
                                 <!-- Time of day -->
                                 <div class="flex items-center gap-4">
                                     <label><input type="checkbox" wire:model="morning" class="mr-1"> সকাল</label>
                                     <label><input type="checkbox" wire:model="noon" class="mr-1"> দুপুর</label>
                                     <label><input type="checkbox" wire:model="evening" class="mr-1"> বিকাল</label>
                                     <label><input type="checkbox" wire:model="night" class="mr-1"> রাত</label>
                                 </div>

                                 <!-- Dose inputs -->
                                 <div class="flex gap-2">
                                     <input type="number" wire:model="dose_morning" placeholder="সকাল" class="w-16 border rounded p-1">
                                     <input type="number" wire:model="dose_noon" placeholder="দুপুর" class="w-16 border rounded p-1">
                                     <input type="number" wire:model="dose_evening" placeholder="বিকাল" class="w-16 border rounded p-1">
                                     <input type="number" wire:model="dose_night" placeholder="রাত" class="w-16 border rounded p-1">
                                 </div>

                                 <!-- Instruction dropdown -->
                                 <div>
                                     <select wire:model="instruction" class="border rounded p-2 w-full">
                                         <option value="">Select Instruction</option>
                                         <option value="খাবারের আগে">খাবারের আগে</option>
                                         <option value="খাবারের পরে">খাবারের পরে</option>
                                         <option value="খাবারের ৩০ মিনিট আগে">খাবারের ৩০ মিনিট আগে</option>
                                     </select>
                                 </div>

                                 <!-- Duration -->
                                 <div class="flex items-center gap-2">
                                     <span>Take For:</span>
                                     @foreach([1,5,7,14,30] as $day)
                                         <label><input type="radio" wire:model="duration" value="{{ $day }}" class="mr-1"> {{ $day }}</label>
                                     @endforeach
                                     <label><input type="radio" wire:model="duration" value="custom" class="mr-1"> Custom</label>
                                     @if($duration === "custom")
                                         <input type="number" wire:model="custom_duration" class="w-20 border rounded p-1">
                                         <select wire:model="custom_unit" class="border rounded p-1">
                                             <option value="দিন">দিন</option>
                                             <option value="মাস">মাস</option>
                                         </select>
                                     @endif
                                 </div>

                                 <!-- Custom instruction -->
                                 <div>
                    <textarea wire:model="custom_instruction" class="border rounded p-2 w-full"
                              placeholder="Instruction or custom time"></textarea>
                                 </div>

                                 <!-- Default setting -->
                                 <div>
                                     <label>
                                         <input type="checkbox" wire:model="set_default" class="mr-1">
                                         Set as default settings for this medicine
                                     </label>
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



        </div>
        <div class="bg-green-100 p-2 rounded">
            <label class="block">Other</label>
        </div>
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
