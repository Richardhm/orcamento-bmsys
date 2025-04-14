<x-app-layout>
    <div class="max-w-7xl mx-auto p-4 rounded sm:px-6 lg:px-8 py-8 bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px]">
        <!-- Cabeçalho -->
        <div class="mb-8">
            <h1 class="text-3xl font-bold text-white">Gestão Financeira</h1>
            <p class="mt-2 text-white">Histórico completo de transações da sua assinatura</p>
        </div>

        <!-- Resumo da Assinatura -->
        <div class="bg-indigo-50 rounded-lg p-6 mb-8">
            <div class="flex flex-wrap items-center justify-between">
                <div class="mb-4 md:mb-0">
                    <h2 class="text-xl font-semibold text-indigo-900">Próxima Fatura</h2>
                    <p class="text-gray-600">Vencimento: {{ $dados['proxima_fatura']['data'] }}</p>
                </div>
                <div class="bg-white p-4 rounded-lg shadow">
                    <p class="text-2xl font-bold text-indigo-600">
                        R$ {{ $dados['proxima_fatura']['valor'] }}
                    </p>
                </div>
            </div>
        </div>

        <!-- Histórico Detalhado -->
        <div class="bg-white rounded-xl shadow-lg overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gray-50">
                <h3 class="text-lg font-semibold text-gray-900">Transações Recentes</h3>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse ($dados['historico'] as $transacao)
                    <div class="p-6 hover:bg-gray-50 transition-colors">
                        <div class="flex flex-wrap items-start justify-between gap-4">
                            <!-- Coluna Esquerda -->
                            <div class="flex-1 min-w-[250px]">
                                <div class="flex items-center gap-3 mb-4">
                            <span class="inline-block px-3 py-1 rounded-full text-sm
                                @if($transacao['status'] === 'paid') bg-green-100 text-green-800
                                @elseif($transacao['status'] === 'waiting') bg-yellow-100 text-yellow-800
                                @else bg-gray-100 text-gray-800 @endif">
                                 {{ translateStatus($transacao['status']) }}
                            </span>
                                    <span class="text-sm text-gray-500">#{{ $transacao['charge_id'] }}</span>
                                </div>

                                <div class="space-y-1">
                                    <p class="font-medium">{{ $transacao['cliente']['nome'] }}</p>
                                    <p class="text-gray-600 text-sm">{{ $transacao['cliente']['email'] }}</p>
                                    <p class="text-sm text-gray-500">{{ $transacao['data_criacao'] }}</p>
                                </div>
                            </div>

                            <!-- Coluna Direita -->
                            <div class="w-full md:w-auto">
                                <div class="grid grid-cols-2 gap-4 text-sm">
                                    <div class="space-y-1">
                                        <p class="text-gray-500">Método</p>
                                        <p class="font-medium capitalize">{{ translatePaymentMethod($transacao['metodo_pagamento']) }}</p>
                                    </div>
                                    <div class="space-y-1">
                                        <p class="text-gray-500">Valor Total</p>
                                        <p class="font-medium text-green-700">R$ {{ $transacao['valor_total'] }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Itens da Cobrança -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <h4 class="text-sm font-medium text-gray-900 mb-2">Itens Cobrados</h4>
                            <div class="space-y-3">
                                @foreach($transacao['items'] as $item)
                                    <div class="flex justify-between text-sm">
                                        <span>{{ $item['nome'] }} (x{{ $item['quantidade'] }})</span>
                                        <span>R$ {{ $item['valor_unitario'] }}</span>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Última Atualização -->
                        <div class="mt-4 text-sm text-gray-500">
                            <span class="mr-2">↻</span>
                            {{ $transacao['ultima_mensagem'] }}
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
