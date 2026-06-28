<?php

namespace App\Filament\Admin\Resources\Attendances\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class AttendanceForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('និស្សិត')
                    ->relationship('student', 'first_name')
                    ->searchable(['student_code', 'first_name', 'last_name'])
                    ->preload(false)
                    ->required(),
                Select::make('class_room_id')
                    ->label('ថ្នាក់រៀន')
                    ->relationship('classRoom', 'class_name')
                    ->searchable()
                    ->preload(false),
                DatePicker::make('attendance_date')
                    ->label('កាលបរិច្ឆេទ')
                    ->required(),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'present' => 'មានវត្តមាន',
                        'absent' => 'អវត្តមាន',
                        'late' => 'មកយឺត',
                        'excused' => 'មានច្បាប់',
                    ])
                    ->default('present')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
