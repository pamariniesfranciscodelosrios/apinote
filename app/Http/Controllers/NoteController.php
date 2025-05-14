<?php

namespace App\Http\Controllers;


use App\Models\Note;
use App\Http\Requests\NoteRequest;
use App\Http\Resources\NoteResource;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;

class NoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): JsonResource
    {
        ///recuperamos todos los elementos
        //$notes = Note::all();
        //ahora ya no devolvemos una vista (retun view) si no que directamente enviamos esos datos mediante un formato de API RESTFUL con JSON
        //return response()->json($notes, 200 );
        /*  JSON Le devolvemos:
                //datos
                //mensaje de estado, 200 = todo OK
                //valor de cabecera (opcional)
          */
        return NoteResource::collection(Note::all());
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(NoteRequest $request): JsonResponse
    {
        $note   = Note::create($request->all());
        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ], 201); // El estado 201 corresponde a la creación correcta de u nuevo elemento
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id): JsonResource
    {
        //Busca un elemento con su ID y lo devuelve
        $note = Note::find($id);
        return new NoteResource($note);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(NoteRequest $request, string $id)
    {
        $note = Note::find($id);
        $note->title = $request->title;
        $note->content = $request->content;
        $note->save(); // Si lo hacemos así, necesitamos guardar

        return new NoteResource($note, 204);
        /*
        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ],204);
        */
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id): JsonResponse
    {
        //Buscamos el elemento a borrar
        $note = Note::find($id);
        $note->delete();
        return response()->json([
            'success' => true,
            'data' => new NoteResource($note)
        ], 205); // El estado 205 corresponde a la eliminación correcta de u nuevo elemento
    }
}
