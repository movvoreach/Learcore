<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseModule extends Model
{
    use LogsActivity;

    protected $primaryKey = 'course_module_id';

    protected $fillable = [
        'course_id',
        'module_number',
        'title',
        'description',
    ];

    protected $casts = [
        'module_number' => 'integer',
    ];

    protected static function booted(): void
    {
        static::creating(function (CourseModule $module): void {
            if (! $module->module_number && $module->course_id) {
                $module->module_number = ((int) static::query()
                    ->where('course_id', $module->course_id)
                    ->max('module_number')) + 1;
            }
        });
    }

    public function course(): BelongsTo
    {
        return $this->belongsTo(Course::class, 'course_id', 'course_id');
    }

    public function lessons(): HasMany
    {
        return $this->hasMany(ContentLesson::class, 'course_module_id', 'course_module_id')
            ->orderBy('position')
            ->orderBy('content_lesson_id');
    }
}
