<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendSuggestionEmail;

Route::post('/send-suggestion', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email',
        'subject' => 'required|string|max:255',
        'message' => 'required|string|max:5000',
    ]);

    // Dados do e-mail
    $data = $request->only('name', 'email', 'subject', 'message');
    $data['message'] = e($data['message']);  // Escapa os caracteres HTML


    // Despachando o Job para a fila
    SendSuggestionEmail::dispatch($data);

    return response()->json(['success' => true, 'message' => 'Mensagem enviada com sucesso!']);
})->name('send.suggestion');

Route::get('/', function () {
    return view('welcome');
});


Route::post('/buscar_planos',[DashboardController::class,'buscar_planos'])->middleware(['auth', 'verified'])->name('buscar_planos');
Route::post('/dashboard/orcamento',[DashboardController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.montarOrcamento');
Route::post("/pdf",[DashboardController::class,'criarPDF'])->middleware(['auth', 'verified'])->name('gerar.imagem');

Route::get('/assinaturas/individual', [AssinaturaController::class, 'createIndividual'])->name('assinaturas.individual.create');
Route::post('/assinaturas/individual', [AssinaturaController::class, 'storeIndividual'])->name('assinaturas.individual.store');

Route::get('/assinaturas/empresarial', [AssinaturaController::class, 'createEmpresarial'])->name('assinaturas.empresarial.create');
Route::post('/assinaturas/empresarial', [AssinaturaController::class, 'storeEmpresarial'])->name('assinaturas.empresarial.store');

Route::get('/teste', [AssinaturaController::class, 'testNotification'])->name('teste');


Route::middleware(['auth','prevent-simultaneous-logins'])->group(callback: function () {
    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::get('/users/manage', [UserController::class, 'index'])->name('users.manage');
    Route::post('/users/manage', [UserController::class, 'storeUser'])->name('storeUser');
    Route::get('/dashboard', [DashboardController::class,"index"])
        ->middleware(['verified'])
        ->name('dashboard');
    Route::get('/layout', [LayoutController::class, 'index'])->name('layouts.index');
    Route::post('/layouts/select', [LayoutController::class, 'select'])->name('layouts.select');
});


require __DIR__.'/auth.php';
