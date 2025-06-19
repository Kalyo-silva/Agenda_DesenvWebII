<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Acolhe+</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=instrument-sans:400,500,600" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-[#FDFDFC] dark:bg-[#0a0a0a] text-[#1b1b18] dark:text-[#EDEDEC] flex flex-col min-h-screen">

    <!-- Navbar -->
    <header class="w-full max-w-6xl mx-auto px-6 py-4 flex justify-between items-center">
        <h1 class="text-xl font-semibold">Acolhe+</h1>
    </header>

    <!-- Conteúdo Principal -->
    <main
        class="flex flex-col-reverse lg:flex-row w-full max-w-6xl mx-auto mt-6 bg-white dark:bg-[#161615] shadow-lg rounded-lg overflow-hidden min-h-[376px] gap-12">

        <!-- Texto -->
        <section class="flex-1 p-8 lg:p-12 max-w-md mx-auto lg:mx-0">
            <h2 class="text-3xl font-semibold mb-4">Cuidado e organização para um futuro melhor</h2>
            <p class="text-gray-600 dark:text-gray-400 text-lg mb-6">
                Facilite o agendamento de atividades, visitas e atendimentos no orfanato. Um sistema pensado para apoiar
                quem cuida e transformar a rotina de quem mais precisa.
            </p>
            <div class="flex gap-6 justify-center lg:justify-start">
                @auth
                        <a
                            href="{{ url('/dashboard') }}"
                            class="inline-block px-8 py-3 border border-blue-600 text-blue-600 font-medium rounded hover:bg-blue-50 dark:hover:bg-gray-800 transition"
                        >
                            Dashboard
                        </a>
                    @else
                        <a href="{{ route('register') }}"
                            class="inline-block px-8 py-3 bg-blue-600 text-white font-medium rounded hover:bg-blue-700 transition">
                            Registrar
                        </a>

                        @if (Route::has('register'))     
                            <a href="{{ route('login') }}"
                                class="inline-block px-8 py-3 border border-blue-600 text-blue-600 font-medium rounded hover:bg-blue-50 dark:hover:bg-gray-800 transition">
                                Entrar
                            </a>
                        @endif
                    @endauth
            </div>
        </section>

        <!-- Imagem -->
        <section class="w-full lg:flex-grow">
            <img src="{{ asset('img' . DIRECTORY_SEPARATOR . 'agenda.jpg') }}" alt="Imagem Agenda"
                class="w-full h-full object-cover rounded-r-lg">
        </section>
    </main>

    <!-- Rodapé (opcional) -->
    <footer class="mt-auto text-center text-sm py-6 text-gray-500 dark:text-gray-400">
        &copy; {{ date('Y') }} Acolhe+. Todos os direitos reservados.
    </footer>

</body>

</html>
