@extends('layouts.default')

@section('title', 'Reportes')

@push('css')
    <!-- Estilos para el datepicker -->
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/bootstrap-datepicker/dist/css/bootstrap-datepicker3.css') }}" rel="stylesheet" />
    <!-- Estilos para DataTables -->
    <link href="{{ asset('assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css') }}" rel="stylesheet" />
@endpush
@section('content')
    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
        <div class="panel-heading">
            <h4 class="panel-title">Panel de administrativo</h4>
            <div class="panel-heading-btn">
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-default" data-click="panel-expand"><i class="fa fa-expand"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-success" data-click="panel-reload"><i class="fa fa-redo"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-warning" data-click="panel-collapse"><i class="fa fa-minus"></i></a>
                <a href="javascript:;" class="btn btn-xs btn-icon btn-circle btn-danger" data-click="panel-remove"><i class="fa fa-times"></i></a>
            </div>
        </div>
        <div class="panel-body">
            <form method="GET" action="{{ route('reports.index') }}">
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label>Tipo de Reporte:</label>
                        <select id="report_type" name="report_type" class="form-control">
                            <option value="documents" {{ $reportType === 'documents' ? 'selected' : '' }}>Documentos</option>
                            <option value="users" {{ $reportType === 'users' ? 'selected' : '' }}>Usuarios</option>
                            <option value="failed_logins" {{ $reportType === 'failed_logins' ? 'selected' : '' }}>Intentos Fallidos de Inicio de Sesión</option>
                            <option value="users_documents" {{ $reportType === 'users_documents' ? 'selected' : '' }}>Usuarios y Documentos</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="date-range-container" style="display: none;">
                        <label>Rango de Fechas:</label>
                        <div class="input-group">
                            <input type="text" id="start_date" name="fecha_inicial" class="form-control" placeholder="Fecha Inicio" value="{{ $fechaInicial }}">
                            <input type="text" id="end_date" name="fecha_final" class="form-control" placeholder="Fecha Fin" value="{{ $fechaFinal }}">
                        </div>
                    </div>
                    <div class="col-md-4" id="tipo-documento-container" style="display: none;">
                        <label>Tipo de Documento:</label>
                        <select id="tipo_documento" name="tipo_documento" class="form-control">
                            <option value="todos" {{ $tipoDocumento === 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="1" {{ $tipoDocumento == 1 ? 'selected' : '' }}>Carta</option>
                            <option value="2" {{ $tipoDocumento == 2 ? 'selected' : '' }}>Dictamen</option>
                            <option value="3" {{ $tipoDocumento == 3 ? 'selected' : '' }}>Nota</option>
                            <option value="4" {{ $tipoDocumento == 4 ? 'selected' : '' }}>Resolución</option>
                            <option value="5" {{ $tipoDocumento == 5 ? 'selected' : '' }}>Solicitudes</option>
                            <option value="6" {{ $tipoDocumento == 6 ? 'selected' : '' }}>Actas</option>
                            <option value="7" {{ $tipoDocumento == 7 ? 'selected' : '' }}>Recibos</option>
                        </select>
                    </div>
                    <div class="col-md-4" id="tipo-correspondencia-container" style="display: none;">
                        <label>Tipo de Correspondencia:</label>
                        <select id="tipo_correspondencia" name="tipo_correspondencia" class="form-control">
                            <option value="todos" {{ $tipoCorrespondencia === 'todos' ? 'selected' : '' }}>Todos</option>
                            <option value="envios" {{ $tipoCorrespondencia === 'envios' ? 'selected' : '' }}>Enviados</option>
                            <option value="recibidos" {{ $tipoCorrespondencia === 'recibidos' ? 'selected' : '' }}>Recibidos</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label>&nbsp;</label>
                        <div class="input-group-append">
                            <button id="filter" class="btn btn-primary"><i class="fa fa-search"></i> Buscar</button>
                        </div>
                    </div>
                </div>
            </form>
            <div class="row">
                @if($reportType === 'documents')
                    @if($documentos->isEmpty())
                        <p>No se encontraron documentos.</p>
                    @else
                        <div class="table-responsive">
                            <table id="documents-table" class="table table-striped table-bordered dt-responsive nowrap" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Cite</th>
                                        <th>Descripción</th>
                                        <th>Estado</th>
                                        <th>Fecha</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($documentos as $documento)
                                        <tr>
                                            <td>{{ $documento->cite }}</td>
                                            <td>{{ $documento->descripcion }}</td>
                                            <td>
                                                @if ($documento->estado === 'A')
                                                    Activo
                                                @elseif ($documento->estado === 'I')
                                                    Inactivo
                                                @else
                                                    Desconocido
                                                @endif
                                            </td>
                                            <td>{{ $documento->created_at }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                @elseif($reportType === 'users')
                    <div class="table-responsive">
                        <table id="users-table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nombre</th>
                                    <th>Apellido</th>
                                    <th>Email</th>
                                    <th>Fecha de Creación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($users as $user)
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
                    </div>
                @elseif($reportType === 'failed_logins')
                    <div class="table-responsive">
                        <table id="failed-logins-table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>UUID</th>
                                    <th>Conexión</th>
                                    <th>Cola</th>
                                    <th>Payload</th>
                                    <th>Excepción</th>
                                    <th>Fecha de Falla</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($failedLogins as $failedLogin)
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
                    </div>
                @elseif($reportType === 'users_documents')
                    <div class="table-responsive">
                        <table id="users-documents-table" class="table table-striped table-bordered dt-responsive nowrap">
                            <thead>
                                <tr>
                                    <th>ID de Usuario</th>
                                    <th>Nombre de Usuario</th>
                                    <th>Apellido de Usuario</th>
                                    <th>ID de Documento</th>
                                    <th>Cite del Documento</th>
                                    <th>Descripción del Documento</th>
                                    <th>Estado del Documento</th>
                                    <th>Fecha de Creación del Documento</th>
                                    <th>Estado de Actividad del Documento</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($usersDocuments as $userDocument)
                                    <tr>
                                        <td>{{ $userDocument->user_id }}</td>
                                        <td>{{ $userDocument->user_name }}</td>
                                        <td>{{ $userDocument->user_last_name }}</td>
                                        <td>{{ $userDocument->document_id }}</td>
                                        <td>{{ $userDocument->document_cite }}</td>
                                        <td>{{ $userDocument->document_description }}</td>
                                        <td>{{ $userDocument->document_status }}</td>
                                        <td>{{ $userDocument->document_created_at }}</td>
                                        <td>{{ $userDocument->document_activity_status }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script src="{{ asset('assets/plugins/bootstrap-datepicker/dist/js/bootstrap-datepicker.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net/js/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons-bs4/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/jszip/dist/jszip.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/build/pdfmake.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/pdfmake/build/vfs_fonts.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('assets/plugins/datatables.net-buttons/js/buttons.colVis.min.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Inicializar los datepickers y establecer valores predeterminados
            $('#start_date, #end_date').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            // Establecer los valores vacíos para fecha inicial y fecha final
            $('#start_date').val('');
            $('#end_date').val('');

            // Inicializar DataTables
            function initDataTable(tableId) {
                $(tableId).DataTable({
                    dom: 'Bfrtip',
                    buttons: [
                        {
                            extend: 'copy',
                            text: 'Copiar',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'csv',
                            text: 'CSV',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'excel',
                            text: 'Excel',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'pdf',
                            text: 'PDF',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        {
                            extend: 'print',
                            text: 'Imprimir',
                            exportOptions: {
                                columns: ':visible'
                            }
                        },
                        'colvis'
                    ],
                    language: {
                        url: '//cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json'
                    }
                });
            }

            initDataTable('#documents-table');
            initDataTable('#users-table');
            initDataTable('#failed-logins-table');
            initDataTable('#users-documents-table');

            // Mostrar/ocultar campos según el tipo de reporte seleccionado
            function toggleFields(reportType) {
                if (reportType === 'documents') {
                    $('#date-range-container').show();
                    $('#tipo-documento-container').show();
                    $('#tipo-correspondencia-container').show();
                } else {
                    $('#date-range-container').hide();
                    $('#tipo-documento-container').hide();
                    $('#tipo-correspondencia-container').hide();
                }
            }

            $('#report_type').change(function() {
                toggleFields($(this).val());
            });

            // Inicializar la visibilidad de los campos según el valor inicial del tipo de reporte
            toggleFields($('#report_type').val());

            // Capturar el evento del botón de filtro
            $('#filter').click(function() {
                var tipoDocumento = $('#tipo_documento').val();
                var tipoCorrespondencia = $('#tipo_correspondencia').val();

                // Si el valor seleccionado es "todos", eliminar el atributo 'name' para enviar todos los registros
                if (tipoDocumento === 'todos') {
                    $('#tipo_documento').removeAttr('name');
                }
                if (tipoCorrespondencia === 'todos') {
                    $('#tipo_correspondencia').removeAttr('name');
                }

                // Enviar el formulario
                $('form').submit();
            });
        });
    </script>
@endpush
