@component('mail::message')

#Bienvenido al portal de Tramites y Servicios Salamanca, Gto.

Gracias por registrarte en el portal de Tramites y Servicios, estamos validando tu registro, en breve recibiras la notificación satisfactoria de la validación de tus datos...

@component('mail::table')
| CURP                    | NOMBRE                  | APELLIDOS                    |EMAIL                     |TELÉFONO                  |
| ----------------------- |:-----------------------:| ----------------------------:|-------------------------:|-------------------------:|
|{{$pre_register['curp']}}|{{$pre_register['name']}}|{{$pre_register['last_name']}}|{{$pre_register['email']}}|{{$pre_register['phone']}}|
@endcomponent

@component('mail::button', ['url' => 'http://www.salamanca.gob.mx'])
Ir a Tramites y Servicios
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
