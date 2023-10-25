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
        Schema::create('editorial', function (Blueprint $table) {
            $table->id();
            $table->string('nombreEditorial');
            $table->timestamps();
        });
        Schema::create('catalogacion_biblioteca', function (Blueprint $table) {
            $table->id();
            $table->integer('inventario')->unique();
            $table->string('codigoAutor');
            $table->string('codigoLibro');
            $table->integer('ejemplar')->default(1);
            $table->integer('tomo')->default(0);
            $table->integer('volumen')->default(0);
            $table->timestamps();
        });
        Schema::create('topicos', function (Blueprint $table) {
            $table->id();
            $table->string('materia');
            $table->text('topicoBusqueda');
            $table->timestamps();
        });
        Schema::create('libros', function (Blueprint $table) {
            $table->id();
            $table->string('titulo_Principal');
            $table->string('titulo_secundario')->nullable();
            $table->string('idioma_libro');
            $table->string('pais');
            $table->string('ciudad');
            $table->string('codigo_isbn');
            $table->integer('anio_publicacion');
            $table->integer('numero_edicion');
            $table->integer('numero_paginas');
            $table->string('topologia_libro');
            $table->string('contiene');
            $table->string('incluye');
            $table->string('tipoAdquisicion');
            $table->text('indice');
            $table->text('imagen')->default('default.png');
            $table->string('estado')->default('disponible');
            // esta parte establece la relacion editorial y libro
            // si se elimina la editorial todos los libros que tenia a esa editorial estaran null 
            $table->unsignedBigInteger('editorial_id')->nullable();
            $table->unsignedBigInteger('catalogacion_id');
            $table->unsignedBigInteger('topicos_id');
            $table->foreign('catalogacion_id')->references('id')->on('catalogacion_biblioteca');
            $table->foreign('editorial_id')->references('id')->on('editorial')->onDelete('set null');
            //
            $table->foreign('topicos_id')->references('id')->on('topicos');
            $table->timestamps();
        });
        Schema::create('autor_libro', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('autor_id');
            $table->unsignedBigInteger('libro_id');
            $table->foreign('autor_id')->references('id')->on('autor')->onDelete('cascade');
            $table->foreign('libro_id')->references('id')->on('libros')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('editorial');
        Schema::dropIfExists('autor_libro');
        Schema::dropIfExists('catalogacion_biblioteca');
        Schema::dropIfExists('libros');
        Schema::dropIfExists('topicos');
    }
};
