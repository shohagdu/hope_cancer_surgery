<div class="max-w-7xl mx-auto p-4 bg-white shadow rounded">
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 pb-4">
        <div>
            <h1 class="text-xl font-bold">
                Organization Information
            </h1>
        </div>
        <div class="text-right">
            @if($companies->count()<=0)
                <button wire:click="openModal()" class="bg-blue-600 text-white px-4 py-2 rounded">Add Organization</button>
            @endif
        </div>
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
        <div class="fixed inset-0 flex items-start justify-center z-50 bg-gray-800 bg-opacity-50 overflow-y-auto py-8">
            <div
                x-data="testimonialsManager(@js($testimonials ?? []))"
                class="bg-white rounded-lg shadow-lg p-6 w-full max-w-4xl mx-4"
            >
                <h3 class="text-lg font-bold mb-4">{{ $company_id ? 'Edit Company' : 'Add Company' }}</h3>

                <form wire:submit.prevent="save" class="space-y-4">

                    {{-- Basic Info --}}
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
                        <input type="text"  wire:model="address"  placeholder="Address"      class="w-full border rounded p-2" />
                        <input type="text"  wire:model="mobile"   placeholder="Mobile"       class="w-full border rounded p-2" />
                        <input type="email" wire:model="email"    placeholder="Email"        class="w-full border rounded p-2" />
                        <input type="text"  wire:model="fb"       placeholder="Facebook URL" class="w-full border rounded p-2" />
                        <input type="text"  wire:model="twitter"  placeholder="Twitter URL"  class="w-full border rounded p-2" />
                        <input type="text"  wire:model="linkedin" placeholder="LinkedIn URL" class="w-full border rounded p-2" />
                        <input type="text"  wire:model="tiktok"   placeholder="TikTok URL"   class="w-full border rounded p-2" />
                        <input type="text"  wire:model="youtube"  placeholder="YouTube URL"  class="w-full border rounded p-2" />
                    </div>

                    {{-- Google Map --}}
                    <div class="mt-3 p-3 bg-blue-50 rounded-lg border border-blue-100 space-y-2">
                        <p class="text-xs font-bold text-blue-700 uppercase tracking-wide">Google Map</p>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">
                                Map Embed URL
                                <span class="text-gray-400 font-normal">(from Google Maps → Share → Embed → copy only the <code>src="..."</code> URL)</span>
                            </label>
                            <input type="text" wire:model="google_map_embed"
                                   placeholder="https://www.google.com/maps/embed?pb=..."
                                   class="w-full border rounded p-2 text-sm font-mono">
                            @error('google_map_embed') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs text-gray-500 mb-1">
                                Open in Maps Link
                                <span class="text-gray-400 font-normal">(from Google Maps → Share → Copy link, or the direct maps.google.com URL)</span>
                            </label>
                            <input type="url" wire:model="google_map_link"
                                   placeholder="https://maps.google.com/?q=..."
                                   class="w-full border rounded p-2 text-sm">
                            @error('google_map_link') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    {{-- Testimonials --}}
                    <div class="mt-3 p-3 bg-yellow-50 rounded-lg border border-yellow-200 space-y-3">
                        <div class="flex items-center justify-between">
                            <p class="text-xs font-bold text-yellow-700 uppercase tracking-wide">Testimonials</p>
                            <button type="button" @click="addItem()"
                                    class="text-xs bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1 rounded">
                                + Add Testimonial
                            </button>
                        </div>

                        {{-- Section heading & sub text --}}
                        <div class="grid grid-cols-2 gap-3">
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Section Heading</label>
                                <input type="text" wire:model="testimonials_heading"
                                       placeholder="e.g. What Our Patients Say"
                                       class="w-full border rounded p-2 text-sm" />
                            </div>
                            <div>
                                <label class="block text-xs text-gray-500 mb-1">Section Sub-text</label>
                                <input type="text" wire:model="testimonials_subtext"
                                       placeholder="Short description below the heading"
                                       class="w-full border rounded p-2 text-sm" />
                            </div>
                        </div>

                        {{-- Testimonial rows --}}
                        <template x-for="(item, idx) in items" :key="idx">
                            <div class="bg-white border rounded p-3 space-y-2 relative">
                                <button type="button" @click="removeItem(idx)"
                                        class="absolute top-2 right-2 text-red-400 hover:text-red-600 text-xs font-bold">
                                    ✕ Remove
                                </button>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Name <span class="text-red-400">*</span></label>
                                        <input type="text" x-model="item.name" placeholder="Patient / Person name"
                                               class="w-full border rounded p-1 text-sm" />
                                    </div>
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Role / Designation</label>
                                        <input type="text" x-model="item.role" placeholder="e.g. Cancer Survivor"
                                               class="w-full border rounded p-1 text-sm" />
                                    </div>
                                </div>

                                {{-- Photo upload --}}
                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Photo</label>
                                    <div class="flex gap-3 items-center">
                                        {{-- Preview --}}
                                        <template x-if="item.picture_url">
                                            <img :src="'{{ asset('storage') }}/' + item.picture_url"
                                                 class="w-14 h-14 rounded-full object-cover border flex-shrink-0" />
                                        </template>
                                        <template x-if="!item.picture_url">
                                            <div class="w-14 h-14 rounded-full bg-gray-100 flex items-center justify-center text-gray-400 text-xs flex-shrink-0">No photo</div>
                                        </template>
                                        {{-- Upload --}}
                                        <div class="flex-1">
                                            <input type="file"
                                                   wire:model="testimonial_photo_upload"
                                                   @change="uploadPhoto(idx, $event)"
                                                   class="w-full text-xs border rounded p-1"
                                                   accept="image/*" />
                                            <template x-if="item.uploading">
                                                <span class="text-xs text-blue-500">Uploading...</span>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <div class="grid grid-cols-2 gap-2">
                                    <div>
                                        <label class="block text-xs text-gray-500 mb-1">Rating (1–5)</label>
                                        <select x-model="item.rating" class="w-full border rounded p-1 text-sm">
                                            <option value="5">★★★★★ (5)</option>
                                            <option value="4">★★★★☆ (4)</option>
                                            <option value="3">★★★☆☆ (3)</option>
                                            <option value="2">★★☆☆☆ (2)</option>
                                            <option value="1">★☆☆☆☆ (1)</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label class="block text-xs text-gray-500 mb-1">Testimonial Message</label>
                                    <textarea x-model="item.message" rows="2" placeholder="What the patient said..."
                                              class="w-full border rounded p-1 text-sm"></textarea>
                                </div>
                            </div>
                        </template>

                        <p x-show="items.length === 0" class="text-sm text-gray-400 text-center py-2">
                            No testimonials added yet. Click "+ Add Testimonial" to begin.
                        </p>
                    </div>

                    {{-- Action buttons --}}
                    <div class="flex space-x-2 pt-2">
                        <button type="button"
                                @click="syncAndSave()"
                                class="bg-blue-600 text-white px-4 py-2 rounded">
                            {{ $company_id ? 'Update' : 'Save' }}
                        </button>
                        <button type="button" wire:click="$set('isShowModal', false)"
                                class="bg-gray-400 text-white px-4 py-2 rounded">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    @endif

    @script
    <script>
    window.addEventListener('swal:success', e => {
        Swal.fire({ icon: 'success', title: e.detail.title, text: e.detail.text, timer: 2500, showConfirmButton: false });
    });
    window.addEventListener('swal:error', e => {
        Swal.fire({ icon: 'error', title: e.detail.title, text: e.detail.text });
    });

    window.testimonialsManager = function(initial) {
        return {
            items: Array.isArray(initial) ? JSON.parse(JSON.stringify(initial)) : [],

            init() {
                this.$wire.on('testimonial-photo-uploaded', ({ idx, url }) => {
                    if (this.items[idx]) {
                        this.items[idx].picture_url = url;
                        this.items[idx].uploading   = false;
                    }
                });
            },

            addItem() {
                this.items.push({ name: '', role: '', picture_url: '', rating: 5, message: '', uploading: false });
            },

            removeItem(idx) {
                this.items = this.items.filter((_, i) => i !== idx);
            },

            async uploadPhoto(idx, event) {
                if (!event.target.files.length) return;
                this.items[idx].uploading = true;
                await $wire.call('uploadTestimonialPhoto', idx);
            },

            async syncAndSave() {
                await $wire.call('setTestimonials', this.items);
                await $wire.call('save');
            }
        };
    };
    </script>
    @endscript

</div>
