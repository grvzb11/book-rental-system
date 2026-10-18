<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\BorrowerController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

Route::resource('books', BookController::class);
Route::resource('borrowers', BorrowerController::class);

Route::prefix('rentals')->name('rentals.')->group(function () {
    Route::get('/', [RentalController::class, 'index'])->name('index');
    Route::get('/create', [RentalController::class, 'create'])->name('create');
    Route::post('/', [RentalController::class, 'store'])->name('store');
    Route::post('/{rental}/return', [RentalController::class, 'returnBook'])->name('return');
});
