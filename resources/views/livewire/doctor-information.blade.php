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
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-5xl mx-4 overflow-y-auto max-h-[90vh]">
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
                            <input type="text" wire:model="name" placeholder="Enter Doctor Name" class="w-full border rounded px-2 py-1">
                            @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
                        </div>
                        <div>
                            <label class="block">Email</label>
                            <input type="email" wire:model="email" placeholder="Enter Doctor Email" class="w-full border rounded px-2 py-1">
                            @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Mobile</label>
                            <input type="text" wire:model="mobile" placeholder="Enter Doctor Mobile" class="w-full border rounded px-2 py-1">
                            @error('mobile') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
                        </div>
                        <div>
                            <label class="block">Picture</label>
                            <input type="file" wire:model="newPicture" class="block w-full px-3 py-2 text-base text-gray-700 bg-white border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 file:mr-4  file:bg-gray-100 file:border-0 file:rounded-md file:text-gray-700 file:cursor-pointer hover:file:bg-gray-200 transition-colors">
                            @error('newPicture') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
                            @if($picture)
                                <img src="{{ asset('storage/'.$picture) }}" class="h-16 mt-2 rounded">
                            @endif
                            @if($newPicture)
                                <img src="{{ $newPicture->temporaryUrl() }}" class="h-16 mt-2 rounded">
                            @endif
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block">Designation/Position</label>
                        <textarea wire:model="positions" placeholder="Enter Doctor Designation/Position"  class="w-full border rounded px-2 py-1"></textarea>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Qualifications</label>
                            <textarea wire:model="qualifications" placeholder="Enter Qualifications" class="w-full border rounded px-2 py-1"></textarea>
                        </div>
                        <div>
                            <label class="block">Special Training</label>
                            <textarea wire:model="special_training" placeholder="Enter Special Training" class="w-full border rounded px-2 py-1"></textarea>
                        </div>
                    </div>

                    <div class="mt-3">
                        <label class="block mb-1">Doctor Profile</label>
                        <div wire:ignore>
                            <div id="doctor-profile-editor" style="min-height:200px; background:#fff;"></div>
                        </div>
                        <input type="hidden" id="doctor-profile-hidden" wire:model="doctor_profile">
                    </div>

                    {{-- Social Media Links --}}
                    <div class="mt-4">
                        <p class="font-semibold text-gray-700 mb-2 flex items-center gap-2">
                            <svg class="w-4 h-4 text-blue-500" fill="currentColor" viewBox="0 0 24 24"><path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"/></svg>
                            Social Media Links
                        </p>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1"><i class="bi bi-facebook text-blue-600 me-1"></i> Facebook URL</label>
                                <input type="url" wire:model="facebook" placeholder="https://facebook.com/..." class="w-full border rounded px-2 py-1 text-sm">
                                @error('facebook') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1"><i class="bi bi-youtube text-red-600 me-1"></i> YouTube URL</label>
                                <input type="url" wire:model="youtube" placeholder="https://youtube.com/..." class="w-full border rounded px-2 py-1 text-sm">
                                @error('youtube') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1"><i class="bi bi-linkedin text-blue-700 me-1"></i> LinkedIn URL</label>
                                <input type="url" wire:model="linkedin" placeholder="https://linkedin.com/in/..." class="w-full border rounded px-2 py-1 text-sm">
                                @error('linkedin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1"><i class="bi bi-tiktok me-1"></i> TikTok URL</label>
                                <input type="url" wire:model="tiktok" placeholder="https://tiktok.com/@..." class="w-full border rounded px-2 py-1 text-sm">
                                @error('tiktok') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-600 mb-1"><i class="bi bi-instagram text-pink-600 me-1"></i> Instagram URL</label>
                                <input type="url" wire:model="instagram" placeholder="https://instagram.com/..." class="w-full border rounded px-2 py-1 text-sm">
                                @error('instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mt-3">
                        <div>
                            <label class="block">Display Order</label>
                            <input type="number" wire:model="display_position"  placeholder="Enter Display Order" class="w-full border rounded px-2 py-1">
                            @error('display_position') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
                        </div>
                        <div>
                            <label class="block">Active?</label>
                            <select wire:model="is_active" class="w-full border rounded px-2 py-1">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                            @error('is_active') <span class="text-red-500 text-sm">{{ $message }}</span> @endif
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

    {{-- SweetAlert + Quill init --}}
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
                    @this.delete(e.detail.id);
                    }
                });
            });
        });

        // Quill editor — registered once via Livewire.on after Livewire boots
        document.addEventListener('livewire:init', () => {
            let _quill = null;

            Livewire.on('init-profile-editor', ({ content }) => {
                // Give Livewire a tick to finish morphing the DOM
                requestAnimationFrame(() => {
                    const el = document.getElementById('doctor-profile-editor');
                    if (!el) return;

                    // Destroy previous instance
                    if (_quill) {
                        _quill = null;
                        el.innerHTML = '';
                    }

                    _quill = new Quill(el, {
                        theme: 'snow',
                        placeholder: 'Enter Doctor Profile...',
                        modules: {
                            toolbar: [
                                [{ header: [2, 3, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link'],
                                ['clean'],
                            ]
                        }
                    });

                    if (content) {
                        _quill.root.innerHTML = content;
                    }

                    _quill.on('text-change', () => {
                        const html = _quill.root.innerHTML === '<p><br></p>' ? '' : _quill.root.innerHTML;
                        @this.set('doctor_profile', html);
                    });
                });
            });
        });
    </script>
</div>

