<div>
    <div>
        <!-- Mensagens de Status -->
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <input type="hidden" name="config_id" id="config_id">
            <!-- Formulário de Cadastro -->
            <div class="bg-white/10 backdrop-blur-[15px] p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-white">Nova Configuração PDF</h2>
                <form action="{{ route('pdf.store') }}" name="store_edit_pdf" method="POST">
                    @csrf

                    <!-- Seleção de Plano e Cidade -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        <div>
                            <label class="block text-white mb-2">Plano</label>
                            <select name="plano_id" required class="w-full px-3 py-2 rounded bg-white/90">
                                @foreach($planos as $plano)
                                    <option value="{{ $plano->id }}">{{ $plano->nome }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-white mb-2">Cidade (Opcional)</label>
                            <select name="tabela_origens_id" class="w-full px-3 py-2 rounded bg-white/90">
                                <option value="">Geral</option>
                                @foreach($cidades as $cidade)
                                    <option value="{{ $cidade->id }}">{{ $cidade->nome }} - {{ $cidade->uf }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <!-- Campos de Texto -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-white mb-2">Linha 01</label>
                            <input type="text" name="linha01" maxlength="35"
                                   class="w-full px-3 py-2 rounded bg-white/90"
                                   oninput="updateCharCounter(this, 'linha01-counter')">
                            <div class="text-right text-sm text-gray-300">
                                <span id="linha01-counter">0</span>/35
                            </div>
                        </div>

                        <div>
                            <label class="block text-white mb-2">Linha 02</label>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <input type="text" name="linha02_part1" maxlength="35"
                                           placeholder="Primeira parte"
                                           class="w-full px-3 py-2 rounded bg-white/90"
                                           oninput="updateCharCounter(this, 'linha02_part1-counter')">
                                    <div class="text-right text-sm text-gray-300">
                                        <span id="linha02_part1-counter">0</span>/35
                                    </div>
                                </div>
                                <div>
                                    <input type="text" name="linha02_part2" maxlength="35"
                                           placeholder="Segunda parte"
                                           class="w-full px-3 py-2 rounded bg-white/90"
                                           oninput="updateCharCounter(this, 'linha02_part2-counter')">
                                    <div class="text-right text-sm text-gray-300">
                                        <span id="linha02_part2-counter">0</span>/35
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div>
                            <label class="block text-white mb-2">Linha 03</label>
                            <input type="text" name="linha03" maxlength="35"
                                   class="w-full px-3 py-2 rounded bg-white/90"
                                   oninput="updateCharCounter(this, 'linha03-counter')">
                            <div class="text-right text-sm text-gray-300">
                                <span id="linha03-counter">0</span>/35
                            </div>
                        </div>
                    </div>

                    <!-- Grid de Valores -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                        @php
                            $campos = [
                                'consultas_eletivas' => 'Consultas Eletivas',
                                'consultas_de_urgencia' => 'Consultas de Urgência',
                                'exames_simples' => 'Exames Simples',
                                'exames_complexos' => 'Exames Complexos',
                                'terapias_especiais' => 'Terapias Especiais',
                                'demais_terapias' => 'Demais Terapias',
                                'internacoes' => 'Internações',
                                'cirurgia' => 'Cirurgia'
                            ];
                        @endphp

                        @foreach($campos as $campo => $label)
                            <div class="bg-white/5 p-4 rounded-lg">
                                <h3 class="text-white font-medium mb-3">{{ $label }}</h3>
                                <div class="space-y-2">
                                    <input type="text" name="{{ $campo }}_total" placeholder="Total"
                                           class="w-full px-3 py-2 rounded bg-white/90">
                                    <input type="text" name="{{ $campo }}_parcial" placeholder="Parcial"
                                           class="w-full px-3 py-2 rounded bg-white/90">
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <button type="submit" id="submit-button"
                            class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                        Salvar Configuração
                    </button>

                    <!-- Adicionar botão de cancelar edição -->
                    <button type="button" onclick="cancelarEdicao()" id="cancel-edit"
                            class="hidden mt-2 w-full bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded">
                        Cancelar Edição
                    </button>

                </form>
            </div>

            <!-- Lista de Configurações -->
            <div class="bg-white/10 backdrop-blur-[15px] p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-white">Configurações Existentes</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full">
                        <thead>
                        <tr class="bg-white/10">
                            <th class="px-4 py-3 text-left text-white">Plano</th>
                            <th class="px-4 py-3 text-left text-white">Cidade</th>
                            <th class="px-4 py-3 text-left text-white">Ações</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-white/20">
                        @foreach($pdfs as $config)
                            <tr>
                                <td class="px-4 py-3 text-white">{{ $config->plano->nome }}</td>
                                <td class="px-4 py-3 text-white">
                                    {{ $config->cidade->nome ?? 'Geral' }} {{ $config->cidade->uf ?? '' }}
                                </td>
                                <td class="px-4 py-3">
                                    <div class="flex space-x-3">
                                        <button onclick="editarConfig({{ $config->id }})"
                                                class="text-blue-400 hover:text-blue-300 border-black bg-white rounded border-2 p-1">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"/>
                                            </svg>
                                        </button>
                                        <form action="{{ route('pdf.destroy', $config->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-400 hover:text-red-300 border-black bg-white rounded border-2 p-1">
                                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
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
