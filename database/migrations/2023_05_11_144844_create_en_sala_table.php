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
        Schema::create('en_sala', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('estudiante_id');
            $table->unsignedBigInteger('libro_id');
            $table->boolean('estado')->default(true);
            $table->dateTime('hora_entrada');
            $table->dateTime('hora_salida')->nullable();
            $table->foreign('estudiante_id')->references('id')->on('estudiantes');
            $table->foreign('libro_id')->references('id')->on('libros');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('en_sala');
    }
};
