<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CourseCategory extends Model
{
    use LogsActivity;

    protected $primaryKey = 'course_category_id';

    protected $fillable = [
        'category_code',
        'category_name',
        'description',
    ];

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'course_category_id', 'course_category_id');
    }
}
