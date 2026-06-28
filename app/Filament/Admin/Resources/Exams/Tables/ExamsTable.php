<?php

namespace App\Filament\Admin\Resources\Exams\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ExamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course', 'subject']))
            ->columns([
                TextColumn::make('title')->label('ការប្រឡង')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('subject.subject_name')->label('មុខវិជ្ជា')->searchable()->sortable(),
                TextColumn::make('exam_date')->label('កាលបរិច្ឆេទ')->date()->sortable(),
                TextColumn::make('start_time')->label('ចាប់ផ្តើម'),
                TextColumn::make('status')->label('ស្ថានភាព')->badge()->sortable(),
                TextColumn::make('total_score')->label('ពិន្ទុសរុប')->sortable(),
            ])
            ->recordActions([EditAction::make(), DeleteAction::make()])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('exam_date', 'desc');
    }
}
