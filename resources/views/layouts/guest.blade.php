<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="{{asset('jquery.min.js')}}"></script>
    <script src="{{asset('jquery.inputmask.min.js')}}"></script>
    <link rel="stylesheet" href="{{asset('toastr.min.css')}}">
    <script src="{{asset('toastr.min.js')}}"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: 5000, // Tempo de exibição (5 segundos)
            positionClass: "toast-top-center", // Ainda usamos uma posição padrão
            onShown: function() {
                $(".toast").css("width", "500px");
                $("#toast-container").addClass("custom-toast-center");
            }
        };
    </script>
    <style>
        .container_formulario {
            background:rgba(254,254,254,0.18);
            backdrop-filter: blur(15px);
        }
        .container_formulario.login {
            width: 390px;
        }
        .container_formulario.cadastro {
            width:950px;
        }
        #toast-container {
            width: 500px !important; /* Ajuste conforme necessário */
            max-width: 100%; /* Evita que fique maior que a tela */
            word-wrap: break-word; /* Quebra texto longo */
        }
        #toast-container > .toast {
            width: 500px !important; /* Ajuste conforme necessário */
            max-width: 100%; /* Evita que fique maior que a tela */
            word-wrap: break-word; /* Quebra texto longo */
        }
        #toast-container > div {
            min-width: 500px !important; /* Aumenta a largura mínima */
            max-width: 600px !important; /* Ajuste conforme necessário */
            word-wrap: break-word; /* Quebra o texto longo */
        }
        .ajax_load {display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;}
        .ajax_load_box{margin:auto;text-align:center;color:#fff;font-weight:var(700);text-shadow:1px 1px 1px rgba(0,0,0,.5)}
        .ajax_load_box_circle{border:16px solid #e3e3e3;border-top:16px solid #61DDBC;border-radius:50%;margin:auto;width:80px;height:80px;-webkit-animation:spin 1.2s linear infinite;-o-animation:spin 1.2s linear infinite;animation:spin 1.2s linear infinite}
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}

        @media (max-width: 768px) {
            .container_formulario.cadastro {
                width: 100% !important;
                margin: 0 10px;
                padding: 10px;
            }

            fieldset {
                margin-bottom: 1rem;
            }

            input, select {
                font-size: 14px !important;
                padding: 8px !important;
            }

            #cartao {
                height: 180px !important;
                margin-top: 1rem !important;
            }
        }





    </style>
    <script type='text/javascript'>var s=document.createElement('script');s.type='text/javascript';var v=parseInt(Math.random()*1000000);s.src='https://cobrancas-h.api.efipay.com.br/v1/cdn/3c8b1529ac6f42b8d524cce476dca9ab/'+v;s.async=false;s.id='3c8b1529ac6f42b8d524cce476dca9ab';if(!document.getElementById('3c8b1529ac6f42b8d524cce476dca9ab')){document.getElementsByTagName('head')[0].appendChild(s);};$gn={validForm:true,processed:false,done:{},ready:function(fn){$gn.done=fn;}};</script>
</head>
<body class="font-sans text-gray-900 antialiased">
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>
<div id="app-container" class="min-h-screen flex flex-col sm:justify-center items-center sm:pt-0 bg-gray-100 dark:bg-gray-900">
    <div class="container_formulario {{ (request()->routeIs('login')) ? 'login' : ((request()->routeIs('assinaturas.individual.create') || request()->routeIs('assinaturas.empresarial.create')) ? 'cadastro' : '') }} w-full mt-1 px-2 py-1 dark:bg-[rgba(254,254,254,0.18)] bg-transparent dark:backdrop-blur-[15px] dark:border-white dark:border-2 shadow-md overflow-hidden sm:rounded-lg">
        {{ $slot }}
    </div>
</div>
<script>
    // Verifica se o tema é dark ou light e aplica a lógica
    const htmlElement = document.getElementById('html');
    const appContainer = document.getElementById('app-container');
    function applyThemeBackground() {
        if (htmlElement.classList.contains('dark')) {
            // Modo dark: fundo preto
            appContainer.style.background = '#000';
        } else {
            // Modo light: fundo com imagem
            appContainer.style.background = "url('{{ asset('fred01.jpeg') }}') no-repeat center center";
            appContainer.style.backgroundSize = 'cover';
        }
    }
    // Executa ao carregar a página
    applyThemeBackground();
    // Observa mudanças no tema (se for implementado com toggle)
    const observer = new MutationObserver(applyThemeBackground);
    observer.observe(htmlElement, { attributes: true, attributeFilter: ['class'] });
</script>
@yield('scripts')
</body>
</html>
