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
        Schema::create('detalle_despachos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_programa_despacho')->references('id')->on('programa_despachos');
            $table->foreignId('id_tipo_concreto')->references('id')->on('tipo_concretos');
            $table->foreignId('id_metodo_colocacion')->references('id')->on('metodo_colocacions');
            $table->foreignId('id_bomba')->references('id')->on('bombas');
            $table->foreignId('id_tipo_cemento')->references('id')->on('tipo_cementos');
            $table->foreignId('id_estructura')->references('id')->on('estructuras');
            $table->foreignId('id_cliente')->references('id')->on('clientes');
            $table->foreignId('id_obra')->references('id')->on('obras');
            $table->decimal('metros_cubicos',9,2);
            $table->decimal('pulgadas',9,2);
            $table->time('hora_despacho');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalle_despachos');
    }
};
