<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cupom extends Model
{
    protected $table = 'cupons';
    use HasFactory;

    protected $fillable = [
        'codigo',
        'desconto_plano',
        'desconto_extra',
        'duracao_horas',
        'duracao_minutos',
        'duracao_segundos',
        'validade',
        'usos_maximos',
        'usos',
        'ativo'
    ];

    protected $casts = [
        'validade' => 'datetime:Y-m-d H:i:s',
        'ativo' => 'boolean'
    ];

    protected $dates = [
        'validade'
    ];

    public function getValidadeFormatadaAttribute()
    {
        return $this->validade->format('d/m/Y H:i:s');
    }



    public function isValid()
    {
        return $this->ativo &&
            $this->validade > now() &&
            ($this->usos_maximos === null || $this->usos < $this->usos_maximos);
    }
}
