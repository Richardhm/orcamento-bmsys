<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionCharge extends Model
{
    protected $table = 'subscription_charges';
    public function subscription()
    {
        return $this->belongsTo(Assinatura::class);
    }
}
