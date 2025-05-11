<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/4'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pessoas') }}</h2>
            </div>
            <div class='w-3/4 flex items-center justify-end'>
                <div class="flex space-x-4">
                    <button onclick="window.location='{{ route('pessoas.create') }}'"
                        class='bg-blue-700 hover:bg-blue-900 px-4 py-2 rounded text-white'>Adicionar</button>

                    <button id="btnVisualizar"
                        class="px-4 py-2 rounded text-white bg-green-600 hover:bg-green-800 opacity-50 pointer-events-none">Visualizar</button>

                    <button id="btnEditar"
                        class="px-4 py-2 rounded text-white bg-yellow-500 hover:bg-yellow-600 opacity-50 pointer-events-none">Editar</button>

                    <form id="formExcluir" action="#" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button id="btnExcluir" type="button"
                            class="px-4 py-2 rounded text-white bg-red-600 hover:bg-red-800 opacity-50 pointer-events-none">Excluir</button>
                    </form>
                </div>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if (session('success'))
                        <div class="mb-4 p-4 bg-green-100 text-green-800 rounded">
                            {{ session('success') }}
                        </div>
                    @endif
                    <h1 class='m-2 font-bold text-lg'>{{ __('Cadastros de Pessoas') }}</h1>

                    <div class='mb-4'>
                        <form action="{{ route('pessoas/search')}}" method="GET" class="inline">
                            <input type="text" name="pessoaSearch" placeholder="Pesquisar..." class="border rounded px-2 py-1 text-gray-700" value="{{request('pessoaSearch')}}">
                            <button class="px-1">
                                <img src="{{ asset('imagens/lupa_black.png')}}" alt="Pesquisar" class="inline w-5 h-5 hover:w-7 hover:h-7">
                            </button>
                        </form>
                        @if($pessoaSearch !== null)
                            <a href="{{ url('pessoas')}}">
                                <button>
                                    <img src="{{ asset('imagens/excluir_red.png')}}" alt="Remover Filtro" class="inline w-6 h-6 hover:w-7 hover:h-7 ">
                                </button>
                            </a>
                        @endif
                    </div>

                    <div class='grid md:grid-cols-3 gap-4'>
                        @foreach ($listaPessoas as $pessoa)
                            <div class="pessoa-card border rounded p-4 bg-gray-50 shadow-sm hover:bg-gray-200 cursor-pointer"
                                onclick="selectPessoa(event, {{ $pessoa->id }}, '{{ route('pessoas.show', $pessoa->id) }}', '{{ route('pessoas.edit', $pessoa->id) }}', '{{ route('pessoas.destroy', $pessoa->id) }}')">
                                <div class="flex mb-2">
                                    <div class='w-16 h-16 rounded border mr-2 overflow-hidden'>
                                        <img class="object-cover w-full h-full"
                                            src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQADjfoADAlJPrsl_hiiOMeE-FBor-i6hEAVg&s"
                                            alt="pfp">
                                    </div>
                                    <div>
                                        <h3 class='font-bold'>{{ $pessoa->nome }}</h3>
                                        <p class='text-sm italic text-gray-700'>
                                            {{ date('d/m/Y', strtotime($pessoa->data_nascimento)) }}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedPessoaId = null;

        function selectPessoa(event, id, visualizarRoute, editarRoute, excluirRoute) {
            selectedPessoaId = id;

            const btnVisualizar = document.getElementById('btnVisualizar');
            const btnEditar = document.getElementById('btnEditar');
            const btnExcluir = document.getElementById('btnExcluir');

            // Ativa os botões
            [btnVisualizar, btnEditar, btnExcluir].forEach(btn => {
                btn.classList.remove('opacity-50', 'pointer-events-none');
            });

            btnVisualizar.setAttribute('onclick', `window.location='${visualizarRoute}'`);
            btnEditar.setAttribute('onclick', `window.location='${editarRoute}'`);
            document.getElementById('formExcluir').setAttribute('action', excluirRoute);

            // Destaque visual
            let registros = document.querySelectorAll('.pessoa-card');
            registros.forEach(registro => {
                registro.classList.remove('bg-blue-100', 'border-blue-700', 'shadow-lg');
            });
            event.currentTarget.classList.add('bg-blue-100', 'border-blue-700', 'shadow-lg');
        }

        function resetButtons() {
            const btnVisualizar = document.getElementById('btnVisualizar');
            const btnEditar = document.getElementById('btnEditar');
            const btnExcluir = document.getElementById('btnExcluir');

            [btnVisualizar, btnEditar, btnExcluir].forEach(btn => {
                btn.classList.add('opacity-50', 'pointer-events-none');
                btn.removeAttribute('onclick');
            });
            selectedPessoaId = null;
        }

        function desmarcarPessoa() {
            let registros = document.querySelectorAll('.pessoa-card');
            registros.forEach(registro => {
                registro.classList.remove('bg-blue-100', 'border-blue-700', 'shadow-lg');
            });
            resetButtons();
        }

        // Ouvinte para clique fora dos cartões
        document.addEventListener('click', function(event) {
            const isCard = event.target.closest('.pessoa-card');
            const isButton = event.target.closest('button');
            const isModal = event.target.closest('#confirmacaoExclusao');

            if (!isCard && !isButton && !isModal) {
                desmarcarPessoa();
            }
        });

        // Ouvinte para a tecla "Escape"
        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                desmarcarPessoa();
            }
        });
    </script>


    <style>
        .btn-acoes {
            background-color: #007bff;
            color: white;
            padding: 8px 16px;
            border-radius: 4px;
            border: none;
            cursor: pointer;
            opacity: 0.5;
        }

        .btn-acoes:hover {
            background-color: #0056b3;
        }

        .btn-acoes.disabled {
            background-color: #d6d6d6;
            cursor: not-allowed;
            opacity: 0.3;
        }

        .border:hover {
            background-color: #f0f0f0;
        }

        .border.bg-blue-100 {
            background-color: #e3f2fd;
        }
    </style>

    <x-confirmacao-exclusao /> <!-- Chama o componente de confirmação de exclusão -->
</x-app-layout>
