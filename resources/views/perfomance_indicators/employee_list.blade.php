@extends('layouts.panel')
@section('content')
div class="row">
  <div class="col-md-12 mb-4">
      <!-- <div class="card">
          <div class="card-header">Menú</div>
          <div class="card-body">
              @if (session('status'))
                  <div class="alert alert-success" role="alert">
                      {{ session('status') }}
                  </div>
              @endif
          </div>
      </div> -->
  </div>
    <div class="col-md-12 mb-4">
      <div class="card">
        <div class="card-header">Evaluaciones Disponibles:</div>
          <div class="card-body">
            <div class="table-responsive">
              <!-- Projects table -->
              <table class="table align-items-center table-flush">
                <thead class="thead-light">
                  <tr>
                    <th scope="col">FICHA</th>
                    <th scope="col">NOMBRE</th>
                    <th scope="col">DEPARTAMENTO</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  @foreach($evaluate_employees as $evaluate_employee)
                  <tr>
                    <th scope="row">
                      {{$evaluate_employee->token}}
                    </th>
                    <td>
                      {{$evaluate_employee->employee_name}}
                    </td>
                    <td>
                      {{$evaluate_employee->government_agency->government_agency}}
                    </td>
                    <td>
                        <a href="{{url('/evaluacion/'.$evaluate_employee->token)}}" class="btn btn-sm btn-success">Evaluar</a>
                    </td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
          </div>
        </div>
      </div>
</div>

@endsection
