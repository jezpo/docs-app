<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gestion extends Model
{
    use HasFactory;

    protected $table = 'gestion';
    protected $primaryKey = 'id';
    public $timestamps = true;
    protected $fillable = ['anio', 'descripcion'];
}

