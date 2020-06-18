<div class="accordion-inner">
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="cep" class="col-md-4 col-form-label text-md-right">
                {{ __('CEP') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="cep" type="text" class="form-input{{ $errors->has('cep') ? ' is-invalid' : '' }}" name="cep" value="{{ old('cep') }}">

            @if ($errors->has('cep'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cep') }}</strong>
            </span>
            @endif              
        </div>
        <div class="span2 align-left">
            {{-- <button type="button" class="btn e_wiggle align-right" id="btn_consultar">
                {{ __('Buscar Cep') }}
            </button> --}}
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="uf" class="col-md-4 col-form-label text-md-right">
                {{ __('Estado') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <select id="uf" class="form-input{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" disabled>
                <option value="AC">Acre</option>
                <option value="AC">Alagoas</option>
                <option value="AP">Amapá</option>
                <option value="AM">Amazonas</option>
                <option value="BA">Bahia</option>
                <option value="CE">Ceará</option>
                <option value="DF">Distrito Federal</option>
                <option value="ES">Espírito Santo</option>
                <option value="GO">Goiás</option>
                <option value="MA">Maranhão</option>
                <option value="MT">Mato Grosso</option>
                <option value="MS">Mato Grosso do Sul</option>
                <option value="MG">Minas Gerais</option>
                <option value="PA">Pará</option>
                <option value="PB">Paraíba</option>
                <option value="PR">Paraná</option>
                <option value="PE">Pernambuco</option>
                <option value="PI">Piauí</option>
                <option value="RJ" selected>Rio de Janeiro</option>
                <option value="RN">Rio Grande do Norte</option>
                <option value="RS">Rio Grande do Su</option>
                <option value="RO">Rondônia</option>
                <option value="RR">Roraima</option>
                <option value="SC">Santa Catarina</option>
                <option value="SP">São Paulo</option>
                <option value="SE">Sergipe</option>
                <option value="TO">Tocantins</option>
            </select>
                                    
            @if ($errors->has('uf'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('uf') }}</strong>
            </span>
            @endif  
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="cidade" class="col-md-4 col-form-label text-md-right">
                {{ __('Município') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <input readonly maxlength="30" id="cidade" type="text" class="form-input{{ $errors->has('cidade') ? ' is-invalid' : '' }}" name="cidade" value="MARICÁ">
                        
            @if ($errors->has('cidade'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cidade') }}</strong>
            </span>
            @endif            
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="bairro" class="col-md-4 col-form-label text-md-right">
                {{ __('Bairro') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            {{-- <input readonly maxlength="30" id="bairro" type="text" class="form-input{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro" value="{{ old('bairro') }}"> --}}
            
            <select id="bairro" class="form-input{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro">
                <option value=""></option>
                <option value="ARAÇATIBA">ARAÇATIBA</option>
                <option value="BALNEÁRIO BAMBUÍ">BALNEÁRIO BAMBUÍ</option>
                <option value="BANANAL">BANANAL</option>
                <option value="BARRA DE MARICÁ">BARRA DE MARICÁ</option>
                <option value="BARROCO">BARROCO</option>
                <option value="CAJU">CAJU</option>
                <option value="CAJUEIROS">CAJUEIROS</option>
                <option value="CALABOCA">CALABOCA</option>
                <option value="CAMBURI">CAMBURI</option>
                <option value="CASSOROTIBA">CASSOROTIBA</option>
                <option value="CAXITO">CAXITO</option>
                <option value="CENTRO">CENTRO</option>
                <option value="CHÁCARAS DE INOÃ">CHÁCARAS DE INOÃ</option>
                <option value="CONDADO DE MARICÁ">CONDADO DE MARICÁ</option>
                <option value="CORDEIRINHO">CORDEIRINHO</option>
                <option value="ESPRAIADO">ESPRAIADO</option>
                <option value="FLAMENGO">FLAMENGO</option>
                <option value="GUARATIBA">GUARATIBA</option>
                <option value="INOÃ">INOÃ</option>
                <option value="ITAOCAIA VALLEY">ITAOCAIA VALLEY</option>
                <option value="ITAPEBA">ITAPEBA</option>
                <option value="JACAROÁ">JACAROÁ</option>
                <option value="JACONÉ">JACONÉ</option>
                <option value="JARDIM INTERLAGOS">JARDIM INTERLAGOS</option>
                <option value="JD ATLÂNTICO CENTRAL">JD ATLÂNTICO CENTRAL</option>
                <option value="JD ATLÂNTICO LESTE">JD ATLÂNTICO LESTE</option>
                <option value="JD ATLÂNTICO OESTE">JD ATLÂNTICO OESTE</option>
                <option value="LAGARTO">LAGARTO</option>
                <option value="MANOEL RIBEIRO">MANOEL RIBEIRO</option>
                <option value="MARQUÊS DE MARICÁ">MARQUÊS DE MARICÁ</option>
                <option value="MORADA DAS ÁGUIAS">MORADA DAS ÁGUIAS</option>
                <option value="MUMBUCA">MUMBUCA</option>
                <option value="PARQUE NANCI">PARQUE NANCI</option>
                <option value="PILAR">PILAR</option>
                <option value="PINDOBAL">PINDOBAL</option>
                <option value="PINDOBAS">PINDOBAS</option>
                <option value="PONTA GROSSA">PONTA GROSSA</option>
                <option value="PONTA NEGRA">PONTA NEGRA</option>
                <option value="PRAIA DE ITAIPUAÇU">PRAIA DE ITAIPUAÇU</option>
                <option value="RECANTO DE ITAIPUAÇU">RECANTO DE ITAIPUAÇU</option>
                <option value="RESTINGA DE MARICÁ">RESTINGA DE MARICÁ</option>
                <option value="RETIRO">RETIRO</option>
                <option value="RINCÃO MIMOSO">RINCÃO MIMOSO</option>
                <option value="SANTA PAULA">SANTA PAULA</option>
                <option value="SÃO JOSÉ DO IMBASSAÍ">SÃO JOSÉ DO IMBASSAÍ</option>
                <option value="SILVADO">SILVADO</option>
                <option value="SPAR">SPAR</option>
                <option value="UBATIBA">UBATIBA</option>
                <option value="VALE DA FIGUEIRA">VALE DA FIGUEIRA</option>
                <option value="ZACARIAS">ZACARIAS</option>
            </select>       
            
            @if ($errors->has('bairro'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('bairro') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="logradouro" class="col-md-4 col-form-label text-md-right">
                {{ __('Logradouro') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <input maxlength="100" id="logradouro" type="text" class="form-input{{ $errors->has('logradouro') ? ' is-invalid' : '' }}" name="logradouro" value="{{ old('logradouro') }}">
            
            @if ($errors->has('logradouro'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('logradouro') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="numero" class="col-md-4 col-form-label text-md-right">
                {{ __('Número') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="4" id="numero" type="text" class="form-input{{ $errors->has('numero') ? ' is-invalid' : '' }}" name="numero" value="{{ old('numero') }}" >

            @if ($errors->has('numero'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('numero') }}</strong>
            </span>
            @endif
        </div>

        <div class="controls span2 form-label">
            <label for="complemento" class="col-md-4 col-form-label text-md-right">
                {{ __('Complemento') }}<br> (Informar Quadra e Lote)
            </label>
        </div>

        <div class="span4">
            <input maxlength="30" id="complemento" type="text" class="form-input{{ $errors->has('complemento') ? ' is-invalid' : '' }}" name="complemento" value="{{ old('complemento') }}">

            @if ($errors->has('complemento'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('complemento') }}</strong>
            </span>
            @endif
        </div>
    </div>
    </form>
</div>