<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Translation extends Model
{
    use HasFactory, LogsActivity;

    protected $fillable = [
        'language_id',
        'group',
        'key',
        'value',
    ];

    public function language(): BelongsTo
    {
        return $this->belongsTo(Language::class);
    }

    public function getFullKeyAttribute(): string
    {
        return $this->group === '*' ? $this->key : $this->group.'.'.$this->key;
    }
}
