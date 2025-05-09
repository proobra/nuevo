<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PresupuestoController;
use App\Http\Controllers\ReplanteoController;
use App\Http\Controllers\PresupuestoDetalleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\ConfiguracionController;
use App\Http\Controllers\GastoFijoConfigurableController;
use App\Http\Controllers\ManoDeObraController;
use App\Http\Controllers\LaudoOperarioController;

Route::middleware(['auth'])->group(function () {

    // Página de inicio redirige a dashboard
    Route::get('/', fn() => redirect()->route('dashboard'));

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Página principal de configuración
    Route::get('/configuracion', [ConfiguracionController::class, 'index'])->name('configuracion.index');

    // CRUD de gastos fijos configurables (con nombres personalizados)
    Route::resource('configuracion/gastos-fijos', GastoFijoConfigurableController::class)
         ->names('configuracion.gastos-fijos');

    // Presupuestos
    Route::get('/presupuestos', [PresupuestoController::class, 'index'])->name('presupuestos.index');
    Route::put('/presupuestos/{id}', [PresupuestoController::class, 'update'])->name('presupuestos.update');
    Route::get('/presupuestos/{id}/edit', [PresupuestoController::class, 'edit'])->name('presupuestos.edit');
    Route::get('/presupuestos/create', [App\Http\Controllers\PresupuestoController::class, 'create'])->name('presupuestos.create');
    Route::get('/inicio', fn() => redirect()->route('dashboard'))->name('inicio');



    // Detalle editable de presupuesto
        Route::post('/presupuestos/{id}/costos', [PresupuestoDetalleController::class, 'storeCostos'])->name('presupuestos.costos.store');

    // Materiales
    Route::post('/materiales', [MaterialController::class, 'store'])->name('materiales.store');
    Route::put('/materiales/{id}', [MaterialController::class, 'update'])->name('materiales.update');

    // Mano de obra
    Route::put('/mano-de-obra/{id}', [ManoDeObraController::class, 'update'])->name('mano-de-obra.update');

    // Replanteo
    Route::get('/presupuestos/{id}/replanteo', [ReplanteoController::class, 'index'])->name('replanteo.index');
    Route::get('/presupuestos/{id}/replanteo/create', [ReplanteoController::class, 'create'])->name('replanteo.create');
    Route::post('/presupuestos/{id}/replanteo', [ReplanteoController::class, 'store'])->name('replanteo.store');
    Route::put('/replanteos/{id}', [ReplanteoController::class, 'update'])->name('replanteos.update');


    //Route::resource('presupuestos', PresupuestoController::class)->middleware('auth');


    // Pagina configuraciones
    Route::get('/configuraciones', [ConfiguracionController::class, 'index'])->name('configuraciones.index');
    Route::post('/configuraciones/laudos', [ConfiguracionController::class, 'updateLaudos'])->name('configuraciones.laudos.update');

    //Formulario de busqueda por id direccion etc
    Route::get('/presupuestos/buscar', [PresupuestoController::class, 'buscar'])->name('presupuestos.buscar');

    // Laudos operarios
    Route::prefix('config')->middleware('auth')->group(function () {
    Route::resource('laudos', LaudoOperarioController::class);
    });


    Route::get('/configuracion/laudos', [LaudoOperarioController::class, 'index'])->name('laudos.index');

    Route::get('/configuracion/laudos', [LaudoOperarioController::class, 'index'])->name('laudos.index');
    Route::post('/configuracion/laudos', [LaudoOperarioController::class, 'store'])->name('laudos.store');
    Route::put('/configuracion/laudos/{id}', [LaudoOperarioController::class, 'update'])->name('laudos.update');
    Route::delete('/configuracion/laudos/{id}', [LaudoOperarioController::class, 'destroy'])->name('laudos.destroy');
    Route::get('/presupuestos/{id}/detalle', [PresupuestoDetalleController::class, 'show'])->name('presupuesto.detalle');
    Route::post('/presupuestos', [PresupuestoController::class, 'store'])->name('presupuestos.store');
    
    // Vista Excel
    //Route::get('/presupuestos/{id}/resumen-m2', [App\Http\Controllers\PresupuestoController::class, 'resumenM2'])->name('presupuestos.resumen_m2');

// 🧾 Ruta para Informe Técnico
// Botones de acciones en presupuesto
Route::get('/presupuestos/{id}/informe-tecnico', [PresupuestoController::class, 'informeTecnico'])->name('presupuestos.informe_tecnico');
Route::post('/presupuestos/{id}/marcar-aceptado', [PresupuestoController::class, 'marcarAceptado'])->name('presupuestos.marcar_aceptado');
Route::post('/presupuestos/{id}/iniciar-obra', [PresupuestoController::class, 'iniciarObra'])->name('presupuestos.iniciar_obra');
Route::post('/presupuestos/{id}/crear-hijo', [PresupuestoController::class, 'crearHijo'])->name('presupuestos.crear_hijo');
Route::post('/presupuestos/{id}/duplicar', [PresupuestoController::class, 'duplicar'])->name('presupuestos.duplicar');
Route::post('/presupuestos/{id}/pausar-obra', [PresupuestoController::class, 'pausarObra'])->name('presupuestos.pausar');
Route::post('/presupuestos/{id}/finalizar-obra', [PresupuestoController::class, 'finalizarObra'])->name('presupuestos.finalizar');
Route::post('/presupuestos/{id}/en-revision', [PresupuestoController::class, 'enRevision'])->name('presupuestos.en_revision');

Route::get('/presupuestos/{id}/crear-hijo', [PresupuestoController::class, 'crearHijo'])->name('presupuestos.crear_hijo');


// Ruta del dashboard
Route::get('/dashboard', function () {
    return view('dashboard');
})->name('dashboard');

// Redirección del inicio al dashboard
Route::get('/', function () {
    return redirect()->route('dashboard');
});


});

// Autenticación
require __DIR__.'/auth.php';
