@extends('layouts.tema_principal')

@section('content')

<div class="container-fluid">

    <div class="alert alert-danger">
        <p>
            Para acessar o Portal de Serviços do município, é necessário que você 
            faça o seu cadastro em uma unidade do SIM. 
        </p>
        
        <p>
            Os seguintes documentos devem ser apresentados:
        </p>
        
        <div class="ml-4">
            <h6>Para cadastro de pessoa física:</h6>
            <ul>
                <li>Identidade;</li>
                <li>CPF;</li>
                <li>Comprovante de Residência;</li>
            </ul>

            <h6>Para cadastro de pessoa jurídica:</h6>
            <ul>
                <li>Identidade;</li>
                <li>Comprovante de residência dos sócios;</li>
                <li>Contrato Social;</li>
            </ul>
        </div>
    </div>
</div>

@endsection
