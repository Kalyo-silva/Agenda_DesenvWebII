<x-app-layout>
    <x-slot name="header">
        <div class='flex items-center'>
            <div class='w-1/2'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Editar Pessoa') }}</h2>
            </div>
            <div class='w-1/2 flex justify-end'>
                <button type="submit" form="form-editar"
                    class="bg-blue-600 hover:bg-blue-700 px-6 py-2 rounded text-white mr-2">
                    Salvar
                </button>

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
                    class="bg-gray-600 hover:bg-gray-800 px-6 py-2 rounded text-white">
                    Voltar
                </a>
            </div>

        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class='mb-4 font-bold text-lg'>{{ __('Editando: ' . $pessoa->nome) }}</h1>

                    <form id="form-editar" method="POST" enctype="multipart/form-data" action="{{ route('pessoas.update', $pessoa->id) }}">
                        @csrf
                        @method('PUT')

                        <div class="flex">
                            <div class="mb-4">
                                <label for="foto_perfil" class="block text-sm font-medium text-gray-700">Foto de Perfil
                                    @if ($pessoa->foto_perfil != null and file_exists(public_path('pfp').DIRECTORY_SEPARATOR.$pessoa->foto_perfil))
                                    <div id="Preview" class='w-32 h-32 rounded border mr-2 overflow-hidden hover:brightness-50 hover:cursor-pointer'>
                                        <img src="{{ asset('pfp/' . $pessoa->foto_perfil) }}"
                                            alt="Foto de Perfil"
                                            class="object-cover w-full h-full">
                                    </div>
                                    @else
                                    <div id="Preview" class='w-32 h-32 rounded border mr-2 overflow-hidden hover:brightness-50 hover:cursor-pointer'>
                                        <img src="{{ asset('img/defaultpfp.png')}}"
                                            alt="Foto de Perfil"
                                            class="object-cover w-full h-full">
                                    </div>
                                    @endif
                                </label>

                                <input type="file"
                                    name="foto_perfil"
                                    id="foto_perfil"
                                    accept=".jpg, .jpeg, .png"
                                    class="mt-1 block absolute w-full border-gray-300 rounded-md shadow-sm opacity-0">
                            </div>

                            <div class="w-full ml-2">
                                <div class="mb-4">
                                    <label for="nome" class="block text-sm font-medium text-gray-700">Nome</label>
                                    <input type="text"
                                        name="nome"
                                        id="nome"
                                        value="{{ old('nome', $pessoa->nome) }}"
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div class="mb-4">
                                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                    <input type="date"
                                        name="data_nascimento"
                                        id="data_nascimento"
                                        value="{{ old('data_nascimento', \Carbon\Carbon::parse($pessoa->data_nascimento)->format('Y-m-d')) }}"
                                        required
                                        class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
                        </div>

                        <div class="form-group mb-4">
                            <label for="tipo_pessoa" class="block text-sm font-medium text-gray-700">Tipo</label>
                            <select class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm" name="tipo_pessoa" id="tipo_pessoa" required>
                                <option value="Profissional" {{ $pessoa->tipo_pessoa == 'Profissional' ? 'selected' : '' }}>Profissional</option>
                                <option value="Acolhido" {{ $pessoa->tipo_pessoa == 'Acolhido' ? 'selected' : '' }}>Acolhido</option>
                            </select>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">CPF</label>
                            <input type="text" name="cpf" value="{{ old('cpf', $pessoa->cpf) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Telefone de Contato</label>
                            <input type="text" name="telefone_contato"
                                value="{{ old('telefone_contato', $pessoa->telefone_contato) }}"
                                class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                        </div>

                        <div class="form-group mb-4">
                            <label for="usuario_id" class="block text-sm font-medium text-gray-700">Usuário Vinculado</label>
                            <select name="usuario_id" id="usuario_id" class="form-control mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">-- Nenhum usuário vinculado --</option>
                                @foreach ($usuarios as $usuario)
                                <option value="{{ $usuario->id }}" {{ $pessoa->usuario_id == $usuario->id ? 'selected' : '' }}>
                                    {{ $usuario->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <x-confirmacao-exclusao />
</x-app-layout>



<script>
    const input = document.getElementById("foto_perfil");
    const Preview = document.getElementById("Preview");

    input.addEventListener("change", updateImageDisplay);

    function updateImageDisplay() {
        const curFiles = input.files;

        if (curFiles.length != 0) {
            while (Preview.firstChild) {
                Preview.removeChild(Preview.firstChild);
            }


            for (const file of curFiles) {
                const image = document.createElement("img");
                image.src = URL.createObjectURL(file);
                image.alt = file.name;
                image.className = "object-cover w-full h-full";

                Preview.appendChild(image);
            }
        }
    }
</script>