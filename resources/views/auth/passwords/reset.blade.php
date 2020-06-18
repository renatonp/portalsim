@extends('layouts.tema01')

@section('content')
<section id="inner-headline">
    <div class="container">
        <div class="row">
            <div class="span8">
                <div class="inner-heading">
                    <h2>{{ __('TROCAR A SENHA') }}</h2>
                </div>
            </div>
            <div class="span4">
                <ul class="breadcrumb">
                    <li><a href="{{  url('/') }}"><i class="fa fa-home"></i></a><i class="fa fa-angle-right"></i></li>
                    <li class="active">{{ __('Trocar a Senha') }}</li>
                </ul>
            </div>
        </div>
    </div>
</section>

<section id="content">
    <div class="container">
        <form method="POST" action="{{ route('resetPassword') }}" id="form_register">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">

            <div class="row">
                <div class="span4 form-label">
                    <label for="cpf" class="control-label">
                        {{ __('CPF/CNPJ') }}
                    </label>
                </div>
                <div class="span3">
                    <input id="cpf" type="text" class="form-input{{ $errors->has('cpf') ? ' is-invalid' : '' }}"
                        name="cpf" value="{{ $email ?? old('cpf') }}" required autofocus>

                    @if ($errors->has('cpf'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('cpf') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="span4 form-label">
                    <label for="email" class="control-label">
                        {{ __('E-Mail') }}
                    </label>
                </div>
                <div class="span6">
                    <input id="email" type="email" class="form-input{{ $errors->has('email') ? ' is-invalid' : '' }}"
                        name="email" value="{{ $email ?? old('email') }}" required autofocus>

                    @if ($errors->has('email'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('email') }}</strong>
                    </span>
                    @endif
                </div>
            </div>

            <div class="row">
                <div class="span4 form-label">
                    <label for="password" class="control-label">
                        {{ __('Senha') }}
                    </label>
                </div>
                <div class="span3">
                    <input id="password" type="password"
                        class="form-input{{ $errors->has('password') ? ' is-invalid' : '' }}" name="password" required>

                    @if ($errors->has('password'))
                    <span class="invalid-feedback" role="alert">
                        <strong>{{ $errors->first('password') }}</strong>
                    </span>
                    @endif
                </div>
                <div class="span2">
                    <section>
                        <div class="login-secure-red">
                        </div>
                        <div class="login-secure-yellow">
                        </div>
                        <div class="login-secure-blue">
                        </div>
                    </section>
                </div>
            </div>

            <div class="row">
                <div class="span4 form-label">
                    <label for="password-confirm" class="control-label">
                        {{ __('Confirme a Senha') }}
                    </label>
                </div>
                <div class="span3">
                    <input id="password-confirm" type="password" class="form-input" name="password_confirmation"
                        required>
                </div>
            </div>
            {!! $showRecaptcha !!}
            <br>

            <div class="row formrow">
                <div class="span5 form-label">
                </div>
                <div class="span5">
                    <p><b>* A sua senha deve conter pelo menos:</b></p>
                    <ul>
                        <li>8 Caracteres</li>
                        <li>Letras maiúsculas e minúsculas</li>
                        <li>Números</li>
                        <li>Símbolos (Exemplo: @,#,$,%,&,!,*) </li>
                    </ul>
                </div>
            </div>

            <div class="span12 aligncenter">
                <button type="button" class="btn btn-theme e_wiggle" id="register_submit" disabled>
                    {{ __('Resetar a Senha') }}
                </button>
            </div>
        </form>
    </div>
    </div>
    <br>
    <br>
    <br>
    @endsection

    @section('post-script')
    <script type="text/javascript">
        var tmpcpf = $("#cpf").val()
        
        jQuery(document).ready(function(){


            var cpf_opt = {
                onKeyPress: function (cpf, e, field, cpf_opt) {
                    var masks = ['000.000.000-000', '00.000.000/0000-00'];
                    var mask = (cpf.length > 14) ? masks[1] : masks[0];
                    $('#cpf').mask(mask, cpf_opt);
                }
            };

            if (typeof ($("#cpf")) !== "undefined") {
                var masks = ['000.000.000-000', '00.000.000/0000-00'];
                var mask = ($("#cpf").val().length > 14) ? masks[1] : masks[0];
                $("#cpf").mask(mask, cpf_opt);
            }
            $("#cpf").val(tmpcpf) ;

            $("#register_submit").click(function(){
                var value = $("#password").val();
                var w = Math.round((securepass(value)*50)/100);
                if (w<=15 || value.length < 8) {
                    alert("A Senha informada é muito fraca.\nInforme uma senha mais segura.\n\nUtilize números, letras, símbolos e que tenha ao menos 8 caracteres.");
                    return false;
                }
                else{
                    $("#form_register").submit();
                }
            });   
            
            $('#password').bind('keyup', function() { 
                console.log("Aqui -> " + $(this).val());
                var value = $(this).val();
                var w = Math.round((securepass(value)*50)/100);
                if (w<=15) {
                    $('.login-secure-red').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                    $('.login-secure-yellow').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                    $('.login-secure-blue').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                } else if (w>=16 && w<=30) {
                    //aplica transparência a div vermelha
                    $('.login-secure-red').stop().animate({width: (w*3)+'px', opacity: 0}, 1000);
                    $('.login-secure-yellow').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                    $('.login--secure-blue').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                } else {
                    //aplica transparência a div vermelha e amarela
                    $('.login-secure-red').stop().animate({width: (w*3)+'px', opacity: 0}, 1000);
                    $('.login-secure-yellow').stop().animate({width: (w*3)+'px', opacity: 0}, 1000);
                    $('.login-secure-blue').stop().animate({width: (w*3)+'px', opacity: 1}, 1000);
                }
            });
            jQuery('.g-recaptcha').attr('data-callback', 'onReCaptchaSuccess');
            jQuery('.g-recaptcha').attr('data-expired-callback', 'onReCaptchaTimeOut');
        });
        function onReCaptchaTimeOut(){
            $("#register_submit").prop('disabled', true);
        }
        function onReCaptchaSuccess(){
            $("#register_submit").prop('disabled', false);
        }   

        //+------------------------------------------------------------------------+
        //| Função para informar o nível de segurança da senha digitada            |
        //| Verifica se a senha é fácil                                            |
        //+------------------------------------------------------------------------+

        function securepass(_value) {
            
            //+-------------------------+
            //| Declaração de variaveis |
            //+-------------------------+
            var level           = 0;
            var value           = _value.replace(/\s/g,''); 
            var lowerCase       = value.search(/[a-z]/);
            var upperCase       = value.search(/[A-Z]/);
            var numbers         = value.search(/[0-9]/);
            var specialChars    = value.search(/[@!#$%&*+=?|-]/);
            var aLowerCase      = value.split(/[a-z]/);
            var aUpperCase      = value.split(/[A-Z]/);
            var aNumbers        = value.split(/[0-9]/);
            var aSpecialChars   = value.split(/[@!#$%&*+=?|-]/) ;

            //+------------------------------------+
            //| Verifica o nivel da senha digitada |
            //+------------------------------------+
            if (_value.length!=0) {
            if (lowerCase>=0) {level += 10;}
            if (upperCase>=0) {level += 10;} 
            if (numbers>=0) {level += 10;}
                if (specialChars>=0) {level += 10;}

                if (aLowerCase.length>2) {level += 5;}
                if (aUpperCase.length>2) {level += 5;}
                if (aNumbers.length>2) {level += 5;}
                if (aSpecialChars.length>2) {level += 10;}
                
            if (value.length >= 4) {level += 5;}
            if (value.length >= 6) {level += 10;}
            if (value.length > 8) {level += 20;}
            }

            return level;
        }

        //+-------------------------------------------------------+
        //| Verifica se a senha pertence a lista de senhas obvias | 
        //+-------------------------------------------------------+
        function obviuspass(_value) {

            var aPass = new Array('111111','11111111','112233','121212','123123','123456','1234567','12345678','131313','232323','654321','666666','696969','777777','7777777','8675309','987654','aaaaaa','abc123','abc123','abcdef','abgrtyu','access','access14','action','albert','alexis','amanda','amateur','andrea','andrew','angela','angels','animal','anthony','apollo','apples','arsenal','arthur','asdfgh','asdfgh','ashley','asshole','august','austin','badboy','bailey','banana','barney','baseball','batman','beaver','beavis','bigcock','bigdaddy','bigdick','bigdog','bigtits','birdie','bitches','biteme','blazer','blonde','blondes','blowjob','blowme','bond007','bonnie','booboo','booger','boomer','boston','brandon','brandy','braves','brazil','bronco','broncos','bulldog','buster','butter','butthead','calvin','camaro','cameron','canada','captain','carlos','carter','casper','charles','charlie','cheese','chelsea','chester','chicago','chicken','cocacola','coffee','college','compaq','computer','cookie','cooper','corvette','cowboy','cowboys','crystal','cumming','cumshot','dakota','dallas','daniel','danielle','debbie','dennis','diablo','diamond','doctor','doggie','dolphin','dolphins','donald','dragon','dreams','driver','eagle1','eagles','edward','einstein','erotic','extreme','falcon','fender','ferrari','firebird','fishing','florida','flower','flyers','football','forever','freddy','freedom','fucked','fucker','fucking','fuckme','fuckyou','gandalf','gateway','gators','gemini','george','giants','ginger','golden','golfer','gordon','gregory','guitar','gunner','hammer','hannah','hardcore','harley','heather','helpme','hentai','hockey','hooters','horney','hotdog','hunter','hunting','iceman','iloveyou','internet','iwantu','jackie','jackson','jaguar','jasmine','jasper','jennifer','jeremy','jessica','johnny','johnson','jordan','joseph','joshua','junior','justin','killer','knight','ladies','lakers','lauren','leather','legend','letmein','letmein','little','london','lovers','maddog','madison','maggie','magnum','marine','marlboro','martin','marvin','master','matrix','matthew','maverick','maxwell','melissa','member','mercedes','merlin','michael','michelle','mickey','midnight','miller','mistress','monica','monkey','monkey','monster','morgan','mother','mountain','muffin','murphy','mustang','naked','nascar','nathan','naughty','ncc1701','newyork','nicholas','nicole','nipple','nipples','oliver','orange','packers','panther','panties','parker','password','password','password1','password12','password123','patrick','peaches','peanut','pepper','phantom','phoenix','player','please','pookie','porsche','prince','princess','private','purple','pussies','qazwsx','qwerty','qwertyui','rabbit','rachel','racing','raiders','rainbow','ranger','rangers','rebecca','redskins','redsox','redwings','richard','robert','rocket','rosebud','runner','rush2112','russia','samantha','sammy','samson','sandra','saturn','scooby','scooter','scorpio','scorpion','secret','sexsex','shadow','shannon','shaved','sierra','silver','skippy','slayer','smokey','snoopy','soccer','sophie','spanky','sparky','spider','squirt','srinivas','startrek','starwars','steelers','steven','sticky','stupid','success','suckit','summer','sunshine','superman','surfer','swimming','sydney','taylor','tennis','teresa','tester','testing','theman','thomas','thunder','thx1138','tiffany','tigers','tigger','tomcat','toutcard','topgun','toyota','travis','trouble','trustno1','tucker','turtle','twitter','united','vagina','victor','victoria','viking','voodoo','voyager','walter','warrior','welcome','whatever','william','willie','wilson','winner','winston','winter','wizard','xavier','xxxxxx','xxxxxxxx','yamaha','yankee','yankees','yellow','zxcvbn','zxcvbnm','zzzzzz');
            for (var i = 0; i < aPass.length; i++) {
                if (aPass[i] == _value) return true;
            }
            return false;
        }

    </script>
    @endsection