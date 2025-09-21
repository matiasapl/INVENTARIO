<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/api/v1/usuarios', function () {
    return view('welcome');
});

Route::get('/api/v1/productos', function () {
    return view('welcome');
});

Route::get('/api/v1/compras', function () {
    return view('welcome');
});

Route::get('/api/v1/ventas', function () {
    return view('welcome');
});

Route::get('/api/v1/inventario_historial', function () {
    return view('welcome');
});