@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span6">
                <div class="inner-heading">
                <h2>{{session('servico')}}</h2>
                </div>
            </div>
            <div class="span6">
                <ul class="breadcrumb">
                    <li>
                        <a href="{{  url('/') }}">
                            <i class="fa fa-home"></i>
                        </a>
                        <i class="fa fa-angle-right"></i>
                    </li>
                    <li class="active">
                        {{session('servico')}}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</section>
<section id="content">
    <div class="container">
        <div class="row justify-content-center">
            <div class="span12">
                @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                @endif
                <iframe name="bpm-iframe" id="bpm-iframe" src="{{$url}}?token={{$token}}{{$fields}}" frameborder="0" scrolling="auto" height="100%" width="100%" style="height: 800px;"></iframe>
            </div>
        </div>
    </div>
</section>
@endsection
