@extends('layouts.tema01')

@section('content')

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
        <div class="row justify-content-center">
            <div class="span12">
                <form method="POST" action="{{ route('avisoSave') }}">
                </form>
                <form method="POST" action="{{ route('avisoSave') }}">
                    @csrf
                    <div class="row">
                        <div class="span4 form-label">
                            <label for="title" class="col-md-4 col-form-label text-md-right">{{ __('Título') }}</label>
                        </div>
                        <div class="span6">
                            <input id="title" type="text" class="form-input{{ $errors->has('title') ? ' is-invalid' : '' }}" name="title" value="{{ old('title') }}" autofocus>
                            
                            @if ($errors->has('title'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('title') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>   

                    <div class="form-group row">
                        <div class="span4 form-label">
                        <label for="text" class="col-md-4 col-form-label text-md-right">{{ __('Texto') }}</label>
                        </div>

                        <div class="span6">
                            <input id="text" type="text" class="form-input{{ $errors->has('text') ? ' is-invalid' : '' }}" name="text" value="{{ old('text') }}" >
                            
                            @if ($errors->has('text'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('text') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>    

                    <div class="form-group row">
                        <div class="span4 form-label">
                            <label for="image" class="col-md-4 col-form-label text-md-right">{{ __('Imagem') }}</label>
                        </div>
                        
                        <div class="span6">
                            <input id="image" type="text" class="form-control{{ $errors->has('image') ? ' is-invalid' : '' }}" name="image" value="{{ old('image') }}" >
                            
                            @if ($errors->has('image'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('image') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>   

                    <div class="form-group row">
                        <div class="span4 form-label">
                            <label for="url" class="col-md-4 col-form-label text-md-right">{{ __('URL do Link') }}</label>
                        </div>
                        
                        <div class="span6">
                            <input id="url" type="text" class="form-control{{ $errors->has('url') ? ' is-invalid' : '' }}" name="url" value="{{ old('url') }}" >
                            
                            @if ($errors->has('url'))
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('url') }}</strong>
                            </span>
                            @endif
                        </div>
                    </div>                            

                    <div class="form-group row">
                        <div class="span4 form-label">
                            <label for="status" class="col-md-4 col-form-label text-md-right">{{ __('Status') }}</label>
                        </div>
                        
                        <div class="span6">
                            <input id="status" type="radio"  name="status" value="1" >&nbsp;Ativo<br>
                            <input id="status" type="radio"  name="status" value="0" >&nbsp;Inativo<br>
                            
                        </div>
                    </div>    

                    <div class="form-group row mb-0">
                        <div class="span12 aligncenter">
                            <button type="submit" class="btn btn-theme e_wiggle">
                                {{ __('Gravar') }}
                            </button>
                        </div>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>
</section>
@endsection
