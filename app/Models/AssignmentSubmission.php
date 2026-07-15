<?php

namespace App\Models;

use App\Models\Concerns\LogsActivity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
    use LogsActivity;

    protected $primaryKey = 'assignment_submission_id';

    protected $fillable = [
        'content_assignment_id',
        'student_id',
        'response',
        'attachment_url',
        'submitted_at',
        'status',
        'score',
        'feedback',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'score' => 'decimal:2',
    ];

    public function attachmentPublicUrl(): ?string
    {
        $url = trim((string) $this->attachment_url);

        if ($url === '') {
            return null;
        }

        if (str_starts_with($url, 'http://') || str_starts_with($url, 'https://')) {
            $path = parse_url($url, PHP_URL_PATH);

            if (is_string($path) && str_starts_with($path, '/storage/')) {
                return $path;
            }

            return $url;
        }

        $path = ltrim($url, '/');

        if (str_starts_with($path, 'storage/')) {
            return '/'.$path;
        }

        return '/storage/'.$path;
    }

    public function assignment(): BelongsTo
    {
        return $this->belongsTo(ContentAssignment::class, 'content_assignment_id', 'content_assignment_id');
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id', 'student_id');
    }

    public function publishGradeToStudent(?int $gradedBy = null): void
    {
        if ($this->score === null) {
            return;
        }

        $assignment = $this->assignment;
        $maxScore = (float) ($assignment?->max_score ?: 100);
        $score = (float) $this->score;
        $percentage = $maxScore > 0 ? ($score / $maxScore) * 100 : 0;

        AssessmentGrade::query()->updateOrCreate(
            [
                'student_id' => $this->student_id,
                'content_assignment_id' => $this->content_assignment_id,
            ],
            [
                'exam_id' => null,
                'quiz_id' => null,
                'graded_by' => $gradedBy,
                'score' => $score,
                'max_score' => $maxScore,
                'grade' => self::letterGrade($percentage),
                'graded_at' => now(),
                'remarks' => $this->feedback,
            ],
        );
    }

    private static function letterGrade(float $percentage): string
    {
        return match (true) {
            $percentage >= 90 => 'A',
            $percentage >= 80 => 'B',
            $percentage >= 70 => 'C',
            $percentage >= 60 => 'D',
            $percentage >= 50 => 'E',
            default => 'F',
        };
    }
}
