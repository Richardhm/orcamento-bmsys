<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class EmailAssinatura extends Model
{

    use HasFactory;

    protected $table = 'emails_assinatura';


    protected $fillable = ['assinatura_id', 'email', 'user_id','is_administrador'];

    public function assinatura()
    {
        return $this->belongsTo(Assinatura::class,'assinatura_id','id');
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
