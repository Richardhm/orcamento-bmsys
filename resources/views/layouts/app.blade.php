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
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
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
    </style>
</head>
<body class="font-sans antialiased">
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
