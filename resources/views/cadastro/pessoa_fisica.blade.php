<div class="accordion-inner">
    {{-- CPF/CNPJ --}}
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="cpf" class="col-md-4 col-form-label text-md-right">
                {{ __('CPF') }} 
            </label>
        </div>
        <div class="span2">
            <input maxlength="20" id="cpfPF" type="text" class="form-input" name="cpf" value="{{$cpf}}" readonly>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nome" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="40" id="nome" type="text" class="form-input"  name="nome" 
            @auth
            value="{{$cgm->aCgmPessoais->z01_nome}}"
            @endauth
            >
        </div>
    </div>
    
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nomeSocial" class="col-md-4 col-form-label text-md-right">
                    {{ __('Nome Social') }}
            </label>
        </div>

        <div class="span7">
            <input maxlength="40" id="nomeSocial" type="text" class="form-input"  name="nomeSocial" value="">
        </div>
    </div>
    
    {{-- Dados Pessoa Física --}}
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="filiacao1" class="col-md-4 col-form-label text-md-right">
                {{ __('Mãe') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="40" id="filiacao1" type="text" class="form-input" name="filiacao1"
            @auth
            value="{{$cgm->aCgmPessoais->z01_mae}}"
            @endauth
            >

        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="filiacao2" class="col-md-4 col-form-label text-md-right">
                {{ __('Pai') }}
            </label>
        </div>

        <div class="span7">
            <input maxlength="40" id="filiacao2" type="text" class="form-input" name="filiacao2"
            @auth
            value="{{$cgm->aCgmPessoais->z01_pai}}"
            @endauth
            >
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="dtnasc" class="col-md-4 col-form-label text-md-right">
                {{ __('Data de Nascimento') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="dtnasc" type="text" class="form-input" name="dtnasc"
            @auth
            value="{{\Carbon\Carbon::parse($cgm->aCgmPessoais->z01_nasc)->format('d/m/Y')}}"
            @endauth            
            >
        </div>

        {{-- Separação --}}

        <div class="controls span2 form-label">
            <label for="estCivil" class="col-md-4 col-form-label text-md-right">
                {{ __('Estado Civil') }} <span class="required">*</span>
            </label>
        </div>
    
        <div class="span2">
            <select name="estCivil" id="estCivil" style="width:100%; ">
                <option value=""></option>
                <option value="Solteiro"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "1" ? "selected" : "" }}    
                @endauth
                >Solteiro</option>
                <option value="Casado"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "2" ? "selected" : "" }}    
                @endauth
                >Casado</option>
                <option value="Viúvo"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "3" ? "selected" : "" }}    
                @endauth
                >Viúvo</option>
                <option value="Divorciado"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "4" ? "selected" : "" }}    
                @endauth
                >Divorciado</option>
                <option value="Separado Consensual"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "5" ? "selected" : "" }}    
                @endauth
                >Separado Consensual</option>
                <option value="Separado Judicial"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "6" ? "selected" : "" }}    
                @endauth
                >Separado Judicial</option>
                <option value="União Estavel"
                @auth
                {{ $cgm->aCgmPessoais->z01_estciv == "7" ? "selected" : "" }}    
                @endauth
                >União Estavel</option>
            </select>
        </div>
    </div>
    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="nacionalidade" class="col-md-4 col-form-label text-md-right">
                {{ __('Nacionalidade') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <select name="nacionalidade" id="nacionalidade" style="width:100%;">
                <option value=""></option>
                <option value="Brasileira"
                @auth
                {{ $cgm->aCgmPessoais->z01_nacion == "1" ? "selected" : "" }}    
                @endauth
                >Brasileira</option>
                <option value="Estrangeira"
                @auth
                {{ $cgm->aCgmPessoais->z01_nacion == "2" ? "selected" : "" }}    
                @endauth
                >Estrangeira</option>
            </select>
        </div>

        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span1 form-label">
            <label for="sexo" class="col-md-4 col-form-label text-md-right">
                {{ __('Sexo') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <select id="sexo" class="form-input" name="sexo">
                <option value=""></option>
                <option value="M"
                @auth
                {{ $cgm->aCgmPessoais->z01_sexo == "M" ? "selected" : "" }}    
                @endauth
                >Masculino</option>
                <option value="F"
                @auth
                {{ $cgm->aCgmPessoais->z01_sexo == "F" ? "selected" : "" }}    
                @endauth
                >Feminino</option>
            </select>
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="naturalidade" class="col-md-4 col-form-label text-md-right">
                    {{ __('Naturalidade') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span7">
            <input maxlength="100" id="naturalidade" type="text" class="form-input"  name="naturalidade" value="">
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="identidade" class="col-md-4 col-form-label text-md-right">
                {{ __('Documento de Identificação') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="20" id="identidade" type="text" class="form-input" name="identidade" 
            @auth
            value="{{$cgm->aCgmAdicionais->z01_ident}}"
            @endauth
            >
        </div>
        {{-- Separação --}}
        <div class="controls span1 form-label">
            <label for="" class="col-md-4 col-form-label text-md-right">
                &nbsp;
            </label>
        </div>

        <div class="controls span2 form-label">
            <label for="orgEmi" class="col-md-4 col-form-label text-md-right">
                {{ __('Órgão Emissor') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input maxlength="50" id="orgEmi" type="text" class="form-input" name="orgEmi"
            @auth
            value="{{$cgm->aCgmAdicionais->z01_identorgao}}"
            @endauth
            >
        </div>
    </div>

    <div class="row formrow">
        <div class="controls span3 form-label">
            <label for="dtEmiss" class="col-md-4 col-form-label text-md-right">
                {{ __('Data Emissão') }} <span class="required">*</span>
            </label>
        </div>

        <div class="span2">
            <input id="dtEmiss" type="text" class="form-input" name="dtEmiss"
            @auth
            value="{{\Carbon\Carbon::parse($cgm->aCgmAdicionais->z01_identdtexp)->format('d/m/Y')}}"
            @endauth              
            >
        </div>

    </div>
    <form>
        @csrf
    </form>

    <form method="POST" action="" id="cad_doc_id" name="cad_doc_id" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Anexar Documento de Identidade') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="Identidade" />
                <input type="hidden" name="tipoDoc" value="Identidade" />
                <input type="hidden" name="idCpf" id="idId" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoId" /><br>
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoId">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    @if($vencimentoIPTU == 0)
        <div class="row formrow">
            <div class="controls span3 form-label">
            </div>
            <div class="span6">
                <div class="alert alert-info" role="alert">
                    Faça também uma selfie segurando, ao lado de sua face, o documento oficial de identificação, com o lado que contém a foto voltado para a câmera. É proibida a utilização de qualquer adereço, vestimenta ou aparato que impossibilite a completa visão de sua face, tais como óculos, bonés, gorros, entre outros. Não tire fotos de fotos, precisamos de uma foto de você mesmo(a).
                </div>
            </div>
        </div>
        <form method="POST" action="" id="cad_selfie_id" name="cad_selfie_id" enctype="multipart/form-data">
            @csrf
            <div class="row formrow">
                <div class="controls span3 form-label">
                    <label for="documento" class="col-md-4 col-form-label text-md-right">
                        {{ __('Anexar Selfie de Identificação') }} <span class="required">*</span>
                    </label>
                </div>

                <div class="span6">
                    <input type="hidden" name="DescrDoc" value="Selfie de Identificação" />
                    <input type="hidden" name="tipoDoc" value="selfie" />
                    <input type="hidden" name="idCpf" id="idSelfie" value="{{ $cpf }}" />
                    <input type="file" name="arquivo" id="arquivoSelfie" /><br>
                </div>
                <div class="span2">
                    <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoSelfie">
                        {{ __('Lançar') }}
                    </button>
                </div>
            </div>
        </form>
    @endif

    <form method="POST" action="" id="cad_doc_cpf" name="cad_doc_cpf" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Anexar Documento CPF') }} <span class="required">*</span>
                </label>
            </div>

            <div class="span6">
                <input type="hidden" name="DescrDoc" value="CPF" />
                <input type="hidden" name="tipoDoc" value="CPF" />
                <input type="hidden" name="idCpf" id="idCpf" value="{{ $cpf }}" />
                <input type="file" name="arquivo" id="arquivoCpf" /><br>
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivoCpf">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosLancadosPF" class="display" style="width:100%">
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
