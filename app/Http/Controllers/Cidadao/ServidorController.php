<?php

namespace App\Http\Controllers\Cidadao;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Cidadao\CgmController;
use Auth;
use DB;

class ServidorController extends Controller
{
    private function ticketSSO(){
        if (strlen( Auth::user()->cpf )<=14){
            $data1 = [
                'user' => USUARIO,
                'pass' => SENHA,
            ];
        }
        else{
            $data1 = [
                'user' => USUARIO_INST,
                'pass' => SENHA_INST,
            ];
        }
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

        // dd(SISTEMACAMINHOBASE."/".CAMINHORELATIVO,$data_string, $response, getcwd().'/cert/' . SSL_LECOM);
        
        return $response;
    }

    public function formataJson($json){
        
        $class_cgm = new CgmController();
        $cgm = $class_cgm->recuperaCGM(Auth::user()->cpf);

        $json = str_replace("[NOME]", Auth::user()->name, $json);
        $json = str_replace("[CPF]", Auth::user()->cpf, $json);
        $json = str_replace("[MATRICULA]", "", $json);
        $json = str_replace("[CELULAR]", Auth::user()->celphone, $json);
        $json = str_replace("[EMAIL]", Auth::user()->email, $json);
        $json = str_replace("[RG]",$cgm['cgm']->aCgmAdicionais->z01_ident, $json);
        $json = str_replace("[ORGAO]",$cgm['cgm']->aCgmAdicionais->z01_identorgao, $json);
        $json = str_replace("[NOME_MAE]","", $json);
        $json = str_replace("[NOME_PAI]","", $json);
        $json = str_replace("[endereco]","", $json);
        $json = str_replace("[complemento]","", $json);
        $json = str_replace("[bairro]","", $json);
        $json = str_replace("[cidade]","", $json);
//        $json = str_replace("[TEL_FIXO]", $cgm['cgm']->aCgmContato->z01_telef, $json);

        
		// dd(Auth::user(), $cgm['cgm']);
        return $json;
    }

    public function formularioBPM($json, $processo, $versao){
        $ticket = json_decode($this->ticketSSO());
        foreach ( $ticket as $ticketId ){
        }
        // dd($ticketId);
        $fields = $this->formataJson($json);
        // dd($fields);
        $url = str_replace(":processo",$processo, SISTEMACAMINHOBASE.CAMINHO);
        $url = str_replace(":versao",$versao, $url);
        // dd($url, $fields);

        $ch = curl_init();
        curl_setopt_array($ch, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_TIMEOUT => 30000,
            CURLOPT_CUSTOMREQUEST => "PUT",
            CURLOPT_POSTFIELDS => $fields,
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
        // dd($ticketId, $url, $fields, $response);
        return $retorno;
    }

    public function solicitarLicencaMaternidade(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço', '=','Solicitar Licença Maternidade')
            ->get(); 
        
        // if( count($registros) > 0 ){
        //     $x = collect($registros->all());
        //     return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta", 'pass' => '1'] );
        // }
        // else{
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=','Servidor')
            ->where('assunto', '=','RH')
            ->where('servico', '=','Solicitar Licença Maternidade')
            ->get();

            $altura = "2500px";
            $header = true;

            $infoForm = $this->formularioBPM($serv[0]->json, $serv[0]->processo, $serv[0]->versao);
            // dd($infoRequisicao);

            if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){
                $uuid = DB::connection('lecom')
                ->table('processo_etapa')
                ->select('uuid')
                ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();

                $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
                    return view('site.formulario',[
                        "pagina" => "Serviços",
                        "altura" => $altura,
                        'guia' => 'Servidor', 
                        'assunto' => 'RH', 
                        'servico' => 'Solicitar Licença Maternidade',
                        'infoForm' => $infoForm, 
                        'uuid' => $uuid[0]->{'uuid'},
                        'caminho' => $caminho,
                        'header'=> true,
                        'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                        'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                        'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                    ]);
            }
            else{
                return redirect()->route('home')->with('erroServico', 1);
            }
        // }
    }

    public function solicitarLicencaPremio(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço', '=','Solicitar Licença Prêmio')
            ->get();
        // dd($registros);
        
        if( count($registros) > 0 ){
            $x = collect($registros->all());
            return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta", 'pass' => '1'] );
        }
        else{
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=','Servidor')
            ->where('assunto', '=','RH')
            ->where('servico', '=','Solicitar Licença Prêmio')
            ->get();

            $altura = "2500px";
            $header = true;

            $infoForm = $this->formularioBPM($serv[0]->json, $serv[0]->processo, $serv[0]->versao);
            // dd($infoRequisicao);

            if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){
                $uuid = DB::connection('lecom')
                ->table('processo_etapa')
                ->select('uuid')
                ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();

                $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
                    return view('site.formulario',[
                        "pagina" => "Serviços",
                        "altura" => $altura,
                        'guia' => 'Servidor', 
                        'assunto' => 'RH', 
                        'servico' => 'Solicitar Licença Prêmio',
                        'infoForm' => $infoForm, 
                        'uuid' => $uuid[0]->{'uuid'},
                        'caminho' => $caminho,
                        'header'=> true,
                        'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                        'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                        'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                    ]);
            }
            else{
                return redirect()->route('home')->with('erroServico', 1);
            }
        }
    }

    public function solicitarAuxílioTransporte(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço', '=','Solicitar Auxílio Transporte')
            ->get();
        // dd($registros);

        if( count($registros) > 0 ){
            $x = collect($registros->all());
            return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta", 'pass' => '1'] );
        }
        else{
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=','Servidor')
            ->where('assunto', '=','RH')
            ->where('servico', '=','Solicitar Auxílio Transporte')
            ->get();

            $altura = "2200px";
            $header = true;
			
            $infoForm = $this->formularioBPM($serv[0]->json, $serv[0]->processo, $serv[0]->versao);
            // dd($infoForm);

            if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){
                $uuid = DB::connection('lecom')
                ->table('processo_etapa')
                ->select('uuid')
                ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();

                $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
                    return view('site.formulario',[
                        "pagina" => "Serviços",
                        "altura" => $altura,
                        'guia' => 'Servidor', 
                        'assunto' => 'RH', 
                        'servico' => 'Solicitar Auxílio Transporte',
                        'infoForm' => $infoForm, 
                        'uuid' => $uuid[0]->{'uuid'},
                        'caminho' => $caminho,
                        'header'=> true,
                        'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                        'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                        'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                    ]);
            }
            else{
                return redirect()->route('home')->with('erroServico', 1);
            }
        }
    }

    public function alterarLotacaoServidor(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço', '=','Alterar Lotação Servidor')
            ->get();
        // dd($registros);

        if( count($registros) > 0 ){
            $x = collect($registros->all());
            return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta", 'pass' => '1'] );
        }
        else{
            $serv = DB::connection('lecom')
            ->table('v_catalogo_sim')
            ->where('guia', '=','Servidor')
            ->where('assunto', '=','RH')
            ->where('servico', '=','Alterar Lotação Servidor')
            ->get();

            $altura = "2500px";
            $header = true;

            $infoForm = $this->formularioBPM($serv[0]->json, $serv[0]->processo, $serv[0]->versao);
            // dd($infoRequisicao);

            if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){
                $uuid = DB::connection('lecom')
                ->table('processo_etapa')
                ->select('uuid')
                ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();

                $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
                    return view('site.formulario',[
                        "pagina" => "Serviços",
                        "altura" => $altura,
                        'guia' => 'Servidor',
                        'assunto' => 'RH',
                        'servico' => 'Alterar Lotação Servidor',
                        'infoForm' => $infoForm,
                        'uuid' => $uuid[0]->{'uuid'},
                        'caminho' => $caminho,
                        'header'=> true,
                        'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                        'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                        'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                    ]);
            }
            else{
                return redirect()->route('home')->with('erroServico', 1);
            }
        }
    }



    
}