<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-4">
        <h1 class="text-xl font-bold text-gray-800">Medicine Records</h1>
        <button wire:click="openCreate"
                class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded text-sm font-medium">
            + Add Medicine
        </button>
    </div>

    {{-- Filters --}}
    <div class="flex flex-col sm:flex-row gap-3 mb-4">
        <input type="text" wire:model.live.debounce.400ms="search"
               placeholder="Search by name, generic, strength..."
               class="flex-1 border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300" />

        <select wire:model.live="filterStatus"
                class="border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-300">
            <option value="">All Status</option>
            <option value="1">Active</option>
            <option value="0">Inactive</option>
        </select>
    </div>

    {{-- Table --}}
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded text-sm">
            <thead>
                <tr class="bg-gray-100 text-gray-700">
                    <th class="px-4 py-2 border text-left">#</th>
                    <th class="px-4 py-2 border text-left">Name</th>
                    <th class="px-4 py-2 border text-left">Generic</th>
                    <th class="px-4 py-2 border text-left">Strength</th>
                    <th class="px-4 py-2 border text-left">Use For</th>
                    <th class="px-4 py-2 border text-left">DAR</th>
                    <th class="px-4 py-2 border text-center">Status</th>
                    <th class="px-4 py-2 border text-center">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($records as $i => $med)
                    <tr class="hover:bg-gray-50 {{ $med->is_active ? '' : 'opacity-60' }}">
                        <td class="px-4 py-2 border text-gray-500">{{ $records->firstItem() + $i }}</td>
                        <td class="px-4 py-2 border font-medium">{{ $med->name }}</td>
                        <td class="px-4 py-2 border text-gray-600">{{ $med->generic ?? '—' }}</td>
                        <td class="px-4 py-2 border text-gray-600">{{ $med->strength ?? '—' }}</td>
                        <td class="px-4 py-2 border text-gray-600">{{ $med->use_for ?? '—' }}</td>
                        <td class="px-4 py-2 border text-gray-600">{{ $med->DAR ?? '—' }}</td>
                        <td class="px-4 py-2 border text-center">
                            <button wire:click="toggleStatus({{ $med->id }})"
                                    class="px-2 py-0.5 rounded-full text-xs font-semibold
                                           {{ $med->is_active
                                               ? 'bg-green-100 text-green-700 hover:bg-green-200'
                                               : 'bg-red-100 text-red-700 hover:bg-red-200' }}">
                                {{ $med->is_active ? 'Active' : 'Inactive' }}
                            </button>
                        </td>
                        <td class="px-4 py-2 border text-center space-x-1">
                            <button wire:click="openEdit({{ $med->id }})"
                                    class="bg-yellow-400 hover:bg-yellow-500 text-white px-2 py-1 rounded text-xs">
                                Edit
                            </button>
                            <button wire:click="delete({{ $med->id }})"
                                    wire:confirm="Delete '{{ $med->name }}'? This cannot be undone."
                                    class="bg-red-500 hover:bg-red-600 text-white px-2 py-1 rounded text-xs">
                                Delete
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="px-4 py-6 text-center text-gray-400">No medicines found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    {{-- Pagination --}}
    <div class="mt-3">
        {{ $records->links() }}
    </div>

    {{-- Modal --}}
    @if($isShowModal)
        <div class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 px-4">
            <div class="bg-white rounded-lg shadow-xl w-full max-w-lg p-6">
                <h3 class="text-lg font-bold mb-4 text-gray-800">
                    {{ $editId ? 'Edit Medicine' : 'Add New Medicine' }}
                </h3>

                <form wire:submit.prevent="save" class="space-y-3">

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">
                            Medicine Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" wire:model="name" placeholder="e.g. Amoxicillin"
                               class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                        @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Generic Name</label>
                            <input type="text" wire:model="generic" placeholder="e.g. Amoxicillin trihydrate"
                                   class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            @error('generic') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Strength</label>
                            <input type="text" wire:model="strength" placeholder="e.g. 500mg"
                                   class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            @error('strength') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Use For</label>
                            <input type="text" wire:model="use_for" placeholder="e.g. Antibiotic"
                                   class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            @error('use_for') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">DAR No.</label>
                            <input type="text" wire:model="DAR" placeholder="DAR number"
                                   class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none" />
                            @error('DAR') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                        <select wire:model="is_active"
                                class="w-full border rounded px-3 py-2 text-sm focus:ring-2 focus:ring-blue-300 focus:outline-none">
                            <option value="1">Active</option>
                            <option value="0">Inactive</option>
                        </select>
                    </div>

                    <div class="flex gap-2 pt-2">
                        <button type="submit"
                                class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-2 rounded text-sm font-medium">
                            {{ $editId ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" wire:click="$set('isShowModal', false)"
                                class="bg-gray-400 hover:bg-gray-500 text-white px-5 py-2 rounded text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
    window.addEventListener('swal:success', e => {
        Swal.fire({ icon: 'success', title: e.detail.title, text: e.detail.text, timer: 2000, showConfirmButton: false });
    });
    </script>
    @endscript

</div>
