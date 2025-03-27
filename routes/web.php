<?php

use App\Http\Controllers\CallbackController;
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


Route::post('/callback', [CallbackController::class,'index']);
Route::get('/bem-vindo/{user}', [BemvindoController::class, 'index'])->name('bemvindo');

Route::post('/buscar_planos',[DashboardController::class,'buscar_planos'])->middleware(['auth', 'verified'])->name('buscar_planos');
Route::post('/dashboard/orcamento',[DashboardController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.montarOrcamento');
Route::post("/pdf",[DashboardController::class,'criarPDF'])->middleware(['auth', 'verified'])->name('gerar.imagem');

Route::get('/assinaturas/individual', [AssinaturaController::class, 'createIndividual'])->name('assinaturas.individual.create');
Route::post('/assinaturas/individual', [AssinaturaController::class, 'storeIndividual'])->name('assinaturas.individual.store');

Route::get('/assinaturas/empresarial', [AssinaturaController::class, 'createEmpresarial'])->name('assinaturas.empresarial.create');
Route::post('/assinaturas/empresarial', [AssinaturaController::class, 'storeEmpresarial'])->name('assinaturas.empresarial.store');

Route::get('/teste', [AssinaturaController::class, 'testNotification'])->name('teste');

//Route::get('/csrf-token', function () {
//    return response()->json(['token' => csrf_token()]);
//})->name('csrf-token');


Route::middleware(['auth','prevent-simultaneous-logins'])->group(function () {
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

    Route::get('/tabela_completa',[TabelaController::class,'index'])->name('tabela_completa.index');
    Route::get('/tabela',[TabelaController::class,'tabela_preco'])->name('tabela.config');
    Route::post('/corretora/select/planos/administradoras',[TabelaController::class,'planosAdministradoraSelect'])->name('planos.administradora.select');
    Route::post('/corretora/mudar/valor/tabela',[TabelaController::class,'mudarValorTabela'])->name('corretora.mudar.valor.tabela');
    Route::post("/tabela/verificar/valores",[TabelaController::class,'verificarValoresTabela'])->name("verificar.valores.tabela");
    Route::post("/tabela/cadastrar/valores",[TabelaController::class,'cadastrarValoresTabela'])->name("cadastrar.valores.tabela");
    Route::post("/coparticipacao/cadastrar/valores",[TabelaController::class,'cadastrarCoparticipacao'])->name("cadastrar.coparticipacao.tabela");
    Route::post("/coparticipacao/excecao/cadastrar/valores",[TabelaController::class,'cadastrarCoparticipacaoExcecao'])->name("cadastrar.excecao.coparticipacao.tabela");
    Route::post("/coparticipacao/existe/valores",[TabelaController::class,'coparticipacaoJaExiste'])->name("coparticipacao.ja.existe");
    Route::post('/users/editar/manager', [UserController::class, 'getUser'])->name('users.get');
    Route::post('/users/update', [UserController::class, 'update'])->name('users.update');
    Route::post('/users/deletar', [UserController::class, 'deletar'])->name('deletar.user');
    Route::post('/users/alterar',[UserController::class,'alterar'])->name('users.alterar');


});
Route::get('/configuracoes', function () {
    $assinatura_id = \App\Models\Assinatura::where("user_id",auth()->user()->id)->first()->id;

    $users = User::whereIn(
        'id',
        EmailAssinatura::where('assinatura_id', $assinatura_id)
            ->where('is_administrador', 0)
            ->pluck('user_id')
    )->get();





    //$users = \App\Models\User::all(); // Carrega os usuários para a tabela de gerenciamento

    $user = auth()->user();
    return view('configuracoes', compact('users','user'));
})->middleware('auth')->name('configuracoes');
Route::post('/dashboard/tabela/orcamento',[TabelaController::class,'orcamento'])->middleware(['auth', 'verified'])->name('orcamento.tabela.montarOrcamento');

require __DIR__.'/auth.php';
