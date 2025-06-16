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

    public $somaValor;
    public $somaUsuarios;

    public function __construct($perPage = 10)
    {
        $this->assinaturas = Assinatura::with([
            'user',
            'emails',
            'cidades'
        ])
            //->where('is_administrador', 1)
            //->get();
            ->paginate($perPage);

        $this->somaValor = $this->assinaturas->sum('preco_total');

        $this->somaUsuarios = $this->assinaturas->sum(function($assinatura){
            return $assinatura->emails->count();
        });

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
                'cidades' => $assinatura->user->phone,
                'status' => $assinatura->status,
                'proximo_pagamento' => $assinatura->next_charge ? $assinatura->next_charge?->format('d/m/Y') : ""
            ];
        });
    }

    public function render()
    {
        return view('components.configuracoes.assinaturas-user', [
            'dados' => $this->formatarDados($this->assinaturas),
            'paginacao' => $this->paginacao,
            'somaValor' => $this->somaValor,
            'somaUsuarios' => $this->somaUsuarios,
        ]);
    }
}
