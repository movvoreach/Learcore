<?php

if (! function_exists('actionExuction')) {
    function actionExuction(callable $callback, mixed $default = null, ?callable $onError = null): mixed
    {
        try {
            return $callback();
        } catch (Throwable $exception) {
            if ($onError !== null) {
                return $onError($exception);
            }

            return $default;
        }
    }
}
