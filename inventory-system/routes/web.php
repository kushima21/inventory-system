<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\SuppliesController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\GymController;
use App\Http\Controllers\BookingController;
use Illuminate\Notifications\Notification;


Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('default', function () {
    return view('layout.default');
});

Route::get('/personnel_dashboard', function () {
    return view('personnel.personnel_dashboard');
});


Route::get('/settings/gym_reservation', function () {
    return view('settings.gym_reservation');
});

Route::get('/settings/reports', function () {
    return view('settings.reports');
});


Route::get('/settings/supplyReports', function () {
    return view('settings.supplyReports');
});

Route::get('/settings/supplies', function () {
    return view('settings.supplies');
});

Route::get('/settings/equipment', function () {
    return view('settings.equipment');
});

Route::get('/settings/gym', function () {
    return view('settings.gym');
});


Route::get('/settings/users', function () {
    return view('settings.users');
});


Route::get('/settings/inventory', function () {
    return view('settings.inventory');
});

Route::get('/faculty/facultyDashboard', function () {
    return view('faculty.facultyDashboard');
});

Route::get('/faculty/facultyProfile', function () {
    return view('faculty.facultyProfile');
});

Route::get('/faculty/facultyRequest', function () {
    return view('faculty.facultyRequest');
});

Route::get('/faculty/facultyMyRequest', function () {
    return view('faculty.facultyMyRequest');
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

Route::get('/customers/bookRequest', function () {
    return view('customers.bookRequest');
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


Route::get('/navbar', function () {
    $user = auth()->user(); // authenticated user
    return view('partials.navbar', compact('user'));
})->middleware('auth');

Route::get('/sideBar', function () {
    return view('partials.sideBar');
});

Route::get('/faculty/facultyRequest', [SuppliesController::class, 'facultySupplyDisplay'])->name('faculty.request');
Route::post('/faculty/request/store', [SuppliesController::class, 'storeFacultyRequest'])->name('faculty.request.store');
Route::get('/faculty/facultyMyRequest', [SuppliesController::class, 'facultyRequestDisplay'])->name('facultyMyRequest.facultyRequests');
Route::post('/faculty/facultyMyRequest/cancel/{id}', [SuppliesController::class, 'cancelFacultyRequest'])
    ->name('faculty.request.cancel');


 Route::get('/settings/supplyReports', [SuppliesController::class, 'facultyReports'])
    ->name('settings.supplyReports');
    
    
// Faculty request actions
// ✅ Correct controller route
// ✅ Faculty Supply Request Overview (Dashboard)
Route::get('/settings/requestSupply', [SuppliesController::class, 'facultyRequesOverview'])
    ->name('settings.requestSupply');

// ✅ Approve Faculty Request
Route::post('/settings/requestSupply/approve/{id}', [SuppliesController::class, 'approveRequest'])
    ->name('faculty.request.approve');

// ✅ Decline Faculty Request
Route::post('/settings/requestSupply/decline/{id}', [SuppliesController::class, 'declineRequest'])
    ->name('faculty.request.decline');

// ✅ Mark Faculty Request as Completed (deducts from inventory)
Route::post('/settings/requestSupply/complete/{id}', [SuppliesController::class, 'completeRequest'])
    ->name('faculty.request.complete');


Route::get('/settings/users', [UserController::class, 'index'])->name('settings.users');
Route::post('/settings/users', [UserController::class, 'store'])->name('users.store');
Route::get('/settings/users/search', [UserController::class, 'search'])->name('users.search');
Route::put('/settings/users/update/{id}', [UserController::class, 'update'])->name('users.update');
Route::delete('/settings/users/{id}', [UserController::class, 'destroy'])->name('users.destroy');


Route::post('/signup', [UserController::class, 'signup'])->name('signup.store');

Route::get('/settings/request', [SuppliesController::class, 'request'])->name('supplies.request');
Route::get('/settings/request/{id}', [SuppliesController::class, 'showRequest'])->name('supplies.request');


Route::post('/settings/supplies/{id}/add-more', [SuppliesController::class, 'addMore'])->name('supplies.addMore');
Route::delete('/settings/supplies/{id}', [SuppliesController::class, 'delete'])->name('supplies.delete');

Route::post('/settings/equipment/{id}/add-more', [EquipmentController::class, 'addMore'])->name('equipment.addMore');
Route::delete('/settings/equipment/{id}', [EquipmentController::class, 'delete'])->name('equipment.delete');
Route::get('/settings/gym', [EquipmentController::class, 'gym'])->name('settings.gym');

Route::post('/settings/gym/store', [GymController::class, 'store'])->name('gym.store');
Route::get('/settings/gym', [GymController::class, 'index'])->name('gym.index');
Route::delete('/settings/gym/{id}', [GymController::class, 'destroy'])->name('gym.destroy');
Route::post('/settings/gym/update/{id}', [GymController::class, 'update'])->name('gym.update');


Route::get('/book', [GymController::class, 'BookIndex'])->name('book.BookIndex');
Route::get('/settings/gym_reservation', [GymController::class, 'bookRequest'])->name('book.BookIndex');
Route::get('/customers/userRequest', [BookingController::class, 'showUserBookings'])->name('bookings.list');
Route::get('/customers/bookRequest', [BookingController::class, 'showUserBookings'])
    ->name('bookings.list');

Route::get('/booked-dates/{gymId}', [BookingController::class, 'getBookedDates'])->name('booked.dates');
Route::post('/notifications/mark-as-read', [BookingController::class, 'markAsRead'])->name('notifications.markAsRead');






// Wala na ni — ayaw i-overwrite
// Route::get('/home', fn() => view('customers.home'))->name('customers.home');



Route::get('/login', fn() => view('auth.login'))->name('login');
Route::post('/login', [UserController::class, 'login'])->name('login.post');

// 🔹 Logout route (POST only)
Route::post('/logout', [UserController::class, 'logout'])->name('logout');

Route::post('/logout', [UserController::class, 'navLogout'])->name('navLogout');

// 🔹 Role-based redirects
Route::get('/home', function () {
    $user = \App\Models\User::find(session('user_id'));
    return view('customers.home', compact('user'));
})->name('customers.home');

// 🔹 Custodian dashboard
Route::get('/settings/dashboard', function () {
    return view('settings.dashboard'); // Blade file at resources/views/settings/dashboard.blade.php
})->name('settings.dashboard');

// 🔹 Personnel dashboard
Route::get('/faculty/facultyDashboard', function () {
    return view('faculty.facultyDashboard');
})->name('faculty.facultyDashboard');

Route::get('/logout', [App\Http\Controllers\UserController::class, 'logout'])->name('logout');

// ✅ Booking route WITHOUT auth middleware
Route::post('/booking/store', [BookingController::class, 'store'])->name('booking.store');
Route::get('/customers/userRequest', [BookingController::class, 'showUserBookings'])->name('bookings.list');
Route::post('/customers/userRequest', [BookingController::class, 'cancelBooking'])->name('booking.cancel');

Route::get('/settings/gym_reservation', [BookingController::class, 'showRequestBooking'])->name('bookings.list');
Route::get('/settings/reports', [BookingController::class, 'showRequestReports'])->name('bookings.list');
Route::get('/settings/dashboard', [BookingController::class, 'showRequestDashboard'])->name('bookings.list');
Route::post('/booking/{id}/approve', [BookingController::class, 'approveBooking'])->name('booking.approve');
Route::post('/booking/{id}/complete', [BookingController::class, 'completeBooking'])->name('booking.complete');

// Inventory Section
// ✅ Unified Inventory Display Route
Route::get('/settings/inventory', [SuppliesController::class, 'inventory'])->name('inventory.create');
Route::put('/supplies/update/{id}', [SuppliesController::class, 'update'])->name('supplies.update');

// ✅ Supplies Routes
Route::post('/settings/inventory', [SuppliesController::class, 'store'])->name('supplies.store');
Route::delete('/settings/supplies/{id}', [SuppliesController::class, 'delete'])->name('supplies.delete');

// ✅ Equipment Routes
Route::post('/settings/equipment', [EquipmentController::class, 'store'])->name('equipment.store');
Route::delete('/equipment/delete/{equipment}', [EquipmentController::class, 'deleteByName'])->name('equipment.deleteByName');

Route::get('/settings/equipment', [EquipmentController::class, 'index'])->name('equipment.index');
Route::post('/settings/equipment-bundle/store', [EquipmentController::class, 'storeBundle'])->name('equipment.bundle.store');
Route::delete('/settings/equipment-bundle/delete/{id}', [EquipmentController::class, 'deleteBundle'])->name('equipment.bundle.delete');

Route::get('/customers/userBook', [EquipmentController::class, 'showUserBook'])->name('equipment.showUserBook');
Route::get('/customers/userBook', [GymController::class, 'userBook'])->name('customers.userBook');


    


Route::get('/settings/dashboard', [SuppliesController::class, 'dashboard'])
    ->name('settings.dashboard');

    Route::get('/export-supply-reports', [App\Http\Controllers\SuppliesController::class, 'exportSupplyReports'])->name('supply.export');


    Route::get('/reports/download', [BookingController::class, 'downloadReport'])->name('reports.download');
    Route::get('/reports', [BookingController::class, 'showRequestReports'])->name('reports.show');


Route::post('/equipment/update/{equipmentName}', [EquipmentController::class, 'update'])->name('equipment.update');



Route::get('/booking/invoice/{id}', [App\Http\Controllers\BookingController::class, 'generateInvoice'])->name('booking.invoice');


Route::get('/customers/profile', function () {
    return view('customers.profile');
})->name('customers.profile');

Route::put('/user/update/{id}', [UserController::class, 'updateCustomer'])->name('user.update');


Route::put('/equipment/bundle/update/{id}', [EquipmentController::class, 'updateEquipmentbundle'])
    ->name('equipment.bundle.update');

Route::get('/inventory', [SuppliesController::class, 'inventory'])->name('inventory');
Route::get('/inventory/search', [SuppliesController::class, 'searchSupplies'])->name('inventory.search');


Route::delete('/settings/supplies/{id}', [SuppliesController::class, 'destroy'])->name('supplies.delete');
Route::put('/faculty/update/{id}', [UserController::class, 'updateFaculty'])->name('faculty.updateProfile');

Route::get('/booked-dates', [BookingController::class, 'getBookedDates']);
