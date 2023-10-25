<?php

namespace App\Models\Catalogacion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro\libros;
class catalogacion extends Model
{
    use HasFactory;
    protected $table = 'catalogacion_biblioteca';

    protected $fillable = [
        'inventario',
        'codigoAutor',
        'codigoLibro',
        'ejemplar',
        'tomo',
        'volumen',
    ];

    public function libros()
    {
        return $this->hasMany(libros::class, 'catalogacion_id');
    }
}
