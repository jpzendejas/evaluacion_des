@extends('layouts.form')
@section('title', 'Registro')
@section('subtitle', 'Ingresa tus datos para registrarte.')
@section('content')
  <div class="container mt--8 pb-5">
  <!-- Table -->
  <div class="row justify-content-center">
  <div class="col-lg-6 col-md-8">
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
  <div class="card-body">
  @if(session('notification'))
  <div class="alert alert-success" role="alert">
    {{session('notification')}}
  </div>
  @endif
  </div>
  <form role="form" method="POST" action="{{ url('/save_pre_registers')}}">
      @csrf
    <p><strong>Datos del Ciudadano</strong></p>
      <div class="row">
        <div class="col-sm-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
            </div>
            <input class="form-control" placeholder="CURP" type="text" autocomplete="off" name="curp"id="curp" minlength="18" maxlength="18" value="{{old('curp')}}" required autofocus >
          </div>
        </div>
      <div class="col-sm-6">
        <div class="input-group input-group-alternative mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
          </div>
          <input class="form-control" placeholder="Nombres" type="text" name="name" value="{{old('name')}}" required autofocus >
        </div>
      </div>
      </div>
      <div class="row">
        <div class="col-sm-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-circle-08"></i></span>
            </div>
            <input class="form-control" placeholder="Apellidos" type="text" name="last_name" value="{{old('last_name')}}" required autofocus >
          </div>
        </div>

        <div class="col-sm-6">
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-mobile-button"></i></span>
            </div>
            <input class="form-control" placeholder="Número de Teléfono" type="text" name="phone" value="{{old('phone')}}" required autofocus >
          </div>
        </div>

      </div>
      <div class="row">

        <div class="col-sm-4">
          <label for="state_id">Estado:</label>
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
            </div>
            <select class="form-control" name="state_id" id="state_id" placeholder="Estado">
                    <option disabled selected>Selecciona tu Estado</option>
                    @foreach($states as $state)
                    <option value="{{$state->id}}">{{$state->state}}</option>
                    @endforeach
            </select>
            <!-- <input class="form-control" placeholder="Estado" type="text" name="estate" value="{{old('estate')}}" required autofocus > -->
          </div>
        </div>
        <div class="col-sm-4">
          <label for="city_id">Municipio:</label>
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
            </div>
            <!-- <input class="form-control" placeholder="Municipio" type="text" name="city_id" value="{{old('city_id')}}" required autofocus > -->
            <select class="form-control" name="city_id" id="city_id" placeholder="Estado">
              <option disabled selected>Selecciona tu Municipio</option>
            </select>
          </div>
        </div>
        <div class="col-sm-4">
          <label for="suburb_id">Colonia:</label>
          <div class="input-group input-group-alternative mb-3">
            <div class="input-group-prepend">
              <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
            </div>
            <select class="form-control" name="suburb_id" id="suburb_id"placeholder="Estado">
              <option disabled selected>Selecciona tu Colonia</option>
            </select>
            <!-- <input class="form-control" placeholder="Colonia" type="text" name="suburb_id" value="{{old('suburb_id')}}" required autofocus > -->
          </div>
        </div>
      </div>
      <div class="col-xs-6 form-group">
        <div class="input-group input-group-alternative mb-3">
          <div class="input-group-prepend">
            <span class="input-group-text"><i class="ni ni-square-pin"></i></span>
          </div>
          <input class="form-control" placeholder="Dirección: calle, número ext, número int." type="text" name="address" value="{{old('address')}}" required autofocus >
        </div>
      </div>
      <p><strong>Inicio de Sesión</strong></p>
          <div class="form-group">
            <div class="input-group input-group-alternative mb-3">
              <div class="input-group-prepend">
                <span class="input-group-text"><i class="ni ni-email-83"></i></span>
              </div>
              <input class="form-control" placeholder="Email" type="email" name="email" value="{{old('email')}}" required>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-6">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" placeholder="Contraseña" type="password" name="password" value="{{old('password')}}" required>
              </div>
            </div>
            <div class="col-sm-6">
              <div class="input-group input-group-alternative">
                <div class="input-group-prepend">
                  <span class="input-group-text"><i class="ni ni-lock-circle-open"></i></span>
                </div>
                <input class="form-control" id="password-confirm" placeholder="Confirmar contraseña" type="password" name="password_confirmation" required>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col-sm-12">
              <br>
              <div class="input-group input-group-alternative">
                <label class="form-check-label" for="exampleCheck1">
                  <input type="checkbox" class="form-check-input" id="privacy_policy" name="privacy_policy">
                    Acepto las condiciones del servicio y la politica de privacidad (Ver politica de privacidad)</label>
                  </div>
            </div>
          </div>
          <div class="text-center">
            <button type="submit" class="btn btn-primary mt-4">Confirmar registro</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
