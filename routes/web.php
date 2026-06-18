<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\RolePermissionController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PatientReferralController;
use App\Http\Controllers\ModuleConfigController;


//Auth
Route::get('/', [AuthController::class, 'index'])->name('home');
Route::get('/login', [AuthController::class, 'show'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('auth.login');
Route::get('/logout', [AuthController::class, 'show']);
Route::post('/logout', [AuthController::class, 'destroy'])->name('auth.destroy');

// Role Access Routes
Route::get('/role-access', [RolePermissionController::class, 'index'])
    ->name('role-access.index')
    ->middleware('auth'); 

Route::get('/get-functions-by-module/{moduleId}', [RolePermissionController::class, 'getFunctionsByModule']);
Route::post('/role-access/store', [RolePermissionController::class, 'store'])->name('role-access.store');
Route::put('/role-access/{id}', [RolePermissionController::class, 'update'])->name('role-access.update');
Route::delete('/role-access/{id}', [RolePermissionController::class, 'destroy'])->name('role-access.destroy');



// Module Config AJAX Routes (no page, JSON only)
Route::group(['middleware' => ['auth']], function () {
    Route::post('/module-config/store-module', [ModuleConfigController::class, 'storeModule'])
        ->name('module-config.store-module');
 
    Route::post('/module-config/store-function', [ModuleConfigController::class, 'storeFunction'])
        ->name('module-config.store-function');
});

// Patient Referral Feature Route Management
Route::group(['middleware' => ['auth']], function () {
    Route::get('/patient-referral', [PatientReferralController::class, 'listing'])->name('patient_referral.listing');
    Route::get('/patient-referral/create', [PatientReferralController::class, 'create'])->name('patient_referral.create');
    Route::post('/patient-referral/store', [PatientReferralController::class, 'store'])->name('patient_referral.store');
    Route::get('/patient-referral/{id}/edit', [PatientReferralController::class, 'edit'])->name('patient_referral.edit');
    Route::put('/patient-referral/{id}', [PatientReferralController::class, 'update'])->name('patient_referral.update');
    Route::delete('/patient-referral/{id}', [PatientReferralController::class, 'delete'])->name('patient_referral.destroy');
    
    // Fallback placeholders to prevent crashes if these buttons are clicked
    Route::get('/patient-referral/{id}/pdf', [PatientReferralController::class, 'listing'])->name('patient_referral.pdf');
    Route::get('/patient-referral/{id}/email', [PatientReferralController::class, 'listing'])->name('patient_referral.email');


});
