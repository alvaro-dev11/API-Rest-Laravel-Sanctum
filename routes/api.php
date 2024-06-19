<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// 8. Crear ruta para llamar a la funcion register de AuthController
Route::post('register', [AuthController::class, 'register']);

// 10. Crear ruta para llamar a la funcion login de AuthController
Route::post('login', [AuthController::class, 'login']);

// 13. Crear un middleware de autenticacion con auth:sanctum para poder usar las rutas que no son públicas
Route::middleware(['auth:sanctum'])->group(function () {
    // 12. Crear ruta para llamar a la funcion logout de AuthController
    Route::get('logout', [AuthController::class, 'logout']);

    // 4. Crear ruta para products
    Route::get('products', [ProductController::class, 'index']);
});
