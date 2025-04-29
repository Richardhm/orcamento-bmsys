<?php

namespace App\Http\Controllers;

use App\Jobs\SendVerificationEmail;
use App\Models\Assinatura;
use App\Models\Cupom;
use App\Models\EmailAssinatura;
use App\Models\User;
use App\Notifications\CustomVerifyEmail;
use App\Notifications\WelcomeNotification;
use Carbon\Carbon;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Efi\Exception\EfiException;
use Efi\EfiPay;
use PHPUnit\Exception;

class AssinaturaController extends Controller
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


    public function testNotification()
    {
//        $user = User::find(1); // Substitua pelo ID válido de um usuário
//        $notification = new CustomVerifyEmail();
//        $mailMessage = $notification->toMail($user);
//
//        // Renderiza a mensagem de e-mail como HTML
//        return $mailMessage->render();





//        $user = User::find(1); // Substitua pelo ID válido
//        $user->notify(new CustomVerifyEmail());
//        //$notification = new CustomVerifyEmail();
//        //$content = $notification->toMail($user)->render();
//
//        ///\Log::info('Template renderizado:', ['html' => $htmlContent]);
//        //dd($content); // Verifique se o conteúdo HTML gerado é válido
    }


    public function createIndividual()
    {
        return view('assinaturas.individual.create');
    }

    public function createEmpresarial()
    {
        return view('assinaturas.empresarial.create');
    }



    private function handleTrialRegistration($request, $imagePath)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'phone' => $request->phone,
            'imagem' => $imagePath,
            'cpf' => preg_replace('/[^0-9]/', '', $request->cpf), // Remove formatação
            'birth_date' => $request->birth_date,

        ]);

        $assinatura = Assinatura::create([
            'user_id' => $user->id,
            'tipo_plano_id' => 1,
            'status' => 'trial',
            'trial_ends_at' => now()->addDays(7),
            'emails_permitidos' => 3,
            'email_extra' => 1,
            'preco_base' => 0,
            'preco_total' => 0,
        ]);

        EmailAssinatura::create([
            'assinatura_id' => $assinatura->id,
            'email' => $user->email,
            'user_id' => $user->id,
            'is_administrador' => true, // Marca este e-mail como administrador
        ]);

        SendVerificationEmail::dispatch($user);


        return response()->json([
            'success' => true,
            'redirect' => route('bemvindo', ['user' => $user->id])
        ]);
    }





    public function storeIndividual(Request $request)
    {
        $isTrial = $request->has('trial');

        $validationRules = [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string',
            'birth_date' => 'required|date|before:-18 years',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:8',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ];

        if(!$isTrial) {
            $validationRules['paymentToken'] = 'required|string';
        }

        $request->validate($validationRules);

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');
        }

        try {
            if($isTrial) {
                return $this->handleTrialRegistration($request,$imagePath);
            } else {
                return $this->handlePaidRegistration($request,$imagePath,$redirect = false);
            }
        } catch (EfiException $e) {
            // ... tratamento de erro existente
        }

    }


    private function handlePaidRegistration($request, $imagePath)
    {
        try {
            // Parâmetros do plano
            $params = [
                "id" => 13289 // ID do plano individual
            ];

            // Itens da assinatura
            $items = [
                [
                    "name" => "Plano Individual",
                    "amount" => 1,
                    "value" => 12990 // R$129,90 em centavos
                ]
            ];
            // Dados do cliente
            $customer = [
                "name" => $request->name,
                "cpf" => preg_replace('/[^0-9]/', '', $request->cpf),
                "phone_number" => preg_replace('/[^0-9]/', '', $request->phone),
                "email" => $request->email,
                "birth" => $request->birth_date // Você precisa adicionar este campo no formulário!
            ];

            // Endereço (também necessário)
            $billingAddress = [
                "street" => $request->street,
                "number" => !empty($request->number) ? $request->number : "S/N",
                "neighborhood" => $request->neighborhood, // Adicionar campo no formulário
                "zipcode" => str_replace('-', '', $request->zipcode), // Adicionar campo no formulário
                "city" => $request->city, // Adicionar campo no formulário
                "state" => $request->state, // Adicionar campo no formulário
            ];



            $body = [
                "items" => $items,
                "payment" => [
                    "credit_card" => [
                        "billing_address" => $billingAddress,
                        "payment_token" => $request->paymentToken,
                        "customer" => $customer
                    ]
                ],
                "metadata" => [
                    "notification_url" => "https://cotacao.bmsys.com.br/callback"
                ]
            ];

            $response = $this->efi->createOneStepSubscription($params, $body);

            if (!isset($response['data']['subscription_id'])) {

                return response()->json([
                    'success' => false,
                    'data' => $response,
                    'redirect' => ""
                ]);
            }

            // Aqui você deve:
            // 1. Criar o usuário no seu banco de dados
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'imagem' => $imagePath,
            ]);

            // 2. Vincular o ID da assinatura ao usuário
            $assinatura = Assinatura::create([
                'user_id' => $user->id,
                'tipo_plano_id' => 1, // ID do plano Individual
                'preco_base' => 129.90,
                'emails_permitidos' => 3,
                'emails_extra' => 1,
                'preco_total' => 129.90, // Preço base sem e-mails extras
                'status' => 'ativo',
                'subscription_id' => $response['data']['subscription_id']
            ]);

            EmailAssinatura::create([
                'assinatura_id' => $assinatura->id,
                'email' => $user->email,
                'user_id' => $user->id,
                'is_administrador' => true, // Marca este e-mail como administrador
            ]);


            // Dispara o email
            SendVerificationEmail::dispatch($user);

            return response()->json([
                'success' => true,
                'data' => $response,
                'redirect' => route('bemvindo', ['user' => $user->id])
            ]);

        } catch (EfiException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->errorDescription,
                'code' => $e->code
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }

    }

    public function storeTrial(Request $request)
    {

        if($request->cupom_promocional) {
            return $this->storePromocionalTrialToPaid($request);
        } else {
            try {

                $user = User::find(auth()->user()->id);

                $params = [
                    "id" => 13289
                ];

                // Itens da assinatura
                $items = [
                    [
                        "name" => "Plano Individual",
                        "amount" => 1,
                        "value" => 12990 // R$29,90 em centavos
                    ]
                ];
                // Dados do cliente
                $customer = [
                    "name" => $user->name,
                    "cpf" => $user->cpf,
                    "phone_number" => preg_replace('/[^0-9]/', '', $user->phone),
                    "email" => $user->email,
                    "birth" => "1986-10-24"
                ];

                // Endereço (também necessário)
                $billingAddress = [
                    "street" => $request->street,
                    "number" => !empty($request->number) ? $request->number : "S/N",
                    "neighborhood" => $request->neighborhood, // Adicionar campo no formulário
                    "zipcode" => str_replace('-', '', $request->zipcode), // Adicionar campo no formulário
                    "city" => $request->city, // Adicionar campo no formulário
                    "state" => $request->state, // Adicionar campo no formulário
                ];



                $body = [
                    "items" => $items,
                    "payment" => [
                        "credit_card" => [
                            "billing_address" => $billingAddress,
                            "payment_token" => $request->paymentToken,
                            "customer" => $customer
                        ]
                    ],
                    "metadata" => [
                        "notification_url" => "https://cotacao.bmsys.com.br/callback"
                    ]
                ];

                $response = $this->efi->createOneStepSubscription($params, $body);

                $assinatura = Assinatura::where("user_id",$user->id)->first();
                $assinatura->preco_base = 129.90;
                $assinatura->preco_total = 129.90;
                $assinatura->status = 'ativo';
                $assinatura->subscription_id = $response['data']['subscription_id'];
                $assinatura->trial_ends_at = null;
                $assinatura->save();


                return response()->json([
                    'success' => true,

                    'redirect' => route('dashboard')->with('success','Assinatura Atualizada com sucesso')
                ]);


            } catch (EfiException $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->errorDescription,
                    'code' => $e->code
                ], 400);
            } catch (\Exception $e) {
                return response()->json([
                    'error' => true,
                    'message' => $e->getMessage()
                ], 500);
            }
        }




    }


    public function storePromocionalTrialToPaid(Request $request)
    {


        $cupom = null;
        $precoBase = 25000; // 250 reais em centavos
        $precoExtraPorEmail = 5000; // 50 reais em centavos

        if ($request->filled('cupom_promocional')) {
            $cupom = Cupom::where('codigo', $request->cupom_promocional)
                ->where('ativo', true)
                ->first();




            if (!$cupom) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom inválido ou expirado'
                ], 400);
            }

            // Verificar validade
            if (now()->gt($cupom->validade)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom expirado'
                ], 400);
            }

            // Verificar usos máximos
            if ($cupom->usos_maximos && $cupom->usos >= $cupom->usos_maximos) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom já utilizado o máximo de vezes'
                ], 400);
            }

            // Aplicar descontos
            $precoBase -= $cupom->desconto_plano * 100;
            $precoExtraPorEmail -= $cupom->desconto_extra * 100;

            // Garantir valores mínimos
            $precoBase = max($precoBase, 0);
            $precoExtraPorEmail = max($precoExtraPorEmail, 0);



        }

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');
        }

        try {
            $params = [
                "id" => 13290
            ];

            $items = [
                [
                    "name" => "Plano Multiusuário",
                    "amount" => 1,
                    "value" => $precoBase
                ]
            ];

            $customer = [
                "name" => auth()->user()->name,
                "cpf" => auth()->user()->cpf,
                "phone_number" => preg_replace('/[^0-9]/', '', auth()->user()->phone),
                "email" => auth()->user()->email,
                "birth" => "1986-10-24" // Você precisa adicionar este campo no formulário!
            ];



            // Endereço (também necessário)
            $billingAddress = [
                "street" => $request->street, // Adicionar campo no formulário
                "number" => !empty($request->number) ? $request->number : "S/N", // Adicionar campo no formulário
                "neighborhood" => $request->neighborhood, // Adicionar campo no formulário
                "zipcode" => str_replace('-', '', $request->zipcode), // Adicionar campo no formulário
                "city" => $request->city, // Adicionar campo no formulário
                "state" => $request->state, // Adicionar campo no formulário
            ];

            $body = [
                "items" => $items,
                "payment" => [
                    "credit_card" => [
                        "billing_address" => $billingAddress,
                        "payment_token" => $request->paymentToken,
                        "customer" => $customer
                    ]
                ],
                "metadata" => [
                    "notification_url" => "https://cotacao.bmsys.com.br/callback"
                ]
            ];


            $response = $this->efi->createOneStepSubscription($params, $body);

            if (!isset($response['data']['subscription_id'])) {
                return response()->json([
                    'success' => false,
                    'data' => $response,
                    'redirect' => ""
                ]);
            }

            $assinatura = Assinatura::where("user_id",auth()->user()->id)->first();
            $assinatura->preco_base = 250.00;
            $assinatura->emails_permitidos = 3;
            $assinatura->emails_extra = 1;
            $assinatura->tipo_plano_id = null;
            $assinatura->cupom_id = $cupom->id;
            $assinatura->preco_total = 250.00;
            $assinatura->status = 'ativo';
            $assinatura->subscription_id = $response['data']['subscription_id'];
            $assinatura->trial_ends_at = null;
            $assinatura->save();


            return response()->json([
                'success' => true,
                'redirect' => route('dashboard'),
                'message' => 'Assinatura Atualizada com sucesso'
            ]);



        }catch(Exception $e) {

        }




    }



    public function storePromocional(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:8|confirmed',
            'paymentToken' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'cupom_promocional' => 'required|string|max:10'
        ]);

        $cupom = null;
        $precoBase = 25000; // 250 reais em centavos
        $precoExtraPorEmail = 5000; // 50 reais em centavos

        if ($request->filled('cupom_promocional')) {
            $cupom = Cupom::where('codigo', $request->cupom_promocional)
                ->where('ativo', true)
                ->first();




            if (!$cupom) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom inválido ou expirado'
                ], 400);
            }

            // Verificar validade
            if (now()->gt($cupom->validade)) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom expirado'
                ], 400);
            }

            // Verificar usos máximos
            if ($cupom->usos_maximos && $cupom->usos >= $cupom->usos_maximos) {
                return response()->json([
                    'error' => true,
                    'message' => 'Cupom já utilizado o máximo de vezes'
                ], 400);
            }

            // Aplicar descontos
            $precoBase -= $cupom->desconto_plano * 100;
            $precoExtraPorEmail -= $cupom->desconto_extra * 100;

            // Garantir valores mínimos
            $precoBase = max($precoBase, 0);
            $precoExtraPorEmail = max($precoExtraPorEmail, 0);



        }

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');
        }

        try {

            $params = [
                "id" => 13290
            ];

            $items = [
                [
                    "name" => "Plano Multiusuário",
                    "amount" => 1,
                    "value" => $precoBase
                ]
            ];



            $customer = [
                "name" => $request->name,
                "cpf" => preg_replace('/[^0-9]/', '', $request->cpf),
                "phone_number" => preg_replace('/[^0-9]/', '', $request->phone),
                "email" => $request->email,
                "birth" => $request->birth_date // Você precisa adicionar este campo no formulário!
            ];



            // Endereço (também necessário)
            $billingAddress = [
                "street" => $request->street, // Adicionar campo no formulário
                "number" => !empty($request->number) ? $request->number : "S/N", // Adicionar campo no formulário
                "neighborhood" => $request->neighborhood, // Adicionar campo no formulário
                "zipcode" => str_replace('-', '', $request->zipcode), // Adicionar campo no formulário
                "city" => $request->city, // Adicionar campo no formulário
                "state" => $request->state, // Adicionar campo no formulário
            ];

            $body = [
                "items" => $items,
                "payment" => [
                    "credit_card" => [
                        "billing_address" => $billingAddress,
                        "payment_token" => $request->paymentToken,
                        "customer" => $customer
                    ]
                ],
                "metadata" => [
                    "notification_url" => "https://cotacao.bmsys.com.br/callback"
                ]
            ];


            $response = $this->efi->createOneStepSubscription($params, $body);




            if (!isset($response['data']['subscription_id'])) {

                return response()->json([
                    'success' => false,
                    'data' => $response,
                    'redirect' => ""
                ]);
            }



            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'imagem' => $imagePath,
            ]);



            // 2. Vincular o ID da assinatura ao usuário
            $assinatura = Assinatura::create([
                'user_id' => $user->id,
                'tipo_plano_id' => 2, // ID do plano Individual
                'preco_base' => 250.00,
                'emails_permitidos' => 10,
                'emails_extra' => 1,
                'preco_total' => 250.00, // Preço base sem e-mails extras
                'status' => 'ativo',
                'subscription_id' => $response['data']['subscription_id']
            ]);

            EmailAssinatura::create([
                'assinatura_id' => $assinatura->id,
                'email' => $user->email,
                'user_id' => $user->id,
                'is_administrador' => true, // Marca este e-mail como administrador
            ]);

            if ($cupom) {
                $cupom->increment('usos');
                $assinatura->update(['cupom_id' => $cupom->id]);
            }

            // Dispara o email
            SendVerificationEmail::dispatch($user);

            return response()->json([
                'success' => true,
                'data' => $response,
                'redirect' => route('bemvindo', ['user' => $user->id])
            ]);



        } catch (EfiException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->errorDescription,
                'code' => $e->code
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }


    public function storeEmpresarial(Request $request)
    {

        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'cpf' => 'required|string',
            'phone' => 'required|string',
            'password' => 'required|confirmed|min:8|confirmed',
            'paymentToken' => 'required|string',
            'imagem' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'

        ]);

        $imagePath = null;
        if ($request->hasFile('imagem')) {
            $imagePath = $request->file('imagem')->store('users', 'public');
        }

        try {
            // Parâmetros do plano
            $params = [
                "id" => 13290 // ID do plano multiusuario
            ];

            // Itens da assinatura
            $items = [
                [
                    "name" => "Plano Multiusuário",
                    "amount" => 1,
                    "value" => 25000 // R$250,00 em centavos
                ]
            ];



            // Dados do cliente
            $customer = [
                "name" => $request->name,
                "cpf" => preg_replace('/[^0-9]/', '', $request->cpf),
                "phone_number" => preg_replace('/[^0-9]/', '', $request->phone),
                "email" => $request->email,
                "birth" => $request->birth_date // Você precisa adicionar este campo no formulário!
            ];

            // Endereço (também necessário)
            $billingAddress = [
                "street" => $request->street, // Adicionar campo no formulário
                "number" => !empty($request->number) ? $request->number : "S/N", // Adicionar campo no formulário
                "neighborhood" => $request->neighborhood, // Adicionar campo no formulário
                "zipcode" => str_replace('-', '', $request->zipcode), // Adicionar campo no formulário
                "city" => $request->city, // Adicionar campo no formulário
                "state" => $request->state, // Adicionar campo no formulário
            ];



            $body = [
                "items" => $items,
                "payment" => [
                    "credit_card" => [
                        "billing_address" => $billingAddress,
                        "payment_token" => $request->paymentToken,
                        "customer" => $customer
                    ]
                ],
                "metadata" => [
                    "notification_url" => "https://cotacao.bmsys.com.br/callback"
                ]
            ];

            $response = $this->efi->createOneStepSubscription($params, $body);

            // Aqui você deve:
            // 1. Criar o usuário no seu banco de dados
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $request->password,
                'phone' => $request->phone,
                'imagem' => $imagePath,
            ]);

            // 2. Vincular o ID da assinatura ao usuário
            $assinatura = Assinatura::create([
                'user_id' => $user->id,
                'tipo_plano_id' => 2, // ID do plano Individual
                'preco_base' => 250.00,
                'emails_permitidos' => 10,
                'emails_extra' => 1,
                'preco_total' => 250.00, // Preço base sem e-mails extras
                'status' => 'ativo',
                'subscription_id' => $response['data']['subscription_id']
            ]);

            EmailAssinatura::create([
                'assinatura_id' => $assinatura->id,
                'email' => $user->email,
                'user_id' => $user->id,
                'is_administrador' => true, // Marca este e-mail como administrador
            ]);


            // Dispara o email
            SendVerificationEmail::dispatch($user);

            return response()->json([
                'success' => true,
                'data' => $response,
                'redirect' => route('bemvindo', ['user' => $user->id])
            ]);

        } catch (EfiException $e) {
            return response()->json([
                'error' => true,
                'message' => $e->errorDescription,
                'code' => $e->code
            ], 400);
        } catch (\Exception $e) {
            return response()->json([
                'error' => true,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    public function createPromocional()
    {
        return view('assinaturas.promocional.create');
    }

    public function edit()
    {
        return view('assinaturas.trial.create');
    }






    public function historicoPagamentos()
    {
        try {
            $assinatura = Assinatura::where('user_id', auth()->id())->firstOrFail();
            $params = ['id' => $assinatura->subscription_id];

            // Buscar detalhes da assinatura
            $response = $this->efi->detailSubscription($params);

            $dados = [
                'proxima_fatura' => [
                    'data' => Carbon::parse($response['data']['next_execution'])->format('d/m/Y'),
                    'valor' => number_format($response['data']['value'] / 100, 2, ',', '.')
                ],
                'historico' => []
            ];

            foreach ($response['data']['history'] as $evento) {
                // Buscar detalhes completos da cobrança
                $chargeResponse = $this->efi->detailCharge(['id' => $evento['charge_id']]);

                // Formatar dados conforme nova estrutura
                $dados['historico'][] = [
                    'charge_id' => $chargeResponse['data']['charge_id'],
                    'status' => $chargeResponse['data']['status'],
                    'valor_total' => number_format($chargeResponse['data']['total'] / 100, 2, ',', '.'),
                    'data_criacao' => Carbon::parse($chargeResponse['data']['created_at'])->format('d/m/Y H:i'),
                    'metodo_pagamento' => $chargeResponse['data']['payment']['method'] ?? 'N/A',
                    'ultima_mensagem' => end($chargeResponse['data']['history'])['message'] ?? 'Sem informações',
                    'cliente' => [
                        'nome' => $chargeResponse['data']['customer']['name'],
                        'email' => $chargeResponse['data']['customer']['email']
                    ],
                    'items' => array_map(function($item) {
                        return [
                            'nome' => $item['name'],
                            'valor_unitario' => number_format($item['value'] / 100, 2, ',', '.'),
                            'quantidade' => $item['amount']
                        ];
                    }, $chargeResponse['data']['items'])
                ];
            }

            return view('assinaturas.historico', compact('dados'));

        } catch (\Exception $e) {
            \Log::error("Erro ao buscar histórico: " . $e->getMessage());
            dd($e->getMessage());
            //return redirect()->back()->withErrors('Erro ao carregar histórico de pagamentos');
        }
    }








}
