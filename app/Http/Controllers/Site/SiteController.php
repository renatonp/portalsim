<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Models\Notice;
use App\Models\Contact;
use App\Models\Log;
use App\Mail\FaleConosco;
use App\Mail\ResetPassword;
use App\Support\LoginSupport;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SiteController extends Controller
{

    public function index(){
        Log::create([ 'servico'=> 0,  'descricao' => "Home", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);

        return view('site.welcome', [ 'pagina' => "Principal"]);
    }

    public function login(Request $request)
    {
        GoogleRecaptcha::verify(
            env('RECAPTCHA_SECRET_KEY'), 
            'Por favor clique no checkbox do reCAPTCHA primeiro!'
        );

        $request->validate([
            'cpf' => 'required|exists:users,cpf',
            'password' => 'required'
        ]);

        $attributes = $request->only(['cpf', 'password']);

        if (Auth::attempt($attributes)) {

            $cpfUsuario = remove_character_document($request->cpf);
            
            $loginSupport = new LoginSupport();

            $resposta = $loginSupport->login($cpfUsuario);
        
            if ($resposta->iStatus != 2) {

                $tipo = "";

                switch ($resposta->aTipoPessoa[0]->i_cod_tipo_pessoa) {

                    case '1':
                        $tipo = "EMPRESA NÃO ESTABELECIDA";
                        break;
                    case '2':
                        $tipo = "EMPRESA";
                        break;
                    case '5':
                        $tipo = "SERVIDOR";
                        break;
                    case '3':
                        $tipo = "CIDADÃO";
                        break;
                    default:
                        $tipo = "";
                        break;
                }

                session(['tipoUsuario' => $tipo]);
            }

            return redirect()->route('home');
        
        } else {
            return redirect()->back()
                ->withInput()
                ->withErrors([
                    'cpf' => 'Essas credenciais não correspondem aos nossos registros.'
                ]); 
        }
    }

    public function outrosservicos(){
        Log::create([ 'servico'=> 1003,  'descricao' => "Outros Serviços", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        return view('site.outrosservicos', [ 'pagina' => 'OutrosServicos' ]);
    }
    
    public function certidaoAutenticacao() {
        $showRecaptcha = GoogleRecaptcha::show(
            env('RECAPTCHA_SITE_KEY'), 
            'codigo', 
            'no_debug', 
            'mt-4 mb-3 col-md-6 offset-md-4 aligncenter', 
            'Por favor clique no checkbox do reCAPTCHA primeiro!'
        );

        return view('cidadao.certidaoautenticacao1', ['showRecaptcha'=> $showRecaptcha] );
    }

    public function esqueceuSenha(Request $request) {


        $cgm = $this->recuperaCGM($request->cpf);
        
        
        // dd($cgm);

        if(!$cgm['cgm']->sSqlerro){  // Encontrou o CPF do usuário no CGM
            if( $_SERVER['HTTP_HOST'] == 'ticmarica.com.br'){
                $request->request->add(['email'=> 'mizael.barbosa@gmail.com' ]);
            }
            else{
                if(strlen($cgm['cgm']->aCgmContato->z01_email) > 1){
                    $request->request->add(['email'=> utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmContato->z01_email))) ]);

                    // Atualiza o e-mail na base do portal para garantir que não tenha divergência
                    DB::table('users')
                        ->where('cpf', '=', $request->cpf)
                        ->update([
                        'email' => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $cgm['cgm']->aCgmContato->z01_email)))
                    ]);
                }
                else{
                    return back()
                        ->withInput($request->only('cpf'))
                        ->withErrors(['cpf' => trans('O usuário não possui um e-mail cadastrado. Para acessar o portal de serviços do município é necessário que você faça o seu cadastro em uma agência do SIM.')]);
                }
            }
            
            $user = DB::table('users')->where('cpf', '=', $request->cpf)->get();

            // Verifica se o usuário existe no portal
            if (count($user) < 1) {
                return redirect()->back()->withErrors(['cpf' => trans('O CPF não está cadastrado no Portal SIM')]);
            }
            
            $tokenData = str_random(60);
            //Create Password Reset Token
            DB::table('password_resets')->insert([
                'email' => $request->email,
                'token' => $tokenData,
                'created_at' => Carbon::now()
            ]);

            //Get the token just created above
            // $tokenData = DB::table('password_resets')->where('email', $request->email)->first();

            if ($this->sendResetEmail($request->email, $tokenData, $request->cpf)) {
                $e = explode("@", $request->email);
                $fakeEmail = substr($e[0], 0, 2).'*@'.$e[1];
                return redirect()->back()->with('status', trans('Um link de recuperação de senha foi enviado para o seguinte email: '. $fakeEmail));
            } else {
                return redirect()->back()->withErrors(['error' => trans('Erro de rede. Por favor Tente Novamente em alguns instantes.')]);
            }
        }
        else{
            return back()
            ->withInput($request->only('cpf'))
            ->withErrors(['cpf' => 'O CPF informado não está cadastrado no CGM']);
        }

    }

    public function resetPassword(Request $request){
        //Validate input

        GoogleRecaptcha::verify(env('RECAPTCHA_SECRET_KEY'), 'Por favor clique no checkbox do reCAPTCHA primeiro!');

        $validator = Validator::make($request->all(), [
            'email' => 'required|exists:users,email',
            'cpf' => 'required|exists:users,cpf',
            'password' => 'required|confirmed'
        ]);

        //check if input is valid before moving on
        if ($validator->fails()) {
            return redirect()->back()
            ->withInput()
            ->withErrors(['cpf' => 'Informações incorretas, Verifique se o e-mail e o CPF estão corretos.']);
        }

        $password = $request->password;

        // Validate the token
        $tokenData = DB::table('password_resets')
            ->where('token', $request->token)
            ->first();

        // dd($request->token, $tokenData);

        // Redirect the user back to the password reset request form if the token is invalid
        if (!$tokenData) {
            return redirect()->back()
                    ->withInput()
                    ->withErrors(['cpf' => 'Token inválido']);
        }

        $user = User::where('email', $request->email)
            ->where('cpf', $request->cpf)
            ->first();

        // dd($request->cpf, $tokenData->email, $user);

        // Redirect the user back if the email is invalid
        if (!$user) return redirect()->back()->withInput()->withErrors(['cpf' => 'Informações incorretas, Verifique se o e-mail e o CPF estão corretos.']);

        //Hash and update the new password
        $user->password = \Hash::make($password);
        $user->update(); //or $user->save();

        //login the user immediately they change password successfully
        Auth::login($user);

        //Delete the token
        DB::table('password_resets')
            ->where('email', $user->email)
            ->delete();

        return view('site.welcome');

        //Send Email Reset Success Email
        // if ($this->sendSuccessEmail($tokenData->email)) {
            // return view('site.welcome');
        // } else {
        //     return redirect()->back()->withErrors(['email' => trans('A Network Error occurred. Please try again.')]);
        // }

    }





    private function sendResetEmail($email, $token, $cpf)
    {
        //Recupera o usuário do bando de dados
        $user = DB::table('users')->where('cpf', $cpf)->select('name', 'email')->first();
        //Generate, the password reset link. The token generated is embedded in the link
        $link = config('base_url') . 'password/reset/' . $token . '?email=' . urlencode($email);

        try {
            Mail::to($email)->send(new ResetPassword($token, $user));

            return true;
        } catch (\Exception $e) {
            return false;
        }
    }



    public function validaAutenticidade(Request $request) {

        GoogleRecaptcha::verify(env('RECAPTCHA_SECRET_KEY'), 'Por favor clique no checkbox do reCAPTCHA primeiro!');

        if( strpos($request->codigo, "--") || strpos($request->codigo, chr(40) ) || strpos($request->codigo, chr(41) ) ) {
            $codigo = DB::connection()->getPdo()->quote($request->codigo);
        }
        else{
            $codigo = $request->codigo;
        }
        Log::create([ 'servico'=> 1005,  'descricao' => "Autenticação de Certidão: ". $codigo, 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);

        try {
            $data1 = [
                'sTokeValiadacao'   => API_TOKEN,
                'sExec'                     => API_AUTENTICIDADE_CERTIDAO,
                'i_codigo_barra_cerdidao'   => $codigo,
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

            $resposta=json_decode(utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$response))));

            // dd($resposta, $codigo, $data_string);

            if($resposta->iStatus=== 2){
                return view('cidadao.falha_integracao', ['titulo' => 'Certidões', 
                "mensagem" => '<p><strong>INVÁLIDA</strong> </p>
                <p>O código informado não é valido para nenhuma certidão dos nossos registros ou a validade está expirada.</p>
                <p>Verifique o código informado e tente novamente.</p>
                <p>Caso não consiga confirmar a autenticidade da certidão, digira-se a uma agência do SIM</p>
                Código: CERT_003' ]);
            }
            else {
                $tipo = explode(" - ",$resposta->aInformacaoCertidao[0]->p50_tipo);

                // dd($tipo[0]);
                setlocale(LC_TIME, 'pt_BR');
                $dataAtual = strftime('%A, %d de %B de %Y');
                $dataAtual2 = strftime('%d de %B de %Y');

                // dd($dataAtual2, $dataAtual);

                switch ($tipo[0]) {
                    case 'v':
                        # Declaração de Valor Venal
                        return \PDF::loadView('cidadao.validacao_v', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    //->stream()
                                                                    ;

                        break;
                    
                    case 't':
                        # Certidão de Numeração Predial Oficial
                        return \PDF::loadView('cidadao.validacao_t', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    //->stream()
                                                                    ;                        
                        break;

                    case 'i':
                        # Certidão de Quitação de ITBI
                        return \PDF::loadView('cidadao.validacao_i', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    //->stream()
                                                                    ;                          
                        break;

                    case 'n':
                        # Certidão Negativa de Imóveis
                        return \PDF::loadView('cidadao.validacao_n', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    // ->stream()
                                                                    ;                         
                        break;

                    case 'p':
                        # Certidão Negativa de Imóveis
                        return \PDF::loadView('cidadao.validacao_p', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    // ->stream()
                                                                    ;                         
                        break;

                    case 'r':
                        # Certidão Regular
                        return \PDF::loadView('cidadao.validacao_r', ['dados' => $resposta, 'numero' => $request->codigo, 'data'=> $dataAtual, 'data2'=> $dataAtual2])
                                                                     ->download('autenticacao_certidado.pdf')
                                                                    // ->stream()
                                                                    ;                         
                        break;
                }

                return view('cidadao.sucesso_integracao', ['titulo' => 'Certidões', 
                "mensagem" => '<p><strong>CERTIDÃO VÁLIDA</strong> </p>
                <p>O código informado corresponde a uma certidão emitida e dentro do período de validade</p>' ]);
                
            }
        } catch (\Exception $e) {
            dd($e);
            return view('cidadao.falha_integracao', ['titulo' => 'Certidões', 
                "mensagem" => '<p><strong>Atenção!</strong> Não foi possível verificar a autenticidade da certidão.</p>
                <p>Tente Novamente em alguns instantes.</p>
                Código: INT_1001' ]);
        }
    }

    public function servicos($guia, $aba = ""){
        Log::create([ 'servico'=> 1002,  'descricao' => "Serviços", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        if($guia == 2){
            $guia = 1;
            $titulo = "EMPRESA";
        }
        else{
            $titulo = "CIDADÃO";
        }
        $registro_guia = DB::connection('mysql')
        ->table('menu_guias')
        ->where('id', '=', $guia )
        ->get();
		if(isset(Auth::user()->cpf)){
			$cpfUsuario = str_replace(".", "",  Auth::user()->cpf);
			$cpfUsuario = str_replace("-", "",  $cpfUsuario);
			$cpfUsuario = str_replace("/", "",  $cpfUsuario);
			$cpfUsuario = str_replace(" ", "",  $cpfUsuario);

			$data1 = [
				'sTokeValiadacao'   => API_TOKEN,
				'sExec'         => API_SERVIDOR_CGM,
				'z01_cgccpf'    => $cpfUsuario,
			];
			$json_data = json_encode($data1);
			$data_string = ['json'=>$json_data];
			//dd($data_string);
				
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
			$vet_response = json_decode($response);
			if($vet_response->servidor_municipal == "SIM"){
				$registros = DB::connection('mysql')
				->table('menu_guia_assuntos')
				->where('id_guia', '=', $guia )
				->where('ativo', '=', 1 )
				->orderBy('menu_guia_assuntos.descricao', 'asc')
				->get();
			}
			else{
				$registros = DB::connection('mysql')
				->table('menu_guia_assuntos')
				->where('id_guia', '=', $guia )
				->where('ativo', '=', 1 )
				// ->where('id','<',14)
				->orderBy('menu_guia_assuntos.descricao', 'asc')
				->get();
            }
            // dd($registros, $aba);

			return view('site.servicos', ['idGuia' => $guia, 'guia' => $titulo, 'assuntos' => $registros, 'aba' => $aba]);
		}
		else{
			$registros = DB::connection('mysql')
			->table('menu_guia_assuntos')
			->where('id_guia', '=', $guia )
			->where('ativo', '=', 1 )
			// ->where('id','<',14)
			->orderBy('menu_guia_assuntos.descricao', 'asc')
			->get();
            
            // dd($registros, $aba);

			return view('site.servicos', ['idGuia' => $guia, 'guia' => $titulo, 'assuntos' => $registros, 'aba' => $aba]);
		}
	//        dd($registros);
    }

    public function noticias(){
        return view('site.noticias', [ 'pagina' => "Notícias"]);
    }

    public function validaUsuario(){
        return view('site.usuario_desatualizado');
    }

    public function faleconosco(){
        $showRecaptcha = GoogleRecaptcha::show(
            env('RECAPTCHA_SITE_KEY'), 
            'mensagem', 
            'no_debug', 
            'mt-4 mb-3 col-md-6 offset-md-4 aligncenter', 
            'Por favor clique no checkbox do reCAPTCHA primeiro!'
        );
        return view('site.faleconosco', [ 'pagina' => "FaleConosco",'showRecaptcha'=> $showRecaptcha ]);
    }

    public function contato(){
        return view('site.contato', [ 'pagina' => "Contato" ]);
    }
    
    public function enviarmensagem(Request $request){
        GoogleRecaptcha::verify(env('RECAPTCHA_SECRET_KEY'), 'Por favor clique no checkbox do reCAPTCHA primeiro!');
        Log::create([ 'servico'=> 1004,  'descricao' => "Envio de Mensagem Fale Conosco", 'cpf' => isset(Auth::user()->cpf)?Auth::user()->cpf:"", 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        $this->contact = $request->all();
        if($this->contact["name"] != ""){
            Contact::create($this->contact);

            if ($request->solicitacao == "Programa de Amparo ao Trabalhador - PAT"){
                $destino = DESTINO_FALE_CONOSCO_PAT;
            }
            else{
                $destino = DESTINO_FALE_CONOSCO;
            }
            // Mail::to("passaporteuniversitario@marica.rj.gov.br")->send(new FaleConosco($this->contact));
            Mail::to($destino)->send(new FaleConosco($this->contact));
            return view('site.welcome', [ 'mensagem' => "respostafaleconosco" ]);
        }
        else{
            return view('site.welcome');
        }
    }


    public function valida_cpf_login(Request $request){
        
        $user = $request->all();
        Log::create([ 'servico'=> 1006,  'descricao' => "Validação de CPF/CNPJ: ". $user['cpf_login'], 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
        
        $u = User::where( 'cpf', $user['cpf_login'] )->first();

//        $cpfUsuario = str_replace(".", "", $user['cpf_login']);
//        $cpfUsuario = str_replace("-", "",  $cpfUsuario);
//        $cpfUsuario = str_replace("/", "",  $cpfUsuario);
//        $cpfUsuario = str_replace(" ", "",  $cpfUsuario);
        
          $cpfUsuario = str_replace(['.', '-', '/', ' '], '', $user['cpf_login']);
        // $u = null;

        // dd($u);

        if (is_null($u)){
            Log::create([ 'servico'=> 1000,  'descricao' => "Cadastro de CPF/CNPJ no Portal: ". $user['cpf_login'], 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
            // O usário não está cadastrado no portal
            // Consulta a API para verificar se o Usuário está cadastrado no CGM
            try {
                $data1 = [
                    'sTokeValiadacao'   => API_TOKEN,
                    'sExec'         => API_CONSULTA_LOGIN,
                    'z01_cgccpf'    => $cpfUsuario,
                ];
                $json_data = json_encode($data1);
                $data_string = ['json'=>$json_data];
                
                $ch = curl_init();
            
                curl_setopt_array($ch, array(
                    CURLOPT_URL => API_URL . API_LOGIN,
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

                //dd($response);

                $resposta=json_decode($response);

                if($resposta->iStatus == 2){
                    // Usuário não cadastro no CGM
                    // Informa ao usuário que deverá ir pessoalmente a uma unidade SIM
                    Log::create([ 'servico'=> 1000,  'descricao' => "CPF/CNPJ sem cadastro no CGM: ". $user['cpf_login'], 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                    // return view('site.usuario_nao_cadastrado');
                    return redirect()->route('atualizaCGM')->with('pagina', "principal");
                }
                else{
                    // Consulta a API para verificar se as informações estão atualizadas
                    $data1 = [
                        'sTokeValiadacao'   => API_TOKEN,
                        'sExec'         => API_VERIFICA_CADASTRO,
                        'z01_cgccpf'    => $cpfUsuario,
                    ];
                    $json_data = json_encode($data1);
                    $data_string = ['json'=>$json_data];
                    
                    $ch = curl_init();
                
                    curl_setopt_array($ch, array(
                        CURLOPT_URL => API_URL . API_LOGIN,
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

                    $resposta=json_decode($response);
                    
                    if($resposta->iStatus == 1){

                        $servidor = $this->recuperaServidor($cpfUsuario);
            

                        // *******************************
                        // Direcionando para forçar o cadastro ATUALIZADO
                        // REMOVER REMOVER REMOVER REMOVER REMOVER REMOVER
                        if( $_SERVER['HTTP_HOST'] == 'ticmarica.com.br'){
                            $resposta->k00_atualizado = "S";

                            // $servidor["servidor"] = "SIM";
                        }
                        // *******************************
                        
                        // dd($servidor["servidor"]);

                        
                        if($resposta->k00_atualizado == "N"){
                            // Cadastro desatualizado
                            Log::create([ 'servico'=> 1000,  'descricao' => "CPF/CNPJ desatualizado no CGM: ". $user['cpf_login'], 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                            // return view('site.usuario_desatualizado', ['servidor' => $servidor["servidor"] ]);
                            return redirect()->route('atualizaCGM')->with('pagina', "principal");
                        }
                        else{
                            // Cadastro Atualizado
                            // dd($resposta);
                            // dd("Cadastro Atualizado");


                            // Recuperando dados do CGM...
                            $data1 = [
                                'sTokeValiadacao'   => API_TOKEN,
                                'sExec'         => API_CONSULTA_CGM,
                                'z01_cgccpf'    => $cpfUsuario,
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
                            // dd($userCGM);

                            // ***********************
                            // REMOVER REMOVER REMOVER REMOVER REMOVER REMOVER
                            if( $_SERVER['HTTP_HOST'] == 'ticmarica.com.br'){
                                $userCGM->aCgmContato->z01_email = "mizael.barbosa@gmail.com";
                            }
                            // ***********************

                            
                            if($userCGM->aCgmContato->z01_email != ""){
                                $arrayUsuario = [
                                    'cpf'               => $user['cpf_login'],
                                    'name'              => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmPessoais->z01_nome))),
                                    'email'             => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmContato->z01_email))),
                                    'email_verified_at' => date("Y-m-d H:i:s"),
                                    'password'          => Hash::make("SenhaPadraodeAcessoaoPortal2018@!"),
                                    'celphone'          => ($userCGM->aCgmContato->z01_telcel==""?"(21)00000-0000":utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$userCGM->aCgmContato->z01_telcel)))),
                                ];
        
                                $returnUser = User::create($arrayUsuario);
                                // dd($returnUser);
                                
                                // $token = app(\Illuminate\Auth\Passwords\PasswordBroker::class)->createToken($returnUser);
                                $token = str_random(60);
        
                                DB::table('password_resets')->insert([
                                    'email' => utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmContato->z01_email))),
                                    'token' => $token,
                                    'created_at' => Carbon::now()
                                ]);
        
                                $resposta = $returnUser->sendPasswordMakeNotification($token);
                                
                                // dd($resposta);
                                
                                Log::create([ 'servico'=> 1000,  'descricao' => "E-mail para cadastramento de senha enviado (". $user['cpf_login'] ." - ". utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1', $userCGM->aCgmContato->z01_email))) .")", 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                                return view('site.usuario_envio_senha');
                            }
                            else{
                                Log::create([ 'servico'=> 1000,  'descricao' => "CPF/CNPJ sem e-mail cadastrado no CGM: ". $user['cpf_login'], 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                                return view('site.usuario_sem_email');
                            }
                        }
                        
                    }
                    else{
                        /////// Final do Log
                        // Erro na resposta
                        // Informa ao usuário que deverá ir pessoalmente a uma unidade SIM
                        Log::create([ 'servico'=> 1000,  'descricao' => "RETORNO 2 da API - " . API_VERIFICA_CADASTRO , 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                        return view('site.usuario_nao_cadastrado');
                    }
                }
                // return redirect()->route('register')->with('cpf',$user['cpf_login']);
            } catch (\Exception $e) {
                // dd($e);
                Log::create([ 'servico'=> 1000,  'descricao' => "ERRO NA INTEGRAÇÃO " , 'cpf' => $user['cpf_login'], 'data' =>  date('Y-m-d H:i:s'), 'browser' => $_SERVER['HTTP_USER_AGENT'], 'ip' => $_SERVER['REMOTE_ADDR'], ]);
                return view('site.usuario_falha_integracao');
            }
        }
        else{
            return redirect()->route('login')->with('cpf',$user['cpf_login']);
        }

    }

    public function valida_cpf_cadastro($id){

        $u = User::where( 'cpf', $id )->first();
        if (is_null($u)){
            return redirect()->route('register')->with('cpf',$id);
        }
        else{
            return redirect()->route('login')->with('cpf',$id);
        }
    }

    public function pesquisa_solicitacao($solicitacao){

        $registros = DB::connection('lecom')
            ->table('v_fale_conosco')
            ->where('solicitacao', '=', $solicitacao )
            ->orderBy('assunto', 'asc')
            ->get();

        return $registros->all();   
        
    }

    public function lecomAtualizaCgm($chamado = "", $status = 0)
    {
        echo "<pre>";
        echo "*****************************************************************\n";
        echo "Pesquisando solicitações pendentes...\n";

        if ($chamado == ""){
            $dadosPendentes = DB::table('cgm_lecom')
            ->select(DB::raw('count(*) as cod_count, cod_lecom'))
            ->where('status',   '=', 0 )
            ->groupby("cod_lecom")
            ->get();
        }
        else{
            $dadosPendentes = DB::table('cgm_lecom')
            ->select(DB::raw('count(*) as cod_count, cod_lecom'))
            ->where('cod_lecom',   '=', $chamado )
            ->where('status',   '=', 0 )
            ->groupby("cod_lecom")
            ->get();
        }

        echo "Solicitações pendentes encontradas: " . count($dadosPendentes) . "\n";
        // dd($dadosPendentes);
        foreach ($dadosPendentes as $campo){
            echo "\nconsultado Chamado no lecom: " . $campo->cod_lecom. "\n";
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('Chamado', '=', $campo->cod_lecom )
            ->get();

            // dd($registros);

            if (count($registros)> 0 ){
                echo "Status do Chamado: <b>" . $registros[0]->FINALIZADO. "</b>\n";

                if($status == 1 || $status == 2){
                    echo "<b>Forçando o status do chamado para Finalizado.</b>\n";
                    if ($status == 1){ // Hack: Cadastro aprovado
                        $registros[0]->FINALIZADO = "concluído";
                        echo "<b>Forçando a Fase do chamado para APROVADO.</b>\n";
                        $registros[0]->Fase = "Cadastro Aprovado";
                    }
                    elseif ($status == 2){ // Hack: Cadastro Reprovado
                        $registros[0]->FINALIZADO = "concluído";
                        echo "<b>Forçando a Fase do chamado para REPROVADO.</b>\n";
                        $registros[0]->Fase = "Reprovado";
                    }
                }
                elseif ($status == 3){ // Hack: Chamado Cancelado
                    echo "<b>Forçando o cancelamento do chamado.</b>\n";
                    $registros[0]->FINALIZADO = "cancelado";
                }
                

                // Verifica se o processo terminou
                if ( $registros[0]->FINALIZADO == "cancelado" ||  $registros[0]->Fase == "Reprovado" ){
                    echo "Chamado Cancelado\n";
                    echo "Registrando que o Chamado já foi tratado". "\n";
                    // atualiza o status
                    DB::table('cgm_lecom')
                    ->where('cod_lecom',   '=', $campo->cod_lecom )
                    ->update([
                        'status' => 1
                        ]);   
                    DB::table('cgm_documentos')
                    ->where('cod_lecom',   '=', $campo->cod_lecom )
                    ->update([
                        'status' => 1
                        ]);   
                }
                elseif( $registros[0]->FINALIZADO == "concluído"){
                    echo "Fase do Chamado: <b>". $registros[0]->Fase . "</b>\n";
                    // Verifica se as alterações foram aprovadas
                    // if ($registros[0]->Fase == "Cadastro Aprovado"){
                    if ($registros[0]->Fase == "Cadastro Reprovado"){
                        echo "Registrando que o Chamado já foi tratado". "\n";
                        // atualiza o status
                        DB::table('cgm_lecom')
                        ->where('cod_lecom',   '=', $campo->cod_lecom )
                        ->update([
                            'status' => 1
                            ]);  
                        DB::table('cgm_documentos')
                        ->where('cod_lecom',   '=', $campo->cod_lecom )
                        ->update([
                            'status' => 1
                            ]);                              
                    }
                    elseif ($registros[0]->Fase == "Cadastro Aprovado"){
                        echo "Atualizando as informações no e-Cidades...". "\n";
                        try {
                            $composCamado = DB::table('cgm_lecom')
                            ->where('cod_lecom',  '=', $campo->cod_lecom )
                            ->get();
                            
                            // dd($composCamado);

                            // Atualiza as informações no e-Cidades
                            $cpfUsuario = str_replace(".", "", $composCamado[0]->cpf);
                            $cpfUsuario = str_replace("-", "", $cpfUsuario);
                            $cpfUsuario = str_replace("/", "", $cpfUsuario);
                            $cpfUsuario = str_replace(" ", "", $cpfUsuario);
                        
                            $data1 = [
                                'sTokeValiadacao'   => API_TOKEN,
                                'sExec'             => API_ATUALIZA_CGM,
                                'z01_cgccpf'        => $cpfUsuario,
                            ];
                            $data2 = [
                                'sTokeValiadacao'   => API_TOKEN,
                                'sExec'             => API_ATUALIZA_ENDERECO_CGM,
                                'sCpfcnpj'          => $cpfUsuario,
                                'sTipoEndereco'     => "P",
                            ];

                            $conta_data1 = 0;
                            $conta_data2 = 0;
                            // pega os campos alterados e monta a chamada da API
                            foreach ($composCamado as $c){
                                $campoApi = "";
                                $campoApiEnd = "";
                                switch($c->campo){
                                    case 'mae':
                                        $campoApi = "z01_mae";
                                        break;
                                    case 'pai':
                                        $campoApi = "z01_pai";
                                        break;
                                    case 'nascimento':
                                        $campoApi = "z01_nasc";
                                        break;
                                    case 'falecimento':
                                        $campoApi = "z01_dtfalecimento";
                                        break;
                                    case 'estadoCivil':
                                        $campoApi = "z01_estciv";
                                        break;
                                    case 'sexo':
                                        $campoApi = "z01_sexo";
                                        break;
                                    case 'nacionalidade':
                                        $campoApi = "z01_nacion";
                                        break;
                                    case 'escolaridade':
                                        $campoApi = "z01_escolaridade";
                                        break;
                                    case 'inscrEst':
                                        $campoApi = "z01_incest";
                                        break;                                        
                                    case 'nomeFanta':
                                        $campoApi = "z01_nomefanta";
                                        break;                                        
                                    case 'cep':
                                        $campoApiEnd = "sCep";
                                        break;
                                    case 'uf':
                                        $campoApiEnd = "iCodigoEstado";
                                        break;
                                    case 'municipio':
                                        $campoApiEnd = "sDescMunicipio";
                                        break;
                                    case 'bairro':
                                        $campoApiEnd = "sDescBairro";
                                        break;
                                    case 'endereco':
                                        $campoApiEnd = "sDescRua";
                                        break;
                                    case 'numero':
                                        $campoApiEnd = "sNumeroLocal";
                                        break;
                                    case 'complemento':
                                        $campoApiEnd = "sDescricaoComplemento";
                                        break;
                                    case 'CodBairro':
                                        $campoApiEnd = "iCodBairro";
                                        break;
                                    case 'CodRua':
                                        $campoApiEnd = "iCodRua";
                                        break;
                                    case 'CodMunicipio':
                                        $campoApiEnd = "iCodigoMunicipio";
                                        break;
                                    case 'morador':
                                        $campoApiEnd = "iMunicipio";
                                        break;
                                    
                                }

                                if($campoApi != ""){
                                    $data1 = array_merge($data1, array($campoApi => $c->valor_novo));
                                    $conta_data1++;
                                }

                                if($campoApiEnd != ""){
                                    $data2 = array_merge($data2, array($campoApiEnd => $c->valor_novo));
                                    $conta_data2++;
                                }
                            }
                            
                            // dd($data1, $data2);
                            
                            $json_data = json_encode($data1);
                            $json_data2 = json_encode($data2);
                            $data_string = ['json'=>$json_data];
                            $data_string2 = ['json'=>$json_data2];

                            print_r($data_string2);
                            if($conta_data1>0){                             
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
                            }
                            if($conta_data2>0){
                                $ch = curl_init();
                            
                                curl_setopt_array($ch, array(
                                    CURLOPT_URL => API_URL . API_CGM,
                                    CURLOPT_RETURNTRANSFER => true,
                                    CURLOPT_TIMEOUT => 30000,
                                    CURLOPT_CUSTOMREQUEST => "POST",
                                    CURLOPT_POSTFIELDS => http_build_query($data_string2),
                                    CURLOPT_HTTPHEADER => array(
                                        'Content-Length: ' . strlen(http_build_query($data_string2))
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
                            }
                            
                            $respostaInt=json_decode($response);

                            print_r($respostaInt);
                            if($respostaInt->iStatus=== 2){
                                echo "**** Falha ****\n";
                                echo "Falha ao tentar atualizar as informações no e-Cidades\n";
                            }
                            else {
                                echo "**** Sucesso ****\n";
                                echo "As informações foram atualizadas no e-Cidades\n";
                                echo "Registrando que o Chamado já foi tratado". "\n";
                                // atualiza o status
                                DB::table('cgm_lecom')
                                ->where('cod_lecom',   '=', $campo->cod_lecom )
                                ->update([
                                    'status' => 1
                                    ]);
                                DB::table('cgm_documentos')
                                ->where('cod_lecom',   '=', $campo->cod_lecom )
                                ->update([
                                    'status' => 1
                                    ]);                                    
                                echo "Chamado: ".$campo->cod_lecom." atualizado\n";
                            }
            
                        } catch (\Exception $e) {
                            // dd($e);
                            echo "**** Erro ****\n";
                        }
                    }
                }
            }
        }
        echo "\n\nFim da pesquisa";
        
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

            // dd(API_URL . API_CGM, $data_string, $resposta);

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

    public function fileDownload($id)
    {
        if ($id == 2){
            $file= public_path(). "/docs/DOCUMENTOS_ESSENCIAIS_ITBI.pdf";
            $filename= "DOCUMENTOS_ESSENCIAIS_ITBI.pdf";

            $headers = array(
                'Content-Type: application/pdf',
            );
        }
        elseif ($id == 1){
            $file= public_path(). "/docs/ITBI_FORMULARIO_DE_SOLICITACAO.docx";
            $filename= "ITBI_FORMULARIO_DE_SOLICITACAO.docx";

            $headers = array(
                'Content-Type: application/docx',
            );
        }
        elseif ($id == 3){
            $file= public_path(). "/docs/AUTODECLARACAO.pdf";
            $filename= "AUTODECLARACAO.pdf";

            $headers = array(
                'Content-Type: application/pdf',
            );
        }

        return response()->download($file, $filename, $headers);
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
}