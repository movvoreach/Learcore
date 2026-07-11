<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AssignmentSubmission extends Model
{
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
}
