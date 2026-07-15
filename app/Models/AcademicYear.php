<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AcademicYear extends Model
{
    use LogsActivity;

    protected $primaryKey = 'academic_year_id';

    protected $fillable = [
        'year_name',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'is_active' => 'boolean',
        ];
    }

    public function classRooms(): HasMany
    {
        return $this->hasMany(ClassRoom::class, 'academic_year_id', 'academic_year_id');
    }

    public function enrollments(): HasMany
    {
        return $this->hasMany(Enrollment::class, 'academic_year_id', 'academic_year_id');
    }

    public function semesters(): HasMany
    {
        return $this->hasMany(Semester::class, 'academic_year_id', 'academic_year_id');
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class, 'academic_year_id', 'academic_year_id');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class, 'academic_year_id', 'academic_year_id');
    }
}
