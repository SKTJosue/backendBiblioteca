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
        Schema::create('listas_de_libros', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('usuario_id');
            $table->string('nombre');
            $table->timestamps();
        
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
        });
        
        Schema::create('libro_lista', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('lista_de_libros_id');
            $table->unsignedBigInteger('libro_id');
            $table->timestamps();
        
            $table->foreign('lista_de_libros_id')->references('id')->on('listas_de_libros')->onDelete('cascade');
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lista_de_libros');
    }
};
