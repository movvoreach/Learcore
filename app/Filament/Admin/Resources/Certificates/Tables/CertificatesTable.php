<?php

namespace App\Filament\Admin\Resources\Certificates\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class CertificatesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course', 'student']))
            ->columns([
                TextColumn::make('certificate_no')->label('លេខវិញ្ញាបនបត្រ')->searchable()->sortable(),
                TextColumn::make('student.student_code')->label('លេខកូដ')->searchable()->sortable(),
                TextColumn::make('student.first_name')->label('និស្សិត')->searchable()->sortable(),
                TextColumn::make('course.course_name')->label('វគ្គសិក្សា')->searchable()->sortable(),
                TextColumn::make('issued_date')->label('ថ្ងៃចេញ')->date()->sortable(),
                TextColumn::make('status')->label('ស្ថានភាព')->badge(),
            ])
            ->filters([
                SelectFilter::make('course_id')->label('វគ្គសិក្សា')->relationship('course', 'course_name')->searchable()->preload(),
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'issued' => 'បានចេញ',
                        'pending' => 'កំពុងរង់ចាំ',
                        'revoked' => 'បានដកហូត',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
