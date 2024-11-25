<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentesController;
use App\Http\Controllers\DatosController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------|
| Web Routes                                                                |
|--------------------------------------------------------------------------|
| Here is where you can register web routes for your application. These    |
| routes are loaded by the RouteServiceProvider and all of them will       |
| be assigned to the "web" middleware group. Make something great!          |
*/

Route::get('/', function () {
    return view('auth.login');
});

// Rutas sin autenticación


// Rutas protegidas por autenticación, excepto las relacionadas con /residentes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    //Rutas redirección por roles
     Route::get('/residentes', [ResidentesController::class, 'index'])->middleware('checkRole:Superusuario')->name('residentes.index');
    Route::get('/residentes-admin', [ResidentesController::class, 'indexadmin'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.indexadmin');
    Route::get('/residentes-aux', [ResidentesController::class, 'indexaux'])->middleware('checkRole:Superusuario,Auxiliar')->name('residentes.indexaux');
    
    Route::get('residentes/{id}/edit', [ResidentesController::class, 'edit'])->middleware('checkRole:Superusuario,Auxiliar')->name('residentes.edit');
    Route::get('residentes/{id}/editadmin', [ResidentesController::class, 'editadmin'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.editadmin');
    Route::put('residentes/{id}', [ResidentesController::class, 'update'])->middleware('checkRole:Superusuario,Auxiliar')->name('residentes.update');
    Route::put('residentes/{id}/admin', [ResidentesController::class, 'updateadmin'])->name('residentes.updateadmin');

    Route::get('/buscar-apto', [ResidentesController::class, 'showForm'])->middleware('checkRole:Superusuario,Auxiliar')->name('buscar.apto.form');
    Route::get('/buscar-aptoadmin', [ResidentesController::class, 'showFormadmin'])->middleware('checkRole:Superusuario,Administrador')->name('buscar.apto.formadmin');
    Route::post('/buscar-apto', [ResidentesController::class, 'search'])->middleware('checkRole:Superusuario,Auxiliar')->name('buscar.apto');
    Route::post('/buscar-aptoadmin', [ResidentesController::class, 'searchadmin'])->middleware('checkRole:Superusuario,Administrador')->name('buscar.aptoadmin');   
    
    
    Route::get('residentes/estadisticas', [ResidentesController::class, 'estadisticasResidentes'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.estadisticas');

    Route::get('/residentes/{id}/firmar', [ResidentesController::class, 'showSignatureForm'])->middleware('checkRole:Superusuario,Administrador','Auxiliar')->name('residentes.firmar');
    Route::post('/residentes/{id}/firmar', [ResidentesController::class, 'storeSignature'])->middleware('checkRole:Superusuario,Administrador','Auxiliar')->name('residentes.guardarFirma');

    
    Route::post('/upload', [ResidentesController::class, 'upload'])->middleware('checkRole:Superusuario,Administrador')->name('excel.upload');

    Route::get('/residentes/pdf', [ResidentesController::class, 'generarPDF'])->middleware('checkRole:Superusuario')->name('residentes.pdf');
    Route::get('/create-residentes', [ResidentesController::class, 'create'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.create');



    Route::resource('datos', DatosController::class);
    Route::get('datos', [DatosController::class, 'index'])->middleware('checkRole:Superusuario,Administrador')->name('datos.index');
    Route::get('datos/create', [DatosController::class, 'create'])->middleware('checkRole:Superusuario,Administrador')->name('datos.create');


    // Sin acceso
    
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('residentes/{id}', [ResidentesController::class, 'destroy'])->name('residentes.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
});

// Rutas que requieren autenticación y verificación del correo
Route::middleware(['auth', 'verified'])->group(function () {
    // Aquí van las rutas adicionales que requieran autenticación y verificación del correo, si las tienes.
});

require __DIR__ . '/auth.php';
