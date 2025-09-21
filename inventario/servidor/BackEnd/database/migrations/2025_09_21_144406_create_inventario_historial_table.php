<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('inventario_historial', function (Blueprint $table) {
            $table->id();
            $table->string('motivo', 255)->nullable();
            $table->dateTime('fecha');
            $table->foreignId('responsable')->constrained('usuarios');
            $table->string('producto', 30);
            $table->string('categoria', 30)->nullable();
            $table->integer('stock');
            $table->decimal('precio', 10, 2);
            $table->integer('alerta')->nullable();
            $table->string('tipo_edicion', 30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventario_historial');
    }
};
