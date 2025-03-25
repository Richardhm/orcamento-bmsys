<x-app-layout>
    <!-- Botão redondo -->
    <div class="flex md:justify-end justify-center mt-4 md:mr-56 relative">
        <!-- Botão para abrir a modal -->


            <!-- Botão de Abrir Modal -->
        <div class="flex items-center flex-wrap">

            <div class="w-full bg-yellow-500 rounded-full text-center mt-2 items-center border-black border-2 relative md:hidden">
                    <span class="text-lg text-white">
                        para cadastrar clique abaixo
                    </span>
            </div>

            <!-- Braço esquerdo -->
            <div class="flex items-center">
                <div class="h-6 w-48 bg-yellow-500 rounded-l-full mt-8 border-black border-2 relative hidden md:block">
                    <span class="absolute -top-0 left-24 transform -translate-x-1/2 text-sm text-white whitespace-nowrap">
                        para cadastrar clique aqui
                    </span>
                </div>
                <div class="w-8 h-12 text-5xl -ml-1.5 mr-8">👉</div>
            </div>

            <!-- Botão -->
            <button id="toggle-modal"
                    class="w-16 h-16 flex items-center justify-center rounded-full bg-yellow-500 border-black border-4 text-white text-4xl font-bold shadow-lg transition">
                +
            </button>

            <!-- Braço direito com texto -->
            <div class="flex items-center relative">
                <div class="w-8 h-12 text-5xl">👈</div>
                <div class="h-6 w-48 bg-yellow-500 ml-7 mt-8 rounded-r-full relative hidden md:block" style="border:3px solid black;">
                    <span class="absolute -top-0 left-24 transform -translate-x-1/2 text-sm text-white whitespace-nowrap">
                        para cadastrar clique aqui
                    </span>
                </div>
            </div>
        </div>


        <!-- Fundo de sobreposição (backdrop) -->
        <div id="modal-backdrop" class="fixed inset-0 bg-black bg-opacity-50 hidden z-40"></div>



    </div>

    <!-- Modal centralizada -->
    <div id="user-modal"
         class="fixed inset-0 hidden flex items-center justify-center z-50">
        <div class="bg-white shadow-lg rounded-lg p-6 w-96 max-h-[80vh] overflow-auto relative">
            <!-- Cabeçalho da modal -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Cadastrar Usuário</h2>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700 text-2xl font-bold">&times;</button>
            </div>

            <!-- Formulário -->
            <form id="user-form" action="{{ route('storeUser') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name" id="name" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email" id="email" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">

                </div>

                <div class="mb-4">
                    <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                    <input type="text" name="phone" id="phone" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">Imagem do Usuário</label>
                    <input type="file" name="image" id="image" accept="image/*"
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="flex justify-end">
                    <button type="button" id="cancel-modal"
                            class="bg-gray-300 text-gray-700 px-4 py-2 rounded-lg shadow hover:bg-gray-400 transition mr-2">
                        Cancelar
                    </button>
                    <button type="submit"
                            class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-600 transition">
                        Salvar
                    </button>
                </div>
            </form>
        </div>
    </div>






    <div class="mt-7 w-full">
        <section class="flex md:justify-around flex-wrap w-full">
            <div class="md:w-[28%] mx-2 sm:w-full bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] dark:bg-gray-800 py-10 rounded-lg shadow-md flex flex-col justify-between h-full">
                <!-- 📌 Header do Card -->
                <div class="border-b pb-3">
                    <h2 class="text-2xl font-bold text-white dark:text-white text-center">
                        📩 Sua Assinatura
                    </h2>
                    <p class="text-lg text-white dark:text-gray-400 text-center mt-2">
                        Sua assinatura inclui <strong class="text-blue-200 font-bold">{{ $assinatura->emails_permitidos }}</strong> e-mails. Acima disso, é cobrado <strong class="text-red-500">R$ 25</strong> por e-mail.
                    </p>
                </div>

                <!-- 📌 Corpo Centralizado -->
                <div class="flex flex-col items-center justify-center flex-1 text-lg font-medium text-gray-700 dark:text-gray-300 space-y-3">
                    <p>
                        <span class="text-white">📧 Emails Atuais:</span>
                        <strong class="text-blue-200 text-2xl email_atuais">{{ $assinatura->emails_extra }}</strong>
                    </p>
                    <p>
                        <span class="text-white">💰 Preço Base:</span>
                        <strong class="text-green-500 text-2xl">R$ 129,90</strong>
                    </p>
                    <p>
                        <span class="text-white">📈 Preço Total:</span>
                        <strong class="text-red-500 text-2xl preco_total">R$ {{ number_format($assinatura->preco_total, 2, ',', '.') }}</strong>
                    </p>
                </div>

                <!-- 📌 Footer do Card -->
                <div class="mt-4 text-center border-t pt-3">
                    @if($assinatura->emails_extra > $assinatura->emails_permitidos)
                        <span class="bg-red-500 text-white text-sm font-semibold px-4 py-2 rounded-full quantidade_emails">
                Pagando por {{ $assinatura->emails_extra - $assinatura->emails_permitidos }} e-mails extras
            </span>
                    @else
                        <span class="bg-green-500 text-white text-sm font-semibold px-4 py-2 rounded-full">
                Dentro do limite gratuito
            </span>
                    @endif
                </div>
            </div>
            <div class="md:w-[70%] md:mx-0 w-full mt-5 md:mt-0 mx-2" id="user-table">
                @include('partials.user-table', ['users' => $users])
            </div>

        </section>

    </div>

    <!--Modal Editar-->
    <div
        id="editUserModal"
        class="fixed inset-0 z-50 hidden items-center justify-center bg-black/50"
    >
        <div
            class="bg-white rounded-lg shadow-lg w-full max-w-4xl p-6 relative"
        >
            <!-- Botão de fechar -->
            <button
                id="closeModal"
                class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
            >
                ✕
            </button>

            <div class="flex flex-col md:flex-row gap-6">
                <!-- Formulário -->
                <div class="flex-1">
                    <h2 class="text-xl font-semibold mb-4">Editar Usuário</h2>
                    <form action="/update-user" method="POST" enctype="multipart/form-data" class="space-y-4" id="editUserForm">
                        <!-- Nome -->
                        <input type="hidden" name="id_edit" id="id_edit">
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input
                                type="text"
                                id="name_edit"
                                name="name"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Digite o nome do usuário"
                                required
                            />
                        </div>

                        <!-- E-mail -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700">E-mail</label>
                            <input
                                type="email"
                                id="email_edit"
                                name="email"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Digite o e-mail"
                                required
                            />
                        </div>

                        <!-- Telefone -->
                        <div>
                            <label for="phone" class="block text-sm font-medium text-gray-700">Telefone</label>
                            <input
                                type="text"
                                id="phone_edit"
                                name="phone"
                                class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm"
                                placeholder="Digite o telefone"
                            />
                        </div>

                        <!-- Campo de imagem -->
                        <div>
                            <label for="imagem" class="block text-sm font-medium text-gray-700">Imagem</label>
                            <input
                                type="file"
                                id="imagem"
                                name="imagem"
                                class="mt-1 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border file:border-gray-300 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100"
                            />
                        </div>

                        <!-- Botão Salvar -->
                        <div class="flex w-full">
                            <button
                                type="submit"
                                class="px-4 py-2 bg-blue-600 text-white rounded-md shadow-sm hover:bg-blue-700 w-full"
                            >
                                Editar
                            </button>
                        </div>
                    </form>
                </div>

                <!-- Foto do Usuário -->
                <div class="flex items-center justify-center">
                    <div>
                        <img
                            src=""
                            id="imagem_edit"
                            alt="Foto do usuário"
                            class="w-40 h-40 rounded-full border-2 border-gray-300 object-cover"
                        />
                        <p class="mt-4 text-center text-sm text-gray-500">Foto do Usuário</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--Fim Modal Editar-->



    @section('scripts')
        <script>

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
                    document.body.classList.add('overflow-hidden'); // Bloquear scroll
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
                                if (data.success) {
                                    document.getElementById('user-table').innerHTML = data.html;
                                    document.querySelector('.email_atuais').textContent  = data.emails_extra;
                                    document.querySelector('.preco_total').textContent  = data.preco_total;
                                    if(data.emails_cobrados >= 1) {
                                        document.querySelector('.quantidade_emails').innerHTML  = `Pagando por ${data.emails_cobrados} e-mails extras`;
                                    }
                                    closeModal();
                                } else {
                                    alert("Erro ao cadastrar o usuário");
                                }
                            })
                            .catch(error => {
                                load.style.display = "none";
                                console.error('Error:', error);
                                alert('Erro ao enviar os dados.');
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
                            console.error('Erro ao buscar os dados do usuário:', xhr.responseJSON);
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
                    let userId = $(this).data('id');
                    let status = $(this).is(':checked');

                    $.ajax({
                       url:"{{route('users.alterar')}}",
                       method:"POST",
                       data: {
                           userId,
                           status
                       },
                       beforeSend: function () {
                            load.fadeIn(100).css("display", "flex");
                       },
                       success:function(res) {
                           load.fadeOut(100).css("display", "none");
                           document.querySelector('.email_atuais').textContent  = res.emails_extra;
                           document.querySelector('.preco_total').textContent  = res.preco_total;
                           document.querySelector('.quantidade_emails').textContent  = `Pagando por ${res.emails_cobrados} e-mails extras`;
                       }
                    });
                });


                $("body").on("submit", "#editUserForm", function (e) {
                    e.preventDefault();

                    let formData = new FormData(this);

                    $.ajax({
                        url: "{{ route('users.update') }}", // Rota definida no Laravel
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            console.log(response);
                            if (response.success) {
                                alert(response.message);
                                // Atualiza os dados na interface ou fecha a modal
                                location.reload(); // Recarrega a página para refletir as alterações
                            }
                        },
                        error: function (xhr) {
                            console.error("Erro ao atualizar os dados:", xhr.responseJSON);
                            alert("Erro ao atualizar os dados.");
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



        </script>
    @endsection
</x-app-layout>
