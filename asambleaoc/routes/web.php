<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ResidentesController;
use App\Http\Controllers\DatosController;
use App\Http\Controllers\OpcionesController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PreguntasController;
use App\Http\Controllers\VotacionesController;

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
    //Admnistrador
    Route::get('/residentes', [ResidentesController::class, 'index'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.index');
    Route::get('/residentes-listado', [ResidentesController::class, 'indexadmin'])->middleware('checkRole:Administrador')->name('residentes.indexadmin');


    Route::get('/residentes-aux', [ResidentesController::class, 'indexaux'])->middleware('checkRole:Auxiliar')->name('residentes.indexaux');

    Route::get('residentes/{id}/edit', [ResidentesController::class, 'edit'])->middleware('checkRole:Superusuario,Auxiliar')->name('residentes.edit');
    Route::get('residentes/{id}/editadmin', [ResidentesController::class, 'editadmin'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.editadmin');
    Route::get('residentes/{id}/editaux', [ResidentesController::class, 'editaux'])->middleware('checkRole:Superusuario,Auxiliar')->name('residentes.editaux');
    Route::put('residentes/{id}', [ResidentesController::class, 'update'])->middleware('checkRole:Superusuario,Auxiliar, Administrador')->name('residentes.update');
    Route::put('residentes/{id}/admin', [ResidentesController::class, 'updateadmin'])->middleware('checkRole:Administrador')->name('residentes.updateadmin');
    Route::put('residentes/{id}/aux', [ResidentesController::class, 'updateaux'])->middleware('checkRole:Auxiliar')->name('residentes.updateaux');

    Route::get('/buscar-apto', [ResidentesController::class, 'showForm'])->middleware('checkRole:Auxiliar')->name('buscar.apto.form');
    Route::get('/buscar-aptoadmin', [ResidentesController::class, 'showFormadmin'])->middleware('checkRole:Superusuario,Administrador')->name('buscar.apto.formadmin');
    Route::get('/buscar-aptoaux', [ResidentesController::class, 'showFormaux'])->middleware('checkRole:Auxiliar')->name('buscar.apto.formaux');
    Route::post('/buscar-apto', [ResidentesController::class, 'search'])->middleware('checkRole:Auxiliar')->name('buscar.apto');
    Route::post('/buscar-aptoadmin', [ResidentesController::class, 'searchadmin'])->middleware('checkRole:Administrador')->name('buscar.aptoadmin');
    Route::post('/buscar-aptoaux', [ResidentesController::class, 'buscaraux'])->middleware('checkRole:Auxiliar')->name('buscar.aptoaux');


    Route::get('residentes/estadisticas', [ResidentesController::class, 'estadisticasResidentes'])->middleware('checkRole:Superusuario')->name('residentes.estadisticas');
    Route::get('residentes/estadisticasadmin', [ResidentesController::class, 'estadisticasResidentesadmin'])->middleware('checkRole:Administrador')->name('residentes.estadisticasadmin');

    Route::get('/residentes/{id}/firmar', [ResidentesController::class, 'showSignatureForm'])->middleware('checkRole:Superusuario,Administrador', 'Auxiliar')->name('residentes.firmar');
    Route::post('/residentes/{id}/firmar', [ResidentesController::class, 'storeSignature'])->middleware('checkRole:Superusuario,Administrador', 'Auxiliar')->name('residentes.guardarFirma');


    Route::post('/upload', [ResidentesController::class, 'upload'])->middleware('checkRole:Superusuario,Administrador')->name('excel.upload');
    Route::post('/carga', [ResidentesController::class, 'carga'])->middleware('checkRole:Administrador')->name('excel.carga');


    Route::get('/residentes/pdf', [ResidentesController::class, 'generarPDF'])->name('residentes.pdf');
    Route::get('/create-residentes', [ResidentesController::class, 'create'])->middleware('checkRole:Superusuario,Administrador')->name('residentes.create');
    Route::get('/create-residentesadmin', [ResidentesController::class, 'createadmin'])->middleware('checkRole:Administrador')->name('residentes.createadmin');



    Route::resource('datos', DatosController::class);
    Route::get('datos', [DatosController::class, 'index'])->middleware('checkRole:Administrador')->name('datos.index');
    Route::get('datos/create', [DatosController::class, 'create'])->middleware('checkRole:Administrador')->name('datos.create');


    // Sin acceso
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::delete('residentes/{id}', [ResidentesController::class, 'destroy'])->name('residentes.destroy');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');


    // ******** PARA LAS VOTACIONES **********

    // Ruta para crear preguntas

    // Ruta para mostrar todas las preguntas
    Route::get('/preguntas', [PreguntasController::class, 'index'])->name('preguntas.index');

    // Ruta para mostrar el formulario de creación de una nueva pregunta
    Route::get('/preguntas/create', [PreguntasController::class, 'create'])->middleware('checkRole:Administrador')->name('preguntas.create');
    
    Route::get('/qr', [VotacionesController::class, 'qr'])->name('buscar.qr');

    Route::post('/buscar-apto-votar', [VotacionesController::class, 'search'])->name('buscar.apto.votar');
    
    Route::get('/votaciones', [VotacionesController::class, 'index'])->name('votaciones.index');
    Route::get('/votaciones/buscar', [VotacionesController::class, 'buscar'])->name('votaciones.buscar');




    // Ruta para almacenar una nueva pregunta
    Route::post('/preguntas', [PreguntasController::class, 'store'])->name('preguntas.store');

    // Ruta para mostrar una pregunta específica
    Route::get('/preguntas/{pregunta}', [PreguntasController::class, 'show'])->name('preguntas.show');

    // Ruta para mostrar el formulario de edición de una pregunta
    Route::get('/preguntas/{pregunta}/edit', [PreguntasController::class, 'edit'])->name('preguntas.edit');
    
    // Ruta para actualizar una pregunta
    Route::put('/preguntas/{pregunta}', [PreguntasController::class, 'update'])->name('preguntas.update');
    

    // Ruta para eliminar una pregunta
    Route::delete('/preguntas/{pregunta}', [PreguntasController::class, 'destroy'])->name('preguntas.destroy');




    // Ruta para crear opciones
    Route::resource('preguntas', PreguntasController::class);

    // Rutas para las opciones
    Route::resource('opciones', OpcionesController::class);



    // Ruta para mostrar las opciones de una pregunta específica
    Route::get('/preguntas/{pregunta}/opciones', [OpcionesController::class, 'index'])->name('opciones.index');
    

    // Ruta para mostrar el formulario de creación de una nueva opción para una pregunta específica

    Route::get('preguntas/{pregunta}/opciones/create', [OpcionesController::class, 'create'])->name('opciones.create');

    // Ruta para almacenar una nueva opción para una pregunta específica
    // web.php

    Route::post('preguntas/{pregunta}/opciones', [OpcionesController::class, 'store'])->name('opciones.store');


    // Ruta para mostrar el formulario de edición de una opción específica
    Route::get('/opciones/{opcion}/edit', [OpcionesController::class, 'edit'])->name('opciones.edit');

    // Ruta para actualizar una opción específica
    Route::put('/opciones/{opcion}', [OpcionesController::class, 'update'])->name('opciones.update');

    // Ruta para eliminar una opción específica
    Route::delete('/opciones/{id}', [OpcionesController::class, 'destroy'])->name('opciones.destroy');








    // Ruta para crear votaciones

    Route::get('/buscar-apto-votar', [VotacionesController::class, 'showFormVotar'])->name('buscar.votar.form');

    // Ruta para mostrar todas las votaciones
    Route::get('/votaciones', [VotacionesController::class, 'index'])->name('votaciones.index');

    // Ruta para mostrar el formulario de creación de una nueva votación
    Route::get('/votaciones/create', [VotacionesController::class, 'create'])->name('votaciones.create');

    // Ruta para almacenar una nueva votación
    Route::post('/votaciones-votar', [VotacionesController::class, 'store'])->name('votaciones.store');

    // Ruta para mostrar una votación específica
    Route::get('/votaciones/{votacion}', [VotacionesController::class, 'show'])->name('votaciones.show');

    // Ruta para eliminar una votación específica
    Route::delete('/votaciones/{votacion}', [VotacionesController::class, 'destroy'])->name('votaciones.destroy');


    Route::get('/cociente', [VotacionesController::class, 'cociente'])->name('votaciones.cociente');
});

// Rutas que requieren autenticación y verificación del correo
Route::middleware(['auth', 'verified'])->group(function () {
    // Aquí van las rutas adicionales que requieran autenticación y verificación del correo, si las tienes.
});

require __DIR__ . '/auth.php';
