<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Eliminar columnas antiguas
            $table->dropColumn('codigo');
            $table->dropColumn('stock');

            // Agregar nueva columna UUID
            $table->uuid('codigo')->default(DB::raw('UUID()'))->unique()->after('id');

            // Agregar columna estado si no existía
            $table->boolean('estado')->default(true)->after('usuario');
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn('codigo');
            $table->dropColumn('estado');

            $table->unsignedInteger('codigo')->after('id');
            $table->unsignedInteger('stock')->default(0)->after('descripcion');
        });
    }
};