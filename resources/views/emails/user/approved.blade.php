@component('mail::message')
#Validación correcta de datos para Tramites y Servicios.

Tus datos se han verificado correctamente, ahora puedes realizar tramites y servicios en linea.

@component('mail::button', ['url' => 'http://172.17.27.25/tramites_servicios/public/login'])
Ir a Tramites y Servicios
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
