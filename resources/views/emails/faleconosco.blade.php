@component('mail::message')
# Olá,
O(A) Sr(a).  {{ $mensagem['name'] }},

Enviou a seguinte mensagem pelo Portal SIM: <br>

Solicitação: <strong>{{ $mensagem['solicitacao']}}</strong><br>
Assunto: <strong>{{ $mensagem['assunto']}}</strong><br><br>
Nome: <strong>{{ $mensagem['name'] }}</strong><br>
E-Mail: {{ $mensagem['email'] }}<br>
Telefone: {{ $mensagem['phone'] }}<br><br>
<b>Mensagem:</b><br>
{{ $mensagem['message'] }}
<br>
<br>
Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
