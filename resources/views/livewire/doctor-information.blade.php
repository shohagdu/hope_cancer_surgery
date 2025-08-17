<div>
    <div class="bg-white p-6 rounded-lg shadow-md max-w-3xl mx-auto">
        <h2 class="text-xl font-bold mb-4">
            {{ $doctor_id ? 'Edit Doctor' : 'Add Doctor' }}
        </h2>

        <form wire:submit.prevent="save" class="space-y-4">
            <!-- Name -->
            <div>
                <label class="block text-gray-700 font-medium">Name *</label>
                <input type="text" wire:model="name" class="w-full border rounded p-2" />
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Picture -->
            <div>
                <label class="block text-gray-700 font-medium">Picture</label>
                <input type="file" wire:model="picture" class="w-full border rounded p-2" />
                @if($picture)
                    <img src="{{ $picture->temporaryUrl() }}" class="h-20 mt-2 rounded" />
                @endif
                @error('picture') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Qualifications -->
            <div>
                <label class="block text-gray-700 font-medium">Qualifications</label>
                <input type="text" wire:model="qualifications" class="w-full border rounded p-2" />
            </div>

            <!-- Special Training -->
            <div>
                <label class="block text-gray-700 font-medium">Special Training</label>
                <input type="text" wire:model="special_training" class="w-full border rounded p-2" />
            </div>

            <!-- Positions -->
            <div>
                <label class="block text-gray-700 font-medium">Position</label>
                <input type="text" wire:model="positions" class="w-full border rounded p-2" />
            </div>

            <!-- Mobile + Email -->
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-gray-700 font-medium">Mobile</label>
                    <input type="text" wire:model="mobile" class="w-full border rounded p-2" />
                </div>
                <div>
                    <label class="block text-gray-700 font-medium">Email</label>
                    <input type="email" wire:model="email" class="w-full border rounded p-2" />
                </div>
            </div>

            <!-- Social Links -->
            <div class="grid grid-cols-2 gap-4">
                <input type="text" wire:model="facebook" placeholder="Facebook URL" class="w-full border rounded p-2" />
                <input type="text" wire:model="twitter" placeholder="Twitter URL" class="w-full border rounded p-2" />
                <input type="text" wire:model="instagram" placeholder="Instagram URL" class="w-full border rounded p-2" />
                <input type="text" wire:model="linkedin" placeholder="LinkedIn URL" class="w-full border rounded p-2" />
                <input type="text" wire:model="tiktok" placeholder="TikTok URL" class="w-full border rounded p-2" />
                <input type="text" wire:model="youtube" placeholder="YouTube URL" class="w-full border rounded p-2" />
            </div>

            <!-- Display Position -->
            <div>
                <label class="block text-gray-700 font-medium">Display Position</label>
                <input type="number" wire:model="display_position" class="w-full border rounded p-2" />
            </div>

            <!-- Active Toggle -->
            <div class="flex items-center space-x-2">
                <input type="checkbox" wire:model="is_active" class="h-4 w-4 text-blue-600 border-gray-300 rounded" />
                <span class="text-gray-700">Active</span>
            </div>

            <!-- Submit -->
            <div>
                <button type="submit"
                        class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 transition">
                    {{ $doctor_id ? 'Update' : 'Save' }}
                </button>
            </div>
        </form>
    </div>

</div>
