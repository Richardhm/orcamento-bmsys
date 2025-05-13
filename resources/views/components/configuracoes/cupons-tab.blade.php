<div class="flex justify-between">
    <form method="POST" action="{{ route('cupons.store') }}" class="space-y-4 w-[40%]" name="cupon-form">
        @csrf



        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1 text-white">Desconto Plano (R$)</label>
                <input type="text" name="desconto_plano" required
                       class="w-full px-3 py-2 border rounded-md"
                       placeholder="Ex: 100.00">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-white">Desconto por Extra (R$)</label>
                <input type="text" name="desconto_extra" required
                       class="w-full px-3 py-2 border rounded-md"
                       placeholder="Ex: 15.00">
            </div>
        </div>

        <!-- Duração com Selects -->
        <div class="grid grid-cols-3 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1 text-white">Horas</label>
                <select name="duracao_horas" class="w-full px-3 py-2 border rounded-md">
                    @for($i = 0; $i <= 23; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-white">Minutos</label>
                <select name="duracao_minutos" class="w-full px-3 py-2 border rounded-md">
                    @for($i = 0; $i <= 59; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </option>
                    @endfor
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-white">Segundos</label>
                <select name="duracao_segundos" class="w-full px-3 py-2 border rounded-md">
                    @for($i = 0; $i <= 59; $i++)
                        <option value="{{ str_pad($i, 2, '0', STR_PAD_LEFT) }}">
                            {{ str_pad($i, 2, '0', STR_PAD_LEFT) }}
                        </option>
                    @endfor
                </select>
            </div>
        </div>

        <!-- Usos e Status -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-medium mb-1 text-white">Usos Máximos</label>
                <input type="number" name="usos_maximos" min="1"
                       class="w-full px-3 py-2 border rounded-md"
                       placeholder="Deixe em branco para ilimitado">
            </div>

            <div>
                <label class="block text-sm font-medium mb-1 text-white">Status *</label>
                <select name="ativo" class="w-full px-3 py-2 border rounded-md" required>
                    <option value="1">Ativo</option>
                    <option value="0">Inativo</option>
                </select>
            </div>
        </div>

        <div class="bg-gray-50 p-3 rounded-md hidden" id="codigo-container">
            <div class="flex items-center justify-between mb-2">
                <label class="block text-sm font-medium">Código Promocional Gerado</label>
                <button type="button" onclick="copiarCodigo()" class="text-blue-600 hover:text-blue-800 text-sm">
                    📋 Copiar
                </button>
            </div>
            <div id="codigo-gerado" class="font-mono text-lg text-blue-600 bg-white p-2 rounded border"></div>
            <input type="hidden" name="codigo" id="codigo-input">
        </div>

        <button type="submit"
                class="w-full bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-700 transition-colors">
            Cadastrar Cupom
        </button>




        <!-- Seção de Sucesso -->
        <div id="success-message" class="hidden mt-4 p-4 bg-green-100 border border-green-400 text-green-700 rounded">
            <h3 class="font-bold">Cupom cadastrado com sucesso!</h3>
            <p>Código: <span id="success-codigo" class="font-mono"></span></p>
            <p>Válido até: <span id="success-validade" class="font-medium"></span></p>
            <p>Valor do PLano: <span id="success-plano" class="font-medium"></span></p>
            <p>Valor do desconto por usúario extrar: <span id="success-desconto" class="font-medium"></span></p>
        </div>
    </form>
    <div class="flex w-[50%] flex-col items-center bg-white/90 p-6 rounded-xl shadow-lg">
        <h2 class="text-blue-800 text-center text-4xl font-bold mb-6">Observações</h2>

        <div class="text-gray-700 space-y-4 text-sm">
            <p class="border-black border-2 rounded p-1">
                <span class="font-semibold">Desconto Plano (R$):</span> Base de <strong>R$29,90</strong>. O valor inserido será descontado deste valor.<br />
                <span class="text-blue-600">Exemplo:</span> Inserindo <strong>R$10,00</strong> → Resultado: <strong>R$29,90 - R$10,00 = R$19,90(Valor Plano)</strong>.
            </p>

            <p class="border-black border-2 rounded p-1">
                <span class="font-semibold">Desconto por Extra (R$):</span> Base de <strong>R$29,90</strong>. O valor inserido será descontado deste valor.<br />
                <span class="text-blue-600">Exemplo:</span> Inserindo <strong>R$9,90</strong> → Resultado: <strong>R$29,90 - R$9,90 = R$20,00</strong> por usuário extra (email).

            </p>
            <p class="border-black border-2 rounded p-1">
                <span class="font-semibold">Usos Máximos:</span>
                Defina o número máximo de usos permitidos para esta promoção.<br />
                <span class="text-blue-600">Exemplo:</span> Inserindo <strong>3</strong>, apenas os <strong>3 primeiros usuários</strong> conseguirão aproveitar a promoção estando no prazo de validade.
                <br />
                <span class="text-center text-red-600 block">Se deicar o campo vazio o numero de uso vai ser ilimitado</span>
            </p>
        </div>
    </div>
</div>
