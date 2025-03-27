<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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

            $response = $this->efi->getNotification($params);
            header("HTTP/1.1 200");
            if($response) {
                print_r("<pre>" . json_encode($response, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) . "</pre>");
            } else {
                print_r("Errroooo");
            }
        } catch (EfiException $e) {
            header("HTTP/1.1 400");
            print_r($e->code . "<br>");
            print_r($e->error . "<br>");
            print_r($e->errorDescription);
        } catch(Exception $e) {
            header("HTTP/1.1 403");
            print_r($e->getMessage());
        }










    }
}
