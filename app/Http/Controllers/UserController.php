<?php

namespace App\Http\Controllers;

use App\Models\Assinatura;
use App\Models\EmailAssinatura;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $assinatura_id = Assinatura::where("user_id",auth()->user()->id)->first()->id;

        $users = User::whereIn(
            'id',
            EmailAssinatura::where('assinatura_id', $assinatura_id)
                ->where('is_administrador', 0)
                ->pluck('user_id')
        )->get();

        return view('users.manage', compact('users'));
    }

    public function storeUser(Request $request)
    {
        // Validação dos dados
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        DB::beginTransaction(); // Inicia uma transação

        try {
            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('users', 'public');
            }
            // Passo 1: Cadastrar o usuário
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'password' => '12345678', // Senha padrão
                'imagem' => $imagePath,
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
            $assinatura_id = Assinatura::where("user_id",auth()->user()->id)->first()->id;

            $users = User::whereIn(
                'id',
                EmailAssinatura::where('assinatura_id', $assinatura_id)
                    ->where('is_administrador', 0)
                    ->pluck('user_id')
            )->get();

            // Retornar o HTML da tabela de usuários
            $html = view('partials.user-table', compact('users'))->render();

            return response()->json(['success' => true, 'html' => $html]);
        } catch (\Exception $e) {
            DB::rollBack(); // Reverte em caso de erro
            return $e->getMessage();
            //return response()->json(['success' => false], 500);
        }
    }

    public function getUser(Request $request)
    {

        // Busca o usuário pelo ID
        $user = User::find($request->id);
        $user->imagem = $user->imagem ? asset('storage/' . $user->imagem) : null;
        if (!$user) {
            return response()->json(['error' => 'Usuário não encontrado'], 404);
        }
        // Retorna os dados do usuário como JSON
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        $users = Auth::user()->subscription->users;

        return response()->json([
            'success' => true,
            'html' => view('partials.user-table', ['users' => $users])->render(),
        ]);
    }

    public function deletar(Request $request)
    {
        return $request->id;
    }




    public function update(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id_edit,
            'phone' => 'nullable|string|max:20',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $user = User::find($request->id_edit);
        $imagemAntiga = $user->imagem;

        // Atualiza os campos do usuário
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;

        // Processa a imagem se foi enviada
        if ($request->hasFile('imagem')) {
            if (!empty($user->imagem) && Storage::disk('public')->exists($imagemAntiga)) {
                Storage::disk('public')->delete($imagemAntiga);
            }
            $imagePath = $request->file('imagem')->store('users', 'public');
            $user->imagem = $imagePath;
        }

        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Dados atualizados com sucesso!',
            'user' => $user,
        ]);
    }



}
