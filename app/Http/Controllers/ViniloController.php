<?php

namespace App\Http\Controllers;

use App\Models\Artista;
use App\Models\Vinilo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf; // <-- IMPORTANTE: Importar el Facade

class ViniloController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vinilos = \App\Models\Vinilo::withTrashed()->get();

        return view('vinilos.index', compact('vinilos'));
    }

    /**
     * Devuelve los datos JSON para DataTables.
     */
    public function cargarDT()
    {
        $vinilos = Vinilo::withTrashed()->get();

        return response()->json([
            'data'=> $vinilos
        ]);
    }
    /**
     * Genera un reporte en PDF de todos los vinilos.
     */
    public function generarPDF()
    {
        // Obtenemos los datos (puedes usar withTrashed() si quieres incluir los eliminados)
        $vinilos = Vinilo::all();

        // Cargamos la vista de la plantilla de PDF y le pasamos los datos
        $pdf = Pdf::loadView('vinilos.pdf', compact('vinilos'));

        // Retorna el PDF para descargarse o visualizarse en el navegador
        return $pdf->stream('reporte-vinilos.pdf');
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $artistas = Artista::all();

        return view('vinilos.create', compact('artistas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required',
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $nombreImagen = null;

        if ($request->hasFile('imagen')) {

            $nombreImagen = time() . '.' .
                $request->imagen->extension();

            $request->imagen->storeAs(
                'vinilos',
                $nombreImagen,
                'public'
            );
        }

        Vinilo::create([
            'titulo' => $request->titulo,
            'genero' => $request->genero,
            'anio_lanzamiento' => $request->anio_lanzamiento,
            'numero_canciones' => $request->numero_canciones,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'formato' => $request->formato,
            'discografia' => $request->discografia,
            'descripcion' => $request->descripcion,
            'imagen' => $nombreImagen,
            'estado' => true,
            'artista_id' => $request->artista_id
        ]);

        return redirect()->route('vinilos.index')
            ->with('success', 'Artista agregado correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Vinilo $vinilo)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $vinilo = Vinilo::findOrFail($id);
        $artistas = Artista::all();

        return view('vinilos.edit', compact('vinilo', 'artistas'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $vinilo = Vinilo::findOrFail($id);

        $request->validate([
            'titulo' => 'required|max:255',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $nombreImagen = $vinilo->imagen;

        if ($request->hasFile('imagen')) {

            // Eliminar imagen anterior
            if (
                $vinilo->imagen &&
                Storage::disk('public')->exists('vinilos/' . $vinilo->imagen)
            ) {
                Storage::disk('public')->delete('vinilos/' . $vinilo->imagen);
            }

            // Guardar nueva imagen
            $nombreImagen = time() . '.' .
                $request->file('imagen')->extension();

            $request->file('imagen')->storeAs(
                'vinilos',
                $nombreImagen,
                'public'
            );
        }

        $vinilo->update([
            'titulo' => $request->titulo,
            'genero' => $request->genero,
            'anio_lanzamiento' => $request->anio_lanzamiento,
            'numero_canciones' => $request->numero_canciones,
            'precio' => $request->precio,
            'stock' => $request->stock,
            'formato' => $request->formato,
            'discografia' => $request->discografia,
            'descripcion' => $request->descripcion,
            'imagen' => $nombreImagen,
            'estado' => $request->estado,
            'artista_id' => $request->artista_id
        ]);

        return redirect()
            ->route('vinilos.index')
            ->with('success', 'Vinilo actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $vinilo = Vinilo::findOrFail($id);

        $vinilo->delete();

        return redirect()
            ->route('vinilos.index')
            ->with('success', 'Vinilo eliminado');
    }
    public function restore($id)
    {
        Vinilo::withTrashed()
            ->findOrFail($id)
            ->restore();

        return redirect()
            ->route('vinilos.index')
            ->with('success', 'Vinilo restaurado correctamente');
    }
}
