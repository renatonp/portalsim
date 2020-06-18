@extends('layouts.tema01')
@section('content')
<section id="inner-headline">
    <div class="container">
		<div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>Consulta Geral Financeira</h2>
                </div>
            </div>
        </div>
    </div>
</section>
<br>
<section id="content">
    <form method="post" id="formulario">
        @csrf
        <div class="container">
            <div class="row">
                <div class="col-md-3 form-label"><strong>CPF</strong></div>
                <div class="col-md-2"><input type="text" class="form-input" name="cpf"></div>
            </div>
            <div class="row">
                <div class="col-md-3 form-label"><strong>Nome</strong></div>
                <div class="col-md-7"><input type="text" class="form-input" name="nome"></div>
            </div>
            <div class="row">
                <div class="col-md-3 form-label"><strong>Matrícula</strong></div>
                <div class="col-md-2"><input type="text" class="form-input" name="matricula"></div>
                <div class="col-md-2"><input type="button" id="btn_pesquisar" class="btn btn-primary" value="Pesquisar"></div>
            </div>
            <div class="row">
                <div class="col-md-3 form-label"><strong>Inscrição</strong></div>
                <div class="col-md-2"><input type="text" class="form-input" name="inscricao"></div>
            </div>
            <br />
            <div class="row">
                <div class="col-md-12" align="center"><input type="button" id="btn_selecionar" class="btn btn-primary" value="Selecionar"></div>
            </div>
        </div>
    </form>
</section>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function(){
            $('#btn_pesquisar').click(function(){
                $('#formulario').attr("action","{{ route('integracaoPesquisaTipoDebitos') }}");
                $('#formulario').submit();
            });
            $('#btn_selecionar').click(function(){
                $('#formulario').attr("action","{{ route('integracaoPesquisaDebitos') }}");
                $('#formulario').submit();
            });
        });
    </script>
@endsection
