<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Tables;

use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AssignmentSubmissionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['assignment', 'student']))
            ->columns([
                TextColumn::make('assignment.title')
                    ->label('Assignment')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('student.student_code')
                    ->label('Student Code')
                    ->searchable(),
                TextColumn::make('student.first_name')
                    ->label('Student')
                    ->formatStateUsing(fn ($record): string => trim(($record->student?->first_name ?? '').' '.($record->student?->last_name ?? '')))
                    ->searchable(),
                TextColumn::make('submitted_at')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('status')
                    ->badge()
                    ->sortable(),
                TextColumn::make('score')
                    ->sortable(),
            ])
            ->recordActions([EditAction::make()])
            ->defaultSort('submitted_at', 'desc');
    }
}
