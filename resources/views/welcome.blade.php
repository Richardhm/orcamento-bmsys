<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Cotações de Plano de Saúde</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{asset('toastr.min.css')}}">
    <style>
        #demoVideo {
            max-height: 80vh;
            background: #000;
        }
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

        @media (max-width: 768px) {
            /* Ajustes para navbar */
            nav .flex.justify-between {
                /*flex-direction: column;*/
                /*height: auto;*/
                /*padding: 10px 0;*/

            }

            .absolute.left-1\/2 {
                position: relative;
                left: 0;
                transform: none;
                text-align: center;
                margin: 10px 0;
            }

            .flex.space-x-4 {
                flex-wrap: wrap;
                justify-content: center;
                gap: 10px;
            }

            /* Ajustes hero section */
            #imagem-dobra .grid-cols-1 {
                gap: 30px;
            }

            #imagem-dobra h1 {
                font-size: 2rem;
                text-align: center;
            }

            #imagem-dobra .flex.justify-between {
                flex-direction: column;
                gap: 20px;
                text-align: center;
            }

            /* Ajustes seção de preços */
            #pricing .flex.flex-1 {
                flex-direction: column;
                align-items: center;
            }

            #pricing .max-w-5xl {
                width: 90%!important;
            }

            #pricing h2 {
                font-size: 2.5rem;
            }

            /* Footer ajustes */
            footer .grid-cols-3 {
                grid-template-columns: 1fr;
                gap: 30px;
                text-align: center;
            }

            footer .flex.space-x-4 {
                justify-content: center;
            }

            /* Ajustes gerais de tamanho */
            .text-4xl { font-size: 1.8rem; }
            .text-6xl { font-size: 2.5rem; }
            .text-7xl { font-size: 3rem; }


            #imagem-dobra {
                padding-top: 6rem; /* 96px - ajuste conforme necessário */
            }

            /* Opcional: ajustar altura mínima se necessário */
            #imagem-dobra {
                min-height: calc(100vh - 6rem);
            }
        }

        @media (max-width: 480px) {
            /* Ajustes finos para telas pequenas */
            .bg-red-600, .bg-white {
                padding: 8px 15px;
                font-size: 0.9rem;
            }

            .w-\[320px\] {
                width: 100%!important;
                max-width: 320px;
            }

            #imagem-dobra .scale-75 {
                scale: 0.6;

            }


            .h-16.p-1 {
                height: 50px;
            }
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
        <div class="flex flex-row justify-between items-center py-4">
            <!-- Logo -->
            <div>
                <img src="{{asset('logo_bm_1.png')}}" alt="Logo" class="h-12 md:h-16 p-1">
            </div>

            <!-- Título Centralizado -->
            <div class="hidden md:block absolute left-1/2 transform -translate-x-1/2">
                <h1 class="text-2xl md:text-4xl font-bold text-white text-center">Sistema Orçamento</h1>
            </div>

            <!-- Botões Direita -->
            <div class="flex items-center space-x-2 md:space-x-4">
                <a href="#pricing" class="bg-red-600 text-white px-4 py-2 text-sm md:px-6 md:py-2 rounded-full hover:bg-red-900 transition-colors hidden md:inline-block">
                    Assine Agora
                </a>
                <a href="{{route('login')}}" class="bg-white text-black px-4 py-2 text-sm md:px-6 md:py-2 rounded-full hover:bg-gray-900 hover:text-white transition-colors">
                    Login
                </a>
                <div>
                    <img src="{{asset('hapvida-notreDame_baixa_1.png')}}" alt="Hapvida">
                </div>
            </div>

        </div>
    </div>
</nav>


<div id="videoModal" class="hidden fixed inset-0 z-50 bg-black/90 flex items-center justify-center p-4 backdrop-blur-sm">
    <div class="relative w-full max-w-4xl">
        <button onclick="closeVideoModal()" class="absolute -top-8 right-0 text-white text-2xl hover:text-gray-300">
            &times;
        </button>
        <video id="demoVideo" controls class="w-full h-auto rounded-lg shadow-2xl">
            <source src="{{asset('demonstracao.mp4')}}" type="video/mp4">
            Seu navegador não suporta vídeos HTML5.
        </video>
    </div>
</div>



<section id="imagem-dobra" class="relative min-h-screen flex items-center justify-center pt-24 md:pt-16 pb-20 overflow-hidden">
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
            <div class="relative group cursor-pointer w-[70%] md:mt-10" onclick="openVideoModal()">
                <div class="relative rounded-xl overflow-hidden shadow-2xl transform group-hover:scale-90 transition-transform">
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

        </div>
    </div>
</section>

<section id="pricing" class="min-h-screen flex flex-col justify-center py-12 md:py-18">
    <div class="max-w-5xl w-full md:w-[90%] mx-auto px-4">
        <div class="text-center mb-8">
            <h2 class="text-4xl md:text-6xl font-bold text-white mb-4">Nossos Planos</h2>
            <p class="text-xl md:text-4xl text-white font-bold">Escolha o plano ideal</p>
        </div>

        <div class="flex flex-col md:flex-row gap-6 justify-center items-stretch">
            <!-- Plano Individual -->
{{--            <a href="{{route('assinaturas.individual.create')}}" class="bg-white w-full md:w-[320px] rounded-xl shadow-lg p-4 md:p-6 border border-blue-100 transition-all hover:bg-gray-100">--}}
{{--                <div>--}}
{{--                    <div>--}}
{{--                        <p class="text-purple-900 text-center font-bold text-lg">INDIVIDUAL</p>--}}
{{--                        <p class="text-purple-900 text-center">Ideal para uma única pessoa</p>--}}
{{--                    </div>--}}
{{--                    <div class="bg-purple-950 text-white text-center py-3 rounded-full mt-6">--}}
{{--                        Começar Agora--}}
{{--                    </div>--}}
{{--                    <div class="my-6 text-center flex items-center justify-center">--}}
{{--                        <p class="flex flex-col items-start relative">--}}
{{--                            <span class="text-lg font-bold text-purple-900 leading-none">R$</span>--}}
{{--                            <span class="text-7xl font-bold text-purple-900">29,90</span>--}}
{{--                            <span class="text-sm text-purple-900 self-end">/mês</span>--}}
{{--                        </p>--}}
{{--                    </div>--}}

{{--                    <ul class="space-y-2 text-gray-600 text-sm">--}}
{{--                        <li class="flex items-center">--}}
{{--                            ✅ Acesso ao sistema--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center">--}}
{{--                            ✅ Cotações ilimitadas--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center">--}}
{{--                            ✅ Fácil de usar--}}
{{--                        </li>--}}
{{--                        <li class="flex items-center">--}}
{{--                            ✅ Apenas um e-mail--}}
{{--                        </li>--}}
{{--                    </ul>--}}
{{--                </div>--}}

{{--                <div>--}}
{{--                    <p class="text-center text-gray-500 flex justify-center items-center text-sm">--}}
{{--                        Saiba Mais, clique aqui--}}
{{--                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">--}}
{{--                            <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />--}}
{{--                        </svg>--}}
{{--                    </p>--}}
{{--                </div>--}}

{{--            </a>--}}

            <!-- Plano Empresarial -->
            <a href="{{route('assinaturas.empresarial.create')}}" class="bg-white w-full md:w-[320px] rounded-xl shadow-lg p-4 md:p-6 border-4 border-orange-400 transition-all hover:bg-gray-100">
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
                            <span class="text-7xl font-bold text-purple-900">250,00</span>
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

<footer class="text-white py-10 px-4">
    <div class="container mx-auto px-4">
        <!-- Grade Principal -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
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
            &copy; {{ date('Y') }} - Todos os direitos reservados. Criado por BmSyS.
        </div>
    </div>
</footer>

<script src="{{asset('jquery.min.js')}}"></script>
<script src="{{asset('toastr.min.js')}}"></script>
<script>
    function openVideoModal() {
        const video = document.getElementById('demoVideo');

        // Mostrar o loader
        document.querySelector('.ajax_load').style.display = 'flex';

        // Carregar o vídeo
        video.load();

        video.onloadeddata = function() {
            // Esconder o loader
            document.querySelector('.ajax_load').style.display = 'none';

            // Exibir o modal
            document.getElementById('videoModal').classList.remove('hidden');
            document.body.classList.add('overflow-hidden');

            // Iniciar reprodução
            video.play().catch(error => {
                console.log('Reprodução automática bloqueada pelo navegador');
            });
        };
    }

    function closeVideoModal() {
        const video = document.getElementById('demoVideo');
        video.pause();
        video.currentTime = 0;
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
