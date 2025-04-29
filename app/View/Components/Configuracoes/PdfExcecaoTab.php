<?php

namespace App\View\Components\Configuracoes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use App\Models\Plano;
use App\Models\TabelaOrigens;
use App\Models\PdfExcecao;



class PdfExcecaoTab extends Component
{
    public $planos;
    public $cidades;
    public $excecoes;

    public function __construct()
    {
        $this->planos   = Plano::orderBy('nome')->get();
        $this->cidades  = TabelaOrigens::orderBy('nome')->get();
        $this->excecoes = PdfExcecao::with(['plano', 'cidade'])->get();
    }

    public function render()
    {
        return view('components.configuracoes.pdf-excecao-tab');
    }
}
