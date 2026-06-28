<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

return new class extends Migration
{
    public function up(): void
    {
        $course = DB::table('courses')
            ->where('course_code', '12')
            ->where('course_name', 'Networking')
            ->first();

        if (! $course) {
            return;
        }

        if (DB::table('content_lessons')->where('course_id', $course->course_id)->exists()) {
            return;
        }

        $lessons = [
            [
                'title' => 'Introduction to Networking',
                'module_title' => 'Networking Fundamentals',
                'summary' => 'Understand networks, devices, and the role of protocols in communication.',
                'chapters' => [
                    'What is Networking?',
                    'Network Devices',
                    'LAN, WAN, and Internet',
                    'Client Server Communication',
                ],
            ],
            [
                'title' => 'OSI and TCP/IP Models',
                'module_title' => 'Network Models',
                'summary' => 'Learn how layered network models explain data movement across networks.',
                'chapters' => [
                    'OSI Model Overview',
                    'TCP/IP Model Overview',
                    'Encapsulation',
                    'Common Protocols',
                ],
            ],
            [
                'title' => 'IP Addressing and Subnetting',
                'module_title' => 'IP Fundamentals',
                'summary' => 'Practice IPv4 addressing, subnet masks, gateways, and subnet planning.',
                'chapters' => [
                    'IPv4 Address Structure',
                    'Subnet Masks',
                    'Default Gateway',
                    'Subnetting Practice',
                ],
            ],
            [
                'title' => 'Switching Basics',
                'module_title' => 'LAN Switching',
                'summary' => 'Explore how switches forward frames and how VLANs segment a network.',
                'chapters' => [
                    'MAC Address Table',
                    'Frame Forwarding',
                    'VLAN Concepts',
                    'Basic Switch Configuration',
                ],
            ],
            [
                'title' => 'Routing Basics',
                'module_title' => 'IP Routing',
                'summary' => 'Understand routing tables, static routes, and basic router configuration.',
                'chapters' => [
                    'What is Routing?',
                    'Routing Table',
                    'Static Routes',
                    'Default Routes',
                ],
            ],
        ];

        foreach ($lessons as $index => $lesson) {
            $lessonId = DB::table('content_lessons')->insertGetId([
                'course_id' => $course->course_id,
                'module_number' => $index + 1,
                'module_title' => $lesson['module_title'],
                'title' => $lesson['title'],
                'slug' => Str::slug($lesson['title']).'-'.$course->course_id,
                'content_type' => 'lesson',
                'summary' => $lesson['summary'],
                'body' => '<p>'.$lesson['summary'].'</p><p>Use the lesson tree on the left to move through each topic. Mark each lesson complete when you finish reviewing the material.</p>',
                'position' => $index + 1,
                'visibility' => 'visible',
                'completion_required' => true,
                'allow_comments' => false,
                'is_published' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ], 'content_lesson_id');

            foreach ($lesson['chapters'] as $chapterIndex => $chapterTitle) {
                DB::table('content_chapters')->insert([
                    'content_lesson_id' => $lessonId,
                    'title' => $chapterTitle,
                    'summary' => 'Topic '.($index + 1).'.'.($chapterIndex + 1),
                    'content' => '<p>'.$chapterTitle.' introduces the key CCNA concepts students should understand before moving forward.</p>',
                    'sort_order' => $chapterIndex + 1,
                    'is_published' => true,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    public function down(): void
    {
        $course = DB::table('courses')
            ->where('course_code', '12')
            ->where('course_name', 'Networking')
            ->first();

        if (! $course) {
            return;
        }

        $lessonIds = DB::table('content_lessons')
            ->where('course_id', $course->course_id)
            ->whereIn('slug', [
                'introduction-to-networking-'.$course->course_id,
                'osi-and-tcpip-models-'.$course->course_id,
                'ip-addressing-and-subnetting-'.$course->course_id,
                'switching-basics-'.$course->course_id,
                'routing-basics-'.$course->course_id,
            ])
            ->pluck('content_lesson_id');

        DB::table('content_chapters')
            ->whereIn('content_lesson_id', $lessonIds)
            ->delete();

        DB::table('content_lessons')
            ->whereIn('content_lesson_id', $lessonIds)
            ->delete();
    }
};
