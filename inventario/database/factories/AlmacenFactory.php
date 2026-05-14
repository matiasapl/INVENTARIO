<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para generar almacenes de prueba.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Almacen>
 * 
 * @spec "Genera almacenes con datos válidos para testing"
 * @audit "Los almacenes generados son para testing y no afectan datos reales"
 */
class AlmacenFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->words(2, true) . ' Warehouse',
            'descripcion' => fake()->optional(0.8)->sentence(),
            'ubicacion' => fake()->optional(0.7)->city(),
            'estado' => true,
            'habilitado' => true,
            'eliminado' => false,
            'usuario' => User::factory(),
        ];
    }

    /**
     * Indica que el almacén está deshabilitado.
     * 
     * @spec "Un almacén deshabilitado no está disponible para operaciones"
     */
    public function disabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
        ]);
    }

    /**
     * Indica que el almacén está eliminado (soft delete).
     * 
     * @spec "Un almacén eliminado no debe aparecer en listados principales"
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'eliminado' => true,
        ]);
    }

    /**
     * Indica que el almacén está inactivo.
     * 
     * @spec "Un almacén inactivo no debe estar disponible para ninguna operación"
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
            'eliminado' => true,
        ]);
    }
}