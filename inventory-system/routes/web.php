
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;


Route::get('/default', function () {
    return view('layout.default');
});

Route::get('/personnel_dashboard', function () {
    return view('personnel.personnel_dashboard');
});
Route::get('/personnel_dashboard', [UserController::class, 'index'])->name('personnel.personnel_dashboard');
Route::post('/personnel_dashboard', [UserController::class, 'store'])->name('users.store');
Route::get('/personnel_dashboard', [UserController::class, 'search'])->name('users.search');
