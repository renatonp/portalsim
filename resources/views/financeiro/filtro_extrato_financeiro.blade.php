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
                <div class="card-header"><h4>{{ $pagina }}</h4></div>
                <div class="card-body">
                    <div class="container">
                        <div class="form-row">
                            <div class="col-md-6 mb-3">
                                @if(strlen(Auth::user()->cpf ) == 14)
                                <label for="cpf">{{ __('CPF') }}</label>
                                @else
                                <label for="cpf">{{ __('CNPJ') }}</label>
                                @endif
                                <input type="text" class="form-control form-control-sm" name="cpf" value="{{ Auth::user()->cpf }}" readonly="readonly" />
                            </div>
                            <div class="col-md-6 mb-3">
                                @if(strlen(Auth::user()->cpf ) == 14)
                                <label for="matricula">{{ __('Matrícula') }}</label>
                                <input type="text" class="form-control form-control-sm" name="matricula" value="{{ $matricula }}" readonly="readonly" />
                                @else
                                <label for="matricula">{{ __('Inscrição') }}</label>
                                <input type="text" class="form-control form-control-sm" name="matricula" value="{{ $inscricao }}" readonly="readonly" />
                                @endif
                            </div>
                            <div class="col-md-12 mb-3">
                                <label for="nome">{{ __('Nome') }}</label>
                                <input type="text" class="form-control form-control-sm" name="nome" value="{{ Auth::user()->name }}" readonly="readonly" />
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="{{ route('integracaoRelatorioTotalDebitos') }}" method="post" id="formulario">
                        @csrf
                        <div class="container">
                            <div class="row">
                                <div class="col-md-6"><input type="hidden" class="form-input" name="cpf" id="cpf" value="{{ $cpf }}"><input type="hidden" class="form-input" name="ro_cpf" id="ro_cpf" value="{{ $cpf }}"></div>
                                <div class="col-md-6"><input type="hidden" class="form-input" name="ro_nome" id="ro_nome" value="{{ $nome }}"></div>
                            </div>
                            <input type="hidden" name="tipo" id="tipo" value="{{ $tipo }}">
                            @if($tipo == 'i')
                            <input type="hidden" name="inscricao" id="inscricao" value="{{ $inscricao }}">
                            @else
                            <input type="hidden" name="matricula" id="matricula" value="{{ $matricula }}">
                            @endif
                            <div class="row">
                                <div class="col-md-12" align="center">
                                    <input type="radio" name="tipo_relatorio" value="c" class="tipo_relatorio">&nbsp;&nbsp;<strong>Analítico (Detalhado)</strong>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" name="tipo_relatorio" value="r" class="tipo_relatorio">&nbsp;&nbsp;<strong>Sintético (Resumido)</strong>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <button id="btn_voltar" class="btn btn-primary form-control mt-3"><i class="fa fa-arrow-left"></i> Voltar</button>
                </div>
                <div class="col-md-6">
                    <button id="btn_imprimir" class="btn btn-success form-control mt-3" style="visibility: hidden;">Imprimir <i class="fa fa-print"></i></button>
                </div>
            </div>
        </div>
    </div>
</div>
    <script type="text/javascript">
        function download_file(fileURL, fileName) {
            if (!window.ActiveXObject) {
                var save = document.createElement('a');
                save.href = fileURL;
                save.target = '_blank';
                var filename = fileURL.substring(fileURL.lastIndexOf('/')+1);
                save.download = fileName || filename;
                    if ( navigator.userAgent.toLowerCase().match(/(ipad|iphone|safari)/) && navigator.userAgent.search("Chrome") < 0) {
                        document.location = save.href; 
                    // window event not working here
                    }else{
                        var evt = new MouseEvent('click', {
                            'view': window,
                            'bubbles': true,
                            'cancelable': false
                        });
                        save.dispatchEvent(evt);
                        (window.URL || window.webkitURL).revokeObjectURL(save.href);
                    }   
            }

            else if ( !! window.ActiveXObject && document.execCommand)     {
                var _window = window.open(fileURL, '_blank');
                _window.document.close();
                _window.document.execCommand('SaveAs', true, fileName || fileURL)
                _window.close();
            }
        }

        $(document).ready(function(){
            $('#btn_voltar').click(function(){
                history.back();
            });
            $('.tipo_relatorio').click(function(){
                $('#btn_imprimir').css("visibility","visible");
            });


            $('#ro_matricula').change(function(){
                $('#matricula').val($('#ro_matricula').val());
            });
            $('#btn_imprimir').click(function(){
                if($('.tipo_relatorio').is(':checked')){
                    $('#formulario').submit();
                }
                else{
                    $('#msg_erro').css('visibility','visible');
                    setTimeout(function(){ $('#msg_erro').fadeIn(1500); }, 0);
                    setTimeout(function(){ $('#msg_erro').fadeOut(2000); }, 3000);
                }
            });
        });
    </script>
@endsection