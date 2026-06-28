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
        // Don't log if running in console (unless we want to track artisan commands)
        // We will log it if there's a user, otherwise system action.
        $userId = auth()->check() ? auth()->id() : null;
        $ip = request()->ip();

        ActivityLog::create([
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'user_id' => $userId,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => $ip,
        ]);
    }
}
