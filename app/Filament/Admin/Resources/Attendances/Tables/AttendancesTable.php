<?php

namespace App\Filament\Admin\Resources\Attendances\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\DatePicker;
use Filament\Tables\Columns\SelectColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\TextInputColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class AttendancesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['classRoom', 'student']))
            ->columns([
                TextColumn::make('attendance_date')->label('កាលបរិច្ឆេទ')->date()->sortable(),
                TextColumn::make('student.student_code')->label('លេខកូដ')->searchable()->sortable(),
                TextColumn::make('student.first_name')->label('និស្សិត')->searchable()->sortable(),
                TextColumn::make('classRoom.class_name')->label('ថ្នាក់រៀន')->searchable()->sortable(),
                SelectColumn::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'present' => 'មានវត្តមាន',
                        'absent' => 'អវត្តមាន',
                        'late' => 'មកយឺត',
                        'excused' => 'មានច្បាប់',
                    ])
                    ->selectablePlaceholder(false)
                    ->sortable(),
                TextInputColumn::make('note')
                    ->label('កំណត់សម្គាល់'),
            ])
            ->filters([
                SelectFilter::make('class_room_id')->label('ថ្នាក់រៀន')->relationship('classRoom', 'class_name')->searchable()->preload(false),
                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'present' => 'មានវត្តមាន',
                        'absent' => 'អវត្តមាន',
                        'late' => 'មកយឺត',
                        'excused' => 'មានច្បាប់',
                    ]),
                Filter::make('attendance_date')
                    ->label('កាលបរិច្ឆេទ')
                    ->form([
                        DatePicker::make('attendance_date')
                            ->label('កាលបរិច្ឆេទ')
                            ->native(true)
                            ->default(now()->toDateString()),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query->when(
                            $data['attendance_date'],
                            fn (Builder $query, $date): Builder => $query->whereDate('attendance_date', $date),
                        );
                    }),
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
            ->defaultSort('attendance_date', 'desc');
    }
}
