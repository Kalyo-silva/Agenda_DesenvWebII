<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/2'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Visualizar Evento') }}</h2>
            </div>
            <div class='w-1/2 flex justify-end'>
                <!-- Botões de Ação -->
                <a href="{{ route('eventos.edit', $evento->id) }}" class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 rounded text-white mr-2">
                    Editar
                </a>

                <form id="formExcluir" action="{{ route('eventos.destroy', $evento->id) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button id="btnExcluir" type="button" class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded text-white mr-2">
                        Excluir
                    </button>
                </form>

                <a href="{{ route('eventos.index') }}" class="bg-gray-600 hover:bg-gray-800 px-6 py-2 rounded text-white">
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Detalhes do Evento -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Título:</h3>
                        <p class="text-gray-700">{{ $evento->titulo }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Data e Hora de Início:</h3>
                        <p class="text-gray-700">{{ \Carbon\Carbon::parse($evento->data_ini)->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Data e Hora Final Estimada:</h3>
                        <p class="text-gray-700">{{ \Carbon\Carbon::parse($evento->data_fim)->format('d/m/Y H:i') }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Descrição:</h3>
                        <p class="text-gray-700">{{ $evento->descricao }}</p>
                    </div>

                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Status:</h3>
                        @php
                            $statusColors = [
                                'agendado' => 'bg-blue-100 text-blue-800',
                                'pendente' => 'bg-red-100 text-red-800',
                                'concluido' => 'bg-green-100 text-green-800',
                            ];
                            $statusClass = $statusColors[$evento->status] ?? 'bg-gray-100 text-gray-800';
                        @endphp
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded {{ $statusClass }}">
                            {{ ucfirst($evento->status) }}
                        </span>
                    </div>

                    <!-- Profissionais -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Profissionais:</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach ($evento->pessoas->where('tipo_pessoa', 'Profissional') ?? [] as $profissional)
                                <li>{{ $profissional->nome }} - {{ $profissional->cpf }}</li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Acolhidos -->
                    <div class="mb-4">
                        <h3 class="text-lg font-semibold text-gray-800">Acolhidos:</h3>
                        <ul class="list-disc list-inside text-gray-700">
                            @foreach ($evento->pessoas->where('tipo_pessoa', 'Acolhido') ?? [] as $acolhido)
                                <li>{{ $acolhido->nome }} - {{ $acolhido->cpf }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Componente de Confirmação de Exclusão -->
    <x-confirmacao-exclusao />
</x-app-layout>
