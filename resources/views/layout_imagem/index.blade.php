<x-app-layout>
    <div class="container mx-auto mt-6 px-4">
        <h1 class="text-3xl sm:text-4xl font-bold mb-4 text-black p-2 rounded-lg text-center border-purple-600 bg-gray-100">
            Escolha o Layout
        </h1>

        <!-- Feedback de Sucesso -->
        @if(session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-200 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{route('layouts.select')}}" method="POST">
            @csrf
            <!-- Grade responsiva -->
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($layouts as $layout)
                    <label class="relative border border-gray-300 rounded-lg hover:shadow-md transition p-4 flex flex-col items-center cursor-pointer">
                        <!-- Input para seleção destacado -->
                        <input type="radio" id="layout_{{ $layout->id }}"
                               name="layout_id"
                               value="{{ $layout->id }}"
                               {{ $layout->id == $user->layout_id ? 'checked' : '' }}
                               class="w-5 h-5 text-purple-600 focus:ring-2 focus:ring-offset-2 focus:ring-purple-500 cursor-pointer mb-2">

                        <!-- Imagem -->
                        <img src="{{ asset($layout->imagem) }}"
                             alt="{{ $layout->nome }}"
                             class="w-full h-80 sm:h-72 md:h-80 rounded-md transition-transform duration-300">

                        <!-- Nome do layout -->
                        <p class="mt-2 text-center font-medium text-gray-900">{{ $layout->nome }}</p>
                    </label>
                @endforeach
            </div>

            <!-- Botão de salvar -->
            <button type="submit" class="mt-6 px-6 py-3 bg-gray-100 text-black border-purple-600 rounded hover:bg-gray-200 w-full font-semibold text-lg"
                    style="border-width: 5px;">
                Salvar Seleção
            </button>
        </form>
    </div>
    <script>
        function zoomImage(img) {
            img.classList.toggle('zoomed');
        }
    </script>

    <style>
        .zoomed {
            transform: scale(1.5);
            z-index: 50;
            position: relative;
            border: 4px solid #4A90E2;
        }
        .zoomed:hover {
            transform: scale(1.5);
        }
        .zoomed ~ p {
            opacity: 0.5;
        }
    </style>
</x-app-layout>
