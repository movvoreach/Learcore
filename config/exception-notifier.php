<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Exception Enabled
    |--------------------------------------------------------------------------
    |
    | Enable/Disable exception notifications
    |
    */
    'exception_notify_enabled' => env('EXCEPTION_NOTIFY_ENABLED', true),

    'enable_notify_when_access_not_found' => env('EXCEPTION_NOTIFY_WHEN_ACCESS_NOT_FOUND', false),

    /*
    |--------------------------------------------------------------------------
    | Telegram Error
    |--------------------------------------------------------------------------
    |
    | Telegram Bot configuration
    |
    */
    'telegram-error' => [
        'token'     => env('TELEGRAM_ERROR_BOT_TOKEN'),
        'chat_id'   => env('TELEGRAM_ERROR_CHAT_ID')
    ]

];
