<div class="p-6 bg-white border-b border-gray-200">
    <h1 class="mt-2 text-3xl font-medium text-gray-900 text-center">
        Hope Centre for Cancer Surgery and Research    </h1>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
    <!-- Total Patients -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <a href="{{ route('doctors.index') }}">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                Total Doctors
            </h2>
            <div class="text-3xl font-bold text-blue-600">
               {{ !empty($doctors)?$doctors:'0' }}

            </div>
        </a>
    </div>

    <!-- Today's Patients -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <a href="{{ route('onlineAppointment.index') }}">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                Today Online Appointment
            </h2>
            <div class="text-3xl font-bold text-green-600">
                {{ !empty($todayOnlineAppointment)?$todayOnlineAppointment:'0' }}
            </div>
        </a>
    </div>
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <a href="{{ route('onlineAppointment.index') }}">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">
               Total Online Appointment
            </h2>
            <div class="text-3xl font-bold text-green-600">
                {{ !empty($totalOnlineAppointment)?$totalOnlineAppointment:'0' }}
            </div>
        </a>
    </div>

</div>
