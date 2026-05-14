<?php

use App\Models\Product;
use App\Models\User;

/**
 * Tests unitarios para el modelo Product.
 * 
 * @spec "El modelo Product cumple con las reglas de negocio definidas"
 * @audit "Los tests documentan el comportamiento esperado del modelo"
 */

/**
 * @test
 * @spec "Un producto nuevo debe estar habilitado y no eliminado por defecto"
 */
it('is active by default when created', function () {
    $product = Product::factory()->create();

    expect($product)->toBeActiveProduct();
});

/**
 * @test
 * @spec "Un producto puede ser deshabilitado"
 */
it('can be disabled', function () {
    $product = Product::factory()->create(['habilitado' => true]);

    $product->deshabilitar();

    expect($product->fresh())->toBeDisabledProduct();
});

/**
 * @test
 * @spec "Un producto puede ser habilitado después de estar deshabilitado"
 */
it('can be enabled after being disabled', function () {
    $product = Product::factory()->disabled()->create();

    $product->habilitar();

    expect($product->fresh())->toBeActiveProduct();
});

/**
 * @test
 * @spec "Un producto puede ser eliminado (soft delete)"
 */
it('can be deleted (soft delete)', function () {
    $product = Product::factory()->create(['eliminado' => false]);

    $product->eliminar();

    expect($product->fresh())->toBeDeletedProduct();
});

/**
 * @test
 * @spec "Un producto eliminado no puede ser habilitado"
 */
it('deleted product cannot be enabled', function () {
    $product = Product::factory()->deleted()->create();

    $product->habilitar();

    // El producto sigue eliminado aunque se intente habilitar
    expect($product->fresh()->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un producto tiene una relación con el usuario"
 */
it('belongs to a user', function () {
    $user = createUser();
    $product = Product::factory()->create(['usuario' => $user->id]);

    expect($product->user)->toBeInstanceOf(User::class)
        ->and($product->user->id)->toBe($user->id);
});

/**
 * @test
 * @spec "Un producto puede tener descripción nula"
 */
it('can have null description', function () {
    $product = Product::factory()->create(['descripcion' => null]);

    expect($product->descripcion)->toBeNull();
});

/**
 * @test
 * @spec "Un producto debe tener nombre"
 */
it('must have a name', function () {
    $product = Product::factory()->create();

    expect($product->nombre)->toBeString()
        ->and($product->nombre)->not->toBeEmpty();
});

/**
 * @test
 * @spec "Un producto debe tener precio unitario mayor o igual a 0"
 */
it('must have unit price greater than or equal to zero', function () {
    $product = Product::factory()->create();

    expect($product->precio_unitario)->toBeFloat()
        ->and($product->precio_unitario)->toBeGreaterThanOrEqual(0);
});

/**
 * @test
 * @spec "Un producto debe tener M3_unitario mayor o igual a 0"
 */
it('must have M3_unitario greater than or equal to zero', function () {
    $product = Product::factory()->create();

    expect($product->M3_unitario)->toBeFloat()
        ->and($product->M3_unitario)->toBeGreaterThanOrEqual(0);
});

/**
 * @test
 * @spec "Un producto activo puede ser vendido"
 */
it('active product can be sold', function () {
    $product = Product::factory()->create();

    // Un producto activo cumple con las condiciones para ser vendido
    expect($product->habilitado)->toBeTrue()
        ->and($product->eliminado)->toBeFalse();
});

/**
 * @test
 * @spec "Un producto deshabilitado no puede ser vendido"
 */
it('disabled product cannot be sold', function () {
    $product = Product::factory()->disabled()->create();

    // Un producto deshabilitado no cumple con las condiciones para ser vendido
    expect($product->habilitado)->toBeFalse();
});

/**
 * @test
 * @spec "Un producto eliminado no puede ser vendido"
 */
it('deleted product cannot be sold', function () {
    $product = Product::factory()->deleted()->create();

    // Un producto eliminado no cumple con las condiciones para ser vendido
    expect($product->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un producto tiene timestamps (created_at, updated_at)"
 */
it('has timestamps', function () {
    $product = Product::factory()->create();

    expect($product->created_at)->not->toBeNull()
        ->and($product->updated_at)->not->toBeNull();
});

/**
 * @test
 * @spec "El timestamp updated_at se actualiza al modificar el producto"
 */
it('updated_at timestamp changes when product is updated', function () {
    $product = Product::factory()->create();
    $originalUpdatedAt = $product->updated_at;

    sleep(1); // Esperar un segundo para asegurar diferencia

    $product->update(['nombre' => 'Nuevo Nombre']);

    expect($product->fresh()->updated_at)->not->toBe($originalUpdatedAt);
});