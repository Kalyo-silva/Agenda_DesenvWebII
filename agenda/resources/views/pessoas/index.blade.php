<x-app-layout>
    <x-slot name="header">
        <div class = 'flex items-center'>
            <div class='w-1/4'>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">{{ __('Pessoas') }}</h2>
            </div>
            <div class='w-3/4 flex place-content-end'>
                <button onclick="window.location='{{route("pessoas.create")}}'" class='bg-blue-700 hover:bg-blue-900 px-4 py-2 rounded text-white'>Adicionar</button>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class='m-2 font-bold text-lg'>{{ __("Todas as Pessoas Cadastradas") }}</h1>

                    <div class='grid md:grid-cols-3'>
                        @foreach ($listaPessoas as $pessoa)
                            <div class="flex m-2 p-2 border rounded cursor-pointer">
                                <div class='size-16 rounded border mr-2'>
                                    <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQADjfoADAlJPrsl_hiiOMeE-FBor-i6hEAVg&s" alt="pfp">
                                </div>
                                <div>
                                    <h3 class='font-bold'>{{$pessoa->nome}}</h3>
                                    <p class='text-sm italic text-gray-700'>{{date('d/m/Y', strtotime($pessoa->data_nascimento))}}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
