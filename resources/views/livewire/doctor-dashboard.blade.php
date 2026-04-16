<div class="max-w-5xl mx-auto px-4 py-6">

    {{-- Welcome --}}
    <div class="mb-6">
        <h1 class="text-2xl font-bold text-gray-800">
            Welcome, Dr. {{ $doctor?->name ?? auth()->user()->name }}
        </h1>
        <p class="text-sm text-gray-500 mt-0.5">{{ now()->format('l, d F Y') }}</p>
    </div>

    {{-- Stats --}}
    <div class="grid grid-cols-2 gap-4 mb-8">
        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Today's Visits</p>
                <p class="text-3xl font-bold text-blue-600">{{ $todayPatients }}</p>
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5 flex items-center gap-4">
            <div class="w-12 h-12 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div>
                <p class="text-xs text-gray-500 uppercase tracking-wide font-medium">Total Patients Visited</p>
                <p class="text-3xl font-bold text-green-600">{{ $totalPatients }}</p>
            </div>
        </div>
    </div>

    {{-- Recent Patients --}}
    @if($recentPatients->isNotEmpty())
    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
        <div class="flex items-center justify-between px-5 py-3 border-b bg-gray-50">
            <h2 class="font-semibold text-gray-700 text-sm">Recent Patients</h2>
            <a href="{{ route('doctor.patients') }}" class="text-xs text-blue-600 hover:underline">View all →</a>
        </div>
        <table class="w-full text-sm">
            <thead class="text-xs uppercase text-gray-400 border-b bg-gray-50">
                <tr>
                    <th class="px-5 py-2 text-left">Name</th>
                    <th class="px-5 py-2 text-left">Mobile</th>
                    <th class="px-5 py-2 text-left">Gender</th>
                    <th class="px-5 py-2 text-left">Last Visit</th>
                    <th class="px-5 py-2 text-center">Action</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($recentPatients as $p)
                <tr class="hover:bg-gray-50 transition">
                    <td class="px-5 py-2.5 font-medium text-gray-800">{{ $p->patient_name }}</td>
                    <td class="px-5 py-2.5 text-gray-500">{{ $p->mobile }}</td>
                    <td class="px-5 py-2.5">
                        <span @class([
                            'px-2 py-0.5 rounded-full text-xs font-medium',
                            'bg-blue-100 text-blue-700'  => $p->gender === 'male',
                            'bg-pink-100 text-pink-700'  => $p->gender === 'female',
                            'bg-gray-100 text-gray-600'  => !in_array($p->gender, ['male','female']),
                        ])>{{ ucfirst($p->gender ?? '—') }}</span>
                    </td>
                    <td class="px-5 py-2.5 text-gray-500">
                        @php $last = $p->patientPrescriptionRecords->first(); @endphp
                        {{ $last ? \Carbon\Carbon::parse($last->visit_date)->format('d M Y') : '—' }}
                    </td>
                    <td class="px-5 py-2.5 text-center">
                        <a href="{{ route('prescription.new_patient', $p->id) }}"
                           class="inline-flex items-center px-3 py-1 rounded-lg bg-indigo-50 hover:bg-indigo-100 text-indigo-700 text-xs font-medium transition">
                            Prescribe
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>
