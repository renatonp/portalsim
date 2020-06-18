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
                <p><strong>Atenção!</strong> Não foi possível verificar as suas informações no "Cadastro Geral do
                    Município" (CGM).</p>
                <p>Tente Novamente em alguns instantes.</p>
                <p><b>Código:</b> INT_1001</p>
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