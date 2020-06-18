<div class="row">
    <div class="col-lg-12">
        @if (isset($registros->aListaItbiQuitado))
            <div class="table-responsive">
                <table class="table table-bordered mt-3">
                    <thead>
                        <tr>
                            <th>Inscrição</th>
                            <th>Guia</th>
                            <th>Data</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($registros->aListaItbiQuitado as $registro)
                            @php
                                $year = explode('-', $registro->it01_data)[0];
                            @endphp

                            <tr>
                                <td>{{ $year }}</td>
                                <td>{{ $registro->it01_guia }}</td>
                                <td>{{ convert_date_br($registro->it01_data) }}</td>
                                <td>
                                    <a href="{{ route('certidaoITBIImprimir', ['matri' => $year, 'guia' => $registro->it01_guia]) }}" 
                                        class="btn btn-primary btn-sm">
                                        
                                        <i class="fa fa-print"></i> Imprimir
                                    </a>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="alert alert-danger">
                Não há registros de Certidão de Quitação ITBI para esse imóvel.
            </div>
        @endif
    </div>
</div>