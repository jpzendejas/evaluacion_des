<!-- Navigation -->
<h6 class="navbar-heading text-muted">
@if(Auth::guest())
Evaluación al Desemepeño
@else
@if(auth()->user()->role == 'admin')
Gestionar Datos
@else
Menú
@endif
@endif
</h6>
  @if(Auth::guest())
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="/evaluacion_desempeño">
        <i class="ni ni-tv-2 text-red"></i> Inicio Evaluación
      </a>
    </li>
  @else
  <ul class="navbar-nav">
    <li class="nav-item">
      <a class="nav-link" href="{{url('/evaluacion_desempeño')}}">
        <i class="ni ni-tv-2 text-red"></i> Inicio
      </a>
    </li>
  @if(auth()->user()->role == 'admin')
  <!-- Inicio Menu -->
  <li class="nav-item">
    <a class="nav-link" href="{{url('/preguntas')}}">
      <i class="ni ni-single-02 text-orange"></i>Preguntas
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/respuestas')}}">
      <i class="ni ni-bullet-list-67 text-orange"></i>Respuestas
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/get_pre_users')}}">
      <i class="ni ni-ruler-pencil text-red"></i> Evaluaciones
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/dependencias')}}">
      <i class="ni ni-building text-yellow"></i>Dependencias
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/empleados')}}">
      <i class="ni ni-single-02 text-blue"></i>Empleados
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{url('/resultados')}}">
      <i class="ni ni-check-bold text-red"></i>Resultados
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="{{route('logout')}}" onclick="event.preventDefault(); document.getElementById('formLogout').submit();">
      <i class="ni ni-key-25 text-info"></i>Cerrar sesíon
    </a>
    <form  action="{{route('logout')}}" method="post" style="display: none;" id="formLogout">
      @csrf
    </form>
    </li>
  @else

  @endif
  <!-- <li class="nav-item">
    <a class="nav-link" href="./examples/icons.html">
      <i class="ni ni-planet text-blue"></i>  Especialidades
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="./examples/maps.html">
      <i class="ni ni-single-02 text-orange"></i> Médicos
    </a>
  </li>
  <li class="nav-item">
    <a class="nav-link" href="./examples/profile.html">
      <i class="ni ni-satisfied text-info"></i> Pacientes
    </a>
  </li> -->
  @endif


  </ul>

<!-- Divider -->
      <hr class="my-3">
      <!-- Heading -->
      <!-- Navigation -->
      @if(Auth::guest())
      @else
      <h6 class="navbar-heading text-muted">Reportes</h6>
      <ul class="navbar-nav mb-md-3">
        <li class="nav-item">
          <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/getting-started/overview.html">
            <i class="ni ni-collection text-yellow"></i> Reporte 1
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="https://demos.creative-tim.com/argon-dashboard/docs/foundation/colors.html">
            <i class="ni ni-spaceship text-red"></i> Reporte 2
          </a>
        </li>

      </ul>
      @endif
