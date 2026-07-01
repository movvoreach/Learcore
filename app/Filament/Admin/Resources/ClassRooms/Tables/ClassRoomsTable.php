<?php

namespace App\Filament\Admin\Resources\ClassRooms\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('course.course_name')
                    ->label('វគ្គសិក្សា (Course)')
                    ->searchable(),
                TextColumn::make('academicYear.year_name')
                    ->label('ឆ្នាំសិក្សា (Academic Year)')
                    ->searchable(),
                TextColumn::make('class_code')
                    ->label('លេខកូដថ្នាក់ (Class Code)')
                    ->searchable(),
                TextColumn::make('class_name')
                    ->label('ឈ្មោះថ្នាក់ (Class Name)')
                    ->searchable(),
                TextColumn::make('room')
                    ->label('បន្ទប់រៀន (Room)')
                    ->searchable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
