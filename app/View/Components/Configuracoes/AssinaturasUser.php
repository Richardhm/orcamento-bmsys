<?php

namespace App\View\Components\configuracoes;

use App\Models\Assinatura;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AssinaturasUser extends Component
{
    public $assinaturas;
    public $paginacao;

    public function __construct($perPage = 10)
    {
        $this->assinaturas = Assinatura::with([
            'user',
            'emails' => function($query) {
                $query->where('is_administrador', 1);
            },
            'cidades'
        ])
            ->paginate($perPage);

        $this->paginacao = $this->assinaturas;
    }

    private function formatarDados($assinaturas)
    {
        return $assinaturas->map(function($assinatura) {
            return [
                'id' => $assinatura->id,
                'admin' => $assinatura->emails->first()->user->name ?? 'N/A',
                'email_admin' => $assinatura->emails->first()->email ?? 'N/A',
                'valor' => number_format($assinatura->preco_total, 2, ',', '.'),
                'usuarios' => $assinatura->emails->count(),
                'cidades' => $assinatura->cidades->pluck('nome')->implode(', '),
                'status' => $assinatura->status,
                'proximo_pagamento' => $assinatura->next_charge?->format('d/m/Y')
            ];
        });
    }

    public function render()
    {
        return view('components.configuracoes.assinaturas-user', [
            'dados' => $this->formatarDados($this->assinaturas),
            'paginacao' => $this->paginacao
        ]);
    }
}
