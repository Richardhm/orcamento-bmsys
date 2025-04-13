<?php

namespace App\View\Components\Configuracoes;

use App\Models\Administradora;
use App\Models\TabelaOrigens;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

use App\Models\Plano;

use App\Models\Desconto;




class DescontoTab extends Component
{
    public $planos;
    public $cidades;
    public $descontos;
    public $administradoras;


    /**
     * Create a new component instance.
     */
    public function __construct()
    {

        $this->planos = Plano::orderBy('nome')->get();
        $this->cidades = TabelaOrigens::orderBy('nome')->get();
        $this->descontos = Desconto::with(['plano', 'cidade'])->latest()->get();
        $this->administradoras = Administradora::orderBy('id','desc')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.desconto-tab');
    }
}
