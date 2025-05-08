<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/2'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Detalhes da Pessoa') }}</h2>
            </div>
            <div class='w-1/2 flex justify-end'>
                <a href="{{ route('pessoas.edit', $pessoa->id) }}"
                    class="bg-yellow-500 hover:bg-yellow-600 px-6 py-2 rounded text-white mr-2">Editar</a>

                <form id="formExcluir" action="{{ route('pessoas.destroy', $pessoa->id) }}" method="POST"
                    style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button id="btnExcluir" type="button"
                        class="bg-red-600 hover:bg-red-700 px-6 py-2 rounded text-white mr-2">
                        Excluir
                    </button>
                </form>

                <a href="{{ route('pessoas.index') }}"
                    class="bg-gray-600 hover:bg-gray-800 px-6 py-2 rounded text-white">Voltar</a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class='mb-4 font-bold text-lg'>{{ __('Detalhes de: ' . $pessoa->nome) }}</h1>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Nome</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{ $pessoa->nome }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{ \Carbon\Carbon::parse($pessoa->data_nascimento)->format('d/m/Y') }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Tipo</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{$pessoa->tipo_pessoa}} <!-- Exibe 'Profissional' ou 'Acolhido' -->
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">CPF</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{ $pessoa->cpf }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Telefone de Contato</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            {{ $pessoa->telefone_contato }}
                        </div>
                    </div>

                    <div class="mb-4">
                        <label class="block text-sm font-medium text-gray-700">Foto de Perfil</label>
                        <div class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                            @if ($pessoa->foto_perfil)
                                <img src="{{ asset('storage/' . $pessoa->foto_perfil) }}" alt="Foto de Perfil"
                                    class="img-fluid" style="max-width: 150px;">
                            @else
                                <p>Foto não disponível</p>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <x-confirmacao-exclusao />
</x-app-layout>
