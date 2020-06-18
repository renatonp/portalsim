@extends('layouts.tema_principal')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-12">
            <div class="card card-servicos">
                <div class="card-header card-header-title">Fale Conosco</div>
                <div class="card-body">
                    <form id="contactForm" action="{{ route('enviarmensagem') }}" method="POST" role="form" class="contactForm">
                        @csrf
                        <div id="errormessage"></div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">Nome</label>
                                <input maxlength="40" type="text" name="name" class="form-control form-control-sm" id="nameFC" placeholder="Seu nome" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">E-mail</label>
                                <input maxlength="100" type="email" class="form-control form-control-sm" name="email" id="emailFC" placeholder="Seu email" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">Telefone</label>
                                <input type="text" class="form-control form-control-sm" name="phone" id="phoneFC" placeholder="Telefone" />
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">Informe o Tipo de Solicitação</label>
                                <select id="solicitacao" name="solicitacao" class="form-control form-control-sm">
                                    <option value="">Selecione</option>

                                    @inject('servicos_fc', 'App\Services\ServicosService')

                                    @foreach ($servicos_fc->servicos_fc() as $servico)
                                    <option value="{{$servico->servico}}">{{$servico->servico}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">Assunto</label>
                                <select id="assunto" name="assunto" class="form-control form-control-sm">
                                    <option value="">Selecione</option>
                                    <option value="Elogio">Elogio</option>
                                    <option value="Dúvida">Dúvida</option>
                                    <option value="Reclamação">Reclamação</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <label for="nome_campo1">Mensagem</label>
                                <textarea class="form-control form-control-sm" id="mensagem" name="message" rows="6" data-rule="required" data-msg="Por favor, escreva a sua mensagem" placeholder="Por favor, escreva a sua mensagem"></textarea>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                {!! $showRecaptcha !!}
                            </div>
                        </div>
                        <br/>
                        <br/>
                        <br/>
                        <br/>
                        <div class="row">
                            <div class="col-lg-3 form-group">
                                <button id="btn_contato" class="btn btn-large btn-theme margintop10" type="button" disabled>Enviar Mensagem</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('post-script')
    <script type="text/javascript">

        $("#btn_contato").prop('disabled', true);

        jQuery(document).ready(function(){
            jQuery('.g-recaptcha').attr('data-callback', 'onReCaptchaSuccess');
            jQuery('.g-recaptcha').attr('data-expired-callback', 'onReCaptchaTimeOut');
        });
        function onReCaptchaTimeOut(){
            $("#btn_contato").prop('disabled', true);
        }
        function onReCaptchaSuccess(){
            $("#btn_contato").prop('disabled', false);
        }
    </script>
@endsection
