<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    public function faixaEtaria()
    {
        return $this->belongsTo(FaixaEtaria::class);
    }

    public function valores()
    {
        return $this->hasMany(TabelaValor::class);
    }

    public function valoresPorAcomodacao()
    {
        return $this->valores()
            ->with(['acomodacao', 'faixaEtaria'])
            ->get()
            ->groupBy('acomodacao.nome')
            ->mapWithKeys(function ($valores, $acomodacao) {
                return [$acomodacao => $valores->pluck('valor', 'faixa_etaria_id')];
            });
    }




}
