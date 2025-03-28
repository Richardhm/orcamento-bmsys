<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionCharge extends Model
{
    protected $table = 'subscription_charges';

    protected $fillable = [
        'charge_id',
        'subscription_id',
        'status',
        'value',
        'payment_date',
        'event_date',
        'metadata'
    ];

    public function subscription()
    {
        return $this->belongsTo(Assinatura::class);
    }
}
