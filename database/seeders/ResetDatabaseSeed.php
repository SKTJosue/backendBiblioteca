<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ResetDatabaseSeed extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');
        DB::table('lista_libros')->truncate();
        DB::table('libros')->truncate();
        DB::table('usuarios')->truncate();
        DB::table('autor_libro')->truncate();
        DB::table('autores')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');

        $this->call([
            LibrosSeed::class,
            UsuariosSeed::class,
            AutoresSeed::class,
            AutorLibroSeed::class,
            ListaLibrosSeed::class,
        ]);
        //
    }
}
