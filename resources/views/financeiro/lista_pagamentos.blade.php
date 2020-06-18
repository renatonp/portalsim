@extends('layouts.tema_principal')
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col d-flex justify-content-center">
            <div class="col-lg-12">
                <h2 class="mb-4"><i class="fa fa-home"></i> Consulta Geral Financeira</h2>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="container">
                        <form action="{{ Route('integracaoRelatorioPagamentosEfetuados') }}" method="post">
                            @csrf
                            <div class="form-row">
                                <div class="col-md-6 mb-3">
                                    @if(strlen(Auth::user()->cpf ) == 14)
                                    <label for="cpf">{{ __('CPF') }}</label>
                                    <input type="hidden" id="hd_cpf" value="{{ Auth::user()->cpf }}">
                                    @else
                                    <label for="cpf">{{ __('CNPJ') }}</label>
                                    @endif
                                    <input type="text" class="form-control form-control-sm" name="cpf" value="{{ Auth::user()->cpf }}" readonly="readonly" />
                                </div>
                                <div class="col-md-6 mb-3">
                                    @if(strlen(Auth::user()->cpf ) == 14)
                                    <label for="matricula">{{ __('Matrícula') }}</label>
                                    @else
                                    <label for="matricula">{{ __('Inscrição') }}</label>
                                    @endif
                                    <input type="text" class="form-control form-control-sm" name="matricula" value="{{ $request->matricula }}" readonly="readonly" />
                                </div>
                                <div class="col-md-12 mb-3">
                                    <label for="nome">{{ __('Nome') }}</label>
                                    <input type="text" class="form-control form-control-sm" name="nome" value="{{ Auth::user()->name }}" readonly="readonly" />
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-header">
                    <h4>{{ $pagina }}</h4>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                        <table class="table table-striped table-hover fixed-header" >
                            <thead>
                                <tr>
                                    <th width="15%" align="center">Cod. Arrecadação</th>
                                    <th width="15%" align="center">Operação</th>
                                    <th width="14%" align="center">Parcela</th>
                                    <th width="14%" align="center">Vencimento</th>
                                    <th width="14%" align="center">Receita</th>
                                    <th width="14%" align="center">Valor</th>
                                    <th width="14%" align="center">Pagamento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($data->aPagamentosEfetuadoss as $item)
                                <tr>
                                    <td width="15%" align="center">{{ $item->k00_numpre }}</td>
                                    <td width="15%" align="center">{{ date('d/m/Y', strtotime($item->k00_dtoper)) }}</td>
                                    <td width="14%" align="center">{{ $item->k00_numpar }}</td>
                                    <td width="14%" align="center">{{ date('d/m/Y', strtotime($item->k00_dtvenc)) }}</td>
                                    <td width="14%" align="center">{{ str_replace('%2F','/',str_replace('+',' ',$item->k02_drecei)) }}</td>
                                    <td width="14%" align="center">R$ {{ $item->k00_valor }}</td>
                                    <td width="14%" align="center">{{ date('d/m/Y', strtotime($item->efetpagto)) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="total">{{ __('Total Pago') }}</label>
                            <input type="text" class="form-control" name="total" value="R$ {{ $total }}" readonly />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <span id="btn_voltar" class="btn btn-primary form-control mt-3" value="Voltar"><i class="fa fa-arrow-left"></i> Voltar</button>
                    </div>
                    <div class="col-md-6">
                        <button id="btn_imprimir" type="submit" class="btn btn-success form-control mt-3">Imprimir <i class="fa fa-print"></i></button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $('#btn_voltar').click(function(){
            history.back();
        });
    });
</script>
@endsection
