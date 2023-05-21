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
        Schema::create('alquilers', function (Blueprint $table) {
            $table->id();
            $table->date('fechaInicio');
            $table->date('fechaFin');
            $table->double('descuento');
            // $table->foreignId('idEstadoAlquiler')->references('id')->on('estado_alquilers')->nullable();
            $table->foreignId('idCasa')->references('id')->on('casas');
            $table->foreignId('idUser')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alquilers');
    }
};
