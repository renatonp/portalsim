@component('mail::message')
# Olá {{ $name }}
Você está recebendo este e-mail porque recebemos um pedido de cadastro de senha para sua conta.
@component('mail::button', ['url' => $url])
Cadastrar Senha
@endcomponent
Atenciosamente,<br>
{{ config('app.name') }}
@component('mail::subcopy', ['url' => $url])
Se você está tendo problemas para clicar no botão de "Cadastrar Senha", copie e cole a URL abaixo no seu navegador [{{ $url }}]({{ $url }})
@endcomponent
@endcomponent