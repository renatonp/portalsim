@extends('layouts.marica')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">CONSULTA</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('acompanhamento') }}">
                        @csrf
                        
                        <div class="form-group row">
                            <label for="chamado" class="col-md-4 col-form-label text-md-right">{{ __('Chamado') }}</label>
                            
                            <div class="col-md-6">
                                <input id="chamado" type="text"  class="form-control" name="chamado" value="" autofocus>
                            </div>
                        </div>  
                        
                        <div class="form-group row">
                            <label for="setor" class="col-md-4 col-form-label text-md-right">{{ __('Setor Responsável') }}</label>
                            
                            <div class="col-md-6">
                                <input id="setor" type="text"  class="form-control" name="setor" value="">
                            </div>
                        </div>  

                        <div class="form-group row">
                            <label for="Servico" class="col-md-4 col-form-label text-md-right">{{ __('Serviço') }}</label>
                            
                            <div class="col-md-6">
                                <input id="Servico" type="text"  class="form-control" name="Servico" value="">
                            </div>
                        </div>  

                        <div class="form-group row">
                            <label for="dataIni" class="col-md-4 col-form-label text-md-right">{{ __('Data Inicial') }}</label>
                            
                            <div class="col-md-6">
                                <input id="dataIni" type="date"  class="form-control" name="dataIni" value="">
                            </div>
                        </div> 

                        <div class="form-group row">
                            <label for="dataFim" class="col-md-4 col-form-label text-md-right">{{ __('Data Final') }}</label>
                            
                            <div class="col-md-6">
                                <input id="dataFim" type="date"  class="form-control" name="dataFim" value="">
                            </div>
                        </div>  

                        <div class="form-group row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn bnt-cadastro">
                                    {{ __('Pesquisar') }}
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
