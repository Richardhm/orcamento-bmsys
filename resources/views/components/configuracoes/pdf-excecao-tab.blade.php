<div class="flex flex-col md:flex-row gap-6">
    <!-- Formulário à esquerda -->
    <div class="md:w-1/3 w-full bg-white/10 p-4 rounded-lg mb-6 md:mb-0">
        <form method="POST" action="{{ route('pdf-excecao.store') }}">
            @csrf

            <div class="mb-4">
                <select name="plano_id" required class="rounded p-2 w-full">
                    <option value="">Escolha um Plano</option>
                    @foreach($planos as $plano)
                        <option value="{{ $plano->id }}">{{ $plano->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <select name="tabela_origens_id" required class="rounded p-2 w-full">
                    <option value="">Escolha a Cidade</option>
                    @foreach($cidades as $c)
                        <option value="{{ $c->id }}">{{ $c->nome }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <input type="text" name="linha01" class="rounded p-2 w-full" placeholder="Linha 01">
            </div>
            <div class="mb-4">
                <input type="text" name="linha02" class="rounded p-2 w-full" placeholder="Linha 02">
            </div>
            <div class="mb-4">
                <input type="text" name="linha03" class="rounded p-2 w-full" placeholder="Linha 03">
            </div>
            <div class="mb-4">
                <input type="text" name="consultas_eletivas_total" class="rounded p-2 w-full" placeholder="Consultas Eletivas">
            </div>
            <div class="mb-4">
                <input type="text" name="pronto_atendimento" class="rounded p-2 w-full" placeholder="Pronto Atendimento">
            </div>
            <div class="mb-4 grid grid-cols-2 gap-2">
                <input type="text" name="faixa_1" class="rounded p-2" placeholder="Faixa 1">
                <input type="text" name="faixa_2" class="rounded p-2" placeholder="Faixa 2">
            </div>
            <div class="mb-4 grid grid-cols-2 gap-2">
                <input type="text" name="faixa_3" class="rounded p-2" placeholder="Faixa 3">
                <input type="text" name="faixa_4" class="rounded p-2" placeholder="Faixa 4">
            </div>
            <button type="submit" class="bg-blue-500 hover:bg-blue-600 text-white py-2 px-4 rounded w-full">Salvar</button>
        </form>
    </div>

    <!-- Listagem à direita -->
    <div class="md:w-2/3 w-full overflow-x-auto">
        <table class="min-w-full bg-white/10 text-xs backdrop-blur rounded text-white">
            <thead>
            <tr class="bg-blue-950">
                <td class="px-2 py-1">Cidade</td>
                <td class="px-2 py-1">Plano</td>
                <td class="px-2 py-1">Consultas</td>
                <td class="px-2 py-1">Pronto Atendimento</td>
                <td class="px-2 py-1">Faixa 1</td>
                <td class="px-2 py-1">Faixa 2</td>
                <td class="px-2 py-1">Faixa 3</td>
                <td class="px-2 py-1">Faixa 4</td>
                <td class="px-2 py-1">Ações</td>
            </tr>
            </thead>
            <tbody>
            @forelse($excecoes as $e)
                <tr class="border-b border-white/20">
                    <td class="px-2 py-1">{{ $e->cidade->nome ?? '-' }}</td>
                    <td class="px-2 py-1">{{ $e->plano->nome ?? '-' }}</td>
                    <td class="px-2 py-1">{{ $e->consultas_eletivas_total }}</td>
                    <td class="px-2 py-1">{{ $e->pronto_atendimento }}</td>
                    <td class="px-2 py-1">{{ $e->faixa_1 }}</td>
                    <td class="px-2 py-1">{{ $e->faixa_2 }}</td>
                    <td class="px-2 py-1">{{ $e->faixa_3 }}</td>
                    <td class="px-2 py-1">{{ $e->faixa_4 }}</td>
                    <td class="px-2 py-1">
                        <form action="{{ route('pdf-excecao.destroy', $e->id) }}" method="POST" onsubmit="return confirm('Deseja excluir?')">
                            @csrf
                            @method('DELETE')
                            <button class="text-red-400 hover:text-red-700" title="Excluir" type="submit">Excluir</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td class="px-2 py-1 text-center" colspan="12">Nenhum registro encontrado.</td></tr>
            @endforelse
            </tbody>
        </table>
    </div>
</div>
