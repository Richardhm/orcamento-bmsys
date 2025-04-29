<div>
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Formulário -->
        <div class="bg-white/10 backdrop-blur-[15px] p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-white">Nova Regra de Carência</h2>
            <form action="{{ route('carencia.store') }}" method="POST">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

                    <select name="plano_id" id="plano_id">
                        <option value="">Escolher o Plano</option>
                        @foreach($planos as $p)
                            <option value="{{$p->id}}">{{$p->nome}}</option>
                        @endforeach
                    </select>

                    <select name="tabela_origens_id" id="tabela_origens_id">
                        <option value="">Escolher as Cidades</option>
                        @foreach($cidades as $c)
                            <option value="{{$c->id}}">{{$c->nome}}</option>
                        @endforeach
                    </select>



                </div>

                @php
                    $legends = [
                        "Urgência Emergências e Acidentes Pessoais",
                        "Consultas Médicas, Exames Médicos Simples",
                        "Exames Cardiológicos, Exames Imagem, Oftalmol., Otorrino Simples...",
                        "Cirurgias, Internações, Exames Alto Custo, Trat. Psicológico....",
                        "Parto",
                        "Doenças e Lesões Pré-Existentes"
                    ];
                @endphp

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @for ($i = 0; $i < 6; $i++)
                        <fieldset class="mb-6 border border-white/50 rounded-lg p-4">
                            <legend class="w-full text-center text-sm text-orange-400 font-medium mb-2 leading-tight">
                                {{ $legends[$i] }}
                            </legend>
                            <div>
                                <label class="block text-white mb-2">Tempo (dias)</label>
                                <input type="number" name="tempo_{{ $i+1 }}" required
                                       class="w-full px-3 py-2 rounded bg-white/90">
                            </div>
                            <div>
                                <label class="block text-white mb-2">Detalhe</label>
                                <input type="text" name="detalhe_{{ $i+1 }}" maxlength="100"
                                       class="w-full px-3 py-2 rounded bg-white/90">
                            </div>
                        </fieldset>
                    @endfor
                </div>

                <button type="submit" id="submit-button"
                        class="w-full bg-blue-500 hover:bg-blue-600 text-white font-bold py-2 px-4 rounded">
                    Salvar Carência
                </button>
            </form>
        </div>


        <div id="success-message-carencia" class="hidden mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <h3 class="font-bold">Carencias cadastrado com sucesso!</h3>
        </div>

        <!-- Listagem -->
        <div class="bg-white/10 backdrop-blur-[15px] p-6 rounded-lg shadow">
            <h2 class="text-xl font-semibold mb-4 text-white">Regras Cadastradas</h2>
            <table class="min-w-full">
                <table class="min-w-full bg-white/10 backdrop-blur rounded">
                    <thead>
                    <tr>
                        <th class="px-4 py-2 text-left text-white">Cidade</th>
                        <th class="px-4 py-2 text-left text-white">Plano</th>
                        <th class="px-4 py-2 text-left text-white">Ver Detalhe</th>
                        <th class="px-4 py-2 text-left text-white">Excluir</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($carencias as $key => $grupo)
                        @php
                            [$cidade_nome, $plano_nome, $cidade_id, $plano_id] = explode('|', $key);
                        @endphp
                        <tr class="border-b border-white/20">
                            <td class="px-4 py-2 text-white">{{ $cidade_nome }}</td>
                            <td class="px-4 py-2 text-white">{{ $plano_nome }}</td>
                            <td class="px-4 py-2 text-white">
                                <a href="{{ route('carencia.detalhe', ['plano_id' => $plano_id, 'tabela_origens_id' => $cidade_id]) }}"
                                   class="text-white p-2 bg-blue-600 rounded">Ver Detalhe</a>
                            </td>
                            <td class="px-4 py-2 text-white">
                                <form action="{{ route('carencia.deleteGrupo', ['plano_id' => $plano_id, 'tabela_origens_id' => $cidade_id]) }}" method="POST" onsubmit="return confirm('Tem certeza?');">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-white p-2 bg-red-600 rounded" type="submit">Excluir</button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

            </table>
        </div>
    </div>
</div>
