<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use GoogleRecaptchaToAnyForm\GoogleRecaptcha;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    use SendsPasswordResetEmails;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showLinkRequestForm()
    {
        $showRecaptcha = GoogleRecaptcha::show(
            env('RECAPTCHA_SITE_KEY'), 
            'cpf', 
            'no_debug', 
            'mt-4 mb-3 col-md-6 offset-md-4 aligncenter', 
            'Por favor clique no checkbox do reCAPTCHA primeiro!'
        );

        return view('auth.passwords.email', ['showRecaptcha'=> $showRecaptcha]);
    }
}
