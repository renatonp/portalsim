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
    <div class="container">
		<div class="row">
        	<div class="col-md-3 form-label"><strong>CPF</strong></div>
            <div class="col-md-2"><input type="text" name="cpf" maxlength="20" class="form-input"></div>
            <div class="col-md-3 form-label"><strong>Matrícula</strong></div>
            <div class="col-md-2"><input type="text" name="matricula" class="form-input"></div>
		</div>
        <div class="row">
        	<div class="col-md-3 form-label"><strong>Nome</strong></div>
            <div class="col-md-7"><input type="text" name="nome" class="form-input"></div>
        </div>
        <!--
        <div class="row">
            <div class="col-md-12 alert alert-success" align="center" width="100%">RELATÓRIO DE PAGAMENTOS</div>
        </div>
        -->
        <div class="row">
            <div class="col-md-11"><h4 class="heading">RELATÓRIO DE PAGAMENTOS</h4></div>
        </div>

        <div class="row">
            <div class="col-md-12" align="center">
                    <input type="radio" name="analitico">&nbsp;&nbsp;<strong>Analítico</strong>
                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                    <input type="radio" name="sintetico">&nbsp;&nbsp;<strong>Sintético (Resumido)</strong>
            </div>
        </div>
        <br>
        <div class="row">
            <div class="col-md-12" align="center">
                <input type="button" class="btn btn-primary" value="Imprimir">
                <!--&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                <input type="button"  class="btn btn-secondary" value="Voltar">-->
            </div>
	    </div>
    </div>
</section>
@endsection
