<?php
namespace App\Http\Controllers\Site;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Config;
use App\Models\Notice;
use Carbon\Carbon;
use App\Processo;
use App\User;
use Auth;
use DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    private $processo;
    public function __construct(Processo $processo)
    {
        $this->processo = $processo;
        $this->middleware(['auth', 'verified']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $noticias = Notice::where( 'status', 1 )->get();
        return view('site.home',  ['noticias' => $noticias->toArray(), "pagina" => "Principal" ]);
    }

    public function filtroConsulta(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->orderBy('Chamado','desc')
            ->get();
        $x = collect($registros->all());
        
        // dd($x);

        return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta" ] );            
    }

    public function acompanhamento(Request $request)
    {
        $pesquisa = $request->all();
        
        //  dd( $pesquisa );
        if( $pesquisa['chamado'] != ""){
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Chamado','=', $pesquisa['chamado'])
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->get();
        }
        elseif( $pesquisa['Situacao'] != ""){
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('fase','=', $pesquisa['Situacao'])
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->get();
        }
        elseif( $pesquisa['responsavel'] != ""){
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('responsavel','=', $pesquisa['responsavel'])
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->orderBy('Chamado','desc')
            ->get();
        }
        elseif( $pesquisa['Servico'] != ""){
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço','=', $pesquisa['Servico'])
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->orderBy('Chamado','desc')
            ->get();
        }
        elseif( $pesquisa['dataIni'] != ""){
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('abertura', '>=', $pesquisa['dataIni']." 00:00:00")
            ->where('abertura', '<=', $pesquisa['dataFim']." 00:00:00")
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->orderBy('Chamado','desc')
            ->get();
        }
        else{
            $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            // ->where('FINALIZADO', '!=', "cancelado" )
            ->orderBy('Chamado','desc')
            ->get();
        }
        
        $x = collect($registros->all());
        
// dd($x);

        return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta" ] );
    }

    public function formulario($guia,$assunto,$servico)
    {
        $servico = str_replace("_","/",$servico);
        if($servico == "Certidão Negativa de débitos"){
            return view('certidao.certnegativadebitos' );
        }

        // if($guia == "Passaporte Universitário"){
        //     // $servico = "Abatimento";
        //     $serv = DB::connection('lecom') 
        //     ->table('v_consulta_servico_sim')
        //     ->where('Serviço', '=', $servico )
        //     ->where('cpf', '=', Auth::user()->cpf )
        //     ->limit(1)
        //     ->get();

        //     if (count($serv) > 0 ){
        //         $registros = DB::connection('lecom')
        //         ->table('v_consulta_servico_sim')
        //         ->where('cpf', '=', Auth::user()->cpf )
        //         ->where('Chamado','=', $serv[0]->Chamado)
        //         ->get();
        //         $x = collect($registros->all());
        //         return view('site.acompanhamento', ['registros' => $x, "pagina" => "Consulta", 'pass' => '1'] );
        //     };
        // }
            // dd($guia);
            // dd($assunto);
            // dd($servico);


        $serv = DB::connection('lecom')
        ->table('v_catalogo_sim')
        ->where('guia', '=', $guia )
        ->where('assunto', '=', $assunto )
        ->where('servico', '=', $servico )
        ->get();

        if ($serv[0]->processo == "0" and $serv[0]->versao == "0"){
            return redirect()->route('sigelu')->with('servico', $servico);
        }

        // dd($serv);
        $infoForm = $this->formularioBPM($servico,$serv[0]->processo,$serv[0]->versao);
        // dd($infoForm);
        
        if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){
            $uuid = DB::connection('lecom')
            ->table('processo_etapa')
            ->select('uuid')
            ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
    
            $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
    
            return view('site.formulario',[
                'guia' => $guia, 
                'assunto' => $assunto, 
                'servico' => $servico,
                'infoForm' => $infoForm, 
                'uuid' => $uuid[0]->{'uuid'},
                'caminho' => $caminho,
                'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                ]);
        }
        else{
            return redirect()->route('home')->with('erroServico', 1);
        }
    }

    // public function servicos($guia)
    // {
    //     $registros = DB::connection('lecom')
    //     ->table('v_catalogo_sim')
    //     ->select(DB::raw('count(*) as assunto_count, assunto'))
    //     ->where('guia', '=', $guia )
    //     ->orderBy('assunto', 'asc')
    //     ->groupBy('assunto')
    //     ->get();
    //     return view('site.servicos', ['guia' => $guia, "assuntos" => $registros ]);
    // }

    public function servicos_documentos()
    {
        return view('site.servicos_documentos');
    }

    public function servicos_tributos()
    {
        return view('site.servicos_tributos');
    }

    public function alterarSenha()
    {
        return view('site.perfil_senha', [ "pagina" => "perfil" ]);
    }

    public function alterarSenhaSave(Request $request)
    {
        $validatedData = $request->validate([
            'password_atual'    => ['required', 'string', 'min:6'],
            'password'          => ['required', 'string', 'min:6', 'confirmed', 'different:password_atual'],
            'confirm_password'  => ['required_with:new_password', 'same:new_password','string','min:6'],
        ]);
        if (Hash::check($request->get('password_atual'), Auth::user()->password)) {
            $request['password'] = Hash::make($request['password']);
            $user = User::find( Auth::user()->id );
            $u = $user->update( $request->all() );
            return view('site.perfil_save', [ "pagina" => "perfil" ]);
        }
        else {
            return redirect()->back()->withInput()->withErrors( ["password_atual"=>"A Senha atual é inválida"] );
        }
    }



    public function perfilSave(Request $request){
        if(strlen($request['cpf'])<=14){
            $validatedData = $request->validate([
                'cpf'               => ['required', 'cpf', Rule::unique('users')->ignore(Auth::user()->id) ],
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                'voterstitle'       => ['required'],
                'orgao_emissor'     => ['required', 'string', 'min:2', 'max:10'],
                'dt_expedicao'      => ['required', 'date'],            
                'celphone'          => ['required', 'string', 'min:8'],
                'birthdate'         => ['required', 'date'],
                'sex'               => ['required'],
                'mothersname'       => ['required', 'string', 'min:6'],
                'cep'               => ['required', 'string', 'min:6'],
                'uf'                => ['required', 'string', 'min:2', 'max:2'],
                'city'              => ['required', 'string'],
                'district'          => ['required', 'string'],
                'address'           => ['required', 'string'],
                'number'            => ['required', 'string'],
            ]);
        }
        else{
            $validatedData = $request->validate([
                'cpf'               => ['required', 'cnpj', Rule::unique('users')->ignore(Auth::user()->id) ],
                'name'              => ['required', 'string', 'max:255'],
                'email'             => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore(Auth::user()->id)],
                'celphone'          => ['required', 'string', 'min:8'],
                'cep'               => ['required', 'string', 'min:6'],
                'uf'                => ['required', 'string', 'min:2', 'max:2'],
                'city'              => ['required', 'string'],
                'district'          => ['required', 'string'],
                'address'           => ['required', 'string'],
                'number'            => ['required', 'string'],
                'nome_responsavel'      => ['required', 'string'],
                'nome_razao_social'     => ['required', 'string'],
                'inscricao_estadual'    => ['required', 'string'],
            ]);
        }
        // $request['password'] = Hash::make($request['password']);
        $user = User::find( Auth::user()->id );
        $u = $user->update( $request->all() );
        return view('site.perfil_save', [ "pagina" => "perfil" ]);
            
    }

    public function alvara_consulta()
    {
        $infoForm = $this->formularioBPM('Consulta de Alvará');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();

        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.alvara_consulta',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function alvara_certidao()
    {
        $infoForm = $this->formularioBPM('Certidão de Ausência de Atividade Econômica');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.alvara_certidao',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function certidao()
    {

        dd("Certidão Negativa de Débito");
        
        $infoForm = $this->formularioBPM('Certidão Negativa de Débito');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.certidao',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function iptu_abatimento()
    {
        $infoForm = $this->formularioBPM('Abatimento');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.iptu_abatimento',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function iptu_cadastramento()
    {
        $infoForm = $this->formularioBPM('Cadastramento CPF/CNPJ');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.iptu_cadastramento',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function iss_guia()
    {
        $infoForm = $this->formularioBPM('Guia: Alterações');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.iss_guia',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    public function iss_pagamento()
    {
        $infoForm = $this->formularioBPM('Pagamento: Prazos');
        $uuid = DB::connection('lecom')
        ->table('processo_etapa')
        ->select('uuid')
        ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
        $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
        return view('site.iss_pagamento',['infoForm' => $infoForm, 'uuid' => $uuid[0]->{'uuid'},'caminho' => $caminho]);
    }

    private function ticketSSO()
    {
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
        // dd($data_string);
        
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
        //  dd(SISTEMACAMINHOBASE."/".CAMINHORELATIVO,$data_string, $response, getcwd().'/cert/' . SSL_LECOM);

        return $response;
    }

    public function formularioBPM($servico, $processo, $versao, $instituicao = ""){
        $ticket = json_decode($this->ticketSSO());
        foreach ( $ticket as $ticketId ){
        }   
        $campos = DB::connection('lecom')
        ->table('v_catalogo_sim')
        ->select('json')
        ->where('processo', '=', $processo )
        ->where('versao', '=', $versao )
        ->get();
        
        $fields = $this->formataJson($campos[0]->json, $servico, $instituicao);

        // dd($fields);

        $url = str_replace(":processo",$processo, SISTEMACAMINHOBASE.CAMINHO);
        $url = str_replace(":versao",$versao, $url);

        // dd($url);
        
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
        // dd($url,$fields, $retorno);
        return $retorno;
    }

    public function formataJson($json, $servico, $instituicao = ""){

        $cgm = (object) $this->recuperaCGM(Auth::user()->cpf);

        $cgmEnderecoPrimario = (object) $this->recuperaEnderecoCGM(Auth::user()->cpf,"P");

        // dd($cgm, $cgmEnderecoPrimario);

        
        $json = str_replace("[cep]", $cgmEnderecoPrimario->endereco->endereco->iCep, $json);
        $json = str_replace("[endereco]",utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgmEnderecoPrimario->endereco->endereco->sRua))), $json);
        $json = str_replace("[rua]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgmEnderecoPrimario->endereco->endereco->sRua))), $json);
        $json = str_replace("[numero]", $cgmEnderecoPrimario->endereco->endereco->sNumeroLocal, $json);
        $json = str_replace("[complemento]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgmEnderecoPrimario->endereco->endereco->sComplemento))), $json);
        $json = str_replace("[bairro]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgmEnderecoPrimario->endereco->endereco->sBairro))), $json);
        $json = str_replace("[cidade]", utf8_encode(urldecode(iconv('UTF-8', 'ISO-8859-1',$cgmEnderecoPrimario->endereco->endereco->sMunicipio))), $json);
        $json = str_replace("[uf]", $cgmEnderecoPrimario->endereco->endereco->sUf, $json);
        $json = str_replace("[UF]",$cgmEnderecoPrimario->endereco->endereco->sUf, $json);
        $json = str_replace("[celulcar]", Auth::user()->celphone, $json);
        $json = str_replace("[celular]", Auth::user()->celphone, $json);
        $json = str_replace("[telefone]", Auth::user()->phone, $json);
        $json = str_replace("[fixo]", Auth::user()->phone, $json);
        $json = str_replace("[email]", Auth::user()->email, $json);
        $json = str_replace("[CPF_CNPJ]", (strlen(Auth::user()->cpf)<=14?"CPF":"CNPJ"), $json);
        $json = str_replace("[tipo]", (strlen(Auth::user()->cpf)<=14?"CPF":"CNPJ"), $json);
        $json = str_replace("[cpf]", (strlen(Auth::user()->cpf)<=14?Auth::user()->cpf:""), $json);
        $json = str_replace("[CPF]", (strlen(Auth::user()->cpf)<=14?Auth::user()->cpf:""), $json);
        $json = str_replace("[CNPJ]", (strlen(Auth::user()->cpf)>14?Auth::user()->cpf:""), $json);
        $json = str_replace("[cnpj]", (strlen(Auth::user()->cpf)>14?Auth::user()->cpf:""), $json);
        $json = str_replace("[id]", Auth::user()->voterstitle, $json);
        $json = str_replace("[orgaoemissor]", Auth::user()->orgao_emissor, $json);

        $json = str_replace("[data]", $cgm->cgm->aCgmPessoais->z01_nasc , $json);
        if($cgm->cgm->aCgmPessoais->z01_nasc != ""){
            $json = str_replace("[nascimento]", $cgm->cgm->aCgmPessoais->z01_nasc, $json);
        }
        else{
            $json = str_replace("[nascimento]", "0000-00-00", $json);
        }
        
        $json = str_replace("[nomemae]", Auth::user()->mothersname, $json);
  
        if (strlen(Auth::user()->cpf)>14){
            $json = str_replace("[nome]", Auth::user()->nome_razao_social, $json);
            $json = str_replace("[nome_fantasia]", Auth::user()->name, $json);
            $json = str_replace("[genero]", "", $json);
            $json = str_replace("[sexo]", "", $json);
        }
        else{
            $json = str_replace("[nome]", Auth::user()->name, $json);
            $json = str_replace("[nome_fantasia]", "", $json);
            $json = str_replace("[genero]", Auth::user()->sex=="M"?"Masculino":"Feminino", $json);
            $json = str_replace("[sexo]", Auth::user()->sex=="M"?"Masculino":"Feminino", $json);
        }
        $json = str_replace("[razao_social]", Auth::user()->nome_razao_social, $json);
        $json = str_replace("[inscricao_estadual]", Auth::user()->inscricao_estadual, $json);
        
        $json = str_replace("[servico]", $servico, $json);
        $json = str_replace("[instituicao]", $instituicao, $json);
        return $json;
    }

    public function cadAvisos(){
        $user = User::find( Auth::user()->id );
        if ($user['admin']){
            $noticias = Notice::where( 'status', 1 )->get();
            return view('site.avisos')->with( 'noticias', $noticias->toArray() );
        }
        else{
            return redirect()->route('home');
        }
    }

    public function avisoEdit($id){
        $user = User::find( Auth::user()->id );
        if ($user['admin']){
            return view('site.aviso_edit');
        }
        else{
            return redirect()->route('home');
        }
    }

    public function avisoNovo(){
        $user = User::find( Auth::user()->id );
        if ($user['admin']){
            return view('site.aviso_novo');
        }
        else{
            return redirect()->route('home');
        }
    } 

    public function avisoSave(Request $request){
        $validatedData = $request->validate([
            'title'     => ['required', 'string', 'max:50'],
            'text'      => ['required', 'string', 'max:190'],
            'image'     => ['required', 'string', 'max:190'],
            'url'       => ['required', 'string', 'max:190'],
        ]);
        $this->notice = $request->all();
        Notice::create($this->notice);
        return redirect()->route('cadAvisos');
    }

    public function formularioEditaCGM(){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            ->where('cpf', '=', Auth::user()->cpf )
            ->where('Serviço','=', 'CGM')
            ->orderBy('Chamado', 'desc')
            ->limit(1)
            ->get();
        if ($registros->count() > 0){
            // dd($registros[0]->Chamado);
            return redirect()->route('formularioEdita', [$registros[0]->Chamado]);
        }
        else{
            if(strlen( Auth::user()->cpf) <= 14 ){ // Pessoa Jurídica
                // dd("PF");
                $this.formulario("Cadastro Geral Município","Pessoa Física","'Cadastro Geral do Município - PF'");
            }
            else{ // Pessoa Física
                // dd("PJ");
                $this.formulario("Cadastro Geral Município","Pessoa Jurídica","'Cadastro Geral do Município - PJ'");
            }
        }
    }
    
    public function formularioEdita($chamado){
        $registros = DB::connection('lecom')
            ->table('v_consulta_servico_sim')
            // ->where('cpf', '=', Auth::user()->cpf )
            ->where('Chamado','=', $chamado)
            ->get();
            
      
            
            // dd($registros[0]);
        if ( $registros->count() ){
            $servico = $registros[0]->Serviço;

            $serv = DB::connection('lecom')
                ->table('v_catalogo_sim')
                ->where('servico', '=', $servico )
                ->get();
    
            // dd($servico);
            $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
            
            $altura = "2000px";
            $header = true;

            if ( $serv->count() ){
                return view('site.formulario',[
                    'pagina' => "Serviços",
                    'guia' => $serv[0]->guia, 
                    'assunto' => $serv[0]->assunto, 
                    'servico' => $servico,
                    'infoForm' => "", 
                    'uuid' => $registros[0]->uuid,
                    'caminho' => $caminho,
                    'header'=> $header,
                    "altura" => $altura,                    
                    'processInstanceId' => $chamado,
                    'activityInstanceId' => $registros[0]->Etapa,
                    'cycle' => $registros[0]->Ciclo
                    ]);
            }
            else{
                return redirect()->route('acompanhamento')->with( 'erroServico', 1 );
            }
        }
        else{
            return redirect()->route('acompanhamento')->with( 'erroServico', 1 );
        }
    }    
    
    public function itbionline(){
        if(strlen( Auth::user()->cpf) <= 14 ){ // Pessoa Jurídica
            $guia = 'Cidadão';
        }
        else{
            $guia = 'Empresa';
        }
        $assunto = 'Tributos';
        $servico = 'Solicitação de ITBI';

        $serv = DB::connection('lecom')
        ->table('v_catalogo_sim')
        ->where('guia', '=', $guia )
        ->where('assunto', '=', $assunto )
        ->where('servico', '=', $servico )
        ->get();

        $infoForm = $this->formularioBPM($servico,$serv[0]->processo,$serv[0]->versao);
        // dd($infoForm);
        
        if(isset($infoForm['resposta']->{'content'}->{'processInstanceId'})){

            $usuarioITBI = DB::connection('itbi')
            ->table('users')
            ->select('id')
            ->where('cpf', '=', Auth::user()->cpf )->get();

            DB::connection('itbi')
            ->table('itbi_socilitacoes')->insert(
				[
					'cpf' => Auth::user()->cpf, 
					'id_usuario' => $usuarioITBI[0]->id, 
					'id_solicitacao' => $infoForm['resposta']->{'content'}->{'processInstanceId'}, 
					'uuid' => $infoForm['resposta']->{'content'}->{'uuid'}, 
					'data' => date('Y-m-d H:i:s')
				]
			);

            $uuid = DB::connection('lecom')
            ->table('processo_etapa')
            ->select('uuid')
            ->where('COD_PROCESSO', '=', $infoForm['resposta']->{'content'}->{'processInstanceId'} )->get();
    
            $caminho = SISTEMACAMINHOBASE.LECOMFORMS;
    
            return view('site.formulario',[
                'guia' => $guia, 
                'assunto' => $assunto, 
                'servico' => $servico,
                'infoForm' => $infoForm, 
                'uuid' => $uuid[0]->{'uuid'},
                'caminho' => $caminho,
                'processInstanceId' => $infoForm['resposta']->{'content'}->{'processInstanceId'},
                'activityInstanceId' => $infoForm['resposta']->{'content'}->{'currentActivityInstanceId'},
                'cycle' => $infoForm['resposta']->{'content'}->{'currentCycle'}
                ]);
        }
        else{
            return redirect()->route('home')->with('erroServico', 1);
        }

    }

    public function DetectaEtapa($chamado){
        
        $registros = DB::connection('lecom')
        ->table('v_consulta_servico_sim')
        ->where('cpf', '=', Auth::user()->cpf )
        ->where('Chamado','=', $chamado)
        ->get();
        
        return$registros[0]->Etapa;
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
}