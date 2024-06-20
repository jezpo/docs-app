<?php
namespace App\Http\Controllers;

use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Documento;

class GestionController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:view gestion', ['only' => ['index', 'getDocumentsByYear']]);
        $this->middleware('permission:create gestion', ['only' => ['create', 'store']]);
        $this->middleware('permission:update gestion', ['only' => ['edit', 'update']]);
        $this->middleware('permission:delete gestion', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $gestiones = Gestion::all();
        return view('año.index', compact('gestiones'));
    }

    public function create()
    {
        return view('gestion.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'anio' => 'required|integer|digits:4|in:' . date('Y'),
            'descripcion' => 'required|string',
        ]);

        try {
            Gestion::create($request->all());
            Session::flash('success', 'Gestión creada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al crear la gestión.');
        }

        return back();
    }

    public function edit($id)
    {
        $gestion = Gestion::find($id);
        return response()->json($gestion);
    }

    public function update(Request $request, Gestion $gestion)
    {
        $request->validate([
            'anio' => 'required|integer|digits:4|in:' . date('Y'),
            'descripcion' => 'required|string',
        ]);

        try {
            $gestion->update($request->all());
            Session::flash('success', 'Gestión actualizada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al actualizar la gestión.');
        }

        return back();
    }

    public function destroy(Gestion $gestion)
    {
        try {
            $gestion->delete();
            Session::flash('success', 'Gestión eliminada exitosamente.');
        } catch (\Exception $e) {
            Session::flash('error', 'Error al eliminar la gestión.');
        }

        return back();
    }

    public function getDocumentsByYear(Request $request, $year)
    {
        if ($request->ajax()) {
            $data = Documento::whereYear('created_at', $year)->get();
            return Datatables::of($data)
                ->addColumn('actions', function ($row) {
                    $btn = '<a href="' . route('documento.edit', $row->id) . '" class="edit btn btn-sm btn-warning">Editar</a>';
                    $btn .= ' <form action="' . route('documento.destroy', $row->id) . '" method="POST" style="display:inline;">
                                ' . csrf_field() . '
                                ' . method_field('DELETE') . '
                                <button type="submit" class="delete btn btn-sm btn-danger">Eliminar</button>
                              </form>';
                    return $btn;
                })
                ->rawColumns(['actions'])
                ->make(true);
        }

        return view('documento.index', compact('year'));
    }
}

