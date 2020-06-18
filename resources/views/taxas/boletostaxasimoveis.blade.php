@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>Boletos de Taxas</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{  url('/servicos/1') }}">Cidadão </a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Boletos de Taxas</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="aligncenter">
            <div class="row justify-content-center">
                <div class="col-md-10">
                    <div class="row formrow">
                        <div class="controls span2 form-label">
                            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                @if( strlen(Auth::user()->cpf) > 11 )
                                {{ __('CNPJ') }}
                                @else
                                {{ __('CPF') }}
                                @endif
                            </label>
                        </div>

                        <div class="span2">
                            <input id="cpf2" type="text" class="form-input" name="cpf2" value="{{ Auth::user()->cpf }}"
                                readonly>
                        </div>
                    </div>
                    <div class="row formrow">
                        <div class="controls span2 form-label">
                            <label for="nome" class="col-md-4 col-form-label text-md-right">
                                {{ __('NOME') }}
                            </label>
                        </div>
                        <div class="span10">
                            <input id="nome" type="text" class="form-input" name="nome"
                                value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', Auth::user()->name))) }}"
                                readonly>
                        </div>
                    </div>
                    <br />
                    <br />

                    <div class="card">
                        <div class="span12 text-left">
                            <h3>Lista de Imóveis</h3>
                        </div>
                    </div>
                    <div class="card">
                        <div class="span12 text-left">
                            <table id="imoveis" class="display" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Matrícula</th>
                                        <th>Tipo</th>
                                        <th>Bairro</th>
                                        <th>Logradouro</th>
                                        <th>Número</th>
                                        <th>Compl.</th>
                                        <th>Planta / Quadra / Lote</th>
                                        <th>Ações</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($registros->aMatriculasListaCertidaoEncontradas as $registro)
                                    <tr>
                                        <td>
                                            {{ $registro->matricula }}
                                        </td>
                                        <td>
                                            {{ $registro->tipo }}
                                        </td>
                                        <td>
                                            {{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->bairro ))) }}
                                        </td>
                                        <td>
                                            {{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->logradouro ))) }}
                                        </td>
                                        <td>{{ $registro->numero }}</td>
                                        <td>
                                            {{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->complemento ))) }}
                                        </td>
                                        <td>
                                            {{ $registro->planta }} /
                                            {{ $registro->quadra }} /
                                            {{ $registro->lote }}
                                        </td>
                                        <td>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card">
                        <div class="span12 text-left">
                            <a href="{{ url('servicos/1')  }}">
                                <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                    {{ __('Voltar') }}
                                </button>
                                <a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
    <br>
    <br>
</section>


@endsection


@section('post-script')
<script type="text/javascript">
    jQuery(document).ready(function(){
            var table = $('#imoveis').DataTable({
                                "language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                                },
                                "columnDefs": [ {
                                "targets": -1,
                                "data": null,
                                "defaultContent": "<button>Gerar Boletos</button>"
                            } ]
                        });

            $('#imoveis tbody').on( 'click', 'button', function () {
                var data = table.row( $(this).parents('tr') ).data();
                // alert( "Matrícula do imóvel: "+ data[ 0 ] );

                var url = "{{URL::to('/boletosTaxasSelecionar/:id')}}";
                url = url.replace(':id', data[ 0 ]);
                
                window.location.href = url;
            } );
        });
</script>
@endsection