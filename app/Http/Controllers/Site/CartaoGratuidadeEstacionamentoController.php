<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Cidadao\CgmController;
use App\Models\Notice;
use App\Models\Contact;
use App\Models\Log;
use App\Models\CartaoGratuidadeEstacionamento;
use App\Models\CartaoGratuidadeDocumento;
use App\User;
use Carbon\Carbon;
use Auth;
use DB;

class CartaoGratuidadeEstacionamentoController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }

    public function index($id_table=0){
            $class_cgm = new CgmController();
            $cgm = $class_cgm->recuperaCGM(Auth::user()->cpf);
            $cgm_endereco = $class_cgm->recuperaEnderecoCGM(Auth::user()->cpf,"P");

//            dd($cgm_endereco['endereco']);
//            dd($cgm['cgm']);

            $nome = str_replace('+',' ',$cgm['cgm']->aCgmPessoais->z01_nome);
            $rg = $cgm['cgm']->aCgmAdicionais->z01_ident;
            $orgao = str_replace('%2',' ',$cgm['cgm']->aCgmAdicionais->z01_identorgao);
            $bairro = str_replace('+',' ',$cgm_endereco['endereco']->endereco->sBairro);
            $cidade = str_replace('+',' ',str_replace('%E7','Ç',str_replace('%E3','Ã',$cgm_endereco['endereco']->endereco->sMunicipio)));
            $telefone = "(".substr($cgm['cgm']->aCgmContato->z01_telef,0,2).") ".substr($cgm['cgm']->aCgmContato->z01_telef,2,4)."-".substr($cgm['cgm']->aCgmContato->z01_telef,6,4);
            $celular = "(".substr($cgm['cgm']->aCgmContato->z01_telcel,0,2).") ".substr($cgm['cgm']->aCgmContato->z01_telcel,2,5)."-".substr($cgm['cgm']->aCgmContato->z01_telcel,7,4);
            $profissao = str_replace('+',' ',$cgm['cgm']->aCgmAdicionais->z01_profis);
            $email = str_replace('%40','@',$cgm['cgm']->aCgmContato->z01_email);

            $registros_id = DB::connection('mysql')
            ->table('lecom_cartao_gratuidade_documentos')
            ->select('id')
            ->where('cpf','=',Auth::user()->cpf)
            ->get();

            foreach($registros_id as $ids){
                $id = $ids->id;
            }

            $registros = DB::connection('mysql')
            ->table('lecom_cartao_gratuidade_documentos')
            ->where('id_cge','=',0)
            ->where('cpf','=',Auth::user()->cpf)
            ->get();

            $qtd_registros = count($registros);

            if(!is_null(session('solicitacao'))){
                $solicitacao = session('solicitacao');
            }
            else{
                $solicitacao = "";
            }

            if(!is_null(session('data_validade'))){
                $data_validade = session('data_validade');
            }
            else{
                $data_validade = "";
            }

            return view('site.cartao_gratuidade_estacionamento', [ 'pagina' => 'Cartão de Gratuidade de Estacionamento', 'cpf' => Auth::user()->cpf, 'nome' => $nome, 'rg' => $rg, 'orgao' => $orgao, 'bairro' => $bairro, 'cidade' => $cidade, 'telefone' => $telefone,'celular' => $celular, 'profissao' => $profissao, 'email' => $email, 'qtd_registros' => $qtd_registros, 'registros' => $registros,'solicitacao' => $solicitacao,'data_validade' => $data_validade ]);
    }

    public function imageUploadPost(Request $request){
        session(['solicitacao' => $request->solicitacao]);
        if(!is_null($request->data_validade)){
            session(['data_validade' => $request->data_validade]);
        }
        $fileName = $request->file('anexo')->getClientOriginalName();

        $cpfUsuario = str_replace(".", "",$request->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);
        $extensao = $request->file('anexo')->getClientOriginalExtension();
        $uniqid = uniqid();
        $fileName = $cpfUsuario ."_". str_replace(' ','',$request->documento_processo) ."_". $uniqid .".".strtolower($extensao);

        
//        $request->file('anexo')->move(public_path('cartao_gratuidade_estacionamento/pdf'),$fileName);
        $request->file('anexo')->move(storage_path('app/cartao_gratuidade_estacionamento'),$fileName);

        $cgd = new CartaoGratuidadeDocumento();
        $cgd->id_cge = 0;
        $cgd->cpf = Auth::user()->cpf;
        $cgd->uniqid = $uniqid;
        $cgd->documento_processo = $request->documento_processo;
        $cgd->outros_documentos = $request->outros_documentos;
        $cgd->anexo = $fileName;
        $cgd->save();


        return redirect()->route('cartaoGratuidadeEstacionamento');
    }

    public function salvarCartaoGratuidadeEstacionamento(Request $request){
        $cge = new CartaoGratuidadeEstacionamento();
        $cge->cpf = Auth::user()->cpf;
        $cge->nome = $request->nome;
        $cge->rg = $request->rg;
        $cge->orgao = $request->orgao;
        $cge->bairro = $request->bairro;
        $cge->cidade = $request->cidade;
        $cge->celular = $request->celular;
        $cge->profissao = $request->profissao;
        $cge->email = $request->email;
        $cge->solicitacao = $request->solicitacao;
        $cge->prazos = $request->prazos;
        $cge->data_validade = $request->data_validade;
        $cge->cpf_requerente = $request->cpf_requerente;
        $cge->nome_requerente = $request->nome_requerente;
        $cge->telefone_requerente = $request->telefone_requerente;
        $cge->email_requerente = $request->email_requerente;
        $cge->save();

        $cge = CartaoGratuidadeEstacionamento::select('id')->get();
        foreach($cge as $registro_cge){
            $id = $registro_cge->id;
        }

        CartaoGratuidadeDocumento::where('id_cge','=',0)->update(['id_cge' => $id]);

        $request->session()->forget('solicitacao');
        $request->session()->forget('data_validade');

        return view('site.cge_msg_sucesso', [ 'pagina' => 'Cartão de Gratuidade de Estacionamento', 'nome' => $request->nome, 'cpf' => Auth::user()->cpf ]);
    }

    public function removerCartaoGratuidadeDocumento(Request $request){
//        print($request->file."<br />");
        $vet_filename = explode('.',$request->file);
        $qtd_pontos = sizeof($vet_filename);
        $newfilename = "";
        if($qtd_pontos > 2){
            $i=0;
            while($i < $qtd_pontos){
                if($i < ($qtd_pontos -1)){
                    $newfilename .= $vet_filename[$i].'';
                }
                if($i == ($qtd_pontos-1)){
                    $newfilename .= '.'.$vet_filename[$i];
                }
                $i++;
            }
        }
        else{
            $newfilename = $request->file;
        }
//        print($newfilename);exit;
        $cgd = CartaoGratuidadeDocumento::where('id','=',$request->id)->delete();

        $pos = strpos($newfilename,'.');

        $cpfUsuario = str_replace(".", "",$request->cpf);
        $cpfUsuario = str_replace("-", "", $cpfUsuario);
        $cpfUsuario = str_replace("/", "", $cpfUsuario);
        $cpfUsuario = str_replace(" ", "", $cpfUsuario);

        $extensao = strtoupper(substr($newfilename,$pos,strlen($newfilename)));
        $fileName = $cpfUsuario ."_". str_replace(' ','',$request->documento_processo) ."_". $request->uid.$extensao;
//        print($fileName);exit;
        unlink(storage_path('app/cartao_gratuidade_estacionamento/'.$fileName));
        /*
        $extensao = substr($request->file,$pos,strlen($request->file));
        $fileName = $cpfUsuario ."_". str_replace(' ','',$request->documento_processo) ."_". $request->uid.$extensao;
        unlink(storage_path('app/cartao_gratuidade_estacionamento/'.$fileName));
        */

        return redirect()->route('cartaoGratuidadeEstacionamento');
    }
}