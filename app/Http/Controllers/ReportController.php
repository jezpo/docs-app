<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Documento;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view reports')->only('index');
    }

    public function index(Request $request)
    {
        $reportType = $request->input('report_type', 'documents'); // Default report type
        $fechaInicial = $request->input('fecha_inicial');
        $fechaFinal = $request->input('fecha_final');
        $tipoDocumento = $request->input('tipo_documento');
        $tipoCorrespondencia = $request->input('tipo_correspondencia');

        $documentos = collect();
        $users = collect();
        $failedLogins = collect();
        $usersDocuments = collect();

        if ($reportType === 'documents') {
            $query = Documento::query();

            if ($tipoCorrespondencia && $tipoCorrespondencia !== 'todos') {
                $estado = $tipoCorrespondencia === 'envios' ? 'enviado' : 'recibido';
                $query->where('estado', $estado);
            }

            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('created_at', [$fechaInicial, $fechaFinal]);
            }

            if ($tipoDocumento && $tipoDocumento !== 'todos') {
                $query->where('id_tipo_documento', $tipoDocumento);
            }

            $documentos = $query->get();
        } elseif ($reportType === 'users') {
            $users = DB::table('users')
                ->select('id', 'name', 'last_name', 'email', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->get();
        } elseif ($reportType === 'failed_logins') {
            $failedLogins = DB::table('failed_jobs')
                ->select('id', 'uuid', 'connection', 'queue', 'payload', 'exception', 'failed_at')
                ->orderBy('failed_at', 'DESC')
                ->get();
        } elseif ($reportType === 'users_documents') {
            $usersDocuments = DB::table('users as u')
                ->join('documentos as d', 'u.id', '=', 'd.id_origen_tipo')
                ->select(
                    'u.id as user_id',
                    'u.name as user_name',
                    'u.last_name as user_last_name',
                    'd.id as document_id',
                    'd.cite as document_cite',
                    'd.descripcion as document_description',
                    'd.estado as document_status',
                    'd.created_at as document_created_at',
                    DB::raw("CASE WHEN d.estado = 'activo' THEN 'Active' ELSE 'Inactive' END as document_activity_status")
                )
                ->orderBy('d.created_at', 'DESC')
                ->get();
        }

        return view('report.index', compact('documentos', 'users', 'failedLogins', 'usersDocuments', 'reportType', 'fechaInicial', 'fechaFinal', 'tipoDocumento', 'tipoCorrespondencia'));
    }
}
