
<li class="has-sub">
    <a href="{{ url('users') }}">
        <i class="material-icons">people</i> <span>Usuarios</span>
    </a>
</li>
<li>
    <a href="{{ url('gestion') }}">
        <i class="material-icons">calendar_today</i> <span>Gestion</span>
    </a>
</li>
<li>
    <a href="{{ url('permissions') }}">       
        <i class="material-icons">lock</i> <span>Permisos</span>
    </a>
</li>

<li>
    <a href="{{ url('roles') }}">    
        <i class="material-icons">security</i><span>Roles</span>
    </a>
</li>

<li>
    <a href="{{ url('documentos') }}">
        <i class="material-icons">inbox</i>  <span>Documentos</span>
    </a>
</li>

<li>
    <a href="{{ url('/dashboard/programas') }}">
        <i class="material-icons">school</i> <span>Unidad</span>
    </a>
</li>

{{--
<li class="has-sub active expand">
    <a href="javascript:;">
        <b class="caret"></b>
        <i class="material-icons">home</i>
        <span>Documentos</span>
    </a>
  
    <ul class="sub-menu">
        <li class="active">
            <a href="{{ route('recibidos.index') }}">
                <i class="fas fa-file"></i> Documentos Recibidos
            </a>
        </li>
        <li class="active">
            <a href="{{ route('documents.index') }}">
                <i class="fas fa-file"></i> Documentos Enviados
            </a>
        </li>
        <li>
            <a href="{{url('hermes/programas')}}">
                <i class="fas fa-graduation-cap"></i> Unidad o Carrera
            </a>
        </li>
        <li>
            <a href="{{url('hermes/flujotramite')}}">
                <i class="fas fa-retweet"></i> Flujo De Tramite
            </a>
        </li>
        <li>
            <a href="{{url('hermes/flujodocumentos')}}">
                <i class="fas fa-file-alt"></i> Flujo De Documentos
            </a>
        </li>
        <li>
            <a href="{{url('hermes/tipotramite')}}">
                <i class="fas fa-tasks"></i> Tipo De Tramite
            </a>
        </li>
    </ul>
</li>
<li class="has-sub active expand">
    <a href="javascript:;">
        <b class="caret"></b>
        <i class="material-icons">home</i>
        <span>Reportes</span>
    </a>
    <ul class="sub-menu" style="">
        <li class="active">
            <a href="{{ route('reports.index') }}">Reportes</a>
        </li>
    </ul>
</li>
--}}
