<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;   
use App\Models\Documento; 
use App\Models\Programa;

class StatisticsController extends Controller
{
    public function index()
    {
        $totalUsuarios = User::count();
        $totalDocumentos = Documento::count();
        $totalProgramas = Programa::count();

        return ['totalUsuarios' => $totalUsuarios, 'totalDocumentos' => $totalDocumentos, 'totalProgramas' => $totalProgramas];
    }
}