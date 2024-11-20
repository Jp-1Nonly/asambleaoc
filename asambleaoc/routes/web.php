<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentesController;
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
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/residentes', [ResidentesController::class, 'index'])->name('residentes.index');
Route::get('/create-residentes', [ResidentesController::class, 'create'])->name('residentes.create');
Route::post('/upload', [ResidentesController::class, 'upload'])->name('excel.upload');
Route::get('residentes/{id}/edit', [ResidentesController::class, 'edit'])->name('residentes.edit');
Route::put('residentes/{id}', [ResidentesController::class, 'update'])->name('residentes.update');
Route::delete('residentes/{id}', [ResidentesController::class, 'destroy'])->name('residentes.destroy');
Route::get('residentes/estadisticas', [ResidentesController::class, 'estadisticasResidentes'])->name('residentes.estadisticas');



Route::get('/residentes/{id}/firmar', [ResidentesController::class, 'showSignatureForm'])->name('residentes.firmar');
Route::post('/residentes/{id}/firmar', [ResidentesController::class, 'storeSignature'])->name('residentes.guardarFirma');
Route::put('residentes/{id}', [ResidentesController::class, 'update'])->name('residentes.update');




require __DIR__.'/auth.php';
