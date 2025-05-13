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

                    <form id="form-cadastrar" method="POST" enctype="multipart/form-data" action="{{ route('pessoas.store') }}">
                        @csrf
                        <div class="flex">
                            <div class="mb-4">
                                <label for="foto_perfil" class="block text-sm font-medium text-gray-700">Foto de Perfil 
                                    <div id="Preview" class='w-32 h-32 rounded border mr-2 overflow-hidden hover:brightness-50 hover:cursor-pointer'>
                                        <img class="object-cover w-full h-full"
                                             src="{{asset('img/defaultpfp.png')}}"
                                             alt="pfp">
                                     </div>
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
                                    <input type="text" name="nome" id="nome" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>

                                <div class="mb-4">
                                    <label for="data_nascimento" class="block text-sm font-medium text-gray-700">Data de Nascimento</label>
                                    <input type="date" name="data_nascimento" id="data_nascimento" required class="mt-1 block w-full border-gray-300 rounded-md shadow-sm">
                                </div>
                            </div>
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
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>


<script>
    const input = document.getElementById("foto_perfil");
    const Preview = document.getElementById("Preview");

    input.addEventListener("change", updateImageDisplay);

    function updateImageDisplay(){        
        const curFiles = input.files;

        if (curFiles.length != 0){ 
            while (Preview.firstChild){
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