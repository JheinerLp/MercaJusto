<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tickets', function (Blueprint $table) {
            $table->id();

            $table->string('titulo');
            $table->text('descripcion');

            // Para proveedores registrados (opcional)
            $table->unsignedBigInteger('proveedor_id')->nullable();

            // Para usuarios registrados comunes (opcional)
            $table->unsignedBigInteger('user_id')->nullable();

            // Para personas sin cuenta
            $table->string('nombre_contacto')->nullable();
            $table->string('correo_contacto')->nullable();

            // Estado del ticket
            $table->enum('estado', ['abierto', 'en_proceso', 'cerrado'])->default('abierto');

            $table->timestamps();

            // Llaves foráneas
            $table->foreign('proveedor_id')->references('id')->on('proveedores')->onDelete('set null');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
