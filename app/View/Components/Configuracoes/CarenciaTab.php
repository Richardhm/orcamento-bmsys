<?php

namespace App\View\Components\configuracoes;

use App\Models\Carencia;
use App\Models\Plano;
use App\Models\TabelaOrigens;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class CarenciaTab extends Component
{
    public $planos;
    public $cidades;
    public $carencias;

    public function __construct() {

        $this->planos = Plano::orderBy('nome')->get();
        $this->cidades = TabelaOrigens::orderBy('nome')->get();
        $this->carencias = Carencia::with(['plano', 'cidade'])
            ->orderBy('plano_id')
            ->orderBy('tabela_origens_id')
            ->get()
            ->groupBy(function($item) {
                return $item->cidade->nome . '|' . $item->plano->nome . '|' . $item->tabela_origens_id . '|' . $item->plano_id;
            });



    }

    public function render() {
        return view('components.configuracoes.carencia-tab');
    }
}
