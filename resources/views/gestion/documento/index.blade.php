@extends('layouts.default')
@section('title1', 'Admin U.A.T.F.')
@section('title', 'Documentos')
@section('Users', 'active')


@push('css')
    <link href="/assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
@endpush

@section('header-nav')

@endsection

@section('content')

    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Principal</a></li>

        <li class="breadcrumb-item active">Panel Tramite</li>
    </ol>
    <!-- begin page-header -->
    <h1 class="page-header"><i class="fas fa-file-alt fa-fw"></i> Documentos<small></small></h1>
    <!-- end page-header -->

    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle d-flex justify-content-between align-items-center">

            <button id="addDocumentoForm" class="btn btn-sm btn btn-primary" data-toggle="modal"
                data-target="#modal-dialog">
                <i class="fas fa-plus"></i> Crear Nuevo Documento
            </button>

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
        <!-- end panel-heading -->
        <!-- begin panel-body -->



        <div class="panel-body">
            <div id="data-table-combine_wrapper" class="dataTables_wrapper dt-bootstrap4 no-footer">
                <div class="dataTables_wrapper dt-bootstrap">
                    <div class="table-responsive">
                        <div class="">
                            <!-- Botón para abrir el modal de creación -->
                            <br>
                            <!-- DONDE MUESTRA LAS TABLAS ATRAVES DE DATA TABLES -->
                            <div style="position: absolute; height: 1px; width: 0px; overflow: hidden;">
                                <input type="text" tabindex="0">
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <table id="documentos-table"
                                        class="table table-striped table-bordered table-td-valign-middle dt-responsive nowrap"
                                        style="width:100%">
                                        <thead>
                                            <tr>
                                                <th class="text-nowrap">Nro.</th>
                                                <th class="text-nowrap">Cite</th>
                                                <th class="text-nowrap">Descripción</th>
                                                <th class="text-nowrap">Estado</th>
                                                <th class="text-nowrap">Tipo de Documento</th>
                                                <th class="text-nowrap">Acciones</th>
                                            </tr>
                                        </thead>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <!-- end panel-body -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Ver -->
        <div class="modal fade" id="verDocumentoModal" tabindex="-1" role="dialog"
            aria-labelledby="verDocumentoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="verDocumentoModalLabel">Detalles del Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Contenido para mostrar detalles del documento -->
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Nuevo -->
        <div class="modal fade" class="modal fade" id="modal-dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">

                        <h5 class="modal-title" id="nuevoDocumentoModalLabel">
                            <i class="fas fa-plus"></i> Nuevo Documento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>

                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de creación -->
                        <form id="crearNuevoDocumentoForm" class="form-horizontal" method="POST"
                            enctype="multipart/form-data" action="{{ route('documentos.store') }}">
                            @csrf
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Tipo de
                                    Documento:</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="origen_tipos_id" name="origen_tipos_id"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona una opción</option>
                                        <option value="1" data-tipo="1">Enviado</option>
                                        <option value="2" data-tipo="2">Recibido</option>
                                    </select>
                                    @error('origen_tipos_id')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">{{ 'Este valor es requerido' }}
                                            </li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label" for="cite">Cite:</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="cite" name="cite"
                                        placeholder="cite" data-parsley-required="true">
                                    @error('cite')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">{{ 'Este valor es requerido' }}
                                            </li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <input type="hidden" id="anio_gestion" name="anio_gestion"
                                value="{{ $gestion ? $gestion->anio : '' }}">

                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Descripcion:</label>
                                <div class="col-md-8 col-sm-8">
                                    <textarea class="form-control" type="text" id="descripcion" value="" name="descripcion"
                                        placeholder="descripcion" data-parsley-required="true"></textarea>
                                    @error('descripcion')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">
                                                {{ 'Este valor es requerido' }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Estado: </label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="estado" name="estado"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona una opcion
                                        </option>
                                        <option value="A">Activo</option>
                                        <option value="I">Inactivo</option>
                                        @error('estado')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">
                                                    {{ 'este valor es requerido' }}</li>
                                            </ul>
                                        @enderror
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Archivo:</label>
                                <div class="form-group col-md-8 col-sm-8">
                                    <input type="file" class="form-control-file"
                                        class="btn btn-primary
                                        id="documento"
                                        name="documento" accept=".pdf">
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Tipo de documento:
                                </label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="select-required" name="id_tipo_documento"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona una opcion
                                        </option>
                                        <option value="1">Carta</option>
                                        <option value="2">Dictamen</option>
                                        <option value="3">Nota</option>
                                        <option value="4">Resolucion</option>
                                        <option value="5">Solicitudes</option>
                                        <option value="6">Actas</option>
                                        <option value="7">Recibos</option>
                                        @error('id_tipo_documento')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">
                                                    {{ 'este valor es requerido' }}</li>
                                            </ul>
                                        @enderror
                                    </select>
                                </div>
                            </div>

                            <!-- Asegúrate de que jQuery y Select2 estén incluidos antes de este script -->
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Origen:</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control select2_programas" id="id_programa" name="id_programa"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona el origen</option>
                                        @foreach ($programas as $opcion)
                                            <option value="{{ $opcion['id_programa'] }}">
                                                {{ $opcion['programa'] }}</option>
                                            <script>
                                                $(document).ready(function() {
                                                    $('.select2_programas').select2();
                                                });
                                            </script>
                                        @endforeach
                                    </select>
                                    @error('id_programa')
                                        <div class="text-danger">{{ 'Este valor es requerido' }}</div>
                                    @enderror
                                </div>
                            </div>


                            <div class="modal-footer">
                                <hr> <!-- Línea horizontal -->
                                <div class="form-group row m-b-0">
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save"></i> Guardar
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Editar -->
        <div class="modal fade" id="editarDocumentoModal" tabindex="-1" role="dialog"
            aria-labelledby="editarDocumentoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editarDocumentoModalLabel">
                            <i class="fas fa-pencil-alt"></i> Editar Documento
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <!-- Formulario de edición -->
                        <form id="editDocumentoForm" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" id="txtId2" name="txtId2">
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Tipo de Documento:</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="origen_tipos_id2" name="origen_tipos_id" data-parsley-required="true">
                                        <option value="">Por favor selecciona una opción</option>
                                        <option value="1" data-tipo="1">Enviado</option>
                                        <option value="2" data-tipo="2">Recibido</option>
                                    </select>
                                    @error('origen_tipos_id2')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">{{ 'Este valor es requerido' }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Cite:</label>
                                <div class="col-md-8 col-sm-8">
                                    <input class="form-control" type="text" id="cite2" value=""
                                        name="cite2" placeholder="cite" data-parsley-required="true">
                                    @error('cite')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">{{ 'Este valor es requerido' }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>

                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Descripcion:</label>
                                <div class="col-md-8 col-sm-8">
                                    <textarea class="form-control" type="text" id="descripcion2" value="" name="descripcion2"
                                        placeholder="descripcion" data-parsley-required="true"></textarea>
                                    @error('descripcion')
                                        <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                            <li class="parsley-required">{{ 'Este valor es requerido' }}</li>
                                        </ul>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Estado: </label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="estado2" name="estado2"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona una opcion</option>
                                        <option value="A">Activo</option>
                                        <option value="I">Inactivo</option>
                                        @error('estado')
                                            <ul class="parsley-errors-list filled" id="parsley-id-5" aria-hidden="false">
                                                <li class="parsley-required">{{ 'este valor es requerido' }}</li>
                                            </ul>
                                        @enderror
                                    </select>
                                </div>
                            </div>

                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Archivo:</label>
                                <div class="col-md-8 col-sm-8">
                                    <div class="form-group">
                                        <input type="file" class="form-control-file" id="documento2"
                                            name="documento2" accept=".pdf">
                                    </div>
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Tipo de documento:</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control" id="id_tipo_documento2" name="id_tipo_documento2"
                                        data-parsley-required="true">
                                        <option value="">Por favor selecciona una opción</option>
                                        <option value="1">Carta</option>
                                        <option value="2">Dictamen</option>
                                        <option value="3">Nota</option>
                                        <option value="4">Resolucion</option>
                                        <option value="5">Solicitudes</option>
                                        <option value="6">Actas</option>
                                        <option value="7">Recibos</option>
                                    </select>
                                    @error('id_tipo_documento')
                                        <div class="text-danger">{{ 'Este valor es requerido' }}</div>
                                    @enderror
                                </div>
                            </div>
                            <div class="form-group row m-b-15">
                                <label class="col-md-4 col-sm-4 col-form-label">Origen:</label>
                                <div class="col-md-8 col-sm-8">
                                    <select class="form-control select2_programas23" id="id_programa23"
                                        name="id_programa23" data-parsley-required="true">
                                        <option value="">Por favor selecciona el origen</option>
                                        <!-- Opciones dinámicas desde tu backend -->
                                        @foreach ($programas as $opcion)
                                            <option value="{{ $opcion['id_programa'] }}">{{ $opcion['programa'] }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('id_programa23')
                                        <div class="text-danger">{{ 'Este valor es requerido' }}</div>
                                    @enderror
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                    <i class="fas fa-times"></i> Cancelar
                                </button>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-save"></i> Actualizar
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


        <!-- Modal para Eliminar -->
        <div class="modal fade" id="deleteDocument" tabindex="-1" role="dialog"
            aria-labelledby="eliminarDocumentoModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="eliminarDocumentoModalLabel">Eliminar
                            Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <p>¿Estás seguro de que deseas eliminar este documento?</p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                        <button type="button" class="btn btn-danger" id="btnDelete" name="btnDelete">Eliminar</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal para Visualizar PDF -->
        <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog" aria-labelledby="pdfModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="pdfModalLabel">Vista previa del Documento</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <iframe id="pdfFrame" style="width:100%; height:500px;" frameborder="0"></iframe>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    </div>
                </div>
            </div>
        </div>

    </div>


@endsection
@push('scripts')
    <link href="https://fonts.googleapis.com/css?family=Roboto:100,300,400,500,700,900" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" />
    <link href="../assets/css/material/app.min.css" rel="stylesheet" />
    <link href="../assets/plugins/select2/dist/css/select2.min.css" rel="stylesheet" />
    <script src="../assets/plugins/select2/dist/js/select2.min.js"></script>
    <!-- ================== END BASE CSS STYLE ================== -->

    <link href="../assets/plugins/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-autofill-bs4/css/autofill.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-colreorder-bs4/css/colreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-keytable-bs4/css/keytable.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-rowreorder-bs4/css/rowreorder.bootstrap4.min.css" rel="stylesheet" />
    <link href="../assets/plugins/datatables.net-select-bs4/css/select.bootstrap4.min.css" rel="stylesheet" />
    <!-- ================== END PAGE LEVEL STYLE =================C:\laragon\www\odiseogestion-crud3\public\assets\plugins\datatables.net\js= -->

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

    <script src="../assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <link href="../assets/plugins/bootstrap-select/dist/css/bootstrap-select.min.css" rel="stylesheet" />

    <script src="../assets/js/demo/ui-modal-notification.demo.js"></script>
    <script src="../assets/plugins/sweetalert/dist/sweetalert.min.js"></script>
    <link href="../assets/plugins/gritter/css/jquery.gritter.css" rel="stylesheet" />


    <script>
        $(document).ready(function() {
            var documentTable = $('#documentos-table').DataTable({
                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "{{ route('documentos.index') }}",
                },
                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'cite',
                        name: 'cite'
                    },
                    {
                        data: 'descripcion',
                        name: 'descripcion'
                    },
                    {
                        data: 'estado',
                        name: 'estado',
                        render: function(data, type, row) {
                            return data === 'A' ? 'Activo' : 'Inactivo';
                        }
                    },
                    {
                        data: 'id_tipo_documento',
                        name: 'id_tipo_documento',
                        render: function(data, type, row) {
                            switch (data) {
                                case 1:
                                    return 'Carta';
                                case 2:
                                    return 'Dictamen';
                                case 3:
                                    return 'Nota';
                                case 4:
                                    return 'Resolución';
                                case 5:
                                    return 'Solicitudes';
                                case 6:
                                    return 'Actas';
                                case 7:
                                    return 'Recibos';
                                default:
                                    return data;
                            }
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    }
                ],
                buttons: [{
                        extend: 'copy',
                        text: '<i class="fa fa-copy"></i> Copiar',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fa fa-file-csv"></i> CSV',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-file-excel"></i> Excel',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'pdf',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf"></i> PDF',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary',
                        text: '<i class="fa fa-print"></i> Imprimir',
                        exportOptions: {
                            columns: ':not(:last-child)'
                        }
                    }
                ],
                language: {
                    url: '/assets/plugins/datatables.net/Spanish.json'
                },
                dom: '<"dataTables_wrapper dt-bootstrap"<"row"<"col-xl-7 d-block d-sm-flex d-xl-block justify-content-center"<"d-block d-lg-inline-flex mr-0 mr-sm-3"l><"d-block d-lg-inline-flex"B>><"col-xl-5 d-flex d-xl-block justify-content-center"fr>>t<"row"<"col-sm-5"i><"col-sm-7"p>>>',
            });
        });
    </script>

    <script>
        $(function() {
            // Limpia el formulario y abre el modal
            $('#abrirDocumentoModal').click(function() {
                // Limpia los mensajes de error y campos del formulario
                $('.parsley-errors-list').empty();
                $('#crearNuevoDocumentoForm input, #crearNuevoDocumentoForm textarea, #crearNuevoDocumentoForm select')
                    .val('');
            });

            // Agregar evento para enviar el formulario
            $('#crearNuevoDocumentoForm').on('submit', function(e) {
                e.preventDefault();
                var formData = new FormData(this);
                formData.append('_token', '{{ csrf_token() }}');
                $.ajax({
                    url: "{{ route('documentos.store') }}",
                    type: "POST",
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        // Cerrar el modal
                        $('#modal-dialog').modal('hide');

                        $('#crearNuevoDocumentoForm')[0].reset();
                        // Utilizar SweetAlert para mostrar un mensaje de éxito
                        Swal.fire({
                            icon: 'success',
                            title: 'Éxito',
                            text: 'El nuevo documento se ha ingresado correctamente.'
                        }).then(() => {
                            $('#documentos-table').DataTable().ajax.reload();
                        });
                    },
                    error: function(xhr, status, error) {
                        if (xhr.responseJSON.errors) {
                            // Mostrar mensajes de error de validación en el formulario
                            $.each(xhr.responseJSON.errors, function(key, value) {
                                var errorElement = $('#' + key).closest('.form-group')
                                    .find('.parsley-errors-list');
                                errorElement.empty().append(
                                    '<li class="parsley-required">' + value +
                                    '</li>');
                            });
                        }

                        // Utilizar SweetAlert para mostrar un mensaje de error
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Hubo un error al ingresar el nuevo documento.'
                        });
                    }
                });
            });
        });
    </script>
    <script>
        // Definir la variable global 'doc_id' que almacenará el ID del documento a eliminar
        var doc_id;

        // Función que será llamada cuando se haga clic en el botón "Eliminar"
        function deleteDocument(id) {
            doc_id = id;
            console.log("doc_id establecido como: ", doc_id); // Para depuración

            // Utiliza SweetAlert para mostrar un diálogo de confirmación
            Swal.fire({
                title: '¿Estás seguro?',
                text: "Esta acción no se puede deshacer",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí, eliminarlo'
            }).then((result) => {
                if (result.isConfirmed) {
                    var csrfToken = $('meta[name="csrf-token"]').attr('content');
                    // El usuario confirmó la eliminación, ejecuta la solicitud AJAX
                    $.ajax({
                        url: '{{ route('documentos.destroy', '') }}/' + doc_id,
                        type: 'DELETE',
                        dataType: 'json',
                        headers: {
                            'X-CSRF-TOKEN': csrfToken
                        },

                        success: function(data) {
                            setTimeout(function() {
                                Swal.fire(
                                    'Eliminado',
                                    'El registro fue eliminado correctamente',
                                    'success'
                                );

                                // Asumiendo que tienes DataTable y quieres recargar los datos
                                $('#documentos-table').DataTable().ajax.reload();
                            }, 2000);
                        },
                        error: function(xhr, status, error) {
                            console.error("Error: ", xhr, status, error); // Para depuración
                            Swal.fire(
                                'Error',
                                'Hubo un error al eliminar el registro',
                                'error'
                            );
                        }
                    });
                }
            });
        }
    </script>

    <script>
        $(document).ready(function() {
            $('.select2_programas').select2();
        });
    </script>
    <script>
        $(document).ready(function() {
            $('#id_programa').select2();
        });
    </script>

    <script>
        function editDocument(id) {
            $.get('documentos/' + id + '/edit', function(data) {
                console.log(data); // Log para verificar los datos recibidos

                if (data.error) {
                    console.error("Error: " + data.error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Documento no encontrado',
                    });
                    return;
                }

                $('#txtId2').val(data.id);
                $('#origen_tipos_id2').val(data.origen_tipos_id).trigger('change');
                $('#cite2').val(data.cite);
                $('#descripcion2').val(data.descripcion);
                $('#estado2').val(data.estado).trigger('change');
                $('#documento2').val(''); // Limpiar el campo de entrada de archivo
                $('#id_tipo_documento2').val(data.id_tipo_documento).trigger('change');
                $('#id_programa23').val(data.id_programa).trigger('change');
                $("input[name=_token]").val();


                $('#editarDocumentoModal').modal('show');
            }).fail(function(jqXHR, textStatus, errorThrown) {
                console.error("Error AJAX: " + textStatus + ' : ' + errorThrown);
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'No se pudo obtener los datos del documento.',
                });
            });
        }

        $('#editDocumentoForm').submit(function(e) {
            e.preventDefault();
            var id2 = $('#txtId2').val();
            var origen_tipos_id2 = $('#origen_tipos_id2').val();
            var cite2 = $('#cite2').val();
            var descripcion2 = $('#descripcion2').val();
            var estado2 = $('#estado2').val();
            var id_tipo_documento2 = $('#id_tipo_documento2').val();
            var id_programa2 = $('#id_programa23').val();
            var documento2 = $('#documento2')[0].files[0]; // Obtener los datos del archivo
            var _token2 = $("input[name=_token]").val();

            var formData = new FormData();
            formData.append('_method', 'PUT');
            formData.append('origen_tipos_id', origen_tipos_id2);
            formData.append('cite', cite2);
            formData.append('descripcion', descripcion2);
            formData.append('estado', estado2);
            formData.append('id_tipo_documento', id_tipo_documento2);
            formData.append('id_programa', id_programa2);
            if (documento2) {
                formData.append('documento',
                documento2); // Agregar los datos del archivo a los datos del formulario
            }
            formData.append('_token', _token2);
            $.ajax({
                url: 'documentos/' + id2, // Asegúrate de que esta URL es correcta
                type: 'POST',
                data: formData,
                contentType: false,
                processData: false,
                success: function(response) {
                    console.log(response); // Log para verificar la respuesta
                    if (response.success) {
                        $('#editarDocumentoModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro actualizado!',
                            showConfirmButton: false,
                            timer: 1500
                        });
                        $('#documentos-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: response.error || 'Error al actualizar el documento',
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error("Error AJAX: " + textStatus + ' : ' + errorThrown);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'No se pudo actualizar el documento.',
                    });
                }
            });
        });
    </script>

    <script>
        function b64toBlob(b64Data, contentType = '', sliceSize = 512) {
            const byteCharacters = atob(b64Data);
            const byteArrays = [];

            for (let offset = 0; offset < byteCharacters.length; offset += sliceSize) {
                const slice = byteCharacters.slice(offset, offset + sliceSize);

                const byteNumbers = new Array(slice.length);
                for (let i = 0; i < slice.length; i++) {
                    byteNumbers[i] = slice.charCodeAt(i);
                }

                const byteArray = new Uint8Array(byteNumbers);
                byteArrays.push(byteArray);
            }

            const blob = new Blob(byteArrays, {
                type: contentType
            });
            return blob;
        }

        function loadPDF(id) {
            $.ajax({
                url: 'documentos/download/' + id,
                method: 'GET',
                success: function(response) {
                    var blob = b64toBlob(response.base64, 'application/pdf');
                    var blobUrl = URL.createObjectURL(blob);
                    $('#pdfFrame').attr('src', blobUrl);
                    $('#pdfModal').modal('show');
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Documento no encontrado'
                    });
                }
            });
        }
    </script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.getElementById('origen_tipos_id').addEventListener('change', function() {
                const selectedOption = this.options[this.selectedIndex];
                const tipo = selectedOption.getAttribute('data-tipo');
                const citeField = document.getElementById('cite');
                const anioGestion = document.getElementById('anio_gestion').value;

                if (tipo === '1') { // Tipo "Enviado"
                    fetch(`{{ route('generateCite') }}?anio_gestion=${anioGestion}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.cite) {
                                citeField.value = data.cite;
                                citeField.readOnly = true; // Hacer el campo de solo lectura
                            } else {
                                alert('Error al generar el cite.');
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Error al realizar la solicitud.');
                        });
                } else { // Tipo "Recibido"
                    citeField.value = ''; // Limpia el valor del campo
                    citeField.readOnly = false; // Habilitar el campo para edición
                }
            });
        });
    </script>

    {{-- select2 para tipo de documento --}}
    <script>
        $(document).ready(function() {
            // Inicializa Select2
            $('#id_tipo_documento24').select2({
                placeholder: 'Por favor selecciona una opción',
                allowClear: true
            });
        });
    </script>
    <script>
        $(document).ready(function() {
            $('.select2_programas23').select2();
        });
    </script>
@endpush
