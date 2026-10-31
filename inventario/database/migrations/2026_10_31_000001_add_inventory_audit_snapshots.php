<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        $foreignKey = DB::table('information_schema.KEY_COLUMN_USAGE')
            ->where('TABLE_SCHEMA', DB::getDatabaseName())
            ->where('TABLE_NAME', 'registros')
            ->where('COLUMN_NAME', 'usuario')
            ->whereNotNull('REFERENCED_TABLE_NAME')
            ->value('CONSTRAINT_NAME');

        Schema::table('registros', function (Blueprint $table) {
            $table->uuid('operacion_id')->nullable()->after('codigo');
            $table->json('anterior')->nullable()->after('operacion_id');
            $table->json('nuevo')->nullable()->after('anterior');
        });

        if ($foreignKey !== null) {
            Schema::table('registros', function (Blueprint $table) use ($foreignKey) {
                $table->dropForeign($foreignKey);
            });
        }

        DB::table('registros')
            ->whereNull('operacion_id')
            ->update(['operacion_id' => DB::raw('UUID()')]);

        Schema::table('registros', function (Blueprint $table) {
            $table->unique('operacion_id');
        });
    }

    public function down(): void
    {
        Schema::table('registros', function (Blueprint $table) {
            $table->dropUnique(['operacion_id']);
            $table->dropColumn(['operacion_id', 'anterior', 'nuevo']);
        });

        // Keep the actor ID column free of a user FK: accounts may have been
        // deleted since this migration, and restoring the cascade would erase history.
    }
};
