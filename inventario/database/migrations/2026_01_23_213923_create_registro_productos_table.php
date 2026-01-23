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
        Schema::create('registro_productos', function (Blueprint $table) {
        $table->id();
        $table->string('codigo');
        $table->string('descripcion');
        $table->string('ubicacion');
        $table->string('categoria')->nullable();
        $table->decimal('precio', 10, 2)->unsigned()->default(0.00);
        $table->decimal('m3', 14, 5)->unsigned()->default(0.00000);
        $table->foreignId('usuario')->constrained('users')->onDelete('cascade');
        $table->boolean('habilitado')->default(true);
        $table->boolean('eliminado')->default(false);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registro_productos');
    }
};
