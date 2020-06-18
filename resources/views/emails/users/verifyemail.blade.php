@component('mail::message')
# Olá {{ $name }}
Por favor, clique no botão abaixo para confirmar seu endereço de Email.

@component('mail::button', ['url' => $url])
Confirmar Endereço de Email
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@component('mail::subcopy', ['url' => $url])
Se você está tendo problemas para clicar no botão de "Confirmar Endereço de Email", copie e cole a URL abaixo no seu navegador [{{ $url }}]({{ $url }})
@endcomponent
@endcomponent
