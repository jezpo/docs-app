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
    public function Programa(){
        return $this->belongsTo(Programa::class);
    }
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id')
                    ->where('model_type', 'App\Models\User');
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class, 'model_has_permissions', 'model_id', 'permission_id')
                    ->where('model_type', 'App\Models\User');
    }
    
}