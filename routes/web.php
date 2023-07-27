<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ApartmentController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SponsorController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->prefix("admin")->name('admin.')->group(function () {

    Route::resource('/apartments',ApartmentController::class);
    Route::get('/apartments/{apartment}/visibility', [ApartmentController::class, 'visibility'])->name('apartments.visibility');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::delete('/message/{message}', [MessageController::class, 'destroy'])->name('message.destroy');
Route::get('/message', [MessageController::class, 'index'])->name('message');

Route::get('/checkout/{apartment_id}', [SponsorController::class, 'checkout'])->name('checkout');

Route::post('/sponsor/{apartment_id}', [SponsorController::class, 'processPayment'])->name('processPayment');

require __DIR__.'/auth.php';
