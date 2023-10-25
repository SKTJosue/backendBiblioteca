<?php

namespace App\Models\Editorial;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Libro\libros;
class editorial extends Model
{
    use HasFactory;
    protected $table = 'editorial';
    protected $fillable =[
        'nombreEditorial',
    ];
    public function libros(){
        return $this->hasMany(libros::class);
    }
}
