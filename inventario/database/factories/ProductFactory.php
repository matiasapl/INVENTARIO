<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para generar productos de prueba.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 * 
 * @spec "Genera productos con datos válidos para testing"
 * @audit "Los productos generados son para testing y no afectan datos reales"
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => fake()->words(3, true),
            'descripcion' => fake()->optional(0.8)->sentence(),
            'precio_unitario' => fake()->randomFloat(2, 100, 10000),
            'M3_unitario' => fake()->randomFloat(5, 0.001, 10),
            'usuario' => User::factory(),
            'estado' => true,
            'habilitado' => true,
            'eliminado' => false,
        ];
    }

    /**
     * Indica que el producto está deshabilitado.
     * 
     * @spec "Un producto deshabilitado no está disponible para operaciones"
     */
    public function disabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
        ]);
    }

    /**
     * Indica que el producto está eliminado (soft delete).
     * 
     * @spec "Un producto eliminado no debe aparecer en listados principales"
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'eliminado' => true,
        ]);
    }

    /**
     * Indica que el producto está inactivo (deshabilitado y eliminado).
     * 
     * @spec "Un producto inactivo no debe estar disponible para ninguna operación"
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
            'eliminado' => true,
        ]);
    }

    /**
     * Genera un producto con precio bajo.
     * 
     * @spec "Productos con precio bajo para testing de rangos"
     */
    public function cheap(): static
    {
        return $this->state(fn (array $attributes) => [
            'precio_unitario' => fake()->randomFloat(2, 1, 99),
        ]);
    }

    /**
     * Genera un producto con precio alto.
     * 
     * @spec "Productos con precio alto para testing de rangos"
     */
    public function expensive(): static
    {
        return $this->state(fn (array $attributes) => [
            'precio_unitario' => fake()->randomFloat(2, 10001, 100000),
        ]);
    }
}