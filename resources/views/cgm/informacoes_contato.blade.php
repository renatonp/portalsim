<div class="accordion-inner">

    <form method="POST" action="{{ route('cgm_informacoes_contato') }}" id="infoContato">
        @csrf
        {{-- CPF/CNPJ --}}
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="cpf" class="col-md-4 col-form-label text-md-right">
                    @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                    {{ __('CNPJ') }}
                    @else
                    {{ __('CPF') }}
                    @endif
                </label>
            </div>

            <div class="span2">
                <input id="cpf2" type="text" class="form-input{{ $errors->has('cpf2') ? ' is-invalid' : '' }}"
                    name="cpf2" value="{{ $cgm->aCgmPessoais->z01_cgccpf }}" readonly>

                @if ($errors->has('cpf2'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('cpf2') }}</strong>
                </span>
                @endif
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            {{-- Última Atualização --}}
            <div class="controls span3 form-label">
                <label for="ultalt" class="col-md-4 col-form-label text-md-right">
                    {{ __('Última Atualização') }}
                </label>
            </div>

            <div class="span2">
                <input id="ultaltctt" type="text" class="form-input{{ $errors->has('ultalt') ? ' is-invalid' : '' }}"
                    name="ultalt" value="{{ \Carbon\Carbon::parse($cgm->aCgmPessoais->z01_ultalt)->format('d/m/Y')  }}"
                    readonly>

                @if ($errors->has('ultalt'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('ultalt') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="name" class="col-md-4 col-form-label text-md-right">
                    @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                    {{-- Dados Pessoa Jurídica --}}
                    {{ __('Razão Social') }}
                    @else
                    {{-- Dados Pessoa Física --}}
                    {{ __('Nome') }}
                    @endif
                </label>
            </div>

            <div class="span8">
                <input maxlength="40" id="namectt" type="text" class="form-input{{ $errors->has('name') ? ' is-invalid' : '' }}"
                    name="name"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmPessoais->z01_nome)))  }}"
                    readonly>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="email" class="col-md-4 col-form-label text-md-right">
                    {{ __('E-Mail') }}
                </label>
            </div>

            <div class="span8">
                <input type="hidden" id="solicitacaoEmail" 
                @isset($email)
                @if($email != "")
                    value = "1"
                @endif
                @endisset
                >
                <input id="emailOld" type="hidden" name="emailOld"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmContato->z01_email))) }}">
                <input maxlength="100" id="email" type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                    name="email"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmContato->z01_email))) }}"
                    readonly><br>

                @if ($errors->has('email'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('email') }}</strong>
                </span>
                @endif
                                    
                @isset($email)
                @if($email != "")
                
                <div class="alert alert-info" role="alert">
                    <strong>Solicitação de alteração de e-mail pendente:</strong><br>
                    <strong>Novo e-mail:</strong> {{ $email->email_novo }}<br>
                    <strong>Data da Solicitação:</strong>
                    {{ \Carbon\Carbon::parse($email->data_solicitacao)->format('d/m/Y H:i:s') }}<br>
                    <br>
                    Para fazer uma nova solicitação de alteração de e-Mail confirme a solicitação enviada por e-mail ou cancele utilizando este botão:<br><br>

                    <a type="button" value='1' class="btn btn-red e_wiggle align-right" href="{{ route('cancelaEnvioEmail') }}">
                        {{ __('Cancelar Solicitação') }}
                    </a> 
                    <br>
                    <br>
                </div>
                @endif
                @endisset

                @if($cgm->aCgmContato->z01_email != "")
                <div class="alert" role="alert">
                    <strong>Importante:</strong>
                    Para alterar o seu e-mail é necessário possuir acesso ao e-mail atualmente cadastrado.<br>
                    Será enviado uma mensagem para o endereço eletrônico atual solicitando a confirmação do e-mail. Desta maneira, a alteração será efetivada.
                </div>
                @else
                <div class="alert" role="alert">
                    <strong>Atenção:</strong>
                    Você não possui nenhum e-mail cadastrado, desta forma não é possível validar um novo e-mail<br>
                    Dirija-se a uma unidade do SIM mais próxima para realizar a alteração.
                </div>
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="phone" class="col-md-4 col-form-label text-md-right">
                    {{ __('Telefone') }}
                </label>
            </div>

            <div class="span3">
                <input id="phone" type="text" class="form-input{{ $errors->has('phone') ? ' is-invalid' : '' }}"
                    name="phone" value="{{ str_pad( $cgm->aCgmContato->z01_telef , 10 , '0' ,STR_PAD_LEFT) }}" readonly>


                @if ($errors->has('phone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('phone') }}</strong>
                </span>
                @endif
            </div>
        </div>


        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="celphone" class="col-md-4 col-form-label text-md-right">
                    {{ __('Celular') }}
                </label>
            </div>

            <div class="span3">
                <input id="celphone" type="text" class="form-input{{ $errors->has('celphone') ? ' is-invalid' : '' }}"
                    name="celphone" value="{{ $cgm->aCgmContato->z01_telcel }}" readonly>

                @if ($errors->has('celphone'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('celphone') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="span3 align-left">
                <button type="button" value='1' class="btn btn-theme e_wiggle align-right" id="btn_altera_info_ct">
                    {{ __('Alterar Dados') }}
                </button>
            </div>
            <div class="span8 align-left">
                <button type="button" class="btn btn-warning e_wiggle align-right" id="btn_gravar_info_ct" disabled>
                    {{ __('Gravar Dados') }}
                </button>
            </div>
        </div>
    </form>
</div>
