<?php

use App\Http\Controllers\ChinaBankProcessController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('/china_banks', ChinaBankProcessController::class);
    Route::controller(ChinaBankProcessController::class)->group(function(){
        Route::get('/china-banks-process', 'getProcesses')->name('china_banks.process');
        Route::get('/china-banks-create-process', 'createProcesses')->name('china_banks.create_process');
    });
});

require __DIR__.'/auth.php';
