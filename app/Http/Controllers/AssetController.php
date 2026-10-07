<?php

namespace App\Http\Controllers;

use App\Models\Asset;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\Response;

class AssetController extends Controller
{
    /**
     * Muestra el formulario de subida.
     */
    public function create()
    {
        return view('assets.create');
    }

    /**
     * Guarda el archivo en el Storage y en la Base de Datos.
     */
    public function store(Request $request)
    {
        $request->validate([
            'archivo' => 'required|file|mimes:jpg,jpeg,png,mp4,avi,mkv|max:50000', // max ~50MB
        ]);

        if ($request->hasFile('archivo')) {
            $file = $request->file('archivo');
            $nombreOriginal = $file->getClientOriginalName();
            $mime = $file->getMimeType();

            // Determinamos la carpeta destino según el tipo de archivo
            $carpeta = str_contains($mime, 'video') ? 'videos' : 'images';

            // Guardamos el archivo físicamente en storage/app/raw_assets/images o /videos
            $rutaFisica = $file->store("raw_assets/{$carpeta}");

            // Registramos en la Base de Datos
            $asset = Asset::create([
                'nombre_original' => $nombreOriginal,
                'ruta_almacenamiento' => $rutaFisica,
                'tipo_mime' => $mime
            ]);

            return redirect()->route('assets.show', $asset->id)
                ->with('success', 'Archivo subido correctamente al disco virtual.');
        }

        return back()->with('error', 'No se pudo subir el archivo.');
    }

    /**
     * Muestra la vista con el reproductor/visor del archivo.
     */
    public function show($id)
    {
        $asset = Asset::findOrFail($id);
        return view('assets.show', compact('asset'));
    }

    /**
     * Devuelve la imagen de forma binaria desde el Storage seguro.
     */
    public function getImage($id)
    {
        $asset = Asset::findOrFail($id);

        if (!Storage::exists($asset->ruta_almacenamiento)) {
            abort(404);
        }

        $archivo = Storage::get($asset->ruta_almacenamiento);

        return response($archivo, 200)->header('Content-Type', $asset->tipo_mime);
    }

    /**
     * Devuelve el video de forma binaria (Soporta Streaming parcial).
     */
    public function getVideo($id)
    {
        $asset = Asset::findOrFail($id);

        if (!Storage::exists($asset->ruta_almacenamiento)) {
            abort(404);
        }

        $path = Storage::path($asset->ruta_almacenamiento);
        $file = fopen($path, "rb");
        $size = Storage::size($asset->ruta_almacenamiento);

        // Retorno óptimo para reproductores de video HTML5
        return response()->stream(function () use ($file) {
            fpassthru($file);
        }, 200, [
            "Content-Type" => $asset->tipo_mime,
            "Content-Length" => $size,
            "Content-Disposition" => "inline; filename=\"" . $asset->nombre_original . "\""
        ]);
    }
}
