<div>
    <section id="doctors" class="bg-gray-50 py-10">
        <div class="container mx-auto px-4">

            {{-- Doctor Header --}}
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center bg-white shadow-lg rounded-2xl p-6">

                {{-- Doctor Image --}}
                <div class="flex justify-center">
                    @php
                        $imagePath = $doctor->picture && file_exists(storage_path('app/public/'.$doctor->picture))
                            ? asset('storage/'.$doctor->picture)
                            : asset('website/assets/img/default-doctor.png');
                    @endphp
                    <img src="{{ $imagePath }}"
                         alt="{{ $doctor->name }}"
                         class="w-48 h-48 rounded-full object-cover shadow-md">
                </div>

                {{-- Doctor Info --}}
                <div class="md:col-span-2">
                    <h2 class="text-2xl font-bold text-gray-800">{{ $doctor->name }}</h2>
                    <h5 class="text-lg text-gray-600">{{ $doctor->qualifications }}</h5>
                    <p class="mt-2"> {{ $doctor->special_training }}</p>

                    {{-- Positions --}}
                    @if(!empty($doctor->positions))
                        <ul class="list-disc list-inside mt-3 text-gray-700">
                            @foreach(explode("\n", $doctor->positions) as $position)
                                @if(!empty(trim($position)))
                                    <li>{{ $position }}</li>
                                @endif
                            @endforeach
                        </ul>
                    @endif

                    {{-- Social Links --}}
                    <div class="social">
                        @isset($doctor->twitter)
                            <a href="{{ $doctor->twitter }}" target="_blank"><i class="bi bi-twitter-x"></i></a>
                        @endisset
                        @isset($doctor->facebook)
                            <a href="{{ $doctor->facebook  }}" target="_blank" ><i class="bi bi-facebook"></i></a>
                        @endisset
                        @isset($doctor->instagram)
                            <a href="{{ $doctor->instagram }}" target="_blank"><i class="bi bi-instagram"></i></a>
                        @endisset
                        @isset($doctor->linkedin)
                            <a href="{{ $doctor->linkedin }}" target="_blank"><i class="bi bi-linkedin"></i></a>
                        @endisset
                    </div>
                </div>
            </div>

            {{-- Doctor Profile --}}
            <div class="mt-10 bg-white shadow-md rounded-xl p-6">
                <h4 class="text-xl font-bold text-gray-800 mb-3">Doctor Profile</h4>
                <p class="text-gray-700 leading-relaxed">{!! nl2br(e($doctor->doctor_profile)) !!}</p>
            </div>
        </div>
    </section>
</div>
