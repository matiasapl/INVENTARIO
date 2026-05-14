<?php

use App\Models\Almacen;
use App\Models\User;

/**
 * Tests unitarios para el modelo Almacen.
 * 
 * @spec "El modelo Almacen cumple con las reglas de negocio definidas"
 * @audit "Los tests documentan el comportamiento esperado del modelo"
 */

/**
 * @test
 * @spec "Un almacén nuevo debe estar habilitado y no eliminado por defecto"
 */
it('is active by default when created', function () {
    $almacen = Almacen::factory()->create();

    expect($almacen)->toBeActiveAlmacen();
});

/**
 * @test
 * @spec "Un almacén puede ser deshabilitado"
 */
it('can be disabled', function () {
    $almacen = Almacen::factory()->create(['habilitado' => true]);

    $almacen->deshabilitar();

    expect($almacen->fresh()->habilitado)->toBeFalse()
        ->and($almacen->fresh()->eliminado)->toBeFalse();
});

/**
 * @test
 * @spec "Un almacén puede ser habilitado después de estar deshabilitado"
 */
it('can be enabled after being disabled', function () {
    $almacen = Almacen::factory()->disabled()->create();

    $almacen->habilitar();

    expect($almacen->fresh())->toBeActiveAlmacen();
});

/**
 * @test
 * @spec "Un almacén puede ser eliminado (soft delete)"
 */
it('can be deleted (soft delete)', function () {
    $almacen = Almacen::factory()->create(['eliminado' => false]);

    $almacen->eliminar();

    expect($almacen->fresh()->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un almacén tiene una relación con el usuario"
 */
it('belongs to a user', function () {
    $user = createUser();
    $almacen = Almacen::factory()->create(['usuario' => $user->id]);

    expect($almacen->user)->toBeInstanceOf(User::class)
        ->and($almacen->user->id)->toBe($user->id);
});

/**
 * @test
 * @spec "Un almacén debe tener nombre"
 */
it('must have a name', function () {
    $almacen = Almacen::factory()->create();

    expect($almacen->nombre)->toBeString()
        ->and($almacen->nombre)->not->toBeEmpty();
});

/**
 * @test
 * @spec "Un almacén puede tener descripción nula"
 */
it('can have null description', function () {
    $almacen = Almacen::factory()->create(['descripcion' => null]);

    expect($almacen->descripcion)->toBeNull();
});

/**
 * @test
 * @spec "Un almacén puede tener ubicación nula"
 */
it('can have null location', function () {
    $almacen = Almacen::factory()->create(['ubicacion' => null]);

    expect($almacen->ubicacion)->toBeNull();
});

/**
 * @test
 * @spec "Un almacén activo puede almacenar productos"
 */
it('active warehouse can store products', function () {
    $almacen = Almacen::factory()->create();

    expect($almacen->habilitado)->toBeTrue()
        ->and($almacen->eliminado)->toBeFalse();
});

/**
 * @test
 * @spec "Un almacén deshabilitado no puede almacenar productos"
 */
it('disabled warehouse cannot store products', function () {
    $almacen = Almacen::factory()->disabled()->create();

    expect($almacen->habilitado)->toBeFalse();
});

/**
 * @test
 * @spec "Un almacén eliminado no puede almacenar productos"
 */
it('deleted warehouse cannot store products', function () {
    $almacen = Almacen::factory()->deleted()->create();

    expect($almacen->eliminado)->toBeTrue();
});

/**
 * @test
 * @spec "Un almacén tiene timestamps (created_at, updated_at)"
 */
it('has timestamps', function () {
    $almacen = Almacen::factory()->create();

    expect($almacen->created_at)->not->toBeNull()
        ->and($almacen->updated_at)->not->toBeNull();
});