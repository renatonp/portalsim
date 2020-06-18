<?php

namespace App\Http\Controllers\Cidadao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Log;
use App\Support\ImovelSupport;
use Auth;
use DB;

class CertidaoController extends Controller
{
    private $properties;
    private $paginator;

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->properties = new ImovelSupport();
        $this->paginator = new \CoffeeCode\Paginator\Paginator();
    }

    public function validaAutenticidade(Request $request) {

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_AUTENTICIDADE_CERTIDAO,
                'i_codigo_barra_cerdidao' => $request->codigo,
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

            $resposta=json_decode($response);

            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>INVÁLIDA</strong> </p>
                <p>O código informado não é valido para nenhuma certidão dos nossos registros ou a validade está expirada.</p>
                <p>Verifique o código informado e tente novamente.</p>
                <p>Caso não consiga confirmar a autenticidade da certidão, digira-se a uma agência do SIM</p>
                Código: CERT_003' ]);
            }
            else {
                return view('cidadao.sucesso_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>CERTIDÃO VÁLIDA</strong> </p>
                <p>O código informado corresponde a uma certidão emitida e dentro do período de validade</p>' ]);

            }
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a autenticidade da certidão.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function certidaoQuitacaoItbi($matricula)
    {
        $suporteImovel = new ImovelSupport();

        $registros = $suporteImovel->listItbiImmobile($matricula);

        return view('cidadao.pesquisa_certidaoitbi', ['registros' => $registros]);
    }

    public function certidaoNegativaImprimir($id) {
        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_IMOVEL_CERTIDAO,
                'i_codigo_maticula' => $id,
                'z01_cgccpf'        => $cpfUsuario,
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

            $resposta=json_decode($response);

            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Este imóvel/matrícula possui débito(s), que impede(m) a emissão da correspondente certidão negativa</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_004' ]);
            }
            else {

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

                if( $_SERVER['HTTP_HOST'] == '2amsolucoes.com.br' || $_SERVER['HTTP_HOST'] == '127.0.0.1' ){
                    $resposta->sUrl = str_replace("https", "http", $resposta->sUrl);
                }

                $tempImage = tempnam(sys_get_temp_dir(), $resposta->sUrl);
                copy($resposta->sUrl, $tempImage);

                $headers = array(
                    'Content-Type: application/pdf',
                    );

                return response()->download($tempImage, $filename[count($filename)-1], $headers);
            }
        } catch (\Exception $e) {

            return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível gerar a certidão deste imóvel.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function certidaoValorVenalImprimir($id) {
        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {

            $data1 = [
                'sNome'  => '$matricula_imovel',
                'sValor' => $id,
            ];
            $data2 = [
                'sNome'  => '$instituicao',
                'sValor' => '',
            ];
            $json_data1 = json_encode($data1, JSON_UNESCAPED_UNICODE);
            $json_data2 = json_encode($data2, JSON_UNESCAPED_UNICODE);

            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'       => API_VALOR_VENAL_CERTIDAO,
                'aParametros' => [$data1,$data2],
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

            $resposta=json_decode($response);

             // Verifica se o imóvel está baixado
             $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_IMOVEL_CERTIDAO,
                'i_codigo_maticula' => $id,
                'z01_cgccpf'        => $cpfUsuario,
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

            $baixa=json_decode($response);

            if($baixa->i_matricula_baixada === 1){ // Baixado
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a certidão deste imóvel.</p>
                <p>O imóvel está baixado e não possui certidão</p>
                <p><b>Código:</b> CERT_001</p>' ]);
            }
            else {
                if($resposta->iStatus === 2){
                    return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a certidão deste imóvel.</p>
                    <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                    <p><b>Código:</b> CERT_008</p>' ]);
                }
                else {

                    if($resposta->iCertidaoGerada !== 1){
                        return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                        "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a certidão deste imóvel.</p>
                        <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                        <p><b>Código:</b> CERT_007</p>' ]);
                    }
                    else {

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

                        if( $_SERVER['HTTP_HOST'] == '2amsolucoes.com.br' || $_SERVER['HTTP_HOST'] == '127.0.0.1' ){
                            $resposta->sUrl = str_replace("https", "http", $resposta->sUrl);
                        }

                        $tempImage = tempnam(sys_get_temp_dir(), $resposta->sUrl);
                        copy($resposta->sUrl, $tempImage);

                        $headers = array(
                            'Content-Type: application/pdf',
                            );

                        return response()->download($tempImage, $filename[count($filename)-1], $headers);
                    }
                }  // Fim Baixado
            }
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível gerar a certidão deste imóvel.</p>
                <p>Tente Novamente em alguns instantes.</p>
                <p><b>Código:</b> INT_1001</p>' ]);
        }
    }

    public function certidaoITBIImprimir($matr, $guia) {
        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                 => API_ITBI_CERTIDAO,
                'i_matricula_imovel'    => $matr,
                'i_itbi_guia'           => $guia,
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

            $resposta=json_decode($response);

            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a certidão deste imóvel.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_005' ]);
            }
            else {

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

                if( $_SERVER['HTTP_HOST'] == '2amsolucoes.com.br' || $_SERVER['HTTP_HOST'] == '127.0.0.1' ){
                    $resposta->sUrl = str_replace("https", "http", $resposta->sUrl);
                }

                $tempImage = tempnam(sys_get_temp_dir(), $resposta->sUrl);
                copy($resposta->sUrl, $tempImage);

                $headers = array(
                    'Content-Type: application/pdf',
                    );

                return response()->download($tempImage, $filename[count($filename)-1], $headers);
            }
        } catch (\Exception $e) {

            return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível gerar a certidão deste imóvel.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function certidaoNumeroPortaImprimir($id) {
        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                 => API_NUMERO_PORTA_CERTIDAO,
                'i_matricula_imovel'    => $id,
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

            $resposta=json_decode($response);

            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a certidão deste imóvel.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_002' ]);
            }
            elseif($resposta->iMatriculaInscBaixada !== 0){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> O imóvel está baixado.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_001' ]);
            }
            else {

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

                if( $_SERVER['HTTP_HOST'] == '2amsolucoes.com.br' || $_SERVER['HTTP_HOST'] == '127.0.0.1' ){
                    $resposta->sUrl = str_replace("https", "http", $resposta->sUrl);
                }

                $tempImage = tempnam(sys_get_temp_dir(), $resposta->sUrl);
                copy($resposta->sUrl, $tempImage);

                $headers = array(
                    'Content-Type: application/pdf',
                );

                return response()->download($tempImage, $filename[count($filename)-1], $headers);
            }
        } catch (\Exception $e) {
            return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível gerar a certidão deste imóvel.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function certidaoITBI(Request $request)
    {
        $document = remove_character_document(Auth::user()->cpf);
        $resposta = $this->properties->listProperties($request->page, $document);

        $this->paginator->pager(
            $resposta->iPaginacao, // total de páginas
            count($resposta->aMatriculasCgmEncontradas), // qtd por página
            isset($request->page) ? $request->page : 1 // página atual
        );

        if($resposta->iStatus === 2){
            if($resposta->iNumeroErro === 201){
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>
                Em breve este serviço estará disponível aqui para você!.</p>
                Código: ERR_API 002' ]);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_006' ]);
            }
        }
        else {
            Log::create([ 'servico'=> 9 , 'descricao' => "Certidão de Quitação de ITBI", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            return view('cidadao.certidaoitbi', [
                'registros' => $resposta,
                'paginator' => $this->paginator->render()
            ]);
        }
    }

    public function certidaoValorVenal(Request $request)
    {
        $document = remove_character_document(Auth::user()->cpf);
        $resposta = $this->properties->listProperties($request->page, $document);

        $this->paginator->pager(
            $resposta->iPaginacao, // total de páginas
            count($resposta->aMatriculasCgmEncontradas), // qtd por página
            isset($request->page) ? $request->page : 1 // página atual
        );

        if($resposta->iStatus === 2){
            if($resposta->iNumeroErro === 201){
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>
                Em breve este serviço estará disponível aqui para você!.</p>
                Código: ERR_API 002' ]);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_006' ]);
            }
        }
        else {
            Log::create([ 'servico'=> 8 , 'descricao' => "Declaração de Valor Venal de Imóvel", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            return view('cidadao.certidaovalorvenal', [
                    'registros' => $resposta,
                    'paginator' => $this->paginator->render()
            ]);
        }
    }

    public function certidaoNegativa(Request $request)
    {
        $document = remove_character_document(Auth::user()->cpf);
        $resposta = $this->properties->listProperties($request->page, $document);

        $this->paginator->pager(
            $resposta->iPaginacao, // total de páginas
            count($resposta->aMatriculasCgmEncontradas), // qtd por página
            isset($request->page) ? $request->page : 1 // página atual
        );

        if($resposta->iStatus === 2){
            if($resposta->iNumeroErro === 201){
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>
                Em breve este serviço estará disponível aqui para você!.</p>
                Código: ERR_API 002' ]);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_006' ]);
            }
        }
        else {
            Log::create([ 'servico'=> 2 , 'descricao' => "Certidão Negativa de Imóveis", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            return view('cidadao.certidaonegativa', [
                'registros' => $resposta,
                'paginator' => $this->paginator->render()
            ]);
        }

    }

    public function certidaoNumeroPorta(Request $request)
    {
        $document = remove_character_document(Auth::user()->cpf);
        $resposta = $this->properties->listProperties($request->page, $document);

        $this->paginator->pager(
            $resposta->iPaginacao, // total de páginas
            count($resposta->aMatriculasCgmEncontradas), // qtd por página
            isset($request->page) ? $request->page : 1 // página atual
        );

        if($resposta->iStatus === 2){
            if($resposta->iNumeroErro === 201){
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>
                Em breve este serviço estará disponível aqui para você!.</p>
                Código: ERR_API 002' ]);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: CERT_006' ]);
            }
        }
        else {
            Log::create([ 'servico'=> 10 , 'descricao' => "Certidão de Numeração Predial Oficial", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);

            return view('cidadao.certidaonumeroporta', [
                'registros' => $resposta,
                'paginator' => $this->paginator->render()
            ]);
        }

    }
}
