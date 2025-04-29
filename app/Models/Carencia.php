<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Carencia extends Model
{
    protected $fillable = [
        'plano_id',
        'tabela_origens_id',
        'tempo',
        'detalhe',
        'frase'
    ];

    public function plano() {
        return $this->belongsTo(Plano::class);
    }

    public function cidade() {
        return $this->belongsTo(TabelaOrigens::class, 'tabela_origens_id');
    }
}
