<x-app-layout>
    @if(session()->get('toastr'))
        <script>
            toastr.options = {
                "closeButton": true,
                "progressBar": true,
                "positionClass": "toast-top-right",
                "timeOut": 5000,
                "extendedTimeOut": 1000,
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

            const toastrData = @json(session('toastr'));
            toastr[toastrData.type](toastrData.message, toastrData.title);
        </script>
    @endif
    <div class="py-8">
        <div class="w-[99.5%] sm:px-6 lg:px-1">
            <!-- Grid com 3 colunas -->
            <div class="grid grid-cols-1 md:grid-cols-[25%_25%_50%] gap-1">
                <!-- Card 1: Update Profile Information -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-1">
                        @include('profile.partials.update-profile-information-form')
                    </div>
                </div>

                <!-- Card 2: Update Password -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-1">
                        @include('profile.partials.update-password-form')
                    </div>
                </div>

                <!-- Card 3: Manage Users -->
                <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-1">
                        @include('configuracoes.manage')
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts para o modal de gerenciamento de usuários -->
    @section('scripts')
        <script>

            /***Atualizar Registro***/
            document.getElementById('profileForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;

                // Mostrar loading no botão
                submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
                submitButton.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                    },
                    body: formData
                })
                    .then(response => response.json())
                    .then(data => {

                        if (data.success == true) {
                            // Atualizar a imagem se necessário
                            if (data.imagem) {
                                document.querySelector('.user-avatar').src = data.imagem;
                            }

                            // Mostrar toastr
                            toastr.success(data.message, 'Sucesso!');

                            // Resetar erros
                            document.querySelectorAll('.input-error').forEach(el => el.textContent = '');
                        } else {
                            toastr.error(data.message, 'Erro!');
                        }

                    })
                    .catch(error => {
                        console.log(error);
                        toastr.error('Ocorreu um erro inesperado', 'Erro!');
                    })
                    .finally(() => {
                        submitButton.innerHTML = originalButtonText;
                        submitButton.disabled = false;
                    });
            });
            /***Fim Atualizar Registro***/


            /******Atualizar a senha******/
            document.getElementById('passwordForm').addEventListener('submit', function(e) {
                e.preventDefault();

                const form = e.target;
                const formData = new FormData(form);
                const submitButton = form.querySelector('button[type="submit"]');
                const originalButtonText = submitButton.innerHTML;

                // Adicionar método PUT
                formData.append('_method', 'PUT');

                // Mostrar loading
                submitButton.innerHTML = `
        <svg class="animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
    `;
                submitButton.disabled = true;

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: formData
                })
                    .then(response => {
                        if (response.status === 422) {
                            return response.json().then(errors => ({ errors }));
                        }
                        return response.json();
                    })
                    .then(data => {

                        if (data.success) {
                            // Limpar campos e erros
                            form.reset();
                            document.querySelectorAll('[id$="-error"]').forEach(el => el.textContent = '');

                            toastr.success(data.message, 'Sucesso!');
                        } else if (data.errors) {

                            // Atualizar erros
                            Object.entries(data.errors).forEach(([field, messages]) => {

                                const errorElement = document.getElementById(`update_password_${field}-error`);

                                if (errorElement) {

                                    errorElement.textContent = messages[0];
                                }
                            });
                            toastr.error(data.errors.message, 'Erro!');
                        }
                    })
                    .catch(error => {
                        toastr.error('Ocorreu um erro inesperado', 'Erro!');
                    })
                    .finally(() => {
                        submitButton.innerHTML = originalButtonText;
                        submitButton.disabled = false;
                    });
            });
            /******Fim Atualizar a senha******/










            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('user-modal');
                const toggleModalButton = document.getElementById('toggle-modal');
                const closeModalButton = document.getElementById('close-modal');
                const cancelModalButton = document.getElementById('cancel-modal');
                const userForm = document.getElementById('user-form');


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
                        document.body.classList.remove('overflow-hidden');
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

                document.addEventListener('click', function (event) {
                    if (!modal.contains(event.target) && !toggleModalButton.contains(event.target)) {
                        closeModal();
                    }
                });

                if (userForm) {
                    document.getElementById('user-form').addEventListener('submit', function(e) {
                        e.preventDefault();

                        const form = e.target;
                        const formData = new FormData(form);
                        const loader = document.querySelector('.ajax_load');
                        const modal = document.getElementById('user-modal');
                        const submitButton = form.querySelector('button[type="submit"]');

                        // Mostrar loader e desabilitar botão
                        loader.style.display = 'block';
                        submitButton.disabled = true;

                        fetch(form.action, {
                            method: 'POST',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json',
                                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                            },
                            body: formData
                        })
                            .then(response => {
                                console.log(response);
                                if (!response.ok) throw response;
                                return response.json();
                            })
                            .then(data => {
                                console.log(data);
                                if (data.success) {
                                    // Fechar modal e limpar campos
                                    modal.classList.add('hidden');
                                    form.reset();

                                    // Atualizar tabela de usuários
                                    document.getElementById('user-table').innerHTML = data.html;

                                    // Feedback ao usuário
                                    toastr.success('Usuário cadastrado com sucesso!', 'Sucesso!');
                                }
                            })
                            .catch(async (error) => {
                                console.log(error);
                                // Tratamento de erros de validação
                                if (error.status === 422) {
                                    const errors = await error.json();
                                    Object.entries(errors.errors).forEach(([field, messages]) => {
                                        const errorElement = document.getElementById(`${field}-error`);
                                        if (errorElement) {
                                            errorElement.textContent = messages[0];
                                            errorElement.classList.remove('hidden');
                                        }
                                    });
                                    toastr.error('Verifique os campos do formulário', 'Erro!');
                                } else {
                                    toastr.error('Ocorreu um erro inesperado', 'Erro!');
                                }
                            })
                            .finally(() => {
                                // Esconder loader e reativar botão
                                loader.style.display = 'none';
                                submitButton.disabled = false;
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
                //Mascara telefone de cadastro
                const phoneInput = document.getElementById('phone_cadastrar');
                const im = new Inputmask('(99) 9 9999-9999');
                im.mask(phoneInput);

                const modalEdit = document.getElementById('editUserModal');

                $("body").on('click','#openModal',function(){
                    let id = $(this).attr('data-id');
                    $.ajax({
                        url: `{{route('users.get')}}`,
                        method: 'POST',
                        data: { id },
                        success: function (data) {
                            $('#name_edit').val(data.name);
                            $('#email_edit').val(data.email);
                            $('#phone_edit').val(data.phone);
                            $('#id_edit').val(data.id);
                            if (data.imagem) {
                                $('#imagem_edit_exibicao').attr('src', data.imagem);
                            }
                        },
                        error: function (xhr) {
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

                modalEdit.addEventListener('click', (e) => {
                    if (e.target === modalEdit) {
                        modalEdit.classList.add('hidden');
                        modalEdit.classList.remove('flex');
                    }
                });

                $("body").on("submit", "#editUserForm", function (e) {
                    e.preventDefault();
                    let formData = new FormData(this);
                    $.ajax({
                        url: "{{ route('users.update') }}",
                        method: "POST",
                        data: formData,
                        processData: false,
                        contentType: false,
                        success: function (response) {
                            if (response.success) {
                                $("#user-table").html(response.html);
                                modalEdit.classList.add('hidden');
                                modalEdit.classList.remove('flex');
                                //document.getElementById('user-table').innerHTML = data.html;
                                //location.reload();
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
                            $.ajax({
                                url: "{{route('deletar.user')}}",
                                method: "POST",
                                data: { id },
                                success: function(res) {
                                    if (res.success) {
                                        $("#user-table").html(res.html);
                                        toastr.success("Usuário excluído com sucesso!", 'Sucesso', {
                                            toastClass: "toast-custom-width"
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
                });
            });
        </script>
    @endsection
</x-app-layout>
