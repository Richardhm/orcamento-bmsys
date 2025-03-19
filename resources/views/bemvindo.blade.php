<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo, {{ $user->name }}!</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        body {
            background-image: url('{{ asset('fred01.jpeg') }}');
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">

<div class="bg-[rgba(254,254,254,0.18)] backdrop-blur-[15px] p-8 rounded-lg shadow-lg text-center max-w-lg">
    <h1 class="text-2xl font-bold text-white">🎉 Bem-vindo, {{ $user->name }}! 🎉</h1>
    <p class="mt-2 text-white">Obrigado por se cadastrar! Um e-mail de verificação foi enviado para <span class="font-semibold">{{ $user->email }}</span>. Verifique sua caixa de entrada e confirme seu cadastro.</p>

    <div class="mt-4">
        <img src="{{ asset('storage/' . $user->imagem) }}" alt="Imagem de Perfil" class="w-24 h-24 rounded-full mx-auto shadow-md">
    </div>

    <p class="mt-4 text-sm text-white">Caso não tenha recebido o e-mail, verifique sua pasta de spam ou clique no botão abaixo para reenviar.</p>

    <button class="mt-4 bg-yellow-500 text-white font-bold py-2 px-4 rounded">
        Reenviar E-mail
    </button>

    <a href="{{ url('/') }}" class="block mt-4 text-white hover:underline">Voltar para a página inicial</a>
</div>

</body>
</html>
