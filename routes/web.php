<?php

use App\Http\Controllers\CallbackController;
use App\Http\Controllers\ConfiguracoesController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\LayoutController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AssinaturaController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\TabelaController;
use App\Models\EmailAssinatura;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use App\Jobs\SendSuggestionEmail;
use App\Http\Controllers\BemvindoController;

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

Route::get('/teste-charge', function() {
    $event = [
        "type" => "subscription_charge",
        "status" => ["current" => "paid"],
        "identifiers" => [
            "subscription_id" => 95856,
            "charge_id" => 44525608
        ],
        "value" => 2990, // em centavos
        "received_by_bank_at" => "2025-03-28 12:00:00",
        "created_at" => "2025-03-28 10:32:32"
    ];

    $controller = new \App\Http\Controllers\CallbackController();
    $controller->processCharge($event);

    dd(\App\Models\SubscriptionCharge::all());
});



Route::post('/callback', [CallbackController::class,'index']);
Route::get('/bem-vindo/{user}', [BemvindoController::class, 'index'])->name('bemvindo');

Route::post('/buscar_planos',[DashboardController::class,'buscar_planos'])->middleware(['auth', 'verified'])->name('buscar_planos');
Route::post('/dashboard/orcamento',[DashboardController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.montarOrcamento');
Route::post("/pdf",[DashboardController::class,'criarPDF'])->middleware(['auth', 'verified'])->name('gerar.imagem');

Route::get('/assinaturas/individual', [AssinaturaController::class, 'createIndividual'])->name('assinaturas.individual.create');
Route::post('/assinaturas/individual', [AssinaturaController::class, 'storeIndividual'])->name('assinaturas.individual.store');

Route::get('/assinatura/historico', [AssinaturaController::class, 'historicoPagamentos'])->middleware(['auth', 'verified'])->name('assinatura.historico');

Route::get('/assinaturas/empresarial', [AssinaturaController::class, 'createEmpresarial'])->name('assinaturas.empresarial.create');
Route::post('/assinaturas/empresarial', [AssinaturaController::class, 'storeEmpresarial'])->name('assinaturas.empresarial.store');

Route::get('/teste', [AssinaturaController::class, 'testNotification'])->name('teste');

//Route::get('/csrf-token', function () {
//    return response()->json(['token' => csrf_token()]);
//})->name('csrf-token');


Route::middleware(['auth','prevent-simultaneous-logins'])->group(function () {

    /********* Configurações **************/
    Route::middleware(['apenasDesenvolvedores'])->group(function () {
        Route::get("/configuracoes", [ConfiguracoesController::class, 'index'])->name('configuracoes.index');

        Route::post('/configuracoes/cidades/', [ConfiguracoesController::class, 'cidadeStore'])->name('cidades.store');
        Route::delete('/configuracoes/cidades/{id}', [ConfiguracoesController::class, 'cidadeDestroy'])->name('cidades.destroy');

        Route::post('/administradoras/store', [ConfiguracoesController::class, 'storeAdministradora'])->name('administradoras.store');
        Route::delete('/administradoras/{administradora}', [ConfiguracoesController::class, 'administradoraDestroy'])->name('administradoras.destroy');

        Route::post('/planos', [ConfiguracoesController::class, 'storePlanos'])->name('planos.store');
        Route::delete('/planos/{plano}', [ConfiguracoesController::class, 'planosDestroy'])->name('planos.destroy');

        Route::get('/assinaturas-cidades/{assinatura}/cidades', [ConfiguracoesController::class, 'getCidades'])->name('assinaturas.cidades');
        Route::post('/assinaturas-cidades/vincular', [ConfiguracoesController::class, 'vincular'])->name('assinaturas.vincular');
        Route::post('/assinaturas-cidades/desvincular', [ConfiguracoesController::class, 'desvincular'])->name('assinaturas.desvincular');


        Route::post('/store/pdf', [ConfiguracoesController::class, 'storePdf'])->name('pdf.store');
        Route::delete('/pdf/{pdf}', [ConfiguracoesController::class, 'destroyPdf'])->name('pdf.destroy');

        Route::get('/pdf/{pdf}/edit', [ConfiguracoesController::class, 'editPdf'])->name('pdf.edit');
        Route::put('/pdf/{pdf}', [ConfiguracoesController::class, 'updatePdf'])->name('pdf.update');

        Route::post('/verificar/tabela', [ConfiguracoesController::class, 'verificar'])->name('tabelas.verificar');
        Route::post('/tabelas/salvar', [ConfiguracoesController::class, 'salvarTabela'])->name('tabelas.salvar');
        Route::post('/mudar/valor/tabela', [ConfiguracoesController::class, 'mudarTabela'])->name('corretora.mudar.valor.tabela');

        Route::post('/desconto', [ConfiguracoesController::class, 'storeDesconto'])->name('descontos.store');
        Route::delete('/desconto/{desconto}', [ConfiguracoesController::class, 'destroyDesconto'])->name('descontos.destroy');

        Route::get('/plano/administradoras/cidades', [ConfiguracoesController::class, 'index'])->name('admin-planos.index');
        Route::post('/plano/administradoras/cidades', [ConfiguracoesController::class, 'store'])->name('admin-planos.store');
        Route::delete('/plano/administradoras/cidades/{id}', [ConfiguracoesController::class, 'destroy'])->name('admin-planos.destroy');


    });
    /********* Fim Configurações **************/

    Route::get('/users/manage', [UserController::class, 'index'])->name('users.manage')->middleware('apenasAdministradores');
    Route::post('/users/manage', [UserController::class, 'storeUser'])->name('storeUser')->middleware('apenasAdministradores');


    Route::get('/perfil', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/dashboard', [DashboardController::class,"index"])
        ->middleware(['verified'])
        ->name('dashboard');
    Route::get('/layout', [LayoutController::class, 'index'])->name('layouts.index');
    Route::post('/layouts/select', [LayoutController::class, 'select'])->name('layouts.select');

    Route::get('/tabela_completa',[TabelaController::class,'index'])->name('tabela_completa.index');
    Route::get('/tabela',[TabelaController::class,'tabela_preco'])->name('tabela.config');
    Route::post('/corretora/select/planos/administradoras',[TabelaController::class,'planosAdministradoraSelect'])->name('planos.administradora.select');
    //Route::post('/corretora/mudar/valor/tabela',[TabelaController::class,'mudarValorTabela'])->name('corretora.mudar.valor.tabela');

    Route::post('/users/editar/manager', [UserController::class, 'getUser'])->name('users.get');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/deletar', [UserController::class, 'deletar'])->name('deletar.user');
    Route::post('/users/alterar',[UserController::class,'alterar'])->name('users.alterar');


});
//Route::get('/configuracoes', function () {
//    $assinatura_id = \App\Models\Assinatura::where("user_id",auth()->user()->id)->first()->id;
//
//    $users = User::whereIn(
//        'id',
//        EmailAssinatura::where('assinatura_id', $assinatura_id)
//            ->where('is_administrador', 0)
//            ->pluck('user_id')
//    )->get();
//
//
//
//
//
//    //$users = \App\Models\User::all(); // Carrega os usuários para a tabela de gerenciamento
//
//    $user = auth()->user();
//    return view('configuracoes', compact('users','user'));
//})->middleware('auth')->name('configuracoes');
Route::post('/dashboard/tabela/orcamento',[TabelaController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.tabela.montarOrcamento');

require __DIR__.'/auth.php';
