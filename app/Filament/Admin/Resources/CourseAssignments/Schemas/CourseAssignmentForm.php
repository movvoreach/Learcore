<?php

namespace App\Filament\Admin\Resources\CourseAssignments\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Schema;

class CourseAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('teacher_id')
                    ->label('គ្រូបង្រៀន')
                    ->options(fn (): array => \App\Models\Teacher::query()
                        ->get()
                        ->mapWithKeys(fn ($teacher) => [
                            $teacher->teacher_id => trim($teacher->last_name_kh.' '.$teacher->first_name_kh) 
                                ? (trim($teacher->last_name_kh.' '.$teacher->first_name_kh).' ('.trim($teacher->last_name.' '.$teacher->first_name).') - '.$teacher->teacher_code)
                                : (trim($teacher->last_name.' '.$teacher->first_name).' - '.$teacher->teacher_code)
                        ])
                        ->all())
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('class_room_id')
                    ->label('ថ្នាក់រៀន')
                    ->relationship('classRoom', 'class_name')
                    ->searchable()
                    ->preload(),
                Select::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload(),
                DatePicker::make('assigned_date')
                    ->label('ថ្ងៃចាត់តាំង'),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'កំពុងដំណើរការ',
                        'completed' => 'បានបញ្ចប់',
                        'cancelled' => 'បានលុបចោល',
                    ])
                    ->default('active')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
