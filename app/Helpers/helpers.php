<?php

use Illuminate\Support\Facades\Log;

if (! function_exists('actionExecution')) {
    /**
     * Safely execute a callable and catch any Throwable exceptions.
     * Logs errors to the Laravel log for production visibility.
     *
     * @param  callable       $callback  The action to run.
     * @param  mixed          $default   Value returned on failure.
     * @param  callable|null  $onError   Optional custom error handler.
     * @return mixed
     */
    function actionExecution(callable $callback, mixed $default = null, ?callable $onError = null): mixed
    {
        try {
            return $callback();
        } catch (Throwable $exception) {
            Log::error('[actionExecution] Caught exception: ' . $exception->getMessage(), [
                'file'  => $exception->getFile(),
                'line'  => $exception->getLine(),
                'trace' => $exception->getTraceAsString(),
            ]);

            if ($onError !== null) {
                return $onError($exception);
            }

            return $default;
        }
    }
}
