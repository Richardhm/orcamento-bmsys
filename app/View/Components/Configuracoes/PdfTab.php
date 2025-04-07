<?php

namespace App\View\Components\Configuracoes;

use App\Models\Pdf;
use App\Models\Plano;
use App\Models\TabelaOrigens;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class PdfTab extends Component
{
    public $planos;
    public $cidades;
    public $pdfs;
    public function __construct()
    {
        $this->planos = Plano::orderBy('nome')->get();
        $this->cidades = TabelaOrigens::orderBy('nome')->get();
        $this->pdfs = Pdf::with(['plano', 'cidade'])
            ->orderBy('plano_id')
            ->orderBy('tabela_origens_id')
            ->get();
    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render(): View|Closure|string
    {
        return view('components.configuracoes.pdf-tab');
    }
}
