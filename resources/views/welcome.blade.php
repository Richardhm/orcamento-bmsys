<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotações de Plano de Saúde</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('toastr.min.css')}}">
    <style>
        /* Aumentar a largura do toastr */
        .toast {
            width: 400px !important; /* Modifique esse valor conforme necessário */
        }
        .ajax_load {display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;}
        .ajax_load_box{margin:auto;text-align:center;color:#fff;font-weight:var(700);text-shadow:1px 1px 1px rgba(0,0,0,.5)}
        .ajax_load_box_circle{border:16px solid #e3e3e3;border-top:16px solid #61DDBC;border-radius:50%;margin:auto;width:80px;height:80px;-webkit-animation:spin 1.2s linear infinite;-o-animation:spin 1.2s linear infinite;animation:spin 1.2s linear infinite}
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}

        /* Estilização do Scroll */
        ::-webkit-scrollbar {
            width: 12px;
            height: 12px;
        }

        ::-webkit-scrollbar-track {
            background: #FEF3C7; /* Cor de fundo do track */
            border-radius: 8px;
        }

        ::-webkit-scrollbar-thumb {
            background: #34150b; /* text-amber-950 */
            border-radius: 8px;
            border: 3px solid #FEF3C7; /* Borda combinando com o track */
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #431d0e; /* Tom levemente mais claro para hover */
        }

        #pricing {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        #pricing .flex-1 {
            flex: 1 1 0%;
            min-height: 75vh;
        }

        /* Para Firefox */
        * {
            scrollbar-width: thin;
            scrollbar-color: #34150b #FEF3C7;
        }



    </style>
</head>
<body class="bg-blue-950">
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>
<!-- Navbar -->
<nav class="fixed w-full z-50 shadow-md bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px]">
    <div class="mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-20">
            <!-- Logo -->
            <div class="flex items-center rounded-lg">
                <img src="{{asset('logo_bm_1.png')}}" alt="Logo" class="h-16 p-1">
            </div>

            <!-- Título Centralizado -->
            <div class="absolute left-1/2 transform -translate-x-1/2">
                <h1 class="text-4xl font-bold text-white">Sistema Orçamento</h1>
            </div>

            <!-- Botões Direita -->
            <div class="flex items-center space-x-4">
                <a href="#pricing" class="bg-red-600 text-white px-6 py-2 rounded-full hover:bg-red-900 transition-colors">
                    Assine Agora
                </a>
                <a href="{{route('login')}}" class="bg-white text-black px-6 py-2 rounded-full hover:bg-gray-900 hover:text-white transition-colors">
                    Login
                </a>
                <div>
                    <img src="{{asset('hapvida-notreDame_baixa_1.png')}}" alt="Hapvida">
                </div>
            </div>

        </div>
    </div>
</nav>






<section id="imagem-dobra" class="relative min-h-screen flex items-center justify-center pt-16 pb-20 overflow-hidden">

    <!-- Background pattern -->
    <div class="absolute inset-0 opacity-10" style="background-image: url('data:image/svg+xml,%3Csvg width=\"60\" height=\"60\" viewBox=\"0 0 60 60\" xmlns=\"http://www.w3.org/2000/svg\"%3E%3Cg fill=\"none\" fill-rule=\"evenodd\"%3E%3Cg fill=\"%23ffffff\" fill-opacity=\"0.05\"%3E%3Cpath d=\"M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\"/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
            <!-- Left Column - Content -->
            <div class="text-white z-10">
                <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                    Revolucione suas Cotações de Plano de Saúde
                </h1>
                <p class="text-white text-lg md:text-xl mb-8">
                    Crie orçamentos profissionais em poucos cliques. Economize tempo e feche mais vendas com nossa plataforma intuitiva.
                </p>

                <!-- Botão CTA e Video -->
                <div class="flex flex-col gap-6">
                    <a href="#pricing" class="bg-white text-black px-8 py-4 rounded-lg hover:bg-black hover:text-white transition-all transform hover:-translate-y-1 flex items-center justify-center">
                        Saiba Mais
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </a>

                    <!-- Botão Ver Vídeo -->
                    <button onclick="openVideoModal()" class="group relative inline-flex items-center justify-center">
                        <div class="absolute inset-0 bg-white/10 rounded-lg blur-md group-hover:bg-white/20 transition"></div>
                        <span class="relative flex items-center text-white font-bold text-3xl group-hover:text-white transition">
                            <svg class="w-6 h-6 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                            </svg>
                            Ver Demonstração
                        </span>
                    </button>
                </div>

                <!-- Metrics -->
                <div class="flex justify-between mt-12">
                    <div>
                        <h4 class="text-3xl font-bold text-white text-center">+1000</h4>
                        <p class="text-white text-lg">Corretores Ativos</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-white text-center">30s</h4>
                        <p class="text-white text-lg">Tempo Médio de Cotação</p>
                    </div>
                    <div>
                        <h4 class="text-3xl font-bold text-white text-center">98%</h4>
                        <p class="text-white text-lg">Satisfação</p>
                    </div>
                </div>
            </div>

            <!-- Right Column - Preview do GIF -->
            <div class="relative group cursor-pointer scale-75" onclick="openVideoModal()">
                <div class="relative rounded-xl overflow-hidden shadow-2xl transform group-hover:scale-105 transition-transform">
                    <img src="{{asset('tela.png')}}" alt="Preview" class="object-cover">
                    <div class="absolute inset-0 bg-black/40 flex items-center justify-center">
                        <svg class="w-14 h-14 text-white opacity-75 hover:opacity-100 transition" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal do Vídeo -->
    <div id="videoModal" class="hidden fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="relative w-full max-w-4xl">
            <button onclick="closeVideoModal()" class="absolute -top-8 right-0 text-white text-2xl hover:text-gray-300">
                &times;
            </button>
            <img src="{{asset('demonstracao.gif')}}" alt="Demonstração" class="w-full h-auto rounded-lg shadow-2xl">
        </div>
    </div>
</section>

<section id="pricing" class="min-h-screen flex flex-col justify-center py-18">
    <div class="max-w-5xl w-[70%] mx-auto h-full flex flex-col">
        <div class="text-center mb-8">
            <h2 class="text-6xl font-bold text-white mb-4">Nossos Planos</h2>
            <p class="text-4xl text-white font-bold">Escolha o plano ideal para suas necessidades</p>
        </div>

        <div class="flex flex-1 gap-6 justify-center items-stretch h-full">
            <!-- Plano Individual -->
            <a href="{{route('assinaturas.individual.create')}}" class="bg-white w-[320px] rounded-xl shadow-lg p-6 border border-blue-100 transition-all hover:bg-gray-100 flex flex-col justify-between">
                <div>
                    <div>
                        <p class="text-purple-900 text-center font-bold text-lg">INDIVIDUAL</p>
                        <p class="text-purple-900 text-center">Ideal para uma única pessoa</p>
                    </div>
                    <div class="bg-purple-950 text-white text-center py-3 rounded-full mt-6">
                        Começar Agora
                    </div>
                    <div class="my-6 text-center flex items-center justify-center">
                        <p class="flex flex-col items-start relative">
                            <span class="text-lg font-bold text-purple-900 leading-none">R$</span>
                            <span class="text-7xl font-bold text-purple-900">29,90</span>
                            <span class="text-sm text-purple-900 self-end">/mês</span>
                        </p>
                    </div>

                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li class="flex items-center">
                            ✅ Acesso ao sistema
                        </li>
                        <li class="flex items-center">
                            ✅ Cotações ilimitadas
                        </li>
                        <li class="flex items-center">
                            ✅ Fácil de usar
                        </li>
                        <li class="flex items-center">
                            ✅ Apenas um e-mail
                        </li>
                    </ul>



                </div>

                <div>
                    <p class="text-center text-gray-500 flex justify-center items-center text-sm">
                        Saiba Mais, clique aqui
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>

                    </p>

                </div>

            </a>

            <!-- Plano Empresarial -->
            <a href="{{route('assinaturas.empresarial.create')}}" class="bg-white w-[320px] rounded-xl shadow-lg p-6 border-4 border-orange-400 transition-all hover:bg-gray-100 hover:shadow-xl flex flex-col justify-between">
                <div>
                    <div>
                        <p class="text-purple-900 text-center font-bold text-lg">MULTIUSUÁRIO</p>
                        <p class="text-purple-900 text-center">Ideal para a sua corretora</p>
                    </div>
                    <div class="bg-purple-950 text-white text-center py-3 rounded-full mt-6">
                        Começar Agora
                    </div>
                    <div class="my-6 text-center flex items-center justify-center">
                        <p class="flex flex-col items-start relative">
                            <span class="text-lg font-bold text-purple-900 leading-none">R$</span>
                            <span class="text-7xl font-bold text-purple-900">129,90</span>
                            <span class="text-sm text-purple-900 self-end">/mês</span>
                        </p>
                    </div>
                    <ul class="space-y-2 text-gray-600 text-sm">
                        <li class="flex items-center">
                            ✅ Acesso ao sistema
                        </li>
                        <li class="flex items-center">
                            ✅ Cotações ilimitadas
                        </li>
                        <li class="flex items-center">
                            ✅ Fácil de usar
                        </li>
                        <li class="flex items-center">
                            ✅ Equipes colaborativas
                        </li>
                        <li class="flex items-center">
                            ✅ Gestão completa
                        </li>
                        <li class="flex items-center">
                            ✅ Relatórios detalhados
                        </li>
                        <li class="flex items-center">
                            ✅ Cadastrar até 5 e-mails
                        </li>
                        <li class="flex items-center">
                            ✅ Acima de 5 e-mails é cobrado 25 reais
                        </li>
                    </ul>
                </div>
                <div>
                    <p class="text-center text-gray-500 flex justify-center items-center text-sm">
                        Saiba Mais, clique aqui
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                        </svg>
                    </p>
                </div>
            </a>
        </div>
    </div>
</section>





{{--<section class="py-10 to-gray-50">--}}
{{--    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--        <!-- Título Principal -->--}}
{{--        <div class="text-center mb-4">--}}
{{--            <h2 class="text-2xl md:text-4xl font-bold text-white">O que é o Sistema de Cotação?</h2>--}}

{{--        </div>--}}
{{--        <!-- Grid de Características -->--}}
{{--        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-2">--}}
{{--            <!-- Card 1 - Rapidez -->--}}
{{--            <div class="bg-white p-4 rounded-xl shadow-lg hover:shadow-xl transition-shadow">--}}
{{--                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-2">--}}
{{--                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cotação Instantânea</h3>--}}
{{--                <p class="text-gray-600">Gere cotações em segundos para seus clientes. Nossa plataforma processa os dados rapidamente, permitindo respostas imediatas e aumentando suas chances de fechamento.</p>--}}
{{--            </div>--}}
{{--            <!-- Card 2 - Comparativo -->--}}
{{--            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">--}}
{{--                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">--}}
{{--                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--                <h3 class="text-xl font-semibold text-gray-900 mb-3">Comparativo Completo</h3>--}}
{{--                <p class="text-gray-600">Compare diferentes planos lado a lado, destacando benefícios e coberturas. Facilite a decisão do seu cliente com informações claras e organizadas.</p>--}}
{{--            </div>--}}
{{--            <!-- Card 3 - Personalização -->--}}
{{--            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">--}}
{{--                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">--}}
{{--                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>--}}
{{--                    </svg>--}}
{{--                </div>--}}
{{--                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cotações Personalizadas</h3>--}}
{{--                <p class="text-gray-600">Ajuste as cotações de acordo com as necessidades específicas de cada cliente, incluindo coberturas adicionais e personalizações do plano.</p>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--        <!-- Descrição Detalhada com Fluxo -->--}}
{{--        <div class="mt-6 bg-white rounded-xl shadow-lg p-4">--}}
{{--            <div class="max-w-3xl mx-auto">--}}
{{--                <h3 class="text-2xl font-bold text-gray-900 mb-4">Como Funciona?</h3>--}}
{{--                <!-- Fluxo do Processo -->--}}
{{--                <div class="space-y-4">--}}
{{--                    <!-- Passo 1 -->--}}
{{--                    <div class="flex items-start space-x-4">--}}
{{--                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">1</div>--}}
{{--                        <div>--}}
{{--                            <h4 class="text-lg font-semibold text-gray-900">Inserção de Dados</h4>--}}
{{--                            <p class="text-gray-600 mt-2">Insira os dados básicos do cliente como idade, localização e tipo de plano desejado. Nossa interface intuitiva guia você pelo processo.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Passo 2 -->--}}
{{--                    <div class="flex items-start space-x-4">--}}
{{--                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">2</div>--}}
{{--                        <div>--}}
{{--                            <h4 class="text-lg font-semibold text-gray-900">Processamento Automático</h4>--}}
{{--                            <p class="text-gray-600 mt-2">O sistema processa os dados automaticamente e consulta nossa base de planos atualizada para encontrar as melhores opções.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <!-- Passo 3 -->--}}
{{--                    <div class="flex items-start space-x-4">--}}
{{--                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">3</div>--}}
{{--                        <div>--}}
{{--                            <h4 class="text-lg font-semibold text-gray-900">Apresentação dos Resultados</h4>--}}
{{--                            <p class="text-gray-600 mt-2">Receba um comparativo profissional com todas as opções disponíveis, valores e coberturas, pronto para apresentar ao seu cliente.</p>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                </div>--}}
{{--                <!-- Benefícios -->--}}
{{--                <div class="mt-2">--}}
{{--                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Principais Benefícios:</h4>--}}
{{--                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">--}}
{{--                        <li class="flex items-center space-x-2">--}}
{{--                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-gray-600">Economia de tempo</span>--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center space-x-2">--}}
{{--                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-gray-600">Maior precisão nas cotações</span>--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center space-x-2">--}}
{{--                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-gray-600">Apresentação profissional</span>--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center space-x-2">--}}
{{--                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-gray-600">Aumento nas vendas</span>--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}




{{--<section class="py-16">--}}
{{--    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">--}}
{{--        <!-- Título Principal -->--}}
{{--        <div class="text-center mb-12">--}}
{{--            <h2 class="text-3xl md:text-4xl font-bold text-white mb-4">Fale Conosco</h2>--}}
{{--            <p class="text-white max-w-2xl mx-auto">Envie suas dúvidas ou sugestões. Estamos aqui para ajudar!</p>--}}
{{--            <div class="w-24 h-1 bg-white mx-auto mt-4"></div>--}}
{{--        </div>--}}

{{--        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 max-w-6xl mx-auto">--}}
{{--            <!-- Formulário -->--}}
{{--            <div class="bg-white rounded-xl shadow-lg p-8">--}}
{{--                <form id="suggestion-form" class="space-y-6">--}}
{{--                    <!-- Nome -->--}}
{{--                    <div>--}}
{{--                        <label for="name" class="block text-sm font-medium text-black mb-2">Nome</label>--}}
{{--                        <input type="text" id="name" name="name" required--}}
{{--                               class="w-full px-4 py-3 rounded-lg border border-black focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"--}}
{{--                               placeholder="Seu nome completo">--}}
{{--                    </div>--}}

{{--                    <!-- Email -->--}}
{{--                    <div>--}}
{{--                        <label for="email" class="block text-sm font-medium text-black mb-2">Email</label>--}}
{{--                        <input type="email" id="email" name="email" required--}}
{{--                               class="w-full px-4 py-3 rounded-lg border border-black focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"--}}
{{--                               placeholder="seu@email.com">--}}
{{--                    </div>--}}

{{--                    <!-- Assunto -->--}}
{{--                    <div>--}}
{{--                        <label for="subject" class="block text-sm font-medium text-black mb-2">Assunto</label>--}}
{{--                        <input type="text" id="subject" name="subject" required--}}
{{--                               class="w-full px-4 py-3 rounded-lg border border-black focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"--}}
{{--                               placeholder="Assunto da mensagem">--}}
{{--                    </div>--}}

{{--                    <!-- Mensagem -->--}}
{{--                    <div>--}}
{{--                        <label for="message" class="block text-sm font-medium text-black mb-2">Mensagem</label>--}}
{{--                        <textarea id="message" name="message" rows="4" required--}}
{{--                                  class="w-full px-4 py-3 rounded-lg border border-black focus:ring-2 focus:ring-amber-500 focus:border-amber-500 outline-none transition-colors"--}}
{{--                                  placeholder="Digite sua mensagem aqui..."></textarea>--}}
{{--                    </div>--}}

{{--                    <!-- Botão Enviar -->--}}
{{--                    <button type="submit"--}}
{{--                            class="w-full bg-purple-900 text-white py-3 px-6 rounded-lg hover:bg-amber-700 transition-colors duration-300 flex items-center justify-center">--}}
{{--                        <span>Enviar Mensagem</span>--}}
{{--                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" />--}}
{{--                        </svg>--}}
{{--                    </button>--}}
{{--                </form>--}}
{{--            </div>--}}

{{--            <!-- Call to Action -->--}}
{{--            <div class="flex flex-col justify-center lg:justify-start">--}}
{{--                <div class="bg-white rounded-xl shadow-lg p-8 border border-amber-200">--}}
{{--                    <h3 class="text-2xl font-bold text-black mb-4">Comece Agora Mesmo!</h3>--}}
{{--                    <p class="text-black mb-8">--}}
{{--                        Não perca mais tempo com processos manuais. Automatize suas cotações e aumente suas vendas com nossa plataforma intuitiva.--}}
{{--                    </p>--}}
{{--                    <div class="space-y-4">--}}
{{--                        <div class="flex items-center">--}}
{{--                            <svg class="w-6 h-6 text-purple-900 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-black">Cotações em segundos</span>--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <svg class="w-6 h-6 text-purple-900 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-black">Suporte especializado</span>--}}
{{--                        </div>--}}
{{--                        <div class="flex items-center">--}}
{{--                            <svg class="w-6 h-6 text-purple-900 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>--}}
{{--                            </svg>--}}
{{--                            <span class="text-black">Sem taxa de adesão</span>--}}
{{--                        </div>--}}
{{--                    </div>--}}
{{--                    <a href="#signup"--}}
{{--                       class="mt-8 bg-blue-600 text-white py-4 px-8 rounded-lg hover:bg-blue-700 transition-all transform hover:-translate-y-1 inline-flex items-center w-full justify-center">--}}
{{--                        <span>Começar Agora</span>--}}
{{--                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>--}}
{{--                        </svg>--}}
{{--                    </a>--}}
{{--                </div>--}}
{{--            </div>--}}
{{--        </div>--}}
{{--    </div>--}}
{{--</section>--}}

<footer class="text-white py-10">
    <div class="container mx-auto px-4">
        <!-- Grade Principal -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Resumo do Sistema -->
            <div>
                <h3 class="text-xl font-bold mb-4">Sobre o Sistema</h3>
                <p class="text-sm leading-6">
                    Nosso sistema é uma solução completa para gerenciar planos de saúde e parcerias com as maiores administradoras do mercado. Com foco em eficiência e simplicidade, oferecemos uma plataforma que conecta corretores e clientes de forma ágil e segura.
                </p>
            </div>

            <!-- Links para Navegação -->
            <div>
                <h3 class="text-xl font-bold mb-4">Navegação</h3>
                <ul class="space-y-2">
                    <li><a href="#galeria-administradoras" class="text-sm hover:text-blue-300 transition">Galeria de Administradoras</a></li>
                    <li><a href="#pricing" class="text-sm hover:text-blue-300 transition">Planos</a></li>
                    <li><a href="#ranking" class="text-sm hover:text-blue-300 transition">Ranking</a></li>
                    <li><a href="#contact" class="text-sm hover:text-blue-300 transition">Contato</a></li>
                </ul>
            </div>

            <!-- Links Sociais -->
            <div>
                <h3 class="text-xl font-bold mb-4">Siga-nos</h3>
                <div class="flex space-x-4">
                    <a href="#" class="hover:text-blue-300 transition">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M22.675 0H1.325C.594 0 0 .593 0 1.324v21.351C0 23.406.593 24 1.325 24h21.351C23.407 24 24 23.406 24 22.675V1.325C24 .594 23.407 0 22.675 0zm-2.406 20.736h-3.917v-6.215h3.917v6.215zm-1.958-7.107c-1.255 0-2.276-1.021-2.276-2.276s1.021-2.276 2.276-2.276 2.276 1.021 2.276 2.276-1.021 2.276-2.276 2.276zm5.835 7.107h-3.916v-6.215h3.916v6.215zm-1.958-7.107c-1.255 0-2.276-1.021-2.276-2.276s1.021-2.276 2.276-2.276 2.276 1.021 2.276 2.276-1.021 2.276-2.276 2.276zm0 0"></path>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-blue-300 transition">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M12 .296c-6.624 0-12 5.376-12 12s5.376 12 12 12 12-5.376 12-12-5.376-12-12-12zm.296 5.871h2.216v1.674h-2.216c-.549 0-.876.485-.876 1.137v1.587h2.99v1.662h-2.99v4.777h-1.674v-4.777h-1.674v-1.662h1.674v-1.587c0-1.422.936-2.603 2.55-2.603z"></path>
                        </svg>
                    </a>
                    <a href="#" class="hover:text-blue-300 transition">
                        <svg class="w-6 h-6" fill="currentColor" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                            <path d="M23.643 4.937c-.835.371-1.73.621-2.675.733a4.673 4.673 0 002.048-2.578c-.889.528-1.874.913-2.92 1.116a4.657 4.657 0 00-7.926 4.243 13.216 13.216 0 01-9.603-4.863 4.657 4.657 0 001.446 6.216 4.632 4.632 0 01-2.11-.584v.06c0 2.256 1.604 4.14 3.735 4.567-.391.104-.801.159-1.222.159-.3 0-.593-.03-.878-.085a4.661 4.661 0 004.348 3.233 9.328 9.328 0 01-6.88 1.935 13.14 13.14 0 007.13 2.087c8.556 0 13.228-7.083 13.228-13.228 0-.202-.005-.403-.015-.604.906-.656 1.692-1.475 2.313-2.41z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Linha de Direitos -->
        <div class="mt-8 text-center text-sm text-gray-400">
            &copy; {{ date('Y') }} - Todos os direitos reservados. Criado por BmSys.
        </div>
    </div>
</footer>

<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('toastr.min.js')}}"></script>
<script>
    function openVideoModal() {
        // Mostrar o loader
        document.querySelector('.ajax_load').style.display = 'flex';

        // Criar um elemento de imagem temporário para garantir que a mídia foi carregada
        let demoImage = new Image();
        demoImage.src = "{{asset('demonstracao.gif')}}"; // Ajuste caso seja um vídeo

        demoImage.onload = function() {
            // Esconder o loader
            document.querySelector('.ajax_load').style.display = 'none';

            // Exibir o modal
            document.getElementById('videoModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');
        };
    }

    function closeVideoModal() {
        document.getElementById('videoModal').classList.add('hidden');
        document.body.classList.remove('overflow-hidden');
    }

    // Fechar modal ao clicar fora
    document.getElementById('videoModal').addEventListener('click', function(e) {
        if(e.target === this) closeVideoModal();
    });


    document.addEventListener("DOMContentLoaded", () => {

        const smoothScrollLinks = document.querySelectorAll('a[href="#pricing"]');
        smoothScrollLinks.forEach(link => {
            link.addEventListener("click", (event) => {
                event.preventDefault(); // Evita que o comportamento padrão de adicionar #pricing à URL aconteça
                const targetSection = document.querySelector("#pricing");
                if (targetSection) {
                    targetSection.scrollIntoView({
                        behavior: "smooth",
                        block: "start",
                    });
                }
            });
        });


        document.getElementById('suggestion-form').addEventListener('submit', function (e) {
            e.preventDefault();

            // Obter os dados do formulário
            const formData = new FormData(this);

            // Enviar via AJAX
            fetch('{{ route('send.suggestion') }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: formData,
            })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        toastr.success(data.message, 'Sucesso');
                        document.getElementById('suggestion-form').reset(); // Limpar formulário
                    } else {
                        toastr.error('Ocorreu um erro. Tente novamente.', 'Erro');
                    }
                })
                .catch(error => {
                    toastr.error('Ocorreu um erro. Tente novamente.', 'Erro');
                });
        });
    });
</script>
</body>
</html>
