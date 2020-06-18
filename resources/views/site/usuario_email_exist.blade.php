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
            <div class="alert alert-error">
                <p><strong>Atenção!</strong> O <b>E-MAIL</b> registrado no "Cadastro Geral do Município" (CGM) já está sendo utilizado.</p>
                <p>Para acessar o portal de Serviços do município é necessário que você faça a atualização do seu cadastro em uma agência do SIM.</p>
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
        jQuery(document).ready(function(){
            
        });
    </script>
@endsection
