<?php

namespace App\Http\Controllers\Cidadao;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Site\HomeController;
use Illuminate\Support\Facades\Mail;
use App\Mail\ValidaEmail;
use App\Models\Log;
use App\User;
use Auth;
use DB;

class TaxasController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        ini_set('max_execution_time', 60);
    }

    public function boletosTaxas(){
        $resposta = $this->listaGrupoTaxas();

        if($resposta->iStatus === 2){
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
            <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
            Código: TAX_001' ]);
        }
        else {
            // dd($resposta);

            Log::create([ 'servico'=> 12 , 'descricao' => "Boletos de Taxas", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            return view('taxas.boletostaxas', ['registros' => $resposta ] );
        }
    }

    public function taxasconsultacgm($cpf){

        $cpfUsuario = str_replace(".", "", $cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("_", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_CGM_CONSULTA,
                'z01_cgccpf'    => $cpfUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            

            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_CONSULTA,
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


// dd(API_URL . API_CONSULTA, $data_string, $response );

            return $response;

            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível consultar as informações do boleto.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function taxasconsultainscricao($cpf){

        $cpfUsuario = str_replace(".", "", $cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        $cpfUsuario = str_replace("_", "", $cpfUsuario);

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_LISTA_INSCRICAO_TAXAS,
                'i_cpfcnpj'    => $cpfUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            

            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_MOVEL,
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

            // dd($data_string, $response);
            return $response;

            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível consultar as informações do boleto.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }

    }

    public function emitirboletotaxa(Request $request){

        // dd($request);

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf );
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        $grupo = explode("|", $request->grupo);
        $data = explode("/", $request->data);
        try {
            // $data1 = [
            //     'sTokeValiadacao'   => API_TOKEN,
            //     'sExec'             => API_EMITIR_BOLETO_TAXAS,
            //     'i_cpfcnpj'         => '23987634715',
            //     'i_grupo_taxa'      => '1',
            //     'i_codigo_pesquisa' => '115288',
            //     's_tipo_pesquisa'   => 'm',
            //     'd_data_vencimento' => '2019-11-25',
            //     't_historico'       => "Wilker Teste",
            // ];
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_EMITIR_BOLETO_TAXAS,
                'i_cpfcnpj'         => $cpfUsuario,
                'i_grupo_taxa'      => $grupo[0],
                'i_codigo_pesquisa' => $request->inscricao,
                's_tipo_pesquisa'   => $grupo[1],
                'd_data_vencimento' => $data[2]."-".$data[1]."-".$data[0],
                't_historico'       => $request->historico==null?"":$request->historico,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            

            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_TAXAS,
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


            // dd(API_URL . API_TAXAS, $data_string, $resposta);

            if($resposta->iStatus === 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar o boleto deste serviço.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: TAX_002' ]);
            }
            else {
                // dd($resposta);
    
                // return view('cidadao.certidaonegativa', ['registros' => $resposta ] );
                                				
				stream_context_set_default([
                    'ssl' => [
                        'verify_peer' => SSL_API_VERIFICA,
                        'verify_peer_name' => SSL_API_VERIFICA,
                    ]
                ]);

                if( $_SERVER['HTTP_HOST'] == 'ticmarica.com.br' || $_SERVER['HTTP_HOST'] == '127.0.0.1' || $_SERVER['HTTP_HOST'] == '2amsolucoes.com.br' ){
                    $resposta->sUrl = str_replace('https:', 'http:', $resposta->sUrl);
                }
                
                $filename = explode("/", $resposta->sUrl);

                $tempImage = tempnam(sys_get_temp_dir(), $filename[count($filename)-1]);
                copy($resposta->sUrl, $tempImage);

                $headers = array(
                    'Content-Type: application/pdf',
                    );

                return response()->download($tempImage, $filename[count($filename)-1], $headers);
            }

            
        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível consultar as informações do boleto.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }

    }


    public function taxasconsultamatricula($cpf, $matricula = ""){

        $cpfUsuario = str_replace(".", "", $cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("_", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_MATRICULA_CONSULTA,
                'i_cpfcnpj'     => $cpfUsuario,
            ];
            if( $matricula !=="" ){
                $data1 = array_merge($data1, array('i_codigo_maticula' => $matricula));
            }
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            

            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL             => API_URL . API_IMOVEL,
                CURLOPT_RETURNTRANSFER  => true,
                CURLOPT_TIMEOUT         => 30000,
                CURLOPT_CUSTOMREQUEST   => "POST",
                CURLOPT_POSTFIELDS      => http_build_query($data_string),
                CURLOPT_HTTPHEADER      => array(
                    'Content-Length: ' . strlen(http_build_query($data_string))
                ),
            ));
            $response = curl_exec($ch);
            $err = curl_error($ch);
            curl_close($ch);

            // dd(API_URL . API_IMOVEL, $data_string, $response);
            return $response;

            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível consultar as informações do boleto.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }

    }

    public function taxasconsultavalor($tipo, $valor, $grupo){

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_VALOR_TAXAS,
                's_tipo_pesquisa' => $tipo,
                'i_tipo_pesquisa' => $valor,
                'i_grupo_taxa'    => $grupo,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            

            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_TAXAS,
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

            // dd($data_string, $response);
            return $response;

            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível consultar as informações do boleto.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }

    }
 
    public function listaImoveis($cpf){

        $cpfUsuario = str_replace(".", "", $cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_LISTA_IMOVEIS_CERTIDAO,
                'z01_cgccpf'    => $cpfUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_CERTIDAO,
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

            return json_decode($response);

            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }


    public function listaGrupoTaxas(){

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_GRUPO_TAXAS,
                'i_cpfcnpj'     => $cpfUsuario,
            ];
            $json_data = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_TAXAS,
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

            // dd(API_URL . API_TAXAS, $data_string, $response);


            return json_decode($response);
            
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Boletos de Taxas', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação de taxas disponíveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }
}