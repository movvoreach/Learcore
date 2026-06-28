<?php

namespace Database\Seeders;

use App\Models\ClassRoom;
use App\Models\Schedule;
use App\Models\Teacher;
use Illuminate\Database\Seeder;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ScheduleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $teachers = Teacher::inRandomOrder()->limit(5)->get();
        $classes = ClassRoom::inRandomOrder()->limit(5)->get();

        if ($teachers->isEmpty() || $classes->isEmpty()) {
            $this->command->warn('No teachers or classes found. Please seed them first.');
            return;
        }

        $days = ['monday', 'tuesday', 'wednesday', 'thursday', 'friday'];
        $timeBlocks = [
            ['08:00:00', '09:30:00'],
            ['09:45:00', '11:15:00'],
            ['13:00:00', '14:30:00'],
            ['14:45:00', '16:15:00'],
            ['16:30:00', '18:00:00'],
        ];

        DB::table('schedules')->truncate();

        for ($i = 0; $i < 10; $i++) {
            $teacher = $teachers->random();
            $class = $classes->random();
            $day = $days[array_rand($days)];
            $time = $timeBlocks[array_rand($timeBlocks)];

            Schedule::create([
                'teacher_id' => $teacher->teacher_id,
                'class_id' => $class->class_room_id,
                'day' => $day,
                'start_time' => $time[0],
                'end_time' => $time[1],
            ]);
        }

        $this->command->info('Seeded 10 schedule records.');
    }
}
