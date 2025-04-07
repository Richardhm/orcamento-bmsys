<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Administradora extends Model
{
    protected $fillable = ['nome', 'logo'];

    public function dependentes()
    {
        return $this->hasMany(Tabela::class); // Substitua pelo relacionamento real
    }
}
