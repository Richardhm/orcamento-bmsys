<div>
    <div>
        <!-- Mensagens -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">
            <!-- Formulário -->
            <div class="col-span-3 bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-white">Vincular Planos</h2>
                <form id="formPlanos" method="POST" action="{{ route('admin-planos.store') }}">
                    @csrf
                    <div class="grid grid-cols-4 gap-1">

                        <!-- assinaturas -->
                        <div>
                            <h3 class="text-white mb-2 font-medium">Assinaturas</h3>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                @foreach($assinaturas as $ass)
                                    <label class="flex items-center space-x-1 text-white text-sm">
                                        <input type="checkbox" name="assinatura_id[]" value="{{ $ass->id }}"
                                               class="rounded border-gray-300">
                                        <span>{{ $ass->user->name }} ({{ $ass->user->email }})</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Administradoras -->
                        <div>
                            <h3 class="text-white mb-2 font-medium">Administradoras</h3>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                @foreach($administradoras as $adm)
                                    <label class="flex items-center space-x-1 text-white text-sm">
                                        <input type="checkbox" name="administradora_id[]" value="{{ $adm->id }}"
                                               class="rounded border-gray-300">
                                        <span>{{ $adm->nome }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Planos -->
                        <div>
                            <h3 class="text-white mb-2 font-medium">Planos</h3>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                @foreach($planos as $plano)
                                    <label class="flex items-center space-x-1 text-white text-sm">
                                        <input type="checkbox" name="plano_id[]" value="{{ $plano->id }}"
                                               class="rounded border-gray-300">
                                        <span>{{ $plano->nome }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <!-- Tabelas de Origem -->
                        <div>
                            <h3 class="text-white mb-2 font-medium">Tabelas de Origem</h3>
                            <div class="space-y-2 max-h-60 overflow-y-auto">
                                @foreach($tabelas as $tabela)
                                    <label class="flex items-center space-x-1 text-white text-sm">
                                        <input type="checkbox" name="tabela_origem_id[]" value="{{ $tabela->id }}"
                                               class="rounded border-gray-300">
                                        <span>{{ $tabela->nome }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <button type="submit"
                            class="mt-4 bg-blue-500 text-white px-4 py-2 w-full rounded hover:bg-blue-600">
                        Salvar Associações
                    </button>
                </form>
            </div>

            <!-- Lista -->
            <div class="col-span-2 bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-white">Associações Existentes</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                        <tr class="bg-[rgba(254,254,254,0.18)] rounded">
                            <th class="px-2 py-1 text-left text-white text-xs">Adm.</th>
                            <th class="px-2 py-1 text-left text-white text-xs">Plano</th>
                            <th class="px-2 py-1 text-left text-white text-xs">Tabela</th>
                            <th class="px-2 py-1 text-left text-white text-xs">Assinatura</th>
                            <th class="px-2 py-1 text-left text-white text-xs">Ações</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-200">
                        @foreach($vinculos as $vinculo)
                            <tr>
                                <td class="px-2 py-1 text-left text-white text-xs">{{ $vinculo->administradora->nome }}</td>
                                <td class="px-2 py-1 text-left text-white text-xs">{{ $vinculo->plano->nome }}</td>
                                <td class="px-2 py-1 text-left text-white text-xs">{{ $vinculo->tabelaOrigem->nome ?? 'N/A' }}</td>
                                <td class="px-2 py-1 text-left text-white text-xs">{{ $vinculo->assinatura->user->email }}</td>
                                <td class="px-6 py-4">
                                    <form action="{{ route('admin-planos.destroy', $vinculo->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit"
                                                class="text-red-500 hover:text-red-700"
                                                onclick="return confirm('Excluir esta associação?')">
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
