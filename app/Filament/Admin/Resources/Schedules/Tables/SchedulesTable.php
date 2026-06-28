<?php

namespace App\Filament\Admin\Resources\Schedules\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SchedulesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('teacher.first_name')
                    ->label('គ្រូបង្រៀន (Teacher)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('classRoom.class_name')
                    ->label('ថ្នាក់រៀន (Class)')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('day')
                    ->label('ថ្ងៃ (Day)')
                    ->formatStateUsing(fn (string $state): string => match ($state) {
                        'monday' => 'ចន្ទ (Monday)',
                        'tuesday' => 'អង្គារ (Tuesday)',
                        'wednesday' => 'ពុធ (Wednesday)',
                        'thursday' => 'ព្រហស្បតិ៍ (Thursday)',
                        'friday' => 'សុក្រ (Friday)',
                        'saturday' => 'សៅរ៍ (Saturday)',
                        'sunday' => 'អាទិត្យ (Sunday)',
                        default => $state,
                    })
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('ម៉ោងចាប់ផ្តើម (Start Time)')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('end_time')
                    ->label('ម៉ោងបញ្ចប់ (End Time)')
                    ->time('H:i')
                    ->sortable(),
                TextColumn::make('students_count')
                    ->label('សិស្សសរុប (Total Students)')
                    ->counts('students')
                    ->sortable(),
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
