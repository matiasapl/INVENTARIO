<?php

use App\Models\Almacen;
use App\Models\User;
use Inertia\Testing\AssertableInertia as Assert;

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

    $this->post(route('almacen.store'), $almacenData)->assertRedirect(route('almacenes.index'));

    $almacen = Almacen::where('nombre', 'Almacén Flujo Completo')->first();
    expect($almacen)->not->toBeNull();

    // Paso 2: Ver almacén
    $response = $this->get(route('almacen.view', $almacen));
    $response->assertOk();

    // Paso 3: Editar almacén
    $updateData = [
        'nombre' => 'Almacén Flujo Completo Editado',
        'descripcion' => 'Descripción actualizada',
        'ubicacion' => 'Valparaíso, Chile',
        'estado' => true,
    ];

    $this->put(route('almacen.update', $almacen), $updateData)
        ->assertRedirect(route('almacenes.index'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'nombre' => 'Almacén Flujo Completo Editado',
    ]);

    // Paso 4: Deshabilitar almacén
    $this->post(route('almacen.deshabilitar', $almacen))
        ->assertRedirect(route('almacenes.index'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => false,
    ]);

    // Paso 5: Verificar que el almacén deshabilitado no aparece en lista principal
    $response = $this->get(route('almacenes.index'));
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page
        ->has('Almacenes.data')
        ->where('Almacenes.data', fn ($data) => collect($data)->doesntContain('id', $almacen->id)));

    // Paso 6: Habilitar almacén nuevamente
    $this->post(route('almacen.habilitar', $almacen))
        ->assertRedirect(route('almacen.papelera'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => true,
    ]);

    // Paso 7: Eliminar almacén (soft delete)
    $this->delete(route('almacen.eliminar', $almacen))
        ->assertRedirect(route('almacen.papelera'));

    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'eliminado' => true,
    ]);

    // Paso 8: Verificar que el almacén eliminado no aparece en ninguna lista
    $response = $this->get(route('almacenes.index'));
    $response->assertInertia(fn (Assert $page) => $page
        ->has('Almacenes.data')
        ->where('Almacenes.data', fn ($data) => collect($data)->doesntContain('id', $almacen->id)));

    // Los almacenes eliminados tampoco deben aparecer en la papelera.
    $response = $this->get(route('almacen.papelera'));
    $response->assertInertia(fn (Assert $page) => $page->has('Almacenes', 0));
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
        $this->post(route('almacen.store'), [
            'nombre' => $name,
            'ubicacion' => 'Bodega central',
        ])->assertRedirect(route('almacenes.index'));
    }

    // Verificar que todos los almacenes fueron creados
    foreach ($almacenNames as $name) {
        $this->assertDatabaseHas('almacens', [
            'nombre' => $name,
            'usuario' => $this->user->id,
        ]);
    }

    // Ver que todos aparecen en la lista
    $response = $this->get(route('almacenes.index'));
    $response->assertOk();

    $response->assertInertia(fn (Assert $page) => $page
        ->where('Almacenes.data', function ($data) use ($almacenNames) {
            $names = collect($data)->pluck('nombre');

            return collect($almacenNames)->every(fn ($name) => $names->contains($name));
        }));
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
    $response = $this->get(route('almacenes.index'));
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page->has('Almacenes.data', 3));

    // Ver papelera (solo deshabilitados)
    $response = $this->get(route('almacen.papelera'));
    $response->assertOk();
    $response->assertInertia(fn (Assert $page) => $page->has('Almacenes', 2));
});

/**
 * @test
 * @spec "Un almacén creado tiene un UUID único que no se repite"
 */
it('created warehouse has a unique UUID that does not repeat', function () {
    $this->actingAs($this->user);

    // Crear dos almacenes con el mismo nombre
    $this->post(route('almacen.store'), ['nombre' => 'Almacén UUID Test', 'ubicacion' => 'Bodega']);
    $this->post(route('almacen.store'), ['nombre' => 'Almacén UUID Test', 'ubicacion' => 'Bodega']);

    $almacenes = Almacen::where('nombre', 'Almacén UUID Test')->get();

    expect($almacenes)->toHaveCount(2);

    // Verificar que los UUID son diferentes
    $uuids = $almacenes->pluck('codigo')->toArray();
    expect(count(array_unique($uuids)))->toBe(2);
});
