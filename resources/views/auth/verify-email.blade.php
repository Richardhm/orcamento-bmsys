<x-guest-layout>
    <div class="w-[70%] mx-auto bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-5 rounded">
        <div class="mb-4 text-sm text-white dark:text-white text-center">
            {{ __('Obrigado por se cadastrar! Antes de começar, você pode verificar seu endereço de e-mail clicando no link que acabamos de enviar para você? Se você não recebeu o e-mail, teremos o prazer de enviar outro.') }}
        </div>

        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 font-medium text-sm text-white dark:text-white">
                {{ __('Um novo link de verificação foi enviado para o endereço de e-mail que você forneceu durante o cadastro.') }}
            </div>
        @endif

        <div class="mt-4 flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <div>
                    <x-primary-button>
                        {{ __('Reenviar e-mail de verificação') }}
                    </x-primary-button>
                </div>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit" class="underline text-sm text-white dark:text-white hover:text-white dark:hover:text-white rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 dark:focus:ring-offset-gray-800">
                    {{ __('Sair') }}
                </button>
            </form>
        </div>
    </div>

</x-guest-layout>
