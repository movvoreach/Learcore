<?php

namespace App\Filament\Admin\Resources\AssessmentGrades\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssessmentGradeForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('student_id')->label('និស្សិត')->relationship('student', 'student_code')->searchable()->preload(false)->required(),
            Select::make('exam_id')->label('ការប្រឡង')->relationship('exam', 'title')->searchable()->preload(false),
            Select::make('quiz_id')->label('តេស្តខ្លី')->relationship('quiz', 'title')->searchable()->preload(false),
            Select::make('content_assignment_id')->label('កិច្ចការ')->relationship('assignment', 'title')->searchable()->preload(false),
            Select::make('graded_by')->label('អ្នកដាក់ពិន្ទុ')->relationship('grader', 'name')->searchable()->preload(false),
            TextInput::make('score')->label('ពិន្ទុ')->numeric()->default(0)->required(),
            TextInput::make('max_score')->label('ពិន្ទុអតិបរមា')->numeric()->default(100)->required(),
            TextInput::make('grade')->label('និទ្ទេស')->maxLength(20),
            DateTimePicker::make('graded_at')->label('ថ្ងៃដាក់ពិន្ទុ'),
            Textarea::make('remarks')->label('កំណត់ចំណាំ')->rows(4)->columnSpanFull(),
        ]);
    }
}
