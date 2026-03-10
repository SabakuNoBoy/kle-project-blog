<?php

namespace App\Traits;

use App\Models\ActivityLog;
use Illuminate\Support\Facades\Auth;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function ($model) {
            static::logActivity($model, 'Eklendi', $model->getAttributes());
        });

        static::updated(function ($model) {
            $changes = [
                'old' => array_intersect_key($model->getOriginal(), $model->getDirty()),
                'new' => $model->getDirty(),
            ];
            static::logActivity($model, 'Güncellendi', $changes);
        });

        static::deleted(function ($model) {
            static::logActivity($model, 'Silindi', $model->getAttributes());
        });
    }

    protected static function logActivity($model, $action, $properties = null)
    {
        ActivityLog::create([
            'user_id' => Auth::id(),
            'subject_id' => $model->id,
            'subject_type' => get_class($model),
            'action' => $action,
            'description' => class_basename($model) . " {$action}.",
            'properties' => $properties,
        ]);
    }
}
