<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;


class PreventSimultaneousLogins
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $userId = Auth::id();
            $currentSessionId = session()->getId();

            // Verifica se há outra sessão ativa para o mesmo usuário
            $activeSessions = DB::table('sessions')
                ->where('user_id', $userId)
                ->where('id', '!=', $currentSessionId)
                ->where('last_activity', '>', now()->subMinutes(config('session.lifetime'))->timestamp)
                ->count();

            if ($activeSessions > 0) {
                Auth::logout();
                session()->invalidate();
                session()->regenerateToken();

                return redirect()->route('login')->withErrors([
                    'error' => 'Você já está logado em outro dispositivo.',
                ]);
            }
        }

        return $next($request);
    }
}
