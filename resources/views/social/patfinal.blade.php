@extends('layouts.tema01')

@section('content')

<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('PROGRAMA DE AMPARO AO TRABALHADOR ') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <div class="row justify-content-left">
            <div class="col-md-12">
                <div>
                    {{-- <div class="alert" style="width: 380px; text-align:center; float:right; border-radius: 7px; border: 1px solid #d7cbb6; color: #ae7410;"> --}}
                    <div class="alert alert-info" style="width: 580px; text-align:center; margin: auto; border-radius: 7px; border: 1px solid #82a5c7; color: #ae7410;">
                        {{-- <h4>
                            <b>{{$total_pat}}</b> Benefício(s) solicitado(s)
                        </h4>  --}}
                            <br>
                            <b>
                                Encerramento das inscrições:<br> 
                                07/04/2020 às 13:31:46
                            </b>
                            <br>
                            <br>
                            <h3>INSCRIÇÕES ENCERRADAS</h3>
                    </div>
                    <br>
                    <br>
                </div>
                
                <div class="row">
                    <div class="span1 align-left">
                    </div>
                    <div class="span8 align-left">
                        <a href="{{ route('PAT', 1 )  }}">
                            <button type="button" class="btn btn-theme e_wiggle" id="autenticar">
                                {{ __('Voltar') }}
                            </button>
                            <a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <br />
    <br />
    <br />
    <br />
    <br />
    <br />
</section>
@endsection

@section('post-script')

@endsection