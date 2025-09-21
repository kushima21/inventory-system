<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GymController;

Route::get('/', function () {
    return view('index');
})->name('home');

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


Route::get('/login', function () {
    return view('auth.login');
});

Route::get('/signup', function () {
    return view('auth.signup');
});


Route::get('about', function () {
    return view('about');
});

Route::get('book', function () {
    return view('book');
});

Route::get('contact', function () {
    return view('contact');
});

Route::get('services', function () {
    return view('services');
});

Route::get('/home', function () {
    return view('customers.home');
});

Route::get('/userAbout', function () {
    return view('customers.userAbout');
});

Route::get('/userBook', function () {
    return view('customers.userBook');
});

Route::get('/userContact', function () {
    return view('customers.userContact');
});

Route::get('/userServices', function () {
    return view('customers.userServices');
});

Route::get('/navbar', function () {
    return view('partials.navbar');
});

Route::get('/personnel_dashboard', [UserController::class, 'index'])->name('personnel.personnel_dashboard');
Route::post('/personnel_dashboard', [UserController::class, 'store'])->name('users.store');
Route::get('/personnel_dashboard/search', [UserController::class, 'search'])->name('users.search');
Route::post('/signup', [UserController::class, 'signup'])->name('signup.store');

Route::get('/supplies', [SuppliesController::class, 'create'])->name('supplies.create');
Route::post('/supplies', [SuppliesController::class, 'store'])->name('supplies.store');
Route::get('/request', [SuppliesController::class, 'request'])->name('supplies.request');
Route::get('/request/{id}', [SuppliesController::class, 'showRequest'])->name('supplies.request');


Route::post('/supplies/{id}/add-more', [SuppliesController::class, 'addMore'])->name('supplies.addMore');
Route::delete('/supplies/{id}', [SuppliesController::class, 'delete'])->name('supplies.delete');

Route::get('/equipment', [EquipmentController::class, 'create'])->name('equipment.create');
Route::post('/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
Route::post('/equipment/{id}/add-more', [EquipmentController::class, 'addMore'])->name('equipment.addMore');
Route::delete('/equipment/{id}', [EquipmentController::class, 'delete'])->name('equipment.delete');
Route::get('/gym', [EquipmentController::class, 'gym'])->name('settings.gym');

Route::post('/gym/store', [GymController::class, 'store'])->name('gym.store');
Route::get('/gym', [GymController::class, 'index'])->name('gym.index');
Route::delete('/gym/{id}', [GymController::class, 'destroy'])->name('gym.destroy');
