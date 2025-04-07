<?php

namespace App\View\Components\Configuracoes;

use App\Models\Assinatura;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AssinaturasCidadeTab extends Component
{
    public $assinaturas;
    public function __construct()
    {

        $this->assinaturas = Assinatura::with('user')->latest()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.assinaturas-cidade-tab');
    }
}
