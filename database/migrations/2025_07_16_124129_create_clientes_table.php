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
        Schema::create('clientes', function (Blueprint $table) {
            $table->id();
            $table->string('nro_documento');
            $table->foreignId('id_documento')->references('id')->on('tipo_documentos');
            $table->string('nombre');
            $table->string('direccion');
            $table->string('telefono')->nullable();
            $table->foreignId('id_distrito')->references('id')->on('distritos');
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clientes');
    }
};
