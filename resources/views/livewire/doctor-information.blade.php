<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Doctors</h2>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Doctor</button>
    </div>

    <table class="min-w-full bg-white border rounded">
        <thead>
        <tr class="bg-gray-100">
            <th class="px-4 py-2">#</th>
            <th class="px-4 py-2">Name</th>
            <th class="px-4 py-2">Mobile</th>
            <th class="px-4 py-2">Email</th>
            <th class="px-4 py-2">Status</th>
            <th class="px-4 py-2">Action</th>
        </tr>
        </thead>
        <tbody>
        @forelse($doctors as $doctor)
            <tr>
                <td class="px-4 py-2">{{ $doctor->id }}</td>
                <td class="px-4 py-2">{{ $doctor->name }}</td>
                <td class="px-4 py-2">{{ $doctor->mobile }}</td>
                <td class="px-4 py-2">{{ $doctor->email }}</td>
                <td class="px-4 py-2">
                <span class="px-2 py-1 rounded text-xs {{ $doctor->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                    {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                </span>
                </td>
                <td class="px-4 py-2 space-x-2">
                    <button wire:click="openModal({{ $doctor->id }})" class="text-blue-600">Edit</button>
                    <button wire:click="confirmDelete({{ $doctor->id }})" class="text-red-600">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6" class="px-4 py-2 text-center">No doctors found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $doctors->links() }}</div>

    {{-- Single modal, no duplicates, no inline style toggles --}}
    @if($showModal)
        <div
                class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50 overflow-auto"
                wire:keydown.escape="$set('showModal', false)"
        >
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-2xl mx-4">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">
                        {{ $isEdit ? 'Edit Doctor' : 'Add Doctor' }}
                    </h3>
                    <button class="text-gray-500 hover:text-gray-700" wire:click="$set('showModal', false)">✕</button>
                </div>

                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block">Name</label>
                            <input type="text" wire:model="name" class="w-full border rounded px-2 py-1">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block">Email</label>
                            <input type="email" wire:model="email" class="w-full border rounded px-2 py-1">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Mobile</label>
                            <input type="text" wire:model="mobile" class="w-full border rounded px-2 py-1">
                            @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block">Position</label>
                            <input type="text" wire:model="positions" class="w-full border rounded px-2 py-1">
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block">Picture</label>
                        <input type="file" wire:model="newPicture" class="w-full">
                        @error('newPicture') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

                        {{-- Existing stored picture --}}
                        @if($picture)
                            <img src="{{ Storage::url($picture) }}" class="h-16 mt-2 rounded">
                        @endif

                        {{-- New temp preview --}}
                        @if($newPicture)
                            <img src="{{ $newPicture->temporaryUrl() }}" class="h-16 mt-2 rounded">
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Qualifications</label>
                            <input type="text" wire:model="qualifications" class="w-full border rounded px-2 py-1">
                        </div>
                        <div>
                            <label class="block">Special Training</label>
                            <input type="text" wire:model="special_training" class="w-full border rounded px-2 py-1">
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Display Order</label>
                            <input type="number" wire:model="display_position" class="w-full border rounded px-2 py-1">
                            @error('display_position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block">Active?</label>
                            <select wire:model="is_active" class="w-full border rounded px-2 py-1">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div class="flex gap-2 mt-4">
                        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded shadow">
                            {{ $isEdit ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded shadow">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif
</div>

{{-- SweetAlert JS --}}
<script>
    document.addEventListener('DOMContentLoaded', () => {
        window.addEventListener('swal:success', e => {
            Swal.fire({ icon: 'success', title: e.detail.title, text: e.detail.text });
        });

        window.addEventListener('swal:confirm', e => {
            Swal.fire({
                icon: 'warning',
                title: e.detail.title,
                text: e.detail.text,
                showCancelButton: true,
                confirmButtonText: 'Yes, delete!',
            }).then(result => {
                if (result.isConfirmed) {
                    // Call the Livewire PHP method directly
                @this.delete(e.detail.id);
                }
            });
        });
    });
</script>

