@if (count($registros->aIsentosEncontradas) > 0)

    @foreach ($registros->aIsentosEncontradas as $isencao)

        @if($isencao->s_tipo != "")

            @php
                $datas = explode(" - ", $isencao->d_validade)   
            @endphp

            <div class="callout-red shadow-sm mb-3">
                <div class="row">
                    <div class="col-lg-12">
                        <p><b>Período:</b> {{ \Carbon\Carbon::parse($datas[0])->format('d/m/Y')  }} - {{ \Carbon\Carbon::parse($datas[1])->format('d/m/Y') }}</p>
                    </div>

                    <div class="col-lg-12">
                        <p><b>Tipo:</b> {{ convert_accentuation($isencao->s_tipo) }}</p>
                    </div>

                    <div class="col-lg-12">
                        <p><b>Motivo:</b> {{ convert_accentuation($isencao->s_motivo) }}</p>
                    </div>
                </div>
            </div>
        @else
            <p>Não existe registros.</p>
        @endif
        
    @endforeach

@else
    <p>Não existe registros.</p>
@endif
