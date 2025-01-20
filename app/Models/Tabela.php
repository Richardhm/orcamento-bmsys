<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Tabela extends Model
{
    public function faixaEtaria()
    {
        return $this->belongsTo(FaixaEtaria::class);
    }
}
