<div class="p-6 bg-white border-b border-gray-200">
    <h1 class="mt-2 text-3xl font-medium text-gray-900 text-center">
        Patient Management System
    </h1>
    <h2 class="mt-4 text-xl font-medium text-gray-900 text-center">
        Welcome to <span class="font-semibold"> Shaheed Suhrawardy Medical College Hospital, Unit-3</span>
    </h2>
    <div class="text-center">Sher-e-Bangla Nagar, Dhaka-1207</div>

    <p class="mt-6 text-gray-500 leading-relaxed text-justify">
        Shaheed Suhrawardy Medical College (ShSMC) is the 14th government medical college of Bangladesh which was established in 2006. It is situated in the north-western part of Dhaka beside the National Parliament House, having a unique architectural campus and excellent academic atmosphere. Shaheed Suhrawardy Medical College Hospital has a long heritage of discharging health care services and also has a proud history of patronizing many medical institutes to establish and flourish. We are committed to providing top-class medical education, excellent training and quality research through eminent and experienced teachers.
    </p>
</div>

<div class="bg-gray-200 bg-opacity-25 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 p-6">
    <!-- Total Patients -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <a href="{{ route('patient.list') }}">
            <h2 class="text-xl font-semibold text-gray-900 mb-2">
                Total Patients
            </h2>
            <div class="text-3xl font-bold text-blue-600">
               {{ !empty($totalPatient)?$totalPatient:'0' }}

            </div>
        </a>
    </div>

    <!-- Today's Patients -->
    <div class="bg-white rounded-lg shadow p-6 text-center">
        <h2 class="text-xl font-semibold text-gray-900 mb-2">
            <a href="#">Today Patients</a>
        </h2>
        <div class="text-3xl font-bold text-green-600">
            {{ !empty($todayPatient)?$todayPatient:'0' }}
        </div>
    </div>
</div>
