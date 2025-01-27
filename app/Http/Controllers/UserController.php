<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\EmailAssinatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function index()
    {
        return view("users.manage");
    }

    public function storeUser(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
        ]);

        DB::beginTransaction(); // Inicia uma transação

        try {
            // Passo 1: Cadastrar o usuário
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => '12345678', // Senha padrão
            ]);

            // Passo 2: Lógica de Assinaturas
            $assinatura = Assinatura::where('user_id', auth()->id())->firstOrFail();
            $emailCount = $assinatura->emailsAssinatura()->count();

            if ($emailCount >= 5) {
                $emailsExtra = $emailCount - 4;
                $assinatura->update([
                    'preco_total' => $assinatura->preco_total + 30,
                    'emails_extra' => $emailsExtra,
                ]);
            }

            // Passo 3: Atualizar a tabela `emails_assinatura`
            EmailAssinatura::create([
                'assinatura_id' => $assinatura->id,
                'email' => $validated['email'],
                'user_id' => $user->id,
                'is_administrador' => false,
            ]);

            DB::commit(); // Confirma as transações

            // Recuperar todos os usuários da assinatura do usuário logado
            $users = $assinatura
                ->emailsAssinatura
                ->where('is_administrador', false)
                ->map(function ($emailAssinatura) {
                return [
                    'name' => $emailAssinatura->user->name ?? 'N/A',
                    'email' => $emailAssinatura->user->email ?? 'N/A',
                    'phone' => $emailAssinatura->user->phone ?? 'N/A',
                ];
            }); // Relacionamento deve estar correto

            // Retornar o HTML da tabela de usuários
            $html = view('partials.user-table', compact('users'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte em caso de erro
            return $e->getMessage();
            //return response()->json(['success' => false], 500);
        }
    }
}
