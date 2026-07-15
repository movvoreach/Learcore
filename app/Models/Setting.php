<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use App\Services\SettingService;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use LogsActivity;

    protected $fillable = [
        'group',
        'key',
        'value',
        'type',
    ];

    protected static function booted(): void
    {
        static::saved(fn (): mixed => SettingService::forgetCache());
        static::deleted(fn (): mixed => SettingService::forgetCache());
    }
}
