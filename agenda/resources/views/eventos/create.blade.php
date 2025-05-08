<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/2'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Novo Evento') }}</h2>
            </div>
            <div class='w-1/2 flex justify-end space-x-2'>
                <a href="{{ route('eventos.index') }}"
                    class='bg-gray-600 hover:bg-gray-800 px-4 py-2 rounded text-white'>Voltar</a>
                <button form="formEvento" type="submit"
                    class="bg-blue-700 hover:bg-blue-900 px-6 py-2 rounded text-white">Salvar</button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    @if ($errors->any())
                        <div class="mb-4 p-4 bg-red-100 text-red-800 rounded">
                            <ul class="list-disc list-inside">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('eventos.store') }}" id="formEvento">
                        @csrf

                        <!-- Data e Hora de Início -->
                        <div class="mb-4">
                            <label for="data_ini" class="block text-sm font-medium text-gray-700">Data e Hora de Início</label>
                            <input type="datetime-local" name="data_ini" id="data_ini" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Data e Hora Final Estimada -->
                        <div class="mb-4">
                            <label for="data_fim" class="block text-sm font-medium text-gray-700">Data e Hora Final Estimada</label>
                            <input type="datetime-local" name="data_fim" id="data_fim" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Título -->
                        <div class="mb-4">
                            <label for="titulo" class="block text-sm font-medium text-gray-700">Título</label>
                            <input type="text" name="titulo" id="titulo" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                        </div>

                        <!-- Descrição -->
                        <div class="mb-4">
                            <label for="descricao" class="block text-sm font-medium text-gray-700">Descrição</label>
                            <textarea name="descricao" id="descricao" rows="4" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500"></textarea>
                        </div>

                        <!-- Profissionais -->
                        <div class="mb-4">
                            <label for="profissionais" class="block text-sm font-medium text-gray-700">Profissionais</label>
                            <select name="profissionais[]" id="profissionais" multiple
                                class="select2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($profissionais as $profissional)
                                    <option value="{{ $profissional->id }}">{{ $profissional->nome }} - {{ $profissional->cpf }}</option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Você pode buscar por nome ou CPF.</small>
                        </div>

                        <!-- Acolhidos -->
                        <div class="mb-4">
                            <label for="acolhidos" class="block text-sm font-medium text-gray-700">Acolhidos</label>
                            <select name="acolhidos[]" id="acolhidos" multiple
                                class="select2 mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                @foreach ($acolhidos as $acolhido)
                                    <option value="{{ $acolhido->id }}">{{ $acolhido->nome }} - {{ $acolhido->cpf }}</option>
                                @endforeach
                            </select>
                            <small class="text-gray-500">Você pode buscar por nome ou CPF.</small>
                        </div>

                        <!-- Status -->
                        <div class="mb-4">
                            <label for="status" class="block text-sm font-medium text-gray-700">Status</label>
                            <select name="status" id="status" required
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500">
                                <option value="agendado">Agendado</option>
                                <option value="pendente">Pendente</option>
                                <option value="concluido">Concluído</option>
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Inclusão das bibliotecas Select2 -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script>
        $(document).ready(function() {
            $('.select2').select2({
                placeholder: "Selecione uma ou mais opções",
                allowClear: true,
                width: '100%'
            });
        });

        document.getElementById("formEvento").addEventListener("submit", function(e) {
            let datahora = new Date(document.getElementById("datahora").value);
            let datahoraFinal = new Date(document.getElementById("datahora_final").value);

            if (datahoraFinal < datahora) {
                e.preventDefault(); // Impede o envio do formulário
                alert("A data final deve ser maior ou igual à data inicial.");
            }
        });
    </script>
</x-app-layout>
