<?php

use App\Models\Lotes;
use App\Models\Product;
use App\Models\Almacen;
use App\Models\User;

/**
 * Tests de integración para LotesController.
 * 
 * @spec "El controlador de lotes maneja correctamente CRUD y autorización"
 * @audit "Los tests verifican que solo los dueños pueden modificar sus lotes"
 */

beforeEach(function () {
    $this->user = createUser();
    $this->otherUser = createUser(['email' => 'other@example.com']);
});

/**
 * @test
 * @spec "Un usuario no autenticado es redirigido al login al intentar ver lotes"
 */
it('redirects unauthenticated users to login when viewing lots', function () {
    $this->get(route('lotes.index'))->assertRedirect(route('login'));
});

/**
 * @test
 * @spec "Un usuario autenticado puede ver la lista de sus lotes"
 */
it('authenticated user can view lots list', function () {
    $this->actingAs($this->user);

    Lotes::factory()->count(3)->create(['usuario' => $this->user->id]);
    Lotes::factory()->count(2)->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('lotes.index'));

    $response->assertOk();
    expect($response->inertia->page['lotes']['data'])->toHaveCount(3);
});

/**
 * @test
 * @spec "Un usuario autenticado solo ve sus propios lotes activos"
 */
it('authenticated user only sees their own active lots', function () {
    $this->actingAs($this->user);

    // Lotes activos del usuario
    Lotes::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Lotes deshabilitados del usuario
    Lotes::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => false,
        'eliminado' => false,
    ]);

    // Lotes eliminados del usuario
    Lotes::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'eliminado' => true,
    ]);

    $response = $this->get(route('lotes.index'));

    $response->assertOk();
    // Solo deberían aparecer los 2 lotes activos
    expect($response->inertia->page['lotes']['data'])->toHaveCount(2);
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario para crear un lote"
 */
it('authenticated user can view create lot form', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('lotes.create'));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario puede crear un lote válido"
 */
it('authenticated user can create a lot', function () {
    $this->actingAs($this->user);

    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $loteData = [
        'descripcion' => 'Lote de prueba',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 100,
    ];

    $response = $this->post(route('lotes.store'), $loteData);

    $response->assertRedirect(route('lotes.index'));
    $this->assertDatabaseHas('lotes', [
        'descripcion' => 'Lote de prueba',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 100,
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un lote creado tiene un código UUID único"
 */
it('created lot has a unique UUID code', function () {
    $this->actingAs($this->user);

    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $loteData = [
        'descripcion' => 'Lote UUID Test',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 50,
    ];

    $this->post(route('lotes.store'), $loteData);

    $lote = Lotes::where('descripcion', 'Lote UUID Test')->first();

    expect($lote->codigo)->toBeValidUuid();
});

/**
 * @test
 * @spec "Un usuario no puede crear un lote sin descripción"
 */
it('user cannot create lot without description', function () {
    $this->actingAs($this->user);

    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $loteData = [
        'descripcion' => '',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 100,
    ];

    $response = $this->post(route('lotes.store'), $loteData);

    $response->assertSessionHasErrors('descripcion');
});

/**
 * @test
 * @spec "Un usuario no puede crear un lote con cantidad inválida"
 */
it('user cannot create lot with invalid quantity', function () {
    $this->actingAs($this->user);

    $producto = Product::factory()->create(['usuario' => $this->user->id]);
    $almacen = Almacen::factory()->create(['usuario' => $this->user->id]);

    $loteData = [
        'descripcion' => 'Lote con cantidad inválida',
        'producto_id' => $producto->id,
        'almacen_id' => $almacen->id,
        'cantidad' => 0, // Cantidad inválida
    ];

    $response = $this->post(route('lotes.store'), $loteData);

    $response->assertSessionHasErrors('cantidad');
});

/**
 * @test
 * @spec "Un usuario puede ver un lote específico que le pertenece"
 */
it('authenticated user can view their own lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('lotes.view', $lote));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario no puede ver un lote de otro usuario"
 */
it('user cannot view another user lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('lotes.view', $lote));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario de edición de su lote"
 */
it('authenticated user can view edit form for their lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('lotes.edit', $lote));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario no puede editar un lote de otro usuario"
 */
it('user cannot edit another user lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('lotes.edit', $lote));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede actualizar su lote"
 */
it('authenticated user can update their lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->user->id]);

    $updateData = [
        'descripcion' => 'Lote Actualizado',
        'cantidad' => 200,
    ];

    $response = $this->put(route('lotes.update', $lote), $updateData);

    $response->assertRedirect(route('lotes.index'));
    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'descripcion' => 'Lote Actualizado',
        'cantidad' => 200,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede actualizar un lote de otro usuario"
 */
it('user cannot update another user lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create(['usuario' => $this->otherUser->id]);

    $updateData = [
        'descripcion' => 'Intento de actualización',
    ];

    $response = $this->put(route('lotes.update', $lote), $updateData);

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede deshabilitar su lote"
 */
it('authenticated user can disable their lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('lotes.deshabilitar', $lote));

    $response->assertRedirect(route('lotes.index'));
    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'habilitado' => false,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede deshabilitar un lote de otro usuario"
 */
it('user cannot disable another user lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create([
        'usuario' => $this->otherUser->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('lotes.deshabilitar', $lote));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede habilitar su lote deshabilitado"
 */
it('authenticated user can enable their disabled lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->disabled()->create(['usuario' => $this->user->id]);

    $response = $this->post(route('lotes.habilitar', $lote));

    $response->assertRedirect(route('lotes.papelera'));
    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'habilitado' => true,
    ]);
});

/**
 * @test
 * @spec "Un usuario puede eliminar (soft delete) su lote"
 */
it('authenticated user can delete their lot (soft delete)', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('lotes.eliminar', $lote));

    $response->assertRedirect(route('lotes.papelera'));
    $this->assertDatabaseHas('lotes', [
        'id' => $lote->id,
        'eliminado' => true,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede eliminar un lote de otro usuario"
 */
it('user cannot delete another user lot', function () {
    $this->actingAs($this->user);

    $lote = Lotes::factory()->create([
        'usuario' => $this->otherUser->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('lotes.eliminar', $lote));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver la papelera con sus lotes deshabilitados"
 */
it('authenticated user can view trash with disabled lots', function () {
    $this->actingAs($this->user);

    // Lotes deshabilitados del usuario
    Lotes::factory()->count(2)->disabled()->create(['usuario' => $this->user->id]);

    // Lotes activos del usuario (no deberían aparecer en papelera)
    Lotes::factory()->count(3)->create(['usuario' => $this->user->id]);

    $response = $this->get(route('lotes.papelera'));

    $response->assertOk();
    // Solo deberían aparecer los lotes deshabilitados
    expect($response->inertia->page['lotes'])->toHaveCount(2);
});