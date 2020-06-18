<div class="accordion-inner">
    <form method="POST" action="{{ route('cgm_documentos') }}" id="formDocumentos" enctype="multipart/form-data">
        @csrf
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricao" class="col-md-4 col-form-label text-md-right">
                    {{ __('Processo') }}
                </label>
            </div>

            <div class="span4">
                <select id="processo" class="form-input" name="processo">
                    @foreach ($processos as $processo)
                    <option value="{{ $processo["cod"] }}">
                        {{$processo["cod"]}} - {{$processo["descricao"]}}
                    </option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="descricao" class="col-md-4 col-form-label text-md-right">
                    {{ __('Descrição') }}
                </label>
            </div>

            <div class="span4">
                <select id="descricao" class="form-input" name="descricao">
                    <option value="CPF">CPF</option>
                    <option value="Identidade">Identidade</option>
                    <option value="Comprovante de Residência">Comprovante de Residência</option>
                    @if( strlen($cgm->aCgmPessoais->z01_cgccpf) > 11 )
                        <option value="Contrato Social">Contrato Social</option>
                        {{-- <option value="Imposto de Renda">Imposto de Renda</option> --}}
                    @endif
                </select>
            </div>
        </div>

        <div class="row formrow">
            <div class="controls span3 form-label">
                <label for="documento" class="col-md-4 col-form-label text-md-right">
                    {{ __('Documento') }}
                </label>
            </div>

            <div class="span6">
                <input type="file" name="arquivo" id="file" /><br>
                {{--  <input id="documento" type="text" class="form-input" name="documento" value="">  --}}
                Obs.: O tamanho máximo dos arquivos é de 2Mb.
            </div>
            <div class="span2">
                <button type="button" class="btn btn-small btn-blue e_wiggle align-left" id="lancarArquivo">
                    {{ __('Lançar') }}
                </button>
            </div>
        </div>
    </form>

    <div class="row formrow">
        <div class="span11">
            <h4 class="heading">Documentos Lançados<span></span></h4>

            <table id="documentosLancados" class="display" style="width:100%">
                <thead>
                    <tr>
                        <th width='10%'>processo</th>
                        <th width='20%'>Descrição</th>
                        <th>Documento</th>
                        <th width='20%'>&nbsp;</th>
                    </tr>
                </thead>
                <tbody>
                    @isset($arquivos)
                    @foreach ($arquivos as $documento)
                    <tr>
                        <td>{{ $documento->cod_lecom }} </td>
                        <td>{{ $documento->descricao }} </td>
                        <td>{{ $documento->nome_documento }}</td>
                        <td align="right">
                            <a href="{{ url('cgm_documentos_excluir/' . $documento->id) }}">
                                <button type="button" class="btn btn-small btn-danger e_wiggle">
                                    {{ __('Excluir') }}
                                </button>
                            </a>
                        </td>
                    </tr>
                    @endforeach
                    @endisset
                </tbody>
            </table>

        </div>
    </div>
    <br>
    <br>
</div>