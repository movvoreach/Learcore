<?php

namespace Database\Seeders;

use App\Models\Course;
use App\Models\ContentLesson;
use App\Models\ContentChapter;
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

        foreach ($courses as $index => $course) {
            // Seed 2 lessons per course (total 100 lessons if 50 courses)
            for ($moduleNum = 1; $moduleNum <= 2; $moduleNum++) {
                $lessonTitle = $moduleNum === 1 
                    ? "Fundamental Concepts of {$course->course_name}" 
                    : "Advanced Methodologies in {$course->course_name}";

                $slug = Str::slug($lessonTitle) . '-' . $course->course_id . '-' . $moduleNum;

                // Create or update content lesson
                $lesson = ContentLesson::updateOrCreate(
                    ['slug' => $slug],
                    [
                        'course_id' => $course->course_id,
                        'module_number' => $moduleNum,
                        'module_title' => $moduleNum === 1 ? 'Introduction & Core Principles' : 'Advanced Operations',
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

                // Seed 2 chapters per lesson (total 200 chapters)
                for ($chapterNum = 1; $chapterNum <= 2; $chapterNum++) {
                    $chapterTitle = $chapterNum === 1
                        ? "Overview & Historical Context of {$course->course_name}"
                        : "Practical Implementation of {$course->course_name}";

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
            }
        }
    }
}
