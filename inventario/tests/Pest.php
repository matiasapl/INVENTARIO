<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/*
|--------------------------------------------------------------------------
| Test Case Configuration
|--------------------------------------------------------------------------
|
| Configura el caso de prueba base para todos los tests del proyecto.
| Se utiliza RefreshDatabase para limpiar la BD después de cada test,
| asegurando que las pruebas sean aisladas y no afecten datos reales.
|
| @spec "Configuración base para tests de la aplicación"
| @audit "Los tests no modifican datos de producción"
|
*/

pest()
    ->extend(TestCase::class)
    ->use(RefreshDatabase::class)
    ->in('Feature')
    ->in('Unit');

/*
|--------------------------------------------------------------------------
| Expectations Extensions
|--------------------------------------------------------------------------
|
| Extensiones personalizadas para el API de expectativas de Pest.
| Estas extensiones permiten escribir tests más expresivos y legibles.
|
*/

expect()->extend('toBeValidUuid', function () {
    return $this->toBeString()
        ->and(preg_match('/^[0-9a-f]{8}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{4}-[0-9a-f]{12}$/i', $this->value))->toBeTrue();
});

expect()->extend('toBeActiveProduct', function () {
    return $this->toBeObject()
        ->and($this->value->habilitado)->toBeTrue()
        ->and($this->value->eliminado)->toBeFalse();
});

expect()->extend('toBeDisabledProduct', function () {
    return $this->toBeObject()
        ->and($this->value->habilitado)->toBeFalse()
        ->and($this->value->eliminado)->toBeFalse();
});

expect()->extend('toBeDeletedProduct', function () {
    return $this->toBeObject()
        ->and($this->value->eliminado)->toBeTrue();
});

expect()->extend('toBeActiveAlmacen', function () {
    return $this->toBeObject()
        ->and($this->value->habilitado)->toBeTrue()
        ->and($this->value->eliminado)->toBeFalse();
});

expect()->extend('toBeActiveLote', function () {
    return $this->toBeObject()
        ->and($this->value->habilitado)->toBeTrue()
        ->and($this->value->eliminado)->toBeFalse();
});

/*
|--------------------------------------------------------------------------
| Global Helper Functions
|--------------------------------------------------------------------------
|
| Funciones globales para reutilizar código común en los tests.
| Estas funciones ayudan a mantener los tests DRY (Don't Repeat Yourself).
|
*/

/**
 * Crea un usuario autenticado para los tests.
 * 
 * @spec "Provee un usuario autenticado para tests que requieren login"
 * @return \App\Models\User
 */
function createUser(array $attributes = []): \App\Models\User
{
    return \App\Models\User::factory()->create($attributes);
}

/**
 * Autentica un usuario para los tests.
 * 
 * @spec "Autentica un usuario para tests que requieren login"
 * @return \App\Models\User
 */
function authenticateUser(array $attributes = []): \App\Models\User
{
    $user = createUser($attributes);
    test()->actingAs($user);
    return $user;
}

/**
 * Crea un producto de prueba.
 * 
 * @spec "Provee un producto válido para tests"
 * @return \App\Models\Product
 */
function createProduct(array $attributes = []): \App\Models\Product
{
    return \App\Models\Product::factory()->create($attributes);
}

/**
 * Crea un almacén de prueba.
 * 
 * @spec "Provee un almacén válido para tests"
 * @return \App\Models\Almacen
 */
function createAlmacen(array $attributes = []): \App\Models\Almacen
{
    return \App\Models\Almacen::factory()->create($attributes);
}

/**
 * Crea un lote de prueba.
 * 
 * @spec "Provee un lote válido para tests"
 * @return \App\Models\Lotes
 */
function createLote(array $attributes = []): \App\Models\Lotes
{
    return \App\Models\Lotes::factory()->create($attributes);
}

/**
 * Crea un registro de auditoría de prueba.
 * 
 * @spec "Provee un registro válido para tests"
 * @return \App\Models\Registro
 */
function createRegistro(array $attributes = []): \App\Models\Registro
{
    return \App\Models\Registro::factory()->create($attributes);
}

/**
 * Verifica que una ruta requiere autenticación.
 * 
 * @spec "Tests que una ruta redirige a login cuando no está autenticado"
 */
function assertRouteRequiresAuth(string $route, string $method = 'get', array $params = []): void
{
    $response = test()->{$method}(route($route, $params));
    $response->assertRedirect(route('login'));
}

/**
 * Verifica que una ruta requiere autorización (403 Forbidden).
 * 
 * @spec "Tests que una ruta devuelve 403 cuando no hay permisos"
 */
function assertRouteRequiresAuthorization(string $route, array $params = []): void
{
    $user = authenticateUser();
    $response = test()->get(route($route, $params));
    $response->assertForbidden();
}