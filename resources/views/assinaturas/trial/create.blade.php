<x-guest-layout>
    <!-- Session Status -->

    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4 text-center">
            {{ session('error') }}
        </div>
    @endif

    <x-auth-session-status class="mb-1" :status="session('status')" />
    <section class="md:w-[70%] rounded-lg mx-auto">
        <img src="{{ asset('logo_bm_1.png') }}" class="mx-auto my-1 w-32 md:w-32" alt="">

        <form method="POST" name="cadastrar_individual" class="p-1 flex flex-wrap gap-4" enctype="multipart/form-data">
            @csrf
            <div class="w-full">
                {{-- CUPOM PROMOCIONAL --}}
                <div class="mb-2">
                    <label class="text-white">

                        <input type="checkbox" id="cupom_promocional" name="usar_cupom">
                        Possui cupom promocional?
                    </label>
                </div>

                <div id="cardCupom" class="mb-2" style="display:none;">
                    <label for="codigo_cupom" class="block mb-1 font-medium text-white text-sm">Código do Cupom</label>
                    <div class="flex gap-2">
                        <input type="text" id="codigo_cupom" name="codigo_cupom" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" autocomplete="off">
                        <button type="button" id="aplicarCupom" class="bg-blue-600 text-white px-4 py-1 rounded">Aplicar</button>
                    </div>
                    <div id="cupomMensagem" class="text-sm text-red-600"></div>
                </div>

                {{-- RESUMO DA COMPRA --}}
                <div id="resumoCompra" class="bg-gray-100 rounded-lg p-4 mb-4 text-black">
                    <h3 class="text-lg font-semibold mb-2">Resumo da compra</h3>
                    <ul>
                        <li>Plano: <span id="precoPlanoOriginal">R$ 129,90</span> <span id="descontoPlano"></span></li>
                        <li>Usuários adicionais: <span id="precoUsuarioOriginal">R$ 37,90</span> <span id="descontoUsuario"></span></li>
                        <li><b>Total:</b> <span id="totalFinal">R$ 129,90</span></li>
                    </ul>
                </div>

                {{-- ENDEREÇO --}}
                <fieldset id="cardFields" class="border border-gray-300 p-1 rounded-lg mb-4">
                    <legend class="text-lg font-semibold text-white">Endereço</legend>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/3">
                            <label for="zipcode" class="block mb-1 font-medium text-white text-sm">CEP</label>
                            <input type="text" name="zipcode" id="zipcode" placeholder="XXXXX-XXX" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="street" class="block mb-1 font-medium text-white text-sm">Rua</label>
                            <input type="text" name="street" id="street" placeholder="Rua" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                        <div class="w-full md:w-1/4">
                            <label for="number" class="block mb-1 font-medium text-white text-sm">Nº <small>(Opcional)</small></label>
                            <input type="text" name="number" id="number" placeholder="Nº" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg">
                        </div>
                    </div>
                    <div class="flex flex-col md:flex-row gap-4">
                        <div class="w-full md:w-1/3">
                            <label for="city" class="block mb-1 font-medium text-white text-sm">Cidade</label>
                            <input type="text" name="city" id="city" placeholder="Cidade" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="neighborhood" class="block mb-1 font-medium text-white text-sm">Bairro</label>
                            <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                        <div class="w-full md:w-1/4">
                            <label for="state" class="block mb-1 font-medium text-white text-sm">Estado</label>
                            <input type="text" name="state" id="state" placeholder="UF" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                    </div>
                </fieldset>

                {{-- DADOS DO CARTÃO --}}
                <fieldset id="cardDados" class="border border-gray-300 p-1 rounded-lg mb-4">
                    <legend class="text-lg font-semibold text-white">Dados Cartão</legend>
                    <div class="mb-2">
                        <label for="numero_cartao" class="block mb-1 font-medium text-white text-sm">Número do Cartão</label>
                        <input type="text" name="numero_cartao" required id="numero_cartao" placeholder="XXXX XXXX XXXX XXXX" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 focus:border-transparent focus:ring-0 focus:outline-none rounded-lg">
                    </div>
                    <div class="mb-2">
                        <label for="nome_titular" class="block mb-1 font-medium text-white text-sm">Nome do Titular</label>
                        <input type="text" name="nome_titular" required id="nome_titular" placeholder="Nome do Titular do Cartão" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 focus:border-transparent focus:ring-0 focus:outline-none rounded-lg">
                    </div>
                    <div class="flex justify-between gap-2">
                        <div class="w-1/3">
                            <label for="mes" class="block mb-1 font-medium text-white text-sm">Mês</label>
                            <select name="mes" id="mes" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                                <option value="">MM</option>
                                @for ($i = 1; $i <= 12; $i++)
                                    <option value="{{ sprintf('%02d', $i) }}">{{ sprintf('%02d', $i) }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-1/3">
                            <label for="ano" class="block mb-1 font-medium text-white text-sm">Ano</label>
                            <select name="ano" id="ano" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                                <option value="">ANO</option>
                                @for ($i = now()->year; $i <= now()->year + 12; $i++)
                                    <option value="{{ substr($i, -2) }}">{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div class="w-1/3">
                            <label for="cvv" class="block mb-1 font-medium text-white text-sm">CVV</label>
                            <input type="text" name="cvv" required id="cvv" placeholder="XXX" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                        </div>
                    </div>
                </fieldset>

                <input type="hidden" name="bandeira" id="bandeira">

                {{-- BOTÃO SUBMIT --}}
                <div>
                    <button type="submit" class="text-white bg-gradient-to-r from-cyan-500 to-cyan-600 hover:bg-gradient-to-br dark:focus:ring-cyan-800 font-medium px-5 py-2 text-center me-2 mb-1 w-full rounded-lg">Salvar</button>
                </div>
            </div>
        </form>
    </section>



    @section('scripts')
        <script>
            $(function() {

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                let precoPlano = 129.90;
                let precoPorUsuario = 37.90;
                let descontoPlano = 0.0;
                let descontoUsuario = 0.0;
                let totalUsuarios = 1; // Atualize se tiver multiusuário

                function atualizarResumo() {
                    let valorPlano = precoPlano - descontoPlano;
                    let valorUsuarios = (precoPorUsuario - descontoUsuario) * (totalUsuarios - 1);
                    valorUsuarios = Math.max(0, valorUsuarios);

                    let total = valorPlano + valorUsuarios;
                    $("#precoPlanoOriginal").text(`R$ ${precoPlano.toFixed(2)}`);
                    $("#descontoPlano").html(descontoPlano > 0 ? `<span class="text-red-400">(- R$ ${descontoPlano.toFixed(2)})</span>` : "");
                    $("#precoUsuarioOriginal").text(`R$ ${precoPorUsuario.toFixed(2)}`);
                    $("#descontoUsuario").text(descontoUsuario > 0 ? `(- R$ ${descontoUsuario.toFixed(2)}) x ${totalUsuarios-1} usuário(s)` : "");
                    $("#totalFinal").html(`<span class="text-green-600">R$ ${total.toFixed(2)}</span>`);
                }

                atualizarResumo();

                // Mostrar/esconder campo cupom
                $('#cupom_promocional').on('change', function() {
                    $('#cardCupom').toggle(this.checked);
                });

                // Aplicação do cupom
                $('#aplicarCupom').on('click', function() {
                    let codigoCupom = $('#codigo_cupom').val();
                    if (!codigoCupom) {
                        $('#cupomMensagem').text('Informe o código do cupom');
                        return;
                    }

                    $.post("{{ route('cupom.validar') }}", { codigo_cupom: codigoCupom, _token: '{{ csrf_token() }}' }, function(data) {
                        console.log(data);
                        if (data.success) {
                            descontoPlano = parseFloat(data.desconto_plano || 0);
                            descontoUsuario = parseFloat(data.desconto_extra || 0);
                            atualizarResumo();
                            $('#cupomMensagem').removeClass('text-red-600').addClass('text-green-600 bg-white w-full p-2 text-center mt-2').text(data.mensagem);
                        } else {
                            descontoPlano = 0;
                            descontoUsuario = 0;
                            atualizarResumo();
                            $('#cupomMensagem').removeClass('text-green-600').addClass('text-red-600').text(data.mensagem);
                        }
                    });
                });
            });

            $gn.ready(function(checkout){



                $('#cardCupom').hide();

                // Coloca um listener no checkbox
                $('#cupom_promocional').on('change', function() {
                    if ($(this).is(':checked')) {
                        $('#cardCupom').show();
                    } else {
                        $('#cardCupom').hide();
                    }
                });



                $("#zipcode").change(function(){
                    let cep = $(this).val().replace("-","");
                    const url = `https://viacep.com.br/ws/${cep}/json`;
                    const options = {method: "GET",mode: "cors",
                        headers: {'content-type': 'application/json;charset=utf-8'}
                    }
                    fetch(url,options).then(response => response.json()).then(
                        data => {
                            console.log(data);
                            $("#street").val(data.logradouro);
                            $("#neighborhood").val(data.bairro);

                            $("#state").val(data.uf);
                            $("#city").val(data.localidade);
                        }
                    )
                    if($(this).val() != "") {
                        $(".errorcep").html('');
                    }
                });











                function getBandeira(numero) {
                    let bins = {
                        visa: [/^4[0-9]{5}/],
                        mastercard: [/^5[1-5][0-9]{4}/, /^2[2-7][0-9]{4}/],
                        amex: [/^3[47][0-9]{3}/],
                        elo: [/^(636368|438935|504175|451416|509048|509067|509049|509069|509050|509074|509068|509040|509045|509051|509046|509066|509047|509042|509052|509043|509064|509040|36297[8-9]|5067[0-6][0-9]{2}|50677[0-8])/],
                        hipercard: [/^(606282|637095|637568|637599|637609|637612)/]
                    };

                    for (let bandeira in bins) {
                        for (let regex of bins[bandeira]) {
                            if (regex.test(numero)) {
                                return bandeira;
                            }
                        }
                    }
                    return null;
                }



                const zipCode = document.getElementById('zipcode');
                const cvvInput = document.getElementById('cvv');
                const cardNumberInput = document.getElementById('numero_cartao');


                const zip = new Inputmask('99999-999');
                const cvv = new Inputmask('999');
                const cardMask = new Inputmask('9999 9999 9999 9999');


                zip.mask(zipCode);
                cvv.mask(cvvInput);
                cardMask.mask(cardNumberInput);

                $("#numero_cartao").on("input", function() {
                    let numero = $(this).val().replace(/\D/g, ""); // Remove tudo que não for número
                    numero = numero.replace(/(.{4})/g, "$1 "); // Adiciona espaços a cada 4 dígitos
                    $("#cartao-numero").text(numero || "•••• •••• •••• ••••");
                    let bandeira = getBandeira(numero.replace(/\s/g, "").substring(0,6));
                    if(bandeira) {
                        $("#bandeira").val(bandeira);
                    }
                });

                // Atualiza o nome do titular
                $("#nome_titular").on("input", function() {
                    let nome = $(this).val().toUpperCase();
                    $("#cartao-nome").text(nome || "SEU NOME");
                });

                // Atualiza validade do cartão
                $("#mes, #ano").on("change", function() {
                    let mes = $("#mes").val() || "MM";
                    let ano = $("#ano").val() || "AA";
                    $("#cartao-validade").text(`${mes}/${ano}`);
                });

                // Atualiza CVV e vira o cartão
                $("#cvv").on("focus", function() {
                    $("#cartao").addClass("rotate-y-180");
                    $("#cartao-frente").addClass("opacity-0");
                    $("#cartao-verso").removeClass("opacity-0");
                });

                // Volta a mostrar a frente do cartão quando sai do CVV
                $("#cvv").on("blur", function() {
                    $("#cartao").removeClass("rotate-y-180");
                    $("#cartao-frente").removeClass("opacity-0");
                    $("#cartao-verso").addClass("opacity-0");
                });

                $("#cvv").on("input", function() {
                    let cvv = $(this).val().replace(/\D/g, "").substr(0, 4);
                    $("#cartao-cvv").text(cvv || "•••");
                });

                function validarCartaoCredito(numeroCartao) {
                    let numero = numeroCartao.replace(/\D/g, ""); // Remove tudo que não for número
                    let soma = 0;
                    let alternar = false;

                    for (let i = numero.length - 1; i >= 0; i--) {
                        let n = parseInt(numero.charAt(i), 10);

                        if (alternar) {
                            n *= 2;
                            if (n > 9) {
                                n -= 9;
                            }
                        }

                        soma += n;
                        alternar = !alternar;
                    }

                    return (soma % 10) === 0; // Se o resultado for divisível por 10, o cartão é válido
                }


                $("form[name='cadastrar_individual']").on('submit',function(e){
                    e.preventDefault();

                    let load = $(".ajax_load");
                    load.fadeIn(100).css("display", "flex");


                    let numero_cartao = $("#numero_cartao").val();

                    let cupom_promocional = $('#cupom_promocional').is(':checked') == true ? 1 : 0;


                    let bandeira_validar = getBandeira(numero_cartao.replace(/\s/g, "").substring(0,6));
                    if (!bandeira_validar) {
                        toastr.error("O número do cartão informado não corresponde a nenhuma bandeira válida.", "Erro");
                        return false;
                    }
                    if (!validarCartaoCredito(numero_cartao)) {
                        toastr.error("O número do cartão de crédito é inválido. Verifique e tente novamente.", "Erro");
                        return false;
                    }



                    let mes = $("#mes").val();
                    let ano = $("#ano").val();
                    let cvv = $("#cvv").val();
                    let bandeira = $("#bandeira").val();

                    let paymentToken = "";
                    let mascaraCartao = "";

                    checkout.getPaymentToken(
                        {
                            brand: bandeira,
                            number: numero_cartao,
                            cvv: cvv,
                            expiration_month: mes,
                            expiration_year: ano
                        },
                        function(error,response) {

                            if(error) {
                                load.fadeOut(100).css("display", "none");
                            } else {
                                paymentToken = response.data.payment_token;
                                mascaraCartao = response.data.card_mask;

                                let csrf = $('meta[name="csrf-token"]').attr('content');
                                $("input[name='_token']").val(csrf);

                                let formData = new FormData($("form[name='cadastrar_individual']")[0]);
                                formData.append("paymentToken", paymentToken);
                                formData.append("mascaraCartao", mascaraCartao);
                                formData.append("cupom_promocional",cupom_promocional);

                                $.ajax({
                                    url:"{{ route('assinaturas.trial.store') }}",
                                    method:"POST",
                                    data: formData,
                                    contentType: false,
                                    processData: false,
                                    headers: {
                                        'X-CSRF-TOKEN': csrf
                                    },
                                    beforeSend: function () {
                                        //load.fadeIn(100).css("display", "flex");
                                    },
                                    success:function(res) {


                                        load.fadeOut(100).css("display", "none");
                                        if (res.success && res.redirect) {
                                            window.location.href = res.redirect;
                                        }

                                    },
                                    error: function (xhr) {
                                        load.fadeOut(100).css("display", "none");
                                        if (xhr.status === 422) {
                                            load.fadeOut(100).css("display", "none");
                                            let errors = xhr.responseJSON.errors;
                                            $.each(errors, function (key, value) {
                                                toastr.error(value[0], "Erro");
                                            });
                                        } else if (xhr.responseJSON && xhr.responseJSON.message) {
                                            toastr.error(xhr.responseJSON.message, "Erro");
                                        } else {
                                            toastr.error("Ocorreu um erro inesperado. Tente novamente.", "Erro");
                                        }
                                    }
                                });

                            }
                        }
                    );













                    // let nome_titular = $("#nome_titular").val();
                    // let mes = $("#mes").val();
                    // let ano = $("#ano").val();
                    // let cvv = $("#cvv").val();
                    // let bandeira = $("#bandeira").val();
                    //
                    //
                    // let nome = $("#name").val();
                    // let email_usuario = $("#email").val();
                    // let cpf = $("#cpf").val();
                    // let telefone = $("#phone").val();
                    // let password = $("#password").val();
                    // let password_confirmation = $("#password_confirmation").val();
                    // let birth_date = $("#birth_date").val();
                    // let zipcode = $("#zipcode").val();
                    // let street = $("#street").val();
                    // let number = $("#number").val();
                    // let city = $("#city").val();
                    // let neighborhood = $("#neighborhood").val();
                    // let state = $("#state").val();




                    return false;
                });




            });
        </script>

    @endsection


</x-guest-layout>
