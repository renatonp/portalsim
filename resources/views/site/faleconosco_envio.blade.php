@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>Contato</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">Contato</li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="span12 aligncenter">

                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <div class="text-md-center">
                    Enviamos a sua mensagem com sucesso!<br><br>
                    Em breve retornaremos o contato.
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<br>
<br>
<br>
@endsection
