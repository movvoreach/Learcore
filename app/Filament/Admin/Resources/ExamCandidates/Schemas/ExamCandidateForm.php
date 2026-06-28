<?php

namespace App\Filament\Admin\Resources\ExamCandidates\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamCandidateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('exam_id')->label('ការប្រឡង')->relationship('exam', 'title')->searchable()->preload(false)->required(),
            Select::make('student_id')->label('និស្សិត')->relationship('student', 'student_code')->searchable()->preload(false)->required(),
            TextInput::make('seat_number')->label('លេខតុ')->maxLength(50),
            Select::make('status')
                ->label('ស្ថានភាព')
                ->options([
                    'registered' => 'បានចុះឈ្មោះ',
                    'checked_in' => 'បានចូលរួម',
                    'absent' => 'អវត្តមាន',
                    'cancelled' => 'បានបោះបង់',
                ])
                ->default('registered')
                ->required(),
        ]);
    }
}
