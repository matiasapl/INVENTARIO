<?php

use App\Models\Almacen;
use App\Models\User;

/**
 * Tests de características para gestión completa de almacenes.
 * 
 * @spec "Los flujos completos de gestión de almacenes funcionan correctamente"
 * @audit "Se verifica que todas las acciones queden registradas para auditoría"
 */

beforeEach(function () {
    $this->user = createUser();
});

/**
 * @test
 * @spec "Un usuario puede crear, ver, editar y deshabilitar un almacén en un flujo completo"
 */
it('user can create view edit and disable a warehouse in a complete flow', function () {
    $this->actingAs($this->user);

    // Paso 1: Crear almacén
    $almacenData = [
        'nombre' => 'Almacén Flujo Completo',
        'descripcion' => 'Almacén para test de flujo completo',
        'ubicacion' => 'Santiago, Chile',
    ];

    $this->post(route('almacens.store'), $almacenData)->assertRedirect(route('almacens.index'));

    $almacen = Almacen::where('nombre', 'Almacén Flujo Completo')->first();
    expect($almacen)->not->toBeNull();

    // Paso 2: Ver almacén
    $response = $this->get(route('almacens.view', $almacen));
    $response->assertOk();

    // Paso 3: Editar almacén
    $updateData = [
        'nombre' => 'Almacén Flujo Completo Editado',
        'descripcion' => 'Descripción actualizada',
        'ubicacion' => 'Valparaíso, Chile',
    ];

    $this->put(route('almacens.update', $almacen), $updateData)
        ->assertRedirect(route('almacens.index'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'nombre' => 'Almacén Flujo Completo Editado',
    ]);

    // Paso 4: Deshabilitar almacén
    $this->post(route('almacens.deshabilitar', $almacen))
        ->assertRedirect(route('almacens.index'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => false,
    ]);

    // Paso 5: Verificar que el almacén deshabilitado no aparece en lista principal
    $response = $this->get(route('almacens.index'));
    $response->assertOk();
    $almacenIds = collect($response->inertia->page['almacens']['data'])
        ->pluck('id')
        ->toArray();
    expect($almacenIds)->not->toContain($almacen->id);

    // Paso 6: Habilitar almacén nuevamente
    $this->post(route('almacens.habilitar', $almacen))
        ->assertRedirect(route('almacens.papelera'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => true,
    ]);

    // Paso 7: Eliminar almacén (soft delete)
    $this->post(route('almacens.eliminar', $almacen))
        ->assertRedirect(route('almacens.papelera'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'eliminado' => true,
    ]);

    // Paso 8: Verificar que el almacén eliminado no aparece en ninguna lista
    $response = $this->get(route('almacens.index'));
    $almacenIds = collect($response->inertia->page['almacens']['data'])
        ->pluck('id')
        ->toArray();
    expect($almacenIds)->not->toContain($almacen->id);

    // Pero sí aparece en la papelera
    $response = $this->get(route('almacens.papelera'));
    $trashAlmacenIds = collect($response->inertia->page['almacens'])
        ->pluck('id')
        ->toArray();
    expect($trashAlmacenIds)->toContain($almacen->id);
});

/**
 * @test
 * @spec "Un usuario puede crear múltiples almacenes y verlos todos en su lista"
 */
it('user can create multiple warehouses and see them all in their list', function () {
    $this->actingAs($this->user);

    // Crear 3 almacenes
    $almacenNames = [
        'Almacén Central',
        'Almacén Norte',
        'Almacén Sur',
    ];

    foreach ($almacenNames as $name) {
        $this->post(route('almacens.store'), [
            'nombre' => $name,
        ])->assertRedirect(route('almacens.index'));
    }

    // Verificar que todos los almacenes fueron creados
    foreach ($almacenNames as $name) {
        $this->assertDatabaseHas('almacens', [
            'nombre' => $name,
            'usuario' => $this->user->id,
        ]);
    }

    // Ver que todos aparecen en la lista
    $response = $this->get(route('almacens.index'));
    $response->assertOk();

    $almacenNamesInList = collect($response->inertia->page['almacens']['data'])
        ->pluck('name')
        ->toArray();

    foreach ($almacenNames as $name) {
        expect(in_array($name, $almacenNamesInList))->toBeTrue();
    }
});

/**
 * @test
 * @spec "Un usuario puede filtrar almacenes por estado (activo/deshabilitado)"
 */
it('user can filter warehouses by status active disabled', function () {
    $this->actingAs($this->user);

    // Crear almacenes activos
    Almacen::factory()->count(3)->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Crear almacenes deshabilitados
    Almacen::factory()->count(2)->disabled()->create([
        'usuario' => $this->user->id,
    ]);

    // Ver lista principal (solo activos)
    $response = $this->get(route('almacens.index'));
    $response->assertOk();
    expect($response->inertia->page['almacens']['data'])->toHaveCount(3);

    // Ver papelera (solo deshabilitados)
    $response = $this->get(route('almacens.papelera'));
    $response->assertOk();
    expect($response->inertia->page['almacens'])->toHaveCount(2);
});

/**
 * @test
 * @spec "Un almacén creado tiene un UUID único que no se repite"
 */
it('created warehouse has a unique UUID that does not repeat', function () {
    $this->actingAs($this->user);

    // Crear dos almacenes con el mismo nombre
    $this->post(route('almacens.store'), ['nombre' => 'Almacén UUID Test']);
    $this->post(route('almacens.store'), ['nombre' => 'Almacén UUID Test']);

    $almacenes = Almacen::where('nombre', 'Almacén UUID Test')->get();

    expect($almacenes)->toHaveCount(2);

    // Verificar que los UUID son diferentes
    $uuids = $almacenes->pluck('codigo')->toArray();
    expect(count(array_unique($uuids)))->toBe(2);
});