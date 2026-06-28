<?php

namespace Database\Seeders;

use App\Models\AcademicYear;
use App\Models\AssessmentGrade;
use App\Models\AssessmentQuestion;
use App\Models\AssessmentResult;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\Certificate;
use App\Models\ClassRoom;
use App\Models\ContentAssignment;
use App\Models\ContentDocument;
use App\Models\ContentLesson;
use App\Models\ContentResource;
use App\Models\ContentVideo;
use App\Models\Course;
use App\Models\CourseAssignment;
use App\Models\Enrollment;
use App\Models\Exam;
use App\Models\ExamCandidate;
use App\Models\ExamSubmission;
use App\Models\QuestionBank;
use App\Models\QuestionOption;
use App\Models\Quiz;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Models\StudentPromotion;
use App\Models\Subject;
use App\Models\Teacher;
use App\Models\TeacherSchedule;
use Illuminate\Database\Seeder;

class AllFeaturesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $courses = Course::all();
        $students = Student::all();
        $teachers = Teacher::all();

        if ($courses->isEmpty() || $students->isEmpty() || $teachers->isEmpty()) {
            return;
        }

        // 1. Seed 20 Subjects (linked to Courses)
        foreach ($courses->take(20) as $index => $course) {
            Subject::updateOrCreate(
                ['subject_code' => 'SUB-' . $course->course_code],
                [
                    'course_id' => $course->course_id,
                    'subject_name' => 'Subject for ' . $course->course_name,
                    'credit' => rand(2, 4),
                    'description' => 'Core curriculum subject for ' . $course->course_name,
                ]
            );
        }

        // 2. Seed 20 ClassRooms (linked to Courses and Academic Years)
        foreach ($courses->take(20) as $index => $course) {
            ClassRoom::updateOrCreate(
                ['class_code' => 'CLASS-' . $course->course_code],
                [
                    'course_id' => $course->course_id,
                    'academic_year_id' => $course->academic_year_id,
                    'class_name' => 'Class A - ' . $course->course_name,
                    'room' => 'Room ' . rand(101, 505),
                ]
            );
        }

        // 3. Seed 20 CourseAssignments (assigning Teachers to ClassRooms/Courses)
        $classRooms = ClassRoom::take(20)->get();
        foreach ($classRooms as $index => $classRoom) {
            $teacher = $teachers->get($index % $teachers->count());
            CourseAssignment::updateOrCreate(
                [
                    'teacher_id' => $teacher->teacher_id,
                    'course_id' => $classRoom->course_id,
                    'class_room_id' => $classRoom->class_room_id,
                ],
                [
                    'academic_year_id' => $classRoom->academic_year_id,
                    'assigned_date' => now()->subDays(30),
                    'status' => 'active',
                    'note' => 'Main course lecturer.',
                ]
            );
        }

        // 4. Seed 20 Enrollments (enroll Students and align student academic year/semester/department)
        foreach ($students as $index => $student) {
            $course = $courses->get($index % $courses->count());
            
            // Align student credentials with the course so they match dashboard filters
            $student->update([
                'department_id' => $course->department_id,
                'academic_year_id' => $course->academic_year_id,
                'semester_id' => $course->semester_id,
            ]);

            $classRoom = ClassRoom::where('course_id', $course->course_id)->first();
            
            Enrollment::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'course_id' => $course->course_id,
                ],
                [
                    'class_room_id' => $classRoom?->class_room_id,
                    'academic_year_id' => $course->academic_year_id,
                    'semester_id' => $course->semester_id,
                    'enrollment_date' => now()->subDays(20),
                    'status' => 'enrolled',
                    'note' => 'Registered for learning.',
                ]
            );
        }

        // 5. Seed Content Items (Videos, Documents, Assignments, Resources for 20 lessons)
        $lessons = ContentLesson::take(20)->get();
        foreach ($lessons as $index => $lesson) {
            ContentVideo::updateOrCreate(
                ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Video: Introduction to ' . $lesson->title],
                [
                    'description' => 'A video lecture covering the main themes of ' . $lesson->title,
                    'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                    'duration_seconds' => rand(600, 1800),
                    'sort_order' => 1,
                    'is_published' => true,
                ]
            );

            ContentDocument::updateOrCreate(
                ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Slide Deck: ' . $lesson->title],
                [
                    'description' => 'Course presentation slides in PDF format.',
                    'file_path' => 'documents/slide_' . $index . '.pdf',
                    'sort_order' => 1,
                    'is_published' => true,
                ]
            );

            ContentAssignment::updateOrCreate(
                ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Assignment on ' . $lesson->title],
                [
                    'instructions' => '<p>Please complete the exercises listed in the chapter document and upload your results.</p>',
                    'due_at' => now()->addDays(rand(2, 10)),
                    'max_score' => 100,
                    'allow_late_submission' => true,
                    'is_published' => true,
                ]
            );

            ContentResource::updateOrCreate(
                ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Web Resource: ' . $lesson->title],
                [
                    'description' => 'Supplementary reading and references.',
                    'external_url' => 'https://laravel.com/docs',
                    'sort_order' => 1,
                    'is_published' => true,
                ]
            );
        }

        // 6. Seed 20 AssignmentSubmissions
        $assignments = ContentAssignment::take(20)->get();
        foreach ($students as $index => $student) {
            $assignment = $assignments->get($index % $assignments->count());
            AssignmentSubmission::updateOrCreate(
                [
                    'content_assignment_id' => $assignment->content_assignment_id,
                    'student_id' => $student->student_id,
                ],
                [
                    'response' => 'Student response to the assignment tasks detailing solutions.',
                    'attachment_url' => 'submissions/res_' . $student->student_id . '.zip',
                    'submitted_at' => now()->subDays(rand(1, 5)),
                    'status' => 'submitted',
                    'score' => rand(70, 95),
                    'feedback' => 'Good effort.',
                ]
            );
        }

        // 7. Seed Quizzes & Assessment questions
        foreach ($lessons as $index => $lesson) {
            $qbank = QuestionBank::updateOrCreate(
                ['course_id' => $lesson->course_id, 'title' => 'Question Bank: ' . $lesson->title],
                [
                    'subject_id' => Subject::where('course_id', $lesson->course_id)->first()?->subject_id,
                    'description' => 'Database of assessment questions for ' . $lesson->title,
                    'is_active' => true,
                ]
            );

            $quiz = Quiz::updateOrCreate(
                ['content_lesson_id' => $lesson->content_lesson_id, 'title' => 'Quiz: ' . $lesson->title],
                [
                    'instructions' => 'Complete all multiple choice questions within the time limit.',
                    'available_from' => now()->subDays(5),
                    'available_until' => now()->addDays(5),
                    'time_limit_minutes' => 30,
                    'max_attempts' => 3,
                    'passing_score' => 70,
                    'is_published' => true,
                ]
            );

            $question = AssessmentQuestion::updateOrCreate(
                ['question_bank_id' => $qbank->question_bank_id, 'question_text' => 'What is the core principle of ' . $lesson->title . '?'],
                [
                    'content_lesson_id' => $lesson->content_lesson_id,
                    'question_type' => 'multiple_choice',
                    'points' => 10,
                    'correct_answer' => 'Option A',
                    'explanation' => 'Option A provides the correct implementation.',
                    'is_active' => true,
                ]
            );

            QuestionOption::updateOrCreate(
                ['assessment_question_id' => $question->assessment_question_id, 'option_text' => 'Option A'],
                [
                    'is_correct' => true,
                    'sort_order' => 1,
                ]
            );

            QuestionOption::updateOrCreate(
                ['assessment_question_id' => $question->assessment_question_id, 'option_text' => 'Option B'],
                [
                    'is_correct' => false,
                    'sort_order' => 2,
                ]
            );
        }

        // 8. Seed 20 Exams
        foreach ($courses->take(20) as $index => $course) {
            $subject = Subject::where('course_id', $course->course_id)->first();
            Exam::updateOrCreate(
                ['course_id' => $course->course_id, 'title' => 'Final Exam: ' . $course->course_name],
                [
                    'subject_id' => $subject?->subject_id,
                    'description' => 'Comprehensive final examination covering all course chapters.',
                    'exam_date' => now()->addDays(rand(10, 30))->format('Y-m-d'),
                    'start_time' => '09:00:00',
                    'end_time' => '12:00:00',
                    'duration_minutes' => 180,
                    'total_score' => 100,
                    'passing_score' => 50,
                    'status' => 'scheduled',
                ]
            );
        }

        // 9. Seed 20 ExamCandidates
        $exams = Exam::take(20)->get();
        foreach ($students as $index => $student) {
            $exam = $exams->get($index % $exams->count());
            ExamCandidate::updateOrCreate(
                [
                    'exam_id' => $exam->exam_id,
                    'student_id' => $student->student_id,
                ],
                [
                    'seat_number' => 'SEAT-' . str_pad((string)($index + 1), 4, '0', STR_PAD_LEFT),
                    'status' => 'registered',
                ]
            );
        }

        // 10. Seed 20 ExamSubmissions
        foreach ($students as $index => $student) {
            $exam = $exams->get($index % $exams->count());
            ExamSubmission::updateOrCreate(
                [
                    'exam_id' => $exam->exam_id,
                    'student_id' => $student->student_id,
                ],
                [
                    'submitted_at' => now()->subDays(2),
                    'attempt_no' => 1,
                    'answers' => ['q1' => 'ans1', 'q2' => 'ans2'],
                    'score' => rand(60, 95),
                    'status' => 'submitted',
                    'feedback' => 'Satisfactory performance.',
                ]
            );
        }

        // 11. Seed 20 AssessmentGrades
        foreach ($students as $index => $student) {
            $course = $courses->get($index % $courses->count());
            $assignment = ContentAssignment::where('content_lesson_id', ContentLesson::where('course_id', $course->course_id)->first()?->content_lesson_id)->first();
            $teacher = $teachers->get($index % $teachers->count());
            
            AssessmentGrade::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'content_assignment_id' => $assignment?->content_assignment_id,
                ],
                [
                    'graded_by' => $teacher->teacher_id,
                    'score' => rand(70, 95),
                    'max_score' => 100,
                    'grade' => rand(0, 1) ? 'A' : 'B',
                    'graded_at' => now()->subDays(2),
                    'remarks' => 'Great performance.',
                ]
            );
        }

        // 12. Seed 20 AssessmentResults
        foreach ($students as $index => $student) {
            $exam = $exams->get($index % $exams->count());
            AssessmentResult::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'exam_id' => $exam->exam_id,
                ],
                [
                    'assessment_type' => 'exam',
                    'total_score' => rand(60, 95),
                    'passed' => true,
                    'rank' => rand(1, 5),
                    'published_at' => now()->subDays(1),
                    'remarks' => 'Passed.',
                ]
            );
        }

        // 13. Seed 20 StudentProgress records
        foreach ($students as $index => $student) {
            $course = $courses->get($index % $courses->count());
            $classRoom = ClassRoom::where('course_id', $course->course_id)->first();
            StudentProgress::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'course_id' => $course->course_id,
                ],
                [
                    'class_room_id' => $classRoom?->class_room_id,
                    'progress_date' => now()->subDays(1),
                    'progress_percent' => rand(40, 90),
                    'score' => rand(70, 95),
                    'status' => 'in_progress',
                    'note' => 'Regular studying logs.',
                ]
            );
        }

        // 14. Seed 20 StudentPromotions
        foreach ($students as $index => $student) {
            $years = AcademicYear::take(2)->get();
            if ($years->count() >= 2) {
                StudentPromotion::updateOrCreate(
                    [
                        'student_id' => $student->student_id,
                        'from_year_id' => $years->first()->academic_year_id,
                        'to_year_id' => $years->last()->academic_year_id,
                    ],
                    [
                        'from_department_id' => $student->department_id,
                        'from_semester_id' => Semester::where('academic_year_id', $years->first()->academic_year_id)->first()?->semester_id,
                        'to_semester_id' => Semester::where('academic_year_id', $years->last()->academic_year_id)->first()?->semester_id,
                        'promoted_at' => now()->subMonths(6),
                        'note' => 'Academic promotion to new year.',
                    ]
                );
            }
        }

        // 15. Seed 20 Certificates
        foreach ($students as $index => $student) {
            $course = $courses->get($index % $courses->count());
            Certificate::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'course_id' => $course->course_id,
                ],
                [
                    'certificate_no' => 'CERT-' . str_pad((string)($index + 1), 6, '0', STR_PAD_LEFT),
                    'issued_date' => now()->subDays(5)->format('Y-m-d'),
                    'status' => 'issued',
                    'note' => 'Course completed successfully.',
                ]
            );
        }

        // 16. Seed 20 Attendance records
        foreach ($students as $index => $student) {
            $course = $courses->get($index % $courses->count());
            $classRoom = ClassRoom::where('course_id', $course->course_id)->first();
            Attendance::updateOrCreate(
                [
                    'student_id' => $student->student_id,
                    'class_room_id' => $classRoom?->class_room_id,
                    'attendance_date' => now()->subDays(1)->format('Y-m-d'),
                ],
                [
                    'status' => 'present',
                    'note' => 'Attended class.',
                ]
            );
        }

        // 17. Seed 20 TeacherSchedules
        foreach ($classRooms as $index => $classRoom) {
            $teacher = $teachers->get($index % $teachers->count());
            TeacherSchedule::updateOrCreate(
                [
                    'teacher_id' => $teacher->teacher_id,
                    'course_id' => $classRoom->course_id,
                    'class_room_id' => $classRoom->class_room_id,
                ],
                [
                    'day_of_week' => rand(1, 5), // Mon-Fri
                    'start_time' => '08:00:00',
                    'end_time' => '10:00:00',
                    'room' => $classRoom->room,
                    'status' => 'active',
                    'note' => 'Weekly lecture schedule.',
                ]
            );
        }
    }
}
