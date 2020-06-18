<?php

namespace App\Http\Controllers\Cadastro;

use Illuminate\Http\Request;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;
use App\Models\Log;
use Auth;
use DB;


class CadastroController extends Controller
{
    public function __construct()
    {
        // $this->middleware(['auth', 'verified']);
    }

    public function atualizaCGM() {

        if(Auth::user() !== null){
            return redirect()->route('cgm_validarCpf');
        }
        else{

            $showRecaptcha = GoogleRecaptcha::show(
                env('RECAPTCHA_SITE_KEY'), 
                'cgm_cpf', 
                'no_debug', 
                'mt-4 mb-3 col-md-6 offset-md-4 aligncenter', 
                'Por favor clique no checkbox do reCAPTCHA primeiro!'
            );

            return view('cadastro.cgmCpf', [ 'pagina' => "Principal",'showRecaptcha'=> $showRecaptcha,'vencimentoIPTU'=>0]);
        }
    }

    public function atualizaCGMIPTU() {

        if(Auth::user() !== null){
            return redirect()->route('cgm_validarCpfIPTU');
        }
        else{

            $showRecaptcha = GoogleRecaptcha::show(
                env('RECAPTCHA_SITE_KEY'), 
                'cgm_cpf', 
                'no_debug', 
                'mt-4 mb-3 col-md-6 offset-md-4 aligncenter', 
                'Por favor clique no checkbox do reCAPTCHA primeiro!'
            );

            return view('cadastro.cgmCpf', [ 'pagina' => "Principal",'showRecaptcha'=> $showRecaptcha, 'vencimentoIPTU'=>1]);
        }
    }

    public function cgm_direcionarForm() {
        if(Auth::user() !== null){
            return view('cadastro.cgmFormulario', [ 'pagina' => "Principal",'cpf'=> Auth::user()->cpf, 'vencimentoIPTU'=>0]);
        }
        else{
            return redirect()->route('atualizaCGM');
        }
    }

    public function alteraIPTU() {
        if(Auth::user() !== null){
            // usuário logado

            $cgm = $this->recuperaCGM(Auth::user()->cpf);

            if($cgm['error']){
                return view('site.usuario_falha_integracao');
            }

            $cgmEnderecoPrimario = $this->recuperaEnderecoCGM(Auth::user()->cpf,"P");

            if($cgmEnderecoPrimario['error']){
                return view('site.usuario_falha_integracao');
            }

            // dd($cgm['cgm'],$cgmEnderecoPrimario['endereco']);

            return view('cadastro.cgmFormulario', [ 'pagina' => "Principal",'cpf'=> Auth::user()->cpf, 'vencimentoIPTU'=>1, 'cgm' => $cgm['cgm'], 'endereco' => $cgmEnderecoPrimario['endereco'] ]);
        }
        else{
            return redirect()->route('atualizaCGMIPTU');
        }
    }

    public function cgm_validarCpf(Request $request) {

        if(Auth::user() !== null){
            return view('cadastro.cgmFormulario', [ 'pagina' => "Principal",'cpf'=> Auth::user()->cpf, 'vencimentoIPTU'=>$request->vencimentoIPTU]);
        }
        else{
            GoogleRecaptcha::verify(env('RECAPTCHA_SECRET_KEY'), 'Por favor clique no checkbox do reCAPTCHA primeiro!');

            return view('cadastro.cgmFormulario', [ 'pagina' => "Principal",'cpf'=> $request->cgm_cpf, 'vencimentoIPTU'=>$request->vencimentoIPTU]);
        }

    }

    public function gravar_cadastro(Request $request){

        if($request->vencimentoIPTU == 0){
            Log::create([ 'servico'=> 2000,  'descricao' => "Cadastrar / Atualizar CGM", 'cpf' => $request->cpf, 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        }
        else{
            Log::create([ 'servico'=> 2001,  'descricao' => "Alterar Validade de IPTU", 'cpf' => $request->cpf, 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        }

        // dd($request);

        // dd($documentosFinal, $CResidenciaFinal, $ArquivosVIFinal);

        $request->cep = str_replace(".", "", $request->cep);
        $request->cep = str_replace("-", "", $request->cep);

        $id = DB::connection('mysql')
        ->table('lecom_cgm')->insertGetId(
            [
                'TIPO_PESSOA'               => strlen($request->cpf)==14?"F":"J", 
                'RESP_PREENCHIMENTO'        => isset($request->respPreenchimento)?$request->respPreenchimento:null, 
                'NOME_REP_LEGAL'            => isset($request->nomeRespLegal)?$request->nomeRespLegal:null, 
                'RG_REP_LEGALIdentiadade'   => isset($request->idRespLegal)?$request->idRespLegal:null, 
                'RG_REP_LEGALIdOrgEmis'     => isset($request->orgEmRespLegal)?$request->orgEmRespLegal:null, 
                'RG_REP_LEGALIdDtEmis'      => isset($request->dtEmissRespLegal)?implode('-', array_reverse(explode('/', $request->dtEmissRespLegal))):null, 
                'CPF_REP_LEGALCPF'          => isset($request->cpfRespLegal)?$request->cpfRespLegal:null, 
                'RG_REP_LEGALEmail'         => isset($request->emailRespLegal)?$request->emailRespLegal:null, 

                'CNPJ'                      => strlen($request->cpf)>14?$request->cpf:null, 
                'RAZAO_SOCIAL'              => isset($request->razaoSocial)?$request->razaoSocial:null, 
                'NOME_FANTASIA'             => isset($request->nomeFantasia)?$request->nomeFantasia:null, 
                'NATUREZA_JURIDICA'         => isset($request->NatJur)?$request->NatJur:null, 
                'DATA_ABERTURA'             => isset($request->dtAbertura)?implode('-', array_reverse(explode('/', $request->dtAbertura))):null, 
                'INSCRICAO_ESTADUAL'        => isset($request->inscrEstadual)?$request->inscrEstadual:null, 

                'CPF'               => strlen($request->cpf)==14?$request->cpf:null, 
                'NOME'              => isset($request->nome)?$request->nome:null, 
                'NOME_SOCIAL'       => isset($request->nomeSocial)?$request->nomeSocial:null,
                'DATA_NASC'         => isset($request->dtnasc)?implode('-', array_reverse(explode('/', $request->dtnasc))):null,
                'SEXO'              => isset($request->sexo)?$request->sexo:null,
                'NACIONALIDADE'     => isset($request->nacionalidade)?$request->nacionalidade:null,
                'NATURALIDADE'      => isset($request->naturalidade)?$request->naturalidade:null,
                'ESTADO_CIVIL'      => isset($request->estCivil)?$request->estCivil:null,
                'FILIACAO1'         => isset($request->filiacao1)?$request->filiacao1:null,
                'FILIACAO2'         => isset($request->filiacao2)?$request->filiacao2:null,
                'IDENTIDADE'        => isset($request->identidade)?$request->identidade:null,
                'ORGAO_EXPEDITOR'   => isset($request->orgEmi)?$request->orgEmi:null,
                'DATA_EXPEDICAO'    => isset($request->dtEmiss)?implode('-', array_reverse(explode('/', $request->dtEmiss))):null,

                'CEP'               => $request->cep,
                'UF'                => $request->uf,
                'CIDADE'            => $request->cidade,
                'BAIRRO'            => $request->bairro,
                'ENDERECO'          => $request->logradouro,
                'NUMERO'            => $request->numero,
                'COMPLEMENTO'       => $request->complemento,
                'EMAIL'             => $request->email,
                'TELEFONE'          => $request->telefone,
                'CELULAR'           => $request->celular,
                
                'VALIDADE_IPTU'     => $request->vencimentoIPTU!=0?"SIM":"NÃO",
                'DATA_CADASTRO' => date('Y-m-d H:i:s')
            ]
        );

        $txtdocumentos = explode("|", $request->ArquivosPF);
        $documentosFinal = "";
        foreach ($txtdocumentos as &$value) {
            if(strlen($documentosFinal)>0){
                $documentosFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
                $documentosFinal .= $valueArray[0].";". $valueArray[2]; 

                DB::connection('mysql')
                ->table('lecom_cgm_documentos')->insert(
                    [
                        'id_cgm'    => $id, 
                        'cpf'       => $request->cpf, 
                        'documento' => $valueArray[2], 
                        'descricao' => $valueArray[0]
                    ]
                );
			}
        }
        
        $txtCResidencia = explode("|", $request->ArquivosCR);
        $CResidenciaFinal = "";
        foreach ($txtCResidencia as &$value) {
            if(strlen($CResidenciaFinal)>0){
                $CResidenciaFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
                $CResidenciaFinal .= $valueArray[0].";". $valueArray[2]; 

                DB::connection('mysql')
                ->table('lecom_cgm_documentos')->insert(
                    [
                        'id_cgm'    => $id, 
                        'cpf'       => $request->cpf, 
                        'documento' => $valueArray[2], 
                        'descricao' => $valueArray[0]
                    ]
                );
			}
        }
        
        $txtReq = explode("|", $request->ArquivosReq);
        $txtReqFinal = "";
        foreach ($txtReq as &$value) {
            if(strlen($txtReqFinal)>0){
                $txtReqFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
                $txtReqFinal .= $valueArray[0].";". $valueArray[2]; 

                DB::connection('mysql')
                ->table('lecom_cgm_documentos')->insert(
                    [
                        'id_cgm'    => $id, 
                        'cpf'       => $request->cpf, 
                        'documento' => $valueArray[2], 
                        'descricao' => $valueArray[0]
                    ]
                );
			}
        }
        
        
        $txtPJ = explode("|", $request->ArquivosPJ);
        $txtPJFinal = "";
        foreach ($txtPJ as &$value) {
            if(strlen($txtPJFinal)>0){
                $txtPJFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
                $txtPJFinal .= $valueArray[0].";". $valueArray[2]; 

                DB::connection('mysql')
                ->table('lecom_cgm_documentos')->insert(
                    [
                        'id_cgm'    => $id, 
                        'cpf'       => $request->cpf, 
                        'documento' => $valueArray[2], 
                        'descricao' => $valueArray[0]
                    ]
                );
			}
        }
        
        $txtArquivosVI = explode("|", $request->ArquivosVI);
        $ArquivosVIFinal = "";
        foreach ($txtArquivosVI as &$value) {
            if(strlen($ArquivosVIFinal)>0){
                $ArquivosVIFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
                $ArquivosVIFinal .= $valueArray[0].";". $valueArray[2]; 

                DB::connection('mysql')
                ->table('lecom_cgm_imoveis')->insert(
                    [
                        'id_cgm'                => $id, 
                        'cpf'                   => $request->cpf, 
                        'matricula_imovel'      => $valueArray[0], 
                        'tipo_vinculo'          => $valueArray[1], 
                        'descricao_documento'   => $valueArray[2],
                        'documento'             => $valueArray[4] 
                    ]
                );
			}
        }
        
        // $MatrcImoveis = explode("|", $request->MatrcImoveis);
        // $imoveisFinal = "";
        // foreach ($MatrcImoveis as &$value) {
        //     if(strlen($imoveisFinal)>0){
        //         $imoveisFinal .= ";";
        //     }        
        //     $value = str_replace("[", "", $value);
        //     $value = str_replace("]", "", $value);
        //     $value = str_replace("\"", "", $value);
        //     $valueArray = explode(",", $value);
		// 	if(count($valueArray) >1){
		// 		array_pop($valueArray); 
        //         $imoveisFinal .= $valueArray[0].";". $valueArray[1]; 

        //         DB::connection('mysql')
        //         ->table('lecom_cgm_imoveis')->insert(
        //             [
        //                 'id_cgm'            => $id, 
        //                 'cpf'               => $request->cpf, 
        //                 'matricula_imovel'  => $valueArray[1], 
        //             ]
        //         );
		// 	}
        // }






        
        return view('cadastro.protocolo', [ 'pagina' => "Principal",'nome'=> strlen($request->cpf)>14?$request->razaoSocial:$request->nome, 'cpf'=>$request->cpf, 'vencimentoIPTU' => $request->vencimentoIPTU]);

    }



    public function cadastro_documentos(Request $request){
        
        // Retorna mime type do arquivo (Exemplo image/png)
        $tipo = $request->arquivo->getMimeType();
        
        // Retorna o nome original do arquivo
        $nomeOriginal = $request->arquivo->getClientOriginalName();
        
        // Extensão do arquivo
        $extensaoOriginal = $request->arquivo->getClientOriginalExtension();
        $extensao = $request->arquivo->extension();
        
        $cpfUsuario = str_replace(".", "",$request->idCpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        $nomeArquivo = $cpfUsuario . "_" . $request->tipoDoc . "_" . uniqid() . ".".$extensao;
        
        $upload = $request->arquivo->storeAs('cgm', $nomeArquivo , 'local');
        
        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            
            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->tipoDoc , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);
        }
        else{
            // Erro no upload
            return (['statusArquivoTransacao'=> 2]); 
        }
    }

    public function cadastro_documentos_remove($arquivo){


        $retorno = Storage::disk('local')->delete('cgm/'.$arquivo);

        return (['status', 1]);
    }

    public function recuperaCGM($cpf){
        try {
            $cpfUsuario = str_replace(".", "",  $cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_CONSULTA_CGM,
                'z01_cgccpf'    => $cpfUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();

            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_CGM,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_SSL_VERIFYHOST => false,
				CURLOPT_SSL_VERIFYPEER => false,
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



            $userCGM = json_decode(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $response))));

            // dd( API_URL . API_CGM, $data_string, $response, $err);


            $retorno = [
                'error'         => false,
                'cgm'           => $userCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
    }

    public function recuperaEnderecoCGM($cpf,$tipo = "P"){

        // dd($tipo);

        try {
            $cpfUsuario = str_replace(".", "",  $cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_CONSULTA_ENDERECO_CGM,
                'sCpfcnpj'          => $cpfUsuario,
                'sTipoEndereco'     => $tipo,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();

            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_CGM,
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

            $enderecoCGM = json_decode( utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $response))));

            // dd(API_URL . API_CGM, $data_string, $response, $err);

            $retorno = [
                'error'         => false,
                'endereco'      => $enderecoCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
    }

}
