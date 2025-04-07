<?php

namespace App\View\Components\Configuracoes;

use App\Models\Plano;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PlanosTab extends Component
{
    public $planos;
    public function __construct()
    {
        $this->planos = Plano::orderBy('nome')->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.planos-tab');
    }
}
