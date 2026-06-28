<?php

namespace App\Filament\Admin\Resources\ExamSubmissions\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['exam', 'student']))
            ->columns([
                TextColumn::make('exam.title')->label('ការប្រឡង')->searchable()->sortable(),
                TextColumn::make('student.student_code')->label('កូដនិស្សិត')->searchable()->sortable(),
                TextColumn::make('submitted_at')->label('ថ្ងៃដាក់ស្នើ')->dateTime()->sortable(),
                TextColumn::make('attempt_no')->label('លើកទី')->sortable(),
                TextColumn::make('score')->label('ពិន្ទុ')->sortable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge()->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('submitted_at', 'desc');
    }
}
