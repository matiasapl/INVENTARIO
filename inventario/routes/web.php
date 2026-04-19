<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\RegistroController;
use App\Http\Controllers\LotesController;
use App\Http\Controllers\AlmacenController;

//Punto de entrada de la Web
Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');



Route::middleware(['auth', 'verified'])->group(function () {
    
    //--------Inicio Secciones de la APP--------
    Route::get('dashboard',  [ProductController::class, 'dashboard'])->name('dashboard');
    Route::get('productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::get('lotes', [LotesController::class, 'index'])->name('lotes.index');
    Route::get('registros', [RegistroController::class, 'index'])->name('registros.index');
    
    //--------Fin Secciones de la APP--------

    //--------Inicio Productos--------
    //Productos Index
    Route::get('/productos/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/productos/papelera', [ProductController::class, 'papelera'])->name('products.papelera');
    Route::get('/productos/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/productos/view/{product}', [ProductController::class, 'view'])->name('products.view');
    Route::get('/productos/{product}/deshabilitar', [ProductController::class, 'deshabilitar'])->name('products.deshabilitar');

    //Productos Papelera 
    Route::get('/productos/{product}/habilitar', [ProductController::class, 'habilitar'])->name('products.habilitar');
    Route::delete('/productos/{product}/eliminar', [ProductController::class, 'eliminar'])->name('products.eliminar');

    //Crear Productos 
    Route::post('/productos/store', [ProductController::class, 'store'])->name('products.store');

    //Editar Productos 
    Route::put('/productos/update/{product}', [ProductController::class, 'update'])->name('products.update');

    //--------Fin Productos--------

    //--------Inicio Almacenes--------
    //Almacenes Index
    Route::get('/almacenes/create', [AlmacenController::class, 'create'])->name('almacenes.create');
    Route::get('/almacenes/papelera', [AlmacenController::class, 'papelera'])->name('almacen.papelera');
    Route::get('/almacenes/edit/{almacen}', [AlmacenController::class, 'edit'])->name('almacen.edit');
    Route::get('/almacenes/view/{almacen}', [AlmacenController::class, 'view'])->name('almacen.view');
    Route::get('/almacenes/{almacen}/deshabilitar', [AlmacenController::class, 'deshabilitar'])->name('almacen.deshabilitar');
    
    //Almacenes Papelera 
    Route::get('/almacenes/{almacen}/habilitar', [AlmacenController::class, 'habilitar'])->name('almacen.habilitar');
    Route::delete('/almacenes/{almacen}/eliminar', [AlmacenController::class, 'eliminar'])->name('almacen.eliminar');

    //Almacenes Crear
    Route::post('/almacenes/store', [AlmacenController::class, 'store'])->name('almacen.store');

    //Almacenes Editar
    Route::put('/almacenes/update/{almacen}', [AlmacenController::class, 'update'])->name('almacen.update');

    //--------Fin Almacenes--------




    //--------Inicio Lotes--------
    //Lotes Index
    Route::get('/lotes/create', [LotesController::class, 'create'])->name('lotes.create');
    Route::get('/lotes/papelera', [LotesController::class, 'papelera'])->name('lotes.papelera');
    Route::get('/lotes/edit/{lote}', [LotesController::class, 'edit'])->name('lotes.edit');
    Route::get('/lotes/view/{lote}', [LotesController::class, 'view'])->name('lotes.view');
    Route::get('/lotes/{Lote}/deshabilitar', [LotesController::class, 'deshabilitar'])->name('lotes.deshabilitar');
    
    //Lotes Papelera
    Route::get('/lotes/{Lote}/habilitar', [LotesController::class, 'habilitar'])->name('lotes.habilitar');
    Route::delete('/lotes/{Lote}/eliminar', [LotesController::class, 'eliminar'])->name('lotes.eliminar');

    //Lotes Crear
    Route::post('/lotes/store', [LotesController::class, 'store'])->name('lotes.store');
    
    //Lotes Editar
    Route::put('/lotes/update/{lote}', [LotesController::class, 'update'])->name('lotes.update');

    //--------Fin Lotes--------
    });
require __DIR__.'/settings.php';



