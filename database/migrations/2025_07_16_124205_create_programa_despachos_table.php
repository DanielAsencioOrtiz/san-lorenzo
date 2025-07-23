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
        Schema::create('programa_despachos', function (Blueprint $table) {
            $table->id();
            $table->date('fecha_programa');
            $table->foreignId('id_sede')->references('id')->on('sedes');
            $table->decimal('total_m3', 9, 2)->default(0);
            $table->time('hora_entrada_personal')->nullable();
            $table->boolean('estado')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('programa_despachos');
    }
};
