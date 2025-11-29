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

    Schema::create('products', function (Blueprint $table) {
        $table->id();
        $table->integer('codigo');
        $table->string('nombre');
        $table->string('descripcion')->nullable();
        $table->unsignedInteger('stock')->default(0);
        $table->unsignedDecimal('precio_unitario', 10, 2)->default(0.00);
        $table->unsignedDecimal('M3_unitario', 14, 5)->default(0.00000);
        $table->foreignId('usuario')->constrained('users')->onDelete('cascade');
        $table->timestamps();
    });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
