<?php

namespace App\Http\Controllers\Site;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class SigeluController extends Controller
{

    public function __construct()
    {
        $this->middleware(['auth', 'verified']);
    }


    public function abrirServico(){
        
        $url = "https://cidadao.maricahom.sigelu.com/atende";
        $token = "%22Bearer%20eyJhbGciOiJIUzI1NiIsInR5cCI6IkpXVCJ9.eyJ1c3VhcmlvX2VtYWlsIjoiY2lkYWRhb193ZWIiLCJpYXQiOjE1NTEwMjEzNTJ9.kZyUcFP0Ursg8ZoNXaQxy1NHj29BLSnRccIEbsGu538%22";

        $genero = Auth::user()->sex=="M"?"MASCULINO":"FEMININO";
        
        $fields = '&cidadao={ "cpf":"'.Auth::user()->cpf.'", "nome":"'.Auth::user()->name.'", "email":"'.Auth::user()->email.'", "dt_nascimento":"'.Auth::user()->birthdate.'", "nome_mae":"'.Auth::user()->mothersname.'", "identidade":"'.Auth::user()->voterstitle.'", "orgao_emissor":"'.Auth::user()->orgao_emissor.'", "dt_expedicao":"'.Auth::user()->dt_expedicao.'", "telefone":"'.Auth::user()->phone.'", "celular":"'.Auth::user()->celphone.'", "genero":"'.$genero.'", "endereco":{ "cep":"'.Auth::user()->cep.'", "uf":"'.Auth::user()->uf.'", "cidade":"'.Auth::user()->city.'", "bairro":"'.Auth::user()->district.'", "logradouro":"'.Auth::user()->address.'", "numero":"'.Auth::user()->number.'", "complemento":"'.Auth::user()->complement.'", "ponto_referencia":""} }';
        // $fields = '&cidadao={ "cpf":"164.592.467-00", "nome":"'.Auth::user()->name.'", "email":"'.Auth::user()->email.'", "dt_nascimento":"'.Auth::user()->birthdate.'", "nome_mae":"'.Auth::user()->mothersname.'", "identidade":"'.Auth::user()->voterstitle.'", "orgao_emissor":"'.Auth::user()->orgao_emissor.'", "dt_expedicao":"'.Auth::user()->dt_expedicao.'", "telefone":"'.Auth::user()->phone.'", "celular":"'.Auth::user()->celphone.'", "genero":"'.$genero.'", "endereco":{ "cep":"'.Auth::user()->cep.'", "uf":"'.Auth::user()->uf.'", "cidade":"'.Auth::user()->city.'", "bairro":"'.Auth::user()->district.'", "logradouro":"'.Auth::user()->address.'", "numero":"'.Auth::user()->number.'", "complemento":"'.Auth::user()->complement.'", "ponto_referencia":""} }';
        // $fields = '&cidadao={%20%22cpf%22:%22164.592.467-00%22,%20%22nome%22:%22Jo%C3%A3o%20dos%20Santos%20Oliveira%22,%20%22email%22:%22joao.santos@gmail.com%22,%20%22dt_nascimento%22:%221986-09-05%22,%20%22nome_mae%22:%22Amalia%20dos%20Santos%20Silva%22,%20%22identidade%22:%2221.312.231-3%22,%20%22orgao_emissor%22:%22DIC%22,%20%22dt_expedicao%22:%222000-06-10%22,%20%22telefone%22:%22(21)3652-7899%22,%20%22celular%22:%22(21)92590-4273%22,%20%22genero%22:%22Masculino%22,%20%22endereco%22:{%20%22cep%22:%221941614%22,%20%22uf%22:%22RJ%22,%20%22cidade%22:%22Rio%20de%20Janeiro%22,%20%22bairro%22:%22Cidade%20Universit%C3%A1ria%22,%20%22logradouro%22:%22Rua%20Helio%20de%20Almeida%22,%20%22numero%22:%2241%22,%20%22complemento%22:%22Sala%2015%22,%20%22ponto_referencia%22:%22Esquina%20com%20a%20Rua%20Paulo%20Em%C3%ADdio%22%20}%20}';

        $fields = str_replace(chr(34), "%22", $fields);
        $fields = str_replace(chr(32), "%20", $fields);
        
                
        
        return view('site.sigelu',[ "pagina" => "perfil" , 'url' => $url, 'token' => $token, 'fields' => $fields]);




    }


}