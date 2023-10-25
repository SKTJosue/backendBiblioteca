<?php

namespace App\Http\Controllers\Topico;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Topicos\topicos;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
class topicoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $topico= topicos::all();
        return Response()->json([
            'success' => true,
            'data' => $topico
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
        $validator = Validator::make($request->all(), [
            'materia'=>'required',
            'topicoBusqueda'=>'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 400);
        }
        $topico = new topicos([
            'materia'=>$request->input('materia'),
            'topicoBusqueda'=>$request->input('topicoBusqueda'),
        ]);
        $topico->save();
        return response()->json(['message' => 'topico creado correctamente','id'=>$topico->id], 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $topico = topicos::findOrFail($id);
        return response()->json($topico, 200);
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
        // $validator = Validator::make($request->all(), [
        //     'materia'=>'required',
        //     'topicoBusqueda'=>'required',
        // ]);
        // if ($validator->fails()) {
        //     return response()->json(['errors' => $validator->errors()], 400);
        // }
        $topico = topicos::findOrFail($id);
        $topico->fill($request->all());
        $topico->save();

        return response()->json(['mensaje' => 'El tópico ha sido actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $topico = topicos::find($id);
        if (!$topico) {
            return response()->json(['message' => 'topico no encontrado'], 404);
        }
    }
}
