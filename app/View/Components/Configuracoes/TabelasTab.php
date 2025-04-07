<?php

namespace App\View\Components\Configuracoes;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Illuminate\View\Component;

class TabelasTab extends Component
{

    public $administradoras;
    public $planos;
    public $acomodacao;
    public $faixas;
    public $tabela_origem;


    /**
     * Create a new component instance.
     */
    public function __construct()
    {
        $this->administradoras = DB::table('administradoras')->get();
        $this->planos = DB::table('planos')->get();
        $this->acomodacao = DB::table('acomodacoes')->get();
        $this->faixas = DB::table('faixa_etarias')->get();
        $this->tabela_origem = DB::table('tabela_origens')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.tabelas-tab');
    }
}
