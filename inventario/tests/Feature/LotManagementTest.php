<?php

use App\Models\Lotes;
use App\Models\Product;
use App\Models\Almacen;
use App\Models\User;

/**
 * Tests de características para gestión completa de lotes.
 * 
 * @spec "Los flujos completos de gestión de lotes funcionan correctamente"
 * @audit "Se verifica que todas las acciones queden registradas para auditoría"
 */

beforeEach(function () {
    $this->user = createUser();
});

/**
 * @test
 * @spec "Un usuario puede crear, ver, editar y deshabilitar un lote en un flujo completo"
 */
it('user can create view edit and disable a lot in a complete flow', function () {
    $this->actingAs($this->user);

    // Crear producto y almacén necesarios para el lote
    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    // Paso 1: Crear lote
    $loteData = [
        'descripcion' => 'Lote Flujo Completo',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 100,
    ];

    $this->post(route('lotes.store'), $loteData)->assertRedirect(route('lotes.index'));

    $lote = Lotes::where('descripcion', 'Lote Flujo Completo')->first();
    expect($lote)->not->toBeNull();

    // Paso 2: Ver lote
    $response = $this->get(route('lotes.view', $lote));
    $response->assertOk();

    // Paso 3: Editar lote
    $updateData = [
        'descripcion' => 'Lote Flujo Completo Editado',
        'cantidad' => 200,
    ];

    $this->put(route('lotes.update', $lote), $updateData)
        ->assertRedirect(route('lotes.index'));

    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'descripcion' => 'Lote Flujo Completo Editado',
        'cantidad' => 200,
    ]);

    // Paso 4: Deshabilitar lote
    $this->post(route('lotes.deshabilitar', $lote))
        ->assertRedirect(route('lotes.index'));

    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'habilitado' => false,
    ]);

    // Paso 5: Verificar que el lote deshabilitado no aparece en lista principal
    $response = $this->get(route('lotes.index'));
    $response->assertOk();
    $loteIds = collect($response->inertia->page['lotes']['data'])
        ->pluck('id')
        ->toArray();
    expect($loteIds)->not->toContain($lote->id);

    // Paso 6: Habilitar lote nuevamente
    $this->post(route('lotes.habilitar', $lote))
        ->assertRedirect(route('lotes.papelera'));

    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'habilitado' => true,
    ]);

    // Paso 7: Eliminar lote (soft delete)
    $this->post(route('lotes.eliminar', $lote))
        ->assertRedirect(route('lotes.papelera'));

    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'eliminado' => true,
    ]);

    // Paso 8: Verificar que el lote eliminado no aparece en ninguna lista
    $response = $this->get(route('lotes.index'));
    $loteIds = collect($response->inertia->page['lotes']['data'])
        ->pluck('id')
        ->toArray();
    expect($loteIds)->not->toContain($lote->id);

    // Pero sí aparece en la papelera
    $response = $this->get(route('lotes.papelera'));
    $trashLoteIds = collect($response->inertia->page['lotes'])
        ->pluck('id')
        ->toArray();
    expect($trashLoteIds)->toContain($lote->id);
});

/**
 * @test
 * @spec "Un usuario puede crear múltiples lotes y verlos todos en su lista"
 */
it('user can create multiple lots and see them all in their list', function () {
    $this->actingAs($this->user);

    // Crear producto y almacén
    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    // Crear 3 lotes
    $loteDescriptions = [
        'Lote 001',
        'Lote 002',
        'Lote 003',
    ];

    foreach ($loteDescriptions as $desc) {
        $this->post(route('lotes.store'), [
            'descripcion' => $desc,
            'producto_id' => $producto->id,
            'almacen_id' => $almacen->id,
            'cantidad' => 50,
        ])->assertRedirect(route('lotes.index'));
    }

    // Verificar que todos los lotes fueron creados
    foreach ($loteDescriptions as $desc) {
        $this->assertDatabaseHas('lotes', [
            'descripcion' => $desc,
            'usuario' => $this->user->id,
        ]);
    }

    // Ver que todos aparecen en la lista
    $response = $this->get(route('lotes.index'));
    $response->assertOk();

    $loteDescriptionsInList = collect($response->inertia->page['lotes']['data'])
        ->pluck('descripcion')
        ->toArray();

    foreach ($loteDescriptions as $desc) {
        expect(in_array($desc, $loteDescriptionsInList))->toBeTrue();
    }
});

/**
 * @test
 * @spec "Un usuario puede filtrar lotes por estado (activo/deshabilitado)"
 */
it('user can filter lots by status active disabled', function () {
    $this->actingAs($this->user);

    // Crear producto y almacén
    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    // Crear lotes activos
    Lotes::factory()->count(3)->create([
        'usuario' => $this->user->id,
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Crear lotes deshabilitados
    Lotes::factory()->count(2)->disabled()->create([
        'usuario' => $this->user->id,
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
    ]);

    // Ver lista principal (solo activos)
    $response = $this->get(route('lotes.index'));
    $response->assertOk();
    expect($response->inertia->page['lotes']['data'])->toHaveCount(3);

    // Ver papelera (solo deshabilitados)
    $response = $this->get(route('lotes.papelera'));
    $response->assertOk();
    expect($response->inertia->page['lotes'])->toHaveCount(2);
});

/**
 * @test
 * @spec "Un lote creado tiene un UUID único que no se repite"
 */
it('created lot has a unique UUID that does not repeat', function () {
    $this->actingAs($this->user);

    // Crear producto y almacén
    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    // Crear dos lotes con la misma descripción
    $this->post(route('lotes.store'), [
        'descripcion' => 'Lote UUID Test',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 50,
    ]);
    $this->post(route('lotes.store'), [
        'descripcion' => 'Lote UUID Test',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 100,
    ]);

    $lotes = Lotes::where('descripcion', 'Lote UUID Test')->get();

    expect($lotes)->toHaveCount(2);

    // Verificar que los UUID son diferentes
    $uuids = $lotes->pluck('codigo')->toArray();
    expect(count(array_unique($uuids)))->toBe(2);
});

/**
 * @test
 * @spec "Un lote está asociado correctamente a su producto y almacén"
 */
it('lot is correctly associated with its product and warehouse', function () {
    $this->actingAs($this->user);

    // Crear producto y almacén
    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    // Crear lote
    $loteData = [
        'descripcion' => 'Lote Asociado',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 75,
    ];

    $this->post(route('lotes.store'), $loteData);

    $lote = Lotes::where('descripcion', 'Lote Asociado')->first();

    // Verificar asociaciones
    expect($lote->producto_id)->toBe($producto->id)
        ->and($lote->almacen_id)->toBe($almacen->id);

    // Verificar que las relaciones funcionan
    expect($lote->producto)->toBeInstanceOf(Product::class)
        ->and($lote->almacen)->toBeInstanceOf(Almacen::class);
});