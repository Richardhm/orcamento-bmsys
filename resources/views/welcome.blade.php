<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotações de Plano de Saúde</title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/particles.js/2.0.0/particles.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css"/>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-black">
<!-- Navbar -->
<nav class="fixed w-full z-50 bg-black/80 backdrop-blur-md border-b border-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between h-16">
            <div class="flex-shrink-0 flex items-center">
                <span class="text-white text-xl font-bold">Sistema de Cotaçãoooooo</span>
            </div>
            <div class="hidden md:flex items-center space-x-8">
                <a href="{{route('login')}}" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Login</a>
                <a href="{{route('login')}}" class="bg-yellow-500 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors">Saiba Mais</a>
            </div>
        </div>
    </div>
</nav>

<!-- Background Particles -->
<div id="particles-js" class="fixed inset-0 z-0"></div>

<section class="relative min-h-screen pt-16 overflow-hidden" style="background-color: #f5f5f5; background-image: linear-gradient(rgba(0, 0, 0, 0.92), rgba(0, 0, 0, 0.92)), url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%23ffffff' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E");">
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 pt-20">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
        <!-- Left Column - Content -->
        <div class="text-white z-10" data-aos="fade-right">
            <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold leading-tight mb-6">
                Revolucione suas Cotações de Plano de Saúde
            </h1>
            <p class="text-gray-300 text-lg md:text-xl mb-8">
                Crie orçamentos profissionais em poucos cliques. Economize tempo e feche mais vendas com nossa plataforma intuitiva.
            </p>
            <div class="flex flex-wrap gap-4">
                <a href="#pricing" class="bg-blue-600 w-full text-center text-white px-8 py-4 rounded-lg hover:bg-blue-700 transition-all transform hover:-translate-y-1 inline-flex items-center">
                    <p class="w-full text-center flex justify-center items-center">
                        Começar Agora
                        <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                        </svg>
                    </p>
                </a>
                <img src="{{asset('demonstracao.gif')}}" alt="Demonstração">
            </div>
            <!-- Metrics -->
            <div class="grid grid-cols-3 gap-8 mt-12">
                <div>
                    <h4 class="text-3xl font-bold text-blue-500">+1000</h4>
                    <p class="text-gray-400">Corretores Ativos</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-blue-500">30s</h4>
                    <p class="text-gray-400">Tempo Médio de Cotação</p>
                </div>
                <div>
                    <h4 class="text-3xl font-bold text-blue-500">98%</h4>
                    <p class="text-gray-400">Satisfação</p>
                </div>
            </div>
        </div>

        <!-- Right Column - Video -->
        <div class="relative" data-aos="fade-left">
            <img src="{{asset('tela.png')}}" alt="Tela" title="Tela" class="w-full h-[80%] object-cover"/>
            <div class="absolute top-0 left-0 w-full h-full bg-gray-400 opacity-10"></div>
        </div>
    </div>
</div>
<!-- Decorative Elements -->
<div class="absolute bottom-0 inset-x-0 h-64 bg-gradient-to-t from-black/95 to-transparent"></div>
</section>

<section id="arguments" class="h-screen bg-gray-100 text-gray-800">
    <div class="h-full flex flex-col justify-start items-center px-8 pt-12">
        <!-- Título da seção -->
        <h2 class="text-4xl font-bold mb-10 text-center">Por que escolher nosso sistema?</h2>
        <!-- Argumentos -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8 w-full max-w-7xl">
            <!-- Card 1 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Alta Performance</h3>
                <p>Tudo o que você e seu time precisam para trabalhar, na palma da sua mão, de qualquer lugar e a qualquer momento, à sua disposição.</p>
            </div>
            <!-- Card 2 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Agilidade</h3>
                <p>Envie cotações em 1 minuto direto no WhatsApp ou e-mail do seu cliente. Nosso time mantém todas tabelas atualizadas para você.</p>
            </div>
            <!-- Card 3 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Mais Credibilidadesssss</h3>
                <p>Entregue cotações com apresentação profissional ao seu cliente e saia na frente de seus concorrentes.</p>
            </div>
            <!-- Card 4 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Precisão</h3>
                <p>Dados consistentes para evitar erros.</p>
            </div>
            <!-- Card 5 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Personalização</h3>
                <p>Ajuste cotações para atender a cada cliente.</p>
            </div>
            <!-- Card 6 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Suporte Dedicado</h3>
                <p>Nossa equipe está disponível para ajudá-lo sempre que precisar, garantindo a continuidade do seu trabalho.</p>
            </div>
            <!-- Card 7 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Segurança</h3>
                <p>Seus dados estão protegidos com as melhores práticas de segurança digital.</p>
            </div>
            <!-- Card 8 -->
            <div class="flex flex-col items-center text-center bg-white p-8 shadow-xl rounded-lg min-h-[16rem]">
                <h3 class="text-2xl font-semibold mb-4">Economia</h3>
                <p>Reduza os custos operacionais e foque no que importa: vender mais e melhor.</p>
            </div>
        </div>
    </div>
</section>

<section id="pricing" class="h-screen flex items-center justify-center bg-blue-500 text-white text-center">
    <div>
        <h2 class="text-3xl lg:text-5xl font-bold">Planos Acessíveis</h2>
        <div class="mt-8 flex flex-col lg:flex-row gap-6 justify-center">
            <div class="bg-white text-blue-500 rounded-lg shadow-lg p-6 w-72">
                <h3 class="text-2xl font-semibold">Plano Individual</h3>
                <p class="text-4xl font-bold mt-4">R$ 29,90/mês</p>
                <ul class="mt-4 text-left">
                    <li>- Acesso ao sistema.</li>
                    <li>- Cotações ilimitadas.</li>
                    <li>- Fácil de usar.</li>
                </ul>
                <button class="mt-6 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Assinar
                </button>
            </div>
            <div class="bg-white text-blue-500 rounded-lg shadow-lg p-6 w-72">
                <h3 class="text-2xl font-semibold">Plano Empresarial</h3>
                <p class="text-4xl font-bold mt-4">R$ 150,99/mês</p>
                <ul class="mt-4 text-left">
                    <li>- Equipes colaborativas.</li>
                    <li>- Gestão completa.</li>
                    <li>- Relatórios detalhados.</li>
                    <li>- Cadastrar até 10 email.</li>
                </ul>
                <button class="mt-6 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Assinar
                </button>
            </div>
            <div class="bg-white text-blue-500 rounded-lg shadow-lg p-6 w-72">
                <h3 class="text-2xl font-semibold">Plano Premium</h3>
                <p class="text-4xl font-bold mt-4">R$ 239,99/mês</p>
                <ul class="mt-4 text-left">
                    <li>- Equipes colaborativas.</li>
                    <li>- Gestão completa.</li>
                    <li>- Relatórios detalhados.</li>
                    <li>- Cadastro email iliminado.</li>
                </ul>
                <button class="mt-6 bg-blue-500 text-white py-2 px-4 rounded-lg hover:bg-blue-600">
                    Assinar
                </button>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-br from-white to-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título Principal -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-900 mb-4">O que é o Sistema de Cotação?</h2>
            <div class="w-24 h-1 bg-blue-600 mx-auto"></div>
        </div>

        <!-- Grid de Características -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mt-12">
            <!-- Card 1 - Rapidez -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cotação Instantânea</h3>
                <p class="text-gray-600">Gere cotações em segundos para seus clientes. Nossa plataforma processa os dados rapidamente, permitindo respostas imediatas e aumentando suas chances de fechamento.</p>
            </div>

            <!-- Card 2 - Comparativo -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Comparativo Completo</h3>
                <p class="text-gray-600">Compare diferentes planos lado a lado, destacando benefícios e coberturas. Facilite a decisão do seu cliente com informações claras e organizadas.</p>
            </div>

            <!-- Card 3 - Personalização -->
            <div class="bg-white p-6 rounded-xl shadow-lg hover:shadow-xl transition-shadow">
                <div class="bg-blue-100 w-12 h-12 rounded-lg flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"/>
                    </svg>
                </div>
                <h3 class="text-xl font-semibold text-gray-900 mb-3">Cotações Personalizadas</h3>
                <p class="text-gray-600">Ajuste as cotações de acordo com as necessidades específicas de cada cliente, incluindo coberturas adicionais e personalizações do plano.</p>
            </div>
        </div>

        <!-- Descrição Detalhada com Fluxo -->
        <div class="mt-16 bg-white rounded-xl shadow-lg p-8">
            <div class="max-w-3xl mx-auto">
                <h3 class="text-2xl font-bold text-gray-900 mb-6">Como Funciona?</h3>

                <!-- Fluxo do Processo -->
                <div class="space-y-8">
                    <!-- Passo 1 -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">1</div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Inserção de Dados</h4>
                            <p class="text-gray-600 mt-2">Insira os dados básicos do cliente como idade, localização e tipo de plano desejado. Nossa interface intuitiva guia você pelo processo.</p>
                        </div>
                    </div>

                    <!-- Passo 2 -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">2</div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Processamento Automático</h4>
                            <p class="text-gray-600 mt-2">O sistema processa os dados automaticamente e consulta nossa base de planos atualizada para encontrar as melhores opções.</p>
                        </div>
                    </div>

                    <!-- Passo 3 -->
                    <div class="flex items-start space-x-4">
                        <div class="flex-shrink-0 bg-blue-500 text-white rounded-full w-8 h-8 flex items-center justify-center font-bold">3</div>
                        <div>
                            <h4 class="text-lg font-semibold text-gray-900">Apresentação dos Resultados</h4>
                            <p class="text-gray-600 mt-2">Receba um comparativo profissional com todas as opções disponíveis, valores e coberturas, pronto para apresentar ao seu cliente.</p>
                        </div>
                    </div>
                </div>

                <!-- Benefícios -->
                <div class="mt-12">
                    <h4 class="text-lg font-semibold text-gray-900 mb-4">Principais Benefícios:</h4>
                    <ul class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-600">Economia de tempo</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-600">Maior precisão nas cotações</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-600">Apresentação profissional</span>
                        </li>
                        <li class="flex items-center space-x-2">
                            <svg class="w-5 h-5 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <span class="text-gray-600">Aumento nas vendas</span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="py-16 bg-gradient-to-br from-amber-50 to-amber-100/50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Título Principal -->
        <div class="text-center mb-12">
            <h2 class="text-3xl md:text-4xl font-bold text-amber-900 mb-4">Perguntas Frequentes (F.A.Q)</h2>
            <p class="text-amber-800 max-w-2xl mx-auto">Encontre respostas para as dúvidas mais comuns sobre nosso sistema de cotação.</p>
            <div class="w-24 h-1 bg-amber-700 mx-auto mt-4"></div>
        </div>

        <!-- Container de Perguntas e Respostas -->
        <div class="max-w-3xl mx-auto space-y-4">
            <!-- Pergunta 1 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">Como faço para começar a usar o sistema?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    Basta se cadastrar em nossa plataforma, preencher seus dados profissionais e fazer a verificação da sua corretora. Após a aprovação, você terá acesso imediato a todas as funcionalidades do sistema.
                </div>
            </div>

            <!-- Pergunta 2 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">Quanto tempo leva para gerar uma cotação?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    O processo de cotação é instantâneo. Após inserir os dados do cliente, você receberá as opções de planos em segundos. O relatório completo com comparativos fica pronto em menos de 1 minuto.
                </div>
            </div>

            <!-- Pergunta 3 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">Quais operadoras estão disponíveis no sistema?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    Trabalhamos com as principais operadoras do mercado. Nossa base é atualizada constantemente e inclui todas as operadoras com atuação nacional e as principais operadoras regionais.
                </div>
            </div>

            <!-- Pergunta 4 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">Como são calculadas as comissões?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    As comissões são calculadas automaticamente com base nas tabelas atualizadas de cada operadora. O sistema mostra o valor da sua comissão em tempo real durante a cotação.
                </div>
            </div>

            <!-- Pergunta 5 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">Posso personalizar os relatórios para meus clientes?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    Sim! Você pode personalizar os relatórios com sua logo, cores e informações de contato. Também é possível escolher quais informações serão exibidas no comparativo.
                </div>
            </div>

            <!-- Pergunta 6 -->
            <div class="bg-amber-50 rounded-lg shadow-md hover:shadow-lg transition-shadow border border-amber-200">
                <button class="w-full text-left px-6 py-4 focus:outline-none flex justify-between items-center">
                    <span class="font-semibold text-amber-900">O sistema funciona em dispositivos móveis?</span>
                    <svg class="w-5 h-5 text-amber-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </button>
                <div class="px-6 pb-4 text-amber-800">
                    Sim, nossa plataforma é 100% responsiva e funciona perfeitamente em smartphones e tablets. Você pode fazer cotações de qualquer lugar, a qualquer momento.
                </div>
            </div>
        </div>

        <!-- Suporte Adicional -->
        <div class="mt-12 text-center">
            <p class="text-amber-800">Não encontrou o que procurava?</p>
            <a href="#contact" class="inline-flex items-center text-amber-700 hover:text-amber-800 mt-2">
                Entre em contato com nosso suporte
                <svg class="w-5 h-5 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"/>
                </svg>
            </a>
        </div>
    </div>
</section>








<script>
    // Inicializa as animações AOS
    AOS.init({
        duration: 1000,
        once: true
    });

    // Configuração do Particles.js
    particlesJS("particles-js", {
        particles: {
            number: {
                value: 80,
                density: {
                    enable: true,
                    value_area: 800
                }
            },
            color: {
                value: "#4B5563"
            },
            shape: {
                type: "circle"
            },
            opacity: {
                value: 0.5,
                random: false
            },
            size: {
                value: 3,
                random: true
            },
            line_linked: {
                enable: true,
                distance: 150,
                color: "#4B5563",
                opacity: 0.4,
                width: 1
            },
            move: {
                enable: true,
                speed: 2,
                direction: "none",
                random: false,
                straight: false,
                out_mode: "out",
                bounce: false
            }
        },
        interactivity: {
            detect_on: "canvas",
            events: {
                onhover: {
                    enable: true,
                    mode: "grab"
                },
                onclick: {
                    enable: true,
                    mode: "push"
                },
                resize: true
            }
        },
        retina_detect: true
    });
</script>
</body>
</html>
