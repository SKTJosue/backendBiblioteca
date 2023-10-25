<?php

namespace App\Models\Autor;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro\libros;
class autor extends Model
{
    use HasFactory;
    protected $table='autor';
    protected $fillable=[
        'nombreAutor',
    ];
    public function libros(){
        return $this->belongsToMany(libros::class,'autor_libro','autor_id','libro_id');
    }
}
