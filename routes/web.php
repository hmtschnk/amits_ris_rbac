<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RolePermissionController;

Route::get('/role-access', [RolePermissionController::class, 'index'])->name('role-access.index');