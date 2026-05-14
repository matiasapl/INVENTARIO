<?php

use App\Models\Product;
use App\Models\Registro;
use App\Models\User;

/**
 * Tests de características para gestión completa de productos.
 * 
 * @spec "Los flujos completos de gestión de productos funcionan correctamente"
 * @audit "Se verifica que todas las acciones queden registradas para auditoría"
 */

beforeEach(function () {
    $this->user = createUser();
});

/**
 * @test
 * @spec "Un usuario puede crear, ver, editar y deshabilitar un producto en un flujo completo"
 */
it('user can create view edit and disable a product in a complete flow', function () {
    $this->actingAs($this->user);

    // Paso 1: Crear producto
    $productData = [
        'nombre' => 'Producto Flujo Completo',
        'descripcion' => 'Producto para test de flujo completo',
        'precio_unitario' => 150.75,
        'M3_unitario' => 0.8,
    ];

    $this->post(route('products.store'), $productData)->assertRedirect(route('products.index'));

    $product = Product::where('nombre', 'Producto Flujo Completo')->first();
    expect($product)->not->toBeNull();

    // Verificar registro de auditoría de creación
    $this->assertDatabaseHas('registros', [
        'accion' => 'Crear Producto',
        'nombre' => 'Producto Flujo Completo',
        'usuario' => $this->user->id,
    ]);

    // Paso 2: Ver producto
    $response = $this->get(route('products.view', $product));
    $response->assertOk();

    // Verificar registro de auditoría de visualización
    $this->assertDatabaseHas('registros', [
        'accion' => 'Ver Producto',
        'nombre' => 'Producto Flujo Completo',
        'usuario' => $this->user->id,
    ]);

    // Paso 3: Editar producto
    $updateData = [
        'nombre' => 'Producto Flujo Completo Editado',
        'descripcion' => 'Descripción actualizada',
        'precio_unitario' => 200.50,
        'M3_unitario' => 1.2,
    ];

    $this->put(route('products.update', $product), $updateData)
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'nombre' => 'Producto Flujo Completo Editado',
    ]);

    // Verificar registro de auditoría de edición
    $this->assertDatabaseHas('registros', [
        'accion' => 'Editar Producto',
        'nombre' => 'Producto Flujo Completo Editado',
        'usuario' => $this->user->id,
    ]);

    // Paso 4: Deshabilitar producto
    $this->post(route('products.deshabilitar', $product))
        ->assertRedirect(route('products.index'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'habilitado' => false,
    ]);

    // Verificar registro de auditoría de deshabilitación
    $this->assertDatabaseHas('registros', [
        'accion' => 'Deshabilitar Producto',
        'nombre' => 'Producto Flujo Completo Editado',
        'usuario' => $this->user->id,
    ]);

    // Paso 5: Verificar que el producto deshabilitado no aparece en lista principal
    $response = $this->get(route('products.index'));
    $response->assertOk();
    // El producto deshabilitado no debería estar en la lista
    $productsIds = collect($response->inertia->page['products']['data'])
        ->pluck('id')
        ->toArray();
    expect($productsIds)->not->toContain($product->id);

    // Paso 6: Habilitar producto nuevamente
    $this->post(route('products.habilitar', $product))
        ->assertRedirect(route('products.papelera'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'habilitado' => true,
    ]);

    // Verificar registro de auditoría de habilitación
    $this->assertDatabaseHas('registros', [
        'accion' => 'Habilitar Producto',
        'nombre' => 'Producto Flujo Completo Editado',
        'usuario' => $this->user->id,
    ]);

    // Paso 7: Eliminar producto (soft delete)
    $this->post(route('products.eliminar', $product))
        ->assertRedirect(route('products.papelera'));

    $this->assertDatabaseHas('products', [
        'id' => $product->id,
        'eliminado' => true,
    ]);

    // Verificar registro de auditoría de eliminación
    $this->assertDatabaseHas('registros', [
        'accion' => 'Eliminar Producto',
        'nombre' => 'Producto Flujo Completo Editado',
        'usuario' => $this->user->id,
    ]);

    // Paso 8: Verificar que el producto eliminado no aparece en ninguna lista
    $response = $this->get(route('products.index'));
    $productsIds = collect($response->inertia->page['products']['data'])
        ->pluck('id')
        ->toArray();
    expect($productsIds)->not->toContain($product->id);

    // Pero sí aparece en la papelera
    $response = $this->get(route('products.papelera'));
    $trashProductIds = collect($response->inertia->page['products'])
        ->pluck('id')
        ->toArray();
    expect($trashProductIds)->toContain($product->id);
});

/**
 * @test
 * @spec "Un usuario puede crear múltiples productos y verlos todos en su lista"
 */
it('user can create multiple products and see them all in their list', function () {
    $this->actingAs($this->user);

    // Crear 5 productos
    $productNames = [
        'Producto 1',
        'Producto 2',
        'Producto 3',
        'Producto 4',
        'Producto 5',
    ];

    foreach ($productNames as $name) {
        $this->post(route('products.store'), [
            'nombre' => $name,
            'precio_unitario' => 100,
            'M3_unitario' => 1,
        ])->assertRedirect(route('products.index'));
    }

    // Verificar que todos los productos fueron creados
    foreach ($productNames as $name) {
        $this->assertDatabaseHas('products', [
            'nombre' => $name,
            'usuario' => $this->user->id,
        ]);
    }

    // Ver que todos aparecen en la lista
    $response = $this->get(route('products.index'));
    $response->assertOk();

    $productNamesInList = collect($response->inertia->page['products']['data'])
        ->pluck('name')
        ->toArray();

    foreach ($productNames as $name) {
        expect(in_array($name, $productNamesInList))->toBeTrue();
    }
});

/**
 * @test
 * @spec "Un usuario puede filtrar productos por estado (activo/deshabilitado)"
 */
it('user can filter products by status active disabled', function () {
    $this->actingAs($this->user);

    // Crear productos activos
    Product::factory()->count(3)->create([
        'usuario' => $this->user->id,
        'habilitado' => true,
        'eliminado' => false,
    ]);

    // Crear productos deshabilitados
    Product::factory()->count(2)->disabled()->create([
        'usuario' => $this->user->id,
    ]);

    // Ver lista principal (solo activos)
    $response = $this->get(route('products.index'));
    $response->assertOk();
    expect($response->inertia->page['products']['data'])->toHaveCount(3);

    // Ver papelera (solo deshabilitados)
    $response = $this->get(route('products.papelera'));
    $response->assertOk();
    expect($response->inertia->page['products'])->toHaveCount(2);
});

/**
 * @test
 * @spec "El sistema registra todas las acciones importantes en la bitácora"
 */
it('system logs all important actions in the audit trail', function () {
    $this->actingAs($this->user);

    // Crear producto
    $productData = [
        'nombre' => 'Producto Auditado',
        'precio_unitario' => 100,
        'M3_unitario' => 1,
    ];

    $this->post(route('products.store'), $productData);

    $product = Product::where('nombre', 'Producto Auditado')->first();

    // Ver producto
    $this->get(route('products.view', $product));

    // Editar producto
    $this->put(route('products.update', $product), [
        'nombre' => 'Producto Auditado Editado',
        'precio_unitario' => 150,
        'M3_unitario' => 1.5,
    ]);

    // Deshabilitar producto
    $this->post(route('products.deshabilitar', $product));

    // Habilitar producto
    $this->post(route('products.habilitar', $product));

    // Eliminar producto
    $this->post(route('products.eliminar', $product));

    // Verificar que existen todos los registros de auditoría
    $registros = Registro::where('usuario', $this->user->id)->get();

    $acciones = $registros->pluck('accion')->toArray();

    expect($acciones)->toContain('Crear Producto');
    expect($acciones)->toContain('Ver Producto');
    expect($acciones)->toContain('Editar Producto');
    expect($acciones)->toContain('Deshabilitar Producto');
    expect($acciones)->toContain('Habilitar Producto');
    expect($acciones)->toContain('Eliminar Producto');
});