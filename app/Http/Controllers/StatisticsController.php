<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Documento;
use App\Models\Programa;
use App\Models\Gestion;
use Yajra\Datatables\Datatables;

class StatisticsController extends Controller
{

    public function index()
    {
        $totalUsuarios = User::count();
        $totalDocumentos = Documento::count();
        $totalProgramas = Programa::count();
        $gestion = Gestion::count();
        $totalDocumentosToday = Documento::whereDate('created_at', date('Y-m-d'))->count();
        $totalDocumentosThisWeek = Documento::whereBetween('created_at', 
                                                            [date('Y-m-d', 
                                                            strtotime('last monday')), 
                                                            date('Y-m-d', strtotime('next sunday'))])->count();
        $totalDocumentosThisMonth = Documento::whereBetween('created_at', [date('Y-m-01'), 
        date('Y-m-t')])->count();


        return [
            'totalUsuarios' => $totalUsuarios,
            'totalDocumentosToday' => $totalDocumentosToday,
            'totalDocumentosThisWeek' => $totalDocumentosThisWeek,
            'totalDocumentosThisMonth' => $totalDocumentosThisMonth,
            'totalDocumentos' => $totalDocumentos,
            'totalProgramas' => $totalProgramas,
            'gestion' => $gestion
        ];
    }
}