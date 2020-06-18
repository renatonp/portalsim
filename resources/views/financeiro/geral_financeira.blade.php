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
            <div class="col-md-7"><input type="text" class="form-input" name="cpf"></div>
		</div>
        <div class="row">
        	<div class="col-md-3 form-label"><strong>Nome</strong></div>
            <div class="col-md-7"><input type="text" class="form-input" name="nome"></div>
        </div>
        <div class="row">
        	<div class="col-md-3 form-label"><strong>Opções de Consulta</strong></div>
            <div class="col-md-7">
                    <input type ="radio" name="consulta" value="1" checked="checked">&nbsp;&nbsp;Débitos em aberto<br />
                    <input type ="radio" name="consulta" value="2">&nbsp;&nbsp;Pagamentos Efetuados<br />
                    <input type ="radio" name="consulta" value="3">&nbsp;&nbsp;Relatórios de Débitos
            </div>
        </div>
        <br />
        <div class="row">
            <div class="col-md-12" align="center"><input type="button" class="btn btn-primary" value="Selecionar"></div>
        </div>
	</div>
</section>
@endsection
