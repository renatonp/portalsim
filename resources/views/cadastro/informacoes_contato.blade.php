<div class="accordion-inner">

    <div class="row formrow">
        <div class="controls span3 form-label">
        </div>

        <div class="span7">

            <div class="alert alert-info">
                <button type="button" class="close" data-dismiss="alert">×</button>
                O e-mail será vinculado ao CPF e todo o contato da prefeitura com o cidadão será feito por meio deste
              </div>
        </div>
    </div>
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="email" class="col-md-4 col-form-label text-md-right">
                {{ __('E-Mail') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="email" type="email" class="form-input" name="email"
            @auth
            value="{{$cgm->aCgmContato->z01_email}}"
            @endauth            
            >
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="email-confirm" class="col-md-4 col-form-label text-md-right">
                {{ __('Confirmação do E-Mail') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="email-confirm" type="email" class="form-input" name="email-confirm" 
            @auth
            value="{{$cgm->aCgmContato->z01_email}}"
            @endauth             
            ><br>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="celular" class="col-md-4 col-form-label text-md-right">
                {{ __('Celular') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span3">
            <input id="celular" type="text" class="form-input{{ $errors->has('celular') ? ' is-invalid' : '' }}" name="celular" 
            @auth
            value="{{$cgm->aCgmContato->z01_telcel}}"
            @endauth             
            >

            @if ($errors->has('celular'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('celular') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="telefone" class="col-md-4 col-form-label text-md-right">
                {{ __('Telefone de Contato') }}
            </label>
        </div>

        <div class="span3">
            <input id="telefone" type="text" class="form-input" name="telefone"
            @auth
            value="{{$cgm->aCgmContato->z01_telef}}"
            @endauth             
            >
        </div>
    </div>


</div>
