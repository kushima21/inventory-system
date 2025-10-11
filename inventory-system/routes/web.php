<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\BookingController;


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('default', function () {
    return view('layout.default');
});

Route::get('/personnel_dashboard', function () {
    return view('personnel.personnel_dashboard');
});

Route::get('/dashboard', function () {
    return view('settings.dashboard');
});

Route::get('/gym_reservation', function () {
    return view('settings.gym_reservation');
});

Route::get('/reports', function () {
    return view('settings.reports');
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

Route::get('/inventory', function () {
    return view('settings.inventory');
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

Route::get('/customers/home', function () {
    return view('customers.home');
});

Route::get('/customers/userAbout', function () {
    return view('customers.userAbout');
});

Route::get('/customers/userBook', function () {
    return view('customers.userBook');
});

Route::get('/customers/userContact', function () {
    return view('customers.userContact');
});

Route::get('/customers/userServices', function () {
    return view('customers.userServices');
});

Route::get('/customers/profile', function () {
    return view('customers.profile');
});

Route::get('/customers/bookRequest', function () {
    return view('customers.bookRequest');
});

Route::get('/navbar', function () {
    return view('partials.navbar');
});

Route::get('/sideBar', function () {
    return view('partials.sideBar');
});

Route::get('/personnel_dashboard', [UserController::class, 'index'])->name('personnel.personnel_dashboard');
Route::post('/personnel_dashboard', [UserController::class, 'store'])->name('users.store');
Route::get('/personnel_dashboard/search', [UserController::class, 'search'])->name('users.search');
Route::post('/signup', [UserController::class, 'signup'])->name('signup.store');

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


Route::get('/book', [GymController::class, 'BookIndex'])->name('book.BookIndex');
// Sakto nga route for Customers home
Route::get('/customers/userBook', [GymController::class, 'userBook'])->name('customers.userBook');

// Wala na ni — ayaw i-overwrite
// Route::get('/home', fn() => view('customers.home'))->name('customers.home');



Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');
Route::get('/logout', [UserController::class, 'logout'])->name('logout');

// Role-based redirects
Route::get('/home', function () {
    $user = \App\Models\User::find(session('user_id'));
    return view('customers.home', compact('user'));
})->name('customers.home');

Route::get('/admin/dashboard', fn() => view('admin.dashboard'))->name('admin.dashboard');
Route::get('/personnel/dashboard', fn() => view('personnel.personnel_dashboard'))->name('personnel.dashboard');

// ✅ Booking route WITHOUT auth middleware
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');


// Inventory Section
Route::get('/inventory', [SuppliesController::class, 'create'])->name('inventory.create');
Route::post('/inventory', [SuppliesController::class, 'store'])->name('supplies.store');