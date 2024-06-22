<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class ActivityLogObserver
{
    public function created($model)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'created',
            'details' => json_encode($model->toArray()),
            'user_id' => Auth::id(),
        ]);
    }

    public function updated($model)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'updated',
            'details' => json_encode($model->getChanges()),
            'user_id' => Auth::id(),
        ]);
    }

    public function deleted($model)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'deleted',
            'details' => json_encode($model->toArray()),
            'user_id' => Auth::id(),
        ]);
    }
    public function permissionAssigned($model, $permission)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'permission_assigned',
            'details' => json_encode(['permission' => $permission->name]),
            'user_id' => Auth::id(),
        ]);
    }

    public function permissionRevoked($model, $permission)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'permission_revoked',
            'details' => json_encode(['permission' => $permission->name]),
            'user_id' => Auth::id(),
        ]);
    }

    public function roleAssigned($model, $role)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'role_assigned',
            'details' => json_encode(['role' => $role->name]),
            'user_id' => Auth::id(),
        ]);
    }

    public function roleRevoked($model, $role)
    {
        ActivityLog::create([
            'model_type' => get_class($model),
            'model_id' => $model->id,
            'action' => 'role_revoked',
            'details' => json_encode(['role' => $role->name]),
            'user_id' => Auth::id(),
        ]);
    }
}