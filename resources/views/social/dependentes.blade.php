<div class="accordion-inner">

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="depNome" class="col-md-4 col-form-label text-md-right">
            </label>
        </div>
        <div class="span8 alert alert-error">
            <button type="button" class="close" data-dismiss="alert">×</button>
            <strong>ATENÇÃO!</strong> Os dependentes devem ser moradores do mesmo núcleo familiar.
        </div>
    </div>
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="depNome" class="col-md-4 col-form-label text-md-right">
                {{ __('Nome do Dependente') }}
            </label>
        </div>

        <div class="span8">
            <input id="dependentesLista" type="hidden" name="dependentesLista" value="{{ old('dependentesLista') }}">
            <input maxlength="100" id="depNome" type="text" class="form-input{{ $errors->has('depNome') ? ' is-invalid' : '' }}" name="depNome" value=""><br>

            @if ($errors->has('depNome'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('depNome') }}</strong>
            </span>
            @endif
        </div>
    </div>


    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="depDtNasc" class="col-md-4 col-form-label text-md-right">
                {{ __('Data de Nascimento') }}
            </label>
        </div>

        <div class="span3">
            <input id="depDtNasc" type="text" class="form-input{{ $errors->has('depDtNasc') ? ' is-invalid' : '' }}" name="depDtNasc" value="">

            @if ($errors->has('depDtNasc'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('depDtNasc') }}</strong>
            </span>
            @endif
        </div>
    </div>    

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="depCpf" class="col-md-4 col-form-label text-md-right">
                {{ __('CPF do Dependente') }}
            </label>
        </div>

        <div class="span5">
            <input id="depCpf" type="text" class="form-input{{ $errors->has('depCpf') ? ' is-invalid' : '' }}" name="depCpf" value="" >

            @if ($errors->has('depCpf'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('depCpf') }}</strong>
            </span>
            @endif

            <div>
                Obs.: O CPF é obrigatório para os dependentes maiores de 16 anos.
            </div>
        </div>
    </div>


    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="parentesco" class="col-md-4 col-form-label text-md-right">
                {{ __('Grau de Parentesco') }}
            </label>
        </div>

        <div class="span3">
            <select id="parentesco" class="form-input" name="parentesco">
                <option value="" ></option>
                <option value="Amigo(a)" {{ old('sex')=="Amigo(a)" ? "selected" : "" }}>Amigo(a)</option>
                <option value="Avô(ó)" {{ old('sex')=="Avô(ó)" ? "selected" : "" }}>Avô(ó)</option>
                <option value="Cunhado(a)" {{ old('sex')=="Cunhado(a)" ? "selected" : "" }}>Cunhado(a)</option>
                <option value="Companheiro(a)" {{ old('sex')=="Companheiro(a)" ? "selected" : "" }}>Companheiro(a)</option>
                <option value="Cônjuge" {{ old('sex')=="Cônjuge" ? "selected" : "" }}>Cônjuge</option>
                <option value="Enteado(a)" {{ old('sex')=="Enteado(a)" ? "selected" : "" }}>Enteado(a)</option>
                <option value="Filho(a)" {{ old('sex')=="Filho(a)" ? "selected" : "" }}>Filho(a)</option>
                <option value="Genro/Nora" {{ old('sex')=="Genro/Nora" ? "selected" : "" }}>Genro/Nora</option>
                <option value="Irmão(ã)" {{ old('sex')=="Irmão(ã)" ? "selected" : "" }}>Irmão(ã)</option>
                <option value="Neto(a)" {{ old('sex')=="Neto(a)" ? "selected" : "" }}>Neto(a)</option>
                <option value="Pai/Mãe" {{ old('sex')=="Pai/Mãe" ? "selected" : "" }}>Pai/Mãe</option>
                <option value="Parceiro(a)" {{ old('sex')=="Parceiro(a)" ? "selected" : "" }}>Parceiro(a)</option>
                <option value="Primo(a)" {{ old('sex')=="Primo(a)" ? "selected" : "" }}>Primo(a)</option>
                <option value="Sogro(a)" {{ old('sex')=="Dogro(a)" ? "selected" : "" }}>Sogro(a)</option>
                <option value="Tio(a)" {{ old('sex')=="Tio(a)" ? "selected" : "" }}>Tio(a)</option>
                <option value="Outro" {{ old('sex')=="Outro" ? "selected" : "" }}>Outro</option>
            </select>

            @if ($errors->has('parentesco'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('parentesco') }}</strong>
            </span>
            @endif
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
                &nbsp;
        </div>
        <div class="span2">
            <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="incluirDependente">
                {{ __('Incluir Dependente') }}
            </button>
        </div>
    </div>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Dependentes Incluídos<span></span></h4>

            <table id="dependentes" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th align="left" width="15%">CPF</th>
                        <th align="left" width="10%">Data de Nascimento</th>
                        <th align="left" width="15%">Parentesco</th>
                        <th align="left" width="50%">Nome</th>
                        <th width='10%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>


</div>
