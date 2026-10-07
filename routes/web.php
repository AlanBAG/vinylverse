<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Auth\RegisteredUserController;
use App\Http\Controllers\Auth\PasswordResetLinkController;
use App\Http\Controllers\ArtistaController;
use App\Http\Controllers\ViniloController;
use App\Http\Controllers\AssetController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 1. Primero las rutas personalizadas con URLs fijas
Route::get('/artistas/cargarDT', [ArtistaController::class, 'cargarDT'])->name('artistas.cargarDT');
// Ruta para PDF de Artistas
Route::get('/artistas/pdf', [ArtistaController::class, 'generarPDF'])->name('artistas.pdf');

// 2. Después el recurso (resource)
Route::resource('artistas', ArtistaController::class);

// 3. Al final las rutas que usan parámetros variables como {id}
Route::put('/artistas/{id}/restore', [ArtistaController::class, 'restore'])->name('artistas.restore');

// 1. Primero las rutas personalizadas con URLs fijas
Route::get('/vinilos/cargarDT', [ViniloController::class, 'cargarDT'])->name('vinilos.cargarDT');
// Ruta para PDF de Artistas
Route::get('/vinilos/pdf', [ViniloController::class, 'generarPDF'])->name('vinilos.pdf');

// 2. Después el recurso (resource)
Route::resource('vinilos', ViniloController::class);

// 3. Al final las rutas que usan parámetros variables como {id}
Route::put('/vinilos/{id}/restore', [ViniloController::class, 'restore'])->name('vinilos.restore');

// Rutas de gestión del Disco Virtual Assets
Route::get('/assets/create', [AssetController::class, 'create'])->name('assets.create');
Route::post('/assets', [AssetController::class, 'store'])->name('assets.store');
Route::get('/assets/{id}', [AssetController::class, 'show'])->name('assets.show');

// Rutas de extracción segura de archivos binarios (las que llaman las etiquetas img y video)
Route::get('/assets/image/{id}', [AssetController::class, 'getImage'])->name('assets.getImage');
Route::get('/assets/video/{id}', [AssetController::class, 'getVideo'])->name('assets.getVideo');
require __DIR__.'/auth.php';

// Opción directa: Devuelve la vista del carrusel de inmediato
Route::get('/home', function () {
    return view('home');
})->name('home');

Route::get('/', function () {
    return view('home');
});

Route::get('/logout', function (Request $request) {
    Auth::logout(); // Cierra la sesión del usuario en Laravel

    $request->session()->invalidate(); // Invalida la sesión actual
    $request->session()->regenerateToken(); // Regenera el token CSRF por seguridad

    return redirect('/login'); // Redirecciona al login
})->name('logout.get');

// --- RUTAS PARA REGISTRO (Utilizando tus controladores de Breeze) ---
Route::get('/register', [RegisteredUserController::class, 'create'])->name('register');
Route::post('/register', [RegisteredUserController::class, 'store']);

// --- RUTAS PARA RECUPERAR CONTRASEÑA ---
Route::get('/password/reset', [PasswordResetLinkController::class, 'create'])->name('password.request');
Route::post('/password/email', [PasswordResetLinkController::class, 'store'])->name('password.email');
