<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentesController;
use App\Http\Controllers\DatosController;
use App\Http\Controllers\OpcionesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\VotacionesController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
| Aquí es donde puedes registrar las rutas web de tu aplicación. Estas
| rutas se cargan por el RouteServiceProvider dentro del grupo "web".
*/

Route::get('/', function () {
    return view('auth.login');
});

// Rutas sin autenticación
Route::post('/buscar-apto-votar', [VotacionesController::class, 'search'])->name('buscar.apto.votar');
Route::get('/votaciones', [VotacionesController::class, 'index'])->name('votaciones.index');
Route::get('/buscar-apto-votar', [VotacionesController::class, 'showFormVotar'])->name('buscar.votar.form');
Route::get('/votaciones/create', [VotacionesController::class, 'create'])->name('votaciones.create');
Route::post('/votaciones-votar', [VotacionesController::class, 'store'])->name('votaciones.store');
Route::delete('/votaciones/{votacion}', [VotacionesController::class, 'destroy'])->name('votaciones.destroy');

// Rutas protegidas por autenticación
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/residentes', [ResidentesController::class, 'index'])->middleware('checkRole:Superusuario')->name('residentes.index');
    Route::get('/residentes-listado', [ResidentesController::class, 'indexadmin'])->middleware('checkRole:Administrador')->name('residentes.indexadmin');
    Route::get('/residentes-aux', [ResidentesController::class, 'indexaux'])->middleware('checkRole:Auxiliar')->name('residentes.indexaux');

    Route::get('/buscar-aptoadmin', [ResidentesController::class, 'showFormadmin'])->middleware('checkRole:Administrador')->name('buscar.apto.formadmin');
    Route::get('/buscar-aptoaux', [ResidentesController::class, 'showFormaux'])->middleware('checkRole:Auxiliar')->name('buscar.apto.formaux');
    Route::post('/buscar-aptoadmin', [ResidentesController::class, 'searchadmin'])->middleware('checkRole:Administrador')->name('buscar.aptoadmin');
    Route::post('/buscar-aptoaux', [ResidentesController::class, 'buscaraux'])->middleware('checkRole:Auxiliar')->name('buscar.aptoaux');

    Route::get('residentes/{id}/editadmin', [ResidentesController::class, 'editadmin'])->middleware('checkRole:Administrador')->name('residentes.editadmin');
    Route::get('residentes/{id}/editaux', [ResidentesController::class, 'editaux'])->middleware('checkRole:Auxiliar')->name('residentes.editaux');
    Route::put('residentes/{id}/admin', [ResidentesController::class, 'updateadmin'])->middleware('checkRole:Administrador')->name('residentes.updateadmin');
    Route::put('residentes/{id}/aux', [ResidentesController::class, 'updateaux'])->middleware('checkRole:Auxiliar')->name('residentes.updateaux');

    Route::get('residentes/estadisticasadmin', [ResidentesController::class, 'estadisticasResidentesadmin'])->middleware('checkRole:Administrador')->name('residentes.estadisticasadmin');

    Route::post('/upload', [ResidentesController::class, 'upload'])->middleware('checkRole:Administrador')->name('excel.upload');
    Route::post('/carga', [ResidentesController::class, 'carga'])->middleware('checkRole:Administrador')->name('excel.carga');

    Route::get('/residentes/pdf', [ResidentesController::class, 'generarPDF'])->middleware('checkRole:Superusuario')->name('residentes.pdf');
    Route::get('/create-residentesadmin', [ResidentesController::class, 'createadmin'])->middleware('checkRole:Administrador')->name('residentes.createadmin');

    Route::resource('datos', DatosController::class)->middleware('checkRole:Administrador');

    Route::get('/preguntas', [PreguntasController::class, 'index'])->middleware('checkRole:Administrador')->name('preguntas.index');
    Route::get('/preguntas/create', [PreguntasController::class, 'create'])->middleware('checkRole:Administrador')->name('preguntas.create');
    Route::post('/preguntas', [PreguntasController::class, 'store'])->middleware('checkRole:Administrador')->name('preguntas.store');
    Route::get('/preguntas/{pregunta}', [PreguntasController::class, 'show'])->middleware('checkRole:Administrador')->name('preguntas.show');
    Route::get('/preguntas/{pregunta}/edit', [PreguntasController::class, 'edit'])->middleware('checkRole:Administrador')->name('preguntas.edit');
    Route::put('/preguntas/{pregunta}', [PreguntasController::class, 'update'])->middleware('checkRole:Administrador')->name('preguntas.update');
    Route::delete('/preguntas/{pregunta}', [PreguntasController::class, 'destroy'])->middleware('checkRole:Administrador')->name('preguntas.destroy');

    Route::resource('opciones', OpcionesController::class)->middleware('checkRole:Administrador');
    Route::get('/preguntas/{pregunta}/opciones', [OpcionesController::class, 'index'])->middleware('checkRole:Administrador')->name('opciones.index');
    Route::get('preguntas/{pregunta}/opciones/create', [OpcionesController::class, 'create'])->middleware('checkRole:Administrador')->name('opciones.create');
    Route::post('preguntas/{pregunta}/opciones', [OpcionesController::class, 'store'])->middleware('checkRole:Administrador')->name('opciones.store');
    Route::get('/opciones/{opcion}/edit', [OpcionesController::class, 'edit'])->middleware('checkRole:Administrador')->name('opciones.edit');
    Route::put('/opciones/{opcion}', [OpcionesController::class, 'update'])->middleware('checkRole:Administrador')->name('opciones.update');
    Route::delete('/opciones/{id}', [OpcionesController::class, 'destroy'])->middleware('checkRole:Administrador')->name('opciones.destroy');

    Route::get('/qr', [VotacionesController::class, 'qr'])->middleware('checkRole:Administrador')->name('buscar.qr');
    Route::get('/cociente', [VotacionesController::class, 'cociente'])->middleware('checkRole:Administrador')->name('votaciones.cociente');
});

// Rutas que requieren autenticación y verificación del correo
Route::middleware(['auth', 'verified'])->group(function () {
    // Agregar aquí las rutas adicionales si las necesitas.
});

require __DIR__ . '/auth.php';
