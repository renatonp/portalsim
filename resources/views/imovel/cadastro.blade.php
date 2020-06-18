<div class="callout-red shadow-sm">
    <div class="row">
        <div class="col-lg-6">
            <p><b>Mátricula:</b> {{ $registros->i_matricula }}</p>
            <p><b>Nome:</b> {{ convert_accentuation($registros->s_proprietario) }}</p>
            <p><b>Endereço:</b> {{ convert_accentuation($registros->s_logradouro) }} </p>
            <p><b>Bairro:</b> {{ $registros->s_bairro }}</p>
            <p><b>CEP:</b> {{ $registros->s_cep }}</p>
        </div>

        <div class="col-lg-6">
            <p><b>Referência Cartográfica:</b> {{ $registros->i_referencia_anterior }}</p>
            <p><b>Planta/Quadra/Lote:</b> {{ $registros->s_planta }} / {{ $registros->i_quadra }} / {{ $registros->i_lote }}</p>
            <p><b>Imobiliária:</b> {{ $registros->i_mobiliaria }}</p>
            <p><b>Área do Lote:</b> {{ $registros->i_araa_lote }} <b>m<sup>2</sup></b></p>
            <p><b>Data da Baixa:</b> {{ (!empty($registros->d_data_baixa) ? \Carbon\Carbon::parse($registros->d_data_baixa)->format('d/m/Y') : "Não tem data")  }}</p>
        </div>
    </div>
</div>
