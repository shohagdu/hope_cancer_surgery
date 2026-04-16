<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="flex justify-between items-center mb-4">
        <h2 class="text-xl font-bold">Doctors</h2>
        <button wire:click="openModal" class="bg-blue-600 text-white px-4 py-2 rounded">+ Add Doctor</button>
    </div>

    <table class="min-w-full bg-white border rounded">
        <thead>
        <tr class="bg-gray-100 text-sm">
            <th class="px-4 py-2 text-left">#</th>
            <th class="px-4 py-2 text-left">Name</th>
            <th class="px-4 py-2 text-left">Mobile</th>
            <th class="px-4 py-2 text-left">Login Email</th>
            <th class="px-4 py-2 text-left">Login Account</th>
            <th class="px-4 py-2 text-left">Status</th>
            <th class="px-4 py-2 text-left">Action</th>
        </tr>
        </thead>
        <tbody class="text-sm divide-y">
        @forelse($doctors as $doctor)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-2 text-gray-400">{{ $doctor->id }}</td>
                <td class="px-4 py-2 font-medium text-gray-800">{{ $doctor->name }}</td>
                <td class="px-4 py-2 text-gray-600">{{ $doctor->mobile }}</td>
                <td class="px-4 py-2 text-gray-500">{{ $doctor->user?->email ?? '—' }}</td>
                <td class="px-4 py-2">
                    @if($doctor->user)
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-green-100 text-green-700 rounded-full text-xs font-medium">
                            <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                            Linked
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1 px-2 py-0.5 bg-gray-100 text-gray-500 rounded-full text-xs">
                            No Account
                        </span>
                    @endif
                </td>
                <td class="px-4 py-2">
                    <span class="px-2 py-1 rounded text-xs {{ $doctor->is_active ? 'bg-green-200 text-green-800' : 'bg-red-200 text-red-800' }}">
                        {{ $doctor->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </td>
                <td class="px-4 py-2 space-x-2">
                    <button wire:click="openModal({{ $doctor->id }})" class="text-blue-600 hover:underline">Edit</button>
                    <button wire:click="confirmDelete({{ $doctor->id }})" class="text-red-600 hover:underline">Delete</button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7" class="px-4 py-8 text-center text-gray-400">No doctors found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <div class="mt-4">{{ $doctors->links() }}</div>

    @if($showModal)
        <div class="fixed inset-0 flex items-center justify-center z-50 bg-gray-800 bg-opacity-50">
            <div class="bg-white rounded-lg shadow-lg p-6 w-full max-w-5xl mx-4 overflow-y-auto max-h-[92vh]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="text-lg font-semibold">{{ $isEdit ? 'Edit Doctor' : 'Add Doctor' }}</h3>
                    <button class="text-gray-500 hover:text-gray-700 text-xl" wire:click="$set('showModal', false)">✕</button>
                </div>

                <form wire:submit.prevent="{{ $isEdit ? 'update' : 'store' }}">

                    {{-- ── Basic Info ── --}}
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Basic Information</h4>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium mb-1">Name <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="name" placeholder="Doctor Name" class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('name') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Email</label>
                                <input type="email" wire:model="email" placeholder="Email" class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Mobile <span class="text-red-500">*</span></label>
                                <input type="text" wire:model="mobile" placeholder="Mobile" class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('mobile') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Picture</label>
                                <input type="file" wire:model="newPicture" class="block w-full px-2 py-1.5 text-sm bg-white border border-gray-300 rounded file:mr-3 file:bg-gray-100 file:border-0 file:rounded file:text-sm file:text-gray-700">
                                @error('newPicture') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                @if($newPicture)
                                    <img src="{{ $newPicture->temporaryUrl() }}" class="h-14 mt-2 rounded">
                                @elseif($picture)
                                    <img src="{{ asset('storage/'.$picture) }}" class="h-14 mt-2 rounded">
                                @endif
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Hero Tag <span class="text-xs text-gray-400">(shown on page, e.g. "Surgical Oncologist")</span></label>
                                <input type="text" wire:model="hero_tag" placeholder="e.g. Surgical Oncologist" class="w-full border rounded px-2 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Qualifications <span class="text-xs text-gray-400">(comma-separated)</span></label>
                                <textarea wire:model="qualifications" placeholder="MBBS, MS, FCPS" rows="2" class="w-full border rounded px-2 py-1.5 text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Designation / Positions <span class="text-xs text-gray-400">(one per line)</span></label>
                                <textarea wire:model="positions" placeholder="Each position on a new line" rows="2" class="w-full border rounded px-2 py-1.5 text-sm"></textarea>
                            </div>
                            <div>
                                <label class="block text-sm font-medium mb-1">Special Training</label>
                                <textarea wire:model="special_training" placeholder="Fellowship, training etc." rows="2" class="w-full border rounded px-2 py-1.5 text-sm"></textarea>
                            </div>
                        </div>
                    </div>

                    {{-- ── Stats ── --}}
                    <div class="bg-blue-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Stats Strip</h4>
                        <div class="grid grid-cols-4 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Years Experience</label>
                                <input type="text" wire:model="stat_experience" placeholder="e.g. 15+" class="w-full border rounded px-2 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Publications</label>
                                <input type="text" wire:model="stat_publications" placeholder="e.g. 15+" class="w-full border rounded px-2 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Patients Treated</label>
                                <input type="text" wire:model="stat_patients" placeholder="e.g. 5000+" class="w-full border rounded px-2 py-1.5 text-sm">
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Success Rate</label>
                                <input type="text" wire:model="stat_success_rate" placeholder="e.g. 98%" class="w-full border rounded px-2 py-1.5 text-sm">
                            </div>
                        </div>
                        <p class="text-xs text-gray-400 mt-2">Leave empty to hide the stats strip on the public page.</p>
                    </div>

                    {{-- ── Doctor Profile ── --}}
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Doctor Profile / Biography</h4>
                        <div wire:ignore>
                            <div id="doctor-profile-editor" style="min-height:180px; background:#fff;"></div>
                        </div>
                        <input type="hidden" id="doctor-profile-hidden" wire:model="doctor_profile">
                    </div>

                    {{-- ── Expertise ── --}}
                    <div class="bg-green-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-1">Areas of Expertise</h4>
                        <p class="text-xs text-gray-400 mb-2">One item per line (e.g. Breast Cancer)</p>
                        <textarea wire:model="expertiseText"
                                  rows="6"
                                  placeholder="Breast Cancer&#10;Stomach Cancer&#10;Colo-rectal Cancer&#10;Thyroid Cancer"
                                  class="w-full border rounded px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-green-400"></textarea>
                    </div>

                    {{-- ── Chambers ── --}}
                    <div class="bg-yellow-50 rounded-lg p-4 mb-4"
                         x-data="chambersManager(@js($chambers))"
                         x-init="sync()">
                        <div class="flex items-center justify-between mb-3">
                            <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide">Chambers & Consultation</h4>
                            <button type="button" @click="addRow()"
                                    class="text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded font-medium">
                                + Add Chamber
                            </button>
                        </div>
                        <div class="space-y-3">
                            <template x-for="(ch, idx) in rows" :key="idx">
                                <div class="bg-white border border-yellow-200 rounded-lg p-3 grid grid-cols-6 gap-2 items-start">
                                    <div class="col-span-2">
                                        <label class="text-xs text-gray-500 block mb-0.5">Place / Location</label>
                                        <input type="text" x-model="ch.place" @input="sync()"
                                               placeholder="Hospital name, address"
                                               class="w-full border rounded px-2 py-1.5 text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-0.5">Title</label>
                                        <input type="text" x-model="ch.title" @input="sync()"
                                               placeholder="Main Chamber"
                                               class="w-full border rounded px-2 py-1.5 text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-0.5">Days</label>
                                        <input type="text" x-model="ch.days" @input="sync()"
                                               placeholder="Sat – Thu"
                                               class="w-full border rounded px-2 py-1.5 text-sm">
                                    </div>
                                    <div>
                                        <label class="text-xs text-gray-500 block mb-0.5">Hours</label>
                                        <input type="text" x-model="ch.hours" @input="sync()"
                                               placeholder="6–9 PM"
                                               class="w-full border rounded px-2 py-1.5 text-sm">
                                    </div>
                                    <div class="flex flex-col gap-1">
                                        <label class="text-xs text-gray-500 block mb-0.5">Badge</label>
                                        <div class="flex gap-1">
                                            <input type="text" x-model="ch.badge" @input="sync()"
                                                   placeholder="Primary"
                                                   class="w-full border rounded px-2 py-1.5 text-sm">
                                            <button type="button" @click="removeRow(idx)"
                                                    class="text-red-500 hover:text-red-700 text-lg leading-none px-1">✕</button>
                                        </div>
                                    </div>
                                </div>
                            </template>
                            <p x-show="rows.length === 0" class="text-xs text-gray-400 italic">No chambers added yet.</p>
                        </div>
                    </div>

                    {{-- ── Social Media ── --}}
                    <div class="bg-gray-50 rounded-lg p-4 mb-4">
                        <h4 class="text-sm font-bold text-gray-600 uppercase tracking-wide mb-3">Social Media Links</h4>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">Facebook URL</label>
                                <input type="url" wire:model="facebook" placeholder="https://facebook.com/..." class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('facebook') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">YouTube URL</label>
                                <input type="url" wire:model="youtube" placeholder="https://youtube.com/..." class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('youtube') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">LinkedIn URL</label>
                                <input type="url" wire:model="linkedin" placeholder="https://linkedin.com/in/..." class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('linkedin') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-sm text-gray-600 mb-1">TikTok URL</label>
                                <input type="url" wire:model="tiktok" placeholder="https://tiktok.com/@..." class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('tiktok') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                            <div class="col-span-2">
                                <label class="block text-sm text-gray-600 mb-1">Instagram URL</label>
                                <input type="url" wire:model="instagram" placeholder="https://instagram.com/..." class="w-full border rounded px-2 py-1.5 text-sm">
                                @error('instagram') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Login Information ── --}}
                    <div class="bg-indigo-50 rounded-lg p-4 mb-4 border border-indigo-100">
                        <div class="flex items-center justify-between mb-3">
                            <div>
                                <h4 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Login Information</h4>
                                @if($linkedUserId)
                                    <p class="text-xs text-green-600 mt-0.5 font-medium">
                                        ✓ Account linked — leave password blank to keep current password.
                                    </p>
                                @else
                                    <p class="text-xs text-amber-600 mt-0.5 font-medium">
                                        Enter the doctor's login email. If the account already exists it will be linked automatically.
                                    </p>
                                @endif
                            </div>
                            @if($linkedUserId)
                                <span class="text-xs bg-green-100 text-green-700 px-2.5 py-1 rounded-full font-medium">
                                    User #{{ $linkedUserId }}
                                </span>
                            @endif
                        </div>
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Login Email <span class="text-red-500">*</span>
                                </label>
                                <input type="email" wire:model="loginEmail"
                                       placeholder="doctor@example.com"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                                @error('loginEmail') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-600 mb-1">
                                    Password
                                    @if($isEdit) <span class="text-gray-400 font-normal">(leave blank to keep current)</span> @else <span class="text-red-500">*</span> @endif
                                </label>
                                <input type="password" wire:model="loginPassword"
                                       placeholder="{{ $isEdit ? '••••••••' : 'Min. 6 characters' }}"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"
                                       autocomplete="new-password">
                                @error('loginPassword') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                            </div>
                        </div>
                    </div>

                    {{-- ── Settings ── --}}
                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label class="block text-sm font-medium mb-1">Display Order</label>
                            <input type="number" wire:model="display_position" placeholder="1, 2, 3..." class="w-full border rounded px-2 py-1.5 text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium mb-1">Status</label>
                            <select wire:model="is_active" class="w-full border rounded px-2 py-1.5 text-sm">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>
                    </div>

                    <div class="flex gap-2">
                        <button type="submit" class="bg-green-600 text-white px-5 py-2 rounded shadow text-sm font-medium">
                            {{ $isEdit ? 'Update Doctor' : 'Save Doctor' }}
                        </button>
                        <button type="button" wire:click="closeModal" class="bg-gray-500 text-white px-4 py-2 rounded shadow text-sm">
                            Cancel
                        </button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    <script>
        // ── SweetAlert & Quill ──────────────────────────────────────────────────
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
                    if (result.isConfirmed) { @this.delete(e.detail.id); }
                });
            });
        });

        document.addEventListener('livewire:init', () => {
            let _quill = null;

            Livewire.on('init-profile-editor', ({ content }) => {
                requestAnimationFrame(() => {
                    const el = document.getElementById('doctor-profile-editor');
                    if (!el) return;
                    if (_quill) { _quill = null; el.innerHTML = ''; }

                    _quill = new Quill(el, {
                        theme: 'snow',
                        placeholder: 'Enter Doctor Profile...',
                        modules: {
                            toolbar: [
                                [{ header: [2, 3, false] }],
                                ['bold', 'italic', 'underline'],
                                [{ list: 'ordered' }, { list: 'bullet' }],
                                ['link'], ['clean'],
                            ]
                        }
                    });

                    if (content) _quill.root.innerHTML = content;

                    _quill.on('text-change', () => {
                        const html = _quill.root.innerHTML === '<p><br></p>' ? '' : _quill.root.innerHTML;
                        @this.set('doctor_profile', html);
                    });
                });
            });
        });

        // ── Chambers Alpine component ───────────────────────────────────────────
        function chambersManager(initial) {
            return {
                rows: Array.isArray(initial) ? JSON.parse(JSON.stringify(initial)) : [],

                addRow() {
                    this.rows.push({ title: '', place: '', days: '', hours: '', badge: '' });
                    this.sync();
                },
                removeRow(idx) {
                    this.rows.splice(idx, 1);
                    this.sync();
                },
                sync() {
                    // Push current rows to Livewire
                    @this.call('setChambers', this.rows);
                }
            };
        }
    </script>
</div>
