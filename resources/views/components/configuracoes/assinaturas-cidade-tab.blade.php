<div>
    <div>
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
            <!-- Lista de Assinaturas (Esquerda) -->
            <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow">
                <h2 class="text-xl font-semibold mb-4 text-white">Responsáveis por Assinaturas</h2>
                <div class="space-y-2 max-h-96 overflow-y-auto">
                    @foreach($assinaturas as $assinatura)
                        <div class="assinatura-item cursor-pointer p-3 hover:bg-white/10 rounded-lg text-white transition-all"
                             data-assinatura-id="{{ $assinatura->id }}"
                             onclick="carregarCidades({{ $assinatura->id }}, this)">
                            {{ $assinatura->user->name }} ({{ $assinatura->user->email }})
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Lista de Cidades (Direita) -->
            <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-6 rounded-lg shadow" id="cidades-container">
                <h2 class="text-xl font-semibold mb-4 text-white">Cidades Vinculadas</h2>
                <div id="cidades-list" class="space-y-2 max-h-96 overflow-y-auto">
                    <!-- Cidades serão carregadas via AJAX -->
                </div>
            </div>
        </div>
    </div>


</div>
