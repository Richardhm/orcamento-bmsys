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


        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .container_formulario {
                background:rgba(254,254,254,0.18);
                backdrop-filter: blur(15px);
            }
        </style>


    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div id="app-container" class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gray-100 dark:bg-gray-900">
            <div class="container_formulario w-full sm:max-w-md mt-6 px-6 py-4 dark:bg-[rgba(254,254,254,0.18)] bg-transparent dark:backdrop-blur-[15px] dark:border-white dark:border-2 shadow-md overflow-hidden sm:rounded-lg">
                {{ $slot }}
            </div>
        </div>
        <script src="{{asset('jquery.min.js')}}"></script>
        <script src="{{asset('jquery.inputmask.min.js')}}"></script>
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
