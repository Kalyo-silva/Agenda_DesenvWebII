<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Agenda do mês de ' . $referencia->locale('pt_BR')->isoFormat('MMMM [de] YYYY')) }}
        </h2>
    </x-slot>

    <style>
        .calendar-wrapper {
            max-width: 1200px;
            margin: 20px auto;
            background: white;
            border-radius: 8px;
            padding: 16px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        .calendar-controls {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            align-items: center;
        }
        .calendar-controls a {
            color: #3b82f6;
            font-weight: bold;
            text-decoration: none;
        }
        .calendar-grid {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 4px;
        }
        .day-name {
            text-align: center;
            font-weight: bold;
            color: #555;
            font-size: 0.8rem;
        }
        .day-box {
            min-height: 100px;
            padding: 6px;
            border: 1px solid #ccc;
            background-color: #f9f9f9;
            position: relative;
            font-size: 0.9rem;
            border-radius: 4px;
        }
        .day-box.today {
            border: 2px solid red;
            background: #fff0f0;
        }
        .day-number {
            font-weight: bold;
            font-size: 14px;
        }
        .event-title {
            margin-top: 4px;
            font-size: 12px;
            background: #3b82f6;
            color: white;
            border-radius: 4px;
            padding: 2px 4px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
    </style>

    <div class="calendar-wrapper">
        <form method="GET" action="{{ route('agenda.index') }}" class="mb-4 flex justify-between items-center gap-2">
            <div>
                <select name="pessoa_id" onchange="this.form.submit()" class="border rounded px-3 py-1 text-sm">
                    <option value="">Todas as pessoas</option>
                    @foreach($pessoas as $pessoa)
                        <option value="{{ $pessoa->id }}" {{ $pessoaId == $pessoa->id ? 'selected' : '' }}>
                            {{ $pessoa->nome }}
                        </option>
                    @endforeach
                </select>
            </div>
            <input type="hidden" name="ano" value="{{ $referencia->year }}">
            <input type="hidden" name="mes" value="{{ $referencia->month }}">
        </form>

        <div class="calendar-controls">
            @php
                $mesAnterior = $referencia->copy()->subMonth();
                $mesPosterior = $referencia->copy()->addMonth();
            @endphp

            <a href="{{ route('agenda.index', ['ano' => $mesAnterior->year, 'mes' => $mesAnterior->month, 'pessoa_id' => $pessoaId]) }}">← Mês anterior</a>
            <span>{{ $referencia->locale('pt_BR')->isoFormat('MMMM [de] YYYY') }}</span>
            <a href="{{ route('agenda.index', ['ano' => $mesPosterior->year, 'mes' => $mesPosterior->month, 'pessoa_id' => $pessoaId]) }}">Próximo mês →</a>
        </div>

        <div class="calendar-grid">
            @foreach (['D', 'S', 'T', 'Q', 'Q', 'S', 'S'] as $dia)
                <div class="day-name">{{ $dia }}</div>
            @endforeach

            @foreach ($diasDoMes as $dia)
                <div class="day-box {{ $dia->isSameDay($hoje) ? 'today' : '' }}">
                    <div class="day-number">{{ $dia->day }}</div>

                    @foreach ($eventos as $evento)
                        @php
                            $dataIni = \Carbon\Carbon::parse($evento->data_ini)->startOfDay();
                            $dataFim = \Carbon\Carbon::parse($evento->data_fim)->endOfDay();
                        @endphp
                        @if ($dia->between($dataIni, $dataFim))
                            <div class="event-title" title="{{ $evento->titulo }} ({{ $dataIni->format('d/m H:i') }} - {{ $dataFim->format('d/m H:i') }})">
                                {{ $evento->titulo }}
                            </div>
                        @endif
                    @endforeach
                </div>
            @endforeach
        </div>
    </div>
</x-app-layout>
