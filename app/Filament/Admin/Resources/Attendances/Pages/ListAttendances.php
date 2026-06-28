<?php

namespace App\Filament\Admin\Resources\Attendances\Pages;

use App\Filament\Admin\Resources\Attendances\AttendanceResource;
use App\Models\ClassRoom;
use App\Models\Enrollment;
use App\Models\Attendance;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;

class ListAttendances extends ListRecords
{
    protected static string $resource = AttendanceResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Action::make('quickCreateAttendance')
                ->label('បង្កើតវត្តមានរហ័ស')
                ->icon('heroicon-o-check-circle')
                ->color('success')
                ->modalHeading('បង្កើតវត្តមានរហ័ស')
                ->modalDescription('ជ្រើសរើសថ្នាក់រៀន និងកាលបរិច្ឆេទដើម្បីបង្កើតកំណត់ត្រាវត្តមានសម្រាប់និស្សិតទាំងអស់។')
                ->form([
                    Select::make('class_room_id')
                        ->label('ថ្នាក់រៀន')
                        ->options(fn (): array => ClassRoom::query()
                            ->orderBy('class_name')
                            ->pluck('class_name', 'class_room_id')
                            ->all())
                        ->searchable()
                        ->preload(false)
                        ->required(),
                    DatePicker::make('attendance_date')
                        ->label('កាលបរិច្ឆេទ')
                        ->native(true)
                        ->default(now()->toDateString())
                        ->required(),
                    Select::make('status')
                        ->label('ស្ថានភាពលំនាំដើម')
                        ->options([
                            'present' => 'មានវត្តមាន',
                            'absent' => 'អវត្តមាន',
                            'late' => 'មកយឺត',
                            'excused' => 'មានច្បាប់',
                        ])
                        ->default('present')
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $classRoomId = $data['class_room_id'];
                    $attendanceDate = $data['attendance_date'];
                    $defaultStatus = $data['status'];

                    $enrollments = Enrollment::query()
                        ->where('class_room_id', $classRoomId)
                        ->where('status', 'studying')
                        ->get();

                    if ($enrollments->isEmpty()) {
                        Notification::make()
                            ->title('មិនមាននិស្សិតក្នុងថ្នាក់នេះទេ')
                            ->warning()
                            ->send();
                        return;
                    }

                    $createdCount = 0;
                    foreach ($enrollments as $enrollment) {
                        $studentId = $enrollment->student_id;

                        // Check if record exists
                        $exists = Attendance::query()
                            ->where('student_id', $studentId)
                            ->where('class_room_id', $classRoomId)
                            ->where('attendance_date', $attendanceDate)
                            ->exists();

                        if (!$exists) {
                            Attendance::create([
                                'student_id' => $studentId,
                                'class_room_id' => $classRoomId,
                                'attendance_date' => $attendanceDate,
                                'status' => $defaultStatus,
                            ]);
                            $createdCount++;
                        }
                    }

                    Notification::make()
                        ->title("បានបង្កើតវត្តមានសម្រាប់និស្សិតចំនួន {$createdCount} នាក់ដោយជោគជ័យ។")
                        ->success()
                        ->send();
                }),
            CreateAction::make(),
        ];
    }
}
