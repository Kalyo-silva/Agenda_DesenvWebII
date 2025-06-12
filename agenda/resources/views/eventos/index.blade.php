<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/4'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Eventos') }}</h2>
            </div>
            <div class='w-3/4 flex items-center justify-end'>
                <div class="flex space-x-4">
                    <button onclick="window.location='{{ route('eventos.create') }}'"
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

                    <h1 class='m-2 font-bold text-lg'>{{ __('Cadastros de Eventos') }}</h1>

                    <div class='mb-4'>
                        <form action="{{ route('eventos/search') }}" method="GET"
                            class="flex items-center w-full max-w-md space-x-2">
                            <input type="text" name="eventoSearch" placeholder="Pesquisar..."
                                class="w-full px-4 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
                                value="{{ request('eventoSearch') }}">
                            <button type="submit"
                                class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700">
                                Buscar
                            </button>

                            @if (!empty($eventoSearch))
                                <a href="{{ url('eventos') }}"
                                    class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">X</a>
                            @endif
                        </form>
                    </div>

                    <div class='grid md:grid-cols-3 gap-4'>
                        @if ($listaEventos->isEmpty())
                            <p>Nenhum evento encontrado.</p>
                        @else
                            @foreach ($listaEventos as $evento)
                                @php
                                    $statusColors = [
                                        'agendado' => 'bg-blue-100 text-blue-800',
                                        'pendente' => 'bg-red-100 text-red-800',
                                        'concluido' => 'bg-green-100 text-green-800',
                                    ];
                                    $statusClass = $statusColors[$evento->status] ?? 'bg-gray-100 text-gray-800';
                                @endphp

                                <div class="evento-card border rounded p-4 bg-gray-50 shadow-sm hover:bg-gray-200 cursor-pointer"
                                    onclick="selectevento(event, {{ $evento->id }}, '{{ route('eventos.show', $evento->id) }}', '{{ route('eventos.edit', $evento->id) }}', '{{ route('eventos.destroy', $evento->id) }}')">

                                    <h3 class='font-bold text-lg text-blue-900'>{{ $evento->titulo }}</h3>
                                    <p class='text-sm text-gray-700 mt-1'>
                                        {{ \Carbon\Carbon::parse($evento->datahora)->format('d/m/Y H:i') }}
                                    </p>

                                    <span
                                        class="mt-2 inline-block px-3 py-1 text-sm font-semibold rounded {{ $statusClass }}">
                                        {{ ucfirst($evento->status) }}
                                    </span>
                                </div>
                            @endforeach
                        @endif
                    </div>

                    <div class="mt-4">
                        {{$listaEventos->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        let selectedeventoId = null;

        function selectevento(event, id, visualizarRoute, editarRoute, excluirRoute) {
            selectedeventoId = id;

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
            let registros = document.querySelectorAll('.evento-card');
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
            selectedeventoId = null;
        }

        function desmarcarevento() {
            let registros = document.querySelectorAll('.evento-card');
            registros.forEach(registro => {
                registro.classList.remove('bg-blue-100', 'border-blue-700', 'shadow-lg');
            });
            resetButtons();
        }

        document.addEventListener('click', function(event) {
            const isCard = event.target.closest('.evento-card');
            const isButton = event.target.closest('button');
            const isModal = event.target.closest('#confirmacaoExclusao');

            if (!isCard && !isButton && !isModal) {
                desmarcarevento();
            }
        });

        document.addEventListener('keydown', function(event) {
            if (event.key === 'Escape') {
                desmarcarevento();
            }
        });
    </script>

    <x-confirmacao-exclusao />
</x-app-layout>
