<?php

use Illuminate\Support\Facades\Route;
use Inertia\Inertia;
use Laravel\Fortify\Features;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ControlStockController;
use App\Http\Controllers\RegistroController;
Route::get('/', function () {
    return Inertia::render('welcome', [
        'canRegister' => Features::enabled(Features::registration()),
    ]);
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('dashboard', function () {
        return Inertia::render('dashboard');
    })->name('dashboard');
});


Route::middleware(['auth'])->group(function () {
    Route::get('/products', [ProductController::class, 'index'])->name('products.index');
    Route::get('/products/papelera', [ProductController::class, 'papelera'])->name('products.papelera');
    Route::get('/registros', [RegistroController::class, 'index'])->name('registros.index');
    Route::get('/products/create', [ProductController::class, 'create'])->name('products.create');
    Route::post('/products/store', [ProductController::class, 'store'])->name('products.store');
    Route::get('/products/edit/{product}', [ProductController::class, 'edit'])->name('products.edit');
    Route::put('/products/update/{product}', [ProductController::class, 'update'])->name('products.update');
    Route::get('/products/view/{product}', [ProductController::class, 'view'])->name('products.view');
    Route::get('/products/delete/{product}', [ProductController::class, 'delete'])->name('products.delete');

    
    Route::get('/products/{product}/deshabilitar', [ProductController::class, 'deshabilitar'])->name('products.deshabilitar');
    Route::get('/products/{product}/habilitar', [ProductController::class, 'habilitar'])->name('products.habilitar');
    Route::delete('/products/{product}/eliminar', [ProductController::class, 'eliminar'])->name('products.eliminar');

    Route::get('/controlstock', [ControlStockController::class, 'index'])->name('controlstock.index');
    Route::get('/controlstock/create', [ControlStockController::class, 'create'])->name('controlstock.create');

    
    // Acciones para sumar y restar stock
    Route::post('/controlstock/{id}/sumar', [ControlStockController::class, 'sumar'])->name('controlstock.sumar');
    Route::post('/controlstock/{id}/restar', [ControlStockController::class, 'restar'])->name('controlstock.restar');

});


require __DIR__.'/settings.php';



