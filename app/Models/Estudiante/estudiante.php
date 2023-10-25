<?php

namespace App\Models\Estudiante;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro\libros;
use App\Models\EnSala\enSalan;
class estudiante extends Model
{
    use HasFactory;
    protected $table='estudiantes';
    protected $fillable = ['nombre', 'apellido', 'numeroCelular', 'nombreTutor','apellidoTutor', 'numeroCelularTutor'];

    public function libros()
    {
        return $this->belongsToMany(libros::class, 'en_sala')->withPivot(['estado', 'hora_entrada', 'hora_salida']);
    }

    public function salas()
    {
        return $this->belongsToMany(enSala::class, 'en_sala')->withPivot(['estado', 'hora_entrada', 'hora_salida']);
    }
}
