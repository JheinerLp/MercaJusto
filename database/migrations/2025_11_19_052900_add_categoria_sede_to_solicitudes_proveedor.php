<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('solicitudes_proveedor', function (Blueprint $table) {
            // Nuevas columnas
            $table->unsignedBigInteger('categoria_id')->nullable()->after('direccion');
            $table->unsignedBigInteger('sede_id')->nullable()->after('categoria_id');

            // Foreign keys
            $table->foreign('categoria_id')
                ->references('id')->on('categorias')
                ->onDelete('set null');

            $table->foreign('sede_id')
                ->references('id')->on('sedes')
                ->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::table('solicitudes_proveedor', function (Blueprint $table) {
            $table->dropForeign(['categoria_id']);
            $table->dropForeign(['sede_id']);

            $table->dropColumn('categoria_id');
            $table->dropColumn('sede_id');
        });
    }
};
