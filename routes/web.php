<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CardapioController;

use App\Http\Controllers\TesteController;

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cardapio', [CardapioController::class, 'index'])->name('cardapio.index');
Route::post('/pedidos', [CardapioController::class, 'store'])->name('pedidos.store');

Route::get('/teste', [TesteController::class, 'index']);