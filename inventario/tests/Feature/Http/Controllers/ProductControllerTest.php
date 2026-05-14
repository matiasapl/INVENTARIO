<?php

use App\Models\Product;
use App\Models\User;
use Inventario\tests\Concerns\InteractsWithAuthentication;

/**
 * Tests de integración para ProductController.
 * 
 * @spec "El controlador de productos maneja correctamente CRUD y autorización"
 * @audit "Los tests verifican que solo los dueños pueden modificar sus productos"
 */

beforeEach(function () {
    $this->user = createUser();
    $this->otherUser = createUser(['email' => 'other@example.com']);
});

/**
 * @test
 * @spec "Un usuario no autenticado es redirigido al login al intentar ver productos"
 */
it('redirects unauthenticated users to login when viewing products', function () {
    $this->get(route('products.index'))->assertRedirect(route('login'));
});

/**
 * @test
 * @spec "Un usuario autenticado puede ver la lista de sus productos"
 */
it('authenticated user can view products list', function () {
    $this->actingAs($this->user);

    $products = Product::factory()->count(3)->create(['usuario' => $this->user->id]);
    Product::factory()->count(2)->create(['usuario' => $this->otherUser->id]); // Otros productos

    $response = $this->get(route('products.index'));

    $response->assertOk();
    // Verificar que solo ve sus productos (3 activos)
    expect($response->inertia->page['products']['data'])->toHaveCount(3);
});

/**
 * @test
 * @spec "Un usuario autenticado solo ve sus propios productos activos"
 */
it('authenticated user only sees their own active products', function () {
    $this->actingAs($this->user);

    // Crear productos del usuario
    Product::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Crear productos deshabilitados del usuario (no deberían aparecer)
    Product::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'habilitado' => false,
        'eliminado' => false,
    ]);

    // Crear productos eliminados del usuario (no deberían aparecer)
    Product::factory()->count(2)->create([
        'usuario' => $this->user->id,
        'eliminado' => true,
    ]);

    $response = $this->get(route('products.index'));

    $response->assertOk();
    // Solo deberían aparecer los 2 productos activos
    expect($response->inertia->page['products']['data'])->toHaveCount(2);
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario para crear un producto"
 */
it('authenticated user can view create product form', function () {
    $this->actingAs($this->user);

    $response = $this->get(route('products.create'));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario puede crear un producto válido"
 */
it('authenticated user can create a product', function () {
    $this->actingAs($this->user);

    $productData = [
        'nombre' => 'Producto de Prueba',
        'descripcion' => 'Descripción del producto',
        'precio_unitario' => 100.50,
        'M3_unitario' => 0.5,
    ];

    $response = $this->post(route('products.store'), $productData);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'nombre' => 'Producto de Prueba',
        'usuario' => $this->user->id,
    ]);

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Crear Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un producto creado tiene un código UUID único"
 */
it('created product has a unique UUID code', function () {
    $this->actingAs($this->user);

    $productData = [
        'nombre' => 'Producto UUID Test',
        'precio_unitario' => 100,
        'M3_unitario' => 1,
    ];

    $this->post(route('products.store'), $productData);

    $product = Product::where('nombre', 'Producto UUID Test')->first();

    expect($product->codigo)->toBeValidUuid();
});

/**
 * @test
 * @spec "Un usuario no puede crear un producto sin nombre"
 */
it('user cannot create product without name', function () {
    $this->actingAs($this->user);

    $productData = [
        'nombre' => '',
        'precio_unitario' => 100,
        'M3_unitario' => 1,
    ];

    $response = $this->post(route('products.store'), $productData);

    $response->assertSessionHasErrors('nombre');
});

/**
 * @test
 * @spec "Un usuario puede ver un producto específico que le pertenece"
 */
it('authenticated user can view their own product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('products.view', $product));

    $response->assertOk();

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Ver Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede ver un producto de otro usuario"
 */
it('user cannot view another user product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('products.view', $product));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver el formulario de edición de su producto"
 */
it('authenticated user can view edit form for their product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->user->id]);

    $response = $this->get(route('products.edit', $product));

    $response->assertOk();
});

/**
 * @test
 * @spec "Un usuario no puede editar un producto de otro usuario"
 */
it('user cannot edit another user product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->get(route('products.edit', $product));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede actualizar su producto"
 */
it('authenticated user can update their product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->user->id]);

    $updateData = [
        'nombre' => 'Producto Actualizado',
        'descripcion' => 'Nueva descripción',
        'precio_unitario' => 200.75,
        'M3_unitario' => 1.5,
    ];

    $response = $this->put(route('products.update', $product), $updateData);

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'nombre' => 'Producto Actualizado',
    ]);

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Editar Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede actualizar un producto de otro usuario"
 */
it('user cannot update another user product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create(['usuario' => $this->otherUser->id]);

    $updateData = [
        'nombre' => 'Intento de actualización',
    ];

    $response = $this->put(route('products.update', $product), $updateData);

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede deshabilitar su producto"
 */
it('authenticated user can disable their product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('products.deshabilitar', $product));

    $response->assertRedirect(route('products.index'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'habilitado' => false,
    ]);

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Deshabilitar Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede deshabilitar un producto de otro usuario"
 */
it('user cannot disable another user product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create([
        'usuario' => $this->otherUser->id,
        'habilitado' => true,
    ]);

    $response = $this->post(route('products.deshabilitar', $product));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede habilitar su producto deshabilitado"
 */
it('authenticated user can enable their disabled product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->disabled()->create(['usuario' => $this->user->id]);

    $response = $this->post(route('products.habilitar', $product));

    $response->assertRedirect(route('products.papelera'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'habilitado' => true,
    ]);

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Habilitar Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un usuario puede eliminar (soft delete) su producto"
 */
it('authenticated user can delete their product (soft delete)', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create([
        'usuario' => $this->user->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('products.eliminar', $product));

    $response->assertRedirect(route('products.papelera'));
    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'eliminado' => true,
    ]);

    // Verificar que se creó un registro de auditoría
    $this->assertDatabaseHas('registros', [
        'accion' => 'Eliminar Producto',
        'usuario' => $this->user->id,
    ]);
});

/**
 * @test
 * @spec "Un usuario no puede eliminar un producto de otro usuario"
 */
it('user cannot delete another user product', function () {
    $this->actingAs($this->user);

    $product = Product::factory()->create([
        'usuario' => $this->otherUser->id,
        'eliminado' => false,
    ]);

    $response = $this->post(route('products.eliminar', $product));

    $response->assertForbidden();
});

/**
 * @test
 * @spec "Un usuario puede ver la papelera con sus productos deshabilitados"
 */
it('authenticated user can view trash with disabled products', function () {
    $this->actingAs($this->user);

    // Productos deshabilitados del usuario
    Product::factory()->count(2)->disabled()->create(['usuario' => $this->user->id]);

    // Productos activos del usuario (no deberían aparecer en papelera)
    Product::factory()->count(3)->create(['usuario' => $this->user->id]);

    $response = $this->get(route('products.papelera'));

    $response->assertOk();
    // Solo deberían aparecer los productos deshabilitados
    expect($response->inertia->page['products'])->toHaveCount(2);
});