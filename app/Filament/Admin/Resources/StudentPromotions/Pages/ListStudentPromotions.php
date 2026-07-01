<?php

namespace App\Filament\Admin\Resources\StudentPromotions\Pages;

use App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource;
use App\Models\Department;
use App\Models\Student;
use App\Models\StudentPromotion;
use App\Services\StudentPromotionService;
use Filament\Actions\Action;
use Filament\Actions\CreateAction;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Support\Enums\Width;
use Illuminate\Support\Facades\DB;

class ListStudentPromotions extends ListRecords
{
    protected static string $resource = StudentPromotionResource::class;

    public function mount(): void
    {
        parent::mount();

        if (request()->boolean('openPromotionModal')) {
            $this->defaultAction = 'create';
        }
    }

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make()
                ->modalHeading('ដំឡើងឆមាសនិស្សិត')
                ->modalDescription('ជ្រើសនិស្សិតម្នាក់ ហើយកំណត់ឆ្នាំសិក្សា និងឆមាសគោលដៅ។')
                ->modalSubmitActionLabel('ដំឡើងឆមាស')
                ->modalWidth(Width::SevenExtraLarge)
                ->createAnother(false)
                ->form([
                    Section::make('ជ្រើសរើសនិស្សិត')
                        ->schema([
                            Select::make('student_id')
                                ->label('និស្សិត')
                                ->options(fn (): array => Student::query()
                                    ->orderBy('student_code')
                                    ->get()
                                    ->mapWithKeys(fn (Student $student): array => [
                                        $student->student_id => trim($student->student_code.' - '.$student->first_name.' '.$student->last_name),
                                    ])
                                    ->all())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set, ?int $state): void {
                                    $student = $state ? Student::query()->find($state) : null;

                                    $set('from_department_id', $student?->department_id);
                                    $set('from_year_id', $student?->academic_year_id);
                                    $set('from_semester_id', $student?->semester_id);
                                })
                                ->required(),
                        ]),
                    Section::make('ព័ត៌មានបច្ចុប្បន្ន')
                        ->columns(3)
                        ->schema([
                            Select::make('from_department_id')
                                ->label('ដេប៉ាតឺម៉ង់')
                                ->options(fn (): array => Department::query()
                                    ->orderBy('department_name')
                                    ->pluck('department_name', 'department_id')
                                    ->all())
                                ->disabled()
                                ->dehydrated(),
                            Select::make('from_year_id')
                                ->label('ឆ្នាំសិក្សា')
                                ->options(fn (): array => StudentPromotionResource::academicYearOptions())
                                ->disabled()
                                ->dehydrated(),
                            Select::make('from_semester_id')
                                ->label('ឆមាស')
                                ->options(fn (Get $get): array => StudentPromotionResource::semesterOptions($get('from_year_id')))
                                ->disabled()
                                ->dehydrated(),
                        ]),
                    Section::make('គោលដៅ')
                        ->columns(2)
                        ->schema([
                            Select::make('to_year_id')
                                ->label('ឆ្នាំសិក្សាថ្មី')
                                ->options(fn (): array => StudentPromotionResource::academicYearOptions())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set): void {
                                    $set('to_semester_id', null);
                                })
                                ->required(),
                            Select::make('to_semester_id')
                                ->label('ឆមាសថ្មី')
                                ->options(fn (Get $get): array => StudentPromotionResource::semesterOptions($get('to_year_id')))
                                ->disabled(fn (Get $get): bool => blank($get('to_year_id')))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Textarea::make('note')
                                ->label('កំណត់សម្គាល់')
                                ->maxLength(1000)
                                ->columnSpanFull(),
                        ]),
                ])
                ->using(function (array $data): StudentPromotion {
                    return app(StudentPromotionService::class)->promote(
                        Student::query()->findOrFail($data['student_id']),
                        (int) $data['to_year_id'],
                        (int) $data['to_semester_id'],
                        $data['note'] ?? null,
                    );
                })
                ->successNotificationTitle('បានដំឡើងឆមាសនិស្សិត')
                ->label('ដំឡើងឆមាសនិស្សិត'),
            Action::make('promote_group')
                ->label('ដំឡើងឆមាសជាក្រុម')
                ->modalHeading('ដំឡើងឆមាសជាក្រុម')
                ->modalDescription('ប្រព័ន្ធនឹងដំឡើងឆមាសនិស្សិតទាំងអស់ដែលត្រូវនឹងលក្ខខណ្ឌដើម។ មាតិកាវគ្គសិក្សា មេរៀន មុខវិជ្ជា និងម៉ូឌុល មិនត្រូវបានផ្លាស់ប្តូរទេ។')
                ->modalWidth(Width::SevenExtraLarge)
                ->form([
                    Section::make('ពី')
                        ->columns(3)
                        ->schema([
                            Select::make('from_department_id')
                                ->label('ដេប៉ាតឺម៉ង់')
                                ->options(fn (): array => Department::query()
                                    ->orderBy('department_name')
                                    ->pluck('department_name', 'department_id')
                                    ->all())
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('from_year_id')
                                ->label('ឆ្នាំសិក្សា')
                                ->options(fn (): array => StudentPromotionResource::academicYearOptions())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set): void {
                                    $set('from_semester_id', null);
                                })
                                ->required(),
                            Select::make('from_semester_id')
                                ->label('ឆមាស')
                                ->options(fn (Get $get): array => StudentPromotionResource::semesterOptions($get('from_year_id')))
                                ->disabled(fn (Get $get): bool => blank($get('from_year_id')))
                                ->searchable()
                                ->preload()
                                ->required(),
                        ]),
                    Section::make('ទៅ')
                        ->columns(2)
                        ->schema([
                            Select::make('to_year_id')
                                ->label('ឆ្នាំសិក្សាថ្មី')
                                ->options(fn (): array => StudentPromotionResource::academicYearOptions())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set): void {
                                    $set('to_semester_id', null);
                                })
                                ->required(),
                            Select::make('to_semester_id')
                                ->label('ឆមាសថ្មី')
                                ->options(fn (Get $get): array => StudentPromotionResource::semesterOptions($get('to_year_id')))
                                ->disabled(fn (Get $get): bool => blank($get('to_year_id')))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Textarea::make('note')
                                ->label('កំណត់សម្គាល់')
                                ->maxLength(1000)
                                ->columnSpanFull(),
                        ]),
                ])
                ->requiresConfirmation()
                ->action(function (array $data): void {
                    $promotedCount = DB::transaction(function () use ($data): int {
                        $students = Student::query()
                            ->where('department_id', $data['from_department_id'])
                            ->where('academic_year_id', $data['from_year_id'])
                            ->where('semester_id', $data['from_semester_id'])
                            ->get();

                        foreach ($students as $student) {
                            app(StudentPromotionService::class)->promote(
                                $student,
                                (int) $data['to_year_id'],
                                (int) $data['to_semester_id'],
                                $data['note'] ?? null,
                            );
                        }

                        return $students->count();
                    });

                    Notification::make()
                        ->success()
                        ->title("បានដំឡើងឆមាសនិស្សិត {$promotedCount} នាក់")
                        ->send();
                }),
            Action::make('promote_group_to_next')
                ->label('Promote Group Next')
                ->modalHeading('Promote Group to Next Semester')
                ->modalDescription('Promotes every matching active student to the next semester in sequence while preserving academic history.')
                ->modalWidth(Width::SevenExtraLarge)
                ->form([
                    Section::make('Current placement')
                        ->columns(3)
                        ->schema([
                            Select::make('from_department_id')
                                ->label('Department')
                                ->options(fn (): array => Department::query()
                                    ->orderBy('department_name')
                                    ->pluck('department_name', 'department_id')
                                    ->all())
                                ->searchable()
                                ->preload()
                                ->required(),
                            Select::make('from_year_id')
                                ->label('Academic Year')
                                ->options(fn (): array => StudentPromotionResource::academicYearOptions())
                                ->searchable()
                                ->preload()
                                ->live()
                                ->afterStateUpdated(function (Set $set): void {
                                    $set('from_semester_id', null);
                                })
                                ->required(),
                            Select::make('from_semester_id')
                                ->label('Semester')
                                ->options(fn (Get $get): array => StudentPromotionResource::semesterOptions($get('from_year_id')))
                                ->disabled(fn (Get $get): bool => blank($get('from_year_id')))
                                ->searchable()
                                ->preload()
                                ->required(),
                            Textarea::make('note')
                                ->label('Note')
                                ->default('Automatic next-semester bulk promotion')
                                ->maxLength(1000)
                                ->columnSpanFull(),
                        ]),
                ])
                ->requiresConfirmation()
                ->action(function (array $data): void {
                    $students = Student::query()
                        ->where('department_id', $data['from_department_id'])
                        ->where('academic_year_id', $data['from_year_id'])
                        ->where('semester_id', $data['from_semester_id'])
                        ->where('status', 'active')
                        ->get();

                    foreach ($students as $student) {
                        app(StudentPromotionService::class)->promoteToNext($student, $data['note'] ?? null);
                    }

                    Notification::make()
                        ->success()
                        ->title("Promoted {$students->count()} students to the next semester")
                        ->send();
                }),
        ];
    }
}
