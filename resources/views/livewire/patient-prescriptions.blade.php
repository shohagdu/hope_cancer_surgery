<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-5">
        <div class="flex items-center gap-3">
            <a href="{{ route('patients.index') }}"
               class="text-gray-400 hover:text-gray-600 transition">
                ← Back
            </a>
            <div>
                <h1 class="text-xl font-bold text-gray-800">{{ $patient->patient_name }}</h1>
                <p class="text-sm text-gray-500">{{ $patient->mobile }} &nbsp;|&nbsp; {{ ucfirst($patient->gender ?? '—') }}</p>
            </div>
        </div>
        {{-- Add New Prescription --}}
        <a href="{{ route('prescription.new_patient', ['id' => $patient->id, 'fresh' => 1]) }}"
           class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-lg shadow transition">
            + New Prescription
        </a>
    </div>

    {{-- Prescription list --}}
    @if($prescriptions->isEmpty())
        <div class="bg-white rounded-xl shadow p-12 text-center text-gray-400">
            <p class="text-lg mb-3">No prescriptions yet.</p>
            <a href="{{ route('prescription.new_patient', $patient->id) }}"
               class="inline-flex items-center gap-1 px-4 py-2 bg-blue-600 text-white rounded-lg text-sm hover:bg-blue-700 transition">
                Create First Prescription
            </a>
        </div>
    @else
        <div class="space-y-3">
            @foreach($prescriptions as $rx)
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-4 flex items-center justify-between gap-4">

                    {{-- Left info --}}
                    <div class="flex items-center gap-5">
                        <div class="text-center min-w-[64px]">
                            <p class="text-2xl font-bold text-blue-600">
                                {{ \Carbon\Carbon::parse($rx->visit_date)->format('d') }}
                            </p>
                            <p class="text-xs text-gray-500 uppercase">
                                {{ \Carbon\Carbon::parse($rx->visit_date)->format('M Y') }}
                            </p>
                        </div>

                        <div class="border-l pl-5 space-y-1">
                            <div class="flex flex-wrap gap-2 text-xs">
                                @if(!empty($rx->diagnosis))
                                    <span class="font-semibold text-gray-700">Diagnosis:</span>
                                    <span class="text-gray-600">
                                        {{ collect($rx->diagnosis)->pluck('label')->implode(', ') ?: '—' }}
                                    </span>
                                @endif
                            </div>
                            <div class="flex flex-wrap gap-3 text-xs text-gray-500">
                                @if(!empty($rx->complaints))
                                    <span>
                                        Complaints:
                                        {{ collect($rx->complaints)->pluck('label')->take(3)->implode(', ') }}
                                        {{ collect($rx->complaints)->count() > 3 ? '…' : '' }}
                                    </span>
                                @endif
                                <span class="text-green-600 font-medium">
                                    {{ $rx->medicine_count }} medicine{{ $rx->medicine_count != 1 ? 's' : '' }}
                                </span>
                                @if($rx->next_visit_date)
                                    <span class="text-orange-500">
                                        Next: {{ \Carbon\Carbon::parse($rx->next_visit_date)->format('d M Y') }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    {{-- Action --}}
                    <a href="{{ route('prescription.new_patient', ['id' => $patient->id, 'prescriptionId' => $rx->id]) }}"
                       class="flex-shrink-0 inline-flex items-center gap-1 px-4 py-2 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-sm font-medium transition">
                        Open ↗
                    </a>
                </div>
            @endforeach
        </div>
    @endif
</div>
