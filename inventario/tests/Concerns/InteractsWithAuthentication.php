<?php

namespace Tests\Concerns;

use App\Models\User;
use Illuminate\Foundation\Testing\Concerns\InteractsWithAuthentication as BaseInteractsWithAuthentication;

/**
 * Trait para manejo de autenticación en tests.
 * 
 * Este trait extiende la funcionalidad base de autenticación de Laravel
 * y provee métodos adicionales para manejar autenticación en tests.
 * 
 * @spec "Provee métodos para autenticar usuarios en tests de manera consistente"
 * @audit "Los usuarios creados para tests son eliminados después de cada prueba"
 * 
 * @mixin \Tests\TestCase
 */
trait InteractsWithAuthentication
{
    /**
     * Crea y autentica un usuario para los tests.
     * 
     * @spec "Un usuario autenticado puede acceder a rutas protegidas"
     * @return User
     */
    protected function createAuthenticatedUser(array $attributes = []): User
    {
        $user = User::factory()->create($attributes);
        $this->actingAs($user);
        
        return $user;
    }

    /**
     * Crea un usuario sin autenticar.
     * 
     * @spec "Un usuario no autenticado no puede acceder a rutas protegidas"
     * @return User
     */
    protected function createUnauthenticatedUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }

    /**
     * Verifica que una ruta requiere autenticación.
     * 
     * @spec "Las rutas protegidas redirigen a login cuando no hay usuario autenticado"
     * @param string $route Nombre de la ruta
     * @param string $method Método HTTP (get, post, put, patch, delete)
     * @param array $params Parámetros de la ruta
     * @return void
     */
    protected function assertRouteRequiresAuthentication(
        string $route, 
        string $method = 'get', 
        array $params = []
    ): void {
        $response = $this->{$method}(route($route, $params));
        $response->assertRedirect(route('login'));
    }

    /**
     * Verifica que una ruta requiere autorización (403 Forbidden).
     * 
     * @spec "Las rutas con autorización devuelven 403 cuando el usuario no tiene permisos"
     * @param string $route Nombre de la ruta
     * @param array $params Parámetros de la ruta
     * @param User|null $user Usuario para autenticar (por defecto crea uno nuevo)
     * @return void
     */
    protected function assertRouteRequiresAuthorization(
        string $route, 
        array $params = [], 
        ?User $user = null
    ): void {
        if (is_null($user)) {
            $user = $this->createAuthenticatedUser();
        } else {
            $this->actingAs($user);
        }

        $response = $this->get(route($route, $params));
        $response->assertForbidden();
    }

    /**
     * Verifica que un usuario autenticado puede acceder a una ruta.
     * 
     * @spec "Un usuario autenticado puede acceder a rutas protegidas"
     * @param string $route Nombre de la ruta
     * @param User|null $user Usuario para autenticar (por defecto crea uno nuevo)
     * @param array $params Parámetros de la ruta
     * @return \Illuminate\Testing\TestResponse
     */
    protected function actAsUserAndAccessRoute(
        string $route, 
        ?User $user = null, 
        array $params = []
    ): \Illuminate\Testing\TestResponse {
        if (is_null($user)) {
            $user = $this->createAuthenticatedUser();
        } else {
            $this->actingAs($user);
        }

        return $this->get(route($route, $params));
    }

    /**
     * Verifica que un usuario no autenticado es redirigido al login.
     * 
     * @spec "Un usuario no autenticado es redirigido a la página de login"
     * @param string $route Nombre de la ruta
     * @param array $params Parámetros de la ruta
     * @return void
     */
    protected function assertGuestIsRedirectedToLogin(
        string $route, 
        array $params = []
    ): void {
        $response = $this->get(route($route, $params));
        $response->assertRedirect(route('login'));
    }

    /**
     * Crea un usuario con two-factor authentication deshabilitado.
     * 
     * @spec "Un usuario sin 2FA puede acceder sin verificar código"
     * @return User
     */
    protected function createAuthenticatedUserWithoutTwoFactor(array $attributes = []): User
    {
        $user = User::factory()->withoutTwoFactor()->create($attributes);
        $this->actingAs($user);
        
        return $user;
    }

    /**
     * Crea un usuario con email no verificado.
     * 
     * @spec "Un usuario con email no verificado puede tener restricciones"
     * @return User
     */
    protected function createAuthenticatedUserWithUnverifiedEmail(array $attributes = []): User
    {
        $user = User::factory()->unverified()->create($attributes);
        $this->actingAs($user);
        
        return $user;
    }
}