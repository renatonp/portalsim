<div class="accordion-inner">
    <form method="POST" action="{{ route('cgm_endereco_correspondencia') }}" id="enederecoCorrespondencia">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="morador" class="col-md-4 col-form-label text-md-right">
                    {{ __('Mora no Município') }}
                </label>
            </div>

            <div class="span2">
                <select id="morador" class="form-input{{ $errors->has('morador') ? ' is-invalid' : '' }}" name="morador"
                    disabled>
                    <option value="0" {{ $end2->endereco->iMunicipio == "0" ? "selected" : "" }}>SIM</option>
                    <option value="1" {{ $end2->endereco->iMunicipio == "1" ? "selected" : "" }}>NÃO</option>
                </select>

                @if ($errors->has('morador'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('morador') }}</strong>
                </span>
                @endif
            </div>
            {{-- Separação --}}
            <div class="controls span1 form-label">
                <label for="" class="col-md-4 col-form-label text-md-right">
                    &nbsp;
                </label>
            </div>

            <div class="controls span1 form-label">
                <label for="cep" class="col-md-4 col-form-label text-md-right">
                    {{ __('CEP') }}
                </label>
            </div>

            <div class="span2">
                <input id="cep" type="text" class="form-input" name="cep" value="{{ $end2->endereco->iCep }}" readonly>
            </div>
            <div class="span2 align-left">
                <button type="button" class="btn e_wiggle align-right" id="buscaCep" disabled>
                    {{ __('Buscar Cep') }}
                </button>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="uf" class="col-md-4 col-form-label text-md-right">
                    {{ __('Estado') }}
                </label>
            </div>

            <div class="span8">
                <input id="ufDesc" type="hidden" name="ufDesc" value="">
                <input maxlength="2" id="ufCod" type="hidden" name="ufCod" value="">
                <select id="uf" class="form-input{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" disabled>
                    @if (count($estados->oEstados) > 0)
                    @foreach ($estados->oEstados as $estado)
                    <option value="{{ $estado->codigo }}"
                        {{ $end2->endereco->iEstado == $estado->codigo  ? "selected" : "" }}>
                        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $estado->descricao))) }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="city" class="col-md-4 col-form-label text-md-right">
                    {{ __('Município') }}
                </label>
            </div>

            <div class="span8">
                <select id="city_1" class="form-input" name="city" disabled style="display: none;">
                </select>
                <input maxlength="40" id="city_2" type="text" name="city2" class="form-input"
                    value="{{ mb_convert_case(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end2->endereco->sMunicipio))), MB_CASE_UPPER, 'UTF-8' ) }}"
                    readonly>
                <br>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="district" class="col-md-4 col-form-label text-md-right">
                    {{ __('Bairro') }}
                </label>
            </div>

            <div class="span8">
                <input maxlength="40" id="district_1" readonly type="text" class="form-input" name="district"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end2->endereco->sBairro))) }}"
                    readonly>
                <select id="district_0" name="district" class="form-input" disabled>
                    @if (count($bairros->aBairrosEncontradas) > 0)
                    @foreach ($bairros->aBairrosEncontradas as $bairro)
                    <option value="{{ $bairro->iBairro }}">
                        {{ $end2->endereco->sBairro ==  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $bairro->sDescricao)))  ? "selected" : "" }}
                        {{  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $bairro->sDescricao))) }}
                    </option>
                    @endforeach
                    @endif
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="address" class="col-md-4 col-form-label text-md-right">
                    {{ __('Logradouro') }}
                </label>
            </div>

            <div class="span8">
                <input maxlength="60" id="address_1" readonly type="text"
                    class="form-input{{ $errors->has('address') ? ' is-invalid' : '' }}" name="address"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end2->endereco->sRua))) }}" readonly>

                <select id="address_0" name="address" class="form-input" disabled>
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="number" class="col-md-4 col-form-label text-md-right">
                    {{ __('Número') }}
                </label>
            </div>

            <div class="span2">
                <input maxlength="4" id="number" type="text" class="form-input{{ $errors->has('number') ? ' is-invalid' : '' }}"
                    name="number" value="{{ $end2->endereco->sNumeroLocal }}" readonly>

                @if ($errors->has('number'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('number') }}</strong>
                </span>
                @endif
            </div>

            <div class="controls span2 form-label">
                <label for="complement" class="col-md-4 col-form-label text-md-right">
                    {{ __('Complemento') }}
                </label>
            </div>

            <div class="span4">
                <input maxlength="20" id="complement" type="text"
                    class="form-input{{ $errors->has('complement') ? ' is-invalid' : '' }}" name="complement"
                    value="{{ utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $end2->endereco->sComplemento))) }}"
                    readonly>

                @if ($errors->has('complement'))
                <span class="invalid-feedback" role="alert">
                    <strong>{{ $errors->first('complement') }}</strong>
                </span>
                @endif
            </div>
        </div>

        <div class="row">
            <div class="span3 align-left">
                <button type="button" value='1' class="btn btn-theme e_wiggle align-right"
                    id="btn_altera_end_correspondencia">
                    {{ __('Alterar Dados') }}
                </button>
            </div>
            <div class="span8 align-left">
                <button type="button" class="btn btn-warning e_wiggle align-right" id="btn_gravar_end_correspondencia"
                    disabled>
                    {{ __('Gravar Dados') }}
                </button>
            </div>
        </div>
    </form>
</div>