@component('mail::message')
# Bem Vindo {{ $user->name }}!

Vimos que tentou acessar o sistema, porém seu ip de acesso({{ $attempt->ip }}) ainda não esta em nossa lista, caso essa tentativa de
acesso tenha sido realizada por você clique no botao abaixo para liberarmos o seu acesso, caso contrário reporte esta tentativa
de acesso ao administrador do sistema.

@component('mail::button', ['url' => route('releaseAccess').'?token='.$attempt->token])
Validar Acesso
@endcomponent

Atenciosamente,<br>
{{ config('app.name') }}
@endcomponent
