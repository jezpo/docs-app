<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'model_type',
        'model_id',
        'action',
        'details',
        'user_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function Documento()
    {
        return $this->belongsTo(Documento::class);
    }
}