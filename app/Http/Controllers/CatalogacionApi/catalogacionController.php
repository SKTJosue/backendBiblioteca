<?php

namespace App\Http\Controllers\CatalogacionApi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Catalogacion\catalogacion;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class catalogacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $catalogacion = catalogacion::all();
        return response()->json([
            'success'=> true,
            'data'=> $catalogacion
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
            'inventario'=>'required',
            'codigoAutor'=>'required',
            'codigoLibro'=>'required',
            'ejemplar'=>'required',
            'tomo'=>'required',
            'volumen'=>'required',
        ]);
        if($validator->fails()){
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $catalogacion = new catalogacion([
            'inventario'=>$request->input('inventario'),
            'codigoAutor'=>$request->input('codigoAutor'),
            'codigoLibro'=>$request->input('codigoLibro'),
            'ejemplar'=>$request->input('ejemplar'),
            'tomo'=>$request->input('tomo'),
            'volumen'=>$request->input('volumen'),
        ]);
        $catalogacion->save();
        return response()->json(['message' => 'catalogacion creado','id'=>$catalogacion->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $catalogacion= catalogacion::findOrFail($id);
        return response()->json($catalogacion, 200);
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
        $catalogacion= catalogacion::findOrFail($id);
        $catalogacion->inventario = $request->inventario;
        $catalogacion->codigoAutor=$request->codigoAutor;
        $catalogacion->codigoLibro=$request->codigoLibro;
        $catalogacion->ejemplar=$request->ejemplar;
        $catalogacion->tomo=$request->tomo;
        $catalogacion->volumen=$request->volumen;
        $catalogacion->save();
        return response()->json(['mensaje' => 'El catalogacion ha sido actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $catalogacion = catalogacion::find($id);
        if (!$catalogacion) {
            return response()->json(['message' => 'catalogacion no encontrado'], 404);
        }
        $catalogacion->delete();
        return response()->json(['message' => 'catalogacion eliminado correctamente']);
    }
}
