<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Meus Compromissos') }}
        </h2>

        @if ($mensagem)
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded my-4" role="alert">
                <strong>Atenção:</strong> {{ $mensagem }}
            </div>
        @endif

        @if ($pessoaVinculada)
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded my-4" role="alert">
                <strong>Pessoa vinculada:</strong> {{ $pessoaVinculada }}
            </div>
        @endif
    </x-slot>

    <style>
        .calendar-wrapper {
            max-width: 1100px;
            margin: auto;
            border: 1px solid #ccc;
            font-family: Arial, sans-serif;
            display: flex;
            flex-direction: column;
            background: white;
            position: relative;
        }

        .calendar-header {
            display: grid;
            grid-template-columns: 70px repeat(5, 1fr);
            border-bottom: 1px solid #ccc;
            background: #f5f5f5;
            font-weight: bold;
            color: #333;
        }

        .calendar-header .time-label,
        .calendar-header .day-label {
            padding: 8px;
            border-right: 1px solid #ccc;
            text-align: center;
        }

        .calendar-body {
            display: grid;
            grid-template-columns: 70px repeat(5, 1fr);
            position: relative;
        }

        .time-column {
            border-right: 1px solid #ccc;
            background: #fafafa;
        }

        .time-slot {
            height: 30px;
            line-height: 30px;  /* centraliza vertical */
            text-align: center; /* centraliza horizontal */
            font-size: 12px;
            color: #666;
        }

        .day-column {
            position: relative;
            border-right: 1px solid #ccc;
            min-height: 720px; /* 24 horas x 30px */
        }

        .hour-row {
            height: 30px;
        }

        .hour-row:nth-child(even) {
            background-color: #f0f0f0;
        }

        .hour-row:nth-child(odd) {
            background-color: #ffffff;
        }

        .event {
            position: absolute;
            left: 5px;
            right: 5px;
            border-radius: 4px;
            padding: 4px 6px;
            font-size: 12px;
            color: white;
            white-space: nowrap;
            text-overflow: ellipsis;
            overflow: hidden;
            box-shadow: 0 2px 5px rgba(0, 0, 0, 0.15);
            z-index: 5;
        }

        .current-time-line {
            position: absolute;
            left: 70px;
            right: 0;
            height: 2px;
            background: red;
            z-index: 10;
        }
    </style>

    <div class="calendar-wrapper">
        <div class="calendar-header">
            <div class="time-label"></div>
            @foreach($diasSemana as $dia)
                <div class="day-label">
                    {{ $dia->locale('pt_BR')->isoFormat('dddd, DD/MM') }}
                </div>
            @endforeach
        </div>

        <div class="calendar-body">
            {{-- Coluna dos horários --}}
            <div class="time-column">
                @for ($hora = 0; $hora < 24; $hora++)
                    <div class="time-slot">{{ str_pad($hora, 2, '0', STR_PAD_LEFT) }}:00</div>
                @endfor
            </div>

            {{-- Colunas dos dias --}}
            @foreach($diasSemana as $dia)
                <div class="day-column">
                    {{-- Linhas horárias para efeito visual --}}
                    @for ($hora = 0; $hora < 24; $hora++)
                        <div class="hour-row"></div>
                    @endfor

                    @php
                        $alturaHora = 30; // pixels por hora
                        $eventosDia = $eventos->filter(fn($evento) => $evento->data_ini->isSameDay($dia));
                    @endphp

                    @foreach($eventosDia as $evento)
                        @php
                            $inicio = $evento->data_ini;
                            $fim = $evento->data_fim ?? $inicio->copy()->addHour();
                            $duracaoMinutos = $fim->diffInMinutes($inicio);
                            $altura = ($duracaoMinutos / 60) * $alturaHora;

                            $offsetMinutos = $inicio->hour * 60 + $inicio->minute;
                            $offsetPx = ($offsetMinutos / 60) * $alturaHora;

                            // Cores para eventos conforme horário
                            $corFundo = match (true) {
                                $inicio->hour < 12 => '#60a5fa',
                                $inicio->hour < 18 => '#3b82f6',
                                default => '#1e40af',
                            };

                            if($evento->status == 'concluido'){
                                $corFundo = '#166534';
                            }
                            else if ($evento->status == 'pendente'){
                                $corFundo = '#991b1b';
                            }
                        @endphp

                        <a href="{{route('eventos.show', $evento->id)}}">
                            <div class="event"
                                title="{{ $evento->titulo }} ({{ $inicio->format('H:i') }} - {{ $fim->format('H:i') }})"
                                style="top: {{ $offsetPx }}px; height: {{ $altura }}px; background-color: {{ $corFundo }};">
                                {{ $inicio->format('H:i') }} - {{ $evento->titulo }}
                            </div>
                        </a>
                    @endforeach
                </div>
            @endforeach
        </div>

        <div class="current-time-line" id="current-time-line"></div>
    </div>

    <script>
        function atualizarLinhaHoraAtual() {
            const now = new Date();
            const minutosNoDia = now.getHours() * 60 + now.getMinutes();
            const deslocamento = (minutosNoDia / 60) * 30; // 30px por hora
            const linha = document.getElementById('current-time-line');
            linha.style.top = deslocamento + 'px';
        }

        atualizarLinhaHoraAtual();
        setInterval(atualizarLinhaHoraAtual, 60000);
    </script>
</x-app-layout>
