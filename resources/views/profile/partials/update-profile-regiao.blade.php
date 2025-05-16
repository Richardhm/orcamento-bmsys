<section>
    <header class="w-full">
        <div class="w-full flex justify-between items-center">
            <div class="flex flex-col">
                <h2 class="text-sm font-medium text-gray-900 dark:text-gray-100">
                    {{ __('Região de Preferencia') }}
                </h2>
                <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                    {{ __("Você tem uma região de Preferência?") }}
                </p>

            </div>


        </div>
    </header>

    @if (session('status'))
        <div class="mt-2 text-sm text-green-600">
            {{ session('status') }}
        </div>
    @endif

    <div class="flex lg:flex-row items-start lg:items-center mt-2 w-full">

        <form id="profileRegiao" method="post" action="{{ route('profile.regiao') }}" class="mt-1 space-y-6 w-full">
            @csrf
            <div>
                <label for="regiao" class="block text-sm font-medium text-gray-700 mb-1">Região (UF)</label>
                <select name="regiao" id="regiao"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
           text-gray-700 bg-white">
                    <option value="" disabled selected>Selecione um UF</option>
                    @foreach($cidades as $uf => $grupo)
                        <option value="{{ $uf }}" {{ auth()->user()->uf_preferencia === $uf ? 'selected' : '' }}>{{ $uf }}</option>

                    @endforeach
                </select>
            </div>
            <div class="flex items-center gap-4">
                <x-primary-button>{{ __('Salvar') }}</x-primary-button>
            </div>
        </form>
        <!-- Imagem de Perfil (lado direito) -->
    </div>
</section>
