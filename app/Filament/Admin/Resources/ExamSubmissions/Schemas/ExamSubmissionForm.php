<?php

namespace App\Filament\Admin\Resources\ExamSubmissions\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ExamSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('exam_id')->label('ការប្រឡង')->relationship('exam', 'title')->searchable()->preload()->required(),
            Select::make('student_id')->label('និស្សិត')->relationship('student', 'student_code')->searchable()->preload()->required(),
            DateTimePicker::make('submitted_at')->label('ថ្ងៃដាក់ស្នើ'),
            TextInput::make('attempt_no')->label('លើកទី')->numeric()->default(1)->required(),
            TextInput::make('score')->label('ពិន្ទុ')->numeric(),
            Select::make('status')
                ->label('ស្ថានភាព')
                ->options([
                    'submitted' => 'បានដាក់ស្នើ',
                    'reviewing' => 'កំពុងពិនិត្យ',
                    'graded' => 'បានដាក់ពិន្ទុ',
                    'returned' => 'បានត្រឡប់',
                ])
                ->default('submitted')
                ->required(),
            Textarea::make('answers')->label('ចម្លើយ')->rows(6)->columnSpanFull(),
            Textarea::make('feedback')->label('មតិយោបល់')->rows(4)->columnSpanFull(),
        ]);
    }
}
