@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span4">
                <div class="inner-heading">
                    <h2>{{ __('NOTÍCIAS') }}</h2>
                </div>
            </div>
            <div class="span8">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Notícias') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row ">
            <div class="span12">
                <table id="avisos" class="display stripe hover" style="width:100%">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Título</th>
                            <th>Texto</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(!empty($noticias))
                            @foreach ($noticias as $noticia)
                                <tr>
                                    <td> {{ $noticia['id'] }}</td>
                                    <td> {{ $noticia['title'] }}</td>
                                    <td> {{ $noticia['text']}}</td>
                                    <td> {{ $noticia['status'] }}</td>
                                </tr>
                            @endforeach
                        @endif                           
                    </tbody>
                </table>
                <div class="col-md-12">
                    <a href="{{ route('avisoNovo') }}">
                        <button type="button" class="btn btn-theme e_wiggle">
                            {{ __('Nova Notícia') }}
                        </button>
                    </a>
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
