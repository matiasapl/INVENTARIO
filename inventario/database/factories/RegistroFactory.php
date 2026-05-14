<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para generar registros de auditoría de prueba.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Registro>
 * 
 * @spec "Genera registros de auditoría con datos válidos para testing"
 * @audit "Los registros generados simulan actividades reales del sistema"
 */
class RegistroFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $acciones = [
            'Crear Producto',
            'Editar Producto',
            'Eliminar Producto',
            'Habilitar Producto',
            'Deshabilitar Producto',
            'Ver Producto',
            'Crear Almacén',
            'Editar Almacén',
            'Eliminar Almacén',
            'Crear Lote',
            'Editar Lote',
            'Eliminar Lote',
        ];

        $tipos = ['Manual', 'Automático', 'Sistema'];

        // Generar un código UUID simulado para el registro
        $codigo = fake()->uuid();

        // Obtener un producto aleatorio para el nombre (si existe)
        $producto = Product::inRandomOrder()->first();
        $nombre = $producto ? $producto->nombre : fake()->words(2, true);

        return [
            'codigo' => $codigo,
            'nombre' => $nombre,
            'accion' => fake()->randomElement($acciones),
            'tipo' => fake()->randomElement($tipos),
            'usuario' => User::factory(),
        ];
    }

    /**
     * Genera un registro de creación de producto.
     * 
     * @spec "Registro específico para acción de crear producto"
     */
    public function productCreated(): static
    {
        return $this->state(fn (array $attributes) => [
            'accion' => 'Crear Producto',
            'tipo' => 'Manual',
        ]);
    }

    /**
     * Genera un registro de edición de producto.
     * 
     * @spec "Registro específico para acción de editar producto"
     */
    public function productUpdated(): static
    {
        return $this->state(fn (array $attributes) => [
            'accion' => 'Editar Producto',
            'tipo' => 'Manual',
        ]);
    }

    /**
     * Genera un registro de eliminación de producto.
     * 
     * @spec "Registro específico para acción de eliminar producto"
     */
    public function productDeleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'accion' => 'Eliminar Producto',
            'tipo' => 'Manual',
        ]);
    }

    /**
     * Genera un registro de acción automática del sistema.
     * 
     * @spec "Registro generado automáticamente por el sistema"
     */
    public function automatic(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 'Automático',
        ]);
    }

    /**
     * Genera un registro de acción del sistema.
     * 
     * @spec "Registro generado por procesos del sistema"
     */
    public function system(): static
    {
        return $this->state(fn (array $attributes) => [
            'tipo' => 'Sistema',
        ]);
    }
}