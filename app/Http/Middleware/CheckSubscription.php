<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscription
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if ($user && $user->assinaturas) {
            $assinatura = $user->assinaturas;

            if ($assinatura->status === 'trial' && now()->gt($assinatura->trial_ends_at)) {

                if ($user->id === $assinatura->user_id) {
                    return redirect()->route('assinatura.edit')
                        ->with('error', 'Seu período de teste acabou. Por favor, atualize sua assinatura!');
                }

                // Usuários comuns da assinatura
                return redirect()->route('assinatura.expirada')
                    ->with('error', 'O período trial expirou. Entre em contato com o administrador.');
            }


            if ($assinatura->tipo === 'PIX' && now()->gt($assinatura->next_charge)) {

                if ($user->id === $assinatura->user_id) {
                    return redirect()->route('assinatura.edit')
                        ->with('error', 'Sua assinatura PIX expirou. Por favor, renove-a para continuar utilizando nossos serviços.');
                }

                return redirect()->route('assinatura.expirada')
                    ->with('error', 'O período trial expirou. Entre em contato com o administrador.');
            }



        }



        return $next($request);
    }
}
