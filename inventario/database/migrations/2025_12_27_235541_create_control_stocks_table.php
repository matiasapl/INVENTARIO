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
        Schema::create('control_stocks', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('codigo');
            $table->string('nombre');
            $table->unsignedInteger('stock_previo');
            $table->unsignedInteger('stock_actual');
            $table->string('accion');
            $table->string('tipo');
            $table->foreignId('usuario')->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('control_stocks');
    }
};
