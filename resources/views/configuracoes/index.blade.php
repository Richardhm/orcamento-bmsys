<x-app-layout>
    <div class="py-6">
        <div class="w-[95%] mx-auto sm:px-6 lg:px-8">
            <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] overflow-hidden shadow-sm sm:rounded-lg">
                <!-- Container das Abas -->
                <div class="border-b border-gray-200">
                    <nav class="flex space-x-8" aria-label="Tabs">
                        <!-- Itens das Abas -->
                        <a href="#tab1" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent active rounded-tl-lg rounded-tr-lg">Tabelas</a>
                        <a href="#tab2" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent">Coparticipações</a>
                        <a href="#tab3" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent">Cidades</a>
                        <a href="#tab4" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent">Assinaturas/Cidade</a>
                        <a href="#tab5" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent">Administradora</a>
                        <a href="#tab6" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent rounded-tr-lg">Planos</a>
                        <a href="#tab7" class="tab-button whitespace-nowrap py-3 px-4 border-b-2 font-medium text-sm text-white hover:bg-white/10 transition-all border-transparent rounded-tr-lg">Desconto</a>
                    </nav>
                </div>

                <!-- Conteúdo das Abas -->
                <div class="p-6">
                    <!-- Conteúdos mantidos igual -->
                    <div id="tab1" class="tab-content active">
                        <x-configuracoes.tabelas-tab />
                    </div>
                    <div id="tab2" class="tab-content hidden">
                        <x-configuracoes.pdf-tab />
                    </div>
                    <div id="tab3" class="tab-content hidden">
                        <x-configuracoes.cidades-tab />
                    </div>
                    <div id="tab4" class="tab-content hidden">
                        <x-configuracoes.assinaturas-cidade-tab />
                    </div>
                    <div id="tab5" class="tab-content hidden">
                        <x-configuracoes.administradoras-tab />
                    </div>
                    <div id="tab6" class="tab-content hidden">
                        <x-configuracoes.planos-tab />
                    </div>
                    <div id="tab7" class="tab-content hidden">
                        <x-configuracoes.desconto-tab />
                    </div>
                </div>
            </div>
        </div>
    </div>

    <style>
        .assinatura-item.active {
            background-color: rgba(59, 130, 246, 0.8);
            border-left: 4px solid #3B82F6;
        }

        .tab-button.active {
            background: rgba(255, 255, 255, 0.25);
            border-top: 2px solid #6366f1;
            border-left: 2px solid #6366f1;
            border-right: 2px solid #6366f1;
            border-bottom: 2px solid transparent !important;
            color: white;
            position: relative;
            top: 0px;
            border-radius: 8px 8px 0 0;
        }

        .tab-button {
            margin-bottom: -2px;
            transition: all 0.2s ease;
        }
    </style>

    @section('scripts')
        <script>
            $(document).ready(function() {

                $('input[name*="valor_apartamento"]').mask("#.##0,00", {reverse: true});
                $('input[name*="valor_enfermaria"]').mask("#.##0,00", {reverse: true});
                $('input[name*="valor_ambulatorial"]').mask("#.##0,00", {reverse: true});
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                // Ativa aba inicial
                $('.tab-button:first').addClass('active');
                $('.tab-button').click(function (e) {
                    e.preventDefault();
                    // Remove todas as classes ativas
                    $('.tab-button').removeClass('active');
                    $('.tab-content').hide();

                    // Adiciona classe ativa no item clicado
                    $(this).addClass('active');

                    // Mostra o conteúdo correspondente
                    $($(this).attr('href')).show();
                });


                var valores = [];

                $("body").on('change', 'select[class^="tabela"]', function (e) {
                    let todosPreenchidos = true;
                    if ($('select[name="administradora"]').val() == '' ||
                        $('select[name="planos"]').val() == '' ||
                        $('select[name="tabela_origem"]').val() == '' ||
                        $('select[name="coparticipacao"]').val() == '' ||
                        $('select[name="odonto"]').val() == '')
                    {
                        todosPreenchidos = false;
                        return false;
                    } else {

                        var valores = {
                            "administradora" : $('select[name="administradora"]').val(),
                            "planos" : $('select[name="planos"]').val(),
                            "tabela_origem" : $('select[name="tabela_origem"]').val(),
                            "coparticipacao" : $('select[name="coparticipacao"]').val(),
                            "odonto" : $('select[name="odonto"]').val()
                        };
                        //valores.push($(this).val());
                        $(".alert-danger").remove();

                        if(todosPreenchidos) {
                                $('input[name*="valor_apartamento"]').prop('disabled',false);
                                $('input[name*="valor_enfermaria"]').prop('disabled',false);
                                $('input[name*="valor_ambulatorial"]').prop('disabled',false);
                                $('#overlay').removeClass("ocultar");

                                let administradora = $('select[name="administradora"]').val();
                                let planos  = $('select[name="planos"]').val()
                                let tabela_origem = $('select[name="tabela_origem"]').val();
                                let coparticipacao = $('select[name="coparticipacao"]').val();
                                let odonto = $('select[name="odonto"]').val();

                                //let plano = $("#planos").val();
                                //let cidade = $("#tabela_origem").val();
                                $('.valor').removeAttr('disabled');

                                $.ajax({
                                    url:"{{route('tabelas.verificar')}}",
                                    method:"POST",
                                    data: {
                                        "administradora" : administradora,
                                        "planos" : planos,
                                        "tabela_origem" : tabela_origem,
                                        "coparticipacao" : coparticipacao,
                                        "odonto" : odonto,

                                    },
                                    success:function(res) {

                                        // $('#overlay').addClass('ocultar');
                                        if(res != "empty") {

                                            $('input[name="valor_apartamento[]"]').each(function(index) {
                                                $(this).addClass('valor');
                                                if (res[index] && res[index].acomodacao_id == 1) {
                                                    $(this).val(res[index].valor_formatado).attr('data-id',res[index].id);
                                                }
                                            });
                                            $('input[name="valor_enfermaria[]"]').each(function(index) {
                                                $(this).addClass('valor');
                                                if (res[index+10] && res[index+10].acomodacao_id == 2) {
                                                    $(this).val(res[index+10].valor_formatado).attr('data-id',res[index+10].id);
                                                }
                                            });
                                            $('input[name="valor_ambulatorial[]"]').each(function(index) {
                                                $(this).addClass('valor');
                                                if (res[index+20] && res[index+20].acomodacao_id == 3) {
                                                    $(this).val(res[index+20].valor_formatado).attr('data-id',res[index+20].id)
                                                }
                                            });
                                            $("#container_btn_cadastrar").slideUp('slow').html('');
                                        } else {
                                            $('input[name="valor_apartamento[]"]')
                                                .val('')
                                                .removeClass('valor');

                                            $('input[name="valor_enfermaria[]"]')
                                                .val('')
                                                .removeClass('valor');

                                            $('input[name="valor_ambulatorial[]"]')
                                                .val('')
                                                .removeClass('valor');

                                            $("#container_btn_cadastrar")
                                                .html(`<button type="button" class="btn_cadastrar text-white w-full bg-gradient-to-r from-blue-500 via-blue-600 to-blue-700 hover:bg-gradient-to-br focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center me-2 mb-2">Cadastrar</button>`)
                                                .hide()
                                                .slideDown('slow');

                                            $("#container_alert_cadastrar")
                                                .html(`<div class="bg-blue-100 border border-blue-300 text-blue-800 text-2xl px-4 py-3 rounded">
                                                    <h4 class="font-semibold">Essa tabela não existe, para inserir os dados clicar no botão cadastrar abaixo, após preencher todos os campos.</h4>
                                                </div>`)
                                                .hide()
                                                .slideDown('slow');
                                        }
                                    }
                                });
                                return false;
                        }
                        return false;
                    }
                    return false;
                });


                $('body').on('change','.valor',function(){
                    let valor = $(this).val();
                    let id = $(this).attr('data-id');



                    $.ajax({
                        url:"{{route('corretora.mudar.valor.tabela')}}",
                        method:"POST",
                        data:"id="+id+"&valor="+valor,
                        success:function(res) {
                            console.log(res);
                        }
                    });
                });







            });

            let itemAtivo = null;
            function carregarCidades(assinaturaId,elemento) {
                if (itemAtivo) {
                    itemAtivo.classList.remove('active');
                }

                // Adicionar classe ativa ao novo item
                elemento.classList.add('active');
                itemAtivo = elemento;
                fetch(`{{ route('assinaturas.cidades', ':assinatura') }}`.replace(':assinatura', assinaturaId))
                    .then(response => response.json())
                    .then(data => {
                        let html = '';
                        data.cidades.forEach(cidade => {
                            html += `
                <div class="flex items-center justify-between p-3 hover:bg-white/10 rounded-lg">
                    <span class="text-white">${cidade.nome} - ${cidade.uf}</span>
                    <input type="checkbox" ${cidade.vinculado ? 'checked' : ''}
                           onchange="toggleVinculo(${assinaturaId}, ${cidade.id}, this.checked)"
                           class="rounded border-gray-300 text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                </div>`;
                        });
                        document.getElementById('cidades-list').innerHTML = html;
                    });
            }

            function toggleVinculo(assinaturaId, cidadeId, vincular) {
                const url = vincular ? "{{ route('assinaturas.vincular') }}" : "{{ route('assinaturas.desvincular') }}";
                const formData = new FormData();
                formData.append('assinatura_id', assinaturaId);
                formData.append('cidade_id', cidadeId);

                fetch(url, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            alert('Ocorreu um erro!');
                            location.reload();
                        }
                    });
            }

            let editMode = false;

            async function editarConfig(id) {
                try {
                    const response = await fetch(`/pdf/${id}/edit`);
                    const data = await response.json();
                    console.log(data);
                    // Preencher formulário
                    document.getElementById('config_id').value = data.id;
                    document.querySelector('[name="plano_id"]').value = data.plano_id;
                    document.querySelector('[name="tabela_origens_id"]').value = data.tabela_origens_id || '';
                    document.querySelector('[name="linha01"]').value = data.linha01 || '';

                    // Split linha02
                    const parts = data.linha02?.split('|') || [];
                    document.querySelector('[name="linha02_part1"]').value = parts[0] || '';
                    document.querySelector('[name="linha02_part2"]').value = parts[1] || '';

                    document.querySelector('[name="linha03"]').value = data.linha03 || '';

                    // Preencher campos dinâmicos
                    const campos = ['consultas_eletivas', 'consultas_de_urgencia', 'exames_simples',
                        'exames_complexos', 'terapias_especiais', 'demais_terapias',
                        'internacoes', 'cirurgia'];

                    campos.forEach(campo => {
                        document.querySelector(`[name="${campo}_total"]`).value = data[`${campo}_total`] || '';
                        document.querySelector(`[name="${campo}_parcial"]`).value = data[`${campo}_parcial`] || '';
                    });

                    // Alterar para modo edição
                    editMode = true;
                    document.getElementById('submit-button').textContent = 'Atualizar Configuração';
                    document.getElementById('cancel-edit').classList.remove('hidden');
                    window.scrollTo({ top: 0, behavior: 'smooth' });

                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro ao carregar dados para edição');
                }
            }

            function cancelarEdicao() {
                editMode = false;
                document.getElementById('config_id').value = '';
                document.getElementById('submit-button').textContent = 'Salvar Configuração';
                document.getElementById('cancel-edit').classList.add('hidden');
                document.querySelector('form[name="store_edit_pdf"]').reset();
            }

            // Atualizar o formulário para enviar para a rota correta
            document.querySelector('form[name="store_edit_pdf"]').addEventListener('submit', function(e) {
                if (editMode) {
                    const id = document.getElementById('config_id').value;
                    this.action = `/pdf/${id}`;
                    this.method = 'POST'; // Usaremos method spoofing
                    const methodInput = document.createElement('input');
                    methodInput.type = 'hidden';
                    methodInput.name = '_method';
                    methodInput.value = 'PUT';
                    this.appendChild(methodInput);
                }
            });

            function updateCharCounter(input, counterId) {
                const counter = document.getElementById(counterId);
                if (counter) {
                    counter.textContent = input.value.length;

                    // Mudar cor se atingir o limite
                    if (input.value.length >= 35) {
                        counter.classList.add('text-red-400');
                        counter.classList.remove('text-gray-300');
                    } else {
                        counter.classList.remove('text-red-400');
                        counter.classList.add('text-gray-300');
                    }
                }
            }

            document.querySelectorAll('input[maxlength="35"]').forEach(input => {
                const counterId = input.name + '-counter';
                input.setAttribute('oninput', `updateCharCounter(this, '${counterId}')`);
                // Disparar evento inicial
                const event = new Event('input');
                input.dispatchEvent(event);
            });

            document.getElementById('formDesconto').addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = new FormData(this);

                try {
                    const response = await fetch('{{ route("descontos.store") }}', {
                        method: 'POST',
                        headers: {
                            'Accept': 'application/json',
                        },
                        body: formData
                    });

                    const data = await response.json();

                    if (data.success) {
                        window.location.reload();
                    } else {
                        alert('Erro: ' + (data.message || 'Falha ao salvar descontos'));
                    }
                } catch (error) {
                    console.error('Erro:', error);
                    alert('Erro ao salvar descontos');
                }
            });


        </script>
    @endsection
</x-app-layout>
