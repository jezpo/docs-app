@extends('layouts.default')

@section('title', config('hermes.name') . 'Correspondencia' . 'Unidades')

@push('css')
    <link href="/assets/plugins/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet" />
@endpush

@section('header-nav')

@endsection

@section('content')
    <ol class="breadcrumb float-xl-right">
        <li class="breadcrumb-item"><a href="{{ url('/dashboard') }}">Principal</a></li>

        <li class="breadcrumb-item active">Panel Unidades</li>
    </ol>
    <!-- begin page-header -->
    <h1 class="page-header"><i class="fas fa-file-alt fa-fw"></i> Unidad o Carreras <small></small></h1>
    <!-- end page-header -->

    <div class="panel panel-inverse">
        <!-- begin panel-heading -->
        <div class="panel-heading ui-sortable-handle d-flex justify-content-between align-items-center">
            <div class="d-block">
                <a id="abrirDocumentoModal" href="#modal-dialog" class="btn btn-sm btn btn-primary" data-toggle="modal"><i
                        class="fas fa-plus"></i> Nuevo Unidad O Carrera</a>
            </div>

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
                        <table id="programa-table"
                            class="table table-striped table-bordered table-td-valign-middle dt-responsive "
                            style="width:100%">
                            <thead>
                                <tr>
                                    <th class="text-nowrap">Nro</th>
                                    <th class="text-nowrap">Sigla</th>
                                    <th class="text-nowrap">Programa</th>
                                    {{-- <th class="text-nowrap">Nivel de unidad</th> --}}
                                    <th class="text-nowrap">Estado</th>
                                    <th class="text-nowrap">Acciones</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <!--FINAL DE CODIGO DONDE MUESTRA LAS TABLAS -->
                    <div class="modal fade" class="modal fade" id="modal-dialog">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="nuevoDocumentoModalLabel">
                                        <i class="fas fa-building"></i> Nuevo Unidad O Carrera
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de creación -->
                                    <form id="crearNuevoProgramaForm" class="form-horizontal" method="PUT"
                                        enctype="multipart/form-data" action="{{ route('programas.store') }}">
                                        @csrf
                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Sigla de
                                                la Unidad o Carrera: </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="id_programa" value=""
                                                    name="id_programa"
                                                    placeholder="ingrese la abrebiatura de la unidad o carrera"
                                                    data-parsley-required="true">
                                                @error('id_programa')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ 'Este valor es requerido' }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Nombre
                                                Unidad O Carrrea:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="programa" value=""
                                                    name="programa" placeholder="Nombre de Unidad O Carrera"
                                                    data-parsley-required="true">
                                                @error('programa')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ 'Este valor es requerido' }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Ingresa
                                                el nivel numerico:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="id_padre" value=""
                                                    name="id_padre" placeholder="Nombre de Unidad O Carrera"
                                                    data-parsley-required="true">
                                                @error('id_padre')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
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
                                                        <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                            aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ 'este valor es requerido' }}</li>
                                                        </ul>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-0">
                                            <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                            <div class="col-md-8 col-sm-8">
                                                <button type="submit" class="btn btn-primary"><i class="fas fa-save">
                                                    </i> Registrar</button>
                                            </div>
                                        </div>


                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!--DONDE MUESTRA LAS TABLAS ATRAVES DE DATA TABLES -->
                    <!-- Modal para Ver -->
                    <div class="modal fade" id="verDocumentoModal" tabindex="-1" role="dialog"
                        aria-labelledby="verDocumentoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="verDocumentoModalLabel">Detalles del Documento
                                    </h5>
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
                    <!-- Modal para Editar -->
                    <div class="modal fade" id="editarProgramaModal" tabindex="-1" role="dialog"
                        aria-labelledby="editarDocumentoModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editarDocumentoModalLabel"><i class="fas fa-edit"></i>
                                        Editar Unidad o Carrera
                                    </h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!-- Formulario de edición -->
                                    <form id="editarProgramaForm" class="form-horizontal" method="POST"
                                        enctype="multipart/form-data" class="form-horizontal">
                                        @csrf
                                        @method('PUT')
                                        <input type="hidden" id="edit-programa-id" name="id">
                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Sigla
                                                de
                                                Unidad o carrera:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="id_programa2"
                                                    value="" name="id_programa2"
                                                    placeholder="ingrese la abrebiatura de la unidad o carrera"
                                                    data-parsley-required="true">
                                                @error('id_programa')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ 'Este valor es requerido' }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Nombre
                                                Unidad O Carrrea:</label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="programa2" value=""
                                                    name="programa2" placeholder="Nombre de Unidad O Carrera"
                                                    data-parsley-required="true">
                                                @error('programa')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ 'Este valor es requerido' }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label" for="fullname">Ingresa
                                                el nivel numerico: </label>
                                            <div class="col-md-8 col-sm-8">
                                                <input class="form-control" type="text" id="id_padre2" value=""
                                                    name="id_padre2" placeholder="Nombre de Unidad O Carrera"
                                                    data-parsley-required="true">
                                                @error('id_padre')
                                                    <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                        aria-hidden="false">
                                                        <li class="parsley-required">
                                                            {{ 'Este valor es requerido' }}</li>
                                                    </ul>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="form-group row m-b-15">
                                            <label class="col-md-4 col-sm-4 col-form-label">Estado: </label>
                                            <div class="col-md-8 col-sm-8">
                                                <select class="form-control" id="estado2" name="estado2"
                                                    data-parsley-required="true">
                                                    <option value="">Por favor selecciona una opcion
                                                    </option>
                                                    <option value="A">Activo</option>
                                                    <option value="I">Inactivo</option>
                                                    @error('estado')
                                                        <ul class="parsley-errors-list filled" id="parsley-id-5"
                                                            aria-hidden="false">
                                                            <li class="parsley-required">
                                                                {{ 'este valor es requerido' }}</li>
                                                        </ul>
                                                    @enderror
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group row m-b-0">
                                            <label class="col-md-4 col-sm-4 col-form-label">&nbsp;</label>
                                            <div class="col-md-8 col-sm-8">
                                                <button type="submit" class="btn btn-primary"><i class="far fa-save">
                                                    </i> Registrar</button>
                                            </div>
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
                                    <button type="button" class="btn btn-secondary"
                                        data-dismiss="modal">Cancelar</button>
                                    <button type="button" class="btn btn-danger" id="btnDelete"
                                        name="btnDelete">Eliminar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal fade" id="pdfModal" tabindex="-1" role="dialog"
                        aria-labelledby="pdfModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="pdfModalLabel">Vista previa del PDF</h5>
                                    <button type="button" class="btn-close" data-dismiss="modal"
                                        aria-label="Close"></button>
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

                    <!-- end panel-body -->

                </div>
            </div>
        </div>
        <!-- end panel-body -->
    </div>




@endsection
@push('scripts')
    {{-- Aqui se coloca los JS de assets --}}
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
    <script src="../assets/plugins/sweetalert2/dist/sweetalert2.all.min.js"></script>
    <!-- ================== END PAGE LEVEL JS ================== -->
    <script>
        $(document).ready(function() {
            var documentTable = $('#programa-table').DataTable({

                paging: true,
                lengthChange: true,
                searching: true,
                ordering: true,
                info: true,
                autoWidth: true,
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('programas.index') }}',
                },

                columns: [{
                        data: 'id',
                        name: 'id',
                        render: function(data, type, row, meta) {
                            return meta.row + meta.settings._iDisplayStart + 1;
                        }
                    },
                    {
                        data: 'id_programa',
                        name: 'id_programa'
                    },
                    {
                        data: 'programa',
                        name: 'programa'
                    },
                    //{
                    //  data: 'id_padre',
                    // name: 'id_padre'
                    //},
                    {
                        data: 'estado',
                        name: 'estado',
                        render: function(data, type, row) {
                            return data === 'A' ? 'Activo' : 'Inactivo';
                        }
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: false,
                        searchable: false
                    },
                ],
                buttons: [{
                        extend: 'pdf',
                        className: 'btn btn-danger',
                        text: '<i class="fa fa-file-pdf"></i> PDF'
                    },
                    {
                        extend: 'excel',
                        className: 'btn btn-success',
                        text: '<i class="fa fa-file-excel"></i> Excel'
                    },
                    {
                        extend: 'print',
                        className: 'btn btn-primary',
                        text: '<i class="fa fa-print"></i> Imprimir'
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
        $(document).ready(function() {
            $("#crearNuevoProgramaForm").submit(function(e) {
                e.preventDefault();
                let formData = new FormData(this);
                $.ajax({
                    url: '{{ route('programas.store') }}',
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    success: function(response) {
                        if (response.success) {
                            Swal.fire({
                                icon: 'success',
                                title: '¡Éxito!',
                                text: 'Programa registrado con éxito!'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#modal-dialog').modal('hide');
                                    location
                                        .reload(); // Opcional, si deseas recargar la página después de una inserción exitosa.
                                }
                            });
                        } else {
                            Swal.fire({
                                icon: 'error',
                                title: 'Error',
                                text: 'Hubo un error al registrar el programa.'
                            });
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Error: ' + textStatus
                        });
                    }
                });
            });
        });
    </script>
    <script>
        function editProgram(id) {
            $.get('/programas/' + id + '/edit', function(data) {

                $('#edit-programa-id').val(data.id);
                $('#id_programa2').val(data.id_programa);
                $('#programa2').val(data.programa);
                $('#id_padre2').val(data.id_padre);
                $('#estado2').val(data.estado).trigger('change');
                $('#editarProgramaModal').modal('show');
            }).fail(function() {
                Swal.fire({
                    icon: 'error',
                    title: '¡Error!',
                    text: 'Ocurrió un error al cargar los datos del programa. Por favor, inténtalo de nuevo.'
                });
            });
        }

        $('#editarProgramaForm').submit(function(e) {
            e.preventDefault();

            var id = $('#edit-programa-id').val();
            var id_programa = $('#id_programa2').val();
            var programa = $('#programa2').val();
            var id_padre = $('#id_padre2').val();
            var estado = $('#estado2').val();

            $.ajax({
                url: '/dashboard/programas/' + id,
                type: 'POST',
                data: {
                    _token: $('input[name="_token"]').val(),
                    _method: 'PUT',
                    id_programa: id_programa,
                    programa: programa,
                    id_padre: id_padre,
                    estado: estado
                },
                success: function(response) {
                    if (response.success == true) {
                        $('#editarProgramaModal').modal('hide');
                        Swal.fire({
                            icon: 'success',
                            title: '¡Registro actualizado!',
                            showConfirmButton: false,
                            timer: 1000
                        });
                        $('#programas-table').DataTable().ajax.reload();
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: '¡Error!',
                            text: 'Ocurrió un error al actualizar el programa. Por favor, inténtalo de nuevo.'
                        });
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    Swal.fire({
                        icon: 'error',
                        title: '¡Error!',
                        text: 'Ocurrió un error al actualizar el programa. Por favor, inténtalo de nuevo.'
                    });
                    console.log("Error de AJAX: " + textStatus + ' : ' + errorThrown);
                }
            });
        });
    </script>
    <script>
        // Definir la variable global 'doc_id' que almacenará el ID del documento a eliminar
        var doc_id;
        // Función que será llamada cuando se haga clic en el botón "Eliminar"
        function deleteProgram(id) {
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
                    // El usuario confirmó la eliminación, ejecuta la solicitud AJAX
                    $.ajax({
                        url: '/dashboard/programas/destroy/' + doc_id,
                        method: 'DELETE',
                        data: {
                            _token: $('input[name="_token"]').val(),
                        },
                        beforeSend: function() {
                            // Cambia el texto del botón mientras se realiza la solicitud
                            Swal.showLoading();
                        },
                        success: function(data) {
                            setTimeout(function() {
                                Swal.fire(
                                    'Eliminado',
                                    'El registro fue eliminado correctamente',
                                    'success'
                                );

                                // Asumiendo que tienes DataTable y quieres recargar los datos
                                $('#programa-table').DataTable().ajax.reload();
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
@endpush
