@if($users->isEmpty())
    <div class="text-center bg-gray-100 text-black w-[50%] mx-auto rounded p-3">
        <p class="font-bold text-sm">Sem usuários cadastrados para a sua assinatura.</p>
    </div>
@else
    <div class="relative overflow-x-auto rounded-lg shadow-md sm:rounded-lg">
        <table class="w-[100%] text-lg text-left rtl:text-right rounded-lg text-gray-500 dark:text-gray-400">
            <thead class="text-[10px] text-orange-500 uppercase bg-black dark:bg-gray-700 rounded dark:text-gray-400">
            <tr>
                <th scope="col" class="px-2 py-1">Imagem</th>
                <th scope="col" class="px-2 py-1">Nome</th>
                <th scope="col" class="px-2 py-1">Email</th>
                <th scope="col" class="px-2 py-1">Telefone</th>
                <th scope="col" class="px-2 py-1 text-center">Ações</th>
            </tr>
            </thead>
            <tbody>
            @foreach($users as $user)
                <tr class="bg-white border-b dark:bg-gray-800 dark:border-gray-700 border-gray-200 hover:bg-gray-50 dark:hover:bg-gray-600">
                    <th scope="row" class="flex items-center px-2 py-1 text-gray-900 whitespace-nowrap dark:text-white">
                        <img class="w-12 h-12 rounded-full" src="{{ asset('storage/'.$user['imagem']) }}" alt="{{ $user['name'] }}">
                    </th>
                    <td class="px-2 py-1">{{ $user['name'] }}</td>
                    <td class="px-2 py-1">{{ $user['email'] }}</td>
                    <td class="px-2 py-1">{{ $user['phone'] }}</td>
                    <td class="px-2 py-1 text-center">
                        <button type="button" id="openModal" data-id="{{ $user['id'] }}"
                                class="edit focus:outline-none text-white bg-purple-700 hover:bg-purple-800 focus:ring-2 focus:ring-purple-300 font-medium rounded-md text-xs px-3 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L10.582 16.07a4.5 4.5 0 0 1-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 0 1 1.13-1.897l8.932-8.931Zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0 1 15.75 21H5.25A2.25 2.25 0 0 1 3 18.75V8.25A2.25 2.25 0 0 1 5.25 6H10" />
                            </svg>
                        </button>
                        <button type="button" data-id="{{ $user['id'] }}"
                                class="delete focus:outline-none text-white bg-red-700 hover:bg-red-800 focus:ring-2 focus:ring-red-300 font-medium rounded-md text-xs px-3 py-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                            </svg>
                        </button>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>
@endif
