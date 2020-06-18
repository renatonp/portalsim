@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>Consulta de Informações de Imóveis</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li><a href="{{  url('/servicos/1') }}">Cidadão </a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Consulta de Informações de Imóveis</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div>
            <div>
                <div class="col-md-12">

                    <div class="accordion" id="accordion3">
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse1">
                                    <i class="icon-minus"></i>
                                    Cadastro do Imóvel
                                </a>
                            </div>
                            <div id="collapse1" class="accordion-body collapse in">
                                <div class="accordion-inner">
                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                                Matrícula
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <input id="i_matricula" type="text"
                                                class="form-input{{ $errors->has('i_matricula') ? ' is-invalid' : '' }}"
                                                name="i_matricula" value="{{ $registro->i_matricula }}" readonly>
                                        </div>
                                        {{-- Separação --}}
                                        <div class="controls span1 form-label">
                                            <label for="" class="col-md-4 col-form-label text-md-right">
                                                &nbsp;
                                            </label>
                                        </div>

                                        <div class="controls span3 form-label">
                                            <label for="ultalt" class="col-md-4 col-form-label text-md-right">
                                                Referência Anterior
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <input id="i_referencia_anterior" type="text"
                                                class="form-input{{ $errors->has('i_referencia_anterior') ? ' is-invalid' : '' }}"
                                                name="i_referencia_anterior"
                                                value="{{ $registro->i_referencia_anterior  }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                                Nome
                                            </label>
                                        </div>

                                        <div class="span8">
                                            <input id="s_proprietario" type="text"
                                                class="form-input{{ $errors->has('s_proprietario') ? ' is-invalid' : '' }}"
                                                name="s_proprietario" value="{{ $registro->s_proprietario }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                                                Planta / Quadra / Lote
                                            </label>
                                        </div>

                                        <div class="span8">
                                            <input id="s_lote" type="text"
                                                class="form-input{{ $errors->has('s_lote') ? ' is-invalid' : '' }}"
                                                name="s_lote"
                                                value="{{ $registro->s_quadra }} / {{ $registro->s_quadra }} / {{ $registro->s_lote }}"
                                                readonly>
                                        </div>
                                    </div>
                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="s_logradouro" class="col-md-4 col-form-label text-md-right">
                                                Endereço
                                            </label>
                                        </div>

                                        <div class="span8">
                                            <input id="s_logradouro" type="text"
                                                class="form-input{{ $errors->has('s_lote') ? ' is-invalid' : '' }}"
                                                name="s_logradouro" value="{{ $registro->s_logradouro }}" readonly>
                                        </div>
                                    </div>
                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="s_bairro" class="col-md-4 col-form-label text-md-right">
                                                Bairro
                                            </label>
                                        </div>

                                        <div class="span8">
                                            <input id="s_bairro" type="text"
                                                class="form-input{{ $errors->has('s_bairro') ? ' is-invalid' : '' }}"
                                                name="s_bairro" value="" readonly>
                                        </div>
                                    </div>

                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="i_mobiliaria" class="col-md-4 col-form-label text-md-right">
                                                Imobiliária
                                            </label>
                                        </div>

                                        <div class="span8">
                                            <input id="i_mobiliaria" type="text"
                                                class="form-input{{ $errors->has('i_mobiliaria') ? ' is-invalid' : '' }}"
                                                name="i_mobiliaria" value="{{ $registro->i_mobiliaria }}" readonly>
                                        </div>
                                    </div>

                                    <div class="row formrow">
                                        <div class="controls span3 form-label">
                                            <label for="i_araa_lote" class="col-md-4 col-form-label text-md-right">
                                                Área do Lote
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <input id="i_araa_lote" type="text"
                                                class="form-input{{ $errors->has('i_araa_lote') ? ' is-invalid' : '' }}"
                                                name="i_araa_lote" value="{!! $registro->i_araa_lote .' m2' !!} "
                                                readonly>
                                        </div>
                                        {{-- Separação --}}
                                        <div class="controls span1 form-label">
                                            <label for="" class="col-md-4 col-form-label text-md-right">
                                                &nbsp;
                                            </label>
                                        </div>

                                        <div class="controls span3 form-label">
                                            <label for="d_data_baixa" class="col-md-4 col-form-label text-md-right">
                                                Data Baixa
                                            </label>
                                        </div>

                                        <div class="span2">
                                            <input id="d_data_baixa" type="text"
                                                class="form-input{{ $errors->has('d_data_baixa') ? ' is-invalid' : '' }}"
                                                name="d_data_baixa" value="{!! $registro->d_data_baixa !!}" readonly>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse2">
                                    <i class="icon-plus"></i>
                                    Característica do Imóvel
                                </a>
                            </div>
                            <div id="collapse2" class="accordion-body collapse">
                                <div class="accordion-inner">

                                    <table id="caracteristicas" class="display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>Grupo</th>
                                                <th>Característica</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($registro->aCaracteristicasEncontradas as $caracteristica)
                                            <tr>
                                                <td>{{ $caracteristica->s_descri }}</td>
                                                <td>{{ $caracteristica->s_descri }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>





                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse3">
                                    <i class="icon-plus"></i>
                                    Cadastro do Lote
                                </a>
                            </div>
                            <div id="collapse3" class="accordion-body collapse">
                                <div class="accordion-inner">

                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse4">
                                    <i class="icon-plus"></i>
                                    Cadastro de Construções
                                </a>
                            </div>
                            <div id="collapse4" class="accordion-body collapse">
                                <div class="accordion-inner">

                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse5">
                                    <i class="icon-plus"></i>
                                    Outros Proprietários
                                </a>
                            </div>
                            <div id="collapse5" class="accordion-body collapse">
                                <div class="accordion-inner">

                                </div>
                            </div>
                        </div>
                        <div class="accordion-group">
                            <div class="accordion-heading">
                                <a class="accordion-toggle" data-toggle="collapse" data-parent="#accordion3"
                                    href="#collapse6">
                                    <i class="icon-plus"></i>
                                    Isenções e Cálculos
                                </a>
                            </div>
                            <div id="collapse6" class="accordion-body collapse">
                                <div class="accordion-inner">

                                </div>
                            </div>
                        </div>
                    </div>



                    {{--  <div class="row formrow">
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
                        value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', Auth::user()->name))) }}" readonly>
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
                                <td>{{ $registro->matricula }}</td>
                                <td>{{ $registro->tipo }}</td>
                                <td>{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->bairro ))) }}
                                </td>
                                <td>{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->logradouro ))) }}
                                </td>
                                <td>{{ $registro->numero }}</td>
                                <td>{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $registro->complemento ))) }}
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
            </div> --}}
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
            var table = $('#caracteristicas').DataTable({
                                "language": {
                                    "url": "//cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json"
                                },
                        });

        });
</script>
@endsection