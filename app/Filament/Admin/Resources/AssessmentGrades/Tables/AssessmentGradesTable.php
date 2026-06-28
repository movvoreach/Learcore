<?php

namespace App\Filament\Admin\Resources\AssessmentGrades\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssessmentGradesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['assignment', 'exam', 'quiz', 'student']))
            ->columns([
                TextColumn::make('student.student_code')->label('កូដនិស្សិត')->searchable()->sortable(),
                TextColumn::make('exam.title')->label('ការប្រឡង')->searchable()->sortable(),
                TextColumn::make('quiz.title')->label('តេស្តខ្លី')->searchable()->sortable(),
                TextColumn::make('assignment.title')->label('កិច្ចការ')->searchable()->sortable(),
                TextColumn::make('score')->label('ពិន្ទុ')->sortable(),
                TextColumn::make('max_score')->label('ពិន្ទុសរុប')->sortable(),
                TextColumn::make('grade')->label('និទ្ទេស')->searchable()->sortable(),
                TextColumn::make('graded_at')->label('ថ្ងៃដាក់ពិន្ទុ')->dateTime()->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('graded_at', 'desc');
    }
}
