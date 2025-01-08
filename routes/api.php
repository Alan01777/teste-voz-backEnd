<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoriasController;
use App\Http\Controllers\Api\V1\ProdutosController;


Route::group(['prefix' => 'categorias'], function () {
    Route::get('/', [CategoriasController::class, 'index']);
    Route::get('/{id}', [CategoriasController::class, 'show']);
    Route::post('/', [CategoriasController::class, 'store']);
    Route::put('/{id}', [CategoriasController::class, 'update']);
    Route::delete('/{id}', [CategoriasController::class, 'destroy']);
});

Route::group(['prefix' => 'produtos'], function () {
   Route::get('/', [ProdutosController::class, 'index']);
    Route::get('/{id}', [ProdutosController::class, 'show']);
    Route::post('/', [ProdutosController::class, 'store']);
    Route::put('/{id}', [ProdutosController::class, 'update']);
    Route::delete('/{id}', [ProdutosController::class, 'destroy']);
});
