@extends('layouts.default')

@section('title', 'UATF Reportes')

@push('styles')
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/ion-rangeslider/css/ion.rangeSlider.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-colorpicker/dist/css/bootstrap-colorpicker.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/@danielfarrell/bootstrap-combobox/css/bootstrap-combobox.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/tag-it/css/jquery.tagit.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-daterangepicker/daterangepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-colorpalette/css/bootstrap-colorpalette.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-fontawesome.css') }}"
        rel="stylesheet" />
    <link href="{{ asset('assets/plugins/jquery-simplecolorpicker/jquery.simplecolorpicker-glyphicons.css') }}"
        rel="stylesheet" />


    <!-- ================== BEGIN BASE CSS STYLE ================== -->
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../assets/css/material/app.min.css" rel="stylesheet" />
    <!-- ================== END BASE CSS STYLE ================== -->

    <!-- ================== BEGIN PAGE LEVEL STYLE ================== -->
    <link href="../assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-autofill-bs4/css/autofill.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-colreorder-bs4/css/colreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-keytable-bs4/css/keytable.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-rowreorder-bs4/css/rowreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE ================== -->
@endpush

@section('content')
<style>
    .btn_personalizado {
        text-decoration: none;
        padding: 10px;
        color: #ffffff;
        background-color: #376bd4;
    }
</style>
<!-- begin breadcrumb -->
<ol class="breadcrumb float-xl-right">
    <li class="breadcrumb-item"><a href="{{ url('/home') }}">Principal</a></li>
    <li class="breadcrumb-item active">Reportes</li>
</ol>
<!-- end breadcrumb -->
<!-- begin page-header -->
<h1 class="page-header"><i class="fas fa-file-alt fa-fw"></i> Reportes <small></small></h1>
<!-- end page-header -->
<!-- begin panel -->
    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
        <div class="panel-heading">
            <h4 class="panel-title">Reportes</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i
                        class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i
                        class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i
                        class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i
                        class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="GET" action="{{-- route('report.index') --}}">
                <div class="form-group">
                    <label for="report_type">Tipo de Reporte</label>
                    <select name="report_type" id="report_type" class="form-control">
                        <option value="" disabled selected>Seleccione un reporte</option>
                        <option value="documents" {{ request('report_type') === 'documents' ? 'selected' : '' }}>Documentos
                        </option>
                        <option value="users" {{ request('report_type') === 'users' ? 'selected' : '' }}>Usuarios</option>
                        <option value="failed_logins" {{ request('report_type') === 'failed_logins' ? 'selected' : '' }}>
                            Inicios de sesión fallidos</option>
                        <option value="documents_by_type"
                            {{ request('report_type') === 'documents_by_type' ? 'selected' : '' }}>Documentos por Tipo
                        </option>
                        <option value="documents_by_unit"
                            {{ request('report_type') === 'documents_by_unit' ? 'selected' : '' }}>Documentos por Unidad
                        </option>
                        <option value="documents_sent_received"
                            {{ request('report_type') === 'documents_sent_received' ? 'selected' : '' }}>Documentos
                            Enviados/Recibidos</option>
                    </select>
                </div>
                <div id="date-range-filters" style="display: none;">
                    <div class="form-group">
                        <label for="fecha_inicial">Fecha Inicial</label>
                        <input type="date" name="fecha_inicial" id="fecha_inicial" class="form-control"
                            value="{{ request('fecha_inicial') }}">
                    </div>
                    <div class="form-group">
                        <label for="fecha_final">Fecha Final</label>
                        <input type="date" name="fecha_final" id="fecha_final" class="form-control"
                            value="{{ request('fecha_final') }}">
                    </div>
                </div>
                <button type="submit" class="btn btn-primary">Generar Reporte</button>
            </form>
            <hr>

            @if (request('report_type'))
                @if (request('report_type') === 'documents' && $documentos->isNotEmpty())
                    <h4>Reporte de Documentos</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Cite</th>
                                <th>Descripción</th>
                                <th>Estado</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $documento)
                                <tr>
                                    <td>{{ $documento->id }}</td>
                                    <td>{{ $documento->cite }}</td>
                                    <td>{{ $documento->descripcion }}</td>
                                    <td>{{ $documento->estado }}</td>
                                    <td>{{ $documento->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(request('report_type') === 'users' && $users->isNotEmpty())
                    <h4>Reporte de Usuarios</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Nombre</th>
                                <th>Apellido</th>
                                <th>Email</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($users as $user)
                                <tr>
                                    <td>{{ $user->id }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->last_name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>{{ $user->created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(request('report_type') === 'failed_logins' && $failedLogins->isNotEmpty())
                    <h4>Reporte de Inicios de Sesión Fallidos</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>UUID</th>
                                <th>Conexión</th>
                                <th>Cola</th>
                                <th>Payload</th>
                                <th>Excepción</th>
                                <th>Fallido</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($failedLogins as $failedLogin)
                                <tr>
                                    <td>{{ $failedLogin->id }}</td>
                                    <td>{{ $failedLogin->uuid }}</td>
                                    <td>{{ $failedLogin->connection }}</td>
                                    <td>{{ $failedLogin->queue }}</td>
                                    <td>{{ $failedLogin->payload }}</td>
                                    <td>{{ $failedLogin->exception }}</td>
                                    <td>{{ $failedLogin->failed_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(request('report_type') === 'documents_by_type' && $usersDocuments->isNotEmpty())
                    <h4>Reporte de Documentos por Tipo</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID Usuario</th>
                                <th>Nombre Usuario</th>
                                <th>Apellido Usuario</th>
                                <th>ID Documento</th>
                                <th>Cite Documento</th>
                                <th>Descripción Documento</th>
                                <th>Estado</th>
                                <th>Tipo de Documento</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usersDocuments as $userDocument)
                                <tr>
                                    <td>{{ $userDocument->user_id }}</td>
                                    <td>{{ $userDocument->user_name }}</td>
                                    <td>{{ $userDocument->user_last_name }}</td>
                                    <td>{{ $userDocument->document_id }}</td>
                                    <td>{{ $userDocument->document_cite }}</td>
                                    <td>{{ $userDocument->Descripcion }}</td>
                                    <td>{{ $userDocument->estado }}</td>
                                    <td>{{ $userDocument->tipo_de_documento }}</td>
                                    <td>{{ $userDocument->document_created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(request('report_type') === 'documents_by_unit' && $usersDocuments->isNotEmpty())
                    <h4>Reporte de Documentos por Unidad</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID Usuario</th>
                                <th>Nombre Usuario</th>
                                <th>Apellido Usuario</th>
                                <th>Cite Documento</th>
                                <th>Unidad</th>
                                <th>Tipo de Documento</th>
                                <th>Estado</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($usersDocuments as $userDocument)
                                <tr>
                                    <td>{{ $userDocument->user_id }}</td>
                                    <td>{{ $userDocument->user_name }}</td>
                                    <td>{{ $userDocument->user_last_name }}</td>
                                    <td>{{ $userDocument->document_cite }}</td>
                                    <td>{{ $userDocument->unidad }}</td>
                                    <td>{{ $userDocument->Tipo_de_documento }}</td>
                                    <td>{{ $userDocument->estado }}</td>
                                    <td>{{ $userDocument->document_created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @elseif(request('report_type') === 'documents_sent_received' && $documentos->isNotEmpty())
                    <h4>Reporte de Documentos Enviados/Recibidos</h4>
                    <table class="table table-striped table-dataTables">
                        <thead>
                            <tr>
                                <th>ID Documento</th>
                                <th>Cite Documento</th>
                                <th>Descripción Documento</th>
                                <th>Estado</th>
                                <th>Creado</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($documentos as $documento)
                                <tr>
                                    <td>{{ $documento->document_id }}</td>
                                    <td>{{ $documento->document_cite }}</td>
                                    <td>{{ $documento->document_description }}</td>
                                    <td>{{ $documento->Estado }}</td>
                                    <td>{{ $documento->document_created_at }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p>No hay datos disponibles para el reporte seleccionado.</p>
                @endif
            @endif
        </div>
    </div>
@endsection

@push('scripts')
    <!-- ================== BEGIN BASE JS ================== -->
	<script src="../assets/js/app.min.js"></script>
	<script src="../assets/js/theme/material.min.js"></script>
	<!-- ================== END BASE JS ================== -->
	
	<!-- ================== BEGIN PAGE LEVEL JS ================== -->
	<script src="../assets/plugins/datatables.net/js/jquery.dataTables.min.js"></script>
	<script src="../assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
	<script src="../assets/plugins/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-autofill/js/dataTables.autofill.min.js"></script>
	<script src="../assets/plugins/datatables.net-autofill-bs4/js/autofill.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-colreorder/js/dataTables.colreorder.min.js"></script>
	<script src="../assets/plugins/datatables.net-colreorder-bs4/js/colreorder.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-keytable/js/dataTables.keytable.min.js"></script>
	<script src="../assets/plugins/datatables.net-keytable-bs4/js/keytable.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-rowreorder/js/dataTables.rowreorder.min.js"></script>
	<script src="../assets/plugins/datatables.net-rowreorder-bs4/js/rowreorder.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-select/js/dataTables.select.min.js"></script>
	<script src="../assets/plugins/datatables.net-select-bs4/js/select.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons/js/buttons.flash.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons/js/buttons.html5.min.js"></script>
	<script src="../assets/plugins/datatables.net-buttons/js/buttons.print.min.js"></script>
	<script src="../assets/plugins/pdfmake/build/pdfmake.min.js"></script>
	<script src="../assets/plugins/pdfmake/build/vfs_fonts.js"></script>
	<script src="../assets/plugins/jszip/dist/jszip.min.js"></script>
	<script src="../assets/js/demo/table-manage-combine.demo.js"></script>
	<!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function() {
            // Inicializar datepicker para el rango de fechas
            $('.input-daterange').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true
            });

            // Mostrar u ocultar el filtro de rango de fechas basado en el tipo de reporte seleccionado
            $('#report_type').change(function() {
                if ($(this).val() !== '') {
                    $('#date-range-filters').show();
                } else {
                    $('#date-range-filters').hide();
                }
                $('#fecha_inicial').val('');
                $('#fecha_final').val('');
            });

            // Trigger change event on page load to show/hide date filters if a report type is selected
            if ($('#report_type').val() !== '') {
                $('#date-range-filters').show();
            }

            // Inicializar DataTables para cada tabla
            $('.table-dataTables').each(function() {
                $(this).DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    responsive: true,
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.24/i18n/Spanish.json'
                    }
                });
            });
        });
    </script>
@endpush
