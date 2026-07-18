<?php

namespace App\Models\Concerns;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait LogsActivity
{
    protected static function bootLogsActivity()
    {
        static::created(function (Model $model) {
            static::logAction($model, 'created', null, $model->getAttributes());
        });

        static::updated(function (Model $model) {
            static::logAction($model, 'updated', $model->getOriginal(), $model->getChanges());
        });

        static::deleted(function (Model $model) {
            static::logAction($model, 'deleted', $model->getAttributes(), null);
        });
    }

    protected static function logAction(Model $model, string $action, ?array $oldValues, ?array $newValues)
    {
        if (app()->runningInConsole()) {
            return;
        }

        $user = auth()->user();
        if (! $user || ! $user->hasAnyRole(['super_admin', 'admin'])) {
            return;
        }

        ActivityLog::create([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'user_id' => $user->id,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
        ]);
    }
}
