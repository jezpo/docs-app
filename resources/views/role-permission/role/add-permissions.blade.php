@extends('layouts.default')
@section('title1', 'Admin U.A.T.F.')
@section('title', 'Admin Roles')
@section('Roles', 'active')
@push('css')
    <link href="/assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="/assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
@endpush

@section('content')
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ url('/home') }}">Principal</a></li>
        <li class="breadcrumb-item active">Roles</li>
    </ol>
    <h1 class="page-header"><i class="fas fa-sitemap fa-fw"></i> Roles <small></small></h1>
    <div class="panel panel-inverse">
        <div class="panel-heading">
            <div class="input-group-prepend pull-right">
                <a href="{{ url('roles') }}" class="btn btn-danger float-right"><i class="fas fa-arrow-left"></i> Atras</a>
            </div>
            <h4 class="panel-title"></h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <h4><i class="fas fa-user fa-user"></i> Usuario: {{ $role->name }}</h4>
            <form action="{{ url('roles/'.$role->id.'/give-permissions') }}" method="POST">
                @csrf
                @method('PUT')
        
                <table id="permissions-table" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th>Permisos</th>
                            <th>Seleccionar</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($permissions as $permission)
                        <tr>
                            <td>{{ $permission->name }}</td>
                            <td>
                                <input
                                    type="checkbox"
                                    name="permission[]"
                                    value="{{ $permission->name }}"
                                    {{ in_array($permission->id, $rolePermissions) ? 'checked':'' }}
                                />
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
        
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save fa-lg fa-fw m-r-10"></i> Guardar
                </button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script src="/assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="/assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="/assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
    <script src="/assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
    <script src="/assets/plugins/pdfmake/build/pdfmake.min.js"></script>
    <script src="/assets/plugins/pdfmake/build/vfs_fonts.js"></script>
    <script src="/assets/plugins/jszip/dist/jszip.min.js"></script>
    <script src="/assets/plugins/moment/min/moment.min.js"></script>
    <script src="/assets/plugins/moment/locale/es-us.js"></script>
    <script src="/assets/plugins/switchery/switchery.min.js"></script>

    <script>
        $(document).ready(function() {
            $('#permissions-table').DataTable({
                responsive: true,
                autoWidth: false,
                language: {
                    url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                }
            });
        });
    </script>
@endpush
