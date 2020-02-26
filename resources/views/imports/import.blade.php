@extends('layouts.form')
@section('title', 'Cargar plantilla de Excel')
@section('subtitle', 'Ingresa el archivo.')


@section('content')
<div class="container mt--8 pb-5">
  <div class="row justify-content-center">
    <div class="col-lg-5 col-md-7">
      <div class="card bg-secondary shadow border-0">

        <div class="card-body px-lg-5 py-lg-5">
          @if($errors->any())
          <div class="text-center text-muted mb-4">
            <small>Oops! se encontró un error.</small>
          </div>
          <div class="alert alert-danger" role="alert">
            {{$errors->first()}}
          </div>
          @endif

          <form role="form" method="POST" action="{{route('import_data')}}" enctype="multipart/form-data">
            @csrf
            <div class="form-group mb-3">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-email-83"></i></span>
                </div>
                <input class="form-control"  id="file_upload" name="file_upload" placeholder="XLSX" type="file" value="{{old('email')}}" required autofocus>

              </div>
            </div>
            <div class="text-center">
              <button type="submit" class="btn btn-primary my-4">Cargar Empleados</button>
            </div>
          </form>
        </div>
      </div>
      <div class="row mt-3">
        <div class="col-6">
          <!-- <a href="{{route('password.request')}}" class="text-light"><small>¿Olvidaste tu contraseña?</small></a> -->
        </div>
        <div class="col-6 text-right">
          <!-- <a href="{{route('register')}}" class="text-light"><small>¿Aún no te has registrado?</small></a> -->
        </div>
      </div>
    </div>
  </div>
</div>
@endsection
