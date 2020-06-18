@if (!empty($registros->aOutrosProprietariosEncontradas->s_nome))

    @foreach ($registros->aOutrosProprietariosEncontradas as $proprietario)
        <div class="callout-red shadow-sm mb-3">
            <div class="row">
                <div class="col-lg-12">
                    <p><b>Nome:</b> {{ convert_accentuation($proprietario->s_nome) }}</p>
                </div>

                <div class="col-lg-12">
                    <p><b>CPF / CNPJ:</b> {{ $proprietario->s_cpfcnpj }}</p>
                </div>

                <div class="col-lg-12">
                    <p><b>Endereço:</b> {{ convert_accentuation($proprietario->s_endereco) }}</p>
                </div>
            </div>
        </div>
    @endforeach

@else
    <p>Não existe outros proprietários cadastrados.</p>
@endif
