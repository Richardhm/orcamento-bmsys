<?php
if (!function_exists('translateStatus')) {
    function translateStatus($status) {
        return match($status) {
            'waiting' => 'Aguardando Pagamento',
            'paid' => 'Pago',
            default => ucfirst($status)
        };
    }
}

if (!function_exists('translatePaymentMethod')) {
    function translatePaymentMethod($method) {
        return match($method) {
            'credit_card' => 'Cartão de Crédito',
            'pix' => 'PIX',
            'boleto' => 'Boleto Bancário',
            default => ucfirst($method)
        };
    }
}
