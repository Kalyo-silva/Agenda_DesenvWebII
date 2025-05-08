<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/2'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Cadastrar Pessoa') }}</h2>
            </div>
            <div class='w-1/2 flex justify-end'>
                <button type="submit" form="form-cadastrar" class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded text-white mr-2">
                    Salvar
                </button>
                <a href="{{ route('pessoas.index') }}" class='bg-gray-600 hover:bg-gray-800 px-6 py-2 rounded text-white'>
                    Voltar
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class='mb-4 font-bold text-lg'>{{ __("Nova Pessoa") }}</h1>

                    <form id="form-cadastrar" method="POST" action="{{ route('pessoas.store') }}">
                        @csrf

                        <div class="mb-4">
                            <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                            <input type="text" name="nome" id="nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="mb-4">
                            <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                            <input type="date" name="data_nascimento" id="data_nascimento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="form-group mb-4">
                            <label for="tipo_pessoa" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" name="tipo_pessoa" id="tipo_pessoa" required>
                                <option value="Profissional">Profissional</option>
                                <option value="Acolhido">Acolhido</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label for="cpf" class="block text-sm font-medium text-gray-700">CPF</label>
                            <input type="text" name="cpf" id="cpf" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="xxx.xxx.xxx-xx">
                        </div>

                        <div class="mb-4">
                            <label for="telefone_contato" class="block text-sm font-medium text-gray-700">Telefone de Contato</label>
                            <input type="text" name="telefone_contato" id="telefone_contato" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" placeholder="(xx) xxxx-xxxx">
                        </div>

                        <div class="mb-4">
                            <label for="foto_perfil" class="block text-sm font-medium text-gray-700">Foto de Perfil (URL)</label>
                            <input type="text" name="foto_perfil" id="foto_perfil" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                    </form>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>
