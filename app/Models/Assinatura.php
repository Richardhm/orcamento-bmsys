<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assinatura extends Model
{
    protected $fillable = [
        'user_id', 'tipo_plano_id', 'preco_base', 'emails_permitidos', 'emails_extra', 'preco_total','status','subscription_id'
    ];

//    public function emails()
//    {
//        return $this->hasMany(EmailAssinatura::class);
//    }
//
    public function emailsAssinatura()
    {
        return $this->hasMany(EmailAssinatura::class,'assinatura_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function emailAssinatura()
    {
        return $this->hasOne(EmailAssinatura::class, 'assinatura_id');
    }

    public function emailsAssinaturaUser()
    {
        return $this->hasMany(EmailAssinatura::class)->with('user');
    }



    public function calcularPrecoTotal()
    {
        $emailsExtras = max(0, $this->emails()->count() - $this->emails_permitidos);
        $this->emails_extra = $emailsExtras;
        $this->preco_total = $this->preco_base + ($emailsExtras * 30);
        $this->save();
    }
}
