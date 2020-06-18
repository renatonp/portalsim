
@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>{{ __('MEUS DADOS') }}</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Meus Dados') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row aligncenter">

            <div class="col-md-3">
                &nbsp;
            </div>
            <div class="col-md-6">
                <div class="alert alert-success">
                    <strong>Sucesso!</strong> As suas informações foram gravadas com sucesso.
                </div>
            </div>
        </div>
    </div>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
    <br/>
</section>
@endsection
    
@section('post-script')
    <script type="text/javascript">
        jQuery(document).ready(function(){

            $("#cpf").mask("999.999.999-99");
            $("#cep").mask("99.999-999");
            $("#celphone").mask("(99)9999-9999?9");
            $("#phone").mask("(99)9999-9999");

            $("#btn_consultar").click(function(){
                if ($("#cep").val() == ""){
                    alert("Informe o CEP");
                    return false;
                }
                else{
                    // $("#buscaCep").modal('toggle');
                    var cep = $("#cep").val().replace(/[^0-9]/, '');
                    if(cep){
                        var url = 'register/consultaCEP/' + cep;
                        
                        $.get( url,  function(resposta){
                            var obj = jQuery.parseJSON(resposta);
                            console.log(obj);
                            if(obj.logradouro){
                                $("#address").val(obj.logradouro);
                                $("#district").val(obj.bairro);
                                $("#city").val(obj.localidade);
                                $("#uf").val(obj.uf);
                                $("#buscaCep").modal('toggle');
                            }
                        });
                    }					
                }
            });	
        });
    </script>
@endsection

    
    