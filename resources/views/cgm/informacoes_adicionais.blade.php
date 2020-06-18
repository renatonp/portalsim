<div class="accordion-inner">

    <form method="POST" action="{{ route('cgm_informacoes_adicionais') }}" id="infoAdicionais">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="identidade" class="col-md-4 col-form-label text-md-right">
                    {{ __('Identidade') }}
                </label>
            </div>

            <div class="span2">
                <input maxlength="20" id="identidade" type="text"
                    class="form-input{{ $errors->has('identidade') ? ' is-invalid' : '' }}" name="identidade"
                    value="{{ $cgm->aCgmAdicionais->z01_ident  }}" readonly>

                @if ($errors->has('identidade'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('identidade') }}</strong>
                </span>
                @endif
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span3 form-label">
                <label for="orgEmi" class="col-md-4 col-form-label text-md-right">
                    {{ __('Órgão Emissor') }}
                </label>
            </div>

            <div class="span2">
                <input maxlength="50" id="orgEmi" type="text" class="form-input{{ $errors->has('orgEmi') ? ' is-invalid' : '' }}"
                    name="orgEmi"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmAdicionais->z01_identorgao ))) }}"
                    readonly>

                @if ($errors->has('orgEmi'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('orgEmi') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="dtEmiss" class="col-md-4 col-form-label text-md-right">
                    {{ __('Data Emissão') }}
                </label>
            </div>

            <div class="span2">
                <input id="dtEmiss" type="text" class="form-input{{ $errors->has('dtEmiss') ? ' is-invalid' : '' }}"
                    name="dtEmiss"
                    value="{{ \Carbon\Carbon::parse($cgm->aCgmAdicionais->z01_identdtexp)->format('d/m/Y')  }}"
                    readonly>

                @if ($errors->has('dtEmiss'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('dtEmiss') }}</strong>
                </span>
                @endif
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span3 form-label">
                <label for="pis" class="col-md-4 col-form-label text-md-right">
                    {{ __('PIS/PASEP') }}
                </label>
            </div>

            <div class="span2">
                <input maxlength="11" id="pis" type="text" class="form-input{{ $errors->has('pis') ? ' is-invalid' : '' }}" name="pis"
                    value="{{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmAdicionais->z01_pis))) }}"
                    readonly>

                @if ($errors->has('pis'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('pis') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="profissoes" class="col-md-4 col-form-label text-md-right">
                    {{ __('Profissão') }}
                </label>
            </div>

            <div class="span8">
                <input maxlength="40" id="profissoes" type="text"
                    class="form-input{{ $errors->has('profissoes') ? ' is-invalid' : '' }}" name="profissoes"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmAdicionais->z01_profis))) }}"
                    readonly>

                @if ($errors->has('profissoes'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('profissoes') }}</strong>
                </span>
                @endif
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="local_trabalho" class="col-md-4 col-form-label text-md-right">
                    {{ __('Local de Trabalho') }}
                </label>
            </div>

            <div class="span8">
                <input maxlength="100" id="local_trabalho" type="text"
                    class="form-input{{ $errors->has('local_trabalho') ? ' is-invalid' : '' }}" name="local_trabalho"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm->aCgmAdicionais->z01_localtrabalho)))  }}"
                    readonly>

                @if ($errors->has('local_trabalho'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('local_trabalho') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="renda" class="col-md-4 col-form-label text-md-right">
                    {{ __('Renda') }}
                </label>
            </div>

            <div class="span3">
                <input maxlength="15" id="renda" type="text" class="form-input{{ $errors->has('renda') ? ' is-invalid' : '' }}"
                    name="renda" value="{{ number_format($cgm->aCgmAdicionais->z01_renda, 2) }}" readonly>

                @if ($errors->has('renda'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('renda') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="span3 align-left">
                <button type="button" value='1' class="btn btn-theme e_wiggle align-right" id="btn_altera_info_ad">
                    {{ __('Alterar Dados') }}
                </button>
            </div>
            <div class="span8 align-left">
                <button type="button" class="btn btn-warning e_wiggle align-right" id="btn_gravar_info_ad" disabled>
                    {{ __('Gravar Dados') }}
                </button>
            </div>
        </div>
    </form>
</div>