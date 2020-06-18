<div class="callout-red shadow-sm mb-4">
    <div class="row">
        <div class="col-lg-6">
            <p><b>Logradouro:</b> {{ convert_accentuation($registros->s_logradouro) }}</p>
            <p><b>Valor Testada:</b> {{$registros->aLoteTestadaEncontradas[0]->i_testada }}</p>
        </div>

        <div class="col-lg-6">
            <p><b>Valor m<sup>2</sup> Terreno:</b> {{ $registros->aLoteTestadaEncontradas[0]->f_vl_terreno }}</p>
            <p><b>Valor m<sup>2</sup> Predial:</b> {{ $registros->aLoteTestadaEncontradas[0]->f_vl_predial }}</p>
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
            @foreach ($registros->aCaracteristicaFace as $caracteristica)
                <tr>
                    <td>{{ convert_accentuation($caracteristica->j32_descr) }}</td>
                    <td>{{ convert_accentuation($caracteristica->j31_descr) }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
