<?php

namespace App\Http\Controllers\Cidadao;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidaEmail;
use App\Models\Log;
use App\User;
use Auth;
use DB;

class CgmController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function cadastroCGM(){

        Log::create([ 'servico'=> strlen(Auth::user()->cpf)>14?15:13 , 'descricao' => strlen(Auth::user()->cpf)>14?"Cadastro Empresarial":"Cadastro do Cidadão", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);

        $cgm = $this->recuperaCGM(Auth::user()->cpf);
        
        // dd($cgm);
        if(!$cgm['error']){
            
            $userCGM = $cgm['cgm'];

            $servidor = $this->recuperaServidor(Auth::user()->cpf);
            
            // dd($servidor);

            $cgmEnderecoPrimario = $this->recuperaEnderecoCGM(Auth::user()->cpf,"P");
            // dd($cgmEnderecoPrimario);
            if($cgmEnderecoPrimario['error']){
                return view('site.usuario_falha_integracao');
            }
            
            $cgmEnderecoSecundario = $this->recuperaEnderecoCGM(Auth::user()->cpf,"S");
            // dd($cgmEnderecoSecundario);
            if($cgmEnderecoSecundario['error']){
                return view('site.usuario_falha_integracao');
            }

            $cgmEstados = $this->recuperaEstadosCGM();
            // dd($cgmEstados);
            if($cgmEstados['error']){
                return view('site.usuario_falha_integracao');
            }            

            $cgmBairros = $this->recuperaBairrosCGM('19','5474');
            // dd($cgmBairros);
            if($cgmBairros['error']){
                return view('site.usuario_falha_integracao');
            }              

            if(isset($userCGM->iStatus)){
                if($userCGM->iStatus == 1){
                    
                    $arqs = DB::table('cgm_documentos')
                    ->where('cpf',      '=', Auth::user()->cpf )
                    ->where('status',   '=', 0 )
                    ->get();

                    $arquivos = array();
                    if( $arqs->count() >0 ){
                        $arquivos=$arqs;
                    }

                    $email_novo = DB::table('cgm_email')
                        ->where('id_user', '=', Auth::user()->id )
                        ->where('data_confirmacao', '=', null )
                        ->get();

                    $email = "";
                    if( $email_novo->count() >0 ){
                        $email=$email_novo[0];
                    }
                    
                    $dadosPendentes = DB::table('cgm_lecom')
                        ->where('cpf',      '=', Auth::user()->cpf )
                        ->where('status',   '=', 0 )
                        ->get();

                    $documentosEnviados = DB::table('cgm_documentos')
                        ->where('cpf',      '=', Auth::user()->cpf )
                        ->where('status',   '=', 0 )
                        ->get();

                    // dd($dadosPendentes);
                    $mae = false;
                    $pai = false;
                    $nascimento = false;
                    $falecimento = false;
                    $estadoCivil = false;
                    $sexo = false;
                    $nacionalidade = false;
                    $escolaridade = false;
                    $cep = false;
                    $uf = false;
                    $municipio = false;
                    $bairro = false;
                    $endereco = false;
                    $numero = false;
                    $complemento = false;
                    $nomeFanta = false;
                    $inscrEst = false;
                    $nire = false;
                    $contato = false;

                    $processo = [];
                    $documentosPendentes = [];
                    foreach ($dadosPendentes as $campo){
                        $aba = "";
                        switch($campo->campo){
                            case 'mae':
                                $mae = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'pai':
                                $pai = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'nascimento':
                                $nascimento = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'falecimento':
                                $falecimento = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'estadoCivil':
                                $estadoCivil = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'sexo':
                                $sexo = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'nacionalidade':
                                $nacionalidade = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'escolaridade':
                                $escolaridade = true;
                                $aba = "Informações Pessoais";
                                break;
                            case 'cep':
                                $cep = true;
                                $aba = "Endereço";
                                break;
                            case 'uf':
                                $uf = true;
                                $aba = "Endereço";
                                break;
                            case 'municipio':
                                $municipio = true;
                                $aba = "Endereço";
                                break;
                            case 'bairro':
                                $bairro = true;
                                $aba = "Endereço";
                                break;
                            case 'endereco':
                                $endereco = true;
                                $aba = "Endereço";
                                break;
                            case 'numero':
                                $numero = true;
                                $aba = "Endereço";
                                break;
                            case 'complemento':
                                $complemento = true;
                                $aba = "Endereço";
                                break;
                            case 'nomeFanta':
                                $nomeFanta = true;
                                $aba = "Informações Empresariais";
                                break;
                            case 'inscrEst':
                                $inscrEst = true;
                                $aba = "Informações Empresariais";
                                break;
                            case 'nire':
                                $nire = true;
                                $aba = "Informações Empresariais";
                                break;
                            case 'contato':
                                $contato = true;
                                $aba = "Informações Empresariais";
                                break;
                        }
                        $pAchou = false;
                        foreach ($processo as $p){
                            if($p['cod'] ==  $campo->cod_lecom){
                                // dd($campo->cod_lecom);
                                $pAchou = true;
                                break;
                            }
                        }
                        if (!$pAchou){
                            array_push($processo, ["cod" => $campo->cod_lecom, "descricao" => $aba] );
                            $achou = false;
                            foreach ($documentosEnviados as $documento){
                                $processoLecom = DB::connection('lecom')
                                ->table('v_consulta_servico_sim')
                                ->where('cpf', '=', Auth::user()->cpf )
                                ->where('Chamado','=', $campo->cod_lecom)
                                ->get();


                                // dd($processoLecom[0]->Fase);

								//dd($documento->cod_lecom);
								
								if( isset($processoLecom[0]->Fase)){
									if($processoLecom[0]->Fase == 'Abertura da Solicitação'){
										if ($aba == "Informações Pessoais"){
											if ( $documento->cod_lecom == $campo->cod_lecom && ($documento->descricao == "CPF" || $documento->descricao == "Identidade" ) ) {
												$achou = true;
												break; 
											}
										}
										if ($aba == "Endereço"){
											if ( $documento->cod_lecom == $campo->cod_lecom && ($documento->descricao == "Comprovante de Residência") ) {
												$achou = true;
												break; 
											}
										}
										if ($aba == "Informações Empresariais"){
											if ( $documento->cod_lecom == $campo->cod_lecom && ($documento->descricao == "Contrato Social") ) {
												$achou = true;
												break; 
											}
										}
									}
									else{
										$achou = true;
									}
								}
								else{
                                    $achou = true;
                                }
                            }
                            if(!$achou){
                                array_push($documentosPendentes, ["aba" => $aba, "processo" => $campo->cod_lecom] );
                            }
                        }                        
                    }
					//dd("FIM");
                    // $userCGM->aCgmContato->z01_email = "mizael.pardinho@gmail.com";
                    
                    // dd(
                    //     $userCGM,
                    //     $cgmEnderecoPrimario['endereco'], 
                    //     $cgmEnderecoSecundario['endereco']
                    // );

                    return view('cgm.perfil', [ 
                        "cgm" => $userCGM, 
                        "email" => $email, 
                        "end1" => $cgmEnderecoPrimario['endereco'], 
                        "end2" => $cgmEnderecoSecundario['endereco'],
                        "estados" => $cgmEstados['estados'],
                        "bairros" => $cgmBairros['bairros'],
                        "camposAlterados" => $dadosPendentes,
                        "mae" => $mae,
                        "pai" => $pai,
                        "nascimento" => $nascimento,
                        "falecimento" => $falecimento,
                        "estadoCivil" => $estadoCivil,
                        "sexo" => $sexo,
                        "nacionalidade" => $nacionalidade,
                        "escolaridade" => $escolaridade,
                        "cep" => $cep,
                        "uf" => $uf,
                        "municipio" => $municipio,
                        "bairroEnd" => $bairro,
                        "endereco" => $endereco,
                        "numero" => $numero,
                        "complemento" => $complemento,
                        "nomeFanta" => $nomeFanta,
                        "inscrEst" => $inscrEst,
                        "nire" => $nire,
                        "contato" => $contato,
                        "arquivos" => $arquivos,
                        "processos" => $processo,
                        "documentosPendentes" => $documentosPendentes,
                        "serv" => $servidor['servidor'],
                        ]);
                }
                else{
                    return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: CGM_006' ]);
                }
            }
            else{
                // dd("Falha na integração 1");
                return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: CGM_006' ]);
            }
        }
        else{
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: INT_1001' ]);
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

            $enderecoCGM = json_decode($response);

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

    public function recuperaRuasCGM($id){
        try {

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_CONSULTA_RUAS_CGM,
                'iCodigoEstado'     => "19",
                'iCodigoMunicipio'  => "5474",
                'iBairro'           => $id,
                'iMunicipio'        => "0",
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
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

            $ruasCGM = json_decode($response);

            $retorno = [
                'error'   => false,
                'ruas'    => $ruasCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
    }

    public function recuperaBairrosCGM($estado, $municipio, $imunicipio = "0"){

        try {

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'            => API_CONSULTA_BAIRROS_CGM,
                'iCodigoEstado'    => $estado,
                'iCodigoMunicipio' => $municipio,
                'iMunicipio'       => $imunicipio,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            
            // dd($data_string);

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

            $bairrosCGM = json_decode($response);

            // dd($bairrosCGM );

            $retorno = [
                'error'         => false,
                'bairros'    => $bairrosCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
    }

    public function recuperaMunicipiosCGM($estado){

        try {

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'            => API_CONSULTA_MUNICIPIOS_CGM,
                'iCodigoEstado'    => $estado,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
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

            $municipiosCGM = json_decode($response);
            
            // dd(API_URL . API_CGM, $data_string, $municipiosCGM, $err);

            $retorno = [
                'error'         => false,
                'municipios'    => $municipiosCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
    }

    public function recuperaEstadosCGM(){

        // dd($tipo);

        try {

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_CONSULTA_ESTADOS_CGM,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
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

            $estadosCGM = json_decode($response);

            $retorno = [
                'error'         => false,
                'estados'      => $estadosCGM
            ];
            return $retorno ;

        } catch (\Exception $e) {
            $retorno = [
                'error'         => true
            ];
            return $retorno ;
        }
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



            $userCGM = json_decode($response);

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
    
    public function recuperaServidor($cpf){
        try {
            $cpfUsuario = str_replace(".", "",  $cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);

            // Recuperando dados do CGM...
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_SERVIDOR_CGM,
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

            $resposta = json_decode($response);

            // dd($data_string, $resposta);

            if($resposta->iStatus == 1){
                $retorno = [
                    'error'         => false,
                    'servidor'      => $resposta->servidor_municipal
                ];
                return $retorno ;
            }
            else{
                $retorno = [
                    'error'         => true,
                    'servidor'      => ""
                ];
                return $retorno ;
            }


        } catch (\Exception $e) {
            // dd($e);
            $retorno = [
                'error'         => true,
                'servidor'      => ""
            ];
            return $retorno ;
        }
    }

    public function cgm_informacoes_pessoais(Request $request){

        // dd($request);

        $validatedData = $request->validate([
            'name' => 'string|max:40',
            'mae' => 'string|max:40',
            'pai' => 'string|max:40',
            'dtnasc' => 'date_format:d/m/Y',
            'estCivil' => 'string|max:1',
            'nacionalidade' => 'string|max:1',
            'sex' => 'string|max:1',
        ]);

        $processosAbertos = DB::table('cgm_lecom')
        ->where('cpf',      '=', Auth::user()->cpf )
        ->where('status',   '=', 0 )
        ->whereIn('campo', ['mae', 'pai', 'nascimento', 'falecimento', 'estadoCivil', 'sexo', 'nacionalidade', 'escolaridade'])
        ->count();
        
        if($processosAbertos > 0){
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['abertos' => trans('Já existe um processo aberto para a alteração dos Dados Pessoais.  Aguarde a conclusão do mesmo para efetuar nova alteração.')]);
        }

        $guia = "Cadastro Geral Município";

        if( strlen( $request->cpf ) > 14){
            $assunto = "Pessoa Jurídica";
            $servico = "Cadastro Geral do Município - PJ";
        }
        else{
            $assunto = "Pessoa Física";
            $servico = "Cadastro Geral do Município - PF";
        }

        $serv = DB::connection('lecom')
        ->table('v_catalogo_sim')
        ->where('guia', '=', $guia )
        ->where('assunto', '=', $assunto )
        ->where('servico', '=', $servico )
        ->get();

        // dd($serv);

        $processo = $serv[0]->processo;
        $versao = $serv[0]->versao;

        $cgm = $this->recuperaCGM(Auth::user()->cpf);
        $enderecoCgm = $this->recuperaEnderecoCGM(Auth::user()->cpf);

        if(!$cgm['error']){
            $ticket = json_decode($this->ticketSSO());
            foreach ( $ticket as $ticketId ){
            }   

            $camposAlterados = array();
            // dd($cgm);
            // dd($enderecoCgm);
            
            $json = $serv[0]->json;

            // $cep = Auth::user()->cep;
            // $cep = str_replace("-", "", $cep);
            // $cep = str_replace(".", "", $cep);
            $json = str_replace("[TIPO_ACAO]", "1", $json);
            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[COLABORADOR]", "NÃO", $json);
                $json = str_replace("[CPF_CNPJ]", "CNPJ", $json);
                $json = str_replace("[CNPJ]", Auth::user()->cpf, $json);
                $json = str_replace("[CPF]", "", $json);
            }
            else{
                $json = str_replace("[COLABORADOR]",  $request->servidor, $json);
                $json = str_replace("[CPF_CNPJ]", "CPF", $json);
                $json = str_replace("[CPF]", Auth::user()->cpf, $json);
                $json = str_replace("[CNPJ]", "", $json);
            }
            $json = str_replace("[NUMCGM]", $cgm['cgm']->cgm, $json);

            $json = str_replace("[CPF]", Auth::user()->cpf, $json);
            $json = str_replace("[DATA_ALTERACAO]", $cgm['cgm']->aCgmPessoais->z01_ultalt, $json);
            $json = str_replace("[EMAIL]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmContato->z01_email))), $json);
            $json = str_replace("[NOME_COMPLETO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_nome))) , $json);

            // Informações Pessoais
            $json = str_replace("[MAE]",utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_mae))), $json);
            $json = str_replace("[MAE_NOVO]", $request->mae, $json);
            if ( $request->mae != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_mae)))){
                array_push($camposAlterados, 
                        array(
                            "campo" => "mae", 
                            "valor_anterior" =>utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_mae))), 
                            "valor_novo" => $request->mae, 
                            )
                        );
            }
            $json = str_replace("[PAI]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_pai))), $json);
            $json = str_replace("[PAI_NOVO]", $request->pai, $json);
            if ( $request->pai != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_pai)))){
                array_push($camposAlterados, 
                        array(
                            "campo" => "pai", 
                            "valor_anterior" =>utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_pai))), 
                            "valor_novo" => $request->pai, 
                            )
                        );
            }     
            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[NASCIMENTO]", "0000-00-00", $json);
                $json = str_replace("[NASCIMENTO_NOVO]", "0000-00-00", $json);
            }
            else{
                if($cgm['cgm']->aCgmPessoais->z01_nasc == ""){
                    $json = str_replace("[NASCIMENTO]", "0000-00-00", $json);
                }
                else{
                    $json = str_replace("[NASCIMENTO]", $cgm['cgm']->aCgmPessoais->z01_nasc, $json);
                }
                $dtnasc = explode("/", $request->dtnasc);
                $json = str_replace("[NASCIMENTO_NOVO]", "$dtnasc[2]-$dtnasc[1]-$dtnasc[0]", $json);
                if ( "$dtnasc[2]-$dtnasc[1]-$dtnasc[0]" !=  $cgm['cgm']->aCgmPessoais->z01_nasc){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "nascimento", 
                                "valor_anterior" =>  $cgm['cgm']->aCgmPessoais->z01_nasc, 
                                "valor_novo" => "$dtnasc[2]-$dtnasc[1]-$dtnasc[0]", 
                                )
                            );
                }  
            }

            if ($cgm['cgm']->aCgmPessoais->z01_dtfalecimento == ""){
                $json = str_replace("[FALECIMENTO]","0000-00-00", $json);
            }
            else{
                $json = str_replace("[FALECIMENTO]", $cgm['cgm']->aCgmPessoais->z01_dtfalecimento, $json);
            }
            if($request->dtfalec != ""){
                $dtfalec = explode("/", $request->dtfalec);
                $json = str_replace("[FALECIMENTO_NOVO]", "$dtfalec[2]-$dtfalec[1]-$dtfalec[0]", $json);

                if ( "$dtfalec[2]-$dtfalec[1]-$dtfalec[0]" !=  $cgm['cgm']->aCgmPessoais->z01_dtfalecimento){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "falecimento", 
                                "valor_anterior" => $cgm['cgm']->aCgmPessoais->z01_dtfalecimento, 
                                "valor_novo" => "$dtfalec[2]-$dtfalec[1]-$dtfalec[0]", 
                                )
                            );
                }  
            }
            else{
                $json = str_replace("[FALECIMENTO_NOVO]", "0000-00-00", $json);
            }

            $json = str_replace("[ESTADO_CIVIL]", $this->retornaEstadoCivil($cgm['cgm']->aCgmPessoais->z01_estciv), $json);
            $json = str_replace("[ESTADO_CIVIL_NOVO]",  $this->retornaEstadoCivil($request->estCivil), $json);
            if( strlen( Auth::user()->cpf ) <= 14){
                if ( $this->retornaEstadoCivil($request->estCivil) != $this->retornaEstadoCivil($cgm['cgm']->aCgmPessoais->z01_estciv)){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "estadoCivil", 
                                "valor_anterior" => $cgm['cgm']->aCgmPessoais->z01_estciv, 
                                "valor_novo" => $request->estCivil, 
                                )
                            );
                } 
            } 

            $json = str_replace("[SEXO]", $this->retornaSexo($cgm['cgm']->aCgmPessoais->z01_sexo), $json);
            $json = str_replace("[SEXO_NOVO]", $this->retornaSexo($request->sex), $json);
            if ( $this->retornaSexo($request->sex) != $this->retornaSexo($cgm['cgm']->aCgmPessoais->z01_sexo)){
                array_push($camposAlterados, 
                        array(
                            "campo" => "sexo", 
                            "valor_anterior" => $cgm['cgm']->aCgmPessoais->z01_sexo, 
                            "valor_novo" => $request->sex, 
                            )
                        );
            } 
            
            $json = str_replace("[NACIONALIDADE]", $this->retornaNacionalidade($cgm['cgm']->aCgmPessoais->z01_nacion), $json);
            $json = str_replace("[NACIONALIDADE_NOVO]", $this->retornaNacionalidade($request->nacionalidade), $json);
            if( strlen( Auth::user()->cpf ) <= 14){
                if ( $this->retornaNacionalidade($request->nacionalidade) != $this->retornaNacionalidade($cgm['cgm']->aCgmPessoais->z01_nacion)){
                    array_push($camposAlterados, 
                        array(
                            "campo" => "nacionalidade", 
                            "valor_anterior" => $cgm['cgm']->aCgmPessoais->z01_nacion, 
                            "valor_novo" => $request->nacionalidade, 
                            )
                        );
                } 

            }
            $json = str_replace("[ESCOLARIDADE]", $this->retornaEscolaridade($cgm['cgm']->aCgmPessoais->z01_escolaridade), $json);
            $json = str_replace("[ESCOLARIDADE_NOVO]", $this->retornaEscolaridade($request->escolaridade), $json);
            if ( $this->retornaEscolaridade($request->escolaridade) != $this->retornaEscolaridade($cgm['cgm']->aCgmPessoais->z01_escolaridade)){
                array_push($camposAlterados, 
                        array(
                            "campo" => "escolaridade", 
                            "valor_anterior" => $cgm['cgm']->aCgmPessoais->z01_escolaridade, 
                            "valor_novo" => $request->escolaridade, 
                            )
                        );
            }             

            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[NOME_FANTASIA]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_nomefanta))), $json);
                $json = str_replace("[NOME_FANTASIA_NOVO]", $request->nomeFantasia, $json);
                if ($request->nomeFantasia != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_nomefanta)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "nomeFanta", 
                                "valor_anterior" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_nomefanta))), 
                                "valor_novo" => $request->nomeFantasia, 
                                )
                            );
                }                 
            }
            else{
                $json = str_replace("[NOME_FANTASIA]", "", $json);
                $json = str_replace("[NOME_FANTASIA_NOVO]", "", $json);
            }

            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[INSCRICAO_ESTADUAL]", $cgm['cgm']->aCgmJuridico->z01_incest, $json);
                $json = str_replace("[INSCRICAO_ESTADUAL_NOVO]", $request->iest, $json);
                if ($request->iest != $cgm['cgm']->aCgmJuridico->z01_incest){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "inscrEst", 
                                "valor_anterior" => $cgm['cgm']->aCgmJuridico->z01_incest, 
                                "valor_novo" => $request->iest, 
                                )
                            );
                }                 
            }
            else{
                $json = str_replace("[INSCRICAO_ESTADUAL]", "", $json);
                $json = str_replace("[INSCRICAO_ESTADUAL_NOVO]", "", $json);
            }

            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[NIRE]", $cgm['cgm']->aCgmJuridico->z08_nire, $json);
                $json = str_replace("[NIRE_NOVO]", $request->nire, $json);
                if ($request->nire != $cgm['cgm']->aCgmJuridico->z08_nire){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "nire", 
                                "valor_anterior" => $cgm['cgm']->aCgmJuridico->z08_nire, 
                                "valor_novo" => $request->nire, 
                                )
                            );
                }                 
            }
            else{
                $json = str_replace("[NIRE]", "", $json);
                $json = str_replace("[NIRE_NOVO]", "", $json);
            }

            if( strlen( Auth::user()->cpf ) > 14){
                $json = str_replace("[CONTATO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_contato))), $json);
                $json = str_replace("[CONTATO_NOVO]", $request->contato, $json);
                if ($request->contato != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_contato)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "contato", 
                                "valor_anterior" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_contato))), 
                                "valor_novo" => $request->contato, 
                                )
                            );
                }                 
            }
            else{
                $json = str_replace("[CONTATO]", "", $json);
                $json = str_replace("[CONTATO_NOVO]", "", $json);
            }

            // dd($camposAlterados);

            $json = str_replace("[TELEFONE]",$cgm['cgm']->aCgmContato->z01_telef, $json);
            $json = str_replace("[TELEFONE_NOVO]", $cgm['cgm']->aCgmContato->z01_telef, $json);
            $json = str_replace("[CELULAR]", $cgm['cgm']->aCgmContato->z01_telcel, $json);
            $json = str_replace("[CELULAR_NOVO]", $cgm['cgm']->aCgmContato->z01_telcel, $json);
            $json = str_replace("[CGM_MUNICIPIO]", $cgm['cgm']->cgm, $json);
            $json = str_replace("[CGM_MUNICIPIO_NOVO]", $cgm['cgm']->cgm, $json);


            $json = str_replace("[CEP]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->iCep))), $json);
            $json = str_replace("[CEP_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->iCep))), $json);
            $json = str_replace("[UF]", $this->converteEstadoSigla($enderecoCgm['endereco']->endereco->sEstado), $json);
            $json = str_replace("[UF_NOVO]", $this->converteEstadoSigla($enderecoCgm['endereco']->endereco->sEstado), $json);
            $json = str_replace("[MUNICIPIO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sMunicipio))), $json);
            $json = str_replace("[MUNICIPIO_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sMunicipio))), $json);
            $json = str_replace("[BAIRRO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sBairro))), $json);
            $json = str_replace("[BAIRRO_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sBairro))), $json);
            $json = str_replace("[ENDERECO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sRua))), $json);
            $json = str_replace("[ENDERECO_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sRua))), $json);
            $json = str_replace("[NUMERO]", $enderecoCgm['endereco']->endereco->sNumeroLocal, $json);
            $json = str_replace("[NUMERO_NOVO]", $enderecoCgm['endereco']->endereco->sNumeroLocal, $json);
            $json = str_replace("[COMPLEMENTO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sComplemento))), $json);
            $json = str_replace("[COMPLEMENTO_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sComplemento))), $json);

            // dd($json);

            $url = str_replace(":processo",$processo, SISTEMACAMINHOBASE.CAMINHO);
            $url = str_replace(":versao",$versao, $url);

            // dd($url);
            
            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_TIMEOUT => 30000,
                CURLOPT_CUSTOMREQUEST => "PUT",
                CURLOPT_POSTFIELDS => $json,
                CURLOPT_HTTPHEADER => array(
                    "content-type: application/json",
                    "language: pt_BR",
                    "ticket-sso: $ticketId",
                ),
            ));
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);
            $retorno = [
                'ticket' => $ticketId,
                'resposta' => json_decode($response),
            ];
            
            // dd( $url, $json, $retorno);
            // dd($retorno["resposta"]->content->processInstanceId);

            if(isset($retorno["resposta"]->content->processInstanceId)){
                $dataAgora = date('Y-m-d H:i:s');
                foreach ($camposAlterados as $id => $valor) {
                    echo ($valor["campo"]."<br>");
                    $resposta = DB::table('cgm_lecom')->insert(
                        [
                            'cpf'               => Auth::user()->cpf, 
                            'cod_cgm'           => $cgm['cgm']->cgm, 
                            'cod_lecom'         => $retorno["resposta"]->content->processInstanceId, 
                            'campo'             => $valor["campo"], 
                            'valor_anterior'    => $valor["valor_anterior"], 
                            'valor_novo'        => $valor["valor_novo"], 
                            'data_solicitacao'  => $dataAgora,
                            'status'            => false
                        ]
                    );
                }
                return back()->with('status', 1);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: CGM_005' ]);
            }


        }
        else{
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: INT_1001' ]);
        }
    }

    public function cgm_informacoes_adicionais(Request $request){
        // dd($request);

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_ATUALIZA_CGM,
                'z01_cgccpf'        => $cpfUsuario
            ];
            // if($request->identidade!=="" && !is_null($request->identidade)){
            //     $data1 = array_merge($data1, array('z01_ident' => $request->identidade));
            // }
            
            // if($request->dtEmiss!=="" && !is_null($request->dtEmiss)){
            //     $dt = explode('/',$request->dtEmiss);
            //     $data1 = array_merge($data1, array('z01_identdtexp' => $dt[2]."-".$dt[1]."-".$dt[0]));
            // }
            // if($request->orgEmi!=="" && !is_null($request->orgEmi)){
            //     $data1 = array_merge($data1, array('z01_identorgao' => $request->orgEmi));
            // }
            // $pis = str_replace(".","", $request->pis);
            // if($request->pis!=="" && !is_null($request->pis)){
            //     $data1 = array_merge($data1, array('z01_pis' => $pis));
            // }
            // if($request->profissoes!=="" && !is_null($request->profissoes)){
            //     $data1 = array_merge($data1, array('z01_profis' => $request->profissoes));
            // }
            // if($request->local_trabalho!=="" && !is_null($request->local_trabalho)){
            //     $data1 = array_merge($data1, array('z01_localtrabalho' => $request->local_trabalho));
            // }
            if($request->renda!=="" && !is_null($request->renda)){
                $renda = str_replace(".", "", $request->renda);
                $renda = str_replace(",", ".", $renda);
                $data1 = array_merge($data1, array('z01_renda' => $renda));
            }


            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            
        //  dd($renda, $request->renda, $data_string );

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

            $resposta=json_decode($response);

            // dd( utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $resposta->sMessage))));
            // dd( $resposta );


            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                "mensagem" => '<p><strong>Atenção!</strong>Não foi possivel gravar as alterações.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: CGM_001' ]);
            }
            else {
                return back()->with('status', 1);
            }

        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Certidões', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível as alterações no seu cadastro.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function cancelaEnvioEmail(){
        DB::table('cgm_email')
        ->where('id_user', '=', Auth::user()->id )
        ->where('data_confirmacao', '=', null )
        ->delete();

        return redirect('cadastroCGM');
    }


    public function cgm_informacoes_contato(Request $request){

        // dd($request);

        $validatedData = $request->validate([
            'name' => 'string|max:40',
            'email' => 'email',
            'phone' => 'string|max:14',
            'celphone' => 'string:max:14',
        ]);

        $tel = str_replace("(", "", $request->phone);
        $tel = str_replace(")", "", $tel);
        $tel = str_replace("-", "", $tel);
        $tel = str_replace(".", "", $tel);
        $tel = str_replace(" ", "", $tel);

        if(!filter_var($tel, FILTER_VALIDATE_INT))
        {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['phone' => trans('O número do telefone é inválido')]);
        }

        $cel = str_replace("(", "", $request->celphone);
        $cel = str_replace(")", "", $cel);
        $cel = str_replace("-", "", $cel);
        $cel = str_replace(".", "", $cel);
        $cel = str_replace(" ", "", $cel);

        if(!filter_var($cel, FILTER_VALIDATE_INT))
        {
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['phone' => trans('O número do celular é inválido')]);
        }


        // if(!filter_var($request->email, FILTER_VALIDATE_EMAIL))
        // {
        //     return redirect()
        //     ->back()
        //     ->withInput()
        //     ->withErrors(['email' => trans('O email é inválido')]);
        // }

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_ATUALIZA_CGM,
                'z01_cgccpf'        => $cpfUsuario
            ];
            $gravaContato = false;
            if($request->phone!=="" && !is_null($request->phone)){
                $tel = str_replace(".", "", $request->phone);
                $tel = str_replace("-", "", $tel);
                $tel = str_replace("(", "", $tel);
                $tel = str_replace(")", "", $tel);
                $tel = str_replace("/", "", $tel);
                $data1 = array_merge($data1, array('z01_telef' => $tel));
                $gravaContato = true;
            }
            if($request->celphone!=="" && !is_null($request->celphone)){
                $cel = str_replace(".", "", $request->celphone);
                $cel = str_replace("-", "", $cel);
                $cel = str_replace("(", "", $cel);
                $cel = str_replace(")", "", $cel);
                $cel = str_replace("/", "", $cel);
                $data1 = array_merge($data1, array('z01_telcel' => $cel));
                $gravaContato = true;
            }

            if ($gravaContato){
                $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
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
    
                $resposta=json_decode($response);
    
                // dd( utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $resposta->sMessage))));
                // dd( $resposta );
                if($resposta->iStatus=== 2){
                    return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong>Não foi possivel gravar as alterações.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: CGM_002' ]);
                }
            }

            $alteraEmail = false;
            $solicitacao = DB::table('cgm_email')
                ->where('id_user', '=', Auth::user()->id )
                ->where('data_confirmacao', '=', null )
                ->first();

            if($solicitacao){
                return redirect()
                ->back()
                ->withInput()
                ->withErrors(['email' => trans('Já existe uma solicitação de troca de e-mail pendente, finalize ou cancele para fazer uma nova solcitação')]);
            }
            else{
                if ($request->emailOld != $request->email){
                    DB::table('cgm_email')
                    ->where('id_user', '=', Auth::user()->id )
                    ->where('data_confirmacao', '=', null )
                    ->delete();
    
                    $token = uniqid();
                    DB::table('cgm_email')->insert(
                        [
                            'cpf' => Auth::user()->cpf, 
                            'id_user' => Auth::user()->id, 
                            'email_atual' => $request->emailOld, 
                            'email_novo' => $request->email, 
                            'data_solicitacao' => date('Y-m-d H:i:s'),
                            'token' => $token
                        ]
                    );
                    $alteraEmail = true;
                    $usuario = [
                        'nome'      => str_replace("+", " ", Auth::user()->name),
                        'novoEmail' => str_replace("+", " ", $request->email),
                        'token'     => $token
                    ];
                    // dd($usuario);
                    if( $_SERVER['HTTP_HOST'] == 'ticmarica.com.br'){
                        Mail::to("mizael.barbosa@gmail.com")->send(new ValidaEmail($usuario));
                    }
                    else{
                        Mail::to($request->emailOld)->send(new ValidaEmail($usuario));
                    }
                }
    
                $valor = 0;
                if($gravaContato){
                    $valor = $valor + 1;
                }
                if($alteraEmail){
                    $valor = $valor + 2;
                }
    
                return back()->with('status', $valor);
            }

        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível registrar as alterações.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function cgm_endereco(Request $request){
        // dd($request);

        $processosAbertos = DB::table('cgm_lecom')
        ->where('cpf',      '=', Auth::user()->cpf )
        ->where('status',   '=', 0 )
        ->whereIn('campo', ['cep', 'uf', 'municipio', 'bairro', 'endereco', 'numero', 'complemento', 'CodMunicipio', 'CodBairro', 'CodRua', 'morador'])
        ->count();
        
        if($processosAbertos > 0){
            return redirect()
            ->back()
            ->withInput()
            ->withErrors(['abertos' => trans('Já existe um processo aberto para a alteração do Endereço.  Aguarde a conclusão do mesmo para efetuar nova alteração.')]);
        }        

        if($request->morador1 == 0){
            // Morador do Município

            $codEstado = "19";
            $descrEstado = "RIO DE JANEIRO";
            $codMunicipio = "5474";
            $descrMunicipio = "MARICA";

            $cgmBairros = $this->recuperaBairrosCGM($codEstado,$codMunicipio);

            if($cgmBairros['error']){
                return view('site.usuario_falha_integracao');
            }

            // dd($cgmBairros['bairros']->aBairrosEncontradas);

            $codbairro = "";
            $descrBairro = strtoupper($request->district1);

            foreach ($cgmBairros['bairros']->aBairrosEncontradas as $id => $valor) {
                // echo strtolower(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao))))."<br>";
                if (strtolower($request->district1) == $valor->iBairro ){
                    $codbairro = $valor->iBairro;
                    $descrBairro = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao)));
                    break;
                }
            }

            // dd($codbairro, $descrBairro);

            $codRua = "";
            $descrRua = strtoupper($request->address1);
            if($codbairro != ""){
                $cgmRuas = $this->recuperaRuasCGM($codEstado,$codMunicipio,$codbairro);
                if($cgmRuas['error']){
                    return view('site.usuario_falha_integracao');
                }
                // dd($cgmRuas['ruas']->aRuasEncontradas);

                foreach ($cgmRuas['ruas']->aRuasEncontradas as $id => $valor) {
                    if (strtolower($request->address1) == $valor->iRua){
                        $codRua = $valor->iRua;
                        $descrRua = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao)));
                        break;
                    }
                }
                // dd($codRua, $descrRua);
            }

        }
        else{
            // Não é morador do Município
            $cgmMunicipios = $this->recuperaMunicipiosCGM($request->ufCod1);
            if($cgmMunicipios['error']){
                return view('site.usuario_falha_integracao');
            }

            $codEstado = $request->ufCod1;

            foreach ($cgmMunicipios['municipios']->oMunicipio as $id => $valor) {
                if (strtolower($request->city1) == strtolower(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->descricao))) )){
                    if($valor->codigo !== "5474"){
                        $codMunicipio = $valor->codigo;
                        $descrMunicipio = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->descricao)));
                        break;
                    }
                }
            }
            $codbairro = "";
            $descrBairro = strtoupper($request->district1);
            $codRua = "";
            $descrRua = strtoupper($request->address1);
        }



        try {
            $guia = "Cadastro Geral Município";

            // dd(strlen( Auth::user()->cpf ));
            if( strlen( Auth::user()->cpf ) > 14){
                $assunto = "Pessoa Jurídica";
                $servico = "Cadastro Geral do Município - PJ";
            }
            else{
                $assunto = "Pessoa Física";
                $servico = "Cadastro Geral do Município - PF";
            }
    
            
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=', $guia )
            ->where('assunto', '=', $assunto )
            ->where('servico', '=', $servico )
            ->get();
    
            // dd($serv);
            $processo = $serv[0]->processo;
            $versao = $serv[0]->versao;
    
            $cgm = $this->recuperaCGM(Auth::user()->cpf);
            $enderecoCgm = $this->recuperaEnderecoCGM(Auth::user()->cpf);
    
            if(!$cgm['error']){
                $ticket = json_decode($this->ticketSSO());
                foreach ( $ticket as $ticketId ){
                }   
    
                $camposAlterados = array();
                // dd($cgm);
                // dd($enderecoCgm);
                
                // $json = '{"values":[{"id": "TIPO_ACAO","value": "[TIPO_ACAO]"},{"id": "NUMCGM","value": "[NUMCGM]"},{"id": "CPF","value": "[CPF]"},{"id": "DATA_ALTERACAO","value": "[DATA_ALTERACAO]"},{"id": "EMAIL","value": "[EMAIL]"},{"id": "NOME_COMPLETO","value": "[NOME_COMPLETO]"},{"id": "MAE","value": "[MAE]"},{"id": "MAE_NOVO","value": "[MAE_NOVO]"},{"id": "PAI","value": "[PAI]"},{"id": "PAI_NOVO","value": "[PAI_NOVO]"},{"id": "NASCIMENTO","value": "[NASCIMENTO]"},{"id": "NASCIMENTO_NOVO","value": "[NASCIMENTO_NOVO]"},{"id": "FALECIMENTO","value": "[FALECIMENTO]"},{"id": "FALECIMENTO_NOVO","value": "[FALECIMENTO_NOVO]"},{"id": "ESTADO_CIVIL","value": "[ESTADO_CIVIL]"},{"id": "ESTADO_CIVIL_NOVO","value": "[ESTADO_CIVIL_NOVO]"},{"id": "SEXO","value": "[SEXO]"},{"id": "SEXO_NOVO","value": "[SEXO_NOVO]"},{"id": "NACIONALIDADE","value": "[NACIONALIDADE]"},{"id": "NACIONALIDADE_NOVO","value": "[NACIONALIDADE_NOVO]"},{"id": "ESCOLARIDADE","value": "[ESCOLARIDADE]"},{"id": "ESCOLARIDADE_NOVO","value": "[ESCOLARIDADE_NOVO]"},{"id": "TELEFONE","value": "[TELEFONE]"},{"id": "TELEFONE_NOVO","value": "[TELEFONE_NOVO]"},{"id": "CELULAR","value": "[CELULAR]"},{"id": "CELULAR_NOVO","value": "[CELULAR_NOVO]"},{"id": "CGM_MUNICIPIO","value": "[CGM_MUNICIPIO]"},{"id": "CGM_MUNICIPIO_NOVO","value": "[CGM_MUNICIPIO_NOVO]"},{"id": "CEP","value": "[CEP]"},{"id": "CEP_NOVO","value": "[CEP_NOVO]"},{"id": "UF","value": "[UF]"},{"id": "UF_NOVO","value": "[UF_NOVO]"},{"id": "MUNICIPIO","value": "[MUNICIPIO]"},{"id": "MUNICIPIO_NOVO","value": "[MUNICIPIO_NOVO]"},{"id": "BAIRRO","value": "[BAIRRO]"},{"id": "BAIRRO_NOVO","value": "[BAIRRO_NOVO]"},{"id": "ENDERECO","value": "[ENDERECO]"},{"id": "ENDERECO_NOVO","value": "[ENDERECO_NOVO]"},{"id": "NUMERO","value": "[NUMERO]"},{"id": "NUMERO_NOVO","value": "[NUMERO_NOVO]"},{"id": "COMPLEMENTO","value": "[COMPLEMENTO]"},{"id": "COMPLEMENTO_NOVO","value": "[COMPLEMENTO_NOVO]"}]} ';
                $json = $serv[0]->json;
    
                // $json = str_replace('{"id": "FALECIMENTO","value": "[FALECIMENTO]"},{"id": "FALECIMENTO_NOVO","value": "[FALECIMENTO_NOVO]"},', "", $json);
    
                // $cep = Auth::user()->cep;
                // $cep = str_replace("-", "", $cep);
                // $cep = str_replace(".", "", $cep);
                $json = str_replace("[TIPO_ACAO]", "1", $json);
                
                $json = str_replace("[NUMCGM]", $cgm['cgm']->cgm, $json);
                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[COLABORADOR]", "NAO", $json);
                    $json = str_replace("[CPF_CNPJ]", "CNPJ", $json);
                    $json = str_replace("[CNPJ]", Auth::user()->cpf, $json);
                    $json = str_replace("[CPF]", "", $json);
                }
                else{
                    $json = str_replace("[COLABORADOR]",  $request->servidor, $json);
                    $json = str_replace("[CPF_CNPJ]", "CPF", $json);
                    $json = str_replace("[CPF]", Auth::user()->cpf, $json);
                    $json = str_replace("[CNPJ]", "", $json);
                }
                $json = str_replace("[DATA_ALTERACAO]", $cgm['cgm']->aCgmPessoais->z01_ultalt, $json);
                $json = str_replace("[EMAIL]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',  $cgm['cgm']->aCgmContato->z01_email))), $json);
                $json = str_replace("[NOME_COMPLETO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_nome))) , $json);
    
                // Informações Pessoais
                $json = str_replace("[MAE]",utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_mae))), $json);
                $json = str_replace("[MAE_NOVO]",utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_mae))), $json);
                $json = str_replace("[MAE_NOVO]", $request->mae, $json);
                $json = str_replace("[PAI]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_pai))), $json);
                $json = str_replace("[PAI_NOVO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmPessoais->z01_pai))), $json);
    
                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[NASCIMENTO]", "0000-00-00", $json);
                    $json = str_replace("[NASCIMENTO_NOVO]", "0000-00-00", $json);
                }
                else{
                    if($cgm['cgm']->aCgmPessoais->z01_nasc == ""){
                        $json = str_replace("[NASCIMENTO]", "0000-00-00", $json);
                        $json = str_replace("[NASCIMENTO_NOVO]", "0000-00-00", $json);
                    }
                    else{
                        $json = str_replace("[NASCIMENTO]", $cgm['cgm']->aCgmPessoais->z01_nasc, $json);
                        $json = str_replace("[NASCIMENTO_NOVO]", $cgm['cgm']->aCgmPessoais->z01_nasc, $json);
                    }
                }
                if ($cgm['cgm']->aCgmPessoais->z01_dtfalecimento == ""){
                    $json = str_replace("[FALECIMENTO]","0000-00-00", $json);
                }
                else{
                    $json = str_replace("[FALECIMENTO]", $cgm['cgm']->aCgmPessoais->z01_dtfalecimento, $json);
                }
                if ($cgm['cgm']->aCgmPessoais->z01_dtfalecimento == ""){
                    $json = str_replace("[FALECIMENTO_NOVO]","0000-00-00", $json);
                }
                else{
                    $json = str_replace("[FALECIMENTO_NOVO]", $cgm['cgm']->aCgmPessoais->z01_dtfalecimento, $json);
                }
    
                $json = str_replace("[ESTADO_CIVIL]", $this->retornaEstadoCivil($cgm['cgm']->aCgmPessoais->z01_estciv), $json);
                $json = str_replace("[ESTADO_CIVIL_NOVO]", $this->retornaEstadoCivil($cgm['cgm']->aCgmPessoais->z01_estciv), $json);
                $json = str_replace("[SEXO]", $this->retornaSexo($cgm['cgm']->aCgmPessoais->z01_sexo), $json);
                $json = str_replace("[SEXO_NOVO]", $this->retornaSexo($cgm['cgm']->aCgmPessoais->z01_sexo), $json);
                $json = str_replace("[NACIONALIDADE]", $this->retornaNacionalidade($cgm['cgm']->aCgmPessoais->z01_nacion), $json);
                $json = str_replace("[NACIONALIDADE_NOVO]", $this->retornaNacionalidade($cgm['cgm']->aCgmPessoais->z01_nacion), $json);
    
                $json = str_replace("[ESCOLARIDADE]", $this->retornaEscolaridade($cgm['cgm']->aCgmPessoais->z01_escolaridade), $json);
                $json = str_replace("[ESCOLARIDADE_NOVO]", $this->retornaEscolaridade($cgm['cgm']->aCgmPessoais->z01_escolaridade), $json);
    
                $json = str_replace("[TELEFONE]",$cgm['cgm']->aCgmContato->z01_telef, $json);
                $json = str_replace("[TELEFONE_NOVO]", $cgm['cgm']->aCgmContato->z01_telef, $json);
                $json = str_replace("[CELULAR]", $cgm['cgm']->aCgmContato->z01_telcel, $json);
                $json = str_replace("[CELULAR_NOVO]", $cgm['cgm']->aCgmContato->z01_telcel, $json);
                $json = str_replace("[CGM_MUNICIPIO]", $cgm['cgm']->cgm, $json);
                $json = str_replace("[CGM_MUNICIPIO_NOVO]", $cgm['cgm']->cgm, $json);
    
    
                $json = str_replace("[CEP]", $enderecoCgm['endereco']->endereco->iCep, $json);
                $cep = str_replace("-", "", $request->cep1);
                $cep = str_replace(".", "", $cep);
                $json = str_replace("[CEP_NOVO]", $cep, $json);
                if ( $request->cep1 != ($enderecoCgm['endereco']->endereco->iCep)){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "cep", 
                                "valor_anterior" => $enderecoCgm['endereco']->endereco->iCep, 
                                "valor_novo" => $cep, 
                                )
                            );
                }    

                $json = str_replace("[UF]", $this->converteEstadoSigla($enderecoCgm['endereco']->endereco->sEstado), $json);
                $json = str_replace("[UF_NOVO]", $this->converteEstadoSigla($request->ufDesc1), $json);
                if ( $request->uf1 != $this->converteEstadoSigla($enderecoCgm['endereco']->endereco->sEstado)){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "uf", 
                                "valor_anterior" => $enderecoCgm['endereco']->endereco->iEstado, 
                                "valor_novo" => $request->ufCod1, 
                                )
                            );
                }  

                $json = str_replace("[MUNICIPIO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sMunicipio))), $json);
                $json = str_replace("[MUNICIPIO_NOVO]", $request->city1, $json);
                if ( $request->city1 != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sMunicipio)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "municipio", 
                                "valor_anterior" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sMunicipio))), 
                                "valor_novo" => $request->city1, 
                                )
                            );
                }                  
                $json = str_replace("[BAIRRO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sBairro))), $json);
                $b = explode("|",$request->district1);
                $json = str_replace("[BAIRRO_NOVO]", $b[1], $json);
                if ( $b[0] != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sBairro)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "bairro", 
                                "valor_anterior" =>  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sBairro))), 
                                "valor_novo" => $b[0], 
                                )
                            );
                }                  
                $json = str_replace("[ENDERECO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sRua))), $json);
                $end = explode("|", $request->address1);
                $json = str_replace("[ENDERECO_NOVO]", $end[1], $json);
                if ( $end[0] != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sRua)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "endereco", 
                                "valor_anterior" =>  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sRua))), 
                                "valor_novo" => $end[0], 
                                )
                            );
                }                 
                $json = str_replace("[NUMERO]", $enderecoCgm['endereco']->endereco->sNumeroLocal, $json);
                $json = str_replace("[NUMERO_NOVO]",$request->number1, $json);
                if ( $request->number1 != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sNumeroLocal)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "numero", 
                                "valor_anterior" =>  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sNumeroLocal))), 
                                "valor_novo" => $request->number1, 
                                )
                            );
                }  

                $json = str_replace("[COMPLEMENTO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sComplemento))), $json);
                $json = str_replace("[COMPLEMENTO_NOVO]", $request->complement1, $json);
                if ( $request->complement1 != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sComplemento)))){
                    array_push($camposAlterados, 
                            array(
                                "campo" => "complemento", 
                                "valor_anterior" =>  utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$enderecoCgm['endereco']->endereco->sComplemento))), 
                                "valor_novo" => $request->complement1, 
                                )
                            );
                }  
                if(isset($codMunicipio)){
                    array_push($camposAlterados, 
                    array(
                        "campo" => "CodMunicipio", 
                        "valor_anterior" => "", 
                        "valor_novo" =>  $codMunicipio, 
                        )
                    );
                }
                if(isset($codMunicipio)){
                    array_push($camposAlterados, 
                    array(
                        "campo" => "CodBairro", 
                        "valor_anterior" => "", 
                        "valor_novo" =>  $codbairro, 
                        )
                    );
                }
                if(isset($codRua)){
                    array_push($camposAlterados, 
                    array(
                        "campo" => "CodRua", 
                        "valor_anterior" =>  "", 
                        "valor_novo" => $codRua, 
                        )
                    );
                }
                if(isset($request->morador1)){
                    array_push($camposAlterados, 
                    array(
                        "campo" => "morador", 
                        "valor_anterior" =>  "", 
                        "valor_novo" => $request->morador1, 
                        )
                    );
                }


                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[NOME_FANTASIA]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_nomefanta))), $json);
                    $json = str_replace("[NOME_FANTASIA_NOVO]", $request->nomeFantasia, $json);
                    if ($request->nomeFantasia != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_nomefanta)))){
                        array_push($camposAlterados, 
                                array(
                                    "campo" => "nomeFanta", 
                                    "valor_anterior" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_nomefanta))), 
                                    "valor_novo" => $request->nomeFantasia, 
                                    )
                                );
                    }                 
                }
                else{
                    $json = str_replace("[NOME_FANTASIA]", "", $json);
                    $json = str_replace("[NOME_FANTASIA_NOVO]", "", $json);
                }
    
                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[INSCRICAO_ESTADUAL]", $cgm['cgm']->aCgmJuridico->z01_incest, $json);
                    $json = str_replace("[INSCRICAO_ESTADUAL_NOVO]", $request->iest, $json);
                    if ($request->iest != $cgm['cgm']->aCgmJuridico->z01_incest){
                        array_push($camposAlterados, 
                                array(
                                    "campo" => "inscrEst", 
                                    "valor_anterior" => $cgm['cgm']->aCgmJuridico->z01_incest, 
                                    "valor_novo" => $request->iest, 
                                    )
                                );
                    }                 
                }
                else{
                    $json = str_replace("[INSCRICAO_ESTADUAL]", "", $json);
                    $json = str_replace("[INSCRICAO_ESTADUAL_NOVO]", "", $json);
                }
    
                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[NIRE]", $cgm['cgm']->aCgmJuridico->z08_nire, $json);
                    $json = str_replace("[NIRE_NOVO]", $request->nire, $json);
                    if ($request->nire != $cgm['cgm']->aCgmJuridico->z08_nire){
                        array_push($camposAlterados, 
                                array(
                                    "campo" => "nire", 
                                    "valor_anterior" => $cgm['cgm']->aCgmJuridico->z08_nire, 
                                    "valor_novo" => $request->nire, 
                                    )
                                );
                    }                 
                }
                else{
                    $json = str_replace("[NIRE]", "", $json);
                    $json = str_replace("[NIRE_NOVO]", "", $json);
                }
    
                if( strlen( Auth::user()->cpf ) > 14){
                    $json = str_replace("[CONTATO]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_contato))), $json);
                    $json = str_replace("[CONTATO_NOVO]", $request->contato, $json);
                    if ($request->contato != utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmJuridico->z01_contato)))){
                        array_push($camposAlterados, 
                                array(
                                    "campo" => "contato", 
                                    "valor_anterior" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgm['cgm']->aCgmJuridico->z01_contato))), 
                                    "valor_novo" => $request->contato, 
                                    )
                                );
                    }                 
                }
                else{
                    $json = str_replace("[CONTATO]", "", $json);
                    $json = str_replace("[CONTATO_NOVO]", "", $json);
                }
    



                // dd($camposAlterados);

                // dd($guia, $assunto, $servico, $json, $request);
    
                $url = str_replace(":processo",$processo, SISTEMACAMINHOBASE.CAMINHO);
                $url = str_replace(":versao",$versao, $url);
    
                // dd($url);
                
                $ch = curl_init();
                curl_setopt_array($ch, array(
                    CURLOPT_URL => $url,
                    CURLOPT_RETURNTRANSFER => true,
                    CURLOPT_TIMEOUT => 30000,
                    CURLOPT_CUSTOMREQUEST => "PUT",
                    CURLOPT_POSTFIELDS => $json,
                    CURLOPT_HTTPHEADER => array(
                        "content-type: application/json",
                        "language: pt_BR",
                        "ticket-sso: $ticketId",
                    ),
                ));
                $response = curl_exec($ch);
                $err = curl_error($ch);
                curl_close($ch);
                $retorno = [
                    'ticket' => $ticketId,
                    'resposta' => json_decode($response),
                ];
                
                // dd($guia, $assunto, $servico, $json, $url, $ticketId, $retorno);
                // dd($retorno["resposta"]->content->processInstanceId);
    
                if(isset($retorno["resposta"]->content->processInstanceId)){
                    $dataAgora = date('Y-m-d H:i:s');
                    foreach ($camposAlterados as $id => $valor) {
                        echo ($valor["campo"]."<br>");
                        $resposta = DB::table('cgm_lecom')->insert(
                            [
                                'cpf'               => Auth::user()->cpf, 
                                'cod_cgm'           => $cgm['cgm']->cgm, 
                                'cod_lecom'         => $retorno["resposta"]->content->processInstanceId, 
                                'campo'             => $valor["campo"], 
                                'valor_anterior'    => $valor["valor_anterior"], 
                                'valor_novo'        => $valor["valor_novo"], 
                                'data_solicitacao'  => $dataAgora,
                                'status'            => false
                            ]
                        );
                    }
                    return back()->with('status', 1);
                }
                else{
                    return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: CGM_004' ]);
                }
    
            }

        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: INT_1001' ]);
        }
    }

    public function cgm_endereco_correspondencia (Request $request){
        // dd($request);

        $codMunicipio = "";
        $descrMunicipio = "";

        if($request->morador == 0){
            // Morador do Município

            $codEstado = "19";
            $descrEstado = "RIO DE JANEIRO";
            $codMunicipio = "5474";
            $descrMunicipio = "MARICA";

            $cgmBairros = $this->recuperaBairrosCGM($codEstado,$codMunicipio);

            if($cgmBairros['error']){
                return view('site.usuario_falha_integracao');
            }

            // dd($cgmBairros['bairros']->aBairrosEncontradas);

            $codbairro = "";
            $descrBairro = strtoupper($request->district);

            foreach ($cgmBairros['bairros']->aBairrosEncontradas as $id => $valor) {
                // echo strtolower(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao))))."<br>";
                if (strtolower($request->district) == $valor->iBairro ){
                    $codbairro = $valor->iBairro;
                    $descrBairro = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao)));
                    break;
                }
            }

            // dd($codbairro, $descrBairro);

            $codRua = "";
            $descrRua = strtoupper($request->address);
            if($codbairro != ""){
                $cgmRuas = $this->recuperaRuasCGM($codEstado,$codMunicipio,$codbairro);
                if($cgmRuas['error']){
                    return view('site.usuario_falha_integracao');
                }
                // dd($cgmRuas['ruas']->aRuasEncontradas);

                foreach ($cgmRuas['ruas']->aRuasEncontradas as $id => $valor) {
                    if (strtolower($request->address) == $valor->iRua){
                        $codRua = $valor->iRua;
                        $descrRua = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->sDescricao)));
                        break;
                    }
                }
                // dd($codRua, $descrRua);
            }

        }
        else{
            // Não é morador do Município
            $cgmMunicipios = $this->recuperaMunicipiosCGM($request->ufCod);
            if($cgmMunicipios['error']){
                return view('site.usuario_falha_integracao');
            }

            $codEstado = $request->ufCod;
            if(isset($cgmMunicipios['municipios']->oMunicipio)){
                foreach ($cgmMunicipios['municipios']->oMunicipio as $id => $valor) {
                    if (strtolower($request->city) == strtolower(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->descricao))) )){
                        if($valor->codigo !== "5474"){
                            $codMunicipio = $valor->codigo;
                            $descrMunicipio = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $valor->descricao)));
                            break;
                        }
                    }
                }
            }
            else{
                $codMunicipio = "";
                $descrMunicipio = strtoupper($request->city);
            }
            if($descrMunicipio == "" ){
                $codMunicipio = "";
                $descrMunicipio = "";
            }
    
            $codbairro = "";
            $descrBairro = strtoupper($request->district);
            $codRua = "";
            $descrRua = strtoupper($request->address);
        }



        try {

            // dd($request);
            // Atualizando endereço...
            $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
            $cpfUsuario = str_replace("-", "",  $cpfUsuario);
            $cpfUsuario = str_replace("/", "",  $cpfUsuario);
            $cpfUsuario = str_replace(" ", "",  $cpfUsuario);
            
            $cepUsuario = str_replace(".", "",  $request->cep);
            $cepUsuario = str_replace("-", "",  $cepUsuario);

            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                 => API_ATUALIZA_ENDERECO_CGM,
                'sCpfcnpj'              => $cpfUsuario,
                'iMunicipio'            => $request->morador,
                'sTipoEndereco'         => "S",
                'iCodigoEstado'         => $codEstado,
                'iCodigoMunicipio'      => $codMunicipio,
                'sDescMunicipio'        => $descrMunicipio,
                'iCodBairro'            => $codbairro,
                'sDescBairro'           => $descrBairro,
                'iCodRua'               => $codRua,
                'sDescRua'              => $descrRua,
                'sNumeroLocal'          => $request->number,
                'sDescricaoComplemento' => $request->complement,
                'sCep'                  => $cepUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            
            $data_string = ['json'=>$json_data];

            // dd( $data_string );
            
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


            $resposta = json_decode($response);
            // dd(API_URL . API_CGM, $data_string, $resposta, $response);
            // dd( utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $resposta->sMessage))) );
            // return back()->with('status', 1);

            if($resposta->iStatus == 1){
                return back()->with('status', 1);
            }
            else{
                $dataAgora = date('Y-m-d H:i:s');
                $r = DB::table('log_erro_api')->insert(
                    [
                        'cpf'       => Auth::user()->cpf, 
                        'data'      => $dataAgora,
                        'url'       => API_URL . API_CGM, 
                        'endpoint'  => json_encode($data_string), 
                        'result'    => json_encode($resposta), 
                    ]
                );

                return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: CGM_003' ]);                
            }

        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: INT_1001' ]);
        }
    }

    public function cgm_valida_email($token){
        // dd($token);

        $resposta = DB::table('cgm_email')
        ->where('token', '=', $token )
        ->get();

        // dd($resposta);

        if (count($resposta) == 0){
            return view('cidadao.falha_integracao', [
                'titulo' => 'CADASTRO DO CIDADÃO', 
                'mensagem' => '<p><strong>Atenção!</strong> </p> Não encontramos o TOKEN informado. <br>Verifique se as informações estão corretas e tente novamente.<br><br>
                Código: CGM_007' 
                ]);
        }
        else if( $resposta[0]->data_confirmacao != null){
            return view('cidadao.falha_integracao', [
                'titulo' => 'CADASTRO DO CIDADÃO', 
                'mensagem' => '<p><strong>Atenção!</strong> </p> Esta solicitação já foi validada.<br><br>
                Código: CGM_008' ]);            
        }
        else{

            try {

                $cpfUsuario = str_replace(".", "", $resposta[0]->cpf);
                $cpfUsuario = str_replace("-", "", $cpfUsuario);
                $cpfUsuario = str_replace("/", "", $cpfUsuario);
                $cpfUsuario = str_replace(" ", "", $cpfUsuario);
            
                $data1 = [
                    'sTokeValiadacao'   => API_TOKEN,
                    'sExec'             => API_ATUALIZA_CGM,
                    'z01_cgccpf'        => $cpfUsuario,
                    'z01_email'         => $resposta[0]->email_novo
                ];

                $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
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
    
                $respostaInt=json_decode($response);

                if($respostaInt->iStatus=== 2){
                    return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong>Não foi possivel gravar as alterações.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: CGM_009' ]);
                }
                else{
                    DB::table('cgm_email')
                    ->where('token', '=', $token )
                    ->update([
                        'data_confirmacao' => date('Y-m-d H:i:s')
                        ]);
    
                    return view('cidadao.sucesso_integracao', [
                        'titulo' => 'CADASTRO DO CIDADÃO', 
                        'mensagem' => '<p><strong>Atenção!</strong> </p> O seu e-mail foi validado com sucesso.<br>Os informes do Portal SIM serão direcionados para este novo e-mail:: <strong>'.$resposta[0]->email_novo.'</strong>' ]);  
                }


            } catch (\Exception $e) {
                // dd($e);
                return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível validar as informações.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1001' ]);
            }
        }
    }

    public function cgm_documentos(Request $request){

        $errors = array();

        // dd($request);

        $request->validate([
            'arquivo'     =>  'required|mimes:jpeg,png,jpg,gif,pdf|max:2048'
        ]);

        // dd ($request);

        // Retorna mime type do arquivo (Exemplo image/png)
        $tipo = $request->arquivo->getMimeType();
        
        // Retorna o nome original do arquivo
        $nomeOriginal = $request->arquivo->getClientOriginalName();
        
        // Extensão do arquivo
        $extensaoOriginal = $request->arquivo->getClientOriginalExtension();
        $extensao = $request->arquivo->extension();
        
        if($extensao != 'jpeg' && $extensao != 'png' && $extensao != 'jpg' && $extensao != 'gif' && $extensao != 'pdf'){
            array_push($errors, "O arquivo deve ser uma imagem ou um pdf (jpeg, png, jpg, gif, pdf)");
        }

        // Tamanho do arquivo
        $tamanhoArquivo = $request->arquivo->getClientSize();
        
        // $path = $request->file('avatar')->store(
            //     'avatars/'.$request->user()->id, 's3'
            // );
            
        $nomeArquivo =  $request->processo."_".$request->descricao.".".$extensao;
        
        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');
        
        if($tamanhoArquivo > 2048000){
            array_push($errors, 'O arquivo deve ter no máximo 2Mb');
        }
        
        if(count($errors)> 0 ){
            return back()->withErrors($errors);
        }
        // dd($request, $tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo, $upload);


        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            $resposta = DB::table('cgm_documentos')->insert(
                [
                    'cpf'               => Auth::user()->cpf, 
                    'cod_lecom'         => $request->processo, 
                    'descricao'         => $request->descricao, 
                    'nome_documento'    => $nomeArquivo, 
                    'data_solicitacao'  => $dataAgora,
                    'status'            => 0,
                ]
            );
            $resposta = DB::connection('lecom')
                ->table('pmm_portal_arquivo')
                ->insert(
                [
                    'COD_PROCESSO'      =>  $request->processo, 
                    'TIPO'              =>  $request->descricao, 
                    'DESCRICAO'         =>  $nomeArquivo, 
                ]
            );
            return back()->with('status', 1);
        }
        else{
            // Erro no upload
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível fazer o upload dos documentos.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1002' ]);
            
        }
    }

    public function cgm_documentos_excluir($id){

        $resultado = DB::table('cgm_documentos')
        ->where('id', '=', $id )
        ->where('cpf', '=', Auth::user()->cpf )
        ->get();

        if(count($resultado)>0){
            // dd($resultado[0]->nome_documento);

            $retorno = Storage::disk('sftp')->delete('documentos/'.$resultado[0]->nome_documento);

            $resultadox = DB::table('cgm_documentos')
            ->where('id', '=', $id )
            ->where('cpf', '=', Auth::user()->cpf )
            ->delete();

            $respostax = DB::connection('lecom')
            ->table('pmm_portal_arquivo')
            ->where('COD_PROCESSO', '=', $resultado[0]->cod_lecom )
            ->where('DESCRICAO', '=',$resultado[0]->nome_documento)
            ->delete();
        }

        return back()->with('status', 1);
    }

    private function ticketSSO(){
        $data1 = [
            'user' => USUARIO,
            'pass' => SENHA,
        ];
        $data_string = json_encode($data1, JSON_UNESCAPED_UNICODE);
        
        $ch = curl_init();
        
        curl_setopt_array($ch, array(
            CURLOPT_URL => SISTEMACAMINHOBASE."/".CAMINHORELATIVO,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $data_string,
            CURLOPT_HTTPHEADER => array(
                "content-type: application/json",
                'Content-Length: ' . strlen($data_string)
            ),
        ));
        if( USAR_SSL ){
            curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_LECOM);
        }
        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return $response;
    }

    public function retornaEstadoCivil($id){
        switch ($id) {
            case '1':
                return "Solteiro";
                break;
            case '2':
                return "Casado";
                break;
            case '3':
                return "Viúvo";
                break;
            case '4':
                return "Divorciado";
                break;
            case '5':
                return ">Separado Consensual";
                break;
            case '6':
                return "Separado Judicial";
                break;
            case '7':
                return "União Estavel";
                break;
            default:
                return "";
                break;
        }
    }

    public function retornaSexo($id){
        switch ($id) {
            case 'M':
                return "Masculino";
                break;
            case 'F':
                return "Feminino";
                break;
            
            default:
                return "Masculino";
                break;
        }
    }

    public function retornaNacionalidade($id){
        switch ($id) {
            case '1':
                return "Brasileira";
                break;
            case '2':
                return "Estrangeira";
                break;
            
            default:
                return "Brasileira";
                break;
        }
    }

    public function retornaEscolaridade($id){
        switch ($id) {
            case '0':
                return "SEM DEFINIÇÃO";
                break;
            case '1':
                return "ANALFABETO";
                break;
            case '2':
                return "FUNDAMENTAL INCOMPLETO";
                break;
            case '3':
                return "FUNDAMENTAL COMPLETO";
                break;
            case '4':
                return "ENSINO MÉDIO INCOMPLETO";
                break;
            case '5':
                return "ENSINO MÉDIO COMPLETO";
                break;
            case '6':
                return "ENSINO SUPERIOR INCOMPLETO";
                break;
            case '7':
                return "ENSINO SUPERIOR COMPLETO";
                break;
            case '8':
                return "MESTRADO";
                break;
            case '9':
                return "DOUTORADO";
                break;
            
            default:
                return "SEM DEFINIÇÃO";
                break;
        }
    }

    public function consultaCEPcgm($id){

        $ch = curl_init();

        curl_setopt_array($ch, array(
            CURLOPT_URL => "https://viacep.com.br/ws/".$id."/json/",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);


        return $response;
    }

    public function converteEstadoSigla($estado){
        $estado = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$estado)));
        $estado = strtoupper($estado);
        switch ($estado) {
            case 'ACRE':
                return "AC";
                break;
            case 'ALAGOAS':
                return "AL";
                break;
            case 'AMAPÁ':
                return "AP";
                break;
            case 'AMAZONAS':
                return "AM";
                break;
            case 'BAHIA':
                return "BA";
                break;
            case 'CEARÁ':
                return "CE";
                break;
            case 'DISTRITO FEDERAL':
                return "DF";
                break;
            case 'ESPÍRITO SANTO':
                return "ES";
                break;
            case 'GOIÁS':
                return "GO";
                break;
            case 'MARANHÃO':
                return "MA";
                break;
            case 'MATO GROSSO':
                return "MT";
                break;
            case 'MATO GROSSO DO SUL':
                return "MS";
                break;
            case 'MINAS GERAIS':
                return "MG";
                break;
            case 'PARÁ':
                return "PA";
                break;
            case 'PARAÍBA':
                return "PB";
                break;
            case 'PERNAMBUCO':
                return "PE";
                break;
            case 'PIAUÍ':
                return "PI";
                break;
            case 'RIO DE JANEIRO':
                return "RJ";
                break;
            case 'RIO GRANDE DO NORTE':
                return "RN";
                break;
            case 'RIO GRANDE DO SUL':
                return "RS";
                break;
            case 'RONDÔNIA':
                return "RO";
                break;
            case 'RORAIMA':
                return "RR";
                break;
            case 'SANTA CATARINA':
                return "SC";
                break;
            case 'SÃO PAULO':
                return "SP";
                break;
            case 'SERGIPE':
                return "SE";
                break;
            case 'TOCANTINS':
                return "TO";
                break;
            
        }
    }
}