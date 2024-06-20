<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Documento extends Model
{
    protected $table = 'documentos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = [
        'cite',
        'descripcion',
        'estado',
        'hash',
        'id_programa',
        'origen_tipos_id',
        'id_tipo_documento',
        'created_at'
    ];

    // Relación con el modelo OrigenTipo
    public function origenTipo()
    {
        return $this->belongsTo(Origen::class, 'origen_tipos_id');
    }

    // Relación con el modelo Programa (suponiendo que hay un modelo Programa)
    public function programa()
    {
        return $this->belongsTo(Programa::class, 'id_programa');
    }

    public static function list_documents()
    {
        return DB::table('documentos')
            ->join('programas', 'documentos.id_programa', '=', 'programas.id_programa')
            ->join('origen_tipos', 'documentos.origen_tipos_id', '=', 'origen_tipos.id')
            ->select('documentos.id', 'documentos.cite', 'documentos.descripcion', 'documentos.estado', 'documentos.id_tipo_documento', 'documentos.id_programa', 'programas.programa', 'documentos.origen_tipos_id', 'origen_tipos.tipo')
            ->get();
    }

    public static function list_documents_enviados($startDate, $endDate)
    {
        return DB::table('documentos')
            ->join('programas', 'documentos.id_programa', '=', 'programas.id_programa')
            ->join('origen_tipos', 'documentos.origen_tipos_id', '=', 'origen_tipos.id')
            ->where('origen_tipos.tipo', 'Enviado')
            ->whereBetween('documentos.created_at', [$startDate, $endDate])
            ->select('documentos.id', 'documentos.cite', 'documentos.descripcion', 'documentos.estado', 'documentos.id_tipo_documento', 'documentos.id_programa', 'programas.programa', 'documentos.origen_tipos_id', 'origen_tipos.tipo')
            ->get();
    }

    public static function list_documents_recibidos($startDate, $endDate)
    {
        return DB::table('documentos')
            ->join('programas', 'documentos.id_programa', '=', 'programas.id_programa')
            ->join('origen_tipos', 'documentos.origen_tipos_id', '=', 'origen_tipos.id')
            ->where('origen_tipos.tipo', 'Recibido')
            ->whereBetween('documentos.created_at', [$startDate, $endDate])
            ->select('documentos.id', 'documentos.cite', 'documentos.descripcion', 'documentos.estado', 'documentos.id_tipo_documento', 'documentos.id_programa', 'programas.programa', 'documentos.origen_tipos_id', 'origen_tipos.tipo')
            ->get();
    }

    // Método para insertar un documento
    public static function insertData($data)
    {
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("INSERT INTO documentos (cite, descripcion, estado, hash, documento, id_programa, origen_tipos_id, id_tipo_documento, created_at, updated_at) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())");
        $stmt->bindParam(1, $data['cite']);
        $stmt->bindParam(2, $data['descripcion']);
        $stmt->bindParam(3, $data['estado']);
        $stmt->bindParam(4, $data['hash']);
        $stmt->bindParam(5, $data['documento'], \PDO::PARAM_LOB);
        $stmt->bindParam(6, $data['id_programa']);
        $stmt->bindParam(7, $data['origen_tipos_id']); // Actualizado
        $stmt->bindParam(8, $data['id_tipo_documento']); // Actualizado
        $stmt->execute();
    }

    // Método para actualizar un documento
    public static function updateData($id, $data)
    {
        $pdo = DB::getPdo();
        if (isset($data['documento'])) {
            $stmt = $pdo->prepare("UPDATE documentos SET cite = ?, descripcion = ?, estado = ?, hash = ?, documento = ?, id_programa = ?, origen_tipos_id = ?, id_tipo_documento = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bindParam(1, $data['cite']);
            $stmt->bindParam(2, $data['descripcion']);
            $stmt->bindParam(3, $data['estado']);
            $stmt->bindParam(4, $data['hash']);
            $stmt->bindParam(5, $data['documento'], \PDO::PARAM_LOB);
            $stmt->bindParam(6, $data['id_programa']);
            $stmt->bindParam(7, $data['origen_tipos_id']); // Actualizado
            $stmt->bindParam(8, $data['id_tipo_documento']); // Actualizado
            $stmt->bindParam(9, $id);
        } else {
            $stmt = $pdo->prepare("UPDATE documentos SET cite = ?, descripcion = ?, estado = ?, hash = ?, id_programa = ?, origen_tipos_id = ?, id_tipo_documento = ?, updated_at = NOW() WHERE id = ?");
            $stmt->bindParam(1, $data['cite']);
            $stmt->bindParam(2, $data['descripcion']);
            $stmt->bindParam(3, $data['estado']);
            $stmt->bindParam(4, $data['hash']);
            $stmt->bindParam(5, $data['id_programa']);
            $stmt->bindParam(6, $data['origen_tipos_id']); // Actualizado
            $stmt->bindParam(7, $data['id_tipo_documento']); // Actualizado
            $stmt->bindParam(8, $id);
        }
        $stmt->execute();
    }

    // Método para ver los datos de un documento
    public static function viewData($id)
    {
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("SELECT documento FROM documentos WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
        $result = $stmt->fetchColumn();
        if (is_resource($result)) {
            $result = stream_get_contents($result);
        }
        return $result;
    }

    // Método para eliminar un documento
    public static function deleteData($id)
    {
        $pdo = DB::getPdo();
        $stmt = $pdo->prepare("DELETE FROM documentos WHERE id = ?");
        $stmt->bindParam(1, $id);
        $stmt->execute();
    }
}
