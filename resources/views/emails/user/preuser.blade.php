@component('mail::message')
# Bienvenido al portal de Tramites y Servicios Salamanca, Gto.

Gracias por registrarte en el portal de Tramites y Servicios, estamos validando tu registro...

@component('mail::button', ['url' => 'http://www.salamanca.gob.mx'])
Ir
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
