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
        <div class="card-header">
          <center><h2>EVALUACIÓN AL DESEMPEÑO SALAMANCA, GTO 2020</h2></center></div>
          <div class="card-body">
            <form role="form" method="POST" action="{{url('download_result')}}" enctype="multipart/form-data">
              @csrf
              <div class="text-center">
                <center>
                <div class="col-sm-6">
                  <label for="state_id"><strong>Departamento:</strong></label>
                    <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <span class="input-group-text"><i class="ni ni-vector"></i></span>
                  </div>
                  <select class="form-control" name="government_agency_id" id="government_agency_id" required placeholder="Estado">
                  <option disabled selected>Selecciona tu Departamento</option>
                  @foreach($departments as $department)
                    <option value="{{$department->id}}">{{$department->government_agency}}</option>
                  @endforeach
                </select>
                </div>
              </div>
            </center>
              </div>
              <div class="text-center">
                <center>
                  <button type="submit" class="btn btn-primary mt-2">Obtener Resultados</button>
                </center>
              </div>
            </form>
          </div>
        </div>
      </div>
</div>

@endsection
