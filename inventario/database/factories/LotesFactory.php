<?php

namespace Database\Factories;

use App\Models\Almacen;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * Factory para generar lotes de prueba.
 * 
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lotes>
 * 
 * @spec "Genera lotes con datos válidos para testing"
 * @audit "Los lotes generados son para testing y no afectan datos reales"
 */
class LotesFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'descripcion' => fake()->words(3, true) . ' Batch',
            'producto_id' => Product::factory(),
            'cantidad' => fake()->numberBetween(1, 1000),
            'almacen_id' => Almacen::factory(),
            'estado' => true,
            'usuario' => User::factory(),
            'habilitado' => true,
            'eliminado' => false,
        ];
    }

    /**
     * Indica que el lote está deshabilitado.
     * 
     * @spec "Un lote deshabilitado no está disponible para operaciones"
     */
    public function disabled(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
        ]);
    }

    /**
     * Indica que el lote está eliminado (soft delete).
     * 
     * @spec "Un lote eliminado no debe aparecer en listados principales"
     */
    public function deleted(): static
    {
        return $this->state(fn (array $attributes) => [
            'eliminado' => true,
        ]);
    }

    /**
     * Indica que el lote está inactivo.
     * 
     * @spec "Un lote inactivo no debe estar disponible para ninguna operación"
     */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'habilitado' => false,
            'eliminado' => true,
        ]);
    }

    /**
     * Genera un lote con cantidad baja.
     * 
     * @spec "Lotes con cantidad baja para testing de stock"
     */
    public function lowStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'cantidad' => fake()->numberBetween(1, 10),
        ]);
    }

    /**
     * Genera un lote con cantidad alta.
     * 
     * @spec "Lotes con cantidad alta para testing de stock"
     */
    public function highStock(): static
    {
        return $this->state(fn (array $attributes) => [
            'cantidad' => fake()->numberBetween(100, 1000),
        ]);
    }
}