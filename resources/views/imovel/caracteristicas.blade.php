<div class="table-responsive">
    <table class="table table-striped table-hover">
        <thead>
            <tr>
                <th>Grupo</th>
                <th>Característica</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($registros->aCaracteristicasEncontradas as $caracteristica)
                @php
                    $caracteristica = explode(" - ", convert_accentuation($caracteristica->s_descri));
                @endphp

                <tr>
                    <td>{{ $caracteristica[0] }}</td>
                    <td>{{ $caracteristica[1] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

