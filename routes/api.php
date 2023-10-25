<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UsuarioApi\AuthController;
use App\Http\Controllers\LibroApi\LibroController;
use App\Http\Controllers\EditorialApi\editorialController;
use App\Http\Controllers\CatalogacionApi\catalogacionController;
use App\Http\Controllers\AutorApi\AutorController;
use App\Http\Controllers\Topico\topicoController;
use App\Http\Controllers\EstudianteApi\estudianteController;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/
// route::Post('register',[AuthController::class,'register'],);
route::get('usuarios',[AuthController::class,'allUser'],);
Route::delete('usuario/{id}',[AuthController::class,'eliminar']);
route::Post('login',[AuthController::class,'login'],);

Route::group(['middleware'=>['auth:sanctum']],function(){
    route::get('user-profile',[AuthController::class,'userProfile']);
    route::post('logout',[AuthController::class,'logout']);
});
// Route::prefix('api')->group(function () {
//     
// }); 
// route::Post('libros',[LibroController::class,'store'],);
route::get('lista',[libroController::class,'index'],);
Route::resource('libros', LibroController::class);
Route::resource('editorial',editorialController::class);
route::get('editorial/busqueda/{letra}',[editorialController::class,'busqueda']);
Route::resource('catalogacion',catalogacionController::class);
Route::resource('autor',AutorController::class);
// Route::group(['prefix' => 'autor'], function () {
//     Route::get('busqueda/{letra}', [AutorController::class, 'busqueda']);
// });
Route::get('autor/busqueda/{letra}', [AutorController::class, 'busqueda'],);
Route::resource('topico',topicoController::class);
route::resource('usuario',AuthController::class);
route::resource('estudiante',estudianteController::class);
Route::get('/asignar-codigos-libro',[LibroController::class,'asignar']);