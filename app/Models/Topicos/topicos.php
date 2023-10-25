<?php

namespace App\Models\Topicos;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro\libros;
class topicos extends Model
{
    use HasFactory;
    protected $table='topicos';
    protected $fillable=['materia',
'topicoBusqueda'];

}
