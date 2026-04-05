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


//Dashboard
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard',  [ProductController::class, 'dashboard'])->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    // Secciones
    Route::get('/productos', [ProductController::class, 'index'])->name('products.index');
    Route::get('/registros', [RegistroController::class, 'index'])->name('registros.index');

    Route::get('/almacenes', [AlmacenController::class, 'index'])->name('almacenes.index');
    Route::get('/lotes', [LotesController::class, 'index'])->name('lotes.index');
    
    
    //Productos Crear
    Route::post('/productos/store', [ProductController::class, 'store'])->name('products.store');

    //Productos Editar
    Route::put('/productos/update/{product}', [ProductController::class, 'update'])->name('products.update');

    //Productos Index
    Route::get('/productos/create', [ProductController::class, 'create'])->name('products.create');
    Route::get('/productos/papelera', [ProductController::class, 'papelera'])->name('products.papelera');
    Route::get('/productos/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::get('/productos/view/{product}', [ProductController::class, 'view'])->name('products.view');
    Route::get('/productos/{product}/deshabilitar', [ProductController::class, 'deshabilitar'])->name('products.deshabilitar');

    //Papelera Productos
    Route::get('/productos/{product}/habilitar', [ProductController::class, 'habilitar'])->name('products.habilitar');
    Route::delete('/productos/{product}/eliminar', [ProductController::class, 'eliminar'])->name('products.eliminar');
});


require __DIR__.'/settings.php';



