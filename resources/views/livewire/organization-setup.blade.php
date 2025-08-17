<div class="p-6">

    <!-- Top controls -->
    <div class="flex justify-between mb-4">
        <div class="flex space-x-2">
            <input type="text" wire:model.debounce.500ms="search" placeholder="Search..." class="border rounded p-2" />
            <select wire:model="perPage" class="border rounded p-2">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
            </select>
        </div>
        <button wire:click="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Company</button>
    </div>

    <!-- Table -->
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border rounded">
            <thead>
            <tr class="bg-gray-100">
                <th class="px-4 py-2 border">#</th>
                <th class="px-4 py-2 border">Name</th>
                <th class="px-4 py-2 border">Slug</th>
                <th class="px-4 py-2 border">Logo</th>
                <th class="px-4 py-2 border">Actions</th>
            </tr>
            </thead>
            <tbody>
            @forelse($companies as $index => $company)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-2 border">{{ $companies->firstItem() + $index }}</td>
                    <td class="px-4 py-2 border">{{ $company->name }}</td>
                    <td class="px-4 py-2 border">{{ $company->slug }}</td>
                    <td class="px-4 py-2 border">
                        @if($company->logo)
                            <img src="{{ asset('storage/'.$company->logo) }}" class="h-12 rounded">
                        @endif
                    </td>
                    <td class="px-4 py-2 border space-x-2">
                        <button wire:click="openModal({{ $company->id }})" class="bg-green-500 text-white px-2 py-1 rounded">Edit</button>
                        <button wire:click="delete({{ $company->id }})" class="bg-red-500 text-white px-2 py-1 rounded">Delete</button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="px-4 py-2 text-center">No records found</td>
                </tr>
            @endforelse
            </tbody>
        </table>
        <div class="mt-2">
            {{ $companies->links() }}
        </div>
    </div>

    <!-- Modal Form -->
    @if($isShowModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-3xl mx-4">
                <h3 class="text-lg font-bold mb-4">{{ $company_id ? 'Edit Company' : 'Add Company' }}</h3>
                <form wire:submit.prevent="save" class="space-y-4">

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium">Name</label>
                            <input type="text" wire:model="name" class="w-full border rounded p-2" />
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium">Slug</label>
                            <input type="text" wire:model="slug" class="w-full border rounded p-2" />
                            @error('slug') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label class="block text-gray-700 font-medium">Logo</label>
                        <input type="file" wire:model="logo_local" class="w-full border rounded p-2" />
                        @if($logo_local)
                            <img src="{{ $logo_local->temporaryUrl() }}" class="h-16 mt-2 rounded">
                        @elseif($logo)
                            <img src="{{ asset('storage/'.$logo) }}" class="h-16 mt-2 rounded">
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <input type="text" wire:model="address" placeholder="Address" class="w-full border rounded p-2" />
                        <input type="text" wire:model="mobile" placeholder="Mobile" class="w-full border rounded p-2" />
                        <input type="email" wire:model="email" placeholder="Email" class="w-full border rounded p-2" />
                        <input type="text" wire:model="fb" placeholder="Facebook URL" class="w-full border rounded p-2" />
                        <input type="text" wire:model="twitter" placeholder="Twitter URL" class="w-full border rounded p-2" />
                        <input type="text" wire:model="linkedin" placeholder="LinkedIn URL" class="w-full border rounded p-2" />
                        <input type="text" wire:model="tiktok" placeholder="TikTok URL" class="w-full border rounded p-2" />
                        <input type="text" wire:model="youtube" placeholder="YouTube URL" class="w-full border rounded p-2" />
                    </div>

                    <div class="flex space-x-2">
                        <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded">
                            {{ $company_id ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" wire:click="$set('isShowModal', false)" class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

</div>
