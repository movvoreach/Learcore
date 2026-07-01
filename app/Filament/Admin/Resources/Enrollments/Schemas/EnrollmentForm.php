<?php

namespace App\Filament\Admin\Resources\Enrollments\Schemas;

use App\Models\Semester;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class EnrollmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('student_id')
                    ->label('និស្សិត')
                    ->relationship('student', 'first_name')
                    ->searchable(['student_code', 'first_name', 'last_name'])
                    ->preload()
                    ->required(),
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('semester_id', null);
                    }),
                Select::make('semester_id')
                    ->label('ឆមាស')
                    ->options(fn (Get $get): array => blank($get('academic_year_id'))
                        ? []
                        : Semester::query()
                            ->where('academic_year_id', $get('academic_year_id'))
                            ->orderBy('start_date')
                            ->pluck('semester_name', 'semester_id')
                            ->all())
                    ->disabled(fn (Get $get): bool => blank($get('academic_year_id')))
                    ->required(fn (Get $get): bool => filled($get('academic_year_id')))
                    ->searchable()
                    ->preload(),
                DatePicker::make('enrollment_date')
                    ->label('ថ្ងៃចុះឈ្មោះ'),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'studying' => 'កំពុងសិក្សា',
                        'completed' => 'បានបញ្ចប់',
                        'cancelled' => 'បានបោះបង់',
                    ])
                    ->default('studying')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
