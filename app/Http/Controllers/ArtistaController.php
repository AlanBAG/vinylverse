<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf; // <-- IMPORTANTE: Importar el Facade

class ArtistaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $artistas = Artista::withTrashed()->get();

        return view('artistas.index', compact('artistas'));
    }
    /**
     * Devuelve los datos JSON para DataTables.
     */
    public function cargarDT()
    {
        // Traemos todos los artistas, incluidos los borrados por SoftDeletes
        $artistas = Artista::withTrashed()->get();

        return response()->json([
            'data' => $artistas
        ]);
    }

    public function generarPDF()
    {
        $artistas = Artista::all();

        $pdf = Pdf::loadView('artistas.pdf', compact('artistas'));

        return $pdf->stream('reporte-artistas.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('artistas.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

        Artista::create([
            'nombre' => $request->nombre,
            'pais' => $request->pais,
            'genero' => $request->genero,
            'biografia' => $request->biografia,
            'estado' => true
        ]);

        return redirect()->route('artistas.index')
        ->with('success', 'Artista registrado correctamente');

    }

    /**
     * Display the specified resource.
     */
    public function show(Artista $artista)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Artista $artista)
    {
        return view('artistas.edit', compact('artista'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Artista $artista)
    {
        $artista->update([
            'nombre' => $request->nombre,
            'pais' => $request->pais,
            'genero' => $request->genero,
            'biografia' => $request->biografia
        ]);

        return redirect()
            ->route('artistas.index')
            ->with('success', 'Artista actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $artista = Artista::findOrFail($id);

        $artista->delete();

        return redirect()
            ->route('artistas.index')
            ->with('success', 'Artista eliminado');
    }
    public function restore($id)
    {
        Artista::withTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('artistas.index');
    }
}
