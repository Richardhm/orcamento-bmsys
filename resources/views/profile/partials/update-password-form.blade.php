<section class="p-2">
    <header>
        <h2 class="text-lg font-medium text-white">
            {{ __('Alterar Senha') }}
        </h2>

        <p class="mt-1 text-sm text-white">
            {{ __('Certifique-se de que sua conta esteja usando uma senha longa e aleatória para permanecer segura.') }}
        </p>
    </header>

    <form  id="passwordForm" method="post" action="{{ route('password.update') }}" class="mt-6 space-y-6">
        @csrf
        @method('put')

        <div>
            <x-input-label for="update_password_current_password" class="text-white" :value="__('Senha Atual')" />
            <x-text-input id="update_password_current_password" name="current_password" required type="password" class="mt-1 block w-full" autocomplete="current-password" />

        </div>

        <div>
            <x-input-label for="update_password_password" class="text-white" :value="__('Nova Senha')" />
            <x-text-input id="update_password_password" name="password" type="password" required class="mt-1 block w-full" autocomplete="new-password" />

        </div>

        <div>
            <x-input-label for="update_password_password_confirmation" class="text-white" :value="__('Confirmar nova Senha')" />
            <x-text-input id="update_password_password_confirmation" name="password_confirmation" required type="password" class="mt-1 block w-full" autocomplete="new-password" />

        </div>

        <div class="flex items-center gap-4">
            <x-primary-button class="w-full text-center flex justify-center">{{ __('Salvar') }}</x-primary-button>

            @if (session('status') === 'password-updated')
                <p
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 2000)"
                    class="text-sm text-gray-600 dark:text-gray-400"
                >{{ __('Salvar.') }}</p>
            @endif
        </div>
    </form>
</section>
