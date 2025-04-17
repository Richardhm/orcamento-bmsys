<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdministradoraPlano extends Model
{
    use HasFactory;

    protected $table = 'administradora_planos';

    protected $fillable = [
        'plano_id',
        'administradora_id',
        'tabela_origens_id',
        'assinatura_id'
    ];

    public function administradora()
    {
        return $this->belongsTo(Administradora::class);
    }

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class);
    }

    public function plano()
    {
        return $this->belongsTo(Plano::class);
    }

    public function cidade()
    {
        return $this->belongsTo(TabelaOrigens::class,'tabela_origens_id');
    }

    public function tabelaOrigem()
    {
        return $this->belongsTo(TabelaOrigens::class, 'tabela_origens_id');
    }
}
