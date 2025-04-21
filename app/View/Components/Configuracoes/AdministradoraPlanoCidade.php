<?php

namespace App\View\Components\configuracoes;

use App\Models\Administradora;
use App\Models\AdministradoraPlano;
use App\Models\Assinatura;
use App\Models\Plano;
use App\Models\TabelaOrigens;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdministradoraPlanoCidade extends Component
{
    public $administradoras;
    public $planos;
    public $tabelas;
    public $assinaturas;
    public $vinculosAgrupados;
    public $vinculos;

    public function __construct()
    {
        $this->assinaturas = Assinatura::with('user')->latest()->get();
        $this->administradoras = Administradora::all();
        $this->planos = Plano::all();
        $this->tabelas = TabelaOrigens::all();
        $this->vinculos = AdministradoraPlano::with(['administradora', 'plano', 'tabelaOrigem','assinatura'])
            ->whereNotNull('assinatura_id')
            ->get();
        $this->vinculosAgrupados = AdministradoraPlano::with(['administradora', 'plano', 'tabelaOrigem', 'assinatura.user'])
            ->whereNotNull('assinatura_id')
            ->get()
            ->groupBy('assinatura_id');

    }



    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.administradora-plano-cidade');
    }
}
