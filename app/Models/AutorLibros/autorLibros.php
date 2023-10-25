<?php

namespace App\Models\AutorLibros;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Autor\autor;
use App\Models\Libro\libros;
class autorLibros extends Model
{
    use HasFactory;
    protected $table='autor_libro';
    public function autor(){
        return $this->belongsTo(autor::class);
    }
    public function libro(){
        return($this->belongsTo(libros::class));
    }
}
