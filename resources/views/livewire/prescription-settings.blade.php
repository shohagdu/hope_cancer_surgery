<div class="max-w-2xl mx-auto px-4 py-6">

    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">

        <div class="px-6 py-4 border-b bg-gray-50 flex items-center justify-between">
            <h1 class="text-lg font-bold text-gray-800">⚙️ Prescription Settings</h1>
            @if(session('success'))
                <span class="text-green-600 text-sm font-medium">✓ {{ session('success') }}</span>
            @endif
        </div>

        <div class="p-6 space-y-7">

            {{-- Page Margins & Layout --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Page Margins & Layout</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Top Space (inches)</label>
                        <input type="number" step="0.1" min="0" max="5"
                               wire:model.live="pdfSettings.margin_top"
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Bottom Space (inches)</label>
                        <input type="number" step="0.1" min="0" max="5"
                               wire:model.live="pdfSettings.margin_bottom"
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Left Margin (inches)</label>
                        <input type="number" step="0.1" min="0" max="5"
                               wire:model.live="pdfSettings.margin_left"
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Medicine Column Width (%)</label>
                        <input type="number" step="1" min="40" max="85"
                               wire:model.live="pdfSettings.medicine_width"
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
            </div>

            {{-- Typography --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Typography</h3>
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Font Family</label>
                        <select wire:model.live="pdfSettings.font_family"
                                class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                            <option value="serif">Serif (Times New Roman)</option>
                            <option value="sans-serif">Sans-serif (Arial)</option>
                            <option value="Arial">Arial</option>
                            <option value="Times New Roman">Times New Roman</option>
                            <option value="Georgia">Georgia</option>
                            <option value="Tahoma">Tahoma</option>
                            <option value="Verdana">Verdana</option>
                            <option value="Courier New">Courier New</option>
                            <option value="SolaimanLipi">SolaimanLipi (Bengali)</option>
                            <option value="Kalpurush">Kalpurush (Bengali)</option>
                        </select>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 block mb-1">Font Size (px)</label>
                        <input type="number" step="1" min="8" max="24"
                               wire:model.live="pdfSettings.font_size"
                               class="w-full border border-gray-300 rounded px-3 py-1.5 text-sm focus:outline-none focus:ring-2 focus:ring-blue-400">
                    </div>
                </div>
                <p class="text-xs text-gray-400 mt-2" style="font-family: {{ $pdfSettings['font_family'] }}; font-size: {{ $pdfSettings['font_size'] }}px;">
                    Preview: The quick brown fox. রোগীর প্রেসক্রিপশন।
                </p>
            </div>

            {{-- Section Visibility --}}
            <div>
                <h3 class="text-sm font-semibold text-gray-700 mb-3 border-b pb-1">Show / Hide Sections</h3>
                <div class="grid grid-cols-2 gap-2">
                    @foreach([
                        'complaints'      => 'Chief Complaints',
                        'onExamination'   => 'On Examination',
                        'pastHistory'     => 'Past History',
                        'drugHistory'     => 'Drug History',
                        'investigation'   => 'Investigations',
                        'diagnosis'       => 'Diagnosis',
                        'treatmentPlan'   => 'Treatment Plan',
                        'operationNote'   => 'Operation Notes',
                        'advice'          => 'Advice',
                        'nextPlan'        => 'Next Plan',
                        'hospitalizations'=> 'Hospitalizations',
                    ] as $key => $label)
                    <label class="flex items-center gap-2 text-sm cursor-pointer select-none">
                        <input type="checkbox"
                               wire:model.live="sectionVisibility.{{ $key }}"
                               class="w-4 h-4 text-blue-600 border-gray-300 rounded">
                        {{ $label }}
                    </label>
                    @endforeach
                </div>
            </div>

        </div>

        <div class="border-t px-6 py-4 bg-gray-50 flex justify-end">
            <button wire:click="save()"
                    class="px-5 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 font-medium transition">
                Save Settings
            </button>
        </div>
    </div>

    {{-- Persist to / load from localStorage --}}
    <script>
        window.addEventListener('rx-settings-saved', e => {
            const data = e.detail[0] || e.detail;
            localStorage.setItem('rx_prescription_settings', JSON.stringify(data));
        });
        document.addEventListener('livewire:initialized', () => {
            const saved = localStorage.getItem('rx_prescription_settings');
            if (saved) {
                try { @this.call('loadSettings', JSON.parse(saved)); } catch(e) {}
            }
        });
    </script>
</div>
