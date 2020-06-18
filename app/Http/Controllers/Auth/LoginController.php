<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
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
        $this->middleware('guest')->except('logout');
    }
    
    public function showLoginForm()
    {
        $showRecaptcha = GoogleRecaptcha::show(
            env('RECAPTCHA_SITE_KEY'), 
            'password', 
            'no_debug', 
            'mt-3 mb-3', 
            'Por favor clique no checkbox do reCAPTCHA primeiro!'
        );

        return view('auth.login', ['showRecaptcha'=> $showRecaptcha, 'cpf' => session('cpf')]);
    }

    // protected function validateLogin(Request $request)
    // {
    //     dd($request);

    //     $request->validate([
    //         $this->username() => 'required|string',
    //         'password' => 'required|string',
    //     ]);
    // }

    // protected function validateLogin(Request $request)
    // {
    
    //     GoogleRecaptcha::verify(env('RECAPTCHA_SECRET_KEY'), 'Google Recaptcha Validation Failed!!');
    
    //     $request->validate([
    //         $this->username() => 'required|string',
    //         'password' => 'required|string',
    //     ]);
    // }

    public function username()
    {
        return 'cpf';
    }
}
