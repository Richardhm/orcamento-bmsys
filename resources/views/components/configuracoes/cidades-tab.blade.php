<div>
    <div>
        <!-- Mensagens -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Formulário (Esquerda) -->
            <div class="md:order-1">
                <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-center text-white">Cadastrar Cidade</h2>
                    <form action="{{ route('cidades.store') }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-white mb-2">Cidade</label>
                            <input type="text" name="nome" required
                                   class="w-full px-3 py-2 border rounded-lg @error('nome') border-red-500 @enderror">
                            @error('nome')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-white mb-2">UF</label>
                            <select name="uf" required
                                    class="w-full px-3 py-2 border rounded-lg bg-white @error('uf') border-red-500 @enderror">
                                <option value="">Selecione um estado</option>
                                @foreach($estados as $uf => $nome)
                                    <option value="{{ $uf }}" @selected(old('uf') == $uf)>{{ $uf }} - {{ $nome }}</option>
                                @endforeach
                            </select>
                            @error('uf')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit"
                                class="bg-blue-500 text-white px-4 py-2 w-full rounded hover:bg-blue-600">
                            Cadastrar
                        </button>
                    </form>
                </div>
            </div>

            <!-- Lista (Direita) -->
            <div class="md:order-2">
                <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-white">Cidades Cadastradas</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                            <tr class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] rounded">
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">UF</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($cidades as $cidade)
                                <tr>
                                    <td class="px-6 py-4 text-white">{{ $cidade->nome }}</td>
                                    <td class="px-6 py-4 text-white">{{ $cidade->uf }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('cidades.destroy', $cidade->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 border-red-600 border-2 p-2 rounded bg-yellow-50"
                                                    onclick="return confirm('Deseja excluir esta cidade?')">
                                                Excluir
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>



    </div>
</div>
