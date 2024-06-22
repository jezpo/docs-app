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
        $reportType = $request->input('report_type', 'documents');
        $fechaInicial = $request->input('fecha_inicial');
        $fechaFinal = $request->input('fecha_final');

        $documentos = collect();
        $users = collect();
        $failedLogins = collect();
        $usersDocuments = collect();

        if ($reportType === 'documents') {
            $query = Documento::query();

            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('created_at', [$fechaInicial, $fechaFinal]);
            }

            $documentos = $query->get();
        } elseif ($reportType === 'users') {
            $query = DB::table('users')
                ->select('id', 'name', 'last_name', 'email', 'created_at')
                ->orderBy('created_at', 'DESC');
            
            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('created_at', [$fechaInicial, $fechaFinal]);
            }
            
            $users = $query->get();
        } elseif ($reportType === 'failed_logins') {
            $query = DB::table('failed_jobs')
                ->select('id', 'uuid', 'connection', 'queue', 'payload', 'exception', 'failed_at')
                ->orderBy('failed_at', 'DESC');
            
            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('failed_at', [$fechaInicial, $fechaFinal]);
            }
            
            $failedLogins = $query->get();
        } elseif ($reportType === 'documents_by_type') {
            $query = DB::table('users as u')
                ->join('documentos as d', 'u.id', '=', 'd.origen_tipos_id')
                ->select(
                    'u.id as user_id',
                    'u.name as user_name',
                    'u.last_name as user_last_name',
                    'd.id as document_id',
                    'd.cite as document_cite',
                    'd.descripcion as Descripcion',
                    'd.created_at as document_created_at',
                    'd.origen_tipos_id',
                    'd.id_tipo_documento'
                )
                ->orderBy('d.created_at', 'DESC');
            
            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('d.created_at', [$fechaInicial, $fechaFinal]);
            }
            
            $usersDocuments = $query->get();

            // Mapea los valores de origen_tipos_id y id_tipo_documento a sus respectivos textos
            $usersDocuments->transform(function ($item) {
                $item->Estado = $item->origen_tipos_id == 1 ? 'Enviado' : ($item->origen_tipos_id == 2 ? 'Recibido' : 'Desconocido');
                $item->Tipo_de_documento = match ($item->id_tipo_documento) {
                    1 => 'Carta',
                    2 => 'Dictamen',
                    3 => 'Nota',
                    4 => 'Resolucion',
                    5 => 'Solicitudes',
                    6 => 'Actas',
                    7 => 'Recibos',
                    default => 'Desconocido',
                };
                return $item;
            });
        } elseif ($reportType === 'documents_by_unit') {
            $query = DB::table('documentos as d')
                ->join('users as u', 'u.id', '=', 'd.origen_tipos_id')
                ->join('programas as p', 'p.id_programa', '=', 'd.id_programa')
                ->select(
                    'u.id as user_id',
                    'u.name as user_name',
                    'u.last_name as user_last_name',
                    'd.cite as document_cite',
                    'd.created_at as document_created_at',
                    'p.programa as unidad',
                    'd.origen_tipos_id',
                    'd.id_tipo_documento'
                )
                ->orderBy('d.created_at', 'DESC');
            
            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('d.created_at', [$fechaInicial, $fechaFinal]);
            }
            
            $usersDocuments = $query->get();

            // Mapea los valores de origen_tipos_id y id_tipo_documento a sus respectivos textos
            $usersDocuments->transform(function ($item) {
                $item->Estado = $item->origen_tipos_id == 1 ? 'Enviado' : ($item->origen_tipos_id == 2 ? 'Recibido' : 'Desconocido');
                $item->Tipo_de_documento = match ($item->id_tipo_documento) {
                    1 => 'Carta',
                    2 => 'Dictamen',
                    3 => 'Nota',
                    4 => 'Resolucion',
                    5 => 'Solicitudes',
                    6 => 'Actas',
                    7 => 'Recibos',
                    default => 'Desconocido',
                };
                return $item;
            });
        } elseif ($reportType === 'documents_sent_received') {
            $query = DB::table('documentos as d')
                ->select(
                    'd.id as document_id',
                    'd.cite as document_cite',
                    'd.descripcion as document_description',
                    'd.created_at as document_created_at',
                    'd.origen_tipos_id'
                )
                ->orderBy('d.created_at', 'DESC');
            
            if ($fechaInicial && $fechaFinal) {
                $query->whereBetween('d.created_at', [$fechaInicial, $fechaFinal]);
            }
            
            $documentos = $query->get();

            // Mapea los valores de origen_tipos_id a sus respectivos textos
            $documentos->transform(function ($item) {
                $item->Estado = $item->origen_tipos_id == 1 ? 'Enviado' : ($item->origen_tipos_id == 2 ? 'Recibido' : 'Desconocido');
                return $item;
            });
        }

        return view('report.index', compact(
            'documentos',
            'users',
            'failedLogins',
            'usersDocuments',
            'reportType',
            'fechaInicial',
            'fechaFinal'
        ));
    }
}
