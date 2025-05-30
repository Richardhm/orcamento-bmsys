<?php

namespace App\Http\Controllers;

use App\Models\SubscriptionCharge;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Assinatura;
use Efi\Exception\EfiException;
use Efi\EfiPay;


class CallbackController extends Controller
{
    private $efi;

    public function __construct()
    {
        $mode = config('gerencianet.mode');
        $certificate = config("gerencianet.{$mode}.certificate_name");

        $client_id = config("gerencianet.{$mode}.client_id");
        $client_secret = config("gerencianet.{$mode}.client_secret");
        $certificate_path = base_path("certs/{$certificate}");

        $options = [
            'client_id' => $client_id,
            'client_secret' => $client_secret,
            'sandbox' => true,
            'debug' => false
        ];

        $this->efi = new EfiPay($options);
    }

    public function index()
    {
        $token = request()->notification;
        $params = [
            "token" => $token
        ];
        try {
            \Log::channel('gerencianet')->info("Iniciando processamento da notificação", [
                'token' => $token,
                'ip' => request()->ip(),
                'user_agent' => request()->userAgent()
            ]);
            $response = $this->efi->getNotification($params);

            \Log::channel('gerencianet')->debug("Resposta completa da API", [
                'raw_response' => $response,
                'memory_usage' => memory_get_usage(true) / 1024 / 1024 . " MB"
            ]);


            header("HTTP/1.1 200");
            if ($response && isset($response['data'])) {

                $this->processNotifications($response['data']);

                \Log::channel('gerencianet')->info("Notificação processada com sucesso", [
                    'subscription_id' => $response['data'][0]['identifiers']['subscription_id'] ?? null,
                    'event_count' => count($response['data'])
                ]);

                return response()->json(['success' => true]);
                //return response()->json($response['data']);

//                return response()->json([
//                    'success' => true,
//                    'data' => $response
//                ], 200, [], JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);


            }
            return response()->json(['error' => 'Resposta inválida'], 400);
        } catch (EfiException $e) {
            header("HTTP/1.1 400");
            print_r($e->code . "<br>");
            print_r($e->error . "<br>");
            print_r($e->errorDescription);
        } catch (Exception $e) {
            header("HTTP/1.1 403");
            print_r($e->getMessage());
        }
    }


    private function processNotifications(array $notifications)
    {
        foreach ($notifications as $event) {
            try {
                switch ($event['type']) {
                    case 'subscription':
                        $this->processSubscription($event);
                        break;

                    case 'subscription_charge':
                        $this->processCharge($event);
                        break;
                }
            } catch (\Exception $e) {
                \Log::error("Erro processando evento {$event['id']}: " . $e->getMessage());
            }
        }
    }

    private function processSubscription(array $subscriptionEvent)
    {
        // Atualizar dados principais da assinatura
        Assinatura::updateOrCreate(
            ['subscription_id' => $subscriptionEvent['identifiers']['subscription_id']],
            [
                'status' => $subscriptionEvent['status']['current'],
                'last_updated' => $subscriptionEvent['created_at']
            ]
        );
    }

    public function processCharge(array $chargeEvent)
    {
        // Converter valores para decimal
        try {
            $params = ['id' => $chargeEvent['identifiers']['subscription_id']];
            $chargeDetails = $this->efi->detailSubscription($params);

            $value = $chargeDetails['data']['value'] / 100; // Valor em decimal
        } catch (\Exception $e) {
            \Log::error("Erro ao buscar detalhes da cobrança: " . $e->getMessage());
            $value = 0;
        }

        // Gravar cobrança individual
        SubscriptionCharge::updateOrCreate(
            [
                'charge_id' => $chargeEvent['identifiers']['charge_id'],
                'subscription_id' => $chargeEvent['identifiers']['subscription_id']
            ],
            [
                'status' => $chargeEvent['status']['current'],
                'value' => $value,
                'payment_date' => isset($chargeEvent['received_by_bank_at'])
                    ? Carbon::parse($chargeEvent['received_by_bank_at'])
                    : null,
                'event_date' => Carbon::parse($chargeEvent['created_at']),
                'metadata' => json_encode($chargeEvent)
            ]
        );

        // Atualizar status geral se for pagamento
        if ($chargeEvent['status']['current'] === 'paid') {
            Assinatura::where('subscription_id', $chargeEvent['identifiers']['subscription_id'])
                ->update([
                    'last_payment' => Carbon::parse($chargeEvent['received_by_bank_at']),
                    'next_charge' => Carbon::parse($chargeEvent['created_at'])->addMonth()
                ]);
        }
    }

}
