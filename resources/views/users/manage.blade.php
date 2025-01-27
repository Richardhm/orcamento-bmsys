<x-app-layout>
    <!-- Botão redondo -->
    <div class="flex justify-end mt-4 mr-4 relative">
        <button id="toggle-modal"
                class="w-12 h-12 flex items-center justify-center rounded-full bg-white text-blue-500 border border-blue-500 shadow-lg hover:bg-blue-100 transition">
            +
        </button>

        <!-- Modal ao lado esquerdo do botão -->
        <div id="user-modal"
             class="absolute hidden bg-white shadow-lg rounded-lg p-6 top-0 right-full mr-36 w-96 z-50 transform transition-transform duration-500 translate-x-full"
             style="margin-right:50px;">
            <!-- Cabeçalho da modal -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Cadastrar Usuário</h2>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700">&times;</button>
            </div>

            <!-- Formulário -->
            <form id="user-form" action="" method="POST">
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

    <div id="user-table">
        <!-- A tabela de usuários será carregada aqui via AJAX -->
    </div>

    @section('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                const modal = document.getElementById('user-modal');
                const toggleModalButton = document.getElementById('toggle-modal');
                const closeModalButton = document.getElementById('close-modal');
                const cancelModalButton = document.getElementById('cancel-modal');

                // Alternar modal com animação
                toggleModalButton.addEventListener('click', function () {
                    if (modal.classList.contains('hidden')) {
                        modal.classList.remove('hidden', 'translate-x-full');
                        modal.classList.add('translate-x-0');
                    } else {
                        modal.classList.add('translate-x-full');
                        modal.classList.remove('translate-x-0');
                        setTimeout(() => modal.classList.add('hidden'), 500); // Aguarda a animação terminar antes de esconder
                    }
                });

                // Fechar modal
                closeModalButton.addEventListener('click', function () {
                    modal.classList.add('translate-x-full');
                    modal.classList.remove('translate-x-0');
                    setTimeout(() => modal.classList.add('hidden'), 500);
                });

                cancelModalButton.addEventListener('click', function () {
                    modal.classList.add('translate-x-full');
                    modal.classList.remove('translate-x-0');
                    setTimeout(() => modal.classList.add('hidden'), 500);
                });

                // Fechar modal ao clicar fora
                window.addEventListener('click', function (event) {
                    if (!modal.contains(event.target) && event.target !== toggleModalButton) {
                        modal.classList.add('translate-x-full');
                        modal.classList.remove('translate-x-0');
                        setTimeout(() => modal.classList.add('hidden'), 200);
                    }
                });
                const userForm = document.getElementById("user-form");
                // Enviar formulário com AJAX
                userForm.addEventListener('submit', function (event) {
                    event.preventDefault(); // Impede o comportamento padrão do formulário

                    const formData = new FormData(userForm);

                    fetch("{{ route('storeUser') }}", {
                        method: 'POST',
                        body: formData,
                    })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Atualizar a tabela de usuários
                                document.getElementById('user-table').innerHTML = data.html;
                                // Fechar o modal
                                modal.classList.add('hidden');
                            } else {
                                alert("Erro ao cadastrar o usuário");
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Erro ao enviar os dados.');
                        });
                });

                // Função para atualizar a tabela de usuários







            });
        </script>
    @endsection
</x-app-layout>
