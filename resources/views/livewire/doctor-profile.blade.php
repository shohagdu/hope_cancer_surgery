<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- Page header --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">My Profile</h1>
        <p class="text-sm text-gray-500 mt-0.5">Manage your public doctor profile shown on the website.</p>
    </div>

    @if(!$doctor)
        <div class="bg-yellow-50 border border-yellow-200 rounded-xl p-6 text-center text-yellow-700">
            <p class="font-semibold text-base">No doctor profile is linked to your account.</p>
            <p class="text-sm mt-1">Please contact the administrator to link your account to a doctor record.</p>
        </div>
    @else

    {{-- Success / Error flash --}}
    @if(session('error'))
        <div class="mb-4 px-4 py-3 bg-red-50 border border-red-200 text-red-700 rounded-lg text-sm">
            {{ session('error') }}
        </div>
    @endif

    <div class="space-y-5">

        {{-- ── Basic Info (read-only) ──────────────────────────────────── --}}
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
            <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                <div>
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Basic Information</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Contact admin to update name, email, mobile or photo.</p>
                </div>
                <span class="inline-flex items-center gap-1 text-xs text-gray-400 bg-gray-100 px-2.5 py-1 rounded-full">
                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                    </svg>
                    Read-only
                </span>
            </div>
            <div class="p-6">
                <div class="flex items-center gap-5 mb-5">
                    @php
                        $imgPath = $picture && file_exists(storage_path('app/public/'.$picture))
                            ? asset('storage/'.$picture)
                            : null;
                    @endphp
                    @if($imgPath)
                        <img src="{{ $imgPath }}" alt="{{ $name }}"
                             class="w-20 h-20 rounded-full object-cover border-2 border-gray-200">
                    @else
                        <div class="w-20 h-20 rounded-full bg-indigo-100 flex items-center justify-center text-indigo-700 font-bold text-2xl border-2 border-gray-200">
                            {{ strtoupper(substr($name, 0, 1)) }}
                        </div>
                    @endif
                    <div>
                        <p class="text-lg font-bold text-gray-800">{{ $name }}</p>
                        <p class="text-sm text-gray-500">{{ $email }}</p>
                        <p class="text-sm text-gray-500">{{ $mobile }}</p>
                    </div>
                </div>
            </div>
        </div>

        <div x-data="profileChambers(@js($chambers))" class="space-y-5">
        <form @submit.prevent="submitForm()" class="space-y-5">

            {{-- ── Professional Details ────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Professional Details</h2>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Hero Tag <span class="text-gray-400 font-normal">(shown on your public page)</span>
                        </label>
                        <input type="text" wire:model="hero_tag"
                               placeholder="e.g. Surgical Oncologist"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('hero_tag') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Qualifications <span class="text-gray-400 font-normal">(comma-separated)</span>
                        </label>
                        <input type="text" wire:model="qualifications"
                               placeholder="MBBS, MS (Surgery), FCPS"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('qualifications') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">Special Training / Fellowship</label>
                        <input type="text" wire:model="special_training"
                               placeholder="Fellowship in Surgical Oncology..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('special_training') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-medium text-gray-600 mb-1">
                            Designations / Positions <span class="text-gray-400 font-normal">(one per line)</span>
                        </label>
                        <textarea wire:model="positions" rows="3"
                                  placeholder="Associate Professor, DMCH&#10;Consultant, XYZ Hospital"
                                  class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
                    </div>
                </div>
            </div>

            {{-- ── Biography ───────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Biography / Profile</h2>
                </div>
                <div class="p-6">
                    <div wire:ignore>
                        <div id="doctor-profile-editor" style="min-height: 200px; background: #fff;"></div>
                    </div>
                    <input type="hidden" id="doctor-profile-hidden" wire:model="doctor_profile">
                </div>
            </div>

            {{-- ── Stats ───────────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Stats</h2>
                    <p class="text-xs text-gray-400 mt-0.5">Leave empty to hide the stats section on your public page.</p>
                </div>
                <div class="p-6 grid grid-cols-2 sm:grid-cols-4 gap-4">
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Years Experience</label>
                        <input type="text" wire:model="stat_experience" placeholder="e.g. 15+"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Publications</label>
                        <input type="text" wire:model="stat_publications" placeholder="e.g. 20+"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Patients Treated</label>
                        <input type="text" wire:model="stat_patients" placeholder="e.g. 5000+"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                    <div>
                        <label class="block text-xs text-gray-500 mb-1">Success Rate</label>
                        <input type="text" wire:model="stat_success_rate" placeholder="e.g. 98%"
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                    </div>
                </div>
            </div>

            {{-- ── Areas of Expertise ──────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Areas of Expertise</h2>
                    <p class="text-xs text-gray-400 mt-0.5">One item per line (e.g. Breast Cancer)</p>
                </div>
                <div class="p-6">
                    <textarea wire:model="expertiseText" rows="6"
                              placeholder="Breast Cancer&#10;Stomach Cancer&#10;Thyroid Cancer&#10;Colo-rectal Cancer"
                              class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm font-mono focus:outline-none focus:ring-2 focus:ring-indigo-400"></textarea>
                </div>
            </div>

            {{-- ── Chambers ────────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
                    <div>
                        <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Chambers & Consultation</h2>
                        <p class="text-xs text-gray-400 mt-0.5">Add your consultation chambers shown on the public page.</p>
                    </div>
                    <button type="button" @click="addChamber()"
                            class="inline-flex items-center gap-1 px-3 py-1.5 bg-indigo-600 hover:bg-indigo-700 text-white text-xs font-medium rounded-lg transition">
                        + Add Chamber
                    </button>
                </div>
                <div class="p-6 space-y-3">
                    <template x-for="(ch, idx) in chambers" :key="idx">
                        <div class="border border-gray-200 rounded-xl p-4 grid grid-cols-2 sm:grid-cols-3 gap-3 relative bg-gray-50">
                            <button type="button" @click="removeChamber(idx)"
                                    class="absolute top-3 right-3 text-gray-400 hover:text-red-500 transition text-xl font-bold leading-none">&times;</button>

                            <div class="col-span-2 sm:col-span-3">
                                <label class="text-xs text-gray-500 block mb-1">Place / Location</label>
                                <input type="text" x-model="ch.place"
                                       placeholder="Hospital name, address"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Title</label>
                                <input type="text" x-model="ch.title"
                                       placeholder="Main Chamber"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Days</label>
                                <input type="text" x-model="ch.days"
                                       placeholder="Sat – Thu"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Hours</label>
                                <input type="text" x-model="ch.hours"
                                       placeholder="6:00 PM – 9:00 PM"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                            <div>
                                <label class="text-xs text-gray-500 block mb-1">Badge Label</label>
                                <input type="text" x-model="ch.badge"
                                       placeholder="Primary / Friday Only"
                                       class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                            </div>
                        </div>
                    </template>
                    <p x-show="chambers.length === 0" class="text-sm text-gray-400 italic text-center py-4">
                        No chambers added yet. Click "+ Add Chamber" to add one.
                    </p>
                </div>
            </div>

            {{-- ── Social Media ────────────────────────────────────────── --}}
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <div class="px-6 py-4 border-b bg-gray-50">
                    <h2 class="text-sm font-bold text-gray-700 uppercase tracking-wide">Social Media Links</h2>
                </div>
                <div class="p-6 grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">Facebook URL</label>
                        <input type="url" wire:model="facebook" placeholder="https://facebook.com/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('facebook') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">YouTube URL</label>
                        <input type="url" wire:model="youtube" placeholder="https://youtube.com/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('youtube') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">LinkedIn URL</label>
                        <input type="url" wire:model="linkedin" placeholder="https://linkedin.com/in/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('linkedin') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-xs text-gray-600 mb-1">TikTok URL</label>
                        <input type="url" wire:model="tiktok" placeholder="https://tiktok.com/@..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('tiktok') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div class="sm:col-span-2">
                        <label class="block text-xs text-gray-600 mb-1">Instagram URL</label>
                        <input type="url" wire:model="instagram" placeholder="https://instagram.com/..."
                               class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-400">
                        @error('instagram') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            {{-- ── Save Button ─────────────────────────────────────────── --}}
            <div class="flex justify-end pb-4">
                <button type="submit"
                        class="px-6 py-2.5 bg-indigo-600 hover:bg-indigo-700 text-white text-sm font-semibold rounded-lg shadow transition">
                    Save Profile
                </button>
            </div>

        </form>
        </div>{{-- end x-data profileChambers --}}

    @endif

    {{-- SweetAlert + Quill + Chambers --}}
    <script>
        // ── SweetAlert ──────────────────────────────────────────────────────────
        document.addEventListener('DOMContentLoaded', () => {
            window.addEventListener('swal:success', e => {
                Swal.fire({ icon: 'success', title: e.detail.title, text: e.detail.text, timer: 2000, showConfirmButton: false });
            });
        });

        // ── Quill editor ────────────────────────────────────────────────────────
        document.addEventListener('livewire:init', () => {
            let _quill = null;

            function initEditor(content) {
                requestAnimationFrame(() => {
                    const el = document.getElementById('doctor-profile-editor');
                    if (!el) return;
                    if (_quill) { _quill = null; el.innerHTML = ''; }

                    _quill = new Quill(el, {
                        theme: 'snow',
                        placeholder: 'Write your biography here...',
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
            }

            initEditor(@js($doctor?->doctor_profile ?? ''));
            Livewire.on('init-profile-editor', ({ content }) => initEditor(content));
        });

        // ── Chambers Alpine parent component ────────────────────────────────────
        // Wraps the whole form so chambers state is owned here and synced
        // to Livewire atomically right before save (no race condition).
        function profileChambers(initial) {
            return {
                chambers: Array.isArray(initial) ? JSON.parse(JSON.stringify(initial)) : [],

                addChamber() {
                    this.chambers.push({ title: '', place: '', days: '', hours: '', badge: '' });
                },

                removeChamber(idx) {
                    // filter instead of splice — triggers Alpine reactivity reliably
                    this.chambers = this.chambers.filter((_, i) => i !== idx);
                },

                async submitForm() {
                    // 1. Push current chambers to Livewire synchronously, THEN save.
                    //    Awaiting setChambers guarantees the property is updated
                    //    before save() reads $this->chambers.
                    await @this.call('setChambers', this.chambers);
                    await @this.call('save');
                }
            };
        }
    </script>

</div>
