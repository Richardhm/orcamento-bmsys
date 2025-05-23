<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 rounded sm:px-6 lg:px-8 py-8 bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px]">
        <!-- Cabeçalho -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Gestão Financeira</h1>
            <p class="mt-2 text-white">Histórico completo de transações da sua assinatura</p>
        </div>



        <!-- Histórico Detalhado -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Transações Recentes</h3>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse ($dados as $transacao)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <!-- Coluna Esquerda -->
                            <div class="flex-1 min-w-[250px]">
                                <div class="flex items-center gap-3 mb-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm

                            </span>
                                    <span class="text-sm text-gray-500">

                                    </span>
                                </div>

                                <div class="space-y-1">
                                    <p class="font-medium">{{ $transacao['devedor']['nome'] }}</p>
                                    <p class="text-gray-600 text-sm">{{ $transacao['devedor']['cpf'] }}</p>
                                    <p class="text-sm text-gray-500">

                                        {{ \Carbon\Carbon::parse($transacao['calendario']['criacao'])->format('d/m/Y') }}



                                    </p>
                                </div>
                            </div>

                            <!-- Coluna Direita -->
                            <div class="w-full md:w-auto">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="space-y-1">
                                        <p class="text-gray-500">Método</p>
                                        <p class="font-medium capitalize">PIX</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-gray-500">Valor Total</p>
                                        <p class="font-medium text-green-700">R$ {{$transacao['valor']['original']}}</p>
                                    </div>
                                </div>
                            </div>
                        </div>



                    </div>
                @empty
                    <div class="p-6 text-center text-gray-500">
                        Nenhuma transação encontrada
                    </div>
                @endforelse
            </div>
        </div>
    </div>
</x-app-layout>
