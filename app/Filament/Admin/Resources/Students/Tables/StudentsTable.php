<?php

namespace App\Filament\Admin\Resources\Students\Tables;

use App\Models\Student;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class StudentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query, $livewire): Builder => $query
                ->with(['department', 'academicYear', 'semester'])
                ->when($livewire && isset($livewire->department_id) && $livewire->department_id, fn ($q) => $q->where('department_id', $livewire->department_id))
                ->when($livewire && isset($livewire->academic_year_id) && $livewire->academic_year_id, fn ($q) => $q->where('academic_year_id', $livewire->academic_year_id))
                ->when($livewire && isset($livewire->semester_id) && $livewire->semester_id, fn ($q) => $q->where('semester_id', $livewire->semester_id))
            )
            ->columns([
                TextColumn::make('student_code')
                    ->label('និស្សិត')
                    ->getStateUsing(fn (Student $record): string => trim($record->last_name_kh.' '.$record->first_name_kh) ?: trim($record->last_name.' '.$record->first_name) ?: $record->student_code)
                    ->description(fn (Student $record): string => collect([
                        trim($record->last_name.' '.$record->first_name),
                        $record->student_code
                    ])->filter()->join(' · '))
                    ->searchable(['student_code', 'first_name', 'last_name', 'first_name_kh', 'last_name_kh', 'email'])
                    ->sortable()
                    ->weight('bold')
                    ->copyable(),

                TextColumn::make('department.department_name')
                    ->label('ការសិក្សា')
                    ->description(fn (Student $record): string => collect([
                        $record->academicYear?->year_name,
                        $record->semester?->semester_name,
                    ])->filter()->join(' · ') ?: 'មិនទាន់កំណត់')
                    ->searchable()
                    ->sortable()
                    ->wrap(),

                TextColumn::make('phone')
                    ->label('ទំនាក់ទំនង')
                    ->description(fn (Student $record): string => $record->email ?: 'គ្មានអ៊ីមែល')
                    ->placeholder('គ្មានលេខទូរស័ព្ទ')
                    ->searchable()
                    ->copyable(),

                TextColumn::make('enrollments_count')
                    ->label('វគ្គសិក្សា')
                    ->badge()
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('progresses_count')
                    ->label('វឌ្ឍនភាព')
                    ->badge()
                    ->color('info')
                    ->sortable()
                    ->alignCenter(),

                TextColumn::make('certificates_count')
                    ->label('វិញ្ញាបនបត្រ')
                    ->badge()
                    ->color('success')
                    ->sortable()
                    ->alignCenter(),

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

                TextColumn::make('created_at')
                    ->label('បានបង្កើត')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
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
