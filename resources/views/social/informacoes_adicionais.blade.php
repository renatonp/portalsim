<div class="accordion-inner">
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="renda" class="col-md-4 col-form-label text-md-right">
                {{ __('Renda Familiar') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="renda" type="text" class="form-input{{ $errors->has('renda') ? ' is-invalid' : '' }}"
                name="renda"
                value="{{ old('renda') }}"
                >

            @if ($errors->has('renda'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('renda') }}</strong>
            </span>
            @endif
        </div>
        <div class="span6">
            Informar o total da renda do núcleo familiar anterior o dia 18 de março de 2020 (valor da renda não é critério de classificação.)
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="irenda" class="col-md-4 col-form-label text-md-right">
                {{ __('Declara Imposto de Renda?') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span3">
            <input id="irSim" type="radio"  name="irenda" value="1" >&nbsp;Sim &nbsp; &nbsp;
            <input id="irNao" type="radio"  name="irenda" value="0" >&nbsp;Não
        </div>
    </div>


    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="profLiberal" class="col-md-4 col-form-label text-md-right">
                {{ __('Classificação Profissional') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <select id="profLiberal" class="form-input" name="profLiberal">
                <option value="Profissional Liberal" {{ old('profLiberal')=="Profissional Liberal" ? "selected" : "" }}>Profissional Liberal</option>
                <option value="Profissional Autônomo" {{ old('profLiberal')=="Profissional Autônomo" ? "selected" : "" }}>Profissional Autônomo</option>
                <option value="Trabalhador Informal" {{ old('profLiberal')=="Trabalhador Informal" ? "selected" : "" }}>Trabalhador Informal</option>
                <option value="MEI" {{ old('profLiberal')=="Trabalhador Informal" ? "selected" : "" }}>MEI</option>
            </select>
            <br>
            <span>* <b>Profissinal Liberal</b>: Obrigatório o anexo do comprovante da entidade de classe no Comprovante de Atividades de Trabalho.</span>
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="ocupacao" class="col-md-4 col-form-label text-md-right">
                {{ __('Ocupação') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <select id="ocupacao" class="form-input" name="ocupacao">
                <option value="" ></option>
                @foreach ($cbos as $cbo)
                    <option value= "{{$cbo}}">
                        {{$cbo}}
                    </option>
                @endforeach
            </select>

        </div>
    </div>

    <div class="row formrow" id="rowCNPJ">
        <div class="controls span3 form-label">
            <label for="cnpj" class="col-md-4 col-form-label text-md-right">
                {{ __('CNPJ') }}<span class="required" id="exigeMEI">*</span>
            </label>
        </div>

        <div class="span3">
            <input maxlength="15" id="cnpj" type="text" class="form-input{{ $errors->has('cnpj') ? ' is-invalid' : '' }}"
                name="cnpj" value="{{ old('cnpj') }}">

            @if ($errors->has('cnpj'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('cnpj') }}</strong>
            </span>
            @endif                    
        </div>
    </div>

    <div class="row formrow" id="rowEntidade">
        <div class="controls span3 form-label">
            <label for="entidadeClasse" class="col-md-4 col-form-label text-md-right">
                {{ __('Entidade de Classe') }}<span class="required" id="exigeEntidade">*</span>
            </label>
        </div>

        <div class="span5">
            <input maxlength="45" id="entidadeClasse" type="text" class="form-input{{ $errors->has('entidadeClasse') ? ' is-invalid' : '' }}"
                name="entidadeClasse" value="{{ old('entidadeClasse') }}">

            @if ($errors->has('entidadeClasse'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('entidadeClasse') }}</strong>
            </span>
            @endif                    
        </div>
    </div>

    <div class="row formrow" id="rowIDFuncional">
        <div class="controls span3 form-label">
            <label for="identidadeFuncional" class="col-md-4 col-form-label text-md-right">
                {{ __('Identidade Funcional') }}<span class="required" id="exigeIdentidade">*</span>
            </label>
        </div>

        <div class="span3">
            <input maxlength="25" id="identidadeFuncional" type="text" class="form-input{{ $errors->has('identidadeFuncional') ? ' is-invalid' : '' }}"
                name="identidadeFuncional" value="{{ old('identidadeFuncional') }}">

            @if ($errors->has('identidadeFuncional'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('identidadeFuncional') }}</strong>
            </span>
            @endif                    
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="agPreferencia" class="col-md-4 col-form-label text-md-right">
                Agência de preferência <span class="required">*</span><br> do banco Mumbuca&nbsp;&nbsp;&nbsp;
            </label>
        </div>

        <div class="span3">
            <select id="agPreferencia" class="form-input" name="agPreferencia">
                <option value=""></option>
                <option value="001">Centro</option>
                <option value="002">Inoã</option>
                <option value="003">Itaipuaçu</option>
                <option value="004">Cordeirinho</option>
            </select>            
        </div>
    </div>   
</div>