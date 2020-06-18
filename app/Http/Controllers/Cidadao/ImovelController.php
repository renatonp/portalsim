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
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\UploadedFile;
use App\Models\AverbacaoLecom;
use App\Support\ImovelSupport;

class ImovelController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
        $this->paginator = new \CoffeeCode\Paginator\Paginator();
        $this->properties = new ImovelSupport();
    }

    public function consultaInformacoes(Request $request)
    {

        $document = remove_character_document(Auth::user()->cpf);
        
        $resposta = $this->properties->listProperties($request->page, $document, API_LISTA_IMOVEIS_CERTIDAO);

        /** 
        * Paginação
        */ 
        $this->paginator->pager(
            $resposta->iPaginacao, // total de páginas
            count($resposta->aMatriculasListaCertidaoEncontradas), // qtd por página
            isset($request->page) ? $request->page : 1 // página atual
        );

        if ($resposta->iStatus === 2) {

            if ($resposta->iNumeroErro === 201) {

                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Foram identificados diversos imóveis em seu cadastro. Dirija-se a uma agência do SIM.<br>

                Em breve este serviço estará disponível aqui para você!.</p>

                Código: ERR_API 002' ]);

            } else{

                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi encontrado nenhum imóvel registrado no seu nome.</p>

                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>

                Código: IMOVEL_002' ]);

            }
        } else {

            Log::create([ 'servico'=> 11 , 'descricao' => "Consulta de Informações de Exames", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' => DB::raw('now()'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);

            $arrBaixa = [];

            foreach ($resposta->aMatriculasListaCertidaoEncontradas as $value) {

                $baixa = $this->properties->getImovelBaixado($value->matricula, $document);

                array_push($arrBaixa, [
                    "matricula" =>  $value->matricula, 
                    "baixado" => $baixa->i_matricula_baixada
                ]);

            }

            return view('imovel.consultaimoveis', [
                'registros' => $resposta, 
                'baixados' => $arrBaixa, 
                'paginator' => $this->paginator->render()
            ]);
        }
    }

    public function imovelInformacao($id)
    {
        $cpfUsuario = remove_character_document(Auth::user()->cpf);

        try {

            $resposta = $this->properties->getPropertie($id, $cpfUsuario);

            if ($resposta->iStatus == 1) {

                $servicosImovel = [
                    'imovel.cadastro'         => 'Cadastro do Imóvel',
                    'imovel.caracteristicas'  => 'Características do Imóvel',
                    'imovel.lote'             => 'Cadastro de Lote',
                    'imovel.construcao'       => 'Cadastro de Construções',
                    'imovel.proprietarios'    => 'Cadastro de Outros Proprietários',
                    'imovel.isencao'          => 'Isenção / Imunidade'
                ];

                return view('imovel.imovel', [
                    'registros' => $resposta,
                    'servicosImovel' => $servicosImovel
                ]);

            } else {

                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>

                <p>Tente Novamente em alguns instantes.</p>

                Código: IMOVEL_001' ]);

            }

        } catch (\Exception $e) {

            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>

                <p>Tente Novamente em alguns instantes.</p>

                Código: INT_1001' ]);

        }
    }



    public function imprimeInformacoes($id) {

        $cpfUsuario = str_replace(".", "", Auth::user()->cpf);

        $cpfUsuario = str_replace("-", "", $cpfUsuario);

        $cpfUsuario = str_replace("/", "", $cpfUsuario);

        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        try {

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'             => API_BIC_IMOVEL,

                'i_codigo_maticula' => $id,

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



            $resposta=json_decode($response);



            // dd($resposta);



            if($resposta->iBicImovelGerada != 1){

                return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível gerar a impressão das informações do imóvel.</p>

                <p>Dirija-se a uma agência do SIM e verifique o seu cadastro.</p>

                Código: IMOVEL_003' ]);

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

            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong>  Não foi possível gerar a impressão das informações do imóvel.</p>

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

            $json_data = json_encode($data1);

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



            // dd(API_URL . API_CERTIDAO, $data_string, json_decode($response), $err);

            $resposta = json_decode($response);



            return json_decode($response);



        } catch (\Exception $e) {

            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>

                <p>Tente Novamente em alguns instantes.</p>

                Código: INT_1001' ]);

        }

    }



    /*

    Buscar os imóveis pelo CPF do contribuinte

    */

    public function listaImoveisAverbacao($cpf, $matricula=""){

        $params = [".", "-", "/", " "];

        $cpf = str_replace($params, "", $cpf);

        try {

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_MATRICULA_CONSULTA,

                'i_cpfcnpj'     => $cpf,

            ];

            if( $matricula !=="" ){

                $data1 = array_merge($data1, array('i_codigo_maticula' => $matricula));

            }

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

            $responseImoveis = curl_exec($ch);

            $err = curl_error($ch);

            curl_close($ch);



            // dd(API_URL . API_IMOVEL, $data_string, json_decode($response), $err);



            return $responseImoveis;





        } catch (\Exception $e) {

            // dd($e);

            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',

                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>

                <p>Tente Novamente em alguns instantes.</p>

                Código: INT_1001' ]);

        }

    }



    public function averbacaoImovel($processo = ""){
        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                 => API_TIPO_AVERBACAO,
            ];

            $json_data = json_encode($data1);
            $data_string = ['json'=>$json_data];

            $ch = curl_init();
            curl_setopt_array($ch, array(
                CURLOPT_URL => API_URL . API_AVERBACAO,
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
            // dd($resposta->iStatus);

            if($resposta->iStatus != 1){
                return view('cidadao.falha_integracao', ['titulo' => 'Averbação de Imóveis',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações de solicitação.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: AVERB_001' ]);
            }
            else {
                $exigencias = DB::connection('lecom')
                ->table('v_exigencias_averbar')
                ->where('COD_PROCESSO', '=', $processo )
                ->get();

                /* $dadosPendentes = DB::table('averbacao_lecom')
                ->where('cpf',      '=', Auth::user()->cpf )
                ->get(); */
                // dd($exigencias[0]);

                $pendencias = [];
                if($exigencias->count()) {
                    $newDate = date_create($exigencias[$exigencias->count()-1]->DT_REG_IMOVEL);

                    $pendencias = [
                        "COD_PROCESSO" => $exigencias[$exigencias->count()-1]->COD_PROCESSO,
                        "COD_ETAPA_ATUAL" => $exigencias[$exigencias->count()-1]->COD_ETAPA_ATUAL,
                        "COD_CICLO_ATUAL" => $exigencias[$exigencias->count()-1]->COD_CICLO_ATUAL,
                        "NU_GUIA_ITBI" => $exigencias[$exigencias->count()-1]->NU_GUIA_ITBI,
                        "NU_REG_GERAL_IMOVEL" => $exigencias[$exigencias->count()-1]->NU_REG_GERAL_IMOVEL,
                        "PROT_REG_IMOVEL" => $exigencias[$exigencias->count()-1]->PROT_REG_IMOVEL,
                        "MAT_IMOV_CARTORIO" => $exigencias[$exigencias->count()-1]->MAT_IMOV_CARTORIO,
                        "DT_REG_IMOVEL" => date_format($newDate, 'd-m-Y'),
                    ];
                }
                // dd($pendencias);

                return view('imovel.averbacao.home', [
                    'registros' => $resposta,
                    'tipoSolicitacao' => $resposta,
                    'estados' => $this->getStats(),
                    'pendencias' => $pendencias
                ]);
            }
        } catch (\Exception $e) {
            // dd($e);

            return view('cidadao.falha_integracao', ['titulo' => 'Imóvel',
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a relação dos imóveis.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }



    /*

    Buscar ITBI’s quitados referente ao imóvel informado

    */

    public function listaItbiImovel($matricula){



            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'                 => API_LISTA_ITBI,

                's_limit'               => "0",

                'i_matricula_imovel'    => $matricula,

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

            $responseItbi = curl_exec($ch);

            $err = curl_error($ch);

            curl_close($ch);



            return $responseItbi;

    }



    public function listaAdquirentes($matricula, $guia){



        $data1 = [

            'sTokeValiadacao'   => API_TOKEN,

            'sExec'                 => API_ADQUIRENTE_AVERBACAO,

            'i_codigo_guia'         => $guia,

            'i_matricula_imovel'    => $matricula,

        ];

        $json_data = json_encode($data1);

        $data_string = ['json'=>$json_data];



        $ch = curl_init();



        curl_setopt_array($ch, array(

            CURLOPT_URL => API_URL . API_AVERBACAO,

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



        return $response;

    }



    public function verifica_status_lecom($matricula) {

        $cpf = Auth::user()->cpf;



        $averba = AverbacaoLecom::where('cpf', $cpf)

                    ->where('matricula', $matricula)

                    ->get();



        // dd($averba);



        if($averba->count()) {

            $serv = DB::connection('lecom')

            ->table('v_consulta_servico_sim')

            ->where('Chamado', '=', $averba[0]->cod_lecom )

            ->get();



            // dd($serv);

            if($serv[0]->FINALIZADO == 'Finalizado') {

                return (['status' => true]);

            }else {

                return (['status' => false]);

            }

        }else {

            return (['status' => true]);

        }

    }



    public function verifica_debitos($matricula) {

        $data1 = [

            'sTokeValiadacao'   => API_TOKEN,

            "sExec" => "integracaoverificardebitosdividaimovel",

            "i_codigo_maticula" => $matricula

        ];

        $json_data = json_encode($data1);

        $data_string = ['json' => $json_data];



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



        // dd($response);

        return $response;

    }



    public function pendencias_gravar(request $request) {

        DB::beginTransaction();



        try {

            $anexos = json_decode($request["anexos"]);



            // dd($request->all());



            $check = DB::connection('mysql')

                    ->table('averbacao_exigencias')

                    ->where([

                        ['processo', '=', $request['processo_pendencias']],

                        ['etapa', '=', $request['etapa_pendencias']],

                        ['ciclo', '=', $request['ciclo_pendencias']],

                    ])

                    ->get();



            if($check->count()) {

                $view = view('cidadao.falha_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Esse processo de edição de pendências da averbação já foi respondido!'])->render();

                return response()->json(['html' => $view]);

            }



            foreach ($anexos as $key => $anx) {

                $anexos_lecom = DB::connection('lecom')

                        ->table('pmm_portal_arquivo')

                        ->insert([

                            'COD_PROCESSO' => $request['processo_pendencias'],

                            'COD_ETAPA' => $request['etapa_pendencias'],

                            'COD_CICLO' => $request['ciclo_pendencias'],

                            'TIPO' => $anx->descricao,

                            'DESCRICAO' => $anx->nome,

                        ]);

            }



            // $data_pendencias = $request['data_pendencias'].' 00:00:00';



            $data_explode = explode('/', $request['data_pendencias']);



            $data_pendencias = $data_explode[2].'-'.$data_explode[1].'-'.$data_explode[0];



            $dados_cumprir = DB::connection('lecom')

                        ->table('pmm_cumprir_exigencia_averbar')

                        ->insert([

                            'PROCESSO' => $request['processo_pendencias'],

                            'ETAPA' => $request['etapa_pendencias'],

                            'CICLO' => $request['ciclo_pendencias'],

                            'NU_GUIA_ITBI' => $request['guia_pendencias'],

                            'NU_REG_GERAL_IMOVEL' => $request['imovel_pendencias'],

                            'PROT_REG_IMOVEL' => $request['protocolo_pendencias'],

                            'DT_REG_IMOVEL' => $data_pendencias,

                        ]);



            $dados_local = DB::connection('mysql')

                        ->table('averbacao_exigencias')

                        ->insert([

                            'processo' => $request['processo_pendencias'],

                            'etapa' => $request['etapa_pendencias'],

                            'ciclo' => $request['ciclo_pendencias'],

                            'data' => date('Y-m-d'),

                        ]);

            



            // dd($dados_cumprir, $dados_local);

            if($dados_cumprir && $dados_local) {

                DB::commit();

                $view = view('cidadao.sucesso_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Solicitação encaminhada para análise. Acompanhe sua solicitação ' . $request['processo_pendencias'] . ' na aba consulta'])->render();

                return response()->json(['html'=>$view]);

            }else {

                DB::rollBack();

                $view = view('cidadao.falha_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Falha no processo de edição de pendências da averbação!'])->render();

                return response()->json(['html'=>$view]);

            }

        } catch (\Throwable $th) {

            DB::rollBack();

            $view = view('cidadao.falha_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Falha no processo de edição de pendências da averbação, tente novamente mais tarde!'])->render();

            return response()->json(['html'=>$view]);

        }



    }



    public function averbacao_gravar(request $request){

        // dd($request->all());



        $adquirentes = json_decode('['.$request["adquirentes"].']');



        // dd($adquirentes);



        $adqString = "";

        foreach ($adquirentes as $key => $adq) {

            $adqString .= $adq->nome.';'.$adq->cpf.';'.$adq->telefone.';'.$adq->celular.';'.$adq->cgm.';'.$adq->cep.';'.$adq->endereco.';'.$adq->numero.';'.$adq->complemento.';'.$adq->bairro.';'.$adq->municipio.';'.$adq->estado.';'.$adq->email.';'.$adq->principal.';';

        }

        $adqString = substr($adqString, 0, -1);





        $anexos = json_decode($request["anexos"]);



        // dd($anexos);



        $anexoString = "";

        foreach ($anexos as $key => $anx) {

            $anexoString .= $anx->outroAnexo ?  $anx->nome.';'.$anx->outroAnexo.';' : $anx->nome.';'.$anx->descricao.';';

        }

        $anexoString = substr($anexoString, 0, -1);



        $cgm = $this->recuperaCGM(Auth::user()->cpf);



        if(!$cgm['error']){



            $guia = "Cidadão";

            $assunto = "Imóvel";

            $servico = "Averbar Imóvel";



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



            // dd($json);



            $dataArray = explode("/", $request["dataAverbacao"]);



            $dataAverbacao = $dataArray[2]."-".$dataArray[1]."-".$dataArray[0];



            $request["anexos"] = substr($request["anexos"], 0, -1);



            $json = str_replace("[nome]", Auth::user()->name, $json);

            $json = str_replace("[cpf]", Auth::user()->cpf, $json);

            $json = str_replace("[telefone]", Auth::user()->celphone, $json);

            $json = str_replace("[celular]", Auth::user()->celphone, $json);

            $json = str_replace("[email]",Auth::user()->email, $json);

            $json = str_replace("[itbi]", $request["guiaItbi"], $json);

            $json = str_replace("[dadosadquirente]", $adqString, $json);

            $json = str_replace("[rgi]", $request["registro"], $json);

            $json = str_replace("[matimovel]", $request["inscricao"], $json);

            $json = str_replace("[protimovel]", $request["protocolo"], $json);

            $json = str_replace("[transacao]", $request["tipoSolicitacao"].' - '.$this->converteTipoSolicacao($request["tipoSolicitacao"]), $json);

            $json = str_replace("[data_reg_imovel]", $dataAverbacao, $json);

            $json = str_replace("[correspondecia]", "", $json);

            $json = str_replace("[anexos]", $anexoString, $json);





            $url = str_replace(":processo",$processo, SISTEMACAMINHOBASE.CAMINHO);

            $url = str_replace(":versao",$versao, $url);



            // dd($url);

            // $json = '{"values": [{"id": "REQ_NOME","value": "FERNANDO DA SILVA PEREIRA"}]}';



            // dd($json);



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

            if( USAR_SSL ){

                curl_setopt($ch, CURLOPT_CAINFO,  getcwd().'/cert/' . SSL_LECOM);

            }

            $response = curl_exec($ch);

            $err = curl_error($ch);

            curl_close($ch);

            $retorno = [

                'ticket' => $ticketId,

                'resposta' => json_decode($response),

            ];



            // dd($processo, $versao, $url, $ticketId, $json, $retorno);

            if($retorno['resposta']->content->processInstanceId) {

                $averbacaoLecom = DB::table('averbacao_lecom')->insert([

                    'cpf'               => Auth::user()->cpf,

                    'cod_lecom'         => $retorno['resposta']->content->processInstanceId,

                    'matricula'         => $request["inscricao"],

                    'data_solicitacao'  => date("Y-m-d H:i:s"),

                ]);

                return view('cidadao.sucesso_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Solicitação encaminhada para análise. Acompanhe sua solicitação ' . $retorno['resposta']->content->processInstanceId . ' na aba consulta']);

            }else {

                return view('cidadao.falha_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS', 'mensagem' => 'Falha no processo de averbação!']);

            }

        }else{

            return view('cidadao.falha_integracao', ['titulo' => 'AVERBAÇÃO DE IMÓVEIS',

            "mensagem" => '<p><strong>Atenção!</strong> Não foi possível recuperar as informações.</p>

            <p>Tente Novamente em alguns instantes.</p>

            Código: INT_1001' ]);

        }

    }



    private function getStats() {

        $stats = [

            ['value' => 'ACRE', 'key' => 'AC'],

            ['value' => 'ALAGOAS', 'key' => 'AL'],

            ['value' => 'AMAPÁ', 'key' => 'AP'],

            ['value' => 'AMAZONAS', 'key' => 'AM'],

            ['value' => 'BAHIA', 'key' => 'BA'],

            ['value' => 'CEARÁ', 'key' => 'CE'],

            ['value' => 'DISTRITO FEDERAL', 'key' => 'DF'],

            ['value' => 'ESPÍRITO SANTO', 'key' => 'ES'],

            ['value' => 'GOIÁS', 'key' => 'GO'],

            ['value' => 'MARANHÃO', 'key' => 'MA'],

            ['value' => 'MATO GROSSO', 'key' => 'MT'],

            ['value' => 'MATO GROSSO DO SUL', 'key' => 'MS'],

            ['value' => 'MINAS GERAIS', 'key' => 'MG'],

            ['value' => 'PARÁ', 'key' => 'PA'],

            ['value' => 'PARAÍBA', 'key' => 'PB'],

            ['value' => 'PERNAMBUCO', 'key' => 'PE'],

            ['value' => 'PIAUÍ', 'key' => 'PI'],

            ['value' => 'RIO DE JANEIRO', 'key' => 'RJ'],

            ['value' => 'RIO GRANDE DO NORTE', 'key' => 'RN'],

            ['value' => 'RIO GRANDE DO SUL', 'key' => 'RS'],

            ['value' => 'RONDÔNIA', 'key' => 'RO'],

            ['value' => 'RORAIMA', 'key' => 'RR'],

            ['value' => 'SANTA CATARINA', 'key' => 'SC'],

            ['value' => 'SÃO PAULO', 'key' => 'SP'],

            ['value' => 'SERGIPE', 'key' => 'SE'],

            ['value' => 'TOCANTINS', 'key' => 'TO'],

        ];

        return $stats;

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





    public function averbacao_documentos(Request $request){



        // dd($request->all());



        // dd($request->hasFile('file'));

        // dd($request->file('arquivo'));



        $errors = [];



        $request->validate([

            'arquivo'     =>  'required|mimes:jpeg,png,jpg,pdf|max:2048'

        ]);



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



        if($tamanhoArquivo > 2048000){

            array_push($errors, 'O arquivo deve ter no máximo 2MB');

        }



        if(count($errors)> 0 ){

            return back()->withErrors($errors);

        }



        // dd($tipo, $nomeOriginal, $extensaoOriginal, $extensao, $tamanhoArquivo);



        // $path = $request->arquivo('avatar')->store(

        //     'avatars/'.$request->user()->id, 's3'

        // );



        $params = [".", "-", "/", " "];

        $cpf = str_replace($params, "", Auth::user()->cpf);



        $descricao = $request->descricao != "Outros" ? $request->descricao : $request->outroAnexo;



        $nomeArquivo =  $cpf."_".date('Y-m-d H:i:s')."_".$descricao.".".$extensao;

        $nomeArquivo = str_replace(" ", "_", $nomeArquivo);

        // die($nomeArquivo);

        $upload = $request->arquivo->storeAs('documentos', $nomeArquivo , 'sftp');



        if($upload){

            return (['statusArquivoTransacao'=> 1, 'descricao' => $request->descricao , 'nome_original' => $nomeOriginal  , 'nome_novo' => $nomeArquivo ]);

        }else{

            return back()->with('status', 0);

        }

    }



    public function averbacao_documentos_excluir($id){



        $resultado = DB::table('averbacao_documentos')

        ->where('id', '=', $id )

        ->where('cpf', '=', Auth::user()->cpf )

        ->get();



        if(count($resultado)>0){

            // dd($resultado[0]->nome_documento);



            $retorno = Storage::disk('sftp')->delete('documentos/'.$resultado[0]->nome_documento);



            $resultadox = DB::table('averbacao_documentos')

            ->where('id', '=', $id )

            ->where('cpf', '=', Auth::user()->cpf )

            ->delete();



            // $respostax = DB::connection('lecom')

            // ->table('pmm_portal_arquivo')

            // ->where('COD_PROCESSO', '=', $resultado[0]->cod_locom )

            // ->where('DESCRICAO', '=',$resultado[0]->nome_documento)

            // ->delete();

        }



        return back()->with('status', 1);

    }



    public function recuperaCgmEndereco($cpf, $tipo = "P") {

        try {

            $params = [".", "-", "/", " "];

            $cpf = str_replace($params, "", $cpf);



            // Recuperando dados do CGM...

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_CONSULTA_CGM,

                'z01_cgccpf'    => $cpf,

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



            $userCGM = json_decode($response);



            // Recuperando o endereço do CGM

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_CONSULTA_ENDERECO_CGM,

                'sCpfcnpj'      => $cpf,

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

                "nome" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmPessoais->z01_nome ))),

                "cpf" => $userCGM->aCgmPessoais->z01_cgccpf,

                "telefone" => $userCGM->aCgmContato->z01_telef,

                "celular" => $userCGM->aCgmContato->z01_telcel,

                "cgm" => $userCGM->cgm,

                "cep" => $enderecoCGM->endereco->iCep,

                "endereco" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $enderecoCGM->endereco->sRua ))),

                "numero" => $enderecoCGM->endereco->sNumeroLocal,

                "complemento" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $enderecoCGM->endereco->sComplemento ))),

                "bairro" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $enderecoCGM->endereco->sBairro ))),

                "municipio" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $enderecoCGM->endereco->sMunicipio ))),

                "estado" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $enderecoCGM->endereco->sUf ))),

                "email" => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmContato->z01_email ))),

                "error" => false,

            ];





            $retorno = [

                'error'         => false,

                'cgm'           => $retorno

            ];

            return $retorno;





        } catch (\Exception $e) {

            $retorno = [

                'error'         => true

            ];

            return $retorno ;

        }

    }



    public function recuperaCGM($cpf){

        try {

            $params = [".", "-", "/", " "];

            $cpf = str_replace($params, "", $cpf);



            // Recuperando dados do CGM...

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_CONSULTA_CGM,

                'z01_cgccpf'    => $cpf,

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







            $userCGM = json_decode($response);



            // dd($data_string, $userCGM );





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



        try {

            $params = [".", "-", "/", " "];

            $cpf = str_replace($params, "", $cpf);



            // Recuperando dados do CGM...

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_CONSULTA_ENDERECO_CGM,

                'sCpfcnpj'      => $cpf,

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



    public function recupera_adquirentes_imovel($guia){



        try {



            // Recuperando dados dos adquirentes de um imóvel...

            $data1 = [

                'sTokeValiadacao'   => API_TOKEN,

                'sExec'         => API_LISTA_ADQUIRENTES_ITBI,

                'i_codigo_guia'      => $guia,

                's_tipo' => "C",

            ];



            $json_data = json_encode($data1);

            $data_string = ['json'=>$json_data];



            $ch = curl_init();



            curl_setopt_array($ch, array(

                CURLOPT_URL => API_URL . API_AVERBACAO,

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



            return $response;



        } catch (\Exception $e) {

            $retorno = [

                'error'         => true

            ];

            return $retorno ;

        }

    }



    public function converteTipoSolicacao($tipo) {

        $tipo = utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$tipo)));

        $tipo = strtoupper($tipo);



        switch ($tipo) {

            case '2':

                return "ESCRITURA";

            case '3':

                return "REGISTRO DE IMOVEIS";

            case '4':

                return "CONTRATO";

            case '9':

                return "MIGRACAO";

        }

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

