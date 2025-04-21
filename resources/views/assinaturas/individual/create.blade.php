<x-guest-layout>
    <!-- Session Status -->
    <x-auth-session-status class="mb-1" :status="session('status')" />
    <section class="w-full rounded-lg">
        <img src="{{asset('logo_bm_1.png')}}" class="mx-auto my-1 w-32 md:w-32" alt="">
        <form method="POST" name="cadastrar_individual" class="p-1 flex flex-wrap gap-4" enctype="multipart/form-data">
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <!--Lado Esquerdo-->
            <div class="w-full md:w-[48%]">
                <fieldset class="border border-gray-300 p-1 rounded-lg">
                    <legend class="text-lg font-semibold text-white">Dados Pessoais</legend>
                    <div class="mb-2">
                        <label for="name" class="block mb-1 font-medium text-white text-sm">Nome</label>
                        <input type="text" name="name" id="name" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" placeholder="Seu Nome" required />
                    </div>
                    <div class="mb-2">
                        <label for="email" class="block mb-1 font-medium text-white text-sm">Email</label>
                        <input type="email" name="email" id="email" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" placeholder="Seu Email" required />
                    </div>
                    <div class="flex flex-col md:flex-row gap-4 mb-3">
                        <div class="w-full md:w-1/2">
                            <label for="birth_date" class="block mb-1 font-medium text-white text-sm">Data de Nascimento</label>
                            <input type="date" name="birth_date" id="birth_date" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                        </div>
                        <div class="w-full md:w-1/2">
                            <label for="cpf" class="block mb-1 font-medium text-white text-sm">CPF</label>
                            <input type="text" name="cpf" id="cpf" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" placeholder="XXX.XXX.XXX-XX" required />
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="phone" class="block mb-1 font-medium text-white text-sm">Telefone</label>
                        <input type="text" name="phone" id="phone" class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" placeholder="(XX) X XXXX-XXXX" required />
                    </div>
                    <div class="mb-2">
                        <label for="imagem" class="block mb-1 font-medium text-white text-sm">Imagem</label>
                        <input type="file" name="imagem" id="imagem" class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 p-1.5" />
                    </div>
                </fieldset>

                <fieldset class="border border-gray-300 px-1 py-3 rounded-lg">
                    <legend class="text-lg font-semibold text-white">Senha</legend>
                    <div class="mb-5">
                        <label for="password" class="block mb-1 font-medium text-white text-sm">Senha</label>
                        <div class="relative">
                            <input type="password" name="password" id="password" class="bg-gray-50 border text-gray-950 border-gray-300 text-sm block w-full p-1.5 rounded-lg" placeholder="Sua Senha" required />
                            <button type="button" id="togglePassword" class="absolute right-2 top-2 cursor-pointer" style="color:black;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="showIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden" id="hideIcon">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>

                    </div>
                    <div class="mb-5">
                        <label for="password_confirmation" class="block mb-1 font-medium text-white text-sm">Confirmar Senha</label>
                        <div class="relative">
                            <input type="password" name="password_confirmation" id="password_confirmation" class="bg-gray-50 border text-gray-950 border-gray-300 text-sm block w-full p-1.5 rounded-lg" placeholder="Confirmar Senha" required />
                            <button type="button" id="togglePasswordConfirmation" class="absolute right-2 top-2 cursor-pointer" style="color:black;">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6" id="showIconConfirmation">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                </svg>
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 hidden" id="hideIconConfirmation">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.451 10.451 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.522 10.522 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                                </svg>
                            </button>
                        </div>

                    </div>
                </fieldset>





            </div>
            <!--Fim Lado Esquerdo-->

            <!--Lado Direito-->

            <div class="w-full md:w-[49%]">

                <fieldset class="border border-gray-300 p-1 rounded-lg">
                    <legend class="text-lg font-semibold text-white">Endereço</legend>

                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-1/3">
                                <label for="zipcode" class="block mb-1 font-medium text-white text-sm">CEP</label>
                                <input type="text" name="zipcode" id="zipcode" placeholder="XXXXX-XXX"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                            </div>

                            <div class="w-full md:w-1/2">
                                <label for="street" class="block mb-1 font-medium text-white text-sm">Rua</label>
                                <input type="text" name="street" id="street" placeholder="Rua"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                            </div>
                            <div class="w-full md:w-1/6">
                                <label for="number" class="block mb-1 font-medium text-white text-sm">Número</label>
                                <input type="text" name="number" id="number" placeholder="Nº"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg">
                            </div>
                        </div>

                        <div class="flex flex-col md:flex-row gap-4">
                            <div class="w-full md:w-1/3">
                                <label for="city" class="block mb-1 font-medium text-white text-sm">Cidade</label>
                                <input type="text" name="city" id="city" placeholder="Cidade"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                            </div>
                            <div class="w-full md:w-1/2">
                                <label for="neighborhood" class="block mb-1 font-medium text-white text-sm">Bairro</label>
                                <input type="text" name="neighborhood" id="neighborhood" placeholder="Bairro"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                            </div>
                            <div class="w-full md:w-1/6">
                                <label for="state" class="block mb-1 font-medium text-white text-sm">Estado</label>
                                <input type="text" name="state" id="state" placeholder="UF"
                                       class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 rounded-lg" required>
                            </div>
                        </div>

                </fieldset>

                <fieldset class="border border-gray-300 p-1 rounded-lg">
                    <legend class="text-lg font-semibold text-white">Dados Cartão</legend>
                    <div class="mb-2">
                        <label for="numero_cartao" class="block mb-1 font-medium text-white text-sm">Número do Cartão</label>
                        <input type="text" name="numero_cartao" required id="numero_cartao" placeholder="XXXX XXXX XXXX XXXX"
                               class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 focus:border-transparent focus:ring-0 focus:outline-none rounded-lg">
                    </div>

                    <div class="mb-2">
                        <label for="nome_titular" class="block mb-1 font-medium text-white text-sm">Nome do Titular</label>
                        <input type="text" name="nome_titular" required id="nome_titular" placeholder="Nome do Titular do Cartão"
                               class="bg-gray-50 border border-gray-300 text-gray-950 text-sm block w-full p-1.5 focus:border-transparent focus:ring-0 focus:outline-none rounded-lg">
                    </div>

                    <div class="flex justify-between gap-2">
                        <div class="w-1/3">
                            <label for="mes" class="block mb-1 font-medium text-white text-sm">Mês</label>
                            <select name="mes" id="mes" required
                                    class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                                <option value="">MM</option>
                                <option value="01">01</option>
                                <option value="02">02</option>
                                <option value="03">03</option>
                                <option value="04">04</option>
                                <option value="05">05</option>
                                <option value="06">06</option>
                                <option value="07">07</option>
                                <option value="08">08</option>
                                <option value="09">09</option>
                                <option value="10">10</option>
                                <option value="11">11</option>
                                <option value="12">12</option>
                            </select>
                        </div>

                    <div class="w-1/3">
                        <label for="ano" class="block mb-1 font-medium text-white text-sm">Ano</label>
                        <select name="ano" id="ano" required class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                            <option value="">ANO</option>
                            <option value="25">2025</option>
                            <option value="26">2026</option>
                            <option value="27">2027</option>
                            <option value="28">2028</option>
                            <option value="29">2029</option>
                            <option value="30">2030</option>
                            <option value="31">2031</option>
                            <option value="32">2032</option>
                            <option value="33">2033</option>
                            <option value="34">2034</option>
                            <option value="35">2035</option>
                            <option value="36">2036</option>
                            <option value="37">2037</option>
                            <option value="38">2038</option>
                            <option value="39">2039</option>
                            <option value="40">2040</option>
                            <option value="41">2041</option>
                            <option value="42">2042</option>
                            <option value="43">2043</option>
                            <option value="44">2044</option>
                            <option value="45">2045</option>
                            <option value="46">2046</option>
                            <option value="47">2047</option>
                            <option value="48">2048</option>
                            <option value="49">2049</option>
                            <option value="50">2050</option>
                        </select>
                    </div>

                    <div class="w-1/3">
                        <label for="cvv" class="block mb-1 font-medium text-white text-sm">CVV</label>
                        <input type="text" name="cvv" required id="cvv" placeholder="XXX"
                               class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-1.5">
                    </div>

                </div>
                </fieldset>

                <div id="cartao" class="relative w-full max-w-md mx-auto md:max-w-full md:h-52 h-42 bg-gradient-to-r mt-1 from-blue-700 to-blue-900 rounded-xl shadow-lg transform transition-transform duration-500">
                    <!-- Frente do Cartão -->
                    <div id="cartao-frente" class="absolute inset-0 flex flex-col justify-between p-2 text-white">
                        <div class="flex justify-between">
                            <span class="text-sm">Cartão de Crédito</span>
                            <span class="text-sm">💳</span>
                        </div>
                        <div class="text-center text-lg tracking-widest" id="cartao-numero">•••• •••• •••• ••••</div>
                        <div class="flex justify-between">
                            <span class="text-sm">Nome:</span>
                            <span class="text-sm">Validade:</span>
                        </div>
                        <div class="flex justify-between">
                            <span class="text-sm uppercase" id="cartao-nome">SEU NOME</span>
                            <span class="text-sm" id="cartao-validade">MM/AA</span>
                        </div>
                    </div>

                    <!-- Verso do Cartão (Mostra o CVV) -->
                    <div id="cartao-verso" class="absolute inset-0 flex flex-col justify-center items-center bg-gray-900 text-white rounded-xl transform rotate-y-180 opacity-0 transition-opacity duration-500">
                        <div class="w-full bg-black h-8"></div>
                        <span class="mt-4 text-lg">CVV</span>
                        <div class="text-2xl bg-gray-800 px-6 py-2 rounded-lg" id="cartao-cvv">•••</div>
                    </div>
                </div>


                <input type="hidden" name="bandeira" id="bandeira">


            </div>

            <!--Fim Lado Direito-->


            <div class="w-full mx-auto my-1">
                <button type="submit" class="text-white bg-gradient-to-r from-cyan-400 via-cyan-500 to-cyan-600 hover:bg-gradient-to-br dark:focus:ring-cyan-800 font-medium px-5 py-2 text-center me-2 mb-1 w-full rounded-lg">Cadastrar</button>
            </div>
        </form>
    </section>

    @section('scripts')
        <script>

            const passwordInput = document.getElementById('password');
            const passwordInputConfirmation = document.getElementById('password_confirmation');
            const toggleButton = document.getElementById('togglePassword');
            const toggleButtonConfirmation = document.getElementById('togglePasswordConfirmation');
            const showIcon = document.getElementById('showIcon');
            const showIconConfirmation = document.getElementById('showIconConfirmation');
            const hideIcon = document.getElementById('hideIcon');
            const hideIconConfirmation = document.getElementById('hideIconConfirmation');

            toggleButton.addEventListener('click', () => {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    showIcon.style.display = 'none';
                    hideIcon.style.display = 'block';
                } else {
                    passwordInput.type = 'password';
                    showIcon.style.display = 'block';
                    hideIcon.style.display = 'none';
                }
            });

            toggleButtonConfirmation.addEventListener('click', () => {
                if (passwordInputConfirmation.type === 'password') {
                    passwordInputConfirmation.type = 'text';
                    showIconConfirmation.style.display = 'none';
                    hideIconConfirmation.style.display = 'block';
                } else {
                    passwordInputConfirmation.type = 'password';
                    showIconConfirmation.style.display = 'block';
                    hideIconConfirmation.style.display = 'none';
                }
            });





            $gn.ready(function(checkout){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                function TestaCPF(strCPF) {
                    var Soma;
                    var Resto;
                    Soma = 0;

                    if (strCPF == "00000000000") return false;
                    for (i=1; i<=9; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (11 - i);
                    Resto = (Soma * 10) % 11;
                    if ((Resto == 10) || (Resto == 11))  Resto = 0;
                    if (Resto != parseInt(strCPF.substring(9, 10)) ) return false;
                    Soma = 0;
                    for (i = 1; i <= 10; i++) Soma = Soma + parseInt(strCPF.substring(i-1, i)) * (12 - i);
                    Resto = (Soma * 10) % 11;
                    if ((Resto == 10) || (Resto == 11))  Resto = 0;
                    if (Resto != parseInt(strCPF.substring(10, 11) ) ) return false;
                    return true;
                }



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

                const phoneInput = document.getElementById('phone');
                const cpfInput = document.getElementById('cpf');
                const zipCode = document.getElementById('zipcode');
                const cvvInput = document.getElementById('cvv');
                const cardNumberInput = document.getElementById('numero_cartao');
                const im = new Inputmask('(99) 9 9999-9999');
                const cpf = new Inputmask('999.999.999-99');
                const zip = new Inputmask('99999-999');
                const cvv = new Inputmask('999');
                const cardMask = new Inputmask('9999 9999 9999 9999');
                im.mask(phoneInput);
                cpf.mask(cpfInput);
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
                    if(!TestaCPF($("#cpf").val().replace(/[^0-9]/g,''))) {
                        toastr.error("O CPF informado é inválido. Verifique e tente novamente.", "Error",{
                            toastClass: "toast-custom-width"
                        });
                        return false;
                    }

                    let numero_cartao = $("#numero_cartao").val();
                    //let bandeira_validar = getBandeira(numero_cartao);
                    let bandeira_validar = getBandeira(numero_cartao.replace(/\s/g, "").substring(0,6));


                    if (!bandeira_validar) {
                        toastr.error("O número do cartão informado não corresponde a nenhuma bandeira válida.", "Erro");
                        return false;
                    }

                    if (!validarCartaoCredito(numero_cartao)) {
                        toastr.error("O número do cartão de crédito é inválido. Verifique e tente novamente.", "Erro");
                        return false;
                    }

                    let nome_titular = $("#nome_titular").val();
                    let mes = $("#mes").val();
                    let ano = $("#ano").val();
                    let cvv = $("#cvv").val();
                    let bandeira = $("#bandeira").val();


                    let nome = $("#name").val();
                    let email_usuario = $("#email").val();
                    let cpf = $("#cpf").val();
                    let telefone = $("#phone").val();
                    let password = $("#password").val();
                    let password_confirmation = $("#password_confirmation").val();
                    let birth_date = $("#birth_date").val();
                    let zipcode = $("#zipcode").val();
                    let street = $("#street").val();
                    let number = $("#number").val();
                    let city = $("#city").val();
                    let neighborhood = $("#neighborhood").val();
                    let state = $("#state").val();


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

                                $.ajax({
                                    url:"{{ route('assinaturas.individual.store') }}",
                                    method:"POST",
                                    data: {
                                        paymentToken,
                                        mascaraCartao,
                                        name: nome,
                                        email:email_usuario,
                                        cpf,
                                        phone: telefone,
                                        password,
                                        password_confirmation,
                                        birth_date,
                                        zipcode,
                                        street,
                                        number,
                                        city,
                                        neighborhood,
                                        state
                                    },
                                    beforeSend: function () {
                                        load.fadeIn(100).css("display", "flex");

                                    },
                                    success:function(res) {
                                        //if(res.success == true) {
                                            load.fadeOut(100).css("display", "none");
                                        //}
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

                    return false;
                });




            });
        </script>

    @endsection


</x-guest-layout>
