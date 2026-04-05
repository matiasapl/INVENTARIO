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
        Schema::create('almacens', function (Blueprint $table) {
            $table->id();
            $table->uuid('codigo')->default(DB::raw('UUID()'))->unique();
            $table->string('nombre');
            $table->string('descripcion')->nullable();
            $table->string('ubicacion')->nullable();
            $table->boolean('estado')->default(true);
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
        Schema::dropIfExists('almacens');
    }
};
