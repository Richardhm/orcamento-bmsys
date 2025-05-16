<section class="p-2">
    <header class="w-full">
        <div class="w-full flex justify-between items-center">
            <div class="flex flex-col">
                <h2 class="text-sm font-medium text-white">
                    {{ __('Informações de Perfil') }}
                </h2>

                <p class="mt-1 text-sm text-white">
                    {{ __("Atualize as informações do perfil.") }}
                </p>
            </div>

            <div class="flex flex-col items-center">
                <img src="{{ $user->imagem ? Storage::url($user->imagem) : 'https://via.placeholder.com/150' }}"
                     class="user-avatar w-24 h-24 rounded-full object-cover cursor-pointer"
                     id="user-avatar">
                <input type="file" id="avatar-input" class="hidden" accept="image/*">
            </div>
        </div>
    </header>

    <form id="send-verification" method="post" action="{{ route('verification.send') }}">
        @csrf
    </form>

    <div class="flex lg:flex-row items-start lg:items-center w-full">

        <form id="profileForm" method="post" action="{{ route('profile.update') }}" class="mt-1 space-y-6 w-full" enctype="multipart/form-data">
            @csrf
            @method('patch')

            <div>
                <x-input-label for="name" class="text-white" :value="__('Nome')" />
                <x-text-input id="name" name="name" type="text" class="mt-1 block w-full" :value="old('name', $user->name)" required autofocus autocomplete="name" />
                <x-input-error class="mt-2" :messages="$errors->get('name')" />
            </div>

            <div>
                <x-input-label for="phone" class="text-white" :value="__('Telefone')" />
                <x-text-input id="phone" name="phone" type="text" class="mt-1 block w-full" :value="old('phone', $user->phone)" required autocomplete="tel" />
                <x-input-error class="mt-2" :messages="$errors->get('phone')" />
            </div>

            <div class="flex items-center gap-4">
                <x-primary-button class="w-full text-center flex justify-center">Salvar</x-primary-button>

                @if (session('status') === 'profile-updated')
                    <p
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 2000)"
                        class="text-sm text-gray-600 dark:text-gray-400"
                    >{{ __('Salvar') }}</p>
                @endif
            </div>
        </form>
        <!-- Imagem de Perfil (lado direito) -->
    </div>
</section>
