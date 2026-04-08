<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('welcome');
Route::view('/confidentialite', 'legal.privacy')->name('privacy');
Route::view('/conditions-utilisation', 'legal.cgu')->name('cgu');

Route::get('/dashboard', [DashboardController::class, 'index'])->middleware(['auth', 'verified','subscription'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/abonnement-expire', fn() => view('subscription.expired'))
    ->name('subscription.expired')
    ->middleware('auth');

// require __DIR__ . '/auth.php';
