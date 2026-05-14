<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Concerns\InteractsWithAuthentication;

/**
 * Caso de prueba base para todos los tests del proyecto.
 * 
 * Este caso de prueba proporciona métodos y configuraciones comunes
 * para todos los tests, incluyendo autenticación y helpers de prueba.
 * 
 * @spec "Base para todos los tests de la aplicación"
 * @audit "Todos los tests heredan de esta clase para consistencia"
 */
abstract class TestCase extends BaseTestCase
{
    use InteractsWithAuthentication;
}
