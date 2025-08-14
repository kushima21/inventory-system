<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\EquipmentController;

Route::get('default', function () {
    return view('layout.default');
});

Route::get('/personnel_dashboard', function () {
    return view('personnel.personnel_dashboard');
});

Route::get('/supplies', function () {
    return view('settings.supplies');
});

Route::get('/equipment', function () {
    return view('settings.equipment');
});

Route::get('/gym', function () {
    return view('settings.gym');
});

Route::get('/facultyDashboard', function () {
    return view('faculty.facultyDashboard');
});

Route::get('/request', function () {
    return view('faculty.request');
});

Route::get('/personnel_dashboard', [UserController::class, 'index'])->name('personnel.personnel_dashboard');
Route::post('/personnel_dashboard', [UserController::class, 'store'])->name('users.store');
Route::get('/personnel_dashboard', [UserController::class, 'search'])->name('users.search');


Route::get('/supplies', [SuppliesController::class, 'create'])->name('supplies.create');
Route::post('/supplies', [SuppliesController::class, 'store'])->name('supplies.store');

Route::post('/supplies/{id}/add-more', [SuppliesController::class, 'addMore'])->name('supplies.addMore');
Route::delete('/supplies/{id}', [SuppliesController::class, 'delete'])->name('supplies.delete');

Route::get('/equipment', [EquipmentController::class, 'create'])->name('equipment.create');
Route::post('/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
Route::post('/equipment/{id}/add-more', [EquipmentController::class, 'addMore'])->name('equipment.addMore');
Route::delete('/equipment/{id}', [EquipmentController::class, 'delete'])->name('equipment.delete');