<?php

namespace App\View\Components\Configuracoes;

use App\Models\Administradora;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class AdministradorasTab extends Component
{
    public $administradoras;
    public function __construct()
    {

        $this->administradoras = Administradora::latest()->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.administradoras-tab');
    }
}
