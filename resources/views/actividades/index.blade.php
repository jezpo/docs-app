@extends('layouts.default')
@section('title1', 'Admin U.A.T.F.')
@section('title', 'Historial de Actividades')
@section('Users', 'active')


@push('css')
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
        <li class="breadcrumb-item active">Historial de Actividades</li>
    </ol>
    <!-- end breadcrumb -->
    <!-- begin page-header -->
    <h1 class="page-header"><i class="fas fa-history fa-fw"></i> Historial de Actividades <small></small></h1>
    <!-- end page-header -->
    <!-- begin panel -->


    <div class="panel panel-inverse" data-sortable-id="ui-widget-1">
        <div class="panel-heading">
            <h4 class="panel-title"></h4>
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
            <table id="activityLogsTable" class="table table-striped table-bordered table-td-valign-middle dt-responsive nowrap"
            style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Model Type</th>
                        <th>Model ID</th>
                        <th>Action</th>
                        {{--<th>Details</th>--}}
                        <th>User</th>
                        <th>Created At</th>
                    </tr>
                </thead>
            </table>

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
            $('#activityLogsTable').DataTable({
                processing: true,
                serverSide: true,
                ajax: "{{ route('activity.logs.data') }}",
                columns: [
                    { data: 'id', name: 'id' },
                    { data: 'model_type', name: 'model_type' },
                    { data: 'model_id', name: 'model_id' },
                    { data: 'action', name: 'action' },
                    //{ data: 'details', name: 'details' },
                    { data: 'user_name', name: 'user.name' },
                    { data: 'created_at', name: 'created_at' }
                ],
                language: {
                    url: '/assets/plugins/datatables.net/Spanish.json'
                },
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
                
            });
        });
    </script>
@endpush