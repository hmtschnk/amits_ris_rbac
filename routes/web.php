<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;

Route::get('/role-access', [RolePermissionController::class, 'index'])->name('role-access.index');

Route::get('/get-functions-by-module/{moduleId}', [RolePermissionController::class, 'getFunctionsByModule']);
Route::post('/role-access/store', [RolePermissionController::class, 'store'])->name('role-access.store');
Route::put('/role-access/{id}', [RolePermissionController::class, 'update'])->name('role-access.update');
Route::delete('/role-access/{id}', [RolePermissionController::class, 'destroy'])->name('role-access.destroy');
