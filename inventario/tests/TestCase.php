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

    protected function setUp(): void
    {
        $this->assertIsolatedTestDatabaseConfiguration();

        parent::setUp();
    }

    private function assertIsolatedTestDatabaseConfiguration(): void
    {
        $connection = getenv('DB_CONNECTION');
        $host = getenv('DB_HOST');
        $port = filter_var(getenv('DB_PORT'), FILTER_VALIDATE_INT);
        $database = getenv('DB_DATABASE');
        $optIn = getenv('INVENTARIO_TEST_DATABASE');

        if (
            getenv('APP_ENV') !== 'testing'
            || $optIn !== 'isolated'
            || $connection !== 'mariadb'
            || !in_array($host, ['127.0.0.1', 'localhost'], true)
            || $port === false
            || $port < 32768
            || $port > 65535
            || !is_string($database)
            || !preg_match('/^inventario_test_[a-f0-9]{8,}$/', $database)
            || getenv('DB_URL')
        ) {
            throw new \LogicException(
                'Tests require explicit opt-in and a uniquely named MariaDB test database on a nonstandard loopback port.'
            );
        }
    }
}
