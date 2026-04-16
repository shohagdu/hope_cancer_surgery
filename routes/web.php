<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Posts;
use App\Livewire\Dashboard;
use App\Livewire\WebpageContentManager;
use App\Livewire\DoctorInformation;
use App\Livewire\OrganizationSetup;
use App\Livewire\OnlineAppointmentManager;
use App\Livewire\Homepage;
use App\Livewire\DoctorDetails;
use App\Livewire\PrescriptionList;
use App\Livewire\PatientListPage;
use App\Livewire\PatientPrescriptions;
use App\Livewire\DoctorDashboard;
use App\Livewire\DoctorProfile;
use App\Livewire\PrescriptionSettings;
use App\Livewire\WhyChooseUs;
use App\Livewire\ServiceDetails;
use App\Livewire\MedicineRecord;


Route::get('/', Homepage::class)->name('home');
Route::get('/why-choose-us', WhyChooseUs::class)->name('why-choose-us');
Route::get('/service/{id}/{slug}', ServiceDetails::class)->name('service.details');

Route::get('/home', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');

    Route::get('dashboard', Dashboard::class)->name('dashboard');
});
Route::get('posts', Posts::class)->middleware('auth');
Route::get('/contents', WebpageContentManager::class)->name('contents.index');
Route::get('/doctors', DoctorInformation::class)->name('doctors.index');
Route::get('/organization', OrganizationSetup::class)->name('organization.index');
Route::get('/medicine-records', MedicineRecord::class)->name('medicine.records');
Route::get('/onlineAppointment', OnlineAppointmentManager::class)->name('onlineAppointment.index');
Route::get('/doctor/{id}/{slug}', DoctorDetails::class)->name('doctor.details');

Route::get('/prescription/new_patient/{id}', PrescriptionList::class)->middleware(['auth'])->name('prescription.new_patient');

// Shared (admin + doctor)
Route::middleware(['auth'])->group(function () {
    Route::get('/patients', PatientListPage::class)->name('patients.index');
    Route::get('/patient/{id}/prescriptions', PatientPrescriptions::class)->name('patient.prescriptions');
});

// Doctor-only routes
Route::middleware(['auth', 'role:doctor'])->group(function () {
    Route::get('/doctor/dashboard', DoctorDashboard::class)->name('doctor.dashboard');
    Route::get('/doctor/patients', PatientListPage::class)->name('doctor.patients');
    Route::get('/doctor/settings', PrescriptionSettings::class)->name('doctor.settings');
    Route::get('/doctor/profile', DoctorProfile::class)->name('doctor.profile');
});


//

