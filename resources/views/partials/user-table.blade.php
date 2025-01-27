<table class="min-w-full bg-white shadow-md rounded-lg overflow-hidden">
    <thead>
    <tr>
        <th class="px-6 py-4 text-left">Nome</th>
        <th class="px-6 py-4 text-left">Email</th>
        <th class="px-6 py-4 text-left">Telefone</th>
    </tr>
    </thead>
    <tbody>
    @foreach ($users as $user)
        <tr>
            <td class="px-6 py-4">{{ $user['name'] }}</td>
            <td class="px-6 py-4">{{ $user['email'] }}</td>
            <td class="px-6 py-4">{{ $user['phone'] }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
