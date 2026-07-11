<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\ContentLesson;
use App\Models\ContentChapter;
use App\Models\Quiz;
use App\Models\ContentAssignment;
use App\Models\ContentVideo;
use App\Models\ContentDocument;
use App\Models\AssessmentQuestion;
use App\Models\QuestionOption;
use App\Models\QuestionBank;
use App\Models\Subject;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ContentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Fetch all courses
        $courses = Course::all();

        if ($courses->isEmpty()) {
            $this->call(CourseSeeder::class);
            $courses = Course::all();
        }

        foreach ($courses as $course) {
            $isWesternArt = ($course->course_code === 'ART-101' || $course->course_name === 'History of Western Art');

            // We seed 10 modules for all courses
            $modulesToSeed = [1, 2, 3, 4, 5, 6, 7, 8, 9, 10];
            if ($isWesternArt) {
                // If it is History of Western Art, we also seed Module 796
                $modulesToSeed[] = 796;
            }

            foreach ($modulesToSeed as $moduleNum) {
                // Define module title and lesson title
                if ($isWesternArt) {
                    if ($moduleNum === 1) {
                        $moduleTitle = 'Introduction & Core Principles';
                        $lessonTitle = 'Fundamental Concepts of History of Western Art';
                    } elseif ($moduleNum === 2) {
                        $moduleTitle = 'Advanced Operations';
                        $lessonTitle = 'Advanced Methodologies in History of Western Art';
                    } elseif ($moduleNum === 796) {
                        $moduleTitle = 'Video Test 1';
                        $lessonTitle = 'HHHH';
                    } else {
                        $moduleTitles = [
                            3 => 'Modern Art Movements',
                            4 => 'High Renaissance Masters',
                            5 => 'Baroque and Rococo Styles',
                            6 => 'Neoclassicism to Romanticism',
                            7 => 'Realism and Impressionism',
                            8 => 'Post-Impressionism and Expressionism',
                            9 => 'Cubism and Abstract Art',
                            10 => 'Contemporary Art Trends',
                        ];
                        $lessonTitles = [
                            3 => 'Art of Egypt, Greece, and Rome',
                            4 => 'Masters of Florence and Rome',
                            5 => 'The Drama of Light and Shadow',
                            6 => 'Reason vs. Emotion in Art',
                            7 => 'Capturing the Fleeting Moment',
                            8 => 'Deconstruction of Form and Color',
                            9 => 'Art in the Digital and Conceptual Age',
                            10 => 'Synthesis and Assessment in Western Art',
                        ];
                        $moduleTitle = $moduleTitles[$moduleNum] ?? 'Art Concepts';
                        $lessonTitle = $lessonTitles[$moduleNum] ?? 'Western Art Lesson';
                    }
                } else {
                    $moduleTitles = [
                        1 => 'Introduction & Core Principles',
                        2 => 'Advanced Operations',
                        3 => 'Theoretical Frameworks',
                        4 => 'Real-world Case Studies',
                        5 => 'Practical Applications & Worksheets',
                        6 => 'Advanced Research Methodologies',
                        7 => 'Modern Design and Architectures',
                        8 => 'Quality Assurance & Standards',
                        9 => 'Review & Performance Benchmarks',
                        10 => 'Final Assessment & Future Directions',
                    ];
                    $lessonTitles = [
                        1 => "Fundamental Concepts of {$course->course_name}",
                        2 => "Advanced Methodologies in {$course->course_name}",
                        3 => "Core Principles of {$course->course_name}",
                        4 => "Detailed Case Analysis of {$course->course_name}",
                        5 => "Hands-on Implementation of {$course->course_name}",
                        6 => "Deep Dive into {$course->course_name}",
                        7 => "Modern Paradigms of {$course->course_name}",
                        8 => "Industry Standards for {$course->course_name}",
                        9 => "Comprehensive Review of {$course->course_name}",
                        10 => "Final Assessment for {$course->course_name}",
                    ];
                    $moduleTitle = $moduleTitles[$moduleNum] ?? "Module {$moduleNum} - Concepts";
                    $lessonTitle = $lessonTitles[$moduleNum] ?? "Lesson {$moduleNum} on {$course->course_name}";
                }

                $slug = Str::slug($lessonTitle) . '-' . $course->course_id . '-' . $moduleNum;

                // Create or update content lesson
                $lesson = ContentLesson::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'course_id' => $course->course_id,
                        'module_number' => $moduleNum,
                        'module_title' => $moduleTitle,
                        'title' => $lessonTitle,
                        'content_type' => 'lesson',
                        'summary' => "This module covers the primary objectives and key elements of {$course->course_name}.",
                        'body' => "<p>Welcome to this module on {$lessonTitle}. In this lesson, we will go through the core guidelines and methodologies. Please proceed with the chapters below.</p>",
                        'position' => $moduleNum,
                        'visibility' => 'visible',
                        'completion_required' => true,
                        'allow_comments' => true,
                        'is_published' => true,
                    ]
                );

                // Seed chapters for this lesson
                $chaptersCount = 2;
                for ($chapterNum = 1; $chapterNum <= $chaptersCount; $chapterNum++) {
                    if ($isWesternArt) {
                        if ($moduleNum === 1) {
                            $chapterTitle = $chapterNum === 1
                                ? "Overview & Historical Context of History of Western Art"
                                : "Practical Implementation of History of Western Art";
                        } elseif ($moduleNum === 2) {
                            $chapterTitle = $chapterNum === 1
                                ? "Overview & Historical Context of History of Western Art"
                                : "Practical Implementation of History of Western Art";
                        } elseif ($moduleNum === 796) {
                            $chapterTitle = $chapterNum === 1
                                ? "Overview of Video Testing"
                                : "Practical Video Implementation";
                        } else {
                            $chapterTitle = $chapterNum === 1
                                ? "Overview & Context of Topic {$moduleNum}"
                                : "Practical Implementation of Topic {$moduleNum}";
                        }
                    } else {
                        $chapterTitle = $chapterNum === 1
                            ? "Overview & Historical Context of {$course->course_name}"
                            : "Practical Implementation of {$course->course_name}";
                    }

                    ContentChapter::updateOrCreate(
                        [
                            'content_lesson_id' => $lesson->content_lesson_id,
                            'title' => $chapterTitle
                        ],
                        [
                            'summary' => "Topic overview for Chapter {$chapterNum} of Module {$moduleNum}.",
                            'content' => "<p>In this chapter, we explore the essential themes related to {$chapterTitle}. We discuss real-world examples, theoretical frameworks, and general standards in the field.</p>",
                            'sort_order' => $chapterNum,
                            'is_published' => true,
                        ]
                    );
                }

                // Seed video, document, assignment, and quiz for Western Art course to ensure they show up!
                if ($isWesternArt) {
                    ContentVideo::updateOrCreate(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Video: Introduction to ' . $lesson->title],
                        [
                            'description' => 'A video lecture covering the main themes of ' . $lesson->title,
                            'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                            'duration_seconds' => 900,
                            'sort_order' => 1,
                            'is_published' => true,
                        ]
                    );

                    ContentDocument::updateOrCreate(
                        ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Slide Deck: ' . $lesson->title],
                        [
                            'description' => 'Course presentation slides in PDF format.',
                            'file_path' => 'documents/slide_art_' . $moduleNum . '.pdf',
                            'sort_order' => 1,
                            'is_published' => true,
                        ]
                    );

                    if ($moduleNum === 1) {
                        // Seed Quiz 1.3
                        Quiz::updateOrCreate(
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
                            ]
                        );

                        // Seed Assignment 1.4 Test
                        ContentAssignment::updateOrCreate(
                            [
                                'content_lesson_id' => $lesson->content_lesson_id,
                                'title' => 'Test',
                            ],
                            [
                                'instructions' => '<p>Please complete the exercises listed in the chapter document and upload your results.</p>',
                                'due_at' => now()->addDays(7),
                                'max_score' => 100,
                                'allow_late_submission' => true,
                                'is_published' => true,
                            ]
                        );
                    }
                }
            }
        }
    }
}
