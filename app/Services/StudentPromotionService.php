<?php

namespace App\Services;

use App\Models\AcademicYear;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentPromotion;
use Illuminate\Support\Facades\DB;
use RuntimeException;

class StudentPromotionService
{
    public function promoteToNext(Student $student, ?string $note = null): StudentPromotion
    {
        [$toYearId, $toSemesterId] = $this->nextPlacement($student);

        return $this->promote($student, $toYearId, $toSemesterId, $note);
    }

    public function promote(Student $student, int $toYearId, int $toSemesterId, ?string $note = null): StudentPromotion
    {
        return DB::transaction(function () use ($student, $toYearId, $toSemesterId, $note): StudentPromotion {
            $promotion = StudentPromotion::create([
                'student_id' => $student->student_id,
                'from_department_id' => $student->department_id,
                'from_year_id' => $student->academic_year_id,
                'from_semester_id' => $student->semester_id,
                'to_year_id' => $toYearId,
                'to_semester_id' => $toSemesterId,
                'promoted_at' => now(),
                'note' => $note,
            ]);

            $student->update([
                'academic_year_id' => $toYearId,
                'semester_id' => $toSemesterId,
            ]);

            return $promotion;
        });
    }

    /**
     * @return array{0: int, 1: int}
     */
    public function nextPlacement(Student $student): array
    {
        if (! $student->academic_year_id || ! $student->semester_id) {
            throw new RuntimeException('The student must have a current academic year and semester.');
        }

        $nextSemester = Semester::query()
            ->where('academic_year_id', $student->academic_year_id)
            ->where('semester_id', '!=', $student->semester_id)
            ->where(function ($query) use ($student): void {
                $currentSemester = Semester::query()->find($student->semester_id);

                if ($currentSemester?->start_date) {
                    $query->whereNull('start_date')->orWhere('start_date', '>', $currentSemester->start_date);
                }
            })
            ->orderBy('start_date')
            ->orderBy('semester_id')
            ->first();

        if ($nextSemester) {
            return [$student->academic_year_id, $nextSemester->semester_id];
        }

        $currentYear = AcademicYear::query()->find($student->academic_year_id);

        $nextYear = AcademicYear::query()
            ->where('academic_year_id', '!=', $student->academic_year_id)
            ->when($currentYear?->start_date, fn ($query) => $query->where('start_date', '>', $currentYear->start_date))
            ->orderBy('start_date')
            ->orderBy('academic_year_id')
            ->first();

        $firstSemester = $nextYear
            ? Semester::query()
                ->where('academic_year_id', $nextYear->academic_year_id)
                ->orderBy('start_date')
                ->orderBy('semester_id')
                ->first()
            : null;

        if (! $nextYear || ! $firstSemester) {
            $student->update(['status' => 'graduated']);

            throw new RuntimeException('No next academic year and semester were found. The student was marked as graduated.');
        }

        return [$nextYear->academic_year_id, $firstSemester->semester_id];
    }
}
