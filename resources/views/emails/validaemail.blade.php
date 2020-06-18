@component('mail::message')
Olá {{ $nome }}.<br><br>
Você está recebendo esta mensagem porque foi feito um pedido para alteração do seu e-mail no Cadastro Geral do Município.<br><br>
<strong>Novo e-mail:</strong> {{ $novoEmail }}<br><br>
@component('mail::button', ['url' => $url])
Confirmar Alteração do E-Mail
@endcomponent
Atenciosamente,<br>
{{ config('app.name') }}
@component('mail::subcopy', ['url' => $url])
Se você está tendo problemas para clicar no botão de "Confirmar Alteração do E-Mail", copie e cole a URL abaixo no seu
navegador
[{{ $url }}]({{ $url }})
@endcomponent
@endcomponent