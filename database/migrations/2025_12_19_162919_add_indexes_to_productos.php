<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Habilitar extensión para búsquedas avanzadas (solo si no existe)
        DB::statement('CREATE EXTENSION IF NOT EXISTS pg_trgm');

        // Índice para búsqueda por nombre
        DB::statement('
            CREATE INDEX IF NOT EXISTS idx_productos_nombre_trgm
            ON productos USING gin (nombre gin_trgm_ops)
        ');

        // Índice para búsqueda por descripción
        DB::statement('
            CREATE INDEX IF NOT EXISTS idx_productos_descripcion_trgm
            ON productos USING gin (descripcion gin_trgm_ops)
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement('DROP INDEX IF EXISTS idx_productos_nombre_trgm');
        DB::statement('DROP INDEX IF EXISTS idx_productos_descripcion_trgm');
    }
};
