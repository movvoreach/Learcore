<?php

namespace App\Filament\Admin\Resources\StudentPromotions;

use App\Filament\Admin\Resources\StudentPromotions\Pages\CreateStudentPromotion;
use App\Filament\Admin\Resources\StudentPromotions\Pages\ListStudentPromotions;
use App\Filament\Admin\Resources\StudentPromotions\Tables\StudentPromotionsTable;
use App\Models\AcademicYear;
use App\Models\Department;
use App\Models\Semester;
use App\Models\Student;
use App\Models\StudentPromotion;
use BackedEnum;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Resources\Resource;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Filament\Tables\Table;
use Illuminate\Contracts\Support\Htmlable;
use Illuminate\Support\HtmlString;

class StudentPromotionResource extends Resource
{
    protected static ?string $model = StudentPromotion::class;

    protected static bool $shouldRegisterNavigation = false;

    protected static string|BackedEnum|null $navigationIcon = null;

    protected static ?string $modelLabel = 'ការឡើងថ្នាក់';

    protected static ?string $pluralModelLabel = 'ការឡើងថ្នាក់';

    protected static string|\UnitEnum|null $navigationGroup = 'គ្រប់គ្រងនិស្សិត';

    protected static ?int $navigationSort = 30;

    public static function getNavigationIcon(): string|BackedEnum|Htmlable|null
    {
        return new HtmlString('<img src="'.e(asset('Icons/promotion.png')).'" alt="" class="fi-sidebar-item-icon" />');
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
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
                            ->options(fn (): array => self::academicYearOptions())
                            ->disabled()
                            ->dehydrated(),
                        Select::make('from_semester_id')
                            ->label('ឆមាស')
                            ->options(fn (Get $get): array => self::semesterOptions($get('from_year_id')))
                            ->disabled()
                            ->dehydrated(),
                    ]),
                Section::make('គោលដៅ')
                    ->columns(2)
                    ->schema([
                        Select::make('to_year_id')
                            ->label('ឆ្នាំសិក្សាថ្មី')
                            ->options(fn (): array => self::academicYearOptions())
                            ->searchable()
                            ->preload()
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('to_semester_id', null);
                            })
                            ->required(),
                        Select::make('to_semester_id')
                            ->label('ឆមាសថ្មី')
                            ->options(fn (Get $get): array => self::semesterOptions($get('to_year_id')))
                            ->disabled(fn (Get $get): bool => blank($get('to_year_id')))
                            ->searchable()
                            ->preload()
                            ->required(),
                        Textarea::make('note')
                            ->label('កំណត់សម្គាល់')
                            ->maxLength(1000)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

    public static function table(Table $table): Table
    {
        return StudentPromotionsTable::configure($table);
    }

    public static function getPages(): array
    {
        return [
            'index' => ListStudentPromotions::route('/'),
            'create' => CreateStudentPromotion::route('/create'),
        ];
    }

    public static function semesterOptions(mixed $academicYearId): array
    {
        if (blank($academicYearId)) {
            return [];
        }

        return Semester::query()
            ->where('academic_year_id', $academicYearId)
            ->orderBy('start_date')
            ->pluck('semester_name', 'semester_id')
            ->all();
    }

    public static function academicYearOptions(): array
    {
        return AcademicYear::query()
            ->orderByDesc('start_date')
            ->orderBy('year_name')
            ->pluck('year_name', 'academic_year_id')
            ->all();
    }
}
