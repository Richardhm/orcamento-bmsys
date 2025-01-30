<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" id="html" class="dark">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    <script src="{{asset('jquery.min.js')}}"></script>
    <script src="{{asset('sweetalert2@11.js')}}"></script>
    <link rel="stylesheet" href="{{asset('toastr.min.css')}}">
    <script src="{{asset('toastr.min.js')}}"></script>
    <script src="{{asset('jquery.inputmask.min.js')}}"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script>
        toastr.options = {
            closeButton: true,
            progressBar: true,
            timeOut: 5000, // Tempo de exibição (5 segundos)
            positionClass: "toast-top-center", // Ainda usamos uma posição padrão
            onShown: function() {
                $("#toast-container").addClass("custom-toast-center");
            }
        };
    </script>
    <style>
        #user-modal {
            opacity: 0; /* Inicialmente invisível */
            transform: translateX(100%);
            transition: transform 0.5s ease-in-out, opacity 0.5s ease-in-out;
        }
        #user-modal.translate-x-0 {
            opacity: 1; /* Tornar visível */
            transform: translateX(0);
        }
        #toast-container {
            top: 10% !important;
            left: 50% !important;
            transform: translate(-50%, -50%) !important;
            width:500px !important;
            position: fixed !important;
        }
        .ajax_load {display:none;position:fixed;left:0;top:0;width:100%;height:100%;background:rgba(0,0,0,.5);z-index:1000;}
        .ajax_load_box{margin:auto;text-align:center;color:#fff;font-weight:var(700);text-shadow:1px 1px 1px rgba(0,0,0,.5)}
        .ajax_load_box_circle{border:16px solid #e3e3e3;border-top:16px solid #61DDBC;border-radius:50%;margin:auto;width:80px;height:80px;-webkit-animation:spin 1.2s linear infinite;-o-animation:spin 1.2s linear infinite;animation:spin 1.2s linear infinite}
        @-webkit-keyframes spin{0%{-webkit-transform:rotate(0deg)}100%{-webkit-transform:rotate(360deg)}}
        @keyframes spin{0%{transform:rotate(0deg)}100%{transform:rotate(360deg)}}
    </style>
</head>
<body class="font-sans antialiased">
<div class="ajax_load">
    <div class="ajax_load_box">
        <div class="ajax_load_box_circle"></div>
        <p class="ajax_load_box_title">Aguarde, carregando...</p>
    </div>
</div>
<!-- Container principal -->
<div id="app-container" class="min-h-screen transition-all duration-300">
    @include('layouts.navigation')

    <!-- Conteúdo da página -->
    <main>
        {{ $slot }}
    </main>
</div>

<!-- Script para aplicar lógica de tema -->
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
