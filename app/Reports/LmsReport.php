<?php

namespace App\Reports;

use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamSubmission;
use App\Models\Student;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use InvalidArgumentException;

class LmsReport
{
    /**
     * @return array<string, array<string, mixed>>
     */
    public static function definitions(): array
    {
        return [
            'students' => [
                'title' => 'របាយការណ៍និស្សិត',
                'description' => 'បញ្ជីនិស្សិត ស្ថានភាព និងសកម្មភាពសិក្សាសំខាន់ៗ',
                'filename' => 'student-report',
                'columns' => ['កូដ', 'ឈ្មោះ', 'ភេទ', 'ទូរស័ព្ទ', 'អ៊ីមែល', 'ស្ថានភាព', 'ចុះឈ្មោះ', 'វត្តមាន', 'វិញ្ញាបនបត្រ', 'បង្កើតនៅ'],
                'rows' => fn (): array => self::studentRows(),
            ],
            'attendance' => [
                'title' => 'របាយការណ៍វត្តមាន',
                'description' => 'កំណត់ត្រាវត្តមានតាមថ្ងៃ សិស្ស និងថ្នាក់រៀន',
                'filename' => 'attendance-report',
                'columns' => ['កាលបរិច្ឆេទ', 'និស្សិត', 'ថ្នាក់', 'ស្ថានភាព', 'ចំណាំ', 'បង្កើតនៅ'],
                'rows' => fn (): array => self::attendanceRows(),
            ],
            'exams' => [
                'title' => 'របាយការណ៍ប្រឡង',
                'description' => 'ព័ត៌មានប្រឡង បេក្ខជន ការដាក់ស្នើ និងពិន្ទុ',
                'filename' => 'exam-report',
                'columns' => ['ចំណងជើង', 'មុខវិជ្ជា', 'វគ្គ', 'ថ្ងៃប្រឡង', 'ពេលចាប់ផ្តើម', 'ពេលបញ្ចប់', 'ពិន្ទុសរុប', 'ពិន្ទុជាប់', 'បេក្ខជន', 'ដាក់ស្នើ', 'ស្ថានភាព'],
                'rows' => fn (): array => self::examRows(),
            ],
            'finance' => [
                'title' => 'របាយការណ៍ហិរញ្ញវត្ថុ',
                'description' => 'សេចក្តីសង្ខេបហិរញ្ញវត្ថុពីទិន្នន័យដែលមានក្នុងប្រព័ន្ធ',
                'filename' => 'finance-report',
                'columns' => ['ប្រភេទ', 'ចំនួន', 'ចំណាំ'],
                'rows' => fn (): array => self::financeRows(),
            ],
            'activity' => [
                'title' => 'កំណត់ត្រាសកម្មភាព',
                'description' => 'សកម្មភាពថ្មីៗពីទិន្នន័យសំខាន់ៗក្នុងប្រព័ន្ធ',
                'filename' => 'activity-log',
                'columns' => ['ថ្ងៃម៉ោង', 'ផ្នែក', 'សកម្មភាព', 'ព័ត៌មានលម្អិត'],
                'rows' => fn (): array => self::activityRows(),
            ],
        ];
    }

    /**
     * @return array{key: string, title: string, description: string, filename: string, columns: array<int, string>, rows: array<int, array<int, string>>, generatedAt: string, total: int}
     */
    public static function make(string $key): array
    {
        $definition = self::definitions()[$key] ?? null;

        if (! $definition) {
            throw new InvalidArgumentException("Unknown report [{$key}].");
        }

        $rows = $definition['rows']();

        return [
            'key' => $key,
            'title' => $definition['title'],
            'description' => $definition['description'],
            'filename' => $definition['filename'],
            'columns' => $definition['columns'],
            'rows' => $rows,
            'generatedAt' => now()->format('Y-m-d H:i:s'),
            'total' => count($rows),
        ];
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function studentRows(): array
    {
        return Student::query()
            ->withCount(['enrollments', 'attendances', 'certificates'])
            ->latest('created_at')
            ->limit(1000)
            ->get()
            ->map(fn (Student $student): array => [
                (string) $student->student_code,
                trim("{$student->first_name} {$student->last_name}"),
                (string) $student->gender,
                (string) $student->phone,
                (string) $student->email,
                self::studentStatus($student->status),
                (string) $student->enrollments_count,
                (string) $student->attendances_count,
                (string) $student->certificates_count,
                self::dateTime($student->created_at),
            ])
            ->all();
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function attendanceRows(): array
    {
        return Attendance::query()
            ->with(['student', 'classRoom'])
            ->latest('attendance_date')
            ->latest('created_at')
            ->limit(1000)
            ->get()
            ->map(fn (Attendance $attendance): array => [
                self::date($attendance->attendance_date),
                self::studentName($attendance->student),
                (string) data_get($attendance, 'classRoom.class_name', data_get($attendance, 'classRoom.class_code', '')),
                self::attendanceStatus($attendance->status),
                (string) $attendance->note,
                self::dateTime($attendance->created_at),
            ])
            ->all();
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function examRows(): array
    {
        return Exam::query()
            ->with(['course', 'subject'])
            ->withCount(['candidates', 'submissions'])
            ->latest('exam_date')
            ->latest('created_at')
            ->limit(1000)
            ->get()
            ->map(fn (Exam $exam): array => [
                (string) $exam->title,
                (string) data_get($exam, 'subject.subject_name', ''),
                (string) data_get($exam, 'course.course_name', ''),
                self::date($exam->exam_date),
                (string) $exam->start_time,
                (string) $exam->end_time,
                (string) $exam->total_score,
                (string) $exam->passing_score,
                (string) $exam->candidates_count,
                (string) $exam->submissions_count,
                (string) $exam->status,
            ])
            ->all();
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function financeRows(): array
    {
        return [
            ['និស្សិតសរុប', (string) Student::query()->count(), 'ប្រើសម្រាប់គណនាផែនការថ្លៃសិក្សា'],
            ['និស្សិតកំពុងសិក្សា', (string) Student::query()->where('status', 'active')->count(), 'ស្ថានភាព active'],
            ['ការចុះឈ្មោះសរុប', (string) Enrollment::query()->count(), 'ទិន្នន័យចុះឈ្មោះតាមវគ្គ/ថ្នាក់'],
            ['ការចុះឈ្មោះកំពុងដំណើរការ', (string) Enrollment::query()->where('status', 'active')->count(), 'ស្ថានភាព active'],
            ['វិញ្ញាបនបត្រចេញរួច', (string) Certificate::query()->count(), 'ប្រើសម្រាប់តាមដានការបញ្ចប់វគ្គ'],
        ];
    }

    /**
     * @return array<int, array<int, string>>
     */
    private static function activityRows(): array
    {
        return collect()
            ->merge(self::recentModelRows(Student::class, 'និស្សិត', 'បានកែប្រែ/បង្កើតនិស្សិត', fn (Student $student): string => trim("{$student->student_code} {$student->first_name} {$student->last_name}")))
            ->merge(self::recentModelRows(Attendance::class, 'វត្តមាន', 'បានកែប្រែកំណត់ត្រាវត្តមាន', fn (Attendance $attendance): string => self::date($attendance->attendance_date).' - '.$attendance->status))
            ->merge(self::recentModelRows(Exam::class, 'ប្រឡង', 'បានកែប្រែ/បង្កើតប្រឡង', fn (Exam $exam): string => (string) $exam->title))
            ->merge(self::recentModelRows(ExamSubmission::class, 'ការដាក់ស្នើប្រឡង', 'បានកែប្រែការដាក់ស្នើ', fn (ExamSubmission $submission): string => "Exam #{$submission->exam_id}, Student #{$submission->student_id}"))
            ->merge(self::recentModelRows(Certificate::class, 'វិញ្ញាបនបត្រ', 'បានកែប្រែវិញ្ញាបនបត្រ', fn (Certificate $certificate): string => "Certificate #{$certificate->certificate_id}"))
            ->sortByDesc('sort')
            ->take(1000)
            ->map(fn (array $row): array => [$row['time'], $row['section'], $row['action'], $row['detail']])
            ->values()
            ->all();
    }

    /**
     * @template TModel of Model
     *
     * @param  class-string<TModel>  $modelClass
     * @param  callable(TModel): string  $detail
     * @return Collection<int, array{sort: string, time: string, section: string, action: string, detail: string}>
     */
    private static function recentModelRows(string $modelClass, string $section, string $action, callable $detail): Collection
    {
        return $modelClass::query()
            ->latest('updated_at')
            ->limit(100)
            ->get()
            ->map(fn (Model $model): array => [
                'sort' => self::dateTime($model->updated_at),
                'time' => self::dateTime($model->updated_at),
                'section' => $section,
                'action' => $action,
                'detail' => $detail($model),
            ]);
    }

    private static function studentName(?Student $student): string
    {
        if (! $student) {
            return '';
        }

        return trim("{$student->student_code} {$student->first_name} {$student->last_name}");
    }

    private static function studentStatus(?string $status): string
    {
        return match ($status) {
            'active' => 'កំពុងសិក្សា',
            'inactive' => 'ផ្អាក',
            'graduated' => 'បញ្ចប់ការសិក្សា',
            default => (string) $status,
        };
    }

    private static function attendanceStatus(?string $status): string
    {
        return match ($status) {
            'present' => 'មានវត្តមាន',
            'absent' => 'អវត្តមាន',
            'late' => 'យឺត',
            'excused' => 'មានច្បាប់',
            default => (string) $status,
        };
    }

    private static function date(mixed $value): string
    {
        return $value instanceof CarbonInterface ? $value->format('Y-m-d') : (string) $value;
    }

    private static function dateTime(mixed $value): string
    {
        return $value instanceof CarbonInterface ? $value->format('Y-m-d H:i:s') : (string) $value;
    }
}
