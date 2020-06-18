<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        if(strlen($data['cpf'])<=14){
            return Validator::make($data, [
                'cpf'           => ['required', 'cpf', 'unique:users'],
                'name'          => ['required', 'string', 'max:100'],
                'email'         => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'email-confirm' => ['required', 'same:email', 'email'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'celphone'      => ['required', 'string', 'min:8'],
                'birthdate'     => ['date'],
                'mothersname'   => ['string', 'min:6', 'max:100'],
                'orgao_emissor' => ['string', 'min:2', 'max:10'],
                'dt_expedicao'  => ['date'],
                'cep'           => ['string', 'min:6'],
                'uf'            => ['string', 'min:2', 'max:2'],
                'city'          => ['string', 'max:75'],
                'district'      => ['string', 'max:40'],
                'address'       => ['string', 'max:100'],
                'number'        => ['string'],
            ]);
        }
        else{
            return Validator::make($data, [
                'cpf'           => ['required', 'cnpj', 'unique:users'],
                'name'          => ['required', 'string', 'max:100'],
                'nome_razao_social'     => ['required', 'string'],
                'email'         => ['required', 'string', 'email', 'max:100', 'unique:users'],
                'email-confirm' => ['required', 'same:email', 'email'],
                'password'      => ['required', 'string', 'min:8', 'confirmed'],
                'celphone'      => ['required', 'string', 'min:8'],
                'cep'           => ['string', 'min:6'],
                'uf'            => ['string', 'min:2', 'max:2'],
                'city'          => ['string', 'max:75'],
                'district'      => ['string', 'max:40'],
                'address'       => ['string', 'max:100'],
                'number'        => ['string'],
                'nome_responsavel'      => ['string'],
                'inscricao_estadual'    => ['string'],
            ]);            
        }
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {   
        $data['password'] = Hash::make($data['password']);

        return User::create($data);
    }

    public function consultaCEP($id){

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
    
}