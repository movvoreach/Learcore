<?php

namespace App\Filament\Admin\Resources\Students\Tables;

use App\Models\Student;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\Layout\Split;
use Filament\Tables\Columns\Layout\Panel;
use Filament\Tables\Columns\Layout\Stack;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['department']))
            ->columns([
                Split::make([
                    TextColumn::make('student_code')
                        ->label('និស្សិត')
                        ->getStateUsing(fn (Student $record): string => trim($record->first_name.' '.$record->last_name) ?: $record->student_code)
                        ->description(fn (Student $record): string => $record->student_code)
                        ->searchable(['student_code', 'first_name', 'last_name', 'email'])
                        ->sortable()
                        ->weight('bold')
                        ->copyable(),

                    TextColumn::make('status')
                        ->label('ស្ថានភាព')
                        ->badge()
                        ->formatStateUsing(fn (string $state): string => match ($state) {
                            'active' => 'សកម្ម',
                            'inactive' => 'អសកម្ម',
                            'graduated' => 'បានបញ្ចប់ការសិក្សា',
                            default => $state,
                        })
                        ->color(fn (string $state): string => match ($state) {
                            'active' => 'success',
                            'inactive' => 'warning',
                            'graduated' => 'info',
                            default => 'gray',
                        })
                        ->sortable(),
                ]),

                Panel::make([
                    Stack::make([
                        TextColumn::make('department.department_name')
                            ->getStateUsing(fn (Student $record): string => 'ដេប៉ាតឺម៉ង់: ' . ($record->department?->department_name ?: 'មិនទាន់កំណត់') . ' (' . collect([
                                $record->academicYear?->year_name,
                                $record->semester?->semester_name,
                            ])->filter()->join(' · ') . ')'),

                        TextColumn::make('phone')
                            ->getStateUsing(fn (Student $record): string => 'លេខទូរស័ព្ទ: ' . ($record->phone ?: 'គ្មាន') . ' · អ៊ីមែល: ' . ($record->email ?: 'គ្មាន')),

                        TextColumn::make('enrollments_count')
                            ->getStateUsing(fn (Student $record): string => 'ចំនួនវគ្គសិក្សា: ' . ($record->enrollments_count ?? 0)),

                        TextColumn::make('progresses_count')
                            ->getStateUsing(fn (Student $record): string => 'ចំនួនវឌ្ឍនភាព: ' . ($record->progresses_count ?? 0)),

                        TextColumn::make('certificates_count')
                            ->getStateUsing(fn (Student $record): string => 'ចំនួនវិញ្ញាបនបត្រ: ' . ($record->certificates_count ?? 0)),
                    ])->space(3),
                ])
                ->collapsible()
                ->collapsed(true),
            ])
            ->filters([
                SelectFilter::make('department_id')
                    ->label('ដេប៉ាតឺម៉ង់')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload(false),

                SelectFilter::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload(false),

                SelectFilter::make('semester_id')
                    ->label('ឆមាស')
                    ->relationship('semester', 'semester_name')
                    ->searchable()
                    ->preload(false),

                SelectFilter::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'សកម្ម',
                        'inactive' => 'អសកម្ម',
                        'graduated' => 'បានបញ្ចប់ការសិក្សា',
                    ]),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->icon('heroicon-o-pencil-square')
                    ->successNotificationTitle('និស្សិតត្រូវបានកែសម្រួលដោយជោគជ័យ!'),

                DeleteAction::make()
                    ->label('លុប')
                    ->icon('heroicon-o-trash')
                    ->successNotificationTitle('និស្សិតត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('និស្សិតដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
