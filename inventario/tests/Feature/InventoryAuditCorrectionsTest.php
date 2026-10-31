<?php

use App\Models\Almacen;
use App\Models\Lotes;
use App\Models\Product;
use App\Models\Registro;
use App\Models\User;
beforeEach(function () {
    $this->user = User::factory()->create();
    $this->otherUser = User::factory()->create();
    $this->product = Product::factory()->create(['usuario' => $this->user->id]);
    $this->warehouse = Almacen::factory()->create(['usuario' => $this->user->id]);
    $this->actingAs($this->user);
});

it('accepts zero quantity for a lot', function () {
    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Lote sin existencias',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 0,
    ]);

    $response->assertRedirect(route('lotes.index'));
    $this->assertDatabaseHas('lotes', [
        'descripcion' => 'Lote sin existencias',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 0,
        'usuario' => $this->user->id,
    ]);
});

it('rejects negative quantity for a lot', function () {
    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Lote negativo',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => -1,
    ]);

    $response->assertSessionHasErrors('cantidad');
    $this->assertDatabaseMissing('lotes', ['descripcion' => 'Lote negativo']);
});

it('rejects a product that belongs to another user when creating a lot', function () {
    $foreignProduct = Product::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Relación ajena',
        'producto_id' => $foreignProduct->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 1,
    ]);

    $response->assertSessionHasErrors('producto_id');
    $this->assertDatabaseMissing('lotes', ['descripcion' => 'Relación ajena']);
});

it('rejects a product whose business state is inactive when creating a lot', function () {
    $this->product->update(['estado' => false]);

    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Producto inactivo',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 1,
    ]);

    $response->assertSessionHasErrors('producto_id');
});

it('rejects a disabled warehouse when creating a lot', function () {
    $this->warehouse->update(['habilitado' => false]);

    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Almacén deshabilitado',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 1,
    ]);

    $response->assertSessionHasErrors('almacen_id');
});

it('rejects a deleted product and warehouse when creating a lot', function () {
    $this->product->update(['eliminado' => true]);
    $this->warehouse->update(['eliminado' => true]);

    $response = $this->post(route('lotes.store'), [
        'descripcion' => 'Relaciones eliminadas',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => 1,
    ]);

    $response->assertSessionHasErrors(['producto_id', 'almacen_id']);
});

it('rejects a foreign relation when updating a lot', function () {
    $lot = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
    ]);
    $foreignWarehouse = Almacen::factory()->create(['usuario' => $this->otherUser->id]);

    $response = $this->put(route('lotes.update', $lot), [
        'descripcion' => $lot->descripcion,
        'producto_id' => $this->product->id,
        'almacen_id' => $foreignWarehouse->id,
        'cantidad' => $lot->cantidad,
        'estado' => true,
    ]);

    $response->assertSessionHasErrors('almacen_id');
    expect($lot->fresh()->almacen_id)->toBe($this->warehouse->id);
});

it('rejects an inactive product when updating a lot', function () {
    $lot = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
    ]);
    $this->product->update(['estado' => false]);

    $response = $this->put(route('lotes.update', $lot), [
        'descripcion' => $lot->descripcion,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => $lot->cantidad,
        'estado' => true,
    ]);

    $response->assertSessionHasErrors('producto_id');
});

it('does not write an audit record when viewing a lot', function () {
    $lot = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
    ]);
    $countBefore = Registro::count();

    $this->get(route('lotes.view', $lot))->assertOk();

    expect(Registro::count())->toBe($countBefore);
});

it('does not write an audit record when viewing a product or warehouse', function () {
    $countBefore = Registro::count();

    $this->get(route('products.view', $this->product))->assertOk();
    $this->get(route('almacen.view', $this->warehouse))->assertOk();

    expect(Registro::count())->toBe($countBefore);
});

it('does not expose lot state-changing actions through GET', function () {
    $lot = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
    ]);

    $this->get(route('lotes.deshabilitar', $lot))->assertMethodNotAllowed();
});

it('does not expose product or warehouse state-changing actions through GET', function () {
    $this->get(route('products.deshabilitar', $this->product))->assertMethodNotAllowed();
    $this->get(route('almacen.deshabilitar', $this->warehouse))->assertMethodNotAllowed();
    $this->get(route('products.habilitar', $this->product))->assertMethodNotAllowed();
    $this->get(route('almacen.habilitar', $this->warehouse))->assertMethodNotAllowed();
});

it('blocks disabling a product associated with any lot state', function (array $lotState) {
    Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        ...$lotState,
    ]);
    $auditCount = Registro::count();

    $response = $this->post(route('products.deshabilitar', $this->product));

    $response->assertRedirect(route('products.index'))->assertSessionHas('error');
    expect($this->product->fresh()->habilitado)->toBeTrue();
    expect(Registro::count())->toBe($auditCount);
})->with([
    'active lot' => [['habilitado' => true, 'eliminado' => false]],
    'disabled and deleted lot' => [['habilitado' => false, 'eliminado' => true]],
]);

it('blocks deleting a product associated with a lot', function () {
    Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'habilitado' => false,
        'eliminado' => true,
    ]);

    $response = $this->delete(route('products.eliminar', $this->product));

    $response->assertRedirect(route('products.index'))->assertSessionHas('error');
    expect($this->product->fresh()->eliminado)->toBeFalse();
});

it('blocks disabling a warehouse associated with any lot state', function (array $lotState) {
    Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        ...$lotState,
    ]);

    $response = $this->post(route('almacen.deshabilitar', $this->warehouse));

    $response->assertRedirect(route('almacenes.index'))->assertSessionHas('error');
    expect($this->warehouse->fresh()->habilitado)->toBeTrue();
})->with([
    'active lot' => [['habilitado' => true, 'eliminado' => false]],
    'disabled and deleted lot' => [['habilitado' => false, 'eliminado' => true]],
]);

it('blocks deleting a warehouse associated with a lot', function () {
    Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'habilitado' => false,
        'eliminado' => true,
    ]);

    $response = $this->delete(route('almacen.eliminar', $this->warehouse));

    $response->assertRedirect(route('almacenes.index'))->assertSessionHas('error');
    expect($this->warehouse->fresh()->eliminado)->toBeFalse();
});

it('stores an operation UUID and JSON snapshots for inventory mutations', function () {
    $response = $this->post(route('products.store'), [
        'nombre' => 'Producto auditado',
        'descripcion' => 'Registro sintético',
        'precio_unitario' => 12.5,
        'M3_unitario' => 0.25,
    ]);

    $response->assertRedirect(route('products.index'));
    $record = Registro::query()->latest('id')->firstOrFail();

    expect($record->operacion_id)->toMatch('/^[0-9a-f-]{36}$/i');
    expect($record->anterior)->toBeNull();
    expect($record->nuevo)->toMatchArray([
        'nombre' => 'Producto auditado',
        'descripcion' => 'Registro sintético',
        'precio_unitario' => '12.50',
    ]);
    expect($record->usuario)->toBe($this->user->id);
    expect($record->nuevo)->not->toHaveKey('email');
});

it('captures before and after snapshots when updating products, warehouses, and lots', function () {
    $productName = $this->product->nombre;
    $this->put(route('products.update', $this->product), [
        'nombre' => 'Producto actualizado',
        'descripcion' => 'Snapshot nuevo',
        'precio_unitario' => 15,
        'M3_unitario' => 0.5,
        'estado' => true,
    ])->assertRedirect(route('products.index'));

    $productAudit = Registro::query()->where('accion', 'Editar Producto')->latest('id')->firstOrFail();
    expect($productAudit->anterior['nombre'])->toBe($productName);
    expect($productAudit->nuevo['nombre'])->toBe('Producto actualizado');

    $warehouseName = $this->warehouse->nombre;
    $this->put(route('almacen.update', $this->warehouse), [
        'nombre' => 'Almacén actualizado',
        'ubicacion' => 'Bodega norte',
        'descripcion' => 'Snapshot almacén',
        'estado' => true,
    ])->assertRedirect(route('almacenes.index'));

    $warehouseAudit = Registro::query()->where('accion', 'Editar Almacen')->latest('id')->firstOrFail();
    expect($warehouseAudit->anterior['nombre'])->toBe($warehouseName);
    expect($warehouseAudit->nuevo['nombre'])->toBe('Almacén actualizado');

    $lot = Lotes::factory()->create([
        'usuario' => $this->user->id,
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'descripcion' => 'Lote anterior',
    ]);
    $this->put(route('lotes.update', $lot), [
        'descripcion' => 'Lote actualizado',
        'producto_id' => $this->product->id,
        'almacen_id' => $this->warehouse->id,
        'cantidad' => $lot->cantidad,
        'estado' => true,
    ])->assertRedirect(route('lotes.index'));

    $lotAudit = Registro::query()->where('accion', 'Editar Lote')->latest('id')->firstOrFail();
    expect($lotAudit->anterior['descripcion'])->toBe('Lote anterior');
    expect($lotAudit->nuevo['descripcion'])->toBe('Lote actualizado');
    expect($productAudit->operacion_id)->not->toBe($warehouseAudit->operacion_id);
    expect($warehouseAudit->operacion_id)->not->toBe($lotAudit->operacion_id);
});

it('preserves audit records and the actor ID when deleting the account', function () {
    $this->post(route('products.store'), [
        'nombre' => 'Producto histórico',
        'descripcion' => 'Debe conservar auditoría',
        'precio_unitario' => 1,
        'M3_unitario' => 0,
    ])->assertRedirect(route('products.index'));
    $record = Registro::query()->latest('id')->firstOrFail();
    $actorId = $this->user->id;

    $this->user->delete();

    expect(Registro::find($record->id))->not->toBeNull();
    expect(Registro::find($record->id)->usuario)->toBe($actorId);
});

it('rolls back an inventory mutation if its audit insert fails', function () {
    $this->withoutExceptionHandling();
    Registro::creating(function () {
        throw new RuntimeException('Synthetic audit insert failure');
    });

    expect(fn () => $this->post(route('products.store'), [
        'nombre' => 'Debe revertirse',
        'descripcion' => 'Prueba de atomicidad',
        'precio_unitario' => 1,
        'M3_unitario' => 0,
    ]))->toThrow(RuntimeException::class, 'Synthetic audit insert failure');

    $this->assertDatabaseMissing('products', ['nombre' => 'Debe revertirse']);
});
