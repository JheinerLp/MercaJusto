<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('solicitudes_proveedor', function (Blueprint $table) {
            $table->id();

            // Datos del solicitante
            $table->string('nombre');
            $table->string('correo');
            $table->string('telefono')->nullable();
            $table->text('descripcion')->nullable();
            $table->text('motivo_rechazo')->nullable();
            

            // Datos de la empresa
            $table->string('nombre_empresa');    
            $table->string('direccion')->nullable();




            // Estado de la solicitud
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado'])
                  ->default('pendiente');

            // Respuesta del administrador
            $table->text('respuesta_admin')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('solicitudes_proveedor');
    }
};
