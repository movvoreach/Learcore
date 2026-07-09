<?php

namespace App\Filament\Admin\Resources\Courses\Schemas;

use App\Models\Semester;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;

class CourseForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_category_id')
                    ->label('ប្រភេទវគ្គសិក្សា')
                    ->relationship('category', 'category_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('department_id')
                    ->label('Department')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('academic_year_id')
                    ->label('Academic Year')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload()
                    ->live()
                    ->afterStateUpdated(function (Set $set): void {
                        $set('semester_id', null);
                    })
                    ->required(),
                Select::make('semester_id')
                    ->label('Semester')
                    ->options(fn (Get $get): array => blank($get('academic_year_id'))
                        ? []
                        : Semester::query()
                            ->where('academic_year_id', $get('academic_year_id'))
                            ->orderBy('start_date')
                            ->pluck('semester_name', 'semester_id')
                            ->all())
                    ->disabled(fn (Get $get): bool => blank($get('academic_year_id')))
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('course_code')
                    ->label('លេខកូដវគ្គសិក្សា')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true),
                TextInput::make('course_name')
                    ->label('ឈ្មោះវគ្គសិក្សា')
                    ->required()
                    ->maxLength(150),
                Textarea::make('description')
                    ->label('ការពិពណ៌នា')
                    ->columnSpanFull(),
                Select::make('visibility')
                    ->label('Visibility')
                    ->options([
                        'public' => 'Public',
                        'private' => 'Private',
                        'university_students' => 'University Students Only',
                    ])
                    ->default('private')
                    ->required(),
            ]);
    }
}
