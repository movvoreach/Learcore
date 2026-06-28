<?php

namespace App\Filament\Admin\Resources\Quizzes\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class QuizzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['lesson']))
            ->columns([
                TextColumn::make('title')->label('តេស្តខ្លី')->searchable()->sortable(),
                TextColumn::make('lesson.title')->label('មេរៀន')->searchable()->sortable(),
                TextColumn::make('available_from')->label('ចាប់ផ្តើម')->dateTime()->sortable(),
                TextColumn::make('available_until')->label('បញ្ចប់')->dateTime()->sortable(),
                TextColumn::make('passing_score')->label('ពិន្ទុជាប់')->sortable(),
                IconColumn::make('is_published')->label('ផ្សាយ')->boolean(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('created_at', 'desc');
    }
}
