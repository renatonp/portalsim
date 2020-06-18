@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>{{ __('Login') }}</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Login') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="aligncenter">
            <div class="alert alert-error" align="left">
                <!--
                <p><strong>Atenção!</strong> As informações do seu registro no "Cadastro Geral do Município" estão desatualizadas.</p>
                <p>Para acessar o portal de Serviços do município é necessário que você faça a atualização dos seus dados 
                    @if($servidor == "NAO")
                        no link: www.marica.rj.gov.br/atualizar-cgm/
                    @else
                        diretamente no RH da Prefeitura Municipal de Maricá.
                    @endif 
                </p>
                <p><b>Código:</b> INT_1003</p>
                -->
                <p>Para acessar o Portal de Serviços do município é necessário que você faça a atualização dos seus dados 
                    @if($servidor == "NAO")
                        no link: <a href="www.marica.rj.gov.br/atualizar-cgm/" target="blank"> </a>www.marica.rj.gov.br/atualizar-cgm/
                    @else
                        diretamente no RH da Prefeitura Municipal de Maricá.
                    @endif 
                </p>
                <p>
                    Os seguintes documentos devem ser apresentados:
                </p>
                <p>
                    Para cadastro de pessoa física: </br>
                        - Identidade; </br> 
                        - CPF; </br>
                        - Comprovante de Residência;
                </p>
                <p>
                    Para cadastro de pessoa jurídica: </br>
                        - Identidade; </br>
                        - Comprovante de residência dos sócios; </br>
                        - Contrato Social;
                </p>
            </div>
        </div>
    </div>
    <br>
    <br>
    <br>
</section>


@endsection


@section('post-script')
<script type="text/javascript">
    jQuery(document).ready(function() {

});
</script>
@endsection