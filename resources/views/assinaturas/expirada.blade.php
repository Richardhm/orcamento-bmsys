<x-app-layout>
    <div class="max-w-md mx-auto mt-10 p-6 bg-white rounded-lg shadow-md">
        <div class="text-center">
            <div class="text-red-500 text-5xl mb-4">
                <i class="fas fa-exclamation-triangle"></i>
            </div>
            <h1 class="text-xl font-bold mb-4">Acesso Bloqueado</h1>
            @if(session('error'))
                <p class="text-gray-600 mb-4">{{ session('error') }}</p>
            @endif
            <p class="text-gray-600">
                Entre em contato com o administrador do sistema para regularizar o acesso.
            </p>
        </div>
    </div>
</x-app-layout>
