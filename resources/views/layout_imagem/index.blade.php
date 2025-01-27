<x-app-layout>
    <div class="container mx-auto mt-6">
        <h1 class="text-4xl font-bold mb-4 text-black p-2 rounded-lg text-center border-purple-600 bg-gray-100">Escolha o Layout</h1>

        <!-- Feedback de Sucesso -->
        @if(session('success'))
            <div class="p-4 mb-4 text-green-800 bg-green-100 border border-green-200 rounded text-center">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{route('layouts.select')}}" method="POST">
            @csrf
            <!-- Grade com 4 colunas -->
            <div class="grid grid-cols-4 gap-4">
                @foreach($layouts as $layout)
                    <div class="relative border border-gray-300 rounded-lg hover:shadow-md transition">
                        <!-- Input para seleção -->
                        <input type="radio" id="layout_{{ $layout->id }}"
                               name="layout_id"
                               value="{{ $layout->id }}"
                               {{ $layout->id == $user->layout_id ? 'checked' : '' }}
                               class="absolute top-2 right-2 cursor-pointer">
                        <!-- Imagem -->
                        <img src="{{ asset($layout->imagem) }}"
                             alt="{{ $layout->nome }}"
                             class="w-[70%] flex self-center mx-auto h-80 rounded-md cursor-pointer transition-transform duration-300"
                             onclick="zoomImage(this)">
                        <!-- Nome do layout -->
                        <p class="mt-2 text-center font-medium text-white">{{ $layout->nome }}</p>
                    </div>
                @endforeach
            </div>

            <!-- Botão de salvar -->
            <button type="submit" class="mt-4 px-6 py-2 bg-gray-100 text-black border-purple-600 rounded hover:bg-gray-200 w-full"
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
