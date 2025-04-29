<x-app-layout>
    <h2 class="text-4xl text-white font-bold my-6 text-center">{{ $cidade->nome }} - {{ $plano->nome }}</h2>
    <table class="w-[70%] mx-auto bg-white/10 rounded text-white">
        <thead>
        <tr>
            <th class="px-2 py-1 text-left">Legenda</th>
            <th class="px-2 py-1 text-left">Tempo (dias)</th>
            <th class="px-2 py-1 text-left">Detalhe</th>

        </tr>
        </thead>
        <tbody>
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
        @foreach($carencias as $index => $carencia)
            <tr class="border-b border-white/20">
                <td class="px-2 py-1">{{ $legends[$index] ?? "Linha ".($index+1) }}</td>
                <td class="px-2 py-1">{{ $carencia->tempo }}</td>
                <td class="px-2 py-1">{{ $carencia->detalhe }}</td>

            </tr>
        @endforeach
        </tbody>
    </table>
    <div class="w-full flex justify-center">
        <a href="{{ route('configuracoes.index') }}"
           class="text-center w-60 mt-4 text-white rounded hover:bg-blue-950 p-2 bg-blue-600 mx-auto text-4xl">Voltar</a>
    </div>

</x-app-layout>
