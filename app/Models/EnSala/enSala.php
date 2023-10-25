<?php

namespace App\Models\EnSala;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Estudiante\estudiante;
use App\Models\Libro\libros;
class enSala extends Model
{
    use HasFactory;
    protected $table='en_sala';
    protected $fillable=['estudiante_id','libro_id', 'estado', 'hora_entrada', 'hora_salida'];
    public function estudiante()
    {
        return $this->belongsTo(estudiante::class);
    }

    public function libro()
    {
        return $this->belongsTo(libros::class);
    }
}
