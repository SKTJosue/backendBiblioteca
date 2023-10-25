<?php

namespace App\Http\Controllers\EditorialApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Libro\libros;
use App\Models\Editorial\editorial;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response;
class editorialController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $editorial = editorial::all();
        return Response()->json([
            'success' => true,
            'data' => $editorial
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
        
        $validator = Validator::make($request->all(),[
            'nombreEditorial'=> 'required', 
        ]);
        if ($validator->fails()) 
        {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $editorial = new editorial([
            'nombreEditorial'=> $request->input('nombreEditorial'),
        ]);
        $editorial->save();
        return response()->json(['message' => 'editorial creada'], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        try {
            $libro = Editorial::findOrFail($id);
            return response()->json($libro, 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'El editorial no fue encontrado'], 200);
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
        $this->validate($request, [
            'nombreEditorial' => 'required|string',
            // Agrega reglas de validación para los demás campos
        ]);
        try {
            $nombreEditorial = $request->input('nombreEditorial');
            // Verificar si se proporciona el campo nombreEditorial en la solicitud
            if ($nombreEditorial && Editorial::where('nombreEditorial', $nombreEditorial)->exists()) {
                $editorialExistente = Editorial::where('nombreEditorial', $nombreEditorial)->first();
                return response()->json([
                    'message' => 'No se puede modificar el campo nombreEditorial',
                    'id_editorial_existente' => $editorialExistente->id
                ], 400);
            }
            $editorial = Editorial::findOrFail($id);
            $editorial->fill($request->all());
            $editorial->save();
            return response()->json(['message' => 'Editorial actualizado correctamente'], 200);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Editorial no encontrado'], 404);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error al actualizar el editorial'], 500);
        }
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        try {
            $editorial = Editorial::findOrFail($id);
            $editorial->delete();
    
            return response()->json(['message' => 'Editorial eliminada correctamente'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'No se pudo eliminar la editorial'], 500);
        }
    }
}
