<?php

use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use App\Http\Controllers\resumenController;
use App\Http\Controllers\automotrizController;
use App\Http\Controllers\ManufacturaController;
use App\Http\Controllers\redesController;
use App\Http\Controllers\LAGEController;
use App\Http\Controllers\mecatronicaController;
use App\Http\Controllers\negociosController;
use App\Http\Controllers\posgradoController;
use App\Http\Controllers\sistemasController;
use App\Http\Controllers\coordinacionController;
use App\Http\Controllers\adminController;
use App\Http\Middleware\CheckRole;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return Inertia::render('Auth/Login', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    
    // ruta de INICIO, a esta pueden acceder todos los usuarios de todos los roles
    Route::get('/dashboard', [resumenController::class, 'viewBienvenida'])->name('dashboard');

    // MENU ADMINISTRACION
    Route::middleware(['auth', 'check.role:Administrador'])->group(function () {
        Route::get('/administracion', [adminController::class, 'administracionView'])->name('view.administracion');
        Route::post('/registrar-nuevo-usuario', [adminController::class, 'registrar']);
        Route::post('/asignar-rol/{id}', [adminController::class, 'asignarRol']);
        Route::post('/eliminar-usuario', [adminController::class, 'eliminar']);
        
    });

    Route::middleware(['auth', 'check.role:Resumen'])->group(function () { 
         // MENU RESUMEN
        Route::get('/resumen', [resumenController::class, 'resumenView'])->name('resumen');
        // REGISTRO
        Route::post('/registro-resumen', [resumenController::class, 'registrar']);
        // ELIMINAR
        Route::post('/eliminar-resumen', [resumenController::class, 'eliminar']);
        // EDITAR
        Route::post('/editar-resumen/{id}', [resumenController::class, 'editar']);
        //Actualizar el resumen
        Route::post('/actualizar-resumen', [resumenController::class, 'actualizarTbResumen']);
        // asignar act transversal
        Route::post('/asignar-act-transversal', [resumenController::class, 'asignarActTransversal']);
        // registrar una nueva actividad transveral
        Route::post('/registrar-act-transversal', [resumenController::class, 'registrarActTransversal']);
        // editar una actividad transveral
        Route::post('/editar-act-transversal/{id}', [resumenController::class, 'editarActividadTransversal']);
        // eliminar una actividad transversal
        Route::post('/eliminar-act-transversal', [resumenController::class, 'eliminarActividadTransversal']);
     });


    Route::middleware(['auth', 'check.role:Automotriz'])->group(function () {
        // ------------- MENU AUTOMOTRIZ -------------
        Route::get('/automotriz', [automotrizController::class, 'automotrizView'])->name('view.autromotriz');
        // REGISTRO
        Route::post('/registro-automotriz', [automotrizController::class, 'registrar']);
        // ELIMINAR
        Route::post('/eliminar-automotriz', [automotrizController::class, 'eliminar']);
        // EDITAR
        Route::post('/editar-automotriz/{id}', [automotrizController::class, 'editar']);
    });


    
    Route::middleware(['auth', 'check.role:Manufactura'])->group(function () { 
        // MENU MANUFACTURA
        Route::get('/manufactura', [ManufacturaController::class, 'manufacturaView'])->name('view.manufactura');
        // REGISTRO
        Route::post('/registro-manufactura', [ManufacturaController::class, 'registrar']);
        // ELIMINAR
        Route::post('/eliminar-manufactura', [ManufacturaController::class, 'eliminar']);
        // EDITAR
        Route::post('/editar-manufactura/{id}', [ManufacturaController::class, 'editar']);
    });


    Route::middleware(['auth', 'check.role:Redes'])->group(function () {
         // MENU REDES
        Route::get('/redes', [redesController::class, 'redesView'])->name('view.redes');
        // REGISTRO
        Route::post('/registro-redes', [redesController::class, 'registrar']);
        // ELIMINAR
        Route::post('/eliminar-redes', [redesController::class, 'eliminar']);
        // EDITAR
        Route::post('/editar-redes/{id}', [redesController::class, 'editar']);
    });
   


    Route::middleware(['auth', 'check.role:LAGE'])->group(function () {

        // MENU LAGE
        Route::get('/lage', [LAGEController::class, 'lageView'])->name('view.lage');
        // REGISTRO
        Route::post('/registro-lage', [LAGEController::class, 'registrar']);
        // ELIMINAR
        Route::post('/eliminar-lage', [LAGEController::class, 'eliminar']);
        // EDITAR
        Route::post('/editar-lage/{id}', [LAGEController::class, 'editar']);
     });

     Route::middleware(['auth', 'check.role:Mecatronica'])->group(function () { 

         // MENU MECATRONICA
         Route::get('/mecatronica', [mecatronicaController::class, 'mecatronicaView'])->name('view.mecatronica');
         // REGISTRO
         Route::post('/registro-mecatronica', [mecatronicaController::class, 'registrar']);
         // ELIMINAR
         Route::post('/eliminar-mecatronica', [mecatronicaController::class, 'eliminar']);
         // EDITAR
         Route::post('/editar-mecatronica/{id}', [mecatronicaController::class, 'editar']);
     });


     Route::middleware(['auth', 'check.role:Negocios'])->group(function () { 

         // MENU NEGOCIOS
         Route::get('/negocios', [negociosController::class, 'negociosView'])->name('view.negocios');
         // REGISTRO
         Route::post('/registro-negocios', [negociosController::class, 'registrar']);
         // ELIMINAR
         Route::post('/eliminar-negocios', [negociosController::class, 'eliminar']);
         // EDITAR
         Route::post('/editar-negocios/{id}', [negociosController::class, 'editar']);
     });

     Route::middleware(['auth', 'check.role:Posgrado'])->group(function () { 

         // MENU POSGRADO
         Route::get('/posgrado', [posgradoController::class, 'posgradoView'])->name('view.posgrado');
         // REGISTRO
         Route::post('/registro-posgrado', [posgradoController::class, 'registrar']);
         // ELIMINAR
         Route::post('/eliminar-posgrado', [posgradoController::class, 'eliminar']);
         // EDITAR
         Route::post('/editar-posgrado/{id}', [posgradoController::class, 'editar']);
     });

     Route::middleware(['auth', 'check.role:Sistemas'])->group(function () { 

         // MENU SISTEMAS
         Route::get('/sistemas', [sistemasController::class, 'sistemasView'])->name('view.sistemas');
         // REGISTRO
         Route::post('/registro-sistemas', [sistemasController::class, 'registrar']);
         // ELIMINAR
         Route::post('/eliminar-sistemas', [sistemasController::class, 'eliminar']);
         // EDITAR
         Route::post('/editar-sistemas/{id}', [sistemasController::class, 'editar']);
     });

     Route::middleware(['auth', 'check.role:Coordinacion'])->group(function () { 

         // MENU COORDINACION
         Route::get('/coordinacion', [coordinacionController::class, 'coordinacionView'])->name('view.coordinacion');
         // REGISTRO
         Route::post('/registro-coordinacion', [coordinacionController::class, 'registrar']);
         // ELIMINAR
         Route::post('/eliminar-coordinacion', [coordinacionController::class, 'eliminar']);
         // EDITAR
         Route::post('/editar-coordinacion/{id}', [coordinacionController::class, 'editar']);
     });

});
