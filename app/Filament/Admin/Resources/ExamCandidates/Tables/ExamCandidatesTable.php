<?php

namespace App\Filament\Admin\Resources\ExamCandidates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamCandidatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['exam', 'student']))
            ->columns([
                TextColumn::make('exam.title')->label('ការប្រឡង')->searchable()->sortable(),
                TextColumn::make('student.student_code')->label('កូដនិស្សិត')->searchable()->sortable(),
                TextColumn::make('student.first_name')->label('នាម')->searchable(),
                TextColumn::make('student.last_name')->label('គោត្តនាម')->searchable(),
                TextColumn::make('seat_number')->label('លេខតុ')->searchable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge()->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }
}
