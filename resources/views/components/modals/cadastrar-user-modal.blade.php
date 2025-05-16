<div id="user-modal"
     class="fixed inset-0 hidden flex items-center justify-center z-50">
    <div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] shadow-lg border-white border-4 rounded-lg p-6 w-96 max-h-[80vh] overflow-auto relative">
        <!-- Cabeçalho da modal -->
        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-white">Cadastrar Usuário</h2>

            <svg id="close-modal" xmlns="http://www.w3.org/2000/svg"  fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor" class="size-6 border-white border-4 rounded hover:cursor-pointer text-white">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </div>

        <!-- Formulário -->
        <form id="user-form" action="{{ route('storeUser') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-white">Nome</label>
                <input type="text" name="name" id="name" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-white">E-mail</label>
                <input type="email" name="email" id="email" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">

            </div>

            <div class="mb-4">
                <label for="phone" class="block text-sm font-medium text-white">Telefone</label>
                <input type="text" name="phone" id="phone" required
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="image" class="block text-sm font-medium text-white">Imagem do Usuário</label>
                <input type="file" name="image" id="image" accept="image/*"
                       class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-blue-500 focus:ring-blue-500 sm:text-sm">
            </div>

            <div class="flex justify-end">
                <button type="button" id="cancel-modal"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg shadow hover:bg-gray-400 transition mr-2">
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
