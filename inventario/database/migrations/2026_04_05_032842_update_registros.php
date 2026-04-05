<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            // Eliminar columnas antiguas
            $table->dropColumn('codigo');

            // Agregar nueva columna UUID
            $table->uuid('codigo')->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            // Revertir cambios
            $table->dropColumn('codigo');
            $table->unsignedInteger('codigo')->after('id');
        });
    }
};