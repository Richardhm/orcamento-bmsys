<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TabelaOrigens extends Model
{
    protected $fillable = [
      'nome',
      'uf'
    ];

    public function assinaturas()
    {
        return $this->belongsToMany(Assinatura::class, 'assinatura_cidade');
    }

    public function tabelaModels()
    {
        return $this->hasMany(Tabela::class); // Substitua pelo modelo real
    }
}
