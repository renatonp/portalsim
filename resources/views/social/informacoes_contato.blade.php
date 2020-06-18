<div class="accordion-inner">

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="email" class="col-md-4 col-form-label text-md-right">
                {{ __('E-Mail') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <input maxlength="100" id="email" type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                name="email"
                value="{{ old('email') }}"
                ><br>

            @if ($errors->has('email'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email') }}</strong>
            </span>
            @endif
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="email-confirm" class="col-md-4 col-form-label text-md-right">
                {{ __('Confirmação do E-Mail') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span8">
            <input maxlength="100" id="email-confirm" type="email" class="form-input{{ $errors->has('email-confirm') ? ' is-invalid' : '' }}" name="email-confirm" value="{{ old('email-confirm') }}"><br>

            @if ($errors->has('email-confirm'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('email-confirm') }}</strong>
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
            <input id="telefone" type="text" class="form-input{{ $errors->has('telefone') ? ' is-invalid' : '' }}" name="telefone" value="{{ old('telefone') }}" >

            @if ($errors->has('telefone'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('telefone') }}</strong>
            </span>
            @endif
        </div>
    </div>


    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="celular" class="col-md-4 col-form-label text-md-right">
                {{ __('Celular') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span3">
            <input id="celular" type="text" class="form-input{{ $errors->has('celular') ? ' is-invalid' : '' }}" name="celular" value="{{ old('celular') }}">

            @if ($errors->has('celular'))
            <span class="invalid-feedback" role="alert">
                <strong>{{ $errors->first('celular') }}</strong>
            </span>
            @endif
        </div>
    </div>
</div>
