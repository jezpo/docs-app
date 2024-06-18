<?php

namespace App\Observers;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

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
}