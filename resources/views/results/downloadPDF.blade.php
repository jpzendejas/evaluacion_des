@extends('layouts.reslayout')
@section('content')
<center><br>
<img src="img/logoverticalnegro.png" width="125" height="150">
<h3>Evaluación al Desempeño</h3>
<h5>Evaluación. Área:{{$government_agency->government_agency}}</h5>
</center><hr>
<center>
Indicador: |0-29 = Bajo| |30-39 = Regular| |40:49 = Bueno| |50 = Excelente|
</center>
<hr>
<table width="100%">
  <thead style="border-top:5px solid black; background:gray">
    <tr>
      <th>FICHA</th>
      <th>EMPLEADO</th>
      <th>DEPARTAMENTO</th>
      <th>PRODUCTIVIDAD</th>
      <th>PLANIFICACIÓN</th>
      <th>LIDERAZGO</th>
    </tr>
  </thead>
  <tbody tyle="border-style: ridge;">
    @foreach($employees as $employee)
    <tr>
      <th scope="row">{{$employee->token}}</th>
      <td>{{$employee->employee_name}}</td>
      <td align="center">{{$employee->government_agency}}</td>
      <td align="center">{{$employee->productividad}}</td>
      <td align="center">{{$employee->planificacion}}</td>
      <td align="center">{{$employee->liderazgo}}</td>
    </tr>
    @endforeach
  </tbody>
</table
@endsection
