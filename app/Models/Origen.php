<?php
// App\Models\Origen.php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Origen extends Model
{
    protected $table = 'origen_tipos';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['tipo'];

    const ENVIADO = 1;
    const RECIBIDO = 2;
    public function documentos()
    {
        return $this->hasMany(Documento::class, 'origen_tipos_id');
    }
}