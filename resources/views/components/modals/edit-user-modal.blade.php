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
                    <!-- Imagem oculta -->
                    <input type="file" id="avatar-input" class="hidden" accept="image/*">

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
                        class="w-40 h-40 rounded-full border-2 border-gray-300 object-cover hover:cursor-pointer"
                    />
                    <p class="mt-4 text-center text-sm text-gray-500">Alterar Foto de Perfil</p>
                </div>
            </div>
        </div>
    </div>
</div>
