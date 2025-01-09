<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\V1\CategoriasController;
use App\Http\Controllers\Api\V1\ProdutosController;

Route::group(['prefix' => 'categorias'], function () {
    Route::get('/', [CategoriasController::class, 'index'])->name('categorias.index');
    Route::get('/{id}', [CategoriasController::class, 'show'])->name('categorias.show');
    Route::post('/', [CategoriasController::class, 'store'])->name('categorias.store');
    Route::put('/{id}', [CategoriasController::class, 'update'])->name('categorias.update');
    Route::delete('/{id}', [CategoriasController::class, 'destroy'])->name('categorias.destroy');
});

Route::group(['prefix' => 'produtos'], function () {
    Route::get('/', [ProdutosController::class, 'index'])->name('produtos.index');
    Route::get('/{id}', [ProdutosController::class, 'show'])->name('produtos.show');
    Route::post('/', [ProdutosController::class, 'store'])->name('produtos.store');
    Route::put('/{id}', [ProdutosController::class, 'update'])->name('produtos.update');
    Route::delete('/{id}', [ProdutosController::class, 'destroy'])->name('produtos.destroy');
});
