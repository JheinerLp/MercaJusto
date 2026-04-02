<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('proveedores', function (Blueprint $table) {
            $table->id();
            $table->string('empresa');
            $table->unsignedBigInteger('user_id');

            $table->unsignedBigInteger('categoria_id');
            $table->unsignedBigInteger('sede_id');

            $table->string('ubicacion')->nullable();
            $table->string('whatsapp');
            $table->text('descripcion')->nullable();
            $table->string('foto')->nullable();
            $table->string('banner')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->foreign('categoria_id')
                ->references('id')
                ->on('categorias')
                ->onDelete('cascade');

            $table->foreign('sede_id')
                ->references('id')
                ->on('sedes')
                ->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('proveedores');
    }
};
