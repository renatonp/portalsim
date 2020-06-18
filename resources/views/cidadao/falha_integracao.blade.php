@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span7">
                <div class="inner-heading">
                    <h2>{{ $titulo }}</h2>
                </div>
            </div>
            <div class="span5">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ $titulo }}</li>
                </ul>
            </div>
        </div>
    </div>

</section>

<section id="content">
    <div class="container">
        <div class="aligncenter">
            <div class="alert alert-error">
                {!! $mensagem !!}
            </div>
        </div>
        <br>
        <br>
        <div class="row">
            <div class="span12 aligncenter">
                <a href="{{ isset($rota)?$rota : URL::previous() }}">
                    <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                        {{ __('Voltar') }}
                    </button>
                    <a>
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