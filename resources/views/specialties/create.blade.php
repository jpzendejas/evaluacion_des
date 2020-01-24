@extends('layouts.panel')
@section('content')
  <div class="card shadow">
            <div class="card-header border-0">
              <div class="row align-items-center">
                <div class="col">
                  <h3 class="mb-0">Nueva especialidad</h3>
                </div>
                <div class="col text-right">
                  <a href="{{url('specialties')}}" class="btn btn-sm btn-default">Cancelar y volver</a>
                </div>
              </div>
            </div>
            <div class="card-body">
              @if($errors->any())
              <ul>
                <div class="alert alert-danger" role="alert">
                  @foreach($errors->all() as $error)

                  <li>{{$error}}</li>
                  @endforeach
                </div>

              </ul>
              @endif
              <form class="" action="{{url('specialties')}}" method="post">
                @csrf
                <div class="form-group">
                  <label for="name">Nombre de la especialidad</label>
                  <input type="text" name="name" value="{{old('name')}}" class="form-control" required>

                </div>
                <div class="form-group">
                  <label for="description">Descripción</label>
                  <input type="text" name="description" value="{{old('description')}}" class="form-control">

                </div>
                <button type="submit" name="button" class="btn btn-primary">Guardar</button>
              </form>
            </div>

          </div>

@endsection
