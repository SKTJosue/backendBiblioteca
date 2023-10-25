<?php

namespace App\Http\Controllers\LibroApi;
use App\Models\Libro\libros;
use App\Models\Editorial\editorial;
use App\Models\Autor\autor;
use App\Models\Catalogacion\catalogacion;
use Illuminate\Support\Facades\Http;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
USE Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Facades\Storage;
use Exception;
class LibroController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $libros = libros::with(['editorial', 'Autor', 'topicos', 'catalogacion'])->get();
        return response()->json([
            'success' => true,
            'data' => $libros
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function asignar(){
        
        $librosSinCodigo = libros::whereNull('codigoLibro')
        ->orWhere('codigoLibro','')
        ->get();

        foreach ($librosSinCodigo as $libro) {
            $libro->codigoLibro = $libro->generateCode();
            $libro->save();
        }
        return Response()->json(['se actulizo correctamente']);
    }
    public function create()
    {
        //
    }

    public function obtener_imagen_portada($isbn)
    {
        $urlBase = "https://www.googleapis.com/books/v1/volumes";
        $parametros = ["q" => "isbn:" . $isbn];
        try {
            $response = Http::get($urlBase, $parametros);
            $datos = $response->json();

            if (isset($datos['items']) && count($datos['items']) > 0) {
                $item = $datos['items'][0];
                $infoLibro = $item['volumeInfo'];

            if (isset($infoLibro['imageLinks']) && isset($infoLibro['imageLinks']['thumbnail'])) {
                return $infoLibro['imageLinks']['thumbnail'];
            }
        } else {
            return null;
        }
    } catch (Exception $e) {
        return null;
    }
}
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
{
    $validator = Validator::make($request->all(), [
        'titulo_Principal' => 'required',
        'titulo_secundario' => 'required',
        'idioma_libro' => 'required',
        'pais' => 'required',
        'ciudad' => 'required',
        'codigo_isbn' => 'required',
        'anio_publicacion' => 'required',
        'numero_edicion' => 'required',
        'numero_paginas' => 'required',
        'topologia_libro' => 'required',
        'contiene' => 'required',
        'incluye' => 'required',
        'tipo_adquisicion' => 'required',
        'indice' => 'required',
        'editorial_id' => 'required|exists:editorial,id',
        'catalogacion_id' => 'required|exists:catalogacion_biblioteca,id',
        'topicos_id' => 'required|exists:topicos,id',
        'imagen' => 'nullable|image|mimes:jpeg,png,jpg',
    ]);

    if ($validator->fails()) {
        return response()->json(['errors' => $validator->errors()], 400);
    }
    $codigoISBN = $request->input('codigo_isbn');
    $urlImagenPortada = $this->obtener_imagen_portada($codigoISBN);

    $libro = new libros([
        'titulo_Principal' => $request->input('titulo_Principal'),
        'titulo_secundario' => $request->input('titulo_secundario'),
        'idioma_libro' => $request->input('idioma_libro'),
        'pais' => $request->input('pais'),
        'ciudad' => $request->input('ciudad'),
        'codigo_isbn' => $request->input('codigo_isbn'),
        'anio_publicacion' => $request->input('anio_publicacion'),
        'numero_edicion' => $request->input('numero_edicion'),
        'numero_paginas' => $request->input('numero_paginas'),
        'topologia_libro' => $request->input('topologia_libro'),
        'contiene' => $request->input('contiene'),
        'incluye' => $request->input('incluye'),
        'tipoAdquisicion' => $request->input('tipo_adquisicion'),
        'indice' => $request->input('indice'),
        'editorial_id' => $request->input('editorial_id'),
        'catalogacion_id' => $request->input('catalogacion_id'),
        'topicos_id' => $request->input('topicos_id'),
    ]);
    $codigoISBN = $request->input('codigo_isbn');
    $urlImagenPortada = $this->obtener_imagen_portada($codigoISBN);
    if ($urlImagenPortada) {
        // Descargar la imagen y guardarla localmente
        $nombreArchivo = time() . '.jpg';
        $rutaImagen = 'imagenes/' . $nombreArchivo;
        file_put_contents(public_path($rutaImagen), file_get_contents($urlImagenPortada));
        $libro->imagen = $rutaImagen;
    }
    $libro->save();
    return response()->json(['message' => 'Libro creado correctamente','id'=>$libro->id], 201);
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $libro = libros::findOrFail($id);
        return response()->json($libro, 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $libro = libros::findOrFail($id);
        if (!$libro) {
            return response()->json(['message' => 'Libro no encontrado'], 404);
        }      
        // $libro->titulo_Principal = $request->input('titulo_Principal');
        // $libro->titulo_secundario = $request->input('titulo_secundario');
        // $libro->idioma_libro = $request->input('idioma_libro');
        // $libro->pais = $request->input('pais');
        // $libro->ciudad = $request->input('ciudad');
        // $libro->codigo_isbn = $request->input('codigo_isbn');
        // $libro->anio_publicacion = $request->input('anio_publicacion');
        // $libro->numero_edicion = $request->input('numero_edicion');
        // $libro->numero_paginas = $request->input('numero_paginas');
        // $libro->topologia_libro = $request->input('topologia_libro');
        // $libro->contiene = $request->input('contiene');
        // $libro->incluye = $request->input('incluye');
        // $libro->tipoAdquisicion = $request->input('tipo_adquisicion');
        // $libro->indice = $request->input('indice');
        // $libro->editorial_id = $request->input('editorial_id');
        // $libro->catalogacion_id = $request->input('catalogacion_id');
        $libro->fill($request->all());
        $codigoISBN = $request->input('codigo_isbn');
        $urlImagenPortada = $this->obtener_imagen_portada($codigoISBN);
        if ($urlImagenPortada) {
            // Descargar la imagen y guardarla localmente
            $nombreArchivo = time() . '.jpg';
            $rutaImagen = 'imagenes/' . $nombreArchivo;
            file_put_contents(public_path($rutaImagen), file_get_contents($urlImagenPortada));
            $libro->imagen = $rutaImagen;
        }
        $libro->save();
        return response()->json(['mensaje' => 'El libro ha sido actualizado correctamente']);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $libro = libros::find($id);
        if (!$libro) {
            return response()->json(['message' => 'Libro no encontrado'], 404);
        }
        // Eliminar la imagen si existe
        if ($libro->imagen && Storage::disk('public')->exists('imagenes/' . $libro->imagen)) {
            Storage::disk('public')->delete('imagenes/' . $libro->imagen);
        }
        $libro->delete();
        return response()->json(['message' => 'Libro eliminado correctamente']);
    }
    }
