<?php

namespace App\Models;

use App\Models\Concerns\GeneratesCodes;
use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Faculty extends Model
{
    use GeneratesCodes, LogsActivity;

    protected $primaryKey = 'faculty_id';

    protected $fillable = [
        'faculty_code',
        'faculty_name',
    ];

    protected static function booted(): void
    {
        static::creating(function (Faculty $faculty): void {
            if (blank($faculty->faculty_code)) {
                $faculty->faculty_code = static::nextCode('faculty_code', 'FAC');
            }
        });
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class, 'faculty_id', 'faculty_id');
    }
}
