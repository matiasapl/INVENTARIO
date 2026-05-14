<?php

use App\Models\Almacen;
use App\Models\User;

/**
 * Tests de integración para AlmacenController.
 * 
 * @spec "El controlador de almacenes maneja correctamente CRUD y autorización"
 * @audit "Los tests verifican que solo los dueños pueden modificar sus almacenes"
 */

beforeEach(function () {
    $this->user = createUser();
    $this->otherUser = createUser(['email' => 'other@example.com']);
});

/**
 * @test
 * @spec "Un usuario no autenticado es redirigido al login al intentar ver almacenes"
 */
it('redirects unauthenticated users to login when viewing warehouses', function () {
    $this->get(route('almacens.index'))->assertRedirect(route('login'));
});

/**
 * @test
 * @spec "Un usuario autenticado puede ver la lista de sus almacenes"
 */
it('authenticated user can view warehouses list', function () {
    $this->actingAs($this->user);

    Almacen::factory()->count(3)->create(['usuario' => $this->user->id]);
    Almacen::factory()->count(2)->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('almacens.index'));

    $response->assertOk();
    expect($response->inertia->page['almacens']['data'])->toHaveCount(3);
});

/**
 * @test
 * @spec "Un usuario autenticado solo ve sus propios almacenes activos"
 */
it('authenticated user only sees their own active warehouses', function () {
    $this->actingAs($this->user);

    // Almacenes activos del usuario
    Almacen::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Almacenes deshabilitados del usuario
    Almacen::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => false,
        'eliminado' => false,
    ]);

    // Almacenes eliminados del usuario
    Almacen::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'eliminado' => true,
    ]);

    $response = $this->get(route('almacens.index'));

    $response->assertOk();
    // Solo deberían aparecer los 2 almacenes activos
    expect($response->inertia->page['almacens']['data'])->toHaveCount(2);
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario para crear un almacén"
 */
it('authenticated user can view create warehouse form', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('almacens.create'));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario puede crear un almacén válido"
 */
it('authenticated user can create a warehouse', function () {
    $this->actingAs($this->user);

    $almacenData = [
        'nombre' => 'Almacén Central',
        'descripcion' => 'Almacén principal de la empresa',
        'ubicacion' => 'Santiago, Chile',
    ];

    $response = $this->post(route('almacens.store'), $almacenData);

    $response->assertRedirect(route('almacens.index'));
    $this->assertDatabaseHas('almacens', [
        'nombre' => 'Almacén Central',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un almacén creado tiene un código UUID único"
 */
it('created warehouse has a unique UUID code', function () {
    $this->actingAs($this->user);

    $almacenData = [
        'nombre' => 'Almacén UUID Test',
    ];

    $this->post(route('almacens.store'), $almacenData);

    $almacen = Almacen::where('nombre', 'Almacén UUID Test')->first();

    expect($almacen->codigo)->toBeValidUuid();
});

/**
 * @test
 * @spec "Un usuario no puede crear un almacén sin nombre"
 */
it('user cannot create warehouse without name', function () {
    $this->actingAs($this->user);

    $almacenData = [
        'nombre' => '',
    ];

    $response = $this->post(route('almacens.store'), $almacenData);

    $response->assertSessionHasErrors('nombre');
});

/**
 * @test
 * @spec "Un usuario puede ver un almacén específico que le pertenece"
 */
it('authenticated user can view their own warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('almacens.view', $almacen));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario no puede ver un almacén de otro usuario"
 */
it('user cannot view another user warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('almacens.view', $almacen));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario de edición de su almacén"
 */
it('authenticated user can view edit form for their warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('almacens.edit', $almacen));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario no puede editar un almacén de otro usuario"
 */
it('user cannot edit another user warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('almacens.edit', $almacen));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede actualizar su almacén"
 */
it('authenticated user can update their warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $updateData = [
        'nombre' => 'Almacén Actualizado',
        'descripcion' => 'Nueva descripción',
        'ubicacion' => 'Valparaíso, Chile',
    ];

    $response = $this->put(route('almacens.update', $almacen), $updateData);

    $response->assertRedirect(route('almacens.index'));
    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'nombre' => 'Almacén Actualizado',
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede actualizar un almacén de otro usuario"
 */
it('user cannot update another user warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create(['usuario' => $this->otherUser->id]);

    $updateData = [
        'nombre' => 'Intento de actualización',
    ];

    $response = $this->put(route('almacens.update', $almacen), $updateData);

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede deshabilitar su almacén"
 */
it('authenticated user can disable their warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('almacens.deshabilitar', $almacen));

    $response->assertRedirect(route('almacens.index'));
    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => false,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede deshabilitar un almacén de otro usuario"
 */
it('user cannot disable another user warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create([
        'usuario' => $this->otherUser->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('almacens.deshabilitar', $almacen));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede habilitar su almacén deshabilitado"
 */
it('authenticated user can enable their disabled warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->disabled()->create(['usuario' => $this->user->id]);

    $response = $this->post(route('almacens.habilitar', $almacen));

    $response->assertRedirect(route('almacens.papelera'));
    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'habilitado' => true,
    ]);
});

/**
 * @test
 * @spec "Un usuario puede eliminar (soft delete) su almacén"
 */
it('authenticated user can delete their warehouse (soft delete)', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create([
        'usuario' => $this->user->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('almacens.eliminar', $almacen));

    $response->assertRedirect(route('almacens.papelera'));
    $this->assertDatabaseHas('almacens', [
        'id' => $almacen->id,
        'eliminado' => true,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede eliminar un almacén de otro usuario"
 */
it('user cannot delete another user warehouse', function () {
    $this->actingAs($this->user);

    $almacen = Almacen::factory()->create([
        'usuario' => $this->otherUser->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('almacens.eliminar', $almacen));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver la papelera con sus almacenes deshabilitados"
 */
it('authenticated user can view trash with disabled warehouses', function () {
    $this->actingAs($this->user);

    // Almacenes deshabilitados del usuario
    Almacen::factory()->count(2)->disabled()->create(['usuario' => $this->user->id]);

    // Almacenes activos del usuario (no deberían aparecer en papelera)
    Almacen::factory()->count(3)->create(['usuario' => $this->user->id]);

    $response = $this->get(route('almacens.papelera'));

    $response->assertOk();
    // Solo deberían aparecer los almacenes deshabilitados
    expect($response->inertia->page['almacens'])->toHaveCount(2);
});