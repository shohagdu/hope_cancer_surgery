<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Posts;
use App\Livewire\PatientInfo;
use App\Livewire\PatientCreateForm;
use App\Livewire\PatientEditForm;
use App\Livewire\PatientView;
use App\Livewire\Dashboard;
use App\Livewire\WebpageContentManager;
use App\Livewire\DoctorInformation;
use App\Livewire\OrganizationSetup;
use App\Livewire\OnlineAppointmentManager;
use App\Livewire\Homepage;
use App\Livewire\DoctorDetails;


Route::get('/', Homepage::class)->name('home');

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
Route::get('patient_infos', PatientInfo::class)->middleware('auth')->name('patient.list');
Route::get('/patient/create', PatientCreateForm::class)->middleware(['auth'])->name('patient.create');
Route::get('/patient/view/{id}', PatientView::class)->middleware(['auth'])->name('patient.view');
Route::get('/patient/edit/{id}', PatientEditForm::class)->middleware(['auth'])->name('patient.edit');
Route::get('/contents', WebpageContentManager::class)->name('contents.index');
Route::get('/doctors', DoctorInformation::class)->name('doctors.index');
Route::get('/organization', OrganizationSetup::class)->name('organization.index');
Route::get('/onlineAppointment', OnlineAppointmentManager::class)->name('onlineAppointment.index');
Route::get('/doctor/{id}/{slug}', DoctorDetails::class)->name('doctor.details');


//

