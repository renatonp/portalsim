<div class="callout-red shadow-sm mb-4">
    <div class="row">
        <div class="col-lg-6">
            <p><b>Endereço:</b> {{ convert_accentuation($registros->s_logradouro) }}</p>
            <p><b>Ano de Construção:</b> {{ $registros->i_ano_constru }}</p>
            <p><b>Data da Demolição:</b> {{ (!empty($registros->d_data_demol) ?? "") }}</p>
        </div>

        @php $varHb = null; @endphp

        @if (!empty($registros->aHabite->s_habitese) && !empty($registros->aHabite->s_habitese))
            @if ($registros->aHabite[0]->s_habitese != "")
                @php
                    $varHb = convert_accentuation($registros->aHabite[0]->s_habitese) . " - " . \Carbon\Carbon::parse($registros->aHabite[0]->d_dthabite)->format('d/m/Y')
                @endphp
            @endif
        @endif

        <div class="col-lg-6">
            <p><b>Área Construída m<sup>2</sup>:</b> {{ $registros->i_area_const }}</p>
            <p><b>Habite-se:</b> {{ $varHb }}</p>
        </div>
    </div>
</div>

<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Característica</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros->aConstrucoesCaracteristicaEncontradas as $caracteristica)
                <tr>
                    <td>{{ convert_accentuation($caracteristica->s_descricao) }}</td>
                    <td>{{ convert_accentuation($caracteristica->i_caracter) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
