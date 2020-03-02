@extends('layouts.panel')
@section('content')
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
        Evaluando a: <br>
        <strong>Ficha:</strong>&nbsp;{{$employee['token']}}. <strong><br>
          Nombre de Empleado:</strong>&nbsp;{{$employee['employee_name']}}.<br>
          <strong>Departamento:</strong>&nbsp;{{$employee->government_agency->government_agency}}.
        </div>
        <div class="card-body">
          <form class="" action="{{url('guardar_resultados')}}" method="post">
            @csrf
            <input type="hidden" name="employee_token" value="{{$employee['token']}}">
            <div class="row">
              <br>
              @foreach($questions as $key => $question)
              <div class="col-sm-12">
                <label for="questions"><strong>{{$question->question}}:</strong></label>
                <div class="input-group input-group-alternative mb-3">
                  <div class="input-group-prepend">
                    <!-- <span class="input-group-text"><i class="ni ni-single-copy-04"></i></span> -->
                  </div>
                  @foreach($question->answers as $key => $answer)
                  @if($key == 0)
                  <div class="custom-control custom-radio mb-3">
                  <input name="{{$question->id}}" value="{{$answer->answer->id}}" class="custom-control-input" id="rb{{$question->id}}{{$answer->answer->id}}" type="radio" required>
                  <label class="custom-control-label" for="rb{{$question->id}}{{$answer->answer->id}}">{{$answer->answer->answer}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  @else
                  <div class="custom-control custom-radio mb-3">
                  <input name="{{$question->id}}" value="{{$answer->answer->id}}" class="custom-control-input" id="rb{{$question->id}}{{$answer->answer->id}}" type="radio">
                  <label class="custom-control-label" for="rb{{$question->id}}{{$answer->answer->id}}">{{$answer->answer->answer}}&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
                  </div>
                  @endif
                  @endforeach
                  <br>

                </div>
              </div>
              @endforeach
              <div class="text-center">
                <button type="submit" class="btn btn-primary mt-4">Realizar Evaluación al Desempeño</button>
              </div>
            </div>
          </form>
      </div>
    </div>
</div>

@endsection
