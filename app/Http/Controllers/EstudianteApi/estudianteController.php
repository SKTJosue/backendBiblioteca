<?php

namespace App\Http\Controllers\EstudianteApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Estudiante\Estudiante;
use Illuminate\Support\Facades\Hash;
USE Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class estudianteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $estudiante = Estudiante::all();
        return Response()->json([
            'success'=>true,
            'data'=>$estudiante
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator= Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'numeroCelular' => 'required',
            'nombreTutor' => 'required',
            'apellidoTutor' => 'required',
            'numeroCelularTutor' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $estudiante = new Estudiante([
            'nombre' => $request->input('nombre'),
            'apellido' => $request->input('apellido'),
            'numeroCelular' => $request->input('numeroCelular'),
            'nombreTutor' => $request->input('nombreTutor'),
            'apellidoTutor' => $request->input('apellidoTutor'),
            'numeroCelularTutor' => $request->input('numeroCelularTutor')
        ]);
        $estudiante->save();
        return response()->json(['message' => 'Estudiante creado','estudiante'=>$estudiante], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $estudiante = Estudiante::findOrFail($id);
            // Aquí realizas las operaciones necesarias con el estudiante encontrado
            // Por ejemplo, puedes retornar una respuesta JSON con los detalles del estudiante
            return response()->json($estudiante,200);
        } catch (ModelNotFoundException $e) {
            // Si no se encuentra el estudiante, se lanza una excepción ModelNotFoundException
            // Puedes manejar el error de acuerdo a tus necesidades, por ejemplo, retornando una respuesta de error
            return response()->json(['error' => 'Estudiante no encontrado'], 404);
        } catch (\Exception $e) {
            // Cualquier otra excepción que ocurra será capturada aquí
            // Puedes manejar el error de acuerdo a tus necesidades, por ejemplo, retornando una respuesta de error genérica
            return response()->json(['error' => 'Ocurrió un error en el servidor'], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $validator= Validator::make($request->all(),[
            'nombre' => 'required',
            'apellido' => 'required',
            'numeroCelular' => 'required',
            'nombreTutor' => 'required',
            'apellidoTutor' => 'required',
            'numeroCelularTutor' => 'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        try {
            $nombre = $request->input('nombre');
            $apellido = $request->input('apellido');
            
            if ($nombre && $apellido && estudiante::where('nombre', $nombre)
                ->where('apellido', $apellido)
                ->exists()) {
                $estudianteExistente = estudiante::where('nombre', $nombre)
                    ->where('apellido', $apellido)
                    ->first();
                    
                return response()->json([
                    'message' => 'No se puede modificar el Estudiante',
                    'id_autor_existente' => $estudianteExistente->id
                ], 400);
            }
            
            $estudiante = Estudiante::findOrFail($id);
            $estudiante->fill($request->all());
            $estudiante->save();
            
            return response()->json(['message' => 'Estudiante actualizado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Estudiante no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el Estudiante'], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $estudiante = Estudiante::find($id);
        if(!$estudiante){
            return response()->json(['menssge'=>'estudiante no encontrado'],404);
        }
        $estudiante->delete();
        return response()->json(['message'=> 'Estudiante eliminado correctamente']);
    }
}
