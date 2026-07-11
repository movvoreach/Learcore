<?php

namespace Database\Seeders;

use App\Models\AssessmentQuestion;
use App\Models\ContentLesson;
use App\Models\Course;
use App\Models\QuestionOption;
use App\Models\Quiz;
use Illuminate\Database\Seeder;
use RuntimeException;

class HistoryWesternArtQuizSeeder extends Seeder
{
    public function run(): void
    {
        $course = Course::query()
            ->where('course_code', 'ART-101')
            ->orWhere('course_name', 'History of Western Art')
            ->first();

        if (! $course) {
            throw new RuntimeException('Course "History of Western Art" was not found. Run CourseSeeder first.');
        }

        $lesson = $course->contentLessons()
            ->where('is_published', true)
            ->orderBy('module_number')
            ->orderBy('position')
            ->first();

        if (! $lesson) {
            $lesson = ContentLesson::query()->updateOrCreate(
                ['slug' => 'introduction-to-western-art-'.$course->course_id],
                [
                    'course_id' => $course->course_id,
                    'module_number' => 1,
                    'module_title' => 'Introduction',
                    'title' => 'Introduction to Western Art',
                    'content_type' => 'lesson',
                    'summary' => 'A short introduction to major periods, artists, and concepts in Western art history.',
                    'body' => '<p>This lesson introduces major periods in Western art from classical antiquity to modernism.</p>',
                    'position' => 1,
                    'visibility' => 'visible',
                    'completion_required' => true,
                    'allow_comments' => true,
                    'is_published' => true,
                ],
            );
        }

        Quiz::query()->updateOrCreate(
            [
                'content_lesson_id' => $lesson->content_lesson_id,
                'title' => 'History of Western Art Quiz',
            ],
            [
                'instructions' => '<p>Answer the questions about major periods and artworks in Western art history.</p>',
                'available_from' => now()->subDay(),
                'available_until' => now()->addMonth(),
                'time_limit_minutes' => 20,
                'max_attempts' => 2,
                'passing_score' => 60,
                'is_published' => true,
            ],
        );

        $questions = [
            [
                'text' => 'Which ancient civilization is strongly associated with classical ideals of balance, proportion, and idealized human figures?',
                'correct' => 'Ancient Greece',
                'options' => ['Ancient Greece', 'Medieval England', 'Baroque Spain', 'Modern France'],
                'explanation' => 'Ancient Greek art emphasized harmony, proportion, and idealized anatomy.',
            ],
            [
                'text' => 'The Renaissance is best known for the revival of which cultural tradition?',
                'correct' => 'Classical Greek and Roman ideas',
                'options' => ['Classical Greek and Roman ideas', 'Industrial design', 'Gothic abstraction', 'Digital media'],
                'explanation' => 'Renaissance artists revived classical learning, humanism, perspective, and naturalism.',
            ],
            [
                'text' => 'Which artist painted the Mona Lisa?',
                'correct' => 'Leonardo da Vinci',
                'options' => ['Leonardo da Vinci', 'Vincent van Gogh', 'Pablo Picasso', 'Claude Monet'],
                'explanation' => 'The Mona Lisa is one of Leonardo da Vinci’s most famous Renaissance paintings.',
            ],
            [
                'text' => 'Impressionist painters often focused on what visual quality?',
                'correct' => 'Changing effects of light and color',
                'options' => ['Changing effects of light and color', 'Strict religious symbolism', 'Flat medieval gold backgrounds', 'Mechanical perspective diagrams'],
                'explanation' => 'Impressionism explored fleeting light, color, atmosphere, and everyday scenes.',
            ],
            [
                'text' => 'Cubism is most closely associated with which feature?',
                'correct' => 'Fragmented forms and multiple viewpoints',
                'options' => ['Fragmented forms and multiple viewpoints', 'Perfectly smooth marble bodies', 'Single-point religious icons', 'Soft atmospheric brushwork only'],
                'explanation' => 'Cubism broke objects into geometric planes and showed multiple viewpoints at once.',
            ],
        ];

        foreach ($questions as $index => $questionData) {
            $question = AssessmentQuestion::query()->updateOrCreate(
                [
                    'content_lesson_id' => $lesson->content_lesson_id,
                    'question_text' => $questionData['text'],
                ],
                [
                    'question_bank_id' => null,
                    'question_type' => 'multiple_choice',
                    'points' => 1,
                    'correct_answer' => $questionData['correct'],
                    'explanation' => $questionData['explanation'],
                    'is_active' => true,
                ],
            );

            foreach ($questionData['options'] as $optionIndex => $optionText) {
                QuestionOption::query()->updateOrCreate(
                    [
                        'assessment_question_id' => $question->assessment_question_id,
                        'option_text' => $optionText,
                    ],
                    [
                        'is_correct' => $optionText === $questionData['correct'],
                        'sort_order' => $optionIndex + 1,
                    ],
                );
            }
        }

        $this->command?->info('Seeded History of Western Art quiz for lesson: '.$lesson->title);
    }
}
