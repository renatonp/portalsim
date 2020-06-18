<div class="accordion-inner">
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="cep" class="col-md-4 col-form-label text-md-right">
                {{ __('CEP') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="cep" type="text" class="form-input" name="cep"
            @auth
            value="{{$endereco->endereco->iCep}}"
            @endauth              
            >

        </div>
        <div class="span2 align-left">
            <button type="button" class="btn e_wiggle align-right" id="btn_consultar">
                {{ __('Buscar Cep') }}
            </button>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="uf" class="col-md-4 col-form-label text-md-right">
                {{ __('Estado') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <select id="uf" class="form-input{{ $errors->has('uf') ? ' is-invalid' : '' }}" name="uf" disabled>
                <option value="AC"
                @auth
                {{ $endereco->endereco->sUf == "AC" ? "selected" : "" }}    
                @endauth
                >Acre</option>
                <option value="AL"
                @auth
                {{ $endereco->endereco->sUf == "AL" ? "selected" : "" }}    
                @endauth
                >Alagoas</option>
                <option value="AP"
                @auth
                {{ $endereco->endereco->sUf == "AP" ? "selected" : "" }}    
                @endauth
                >Amapá</option>
                <option value="AM"
                @auth
                {{ $endereco->endereco->sUf == "AM" ? "selected" : "" }}    
                @endauth
                >Amazonas</option>
                <option value="BA"
                @auth
                {{ $endereco->endereco->sUf == "BA" ? "selected" : "" }}    
                @endauth
                >Bahia</option>
                <option value="CE"
                @auth
                {{ $endereco->endereco->sUf == "CE" ? "selected" : "" }}    
                @endauth
                >Ceará</option>
                <option value="DF"
                @auth
                {{ $endereco->endereco->sUf == "DF" ? "selected" : "" }}    
                @endauth
                >Distrito Federal</option>
                <option value="ES"
                @auth
                {{ $endereco->endereco->sUf == "ES" ? "selected" : "" }}    
                @endauth
                >Espírito Santo</option>
                <option value="GO"
                @auth
                {{ $endereco->endereco->sUf == "GO" ? "selected" : "" }}    
                @endauth
                >Goiás</option>
                <option value="MA"
                @auth
                {{ $endereco->endereco->sUf == "MA" ? "selected" : "" }}    
                @endauth
                >Maranhão</option>
                <option value="MT"
                @auth
                {{ $endereco->endereco->sUf == "MT" ? "selected" : "" }}    
                @endauth
                >Mato Grosso</option>
                <option value="MS"
                @auth
                {{ $endereco->endereco->sUf == "MS" ? "selected" : "" }}    
                @endauth
                >Mato Grosso do Sul</option>
                <option value="MG"
                @auth
                {{ $endereco->endereco->sUf == "MG" ? "selected" : "" }}    
                @endauth
                >Minas Gerais</option>
                <option value="PA"
                @auth
                {{ $endereco->endereco->sUf == "PA" ? "selected" : "" }}    
                @endauth
                >Pará</option>
                <option value="PB"
                @auth
                {{ $endereco->endereco->sUf == "PB" ? "selected" : "" }}    
                @endauth
                >Paraíba</option>
                <option value="PR"
                @auth
                {{ $endereco->endereco->sUf == "PR" ? "selected" : "" }}    
                @endauth
                >Paraná</option>
                <option value="PE"
                @auth
                {{ $endereco->endereco->sUf == "PE" ? "selected" : "" }}    
                @endauth
                >Pernambuco</option>
                <option value="PI"
                @auth
                {{ $endereco->endereco->sUf == "PI" ? "selected" : "" }}    
                @endauth
                >Piauí</option>
                <option value="RJ"
                @auth
                {{ $endereco->endereco->sUf == "RJ" ? "selected" : "" }}    
                @endauth
                >Rio de Janeiro</option>
                <option value="RN"
                @auth
                {{ $endereco->endereco->sUf == "RN" ? "selected" : "" }}    
                @endauth
                >Rio Grande do Norte</option>
                <option value="RS"
                @auth
                {{ $endereco->endereco->sUf == "RS" ? "selected" : "" }}    
                @endauth
                >Rio Grande do Su</option>
                <option value="RO"
                @auth
                {{ $endereco->endereco->sUf == "RO" ? "selected" : "" }}    
                @endauth
                >Rondônia</option>
                <option value="RR"
                @auth
                {{ $endereco->endereco->sUf == "RR" ? "selected" : "" }}    
                @endauth
                >Roraima</option>
                <option value="SC"
                @auth
                {{ $endereco->endereco->sUf == "SC" ? "selected" : "" }}    
                @endauth
                >Santa Catarina</option>
                <option value="SP"
                @auth
                {{ $endereco->endereco->sUf == "SP" ? "selected" : "" }}    
                @endauth
                >São Paulo</option>
                <option value="SE"
                @auth
                {{ $endereco->endereco->sUf == "SE" ? "selected" : "" }}    
                @endauth
                >Sergipe</option>
                <option value="TO"
                @auth
                {{ $endereco->endereco->sUf == "TO" ? "selected" : "" }}    
                @endauth
                >Tocantins</option>
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

        <div class="span7">
            <input readonly maxlength="40" id="cidade" type="text" class="form-input" name="cidade"
            @auth
            value="{{mb_strtoupper($endereco->endereco->sMunicipio,'UTF8')}}"
            @endauth              
            >
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="bairro" class="col-md-4 col-form-label text-md-right">
                {{ __('Bairro') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input readonly maxlength="40" id="bairro" type="text" class="form-input" name="bairro" 
            @auth
            value="{{mb_strtoupper($endereco->endereco->sBairro,'UTF8')}}"
            @endauth  
            >
            
            {{-- <select id="bairro" class="form-input{{ $errors->has('bairro') ? ' is-invalid' : '' }}" name="bairro">
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
            </select>        --}}
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="logradouro" class="col-md-4 col-form-label text-md-right">
                {{ __('Logradouro') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="logradouro" type="text" class="form-input" name="logradouro"            
            @auth
            value="{{mb_strtoupper($endereco->endereco->sRua,'UTF8')}}"
            @endauth  
            >
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="numero" class="col-md-4 col-form-label text-md-right">
                {{ __('Número') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="4" id="numero" type="text" class="form-input" name="numero" style="margin-bottom: 1px;" 
            @auth
            value="{{mb_strtoupper($endereco->endereco->sNumeroLocal,'UTF8')}}"
            @endauth  
            >
            <span style="font-size: 10px;"><b>Se não tiver Número, colocar 0</b></span>
        </div>

        <div class="controls span2 form-label">
            <label for="complemento" class="col-md-4 col-form-label text-md-right">
                {{ __('Complemento') }}
            </label>
        </div>

        <div class="span3">
            <input maxlength="50" id="complemento" type="text" class="form-input" name="complemento"
            @auth
            value="{{mb_strtoupper($endereco->endereco->sComplemento,'UTF8')}}"
            @endauth 
            >
        </div>
    </div>


    <form method="POST" action="" id="formEndereco" name="formEndereco" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Comprovante de Residência') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Comprovante de Endereço" />
                <input type="hidden" name="tipoDoc" value="ComprovanteEndereco" />
                <input type="hidden" name="idCpf" id="idEndereco" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoEndereco" /><br>
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoEndereco">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosEnderecoTbl" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th width='20%'>Descrição</th>
                        <th>Nome Original</th>
                        <th>Nome Final</th>
                        <th width='20%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
        </div>
    </div>
<br>
<br>
</div>