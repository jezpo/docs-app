<?php

namespace App\Http\Controllers;

use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ActivityLogController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:logs-view', ['only' => ['index', 'getLogs']]);
    }
    public function index()
    {
        return view('actividades.index');
    }

    public function getLogs(Request $request)
    {
        if ($request->ajax()) {
            $logs = ActivityLog::with('user')->latest()->get();

            // Depuración: Verifica si los usuarios están siendo cargados correctamente
            foreach ($logs as $log) {
                if ($log->user) {
                    logger('User found: ' . $log->user->name);
                } else {
                    logger('User not found for log ID: ' . $log->id);
                }
            }

            return DataTables::of($logs)
                ->addColumn('user_name', function ($log) {
                    return $log->user ? $log->user->name : 'N/A';
                })
                ->make(true);
        }
    }
}