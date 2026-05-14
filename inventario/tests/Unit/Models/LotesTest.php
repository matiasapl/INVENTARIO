<?php

use App\Models\Lotes;
use App\Models\Product;
use App\Models\Almacen;
use App\Models\User;

/**
 * Tests unitarios para el modelo Lotes.
 * 
 * @spec "El modelo Lotes cumple con las reglas de negocio definidas"
 * @audit "Los tests documentan el comportamiento esperado del modelo"
 */

/**
 * @test
 * @spec "Un lote nuevo debe estar habilitado y no eliminado por defecto"
 */
it('is active by default when created', function () {
    $lote = Lotes::factory()->create();

    expect($lote)->toBeActiveLote();
});

/**
 * @test
 * @spec "Un lote puede ser deshabilitado"
 */
it('can be disabled', function () {
    $lote = Lotes::factory()->create(['habilitado' => true]);

    $lote->deshabilitar();

    expect($lote->fresh()->habilitado)->toBeFalse()
        ->and($lote->fresh()->eliminado)->toBeFalse();
});

/**
 * @test
 * @spec "Un lote puede ser habilitado después de estar deshabilitado"
 */
it('can be enabled after being disabled', function () {
    $lote = Lotes::factory()->disabled()->create();

    $lote->habilitar();

    expect($lote->fresh())->toBeActiveLote();
});

/**
 * @test
 * @spec "Un lote puede ser eliminado (soft delete)"
 */
it('can be deleted (soft delete)', function () {
    $lote = Lotes::factory()->create(['eliminado' => false]);

    $lote->eliminar();

    expect($lote->fresh()->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un lote pertenece a un producto"
 */
it('belongs to a product', function () {
    $producto = Product::factory()->create();
    $lote = Lotes::factory()->create(['producto_id' => $producto->id]);

    expect($lote->producto_id)->toBe($producto->id)
        ->and($lote->producto)->toBeInstanceOf(Product::class);
});

/**
 * @test
 * @spec "Un lote pertenece a un almacén"
 */
it('belongs to a warehouse', function () {
    $almacen = Almacen::factory()->create();
    $lote = Lotes::factory()->create(['almacen_id' => $almacen->id]);

    expect($lote->almacen_id)->toBe($almacen->id)
        ->and($lote->almacen)->toBeInstanceOf(Almacen::class);
});

/**
 * @test
 * @spec "Un lote pertenece a un usuario"
 */
it('belongs to a user', function () {
    $user = createUser();
    $lote = Lotes::factory()->create(['usuario' => $user->id]);

    expect($lote->user)->toBeInstanceOf(User::class)
        ->and($lote->user->id)->toBe($user->id);
});

/**
 * @test
 * @spec "Un lote debe tener descripción"
 */
it('must have a description', function () {
    $lote = Lotes::factory()->create();

    expect($lote->descripcion)->toBeString()
        ->and($lote->descripcion)->not->toBeEmpty();
});

/**
 * @test
 * @spec "Un lote debe tener cantidad mayor a 0"
 */
it('must have quantity greater than zero', function () {
    $lote = Lotes::factory()->create();

    expect($lote->cantidad)->toBeInteger()
        ->and($lote->cantidad)->toBeGreaterThan(0);
});

/**
 * @test
 * @spec "Un lote activo puede ser utilizado"
 */
it('active lot can be used', function () {
    $lote = Lotes::factory()->create();

    expect($lote->habilitado)->toBeTrue()
        ->and($lote->eliminado)->toBeFalse();
});

/**
 * @test
 * @spec "Un lote deshabilitado no puede ser utilizado"
 */
it('disabled lot cannot be used', function () {
    $lote = Lotes::factory()->disabled()->create();

    expect($lote->habilitado)->toBeFalse();
});

/**
 * @test
 * @spec "Un lote eliminado no puede ser utilizado"
 */
it('deleted lot cannot be used', function () {
    $lote = Lotes::factory()->deleted()->create();

    expect($lote->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un lote tiene timestamps (created_at, updated_at)"
 */
it('has timestamps', function () {
    $lote = Lotes::factory()->create();

    expect($lote->created_at)->not->toBeNull()
        ->and($lote->updated_at)->not->toBeNull();
});