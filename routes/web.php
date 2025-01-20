<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', [DashboardController::class,"index"])->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/buscar_planos',[DashboardController::class,'buscar_planos'])->middleware(['auth', 'verified'])->name('buscar_planos');
Route::post('/dashboard/orcamento',[DashboardController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.montarOrcamento');
Route::post("/pdf",[DashboardController::class,'criarPDF'])->middleware(['auth', 'verified'])->name('gerar.imagem');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
