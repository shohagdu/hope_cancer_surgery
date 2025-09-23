<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h1 class="text-xl font-bold">
                Online Appointment Record
            </h1>
        </div>
        <div class="text-right">
            <button wire:click="toggleAdminView" class="px-4 py-2 bg-green-600 text-white rounded">Add New</button>
        </div>
    </div>
    <hr class="my-3">
    <div class="flex justify-between mb-4">
        <input type="text" wire:model.live.debounce.50ms="search" placeholder="Search by name or mobile" class="border rounded px-3 py-2 w-3/3">
        <select wire:model.live.debounce.500ms="perPage" class="border rounded p-2">
            <option value="5">5 per page</option>
            <option value="10">10 per page</option>
            <option value="20">20 per page</option>
            <option value="50">50 per page</option>
            <option value="100">100 per page</option>
            <option value="500">500 per page</option>
        </select>

    </div>

    <!-- Table -->
    <table class="min-w-full divide-y divide-gray-200">
        <thead class="bg-gray-50">
        <tr class="bg-gray-100">
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Date & Time</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Doctor</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Patient Name</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Mobile</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Gender</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse($appointments as $index => $appointment)
            <tr class="border-t">
                <td class="px-4 py-2">{{ $appointments->firstItem() + $index }}</td>
                <td class="px-4 py-2">{{ $appointment->date_time->format('d M Y, H:i') }}</td>
                <td class="px-4 py-2">{{ $appointment->doctor->name ?? 'N/A' }}</td>
                <td class="px-4 py-2">{{ $appointment->patient_name }}</td>
                <td class="px-4 py-2">{{ $appointment->mobile }}</td>
                <td class="px-4 py-2 capitalize">{{ $appointment->gender }}</td>
                <td class="px-4 py-2">{{ $appointment->patient_type == 1 ? 'New' : 'Old' }}</td>
                <td class="px-4 py-2 space-x-2">
                    <button wire:click="prescription({{ $appointment->id }})" class="text-blue-600">Prescription</button>
                    <button wire:click="edit({{ $appointment->id }})" class="text-blue-600">Edit</button>

                    <button wire:click="delete({{ $appointment->id }})" class="text-red-600">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="px-4 py-2 text-center text-gray-500">No appointments found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">
        {{ $appointments->links() }}
    </div>
    @if($showAdminOnlineAppointment)
    <!-- Modal / Form -->
    <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50 overflow-auto" style="display: {{ $isEditing !== null ? 'flex' : 'none' }}">
        <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl mx-4">
            <h3 class="text-lg font-medium text-gray-900 mb-4">{{ $isEditing ? 'Edit Appointment' : 'Add New Appointment' }}</h3>
            <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Date & Time</label>
                        <input type="datetime-local" wire:model="date_time" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('date_time') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Doctor</label>
                        <select wire:model="doctor_id" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Doctor --</option>
                            @foreach($doctors as $doctor)
                                <option value="{{ $doctor->id }}">{{ $doctor->name }}</option>
                            @endforeach
                        </select>
                        @error('doctor_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Patient Name</label>
                        <input type="text" wire:model="patient_name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('patient_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Mobile</label>
                        <input type="text" wire:model="mobile" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium">Gender</label>
                        <select wire:model="gender" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="">-- Select Gender --</option>
                            <option value="male">Male</option>
                            <option value="female">Female</option>
                            <option value="other">Other</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium">Patient Type</label>
                        <select wire:model="patient_type" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            <option value="1">New</option>
                            <option value="2">Old</option>
                        </select>
                        @error('patient_type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <div class="flex space-x-2 mt-4">
                    <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded shadow">{{ $isEditing ? 'Update' : 'Save' }}</button>
                    <button type="button" wire:click="toggleAdminView" class="px-4 py-2 bg-gray-400 text-white rounded shadow">Close</button>
                </div>
            </form>
        </div>
    </div>
    @endif
</div>


<script>
    window.addEventListener('swal:success', event => {
        Swal.fire({
            icon: 'success',
            title: event.detail[0].title,
            text: event.detail[0].text,
            confirmButtonColor: '#3085d6',
            confirmButtonText: 'OK'
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
