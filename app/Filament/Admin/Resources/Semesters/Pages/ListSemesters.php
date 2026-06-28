<?php

namespace App\Filament\Admin\Resources\Semesters\Pages;

use App\Filament\Admin\Resources\Semesters\SemesterResource;
use App\Models\AcademicYear;
use App\Models\Semester;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Section;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class ListSemesters extends ListRecords
{
    protected static string $resource = SemesterResource::class;

    protected static ?string $title = 'បញ្ជីឆមាស';

    protected static ?string $breadcrumb = 'បញ្ជី';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->label('បញ្ចូលឆមាស'),
            Action::make('create_semesters_group')
                ->label('បង្កើតឆមាសជាក្រុម')
                ->icon('heroicon-o-squares-plus')
                ->modalHeading('បង្កើតឆមាសជាក្រុម')
                ->modalDescription('ជ្រើសឆ្នាំសិក្សា ហើយបញ្ចូលឆមាសច្រើនក្នុង modal តែមួយ។')
                ->modalSubmitActionLabel('រក្សាទុកឆមាស')
                ->modalWidth(Width::ExtraLarge)
                ->form([
                    Select::make('academic_year_id')
                        ->label('ឆ្នាំសិក្សា')
                        ->options(fn (): array => AcademicYear::query()
                            ->orderByDesc('start_date')
                            ->orderBy('year_name')
                            ->pluck('year_name', 'academic_year_id')
                            ->all())
                        ->searchable()
                        ->preload(false)
                        ->required(),
                    Repeater::make('semesters')
                        ->label('បញ្ជីឆមាស')
                        ->schema([
                            TextInput::make('semester_name')
                                ->label('ឈ្មោះឆមាស')
                                ->placeholder('ឆមាសទី 1')
                                ->required()
                                ->maxLength(100),
                            DatePicker::make('start_date')
                                ->label('ថ្ងៃចាប់ផ្តើម')
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->required()
                                ->beforeOrEqual('end_date'),
                            DatePicker::make('end_date')
                                ->label('ថ្ងៃបញ្ចប់')
                                ->native(false)
                                ->displayFormat('d/m/Y')
                                ->required()
                                ->afterOrEqual('start_date'),
                            Toggle::make('is_active')
                                ->label('កំពុងប្រើប្រាស់'),
                        ])
                        ->default([
                            ['semester_name' => 'ឆមាសទី 1', 'is_active' => true],
                            ['semester_name' => 'ឆមាសទី 2', 'is_active' => false],
                        ])
                        ->columns(2)
                        ->addActionLabel('បន្ថែមឆមាស')
                        ->reorderableWithButtons()
                        ->minItems(1)
                        ->required(),
                ])
                ->action(function (array $data): void {
                    $semesters = collect($data['semesters'] ?? [])
                        ->map(fn (array $semester): array => [
                            ...$semester,
                            'semester_name' => trim((string) ($semester['semester_name'] ?? '')),
                        ])
                        ->filter(fn (array $semester): bool => filled($semester['semester_name']))
                        ->values();

                    $duplicateNames = $semesters
                        ->pluck('semester_name')
                        ->duplicates()
                        ->unique()
                        ->values();

                    if ($duplicateNames->isNotEmpty()) {
                        throw ValidationException::withMessages([
                            'semesters' => 'ឈ្មោះឆមាសស្ទួន: '.$duplicateNames->implode(', '),
                        ]);
                    }

                    [$createdCount, $updatedCount] = DB::transaction(function () use ($data, $semesters): array {
                        $createdCount = 0;
                        $updatedCount = 0;

                        foreach ($semesters as $semester) {
                            $record = Semester::updateOrCreate(
                                [
                                    'academic_year_id' => $data['academic_year_id'],
                                    'semester_name' => $semester['semester_name'],
                                ],
                                [
                                    'start_date' => $semester['start_date'],
                                    'end_date' => $semester['end_date'],
                                    'is_active' => (bool) ($semester['is_active'] ?? false),
                                ],
                            );

                            $record->wasRecentlyCreated ? $createdCount++ : $updatedCount++;
                        }

                        return [$createdCount, $updatedCount];
                    });

                    Notification::make()
                        ->success()
                        ->title("បានរក្សាទុកឆមាស {$semesters->count()} កំណត់ត្រា")
                        ->body("បង្កើតថ្មី {$createdCount} និងកែប្រែ {$updatedCount}")
                        ->send();
                }),
        ];
    }
}
