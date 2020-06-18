<?php

namespace App\Http\Controllers\Financeiro;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Cidadao\CgmController;
use Auth;
use DB;

class FinanceiroController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

	public function selecaoDebito(){
		return view('financeiro.selecao_debito', ["pagina" => "Seleção de Débito"] );
	}

    public function debitosAbertos(){
        return view('financeiro.debitos_abertos', ["pagina" => "Débitos em Aberto", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name ] );
    }

    public function relatorioDebitosAbertos(Request $request){
        if($request->matricula != ""){
            $matricula_inscricao = $request->matricula;
        }
        if($request->inscricao != ""){
            $matricula_inscricao = $request->inscricao;
        }

        $registros = $this->integracaoPesquisaDebitos($request);
//        dd($registros);

        if(isset($registros->registros) && isset($registros->registros_unicos)){
            if(is_array($registros->registros) && is_array($registros->registros_unicos)){
                return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "registros" => $registros->registros, "registros_unicos" => $registros->registros_unicos, "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
            }
            else{
                if(!is_array($registros->registros) && is_array($registros->registros_unicos)){
                    return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "registros_unicos" => $registros->registros_unicos, "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
                }
                if(is_array($registros->registros) && !is_array($registros->registros_unicos)){
                    return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "registros" => $registros->registros, "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
                }
                if(!is_array($registros->registros) && !is_array($registros->registros_unicos)){
                    return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
                }
            }
        }
        if(isset($registros->registros) && !isset($registros->registros_unicos)){
            if(is_array($registros->registros)){
                return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "registros" => $registros->registros, "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
            }
            else{
                return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
            }
        }
        if(!isset($registros->registros) && isset($registros->registros_unicos)){
            if(is_array($registros->registros_unicos)){
                return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "registros_unicos" => $registros->registros_unicos, "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
            }
            else{
                return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
            }
        }
        if(!isset($registros->registros) && !isset($registros->registros_unicos)){
            return view('financeiro.relatorio_debitos_abertos', ["pagina" => "Débitos em Aberto", "tipo_pesquisa" => $request->tipo_pesquisa, "tipo_debito" => $request->tipo_debito, "matricula_inscricao" => $matricula_inscricao ] );
        }
    }

	public function geralFinanceira(){
		return view('financeiro.geral_financeira', ["pagina" => "Geral Financeira", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name ] );
	}

	public function pagamentosEfetuados(){
		return view('financeiro.pagamentos_efetuados', ["pagina" => "Pagamentos Efetuados", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name ] );
	}

	public function extratoFinanceiro(){
		return view('financeiro.extrato_financeiro', ["pagina" => "Extrato Financeiro", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name ] );
	}

    public function filtroExtratoFinanceiro(Request $request){
        if($request->tipo == 'i'){
            return view('financeiro.filtro_extrato_financeiro', ["pagina" => "Extrato Financeiro", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name, "tipo" => 'i', "inscricao" => $request->inscricao ] );
        }
        else{
            return view('financeiro.filtro_extrato_financeiro', ["pagina" => "Extrato Financeiro", "cpf" => Auth::user()->cpf, "nome" => Auth::user()->name, "tipo" => 'm', "matricula" => $request->matricula ] );
        }
    }

	public function integracaoPesquisaTipoDebitos(Request $request){
        if(isset($request->cpf)){
            $cpfUsuario = str_replace(".", "",  $request->cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            if($request->tipo == 'i'){
                $i_matricula_inscricao = $request->inscricao;
            }
            if($request->tipo == 'm'){
                $i_matricula_inscricao = $request->matricula;
            }

            $data1 = [
                'sExec'         => 'integracaopesquisatipodebitos',
                'i_cpfcnpj'    => $cpfUsuario,
                'i_matricula_inscricao' => $i_matricula_inscricao,
                'c_tipo_pesquisa' => $request->tipo,
                'sTokeValiadacao'   => API_TOKEN,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));


            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

//			dd(API_URL_GFD . API_GFD, $data_string, json_decode($response));
            return $response;
        }
	}

	public function integracaoPesquisaDebitos(Request $request){
        if(isset($request->cpf)){
            $cpfUsuario = str_replace(".", "",  $request->cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            if($request->tipo_pesquisa == 'i'){
                $i_matricula_inscricao = $request->inscricao;
            }
            if($request->tipo_pesquisa == 'm'){
                $i_matricula_inscricao = $request->matricula;
            }

            $data1 = [
                'sExec'         => 'integracaopesquisadebitos',
                'i_cpfcnpj'    => $cpfUsuario,
                'i_matricula_inscricao' => $i_matricula_inscricao,
                'c_tipo_pesquisa' => $request->tipo_pesquisa,
                'i_tipo_debito' => $request->tipo_debito,
                'sTokeValiadacao'   => API_TOKEN,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));


            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

//			dd(API_URL_GFD . API_GFD, $data_string, $response);
            if(isset($response->aDebitosUnicosEncontrados) && isset($response->aDebitosNormaisEncontrados)){
                return view('financeiro.relatorio_debitos_abertos', [ 'pagina' => 'Consulta Geral Financeira - Débitos Abertos', 'registros_unicos' => $response->aDebitosUnicosEncontrados, 'registros' => $response->aDebitosNormaisEncontrados ]);
            }
            if(isset($response->aDebitosUnicosEncontrados) && !isset($response->aDebitosNormaisEncontrados)){
                return view('financeiro.relatorio_debitos_abertos', [ 'pagina' => 'Consulta Geral Financeira - Débitos Abertos', 'registros_unicos' => $response->aDebitosUnicosEncontrados ]);
            }
            if(!isset($response->aDebitosUnicosEncontrados) && isset($response->aDebitosNormaisEncontrados)){
                return view('financeiro.relatorio_debitos_abertos', [ 'pagina' => 'Consulta Geral Financeira - Débitos Abertos', 'registros' => $response->aDebitosNormaisEncontrados ]);
            }
            if(!isset($response->aDebitosUnicosEncontrados) && !isset($response->aDebitosNormaisEncontrados)){
                return view('financeiro.relatorio_debitos_abertos', [ 'pagina' => 'Consulta Geral Financeira - Débitos Abertos' ]);
            }
        }
	}

	public function integracaoReciboDebitos(Request $request){
//        dd($request);
            $cpfUsuario = str_replace(".", "",  Auth::user()->cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);
            if(isset($request->registros_unicos)){
                $vet_registros_unicos = explode("_",$request->registros_unicos);

                $data1 = [
                    'sExec'         => 'integracaorecibodebitos',
                    'i_cpfcnpj'    => $cpfUsuario,
                    'i_matricula_inscricao' => $request->matricula_inscricao,
                    'c_tipo_pesquisa' => $request->tipo_pesquisa,
                    'i_tipo_debito' => $request->tipo_debito,
                    'a_lista_debitos' => [['i_numpre' => '','i_numpar' => '']],
                    'numpre_unica' => $vet_registros_unicos[0],
                    'numpar_unica' => $vet_registros_unicos[1],
                    'd_data_vencimento' => $request->dataVencimento,
                    'sTokeValiadacao'   => API_TOKEN,
                ];
            }
            if(isset($request->registros_normais)){
                $i=0;
                $i_numpre = array();
                $i_numpar = array();
                foreach($request->registros_normais as $registros_normais){
                    $dados = explode("_",$registros_normais);
                    $i_numpre[$i] = $dados[0];
                    $i_numpar[$i] = $dados[1];
                    $i++;
                }

                $numpre_numpar = array();
                $i=0;
                foreach($i_numpre as $numpre){
                    $numpre_numpar[$i]['i_numpre'] = $numpre;
                    $i++;
                }
                $i=0;
                foreach($i_numpar as $numpar){
                    $numpre_numpar[$i]['i_numpar'] = $numpar;
                    $i++;
                }
//                dd($numpre_numpar);
                $data1 = [
                    'sExec'         => 'integracaorecibodebitos',
                    'i_cpfcnpj'    => $cpfUsuario,
                    'i_matricula_inscricao' => $request->matricula_inscricao,
                    'c_tipo_pesquisa' => $request->tipo_pesquisa,
                    'i_tipo_debito' => $request->tipo_debito,
                    'a_lista_debitos' => $numpre_numpar,
                    'numpre_unica' => '',
                    'numpar_unica' => '',
                    'd_data_vencimento' => $request->dataVencimento,
                    'sTokeValiadacao'   => API_TOKEN,
                ];
            }

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));


            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);
//            dd(API_URL_GFD . API_GFD, $data_string, $response);

            $tipo = "application/pdf";
            $arquivo = $response->sUrl;
            $vet_arquivo = explode("/",$arquivo);
            $novoNome = "DebitosAbertos.pdf";

            header('Content-Description: File Transfer');
            header('Content-Disposition: attachment; filename="'.$novoNome.'"');
            header('Content-Type: application/octet-stream');
            header('Content-Transfer-Encoding: binary');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Pragma: public');
            header('Expires: 0');
            readfile($arquivo);

//			dd(API_URL_GFD . API_GFD, $data_string, $response);
/*
            if(isset($response->sUrl)){
                $return = $response->sUrl;
            }
            else{
                $return = "";
            }
            return $return;
*/
	}

    public function integracaoRelatorioTotalDebitos(Request $request){
//        dd($request);
        if(isset($request->cpf)){
            $cpfUsuario = str_replace(".", "",  $request->cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            if($request->tipo == 'i'){
                $i_codigo_pesquisa = $request->inscricao;
            }
            else{
                $i_codigo_pesquisa = $request->matricula;
            }

            $data1 = [
                'sExec'         => 'integracaorelatoriototaldebitos',
                'i_cpfcnpj'    => $cpfUsuario,
                'i_codigo_pesquisa' => $i_codigo_pesquisa,
                'c_tipo_pesquisa' => $request->tipo,
                'c_tipo_retatorio' => $request->tipo_relatorio,
                'sTokeValiadacao'   => API_TOKEN,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));

            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);

            if(isset($request->tipo_relatorio)){
                if(isset($response->sUrl)){
                    $tipo = "application/pdf";
                    $arquivo = $response->sUrl;
                    $vet_arquivo = explode("/",$arquivo);
                    if($request->tipo_relatorio == 'c'){
                        $novoNome = "ExtratoFinanceiroAnalítico.pdf";
                    }
                    else{
                        $novoNome = "ExtratoFinanceiroSintético.pdf";
                    }


                    header('Content-Description: File Transfer');
                    header('Content-Disposition: attachment; filename="'.$novoNome.'"');
                    header('Content-Type: application/octet-stream');
                    header('Content-Transfer-Encoding: binary');
                    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                    header('Pragma: public');
                    header('Expires: 0');

                    // Envia o arquivo para o cliente
                    readfile($arquivo);
                }
                else{
                    return "";
                }
            }
            else{
                return $response->sUrl;
            }

//            dd(API_URL_GFD . API_GFD, $data_string, $response);
        }
    }

    public function integracaoPagamentosEfetuados(Request $request){
//        dd($request);
        if(isset($request->cpf)){

            $cpfUsuario = remove_character_document($request->cpf);

            if(isset($request->inscricao) && $request->inscricao != ''){
                $c_tipo_pesquisa = 'i';
                $i_matricula_inscricao = $request->inscricao;
            }
            if(isset($request->matricula) && $request->matricula != ''){
                $c_tipo_pesquisa = 'm';
                $i_matricula_inscricao = $request->matricula;
            }

            $data1 = [
                'sExec'         => 'integracaopagamentosefetuados',
                'i_cpfcnpj'    => $cpfUsuario,
                'i_matricula_inscricao' => $i_matricula_inscricao,
                'c_tipo_pesquisa' => $c_tipo_pesquisa,
                'i_ano_pesq' => $request->exercicio,
                'd_dt_inicial_pesq' => $request->periodo_inicial,
                'd_dt_final_pesq' => $request->periodo_final,
                'sTokeValiadacao'   => API_TOKEN,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));


            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

//            dd(API_URL_GFD . API_GFD, $data_string, json_decode($response));

            $data = json_decode($response);

            $total = 0;
            if(isset($data->aPagamentosEfetuadoss)){
                foreach($data->aPagamentosEfetuadoss as $value){
                    $total += $value->k00_valor;
                }

                return view('financeiro/lista_pagamentos')->with(['data' => json_decode($response),'request' => $request,'total' => $total,'pagina' => "Pagamentos Efetuados"]);
            }
            else{
                return "";
            }
        }
    }

    public function integracaoRelatorioPagamentosEfetuados(Request $request){
        if(isset($request->cpf)){

            $cpfUsuario = remove_character_document($request->cpf);

            $data1 = [
                'sExec'         => 'integracaorelatoriopagamentosefetuados',
                'i_cpfcnpj'    => $cpfUsuario,
                'i_matricula_inscricao' => $request->matricula,
                'c_tipo_pesquisa' => 'm',
                'sTokeValiadacao'   => API_TOKEN,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL_GFD . API_GFD,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => http_build_query($data_string),
                CURLOPT_HTTPHEADER => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));


            if( USAR_SSL ){
                curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, SSL_API_VERIFICA);
                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_API);
            }

            $response = json_decode(curl_exec($ch));
            $err = curl_error($ch);
            curl_close($ch);
            if(isset($response->sUrl)){
                $tipo = "application/pdf";
                $arquivo = $response->sUrl;
                $vet_arquivo = explode("/",$arquivo);
                $novoNome = "PagamentosEfetuados.pdf";

                header('Content-Description: File Transfer');
                header('Content-Disposition: attachment; filename="'.$novoNome.'"');
                header('Content-Type: application/octet-stream');
                header('Content-Transfer-Encoding: binary');
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Pragma: public');
                header('Expires: 0');

                // Envia o arquivo para o cliente
                readfile($arquivo);
            }
            else{
                return "";
            }

//            dd(API_URL_GFD . API_GFD, $data_string, $response);
//            return Redirect::away($data->sUrl);

        }
    }

    public function pesquisarMatricula(){
        return "<div class='callout-white'>
                <div class'table_head'>
                    <div class='row'>
                        <div class='col-lg-3'>
                            <p><strong>Matrícula</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Tipo</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Planta/Quadra/Lote</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Ações</strong></p>
                        </div>
                    </div>
                </div>
                <div class='table_body'></div>
            </div>";
    }

    public function pesquisarInscricao(){
        return "<div class='callout-white'>
                <div class'table_head'>
                    <div class='row'>
                        <div class='col-lg-3'>
                            <p><strong>Inscrição</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Nome</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Endereço</strong></p>
                        </div>
                        <div class='col-lg-3'>
                            <p><strong>Ações</strong></p>
                        </div>
                    </div>
                </div>
                <div class='table_body'></div>
            </div>";
    }
}
