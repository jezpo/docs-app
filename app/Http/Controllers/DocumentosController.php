<?php

namespace App\Http\Controllers;

use App\Models\Documento;
use App\Models\Origen;
use App\Models\Programa;
use App\Models\Gestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class DocumentosController extends Controller
{
    public function __construct()
    {
        $this->middleware('permission:docs-list', ['only' => ['index', 'show']]);
        $this->middleware('permission:docs-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:docs-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:docs-view', ['only' => ['show']]);
        $this->middleware('permission:docs-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $data = Documento::list_documents();
            return DataTables::of($data)
                ->addColumn('action', function ($documento) {
                    $actionButtons = '';
                    if (Auth::user()->can('docs-view')) {
                        $actionButtons .= '<a href="javascript:void(0)" type="button" name="viewDocument" onclick="loadPDF(' . $documento->id . ')" class="view btn btn-yellow btn-sm"><i class="fas fa-eye" style="color: white;"></i> Ver</a>';
                    }
                    if (Auth::user()->can('docs-edit')) {
                        $actionButtons .= '&nbsp;&nbsp;<a href="javascript:void(0)" type="button" data-toggle="tooltip" onclick="editDocument(' . $documento->id . ')" class="edit btn btn-primary btn-sm"><i class="fas fa-edit" style="color: white;"></i> Editar</a>';
                    }
                    if (Auth::user()->can('docs-delete')) {
                        $actionButtons .= '&nbsp;&nbsp;<button type="button" data-toggle="tooltip" name="deleteDocument" onclick="deleteDocument(' . $documento->id . ')" class="delete btn btn-danger btn-sm"><i class="fas fa-trash-alt" style="color: white;"></i> Eliminar</button>';
                    }
                    if (empty($actionButtons)) {
                        $actionButtons = '<div style="padding: 5px;"><span style="background-color: #7FFF00; padding: 2px; border-radius: 3px;">Sin Acción</span></div>';
                    }
                    return $actionButtons;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $programas = Programa::all();
        $gestion = Gestion::all();
        $origenTipos = Origen::all();

        $gestion = Gestion::latest()->first();
        return view('gestion.documento.index', compact('programas', 'gestion', 'origenTipos'));
    }

    public function edit($id)
    {
        if (request()->ajax()) {
            $documento = Documento::select('id', 'cite', 'descripcion', 'estado', 'id_tipo_documento', 'id_programa', 'origen_tipos_id')->find($id);
            if (!$documento) {
                return response()->json(['error' => 'Documento no encontrado'], 404);
            }
            return response()->json($documento);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'origen_tipos_id' => 'required|integer|exists:origen_tipos,id',
            'cite' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string|in:A,I',
            'id_tipo_documento' => 'required|integer',
            'id_programa' => 'required|string|max:5|exists:programas,id_programa',
            'documento' => 'sometimes|file|mimes:pdf|max:512000', // 500 MB máximo
        ]);

        try {
            $gestion = Gestion::latest()->first();
            $lastDocument = Documento::where('id_programa', $request->id_programa)->whereYear('created_at', $gestion->anio)->latest()->first();
            $citeNumber = $lastDocument ? intval(substr($lastDocument->cite, -4)) + 1 : 1;
            $cite = "UATF/DBU/{$gestion->anio}/" . str_pad($citeNumber, 4, '0', STR_PAD_LEFT);

            $fileData = null;
            if ($request->hasFile('documento')) {
                $fileData = file_get_contents($request->file('documento')->getRealPath());
            } else {
                $fileData = '';
            }

            $data = [
                'cite' => $cite,
                'descripcion' => $request->descripcion,
                'estado' => $request->estado,
                'hash' => hash('md5', $cite . $request->descripcion),
                'id_tipo_documento' => $request->id_tipo_documento,
                'documento' => $fileData,
                'id_programa' => $request->id_programa,
                'origen_tipos_id' => $request->origen_tipos_id,
            ];

            Documento::insertData($data);

            return response()->json(['success' => 'Documento creado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al crear el documento', 'message' => $e->getMessage()], 500);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'origen_tipos_id' => 'required|integer|exists:origen_tipos,id',
            'cite' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'estado' => 'required|string|in:A,I',
            'id_tipo_documento' => 'required|integer',
            'id_programa' => 'required|string|max:5|exists:programas,id_programa',
            'documento' => 'sometimes|file|mimes:pdf|max:512000', // 500 MB máximo
        ]);

        try {
            $documento = Documento::find($id);

            if (!$documento) {
                return response()->json(['error' => 'Documento no encontrado'], 404);
            }

            $fileData = $documento->documento; // Preserva el archivo existente
            if ($request->hasFile('documento')) {
                $fileData = file_get_contents($request->file('documento')->getRealPath());
            }

            $documento->cite = $request->cite;
            $documento->descripcion = $request->descripcion;
            $documento->estado = $request->estado;
            $documento->hash = hash('md5', $request->cite . $request->descripcion);
            $documento->id_tipo_documento = $request->id_tipo_documento;
            $documento->documento = $fileData;
            $documento->id_programa = $request->id_programa;
            $documento->origen_tipos_id = $request->origen_tipos_id;

            $documento->save();

            return response()->json(['success' => 'Documento actualizado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al actualizar el documento', 'message' => $e->getMessage()], 500);
        }
    }

    public function destroy($id)
    {
        try {
            Documento::deleteData($id);
            return response()->json(['success' => 'Documento eliminado con éxito'], 200);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al eliminar el documento', 'message' => $e->getMessage()], 500);
        }
    }

    public function show($id)
    {
        try {
            $documento = Documento::viewData($id);

            if ($documento) {
                return response()->json(['documento' => base64_encode($documento)], 200);
            } else {
                return response()->json(['error' => 'Documento no encontrado'], 404);
            }
        } catch (\Exception $e) {
            return response()->json(['error' => 'Error al visualizar el documento', 'message' => $e->getMessage()], 500);
        }
    }

    public function generateCite(Request $request)
    {
        $anioGestion = $request->get('anio_gestion');

        if ($anioGestion) {
            $lastDocument = Documento::whereYear('created_at', $anioGestion)->latest()->first();
            $citeNumber = $lastDocument ? intval(substr($lastDocument->cite, -4)) + 1 : 1;
            $cite = "UATF/DBU/{$anioGestion}/" . str_pad($citeNumber, 4, '0', STR_PAD_LEFT);

            return response()->json(['cite' => $cite]);
        } else {
            return response()->json(['error' => 'Año de gestión no encontrado'], 404);
        }
    }

    public function downloadPdf($id)
    {
        $documento = Documento::find($id);

        if ($documento) {
            $pdfData = is_resource($documento->documento) ? stream_get_contents($documento->documento) : $documento->documento;
            $pdfBase64 = base64_encode($pdfData);
            return response()->json(['base64' => $pdfBase64]);
        } else {
            return response()->json(['message' => 'Documento no encontrado'], 404);
        }
    }
}
