<?php

namespace App\Http\Controllers\AutorApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Autor\autor;
use Illuminate\Support\Facades\Hash;
USE Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class AutorController extends Controller
{
    public function index(){
        $autor= autor::all();
        return Response()->json([
            'success' => true,
            'data' => $autor
        ]);
    }
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'nombreAutor'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $autor = new autor ([
            'nombreAutor'=> $request->input('nombreAutor')
        ]);
        $autor->save();
        return response()->json(['message' => 'autor creado','autor'=>$autor], 201);
    }
    public function show(string $id){
        $autor= autor::findOrFail($id);
        return response()->json($autor, 200);
    }
    public function update(Request $request, string $id)
    {
        $this->validate($request, [
            'nombreAutor' => 'required|string',
            // Agrega reglas de validación para los demás campos
        ]);
        try{
            $nombreAutor = $request->input('nombreAutor');
            if ($nombreAutor && autor::where('nombreAutor', $nombreAutor)->exists()) {
                $autorExistente = autor::where('nombreAutor', $nombreAutor)->first();
                return response()->json([
                    'message' => 'No se puede modificar el campo nombreEditorial',
                    'id_editorial_existente' => $autorExistente->id
                ], 400);
            }
            $autor = autor::findOrFail($id);
            $autor-> fill( $request->all());
            $autor->save();
            return response()->json(['message' => 'Autor actualizado correctamente'], 200);
        } catch(ModelNotFoundException $e){
            return response()->json(['message' => 'Autor no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el Autor'], 500);
        }
        
        
    // Verificar si se proporciona el campo nombreEditorial en la solicitud
        
        $autor = autor::findOrFail($id);
        // Actualizar los demás campos del editorial si se proporcionan en la solicitud
        $autor->fill($request->except('nombreAutor'));
        $autor->save();
        return response()->json(['message' => 'Autor actualizado correctamente','autor'=>$autor], 200);
    }
    public function destroy(string $id)
    {
        $autor = autor::find($id);
        if(!$autor){
            return response()->json(['menssge'=>'editorial no encontrado'],404);
        }
        $autor->delete();
        return response()->json(['message'=> 'Autor eliminado correctamente']);
    }
    public function busqueda(string $letra){
        // $letra = $request->input('q');
        $autor = Autor::firstOrCreate(['nombreAutor' => $letra]);
        return response()->json(['id'=>$autor->id]);
    }
}
