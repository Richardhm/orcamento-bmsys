@if($users->isEmpty())
    <div class="text-center bg-gray-100 text-black w-[50%] mx-auto rounded p-3">
        <p class="font-bold text-sm">Sem usuários cadastrados para a sua assinatura.</p>
    </div>
@else
    <div class="relative overflow-x-auto rounded-lg shadow-md sm:rounded-lg w-full mx-auto">
        <table class="min-w-full text-lg text-left rtl:text-right rounded-lg text-gray-500 dark:text-gray-400">
            <thead class="text-lg uppercase bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] dark:bg-gray-700 rounded dark:text-gray-400">
            <tr>
                <th scope="col" class="px-2 py-1 text-white">Imagem</th>
                <th scope="col" class="px-2 py-1 text-white">Nome</th>
                <th scope="col" class="px-2 py-1 text-white">Email</th>
                <th scope="col" class="px-2 py-1 text-white">Telefone</th>
                <th scope="col" class="px-2 py-1 text-center text-white">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200">
                    <th scope="row" class="flex items-center px-2 py-1 text-gray-900 whitespace-nowrap dark:text-white">
                        @if(!empty($user['imagem']))
                            <img class="w-12 h-12 rounded-full" src="{{ asset('storage/'.$user['imagem']) }}" alt="{{ $user['name'] }}">
                        @else
                            <div class="w-12 h-12 flex items-center justify-center bg-gray-300 rounded-full">
                                <svg class="w-6 h-6 text-gray-500" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5.121 17.804A12.083 12.083 0 0112 15c2.5 0 4.847.735 6.879 2.002M15 11a3 3 0 11-6 0 3 3 0 016 0zm7 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                        @endif
                    </th>
                    <td class="px-2 py-1 text-white">{{ $user['name'] }}</td>
                    <td class="px-2 py-1 text-white">{{ $user['email'] }}</td>
                    <td class="px-2 py-1 text-white">{{ $user['phone'] }}</td>
                    <td class="px-2 py-1 text-center flex items-center justify-center">
                        <button type="button" id="openModal" data-id="{{ $user['id'] }}"
                                class="edit focus:outline-none text-white bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] focus:ring-2 focus:ring-purple-300 font-medium rounded-md text-xs px-3 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>

                        <label class="switch" data-id="{{ $user['id'] }}">
                            <input type="checkbox" class="toggle-switch" data-id="{{$user['id']}}" {{$user['status'] == 1 ? "checked" : ''}}>
                            <span class="slider"></span>
                        </label>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
