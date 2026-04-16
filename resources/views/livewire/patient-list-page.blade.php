<div class="max-w-7xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <h1 class="text-2xl font-bold text-gray-800">Patient Records</h1>
        <button wire:click="openCreateModal"
                class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
            + New Patient
        </button>
    </div>

    @if(session('success'))
        <div class="mb-4 px-4 py-2 bg-green-50 border border-green-200 text-green-700 rounded-lg text-sm">
            {{ session('success') }}
        </div>
    @endif

    {{-- Search + per-page --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <div class="flex-1">
            <input wire:model.live.debounce.300ms="search"
                   type="text"
                   placeholder="Search by name or mobile..."
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
        </div>
        <select wire:model.live="perPage"
                class="border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
            <option value="15">15 / page</option>
            <option value="30">30 / page</option>
            <option value="50">50 / page</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="bg-white shadow rounded-xl overflow-hidden">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 border-b text-xs uppercase tracking-wide text-gray-500">
                <tr>
                    <th class="px-4 py-3 text-left">#</th>
                    <th class="px-4 py-3 text-left">Name</th>
                    <th class="px-4 py-3 text-left">Age</th>
                    <th class="px-4 py-3 text-left">Mobile</th>
                    <th class="px-4 py-3 text-left">Address</th>
                    <th class="px-4 py-3 text-left">Referred By</th>
                    <th class="px-4 py-3 text-left">Remarks</th>
                    <th class="px-4 py-3 text-left">Last Visit</th>
                    <th class="px-4 py-3 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($patients as $p)
                    <tr class="hover:bg-gray-50 transition">
                        <td class="px-4 py-3 text-gray-400">{{ $patients->firstItem() + $loop->index }}</td>
                        <td class="px-4 py-3 font-semibold text-gray-800">{{ $p->patient_name }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->age ? $p->age . ' Yrs' : '—' }}</td>
                        <td class="px-4 py-3 text-gray-600">{{ $p->mobile ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-[160px] truncate">{{ $p->address ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-[140px] truncate">{{ $p->referer_doctor ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-500 max-w-[140px] truncate">{{ $p->remarks ?: '—' }}</td>
                        <td class="px-4 py-3 text-gray-600 whitespace-nowrap">
                            {{ $p->last_visit_date ? \Carbon\Carbon::parse($p->last_visit_date)->format('d M Y') : '—' }}
                        </td>
                        <td class="px-4 py-3">
                            <div class="flex items-center justify-center gap-2">
                                <a href="{{ route('patient.prescriptions', $p->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-medium transition">
                                    Records
                                </a>
                                <a href="{{ route('prescription.new_patient', $p->id) }}"
                                   class="inline-flex items-center gap-1 px-3 py-1.5 rounded-lg bg-green-50 hover:bg-green-100 text-green-700 text-xs font-medium transition">
                                    Prescribe
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9" class="text-center py-12 text-gray-400">No patients found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-4">
        {{ $patients->links() }}
    </div>

    {{-- Create Patient Modal --}}
    @if($showCreateModal)
    <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm"
         x-data x-on:keydown.escape.window="$wire.showCreateModal = false">
        <div class="bg-white rounded-2xl shadow-xl w-full max-w-lg mx-4">

            {{-- Modal Header --}}
            <div class="flex items-center justify-between px-6 py-4 border-b">
                <h2 class="text-lg font-bold text-gray-800">Add New Patient</h2>
                <button wire:click="$set('showCreateModal', false)"
                        class="text-gray-400 hover:text-gray-600 transition text-xl leading-none">&times;</button>
            </div>

            {{-- Modal Body --}}
            <form wire:submit.prevent="createPatient" class="px-6 py-5 space-y-4">

                <div class="grid grid-cols-2 gap-4">
                    {{-- Name --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Patient Name <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="newPatient.patient_name"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="Full name">
                        @error('newPatient.patient_name')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Age --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Age <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="newPatient.age"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="e.g. 35">
                        @error('newPatient.age')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Gender --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Gender <span class="text-red-500">*</span></label>
                        <select wire:model="newPatient.gender"
                                class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="">— Select —</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                        @error('newPatient.gender')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Mobile --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Mobile <span class="text-red-500">*</span></label>
                        <input type="text" wire:model="newPatient.mobile"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="e.g. 01700000000">
                        @error('newPatient.mobile')
                            <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Address --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Address</label>
                        <input type="text" wire:model="newPatient.address"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="City / Area">
                    </div>

                    {{-- Referred By --}}
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Referred By</label>
                        <input type="text" wire:model="newPatient.referer_doctor"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="Doctor / Person name">
                    </div>

                    {{-- Remarks --}}
                    <div class="col-span-2">
                        <label class="block text-xs font-medium text-gray-600 mb-1">Remarks</label>
                        <input type="text" wire:model="newPatient.remarks"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400"
                               placeholder="Any notes">
                    </div>
                </div>

                {{-- Footer --}}
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" wire:click="$set('showCreateModal', false)"
                            class="px-4 py-2 text-sm text-gray-600 border border-gray-300 rounded-lg hover:bg-gray-50 transition">
                        Cancel
                    </button>
                    <button type="submit"
                            class="px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
                        Save Patient
                    </button>
                </div>
            </form>
        </div>
    </div>
    @endif

</div>
