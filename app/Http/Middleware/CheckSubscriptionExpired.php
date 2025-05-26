<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckSubscriptionExpired
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


            if (!$this->isSubscriptionExpired($assinatura) && !$this->isPixExpired($assinatura)) {
                return redirect()->route('dashboard');
            }


        }

        return $next($request);
    }

    private function isSubscriptionExpired($assinatura): bool
    {
        return $assinatura->status === 'trial' &&
            $assinatura->trial_ends_at &&
            now()->gt($assinatura->trial_ends_at);
    }

    private function isPixExpired($assinatura): bool
    {
        return $assinatura->tipo === 'PIX' &&
            $assinatura->next_charge &&
            now()->gt($assinatura->next_charge);
    }
}
