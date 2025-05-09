<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Minha Agenda') }}
        </h2>
    </x-slot>

    <div class="py-6 px-4 max-w-7xl mx-auto">
        <div class="bg-white shadow overflow-hidden rounded-lg border border-gray-300">
            <div class="grid grid-cols-8 border-b border-gray-400 text-sm font-semibold text-center bg-gray-100">
                <div class="py-3 px-4 text-left border-r border-gray-300">Horário</div>
                @foreach(['Mon' => 'Seg', 'Tue' => 'Ter', 'Wed' => 'Qua', 'Thu' => 'Qui', 'Fri' => 'Sex', 'Sat' => 'Sáb', 'Sun' => 'Dom'] as $key => $dia)
                <div class="py-3 border-r border-gray-300">{{ $dia }}</div>
                @endforeach
            </div>

            @for ($hora = 8; $hora <= 18; $hora++)
                <div class="grid grid-cols-8 border-b border-gray-200 text-sm text-center">
                <div class="py-6 px-2 text-left text-gray-700 font-medium bg-gray-50 border-r border-gray-300">
                    {{ str_pad($hora, 2, '0', STR_PAD_LEFT) }}:00
                </div>

                @foreach(['Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat', 'Sun'] as $dia)
                <div class="h-24 relative border-r border-gray-200 hover:bg-gray-50 transition-all">
                    @if (isset($eventosMapeados[$hora][$dia]))
                    @foreach ($eventosMapeados[$hora][$dia] as $evento)
                    <div class="absolute inset-1 bg-blue-600 text-white text-xs rounded p-1 shadow z-10">
                        {{ $evento->titulo }}
                        <div class="text-[10px] mt-1">
                            {{ \Carbon\Carbon::parse($evento->data_ini)->format('H:i') }}
                            -
                            {{ \Carbon\Carbon::parse($evento->data_fim)->format('H:i') }}
                        </div>
                    </div>
                    @endforeach
                    @endif
                </div>
                @endforeach
        </div>
        @endfor
    </div>

    </div>
</x-app-layout>