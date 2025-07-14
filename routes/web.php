<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Livewire\Posts;
use App\Livewire\PatientInfo;
use App\Livewire\PatientCreateForm;
use App\Livewire\PatientEditForm;
use App\Livewire\PatientView;
use App\Livewire\Dashboard;

Route::get('/', function () {
    return view('welcome');
   // return redirect()->route(Auth::check() ? 'dashboard' : 'login');
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
