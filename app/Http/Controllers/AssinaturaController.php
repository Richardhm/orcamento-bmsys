<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationEmail;
use App\Models\Assinatura;
use App\Models\EmailAssinatura;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\WelcomeNotification;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class AssinaturaController extends Controller
{
    public function testNotification()
    {
//        $user = User::find(1); // Substitua pelo ID válido de um usuário
//        $notification = new CustomVerifyEmail();
//        $mailMessage = $notification->toMail($user);
//
//        // Renderiza a mensagem de e-mail como HTML
//        return $mailMessage->render();





//        $user = User::find(1); // Substitua pelo ID válido
//        $user->notify(new CustomVerifyEmail());
//        //$notification = new CustomVerifyEmail();
//        //$content = $notification->toMail($user)->render();
//
//        ///\Log::info('Template renderizado:', ['html' => $htmlContent]);
//        //dd($content); // Verifique se o conteúdo HTML gerado é válido
    }


    public function createIndividual()
    {
        return view('assinaturas.individual.create');
    }

    public function createEmpresarial()
    {
        return view('assinaturas.empresarial.create');
    }

    public function storeIndividual(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');
        }

        // Criar o usuário
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'imagem' => $imagePath,
        ]);

        // Criar a assinatura
        Assinatura::create([
            'user_id' => $user->id,
            'tipo_plano_id' => 1, // ID do plano Individual
            'preco_base' => 29.90,
            'emails_permitidos' => 1,
            'emails_extra' => 0,
            'preco_total' => 29.90, // Preço base sem e-mails extras
            'status' => 'ativo',
        ]);

        // Realizar login automático
        //Auth::login($user);
        //event(new Registered($user));
        //$user->notify(new WelcomeNotification);
        SendVerificationEmail::dispatch($user);
        // Redirecionar para o dashboard
        return redirect()->route('login')->withErrors([
            'message' => 'Cadastrado com sucesso, por favor verificar seu email.',
        ]);
    }

    public function storeEmpresarial(Request $request)
    {
        // Validação dos dados de entrada
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');

        }

        // Criação do usuário (administrador do plano empresarial)
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'imagem' => $imagePath,
        ]);

        // Configurações do plano empresarial
        $precoBase = 129.90; // Valor base do plano empresarial
        $emailsPermitidos = 5; // Limite inicial de e-mails permitidos
        $emailsExtras = $request->input('emails_extra', 0); // Quantidade de e-mails extras (opcional)
        $precoPorEmailExtra = 30.00; // Preço por e-mail extra

        // Calcular o valor total da assinatura
        $precoTotal = $precoBase + ($emailsExtras * $precoPorEmailExtra);

        // Criar a assinatura empresarial
        $assinatura = Assinatura::create([
            'user_id' => $user->id,
            'tipo_plano_id' => 2, // ID do plano Empresarial
            'preco_base' => $precoBase,
            'emails_permitidos' => $emailsPermitidos,
            'emails_extra' => $emailsExtras,
            'preco_total' => $precoTotal,
            'status' => 'ativo',
        ]);

        // Associar o e-mail do administrador ao plano
        EmailAssinatura::create([
            'assinatura_id' => $assinatura->id,
            'email' => $user->email,
            'user_id' => $user->id,
            'is_administrador' => true, // Marca este e-mail como administrador
        ]);

        SendVerificationEmail::dispatch($user);
        // Redirecionar para o dashboard
        return redirect()->route('login')->withErrors([
            'message' => 'Cadastrado com sucesso, por favor verificar seu email.',
        ]);

        // Redirecionar para o dashboard com mensagem de sucesso
        return redirect()->route('dashboard')->with('success', 'Assinatura empresarial criada com sucesso!');
    }












}
