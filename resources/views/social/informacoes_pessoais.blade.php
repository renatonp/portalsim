<div class="accordion-inner">
    {{-- CPF --}}
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="pat_cpf" class="col-md-4 col-form-label text-md-right">
            {{ __('CPF') }} <span class="required">*</span>
            </label>
        </div>
        <div class="span2">
            <input maxlength="20" id="pat_cpf" type="text" class="form-input" name="cpf" value="{{ isset($cpf) ? $cpf : '' }}" readonly>
        </div>
        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nome" class="col-md-4 col-form-label text-md-right">
                {{ __('Nome') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="nome" type="text" class="form-input{{ $errors->has('nome') ? ' is-invalid' : '' }}"  name="nome" value="{{ old('nome') }}" autofocus>
            @if ($errors->has('nome'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nome') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nomeSocial" class="col-md-4 col-form-label text-md-right">
                {{ __('Nome Social') }}
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="nomeSocial" type="text" class="form-input{{ $errors->has('nomeSocial') ? ' is-invalid' : '' }}"  name="nomeSocial" value="{{ old('nomeSocial') }}" >
            @if ($errors->has('nomeSocial'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('nomeSocial') }}</strong>
            </span>
            @endif
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="dtnasc" class="col-md-4 col-form-label text-md-right">
                {{ __('Data de Nascimento') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="dtnasc" type="text" class="form-input{{ $errors->has('dtnasc') ? ' is-invalid' : '' }}" name="dtnasc" value="{{ old('dtnasc') }}" required>

            @if ($errors->has('dtnasc'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('dtnasc') }}</strong>
            </span>
            @endif
        </div>
        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span2 form-label">
            <label for="sex" class="col-md-4 col-form-label text-md-right">
                {{ __('Sexo Biológico') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <select id="sex" class="form-input" name="sex">
                <option value="" ></option>
                <option value="M" {{ old('sex')=="M" ? "selected" : "" }}>Masculino</option>
                <option value="F" {{ old('sex')=="F" ? "selected" : "" }}>Feminino</option>
            </select>
        </div>

    </div>
    
    <div class="row formrow">

        <div class="controls span3 form-label">
            <label for="eCivil" class="col-md-4 col-form-label text-md-right">
                {{ __('Estado Civil') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span3">
            <select id="eCivil" class="form-input" name="eCivil">
                <option value=""></option>
                <option value="Casado" {{ old('eCivil')=="Casado" ? "selected" : "" }}>Casado</option>
                <option value="Desquitado" {{ old('eCivil')=="Desquitado" ? "selected" : "" }}>Desquitado</option>
                <option value="Divorciado" {{ old('eCivil')=="Divorciado" ? "selected" : "" }}>Divorciado</option>
                <option value="Separado Judicialmente" {{ old('eCivil')=="Separado Judicialmente" ? "selected" : "" }}>Separado Judicialmente</option>
                <option value="Solteiro" {{ old('eCivil')=="Solteiro" ? "selected" : "" }}>Solteiro</option>
                <option value="União estável" {{ old('eCivil')=="União estável" ? "selected" : "" }}>União estável</option>
                <option value="Viúvo" {{ old('eCivil')=="Viúvo" ? "selected" : "" }}>Viúvo</option>
            </select>
        </div>

    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="doenca" class="col-md-4 col-form-label text-md-right">
                {{ __('Possui Doença?') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span3">
            <input id="doencaSim" type="radio"  name="doenca" value="1" >&nbsp;Sim &nbsp; &nbsp;
            <input id="doencaNao" type="radio"  name="doenca" value="0" >&nbsp;Não
        </div>
    </div>

    <div class="row formrow" id="rowCid">
        <div class="controls span3 form-label">
            <label for="doencaDescricao" class="col-md-4 col-form-label text-md-right">
                {{ __('Descrição da Doença (CID-10)') }}<span class="required" id="exigeCid">*</span>
            </label>
        </div>
        <div class="span8">
            <select id="doencaDescricao" class="form-input" name="doencaDescricao">
                <option value="" ></option>
                @foreach ($cid10 as $cid)
                    <option value= "{{$cid}}">
                        {{$cid}}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
        
</div>
