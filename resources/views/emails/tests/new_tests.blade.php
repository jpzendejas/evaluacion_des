@component('mail::message')
# Bienvenidos

Nueva evaluación registrada.
<ul>
<li><strong>Ficha de Empleado: </strong>{{$employee['token']}}.</li>
<li><strong>Nombre de Empleado: </strong>{{$employee['employee_name']}}.</li>
<li><strong>Ficha Evaluador: </strong>{{$employee['parent_token']}}.</li>
</ul>
@component('mail::button', ['url' => 'http://salamanca.gob.mx'])
Ir a pagina principal
@endcomponent

Gracias,<br>
{{ config('app.name') }}
@endcomponent
