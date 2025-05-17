<x-app-layout>
    <!-- Botão redondo -->
    <div class="flex p-2 mt-2 justify-between items-center w-full md:mx-auto md:w-[99%] bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] rounded">
        <!-- Botão para abrir a modal -->
        <!-- Botão de Abrir Modal -->
        <div class="flex items-center flex-wrap">
            <!-- Botão -->


            @if(!auth()->user()->estaEmTrial())
                <p class="text-sm text-white dark:text-gray-400 text-center">
                    Valor por usuário <strong class="text-blue-200 font-bold">R$ 29,90</strong>
                </p>
            @endif

            @if(auth()->user()->estaEmTrial())
                <p class="text-sm text-white dark:text-gray-400 text-center">
                    Valor por usuário <strong class="text-blue-200 font-bold">R$ 29,90</strong>
                </p>
            @endif


        </div>



       <div class="flex items-center">
           <p>
               <span class="text-white">📈 Valor Total:</span>
               <strong class="text-red-500 text-sm preco_total">R$ {{ number_format($valor, 2, ',', '.') }}</strong>
           </p>
           <p class="text-white ml-2">|</p>
           <a class="p-1 bg-orange-500 text-white rounded ml-2" href="{{route('assinatura.edit')}}">Pagar</a>

       </div>



        <!-- Fundo de sobreposição (backdrop) -->
        <div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>



    </div>


    <!--Modal Editar-->
    <x-modals.edit-user-modal />
    <!--Fim Modal Editar-->

    <!-- Modal Cadastrar -->
    <x-modals.cadastrar-user-modal />
    <!-- Fim Modal Cadastrar -->


    <div class="w-[99%] mx-auto flex justify-between">


        <!-- Coluna da esquerda com título + grid -->
        <div class="md:w-[32%] mt-3">

            <h3 class="text-white font-semibold text-lg mb-1 text-sm">Gerenciador de Layout e UF de Referência</h3>

            <div class="flex w-full md:w-[94%] justify-around bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] border-white border mt-1 mb-1 rounded p-1 items-center">
                <label  for="regiao" class="block text-sm font-medium text-white mb-1 w-[50%]">Região (UF) de Preferência</label>
                <select name="regiao" id="regiao"
                        class="block w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm
           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500
           text-gray-700 bg-white  w-[20%]">
                    <option value="" disabled selected>UF</option>
                    @foreach($cidades as $uf => $grupo)
                        <option value="{{ $uf }}" {{ auth()->user()->uf_preferencia === $uf ? 'selected' : '' }}>{{ $uf }}</option>
                    @endforeach
                </select>
            </div>


            <!-- Grid de Layouts -->
            <div class="grid grid-cols-2 gap-1">
                @foreach($layouts as $layout)
                    <label style="height: 250px;max-height: 250px;width:210px;max-width:210px;" class="layout relative group flex flex-col items-center border p-0.5 rounded bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px]">
                        <!-- Input Radio -->
                        <input
                            type="radio"
                            id="layout_{{ $layout->id }}"
                            name="layout_id"
                            value="{{ $layout->id }}"
                            {{ $layout->id == $user->layout_id ? 'checked' : '' }}
                            class="w-[70%] mb-1 cursor-pointer appearance-none border-4 border-white rounded-full transition-all duration-300 group-hover:scale-110 group-hover:z-10 group-hover:shadow-xl"
                        />

                        <!-- Imagem -->
                        <div class="w-full" style="height: 190px;">
                            <img
                                src="{{ $folder ? asset($folder.'/'.$layout->imagem) : asset($layout->imagem) }}"
                                alt="{{ $layout->nome }}"
                                class="w-[80%] mx-auto rounded-lg transition-all duration-300"
                                style="height:100%;"
                            />
                        </div>

                        <!-- Nome do Layout -->
                        <p class="mt-1 text-center text-sm font-semibold text-white drop-shadow-sm">
                            {{ $layout->nome }}
                        </p>
                    </label>
                @endforeach
            </div>


        </div>

        <!-- Tabela de usuários à direita -->
        <div class="w-full md:w-[65%] mt-1">
            <!-- Título -->
            <div class="flex items-center">
                <h3 class="text-white font-semibold text-sm">Usúarios Adicionais</h3>
                <button id="toggle-modal"
                        class="w-8 ml-3 h-8 mr-8 flex items-center justify-center rounded-full bg-green-500 border-white border-4 text-white text-2xl font-bold shadow-lg transition">
                    +
                </button>
            </div>
            <div id="user-table" class="max-h-[550px] h-[550px] overflow-y-auto rounded-lg scrollbar-thin scrollbar-thumb-yellow-500 scrollbar-track-white/10">
                @include('partials.user-table', ['users' => $users])
            </div>
        </div>

    </div>

@section('css')
        <style>

            #user-table::-webkit-scrollbar {
                width: 8px;
            }

            #user-table::-webkit-scrollbar-track {
                background: rgba(255, 255, 255, 0.1); /* trilho */
            }

            #user-table::-webkit-scrollbar-thumb {
                background-color: #facc15; /* amarelo Tailwind: yellow-400 */
                border-radius: 8px;
            }

            /* Firefox */
            #user-table {
                scrollbar-color: #facc15 rgba(255, 255, 255, 0.1);
                scrollbar-width: thin;
            }




            input[type="radio"] {

                width: 20px;

                height: 20px;

                background-color: white;

                border-radius: 50%;

                border: 4px solid white;

                transition: all 0.3s ease-in-out;

            }



            input[type="radio"]:checked {

                border-color: #7B3AED;

                background-color: #7B3AED;

                box-shadow: 0 0 10px rgba(123, 58, 237, 0.6);

            }



            input[type="radio"]:hover {

                transform: scale(1.2);

            }
        </style>
    @endsection





    @section('scripts')
        <script>

            function openPaymentModal() {
                document.getElementById('paymentModal').classList.remove('hidden');
            }

            function closePaymentModal() {
                document.getElementById('paymentModal').classList.add('hidden');
            }

            // Toast com link
            function showUpgradeToast() {
                Toastify({
                    text: 'Limite trial atingido! <a href="#" onclick="openPaymentModal()" class="font-semibold underline ml-2">Fazer upgrade</a>',
                    duration: -1, // Toast permanente
                    gravity: 'top',
                    position: 'right',
                    backgroundColor: '#eab308',
                    escapeMarkup: false,
                    className: '!bg-yellow-600 !text-white',
                    stopOnFocus: true
                }).showToast();
            }


            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('user-modal');
                const toggleModalButton = document.getElementById('toggle-modal');
                const closeModalButton = document.getElementById('close-modal');
                const cancelModalButton = document.getElementById('cancel-modal');
                const userForm = document.getElementById('user-form');

                const phoneInput = document.getElementById('phone');
                const im = new Inputmask('(99) 9 9999-9999');
                im.mask(phoneInput);

                const openModal = () => {
                    modal.classList.remove('hidden', 'translate-x-full');
                    modal.classList.add('translate-x-0');
                    document.body.classList.add('overflow-hidden');
                };

                const closeModal = () => {
                    modal.classList.add('translate-x-full');
                    modal.classList.remove('translate-x-0');
                    setTimeout(() => {
                        modal.classList.add('hidden');
                        userForm.reset();
                        document.body.classList.remove('overflow-hidden'); // Restaurar scroll
                    }, 500);
                };

                if (toggleModalButton && modal) {
                    toggleModalButton.addEventListener('click', function () {
                        if (modal.classList.contains('hidden')) {
                            openModal();
                        } else {
                            closeModal();
                        }
                    });
                }

                if (closeModalButton) {
                    closeModalButton.addEventListener('click', closeModal);
                }

                if (cancelModalButton) {
                    cancelModalButton.addEventListener('click', closeModal);
                }

                // Fechar modal ao clicar fora
                document.addEventListener('click', function (event) {
                    if (!modal.contains(event.target) && !toggleModalButton.contains(event.target)) {
                        closeModal();
                    }
                });

                if (userForm) {
                    userForm.addEventListener('submit', function (event) {
                        event.preventDefault();

                        const phoneInput = document.getElementById('phone');
                        const phonePattern = /^\(\d{2}\) \d \d{4}-\d{4}$/; // Regex para o formato (99) 9 9999-9999

                        if (!phonePattern.test(phoneInput.value)) {
                            toastr.error("Por favor, insira um telefone válido.", "Erro");
                            event.preventDefault();
                            return;
                        }


                        let load = document.querySelector(".ajax_load");
                        load.style.display = "flex";
                        const formData = new FormData(userForm);
                        fetch("{{ route('storeUser') }}", {
                            method: 'POST',
                            body: formData,
                        })
                            .then(response => response.json())
                            .then(data => {

                                load.style.display = "none";
                                if (data.success === 'true' || data.success === true) {
                                    document.getElementById('user-table').innerHTML = data.html;
                                    if(data.emails_cobrados >= 1) {
                                        document.querySelector('.preco_total').textContent  = data.preco_total;

                                    }
                                    closeModal();

                                } else if(data.limite) {
                                    const toast = toastr.warning(
                                        'Limite de 3 usuários atingido no trial. <a href="{{route('assinatura.edit')}}" id="upgrade-link" class="text-blue-200 hover:text-blue-400 underline">Clique aqui para assinar</a>',
                                        'Limite Excedido',
                                        {
                                            timeOut: 30000, // 30 segundos
                                            progressBar: true,
                                            closeButton: true,
                                            allowHtml: true, // Permite HTML no conteúdo
                                            onclick: function() {
                                                //toastr.clear(this);
                                                //openPaymentModal();
                                            }
                                        }
                                    );
                                } else {
                                    toastr.error("Erro ao tentar cadastrar usuario.", "Erro");
                                    //console.log(data);
                                    //alert("Erro ao cadastrar o usuário");
                                }
                            })
                            .catch(error => {
                                load.style.display = "none";
                                toastr.error("Erro ao tentar cadastrar usuario.", "Erro");
                                //console.log('Error:', error);
                                //alert('Erro ao enviar os dados.');
                            });
                    });
                }
            });

            $(document).ready(function(){
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                const openModalButtonEdit = document.getElementById('openModal');
                const closeModalButtonEdit = document.getElementById('closeModal');
                const modalEdit = document.getElementById('editUserModal');

                $("body").on('change','#regiao',function(){
                   let regiao = $(this).val();
                   $.ajax({
                      url:"{{route('gerenciamento.regiao')}}",
                      method:"POST",
                      data: {regiao},
                      success:function(res) {

                          if(res == true) {
                              toastr.success("Região alterada com sucesso", 'Sucesso');
                          } else {
                              toastr.error("Erro ao alterar região", 'Error');
                          }
                      }
                   });
                });

                $("input[name='layout_id']").on('change',function(){

                    let valor = $(this).val();
                    let load = $(".ajax_load");
                    $.ajax({
                        url:"{{route('layouts.select')}}",
                        method:"POST",
                        data: {valor},
                        beforeSend: function () {
                            load.fadeIn(100).css("display", "flex");
                        },
                        success:function(res) {
                            load.fadeOut(100).css("display", "none");
                            if(res == "sucesso") {
                                toastr.success("Layout trocado com sucesso.", "Sucesso",{
                                    toastClass: "toast-custom-width"
                                });
                            } else {
                                toastr.error("Erro ao mudar de Layout. Verifique e tente novamente.", "Error",{
                                    toastClass: "toast-custom-width"
                                });
                            }
                        }
                    });

                });




                $('#email').on('input', function() {
                    const emailInput = $(this).val();
                    const emailError = $('#email-error');
                    const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+\.com$/; // Verifica se termina com .com

                    if (!regex.test(emailInput)) {
                        emailError.show(); // Exibe a mensagem de erro
                    } else {
                        emailError.hide(); // Esconde a mensagem de erro
                    }
                });





                // Abrir a modal
                $("body").on('click','#openModal',function(){
                    let id = $(this).attr('data-id');
                    $.ajax({
                        url: `{{route('users.get')}}`, // Rota definida no Laravel
                        method: 'POST',
                        data: {
                            id
                        },
                        success: function (data) {

                            // Preenche o formulário com os dados do usuário
                            $('#name_edit').val(data.name);
                            $('#email_edit').val(data.email);
                            $('#phone_edit').val(data.phone);
                            $('#id_edit').val(data.id);

                            // Se tiver imagem, exibe na visualização
                            if (data.imagem) {

                                $('#imagem_edit').attr('src',data.imagem);
                            }
                        },
                        error: function (xhr) {
                            console.log('Erro ao buscar os dados do usuário:', xhr.responseJSON);
                            alert('Erro ao buscar os dados do usuário.');
                        }
                    });
                    modalEdit.classList.remove('hidden');
                    modalEdit.classList.add('flex');
                });

                $("body").on('click','#closeModal',function(){
                    modalEdit.classList.add('hidden');
                    modalEdit.classList.remove('flex');
                });

                // Fechar a modal ao clicar fora dela
                modalEdit.addEventListener('click', (e) => {
                    if (e.target === modalEdit) {
                        modalEdit.classList.add('hidden');
                        modalEdit.classList.remove('flex');
                    }
                });

                $(document).on('change', '.toggle-switch', function () {
                    let load = $(".ajax_load");
                    load.fadeIn(100).css("display", "flex");
                    let userId = $(this).data('id');
                    let status = $(this).is(':checked');

                    $.ajax({
                        url:"{{route('users.alterar')}}",
                        method:"POST",
                        data: {
                            userId,
                            status
                        },
                        success:function(res) {
                            console.log(res);
                            load.fadeOut(100).css("display", "none");

                            document.querySelector('.preco_total').textContent  = res.preco_total;


                        }
                    });
                });


                $("body").on("submit", "#editUserForm", function (e) {
                    e.preventDefault();
                    let load = $(".ajax_load");
                    load.fadeIn(100).css("display", "flex");
                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('users.update') }}", // Rota definida no Laravel
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            load.fadeOut(100).css("display", "none");
                            if (response.success) {
                                //alert(response.message);
                                // Atualiza os dados na interface ou fecha a modal
                                location.reload(); // Recarrega a página para refletir as alterações
                            }
                        },
                        error: function (xhr) {
                            console.log("Erro ao atualizar os dados:", xhr.responseJSON);
                            //alert("Erro ao atualizar os dados.");
                        },
                    });
                });


                $("body").on('click', '.delete', function(e) {
                    e.preventDefault();
                    let id = $(this).attr('data-id');

                    // Exibe a confirmação com SweetAlert2
                    Swal.fire({
                        title: "Tem certeza?",
                        text: "Você não poderá reverter esta ação!",
                        icon: "warning",
                        showCancelButton: true,
                        confirmButtonColor: "#d33",
                        cancelButtonColor: "#3085d6",
                        confirmButtonText: "Sim, excluir!",
                        cancelButtonText: "Cancelar"
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Se confirmado, faz a requisição AJAX para deletar o usuário
                            $.ajax({
                                url: "{{route('deletar.user')}}",
                                method: "POST",
                                data: { id: id },
                                success: function(res) {
                                    if (res.success) {
                                        // Atualiza a tabela de usuários
                                        $("#user-table").html(res.html);

                                        // Exibe um Toastr de sucesso
                                        toastr.success("Usuário excluído com sucesso!", 'Sucesso',{

                                            toastClass: "toast-custom-width" // Aplica a classe personalizada

                                        });

                                    } else {
                                        toastr.error("Ocorreu um erro ao excluir o usuário.", "Erro");
                                    }
                                },
                                error: function() {
                                    toastr.error("Erro ao tentar excluir o usuário.", "Erro");
                                }
                            });
                        }
                    });
                    return false;
                });
            });

            document.getElementById('imagem_edit').addEventListener('click', function() {
                document.getElementById('avatar-input').click();
            });

            document.getElementById('avatar-input').addEventListener('change', function(event) {
                if (event.target.files.length > 0) {

                    let id = $("#id_edit").val();

                    const form = new FormData();
                    form.append('imagem',event.target.files[0]);
                    form.append('id',id);


                    fetch('/profile/user/imagem/atualizar', {
                        method: 'POST',
                        body: form,
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        }
                    }).then(response => response.json())
                        .then(data => {
                            if (data.message) {
                                // Atualiza a imagem de perfil no DOM
                                const userAvatar = document.getElementById('imagem_edit');
                                const newSrc = URL.createObjectURL(event.target.files[0]);
                                userAvatar.src = newSrc;
                                document.getElementById('user-table').innerHTML = data.html;
                            } else {
                                console.error(data.error);
                            }
                        }).catch(error => {
                        console.error('Erro:', error);
                    });
                }
            });




        </script>
    @endsection
</x-app-layout>
