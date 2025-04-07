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
            <!-- Formulário -->
            <div class="md:order-1">
                <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-center text-white">Nova Administradora</h2>
                    <form action="{{ route('administradoras.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-white mb-2">Nome</label>
                            <input type="text" name="nome" required
                                   class="w-full px-3 py-2 border rounded-lg @error('nome') border-red-500 @enderror">
                            @error('nome')
                            <span class="text-red-500 text-sm">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="mb-4">
                            <label class="block text-white mb-2">Logo</label>
                            <input type="file" name="logo"
                                   class="w-full px-3 py-2 border rounded-lg bg-white @error('logo') border-red-500 @enderror"
                                   accept="image/*">
                            @error('logo')
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

            <!-- Lista -->
            <div class="md:order-2">
                <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                    <h2 class="text-xl font-semibold mb-4 text-white">Administradoras Cadastradas</h2>
                    <div class="overflow-x-auto">
                        <table class="min-w-full">
                            <thead>
                            <tr class="bg-[rgba(254,254,254,0.18)] rounded">
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Logo</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Nome</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-white uppercase">Ações</th>
                            </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-200">
                            @foreach($administradoras as $adm)
                                <tr>
                                    <td class="px-6 py-4">
                                        @if($adm->logo)
                                            <div class="w-16 h-16 flex items-center">
                                                <img src="{{ asset($adm->logo) }}"
                                                     class="w-full">
                                            </div>

                                        @else
                                            <div class="w-12 h-12 rounded-full bg-gray-200 flex items-center justify-center">
                                                <span class="text-gray-500 text-xs">Sem logo</span>
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-white">{{ $adm->nome }}</td>
                                    <td class="px-6 py-4">
                                        <form action="{{ route('administradoras.destroy', $adm->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                    class="text-red-600 hover:text-red-900 border-red-600 border-2 p-2 rounded bg-yellow-50"
                                                    onclick="return confirm('Deseja excluir esta administradora?')">
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
