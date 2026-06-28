<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssessmentQuestion extends Model
{
    protected $primaryKey = 'assessment_question_id';

    protected $fillable = [
        'question_bank_id',
        'content_lesson_id',
        'question_text',
        'question_type',
        'points',
        'correct_answer',
        'explanation',
        'is_active',
    ];

    protected $casts = [
        'points' => 'decimal:2',
        'is_active' => 'boolean',
    ];

    public function bank(): BelongsTo
    {
        return $this->belongsTo(QuestionBank::class, 'question_bank_id', 'question_bank_id');
    }

    public function lesson(): BelongsTo
    {
        return $this->belongsTo(ContentLesson::class, 'content_lesson_id', 'content_lesson_id');
    }

    public function options(): HasMany
    {
        return $this->hasMany(QuestionOption::class, 'assessment_question_id', 'assessment_question_id');
    }
}
