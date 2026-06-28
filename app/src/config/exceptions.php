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
    'enable_notify_when_access_not_found' => env('EXCEPTION_NOTIFY_NOT_FOUND', false),


    /*
    |--------------------------------------------------------------------------
    | Telegram Error
    |--------------------------------------------------------------------------
    |
    | Enable/Disable exception notifications
    |
    */
    'telegram-error' => [
        'token'     => env('TELEGRAM_ERROR_BOT_TOKEN'),
        'chat_id'   => env('TELEGRAM_ERROR_CHAT_ID'),
    ],

];
