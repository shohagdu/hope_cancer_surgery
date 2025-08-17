<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
        <div>
            <h1 class="text-xl font-bold">
                Content Manager
            </h1>
        </div>
        <div class="text-right">
            <button
                    wire:click="createContent"
                    class="bg-blue-500 text-white px-3 pt-1 pb-2 rounded"
            >
              Add New
            </button>
        </div>
    </div>
    @if($isShowContentModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50 overflow-y-auto">
            <div class="bg-white rounded-lg shadow-lg w-full max-w-4xl mx-4 max-h-[90vh] flex flex-col">

                <!-- Modal Header -->
                <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center sticky top-0 bg-white z-10">
                    <h3 class="text-lg font-medium text-gray-900">
                        {{ $isEditing ? 'Edit Content' : 'Add New Content' }}
                    </h3>
                    <button wire:click="closeContentForm" class="text-gray-500 hover:text-gray-700">&times;</button>
                </div>
                <div class="p-6 overflow-y-auto flex-1">
                <form wire:submit.prevent="{{ $isEditing ? 'update' : 'store' }}" class="space-y-4">
                    <!-- Type -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Content Type</label>
                            <select wire:model="type" wire:change="changeContentType" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Select Type --</option>
                                @foreach($contentTypes as $key => $label)
                                    <option value="{{ $key }}">{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('type') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Icon</label>
                            <input type="text" wire:model="icon" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. fa-solid fa-heart">
                        </div>
                    </div>

                    <!-- Icon -->


                    <!-- Title -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Title</label>
                        <input type="text" wire:model="title" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter Title">
                        @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Short Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Short Description</label>
                        <textarea wire:model="short_description" rows="2" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter Short Description"></textarea>
                    </div>

                    <!-- Full Description -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea wire:model="description" rows="4" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="Enter Description"></textarea>
                    </div>

                    <!-- Storage Type & File Path -->
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Storage Type</label>
                            <select wire:model="storage_type" wire:change="helloChange" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1">Local Storage</option>
                                <option value="2">Remote Server</option>
                            </select>
                        </div>
                        <div>

                            <label class="block text-sm font-medium text-gray-700">File Path</label>

                            @if($storage_type==1)
                                <input
                                        type="file"
                                        wire:model="file_path_local"
                                        class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer
               bg-gray-50 p-2 mt-1  focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500"
                                >

                            @elseif($storage_type==2)
                                <input type="text" wire:model="file_path" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="e.g. uploads/images/...">
                            @endif
                        </div>
                    </div>
                    <div class="grid grid-cols-3 gap-4">
                        <!-- Display Position -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Display Position</label>
                            <input type="number" wire:model="display_position" placeholder="Enter Display Position" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @error('display_position') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>

                        <!-- Highlight Item -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Highlight Item?</label>
                            <select wire:model="is_highlight_item" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="0">No</option>
                                <option value="1">Yes</option>
                            </select>
                        </div>

                        <!-- Active Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700">Status</label>
                            <select wire:model="is_active" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="1">Active</option>
                                <option value="2">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <!-- Buttons -->
                    <div class="flex space-x-2">
                        <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded shadow">
                            {{ $isEditing ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" wire:click="closeContentForm" class="px-4 py-2 bg-red-400 text-white rounded shadow">
                            Close
                        </button>
                    </div>
                </form>
                </div>
            </div>
        </div>
    @endif

    <hr class="my-3">

    <div class="pt-1" >
        <!-- Search + Per Page -->
        <div class="flex justify-between mb-4">
            <input
                    type="text"
                    wire:model.live.debounce.500ms="search"
                    placeholder="Search..."
                    class="border rounded px-3 py-2 w-5/5"
            />

            <select   wire:model.live.debounce.500ms="searchType" class="border rounded p-2 w-2/12">
                <option value="">-- Search Type --</option>
                @foreach($contentTypes as $key => $label)
                    <option value="{{ $key }}">{{ $label }}</option>
                @endforeach
            </select>
            <select   wire:model.live.debounce.500ms="perPage" class="border rounded p-2 w-2/12">
                <option value="5">5 per page</option>
                <option value="10">10 per page</option>
                <option value="20">20 per page</option>
                <option value="50">50 per page</option>
                <option value="100">100 per page</option>
            </select>

        </div>

        <!-- Data Table -->
        <div class="overflow-x-auto bg-white shadow rounded-lg">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Title</th>

                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                @php $i = isset($contentRecord)? $contentRecord->firstItem():1; @endphp
                @forelse($contentRecord as $content)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">  {{ $i++ }}</td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $contentTypes[$content->type] ?? '' }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $content->title }}</td>

                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($content->is_active==1)
                                <span class="px-2 py-1 text-xs font-semibold text-green-800 bg-green-100 rounded-full">Active</span>
                            @elseif($content->is_active==2)
                                <span class="px-2 py-1 text-xs font-semibold text-red-800 bg-red-100 rounded-full">Inactive</span>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <button wire:click="edit({{ $content->id }})" class="text-indigo-600 hover:text-indigo-900">Edit</button>

                            <button
                                    wire:click="confirmDelete({{ $content->id }})"
                                    class="text-red-600 hover:text-red-900 ml-3"
                            >
                                Delete
                            </button>

                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-gray-500">No records found</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            @if($confirmingDeleteId)
                <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
                    <div class="bg-white rounded-lg shadow-lg p-6 w-96">
                        <h3 class="text-lg font-medium text-gray-900 mb-4">Are you sure?</h3>
                        <p class="text-sm text-gray-600 mb-6">This action cannot be undone.</p>

                        <div class="flex justify-end space-x-3">
                            <button
                                    wire:click="$set('confirmingDeleteId', null)"
                                    class="px-4 py-2 bg-gray-300 text-gray-800 rounded hover:bg-gray-400"
                            >
                                Cancel
                            </button>

                            <button
                                    wire:click="delete"
                                    class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700"
                            >
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endif

        </div>

        <!-- Pagination -->
        <div class="mt-4">
            {{ $contentRecord->links() }}
        </div>
    </div>
</div>
<!-- Delete Confirmation Modal -->


<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Success alert
        window.addEventListener('swal:success', event => {
            Swal.fire({
                icon: 'success',
                title: event.detail[0].title,
                text: event.detail[0].text,
                confirmButtonColor: '#3085d6',
                confirmButtonText: 'OK'
            })
        });

        // Error alert
        window.addEventListener('swal:error', event => {
            Swal.fire({
                icon: 'error',
                title: event.detail[0].title,
                text: event.detail[0].text,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Close'
            })
        });
    });

</script>

