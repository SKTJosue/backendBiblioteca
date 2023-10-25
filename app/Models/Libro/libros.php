<?php
namespace App\Models\Libro;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Autor\autor;
use App\Models\AutorLibro\AutorLibros;
use App\Models\EnSala\enSala;
use App\Models\Estudiante\estudiante;
use App\Models\Catalogacion\catalogacion;
use App\Models\Topicos\topicos;
use App\Models\Editorial\editorial;
class libros extends Model
{
    use HasFactory;
    protected $table= 'libros';
    protected $fillable=[
    'titulo_Principal',
    'titulo_secundario',
    'idioma_libro',
    'pais',
    'ciudad',
    'codigo_isbn',
    'anio_publicacion',
    'numero_edicion',
    'numero_paginas',
    'topologia_libro',
    'contiene',
    'incluye',
    'tipoAdquisicion',
    'indice',
    'topicos_id',
    'editorial_id',
    'catalogacion_id',
    ];
    public function editorial()
    {
        return $this->belongsTo(editorial::class,'editorial_id');
    }
    public function Autor()
    {
        return $this->belongsToMany(autor::class, 'autor_libro', 'libro_id', 'autor_id');
    }
    public function Ensalas()
    {
        return $this->belongsToMany(enSala::class, 'en_sala')->withPivot(['estado', 'hora_entrada', 'hora_salida']);
    }

    public function estudiantes()
    {
        return $this->belongsToMany(estudiante::class, 'en_libro')->withPivot(['fecha_prestamo', 'fecha_devolucion']);
    }
    public function catalogacion()
    {
        return $this->belongsTo(catalogacion::class,'catalogacion_id');
    }
    public function topicos(){
        
        return $this->belongsTo(topicos::class, 'topicos_id');
    }
    public function generateCode()
    {
        $randomNumbers = mt_rand(1000, 9999);
        $code = substr($this->titulo_Principal, 0, 4) . $randomNumbers;
        return $code;
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($libro) {
            if (!$libro->codigoLibro) {
                $libro->codigoLibro = $libro->generateCode();
            }
        });
    }
}
