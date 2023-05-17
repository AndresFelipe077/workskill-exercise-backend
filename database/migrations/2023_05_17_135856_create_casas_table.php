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
        Schema::create('casas', function (Blueprint $table) {
            $table->id();
            $table->string('direccion');
            $table->date('costoAlquiler');
            $table->double('ancho');
            $table->double('largo');
            $table->integer('numeroPisos');
            $table->string('descripcion');
            $table->integer('capacidad');
            $table->foreignId('idCategoria')->references('id')->on('categorias');
            $table->foreignId('idEstado')->references('id')->on('estados');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('casas');
    }
};
