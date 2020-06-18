<?php

namespace App\Http\Controllers\Cidadao;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Models\Log;
use App\User;
use Auth;
use DB;


class ItbiController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function lancamentoITBI(){
        $resposta = $this->listaImoveis(Auth::user()->cpf);

        if($resposta->iStatus === 2){
            if($resposta->iNumeroErro === 201){
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>
                Em breve este serviço estará disponível aqui para você!.</p>
                Código: ERR_API 002' ]);
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>
                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                Código: IMOVEL_002' ]);
            }            
        }
        else {
            Log::create([ 'servico'=> 11 , 'descricao' => "Lançamento de ITBI", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            $arrBaixa = [];
            // foreach ($resposta->aMatriculasListaCertidaoEncontradas as $key => $value) {
            //     $baixa = $this->imovelbaixado( $value->matricula );
            //     array_push($arrBaixa, ["matricula" =>  $value->matricula, "baixado" => $baixa->i_matricula_baixada] );
            // }
            return view('itbi.consultaimoveis', ['registros' => $resposta, 'baixados' => $arrBaixa ] );
        }
    }

    public function itbitransacao($id){
        // dd($id);

        $transacoes = $this->listaTrasacoes();
        $dadosImovel = $this->listaImovelITBI($id);
        $dadosImovel2 = $this->listaImovelImovel($id);
        $pendencias = $this->listapendenciasImovel($id);
        $transmitentePrincipal = $this->itbiconsultaCGM(Auth::user()->cpf);

        // dd(json_decode($transmitentePrincipal), $dadosImovel2, $dadosImovel);

        return view('itbi.lancamento', [
            'dadosImovel' => $dadosImovel, 
            'dadosImovel2' => $dadosImovel2, 
            'transacoes'=> $transacoes, 
            'pendencias'=> $pendencias, 
            'transmitentePrincipal' => json_decode($transmitentePrincipal),
            'edicao'=> false
            ]);
    }

     public function editarItbi($chamado){

        $dadosTransacao = DB::connection('lecom')
            ->table('v_exigencias_itbi')
            ->where('COD_PROCESSO', '=', $chamado )
            ->get();

        // dd($dadosTransacao);

        if(count($dadosTransacao)> 0){

            $transacaoExistente = DB::table('itbi_exigencias')
            ->where('processo', '=', $chamado )
            ->where('etapa', '=', $dadosTransacao[0]->COD_ETAPA_ATUAL )
            ->where('ciclo', '=', $dadosTransacao[0]->COD_CICLO_ATUAL )
            ->get();

            if(count($transacaoExistente) == 0){
                
                if($dadosTransacao[0]->MAT_IMOVEL > 0){

                    // dd($dadosTransacao[0]);

                    $processoResposndido = DB::connection('lecom')
                    ->table('v_exigencias_itbi')
                    ->where('COD_PROCESSO', '=', $chamado )
                    ->get();

                    $transacoes = $this->listaTrasacoes();
                    $dadosImovel = $this->listaImovelITBI($dadosTransacao[0]->MAT_IMOVEL);
                    $dadosImovel2 = $this->listaImovelImovel($dadosTransacao[0]->MAT_IMOVEL);
                    $pendencias = $this->listapendenciasImovel($dadosTransacao[0]->MAT_IMOVEL);
                    $transmitentePrincipal = $this->itbiconsultaCGM(Auth::user()->cpf);

                    // dd(json_decode($transmitentePrincipal), $dadosImovel2, $dadosImovel);

                    return view('itbi.lancamento', [
                        'dadosImovel' => $dadosImovel, 
                        'dadosImovel2' => $dadosImovel2, 
                        'transacoes'=> $transacoes, 
                        'pendencias'=> $pendencias, 
                        'transmitentePrincipal' => json_decode($transmitentePrincipal), 
                        'dadosTransacao' => $dadosTransacao,
                        'edicao'=> true
                    ]);
                }
                else{
                    return view('cidadao.falha_integracao', [
                        'titulo' => 'Imóvel', 
                        "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações do seu processo.</p>
                        <p>Entre em contato com o SIM.</p>
                        Código: ITBI_007' ]);
                }
            }
            else{
                return view('cidadao.falha_integracao', [
                    'titulo' => 'Imóvel', 
                    "mensagem" => '<p><strong>Atenção!</strong> Você já respondeu a este processo.  Aguarde a próxima etapa.</p>
                    Código: ITBI_008' ]);
            }
        }
        else{
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações do seu processo.</p>
                <p>Entre em contato com o SIM.</p>
                Código: ITBI_003' ]);
        }
     }
     
    public function baixarguiaitbi($chamado){
        $registros = DB::connection('lecom')
            ->table('v_guias_itbi')
            ->where('PROCESSO', '=', $chamado )
            ->get();

        // dd($registros);
        if(count($registros)>0){
            $primeiroEnvio=true;
            try {
                erroAPI:
                if($primeiroEnvio){
                    $reemissao="false";
                }
                else{
                    $reemissao="true";
                }

                $data1 = [
                    'sTokeValiadacao'   => API_TOKEN,
                    'sExec'         => API_GUIA_ITBI,
                    'i_itbi_guia'   => $registros[0]->PROT_NUM_GUIA,
                    'b_reemissao'   =>  $reemissao,
                ];
                $json_data = json_encode($data1);
                $data_string = ['json'=>$json_data];
                
                $ch = curl_init();
            
                curl_setopt_array($ch, array(
                    CURLOPT_URL => API_URL . API_ITBI,
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
                
                // dd($data1, utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$response))));
                
                $resposta=json_decode($response);

                if($resposta->iStatus=== 2){
                    if ($primeiroEnvio){
                        $primeiroEnvio=false;
                        goto erroAPI;
                    }
                    return view('cidadao.falha_integracao', ['titulo' => 'LANÇAMENTO ITBI', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi foi possível gerar a guia de ITBI deste imóvel.</p>
                    <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>
                    Código: ITBI_005' ]);
                }
                else {
                    // dd($resposta);
                    
                    stream_context_set_default([
                        'ssl' => [
                            'verify_peer' => SSL_API_VERIFICA,
                            'verify_peer_name' => SSL_API_VERIFICA,
                        ]
                    ]);

                    $filename = explode("/", $resposta->sUrl);

                    $tempImage = tempnam(sys_get_temp_dir(), $filename[count($filename)-1]);
                    copy($resposta->sUrl, $tempImage);

                    $headers = array(
                        'Content-Type: application/pdf',
                        );

                    return response()->download($tempImage, $filename[count($filename)-1], $headers);
                }

                
            } 
            catch (\Exception $e) {
                // dd($e);
                return view('cidadao.falha_integracao', ['titulo' => 'LANCAMENTO ITBI', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível efetuar o download da sua guia de ITBI.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: ITBI_004' ]);
            }   
        }
        else{
            return view('cidadao.falha_integracao', ['titulo' => 'LANCAMENTO ITBI', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível efetuar o download da sua guia de ITBI.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: ITBI_006' ]);

        }

    }


    public function itbi_documentos_transacao(Request $request){
        
        // dd($request);
        
        $errors = array();

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

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        $nomeArquivo = "transacao_" . $cpfUsuario . "_". str_replace(" ", "_", $request->descricaoTransacao) . "_" . uniqid() . ".".$extensao;
        
        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');
        
        // dd($upload);


        if($tamanhoArquivo > 2048000){
            array_push($errors, 'O arquivo deve ter no máximo 2Mb');
        }
        
        if(count($errors)> 0 ){
            return back()->withErrors($errors);
        }
        // dd($request, $tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo, $upload);


        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            
            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->descricaoTransacao , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);
        }
        else{
            // Erro no upload
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível fazer o upload dos documentos.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1002' ]);
            
        }
    }

    public function itbi_documentos_transmitente(Request $request){
        
        // dd($request);
        
        $errors = array();

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

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        $nomeArquivo = "transmitente_" . $cpfUsuario . "_". str_replace(" ", "_", $request->descricao) . "_" . uniqid() . ".".$extensao;
        
        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');
        
        // dd($upload);


        if($tamanhoArquivo > 2048000){
            array_push($errors, 'O arquivo deve ter no máximo 2Mb');
        }
        
        if(count($errors)> 0 ){
            return back()->withErrors($errors);
        }
        // dd($request, $tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo, $upload);


        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            
            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->descricao , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);
        }
        else{
            // Erro no upload
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível fazer o upload dos documentos.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1002' ]);
            
        }
    }

    public function itbi_documentos_adquirente(Request $request){

        $errors = array();

        //  dd($request);

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

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        $nomeArquivo = "adquirente_" . $cpfUsuario . "_". str_replace(" ", "_", $request->descricao) . "_" . uniqid() . ".".$extensao;
        
        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');
        
        // dd($upload);


        if($tamanhoArquivo > 2048000){
            array_push($errors, 'O arquivo deve ter no máximo 2Mb');
        }
        
        if(count($errors)> 0 ){
            return back()->withErrors($errors);
        }
        // dd($request, $tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo, $upload);


        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            
            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->descricao , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);
        }
        else{
            // Erro no upload
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível fazer o upload dos documentos.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1002' ]);
            
        }
    }

    public function itbi_documentos_imovel(Request $request){

        $errors = array();

        //  dd($request);

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

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);


        $nomeArquivo = "imovel_" . $cpfUsuario . "_". str_replace(" ", "_",$request->descricao) . "_" . uniqid() . ".".$extensao;
        
        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');
        
        // dd($upload);


        if($tamanhoArquivo > 2048000){
            array_push($errors, 'O arquivo deve ter no máximo 2Mb');
        }
        
        if(count($errors)> 0 ){
            return back()->withErrors($errors);
        }
        // dd($request, $tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo, $upload);


        if($upload){

            $dataAgora = date('Y-m-d H:i:s');
            
            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->descricao , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);
        }
        else{
            // Erro no upload
            return view('cidadao.falha_integracao', ['titulo' => 'CADASTRO DO CIDADÃO', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível fazer o upload dos documentos.</p>
                    <p>Tente Novamente em alguns instantes.</p>
                    Código: INT_1002' ]);
            
        }
    }

    public function itbi_documentos_remove($arquivo){

        $retorno = Storage::disk('sftp')->delete('documentos/'.$arquivo);

        return (['status', 1]);
    }












    public function listaImoveis($cpf){

        $cpfUsuario = str_replace(".", "", $cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        try {
            $data1 = [
                'sExec'             => API_MATRICULA_CONSULTA,
                'i_cpfcnpj'         => $cpfUsuario,
                'sTokeValiadacao'   => API_TOKEN,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_IMOVEL,
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

            // dd(API_URL . API_IMOVEL,  $data_string,  $response);

            return json_decode($response);

            
        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function listaImovelITBI($matricula){

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_IMOVEL_ITBI,
                'i_codigo_maticula'    => $matricula,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_ITBI,
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

            // dd(API_URL . API_ITBI, $data_string, $response);

            return json_decode($response);

            
        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function listaImovelImovel($matricula){

        try {
            $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
            $cpfUsuario = str_replace("-", "", $cpfUsuario);
            $cpfUsuario = str_replace("/", "", $cpfUsuario);
            $cpfUsuario = str_replace(" ", "", $cpfUsuario);

            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_CONSULTA_IMOVEL,
                'i_codigo_maticula' => $matricula,
                'i_cpfcnpj'         => $cpfUsuario,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_IMOVEL,
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

            return json_decode(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $response))));

            
        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', [
                'titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function listaTrasacoes(){
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'         => API_TRANSACAO_ITBI,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_ITBI,
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
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function listaFormasPagamento($transacao, $matricula){

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                 => API_FPGTO_ITBI,
                'i_codigo_transacao'    => $transacao,
                'i_codigo_maticula'     => $matricula,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_ITBI,
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

            return (utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$response))));

        } catch (\Exception $e) {
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar as formas de Pagamento.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function listapendenciasImovel($matricula){

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_DIVIDAS_ITBI,
                'i_codigo_maticula' => $matricula,
            ];
            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];
            
            $ch = curl_init();
        
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_ITBI,
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
            // dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function imovelbaixado($matricula){
        // Verifica se o imóvel está baixado
        
       $cpfUsuario = str_replace(".", "", Auth::user()->cpf);
       $cpfUsuario = str_replace("-", "", $cpfUsuario);
       $cpfUsuario = str_replace("/", "", $cpfUsuario);
       $cpfUsuario = str_replace(" ", "", $cpfUsuario);
       try {
        
           $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'             => API_IMOVEL_CERTIDAO,
                'i_codigo_maticula' => $matricula,
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

           return json_decode($response);

       } catch (\Exception $e) {
            // dd($e);
           return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
               "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
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
            'sExec'         => API_CONSULTA_ENDERECO_CGM,
            'sCpfcnpj'      => $cpfUsuario,
            'sTipoEndereco' => $tipo,
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

public function itbiconsultaCGM($cpf){
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

        $userCGM = json_decode(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$response))));


        // Recuperando dados do Endereço...
        $data1 = [
            'sTokeValiadacao'   => API_TOKEN,
            'sExec'         => API_CONSULTA_ENDERECO_CGM,
            'sCpfcnpj'      => $cpfUsuario,
            'sTipoEndereco' => "P",
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

        $enderecoCGM = json_decode(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$response))));

        $retorno = [
            'error'         => false,
            'cgm'           => $userCGM,
            'endereco'      => $enderecoCGM
        ];
        return json_encode($retorno)  ;

    } catch (\Exception $e) {
        $retorno = [
            'error'         => true
        ];
        return json_encode($retorno) ;
    }
}

public function itbi_lancar(request $request){
    // dd($request);
    try {

        $txtdocumentosTransacao = explode("|", $request->txtdocumentosTransacao);
        $documentosTransacaoFinal = "";
        foreach ($txtdocumentosTransacao as &$value) {
            if(strlen($documentosTransacaoFinal)>0){
                $documentosTransacaoFinal .= ";";
            }        
            $value = str_replace("[", "", $value);
            $value = str_replace("]", "", $value);
            $value = str_replace("\"", "", $value);
            $valueArray = explode(",", $value);
			if(count($valueArray) >1){
				array_pop($valueArray); 
				$documentosTransacaoFinal .= $valueArray[2].";". $valueArray[0]; 
				// dd( $valueArray);
			}
        }
        // dd( $documentosTransacaoFinal);
        
        if(!$request->edicao){
        
            $adquirentes = explode("|", $request->adquirentes);

            $adquirentesFinal = "";
            foreach ($adquirentes as &$value) {
                if(strlen($adquirentesFinal)>0){
                    $adquirentesFinal .= ";";
                }
                $value = str_replace("[", "", $value);
                $value = str_replace("]", "", $value);
                $value = str_replace("\"", "", $value);
                $valueArray = explode(",", $value);
                if(count($valueArray) >1){
                    array_pop($valueArray);
                    $adquirentesFinal .= implode(";", $valueArray);
                    // dd( $valueArray);
                }
            }
            // dd( $adquirentesFinal );

            $documentosAdquirentes = explode("|", $request->documentosAdquirentes);
            $documentosAdquirentesFinal = "";
            foreach ($documentosAdquirentes as &$value) {
                if(strlen($documentosAdquirentesFinal)>0){
                    $documentosAdquirentesFinal .= ";";
                }
                $value = str_replace("[", "", $value);
                $value = str_replace("]", "", $value);
                $value = str_replace("\"", "", $value);
                $valueArray = explode(",", $value);
                if(count($valueArray) >1){
                    array_pop($valueArray);
                    $documentosAdquirentesFinal .= $valueArray[2] .";".$valueArray[0];
                    // dd( $valueArray);
                }
            }
            // dd( $documentosAdquirentesFinal);
    
    
            $transmitentes = explode("|", $request->transmitentes);
            $transmitentesFinal = "";
            foreach ($transmitentes as &$value) {
                if(strlen($transmitentesFinal)>0){
                    $transmitentesFinal .= ";";
                }
                $value = str_replace("[", "", $value);
                $value = str_replace("]", "", $value);
                $value = str_replace("\"", "", $value);
                $valueArray = explode(",", $value);
                $transmitentesFinal .= implode(";", $valueArray); 
                // dd( $valueArray);
            }
            // dd( $transmitentesFinal );
    
            $documentosTransmitentes = explode("|", $request->documentostransmitentes);
            $documentosTransmitentesFinal = "";
            foreach ($documentosTransmitentes as &$value) {
                if(strlen($documentosTransmitentesFinal)>0){
                    $documentosTransmitentesFinal .= ";";
                }        
                $value = str_replace("[", "", $value);
                $value = str_replace("]", "", $value);
                $value = str_replace("\"", "", $value);
                $valueArray = explode(",", $value);
                if(count($valueArray) >1){
                    array_pop($valueArray);
                    $documentosTransmitentesFinal .= $valueArray[2].";". $valueArray[0]; 
                    // dd( $valueArray);
                }
            }
            // dd( $documentosTransmitentesFinal);

            $txtdocumentosimovel = explode("|", $request->txtdocumentosimovel);
            $documentosImovelFinal = "";
            foreach ($txtdocumentosimovel as &$value) {
                if(strlen($documentosImovelFinal)>0){
                    $documentosImovelFinal .= ";";
                }        
                $value = str_replace("[", "", $value);
                $value = str_replace("]", "", $value);
                $value = str_replace("\"", "", $value);
                $valueArray = explode(",", $value);
                if(count($valueArray) >1){
                    array_pop($valueArray);
                    $documentosImovelFinal .= $valueArray[2].";". $valueArray[0]; 
                    // dd( $valueArray);
                }
            }
            // dd( $documentosImovelFinal);
            
            //dd($adquirentes,$documentosAdquirentes,$transmitentes,$documentostransmitentes,$txtdocumentosTransacao);
                
            // dd(strlen(Auth::user()->cpf));

            if (strlen(Auth::user()->cpf) <= 14 ){
                $guia = "Cidadão";
            }
            else {
                $guia = "Empresa";
            }
            $assunto = "Imóvel";
            $servico = "Solicitação de ITBI";
            
            
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=', $guia )
            ->where('assunto', '=', $assunto )
            ->where('servico', '=', $servico )
            ->get();

            $ticket = json_decode($this->ticketSSO());
            foreach ( $ticket as $ticketId ){
            }   

            // dd($serv);
            $processo = $serv[0]->processo;
            $versao = $serv[0]->versao;
            $json = $serv[0]->json;

            $json = str_replace("[tipo]", $request->tipo , $json);
            $json = str_replace("[caracteristica]", $request->caracteristica , $json);
            $json = str_replace("[matricula]", $request->matricula , $json);
            $json = str_replace("[bairro]", $request->bairro , $json);
            $json = str_replace("[quadra]", $request->quadra , $json);
            $json = str_replace("[situacao]", $request->situacao , $json);
            $json = str_replace("[lote]", $request->lote , $json);
            $json = str_replace("[area_terreno]", $request->areaTotal , $json);
            $json = str_replace("[numero]", $request->numero , $json);
            $json = str_replace("[rua]", $request->rua , $json);
            $json = str_replace("[complemento]", $request->complemento , $json);
            
            $json = str_replace("[area_privativa]", ($request->areaConstruida*1) , $json);
            $json = str_replace("[fracao]", $request->percentual , $json);

            $json = str_replace("[anexo_imovel]", $documentosImovelFinal , $json);
            
            $json = str_replace("[dadosadquirente]",  $adquirentesFinal , $json);
            $json = str_replace("[anexo_adqt]", $documentosAdquirentesFinal , $json);
            
            $json = str_replace("[dadostramitente]", $transmitentesFinal , $json);
            $json = str_replace("[anexo_tmt]", $documentosTransmitentesFinal , $json);
            
            $json = str_replace("[trans_parcial]", $request->cadtransacaoParcial==null?"":"TRUE" , $json);
            $json = str_replace("[tipo_transacao]", $request->cadtransacao , $json);
            $json = str_replace("[natureza]", $request->cadnatureza , $json);
            $json = str_replace("[numero_guia]", $request->cadnumGuia , $json);
            $json = str_replace("[percentual]", $request->cadpercentualTransferido , $json);

            $valor = str_replace(".", "", $request->cadvalorDeclarado);
            $valor = str_replace(",", ".", $valor);
            $json = str_replace("[vlr_declarado]",  $valor , $json);

            $valor = str_replace(".", "", $request->cadvalorFinanciado);
            $valor = str_replace(",", ".", $valor);
            $json = str_replace("[vlr_financiado]", $valor , $json);

            $json = str_replace("[anexo_operacao]", $documentosTransacaoFinal , $json);
            
            $json = str_replace("[responsavel]", "Transmitente", $json);
            $json = str_replace("[nome]",  Auth::user()->name, $json);
            $json = str_replace("[cpfoucnpj]",  Auth::user()->cpf, $json);
            
            $json = str_replace("[lote_condominio]", "" , $json);
            $json = str_replace("[possui_debito]", $request->debito , $json);

            $json = str_replace("[it01_mail]", $request->it01_mail , $json);
            $json = str_replace("[it01_obs]", $request->it01_obs , $json);
            $json = str_replace("[it01_areatrans]", $request->areaTransmitida , $json);
            $json = str_replace("[it05_direito]", $request->ladoDireito , $json);
            $json = str_replace("[it05_esquerdo]", $request->ladoEsquerdo , $json);
            $json = str_replace("[it05_frente]", $request->frente , $json);
            $json = str_replace("[it05_fundos]", $request->fundos , $json);
            $json = str_replace("[it29_setorloc]", ($request->it29_setorloc==""?1:$request->it29_setorloc) , $json);
            $json = str_replace("[it22_matricri]", $request->matricula , $json);
            $json = str_replace("[it22_quadrari]", $request->quadra , $json);
            $json = str_replace("[it22_loteri]", $request->lote , $json);
            $json = str_replace("[it22_setor]", $request->setor , $json);
            $json = str_replace("[it01_valortransacao]", ($request->it01_valortransacao==""?1:$request->it01_valortransacao) , $json);
            $json = str_replace("[it01_valorterreno]", ($request->it01_valorterreno==""?1:$request->it01_valorterreno) , $json);
            $json = str_replace("[it01_valorconstr]", ($request->it01_valorconstr==""?1:$request->it01_valorconstr) , $json);

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

            // dd( $processo, $versao, $url, $json, $retorno);

        }
        else{ 

            //dd( $request );

            $dadosTransacao = DB::connection('lecom')
                ->table('v_exigencias_itbi')
                ->where('COD_PROCESSO', '=', $request->processo )
                ->where('COD_ETAPA_ATUAL', '=', $request->etapa )
                ->where('COD_CICLO_ATUAL', '=', $request->ciclo )                
                ->get();
        
            //  dd($dadosTransacao);

            if(count($dadosTransacao)> 0){

                $valorTransacao = str_replace(".", "", $request->cadvalorDeclarado);
                $valorTransacao = str_replace(",", ".", $valorTransacao);

                $totalExigencias = DB::connection('lecom')
                ->table('pmm_cumprir_exigencia_itbi')
                ->where('PROCESSO', '=', $request->processo )
                ->where('ETAPA', '=', $request->etapa )
                ->where('CICLO', '=', $request->ciclo )
                ->get();

                // dd(count($totalExigencias));

                if(count($totalExigencias)==0){
                    DB::connection('lecom')
                        ->table('pmm_cumprir_exigencia_itbi')->insert(
                        [
                            'PROCESSO'          => $dadosTransacao[0]->COD_PROCESSO, 
                            'ETAPA'             => $dadosTransacao[0]->COD_ETAPA_ATUAL, 
                            'CICLO'             => $dadosTransacao[0]->COD_CICLO_ATUAL, 
                            'TRANS_PARC'        => $dadosTransacao[0]->TRANS_PARC==$request->cadtransacaoParcial?"":$request->cadtransacaoParcial, 
                            'TIPO_TRANSACAO'    => $dadosTransacao[0]->TIPO_TRANSACAO==$request->cadtransacao?"":$request->cadtransacao, 
                            'PERCENT_TRANSF'    => $dadosTransacao[0]->PERCENT_TRANSF==$request->cadpercentualTransferido?"0":$request->cadpercentualTransferido, 
                            'NAT_TRANSACAO'     => $dadosTransacao[0]->NAT_TRANSACAO==$request->cadnatureza?"":$request->cadnatureza,
                            'VL_DECL_TRANSACAO' => $dadosTransacao[0]->VL_DECL_TRANSACAO==$valorTransacao?"0":$valorTransacao
                        ]
                    );
                }
                else{
                    DB::connection('lecom')
                        ->table('pmm_cumprir_exigencia_itbi')
                        ->where('PROCESSO', $dadosTransacao[0]->COD_PROCESSO)
                        ->where('ETAPA', $dadosTransacao[0]->COD_ETAPA_ATUAL)
                        ->where('CICLO', $dadosTransacao[0]->COD_CICLO_ATUAL)
                        ->update(
                        [
                            'TRANS_PARC'        => $dadosTransacao[0]->TRANS_PARC==$request->cadtransacaoParcial?"":$request->cadtransacaoParcial, 
                            'TIPO_TRANSACAO'    => $dadosTransacao[0]->TIPO_TRANSACAO==$request->cadtransacao?"":$request->cadtransacao, 
                            'PERCENT_TRANSF'    => $dadosTransacao[0]->PERCENT_TRANSF==$request->cadpercentualTransferido?"0":$request->cadpercentualTransferido, 
                            'NAT_TRANSACAO'     => $dadosTransacao[0]->NAT_TRANSACAO==$request->cadnatureza?"":$request->cadnatureza,
                            'VL_DECL_TRANSACAO' => $dadosTransacao[0]->VL_DECL_TRANSACAO==$valorTransacao?"0":$valorTransacao
                        ]
                    );
                }

                $docs = explode(";", $documentosTransacaoFinal);

                // dd($docs);

                $linha = 0;
                $val = [];
                foreach ($docs as &$valor) {
                    $linha++;
                    $val[$linha] = $valor;
                    if ($linha == 2){
                        $linha=0;
                        DB::connection('lecom')
                            ->table('pmm_portal_arquivo')->insert(
                            [
                                'COD_PROCESSO'      => $dadosTransacao[0]->COD_PROCESSO, 
                                'COD_ETAPA'         => $dadosTransacao[0]->COD_ETAPA_ATUAL, 
                                'COD_CICLO'         => $dadosTransacao[0]->COD_CICLO_ATUAL, 
                                'TIPO'              => $val[2], 
                                'DESCRICAO'         => $val[1]
                            ]
                        );
                    }
                }

                DB::table('itbi_exigencias')->insert(
                    [
                        'processo'      => $dadosTransacao[0]->COD_PROCESSO, 
                        'etapa'         => $dadosTransacao[0]->COD_ETAPA_ATUAL, 
                        'ciclo'         => $dadosTransacao[0]->COD_CICLO_ATUAL, 
                        'data'          =>  date('Y-m-d H:i:s')
                    ]
                );


                return view('cidadao.sucesso_servico', [
                    'titulo' => 'LANÇAMENTO DE ITBI', 
                    'mensagem' => '<p><strong>Atenção!</strong> </p><br>
                    Solicitação encaminhada para análise. Acompanhe sua solicitação <b>'.$dadosTransacao[0]->COD_PROCESSO.'</b> na aba consulta.<br><br>' ]); 
            }
            else{
                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel', 
                    "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações do seu processo.</p>
                    <p>Entre em contato com o SIM.</p>
                    Código: ITBI_003' ]);
            }
        }


        // dd($retorno['resposta']);

        if(isset($retorno['resposta']->{'content'}->{'processInstanceId'})){
            return view('cidadao.sucesso_servico', [
                'titulo' => 'LANÇAMENTO DE ITBI', 
                'mensagem' => '<p><strong>Atenção!</strong> </p><br>
                Solicitação encaminhada para análise. Acompanhe sua solicitação <b>'.$retorno['resposta']->{'content'}->{'processInstanceId'}.'</b> na aba consulta.<br><br>' ]);  
        }
        else{
            return view('cidadao.falha_integracao', ['titulo' => 'LANÇAMENTO DE ITBI', 
            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
            <p>Tente Novamente em alguns instantes.</p>
            Código: ITBI_002' ]);
        }
    } catch (\Exception $e) {
        // dd($e);
        return view('cidadao.falha_integracao', ['titulo' => 'LANÇAMENTO DE ITBI', 
        "mensagem" => '<p><strong>Atenção!</strong> Não foi possível atualizar as informações.</p>
        <p>Tente Novamente em alguns instantes.</p>
        Código: ITBI_001' ]);
    }
}

private function ticketSSO(){
    $data1 = [
        'user' => USUARIO,
        'pass' => SENHA,
    ];
    $data_string = json_encode($data1);
    
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

   

}
