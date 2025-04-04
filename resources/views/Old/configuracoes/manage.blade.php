<section>
    <header class="flex w-full">
        <div class="flex flex-col w-[90%]">
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Usuários Cadastrados') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Ensure your account is using a long, random password to stay secure.') }}
            </p>
        </div>
        <div class="flex w-[10%] justify-end">
            <button id="toggle-modal" class="w-16 h-16 flex items-center justify-center rounded-full bg-blue-600 text-white text-3xl font-bold shadow-lg hover:bg-blue-700 transition">
                +
            </button>
        </div>
    </header>

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
                            <label for="imagem_edit" class="block text-sm font-medium text-gray-700">Imagem</label>
                            <input
                                type="file"
                                id="imagem_edit"
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
                            id="imagem_edit_exibicao"
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






    <!-- Modal centralizada -->
    <div id="user-modal" class="fixed inset-0 flex items-center justify-center bg-black/50 hidden z-50">
        <div class="bg-white shadow-lg rounded-lg p-6 w-full max-w-md">
            <!-- Cabeçalho da modal -->
            <div class="flex justify-between items-center mb-4">
                <h2 class="text-lg font-semibold">Cadastrar Usuário</h2>
                <button id="close-modal" class="text-gray-500 hover:text-gray-700 text-2xl">&times;</button>
            </div>

            <!-- Formulário -->
            <form id="user-form" action="{{ route('storeUser') }}" method="POST">
                @csrf
                <div class="mb-4">
                    <label for="name_cadastrar" class="block text-sm font-medium text-gray-700">Nome</label>
                    <input type="text" name="name_cadastrar" id="name_cadastrar" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="email_cadastrar" class="block text-sm font-medium text-gray-700">E-mail</label>
                    <input type="email" name="email_cadastrar" id="email_cadastrar" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="phone_cadastrar" class="block text-sm font-medium text-gray-700">Telefone</label>
                    <input type="text" name="phone_cadastrar" id="phone_cadastrar" required
                           class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
                </div>

                <div class="mb-4">
                    <label for="image_cadastrar" class="block text-sm font-medium text-gray-700">Imagem do Usuário</label>
                    <input type="file" name="image_cadastrar" id="image_cadastrar" accept="image/*"
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
        @include('partials.user-table', ['users' => $users])
    </div>
</section>
