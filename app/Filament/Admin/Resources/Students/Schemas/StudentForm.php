<?php

namespace App\Filament\Admin\Resources\Students\Schemas;

use App\Models\Semester;
use App\Models\User;
use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class StudentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ព័ត៌មាននិស្សិត')
                    ->columns(2)
                    ->schema([
                        TextInput::make('student_code')
                            ->label('លេខកូដនិស្សិត')
                            ->placeholder('ST001')
                            ->disabled()
                            ->dehydrated(false)
                            ->maxLength(30),
                        Select::make('user_id')
                            ->label('គណនីអ្នកប្រើប្រាស់')
                            ->options(fn (): array => User::query()
                                ->orderBy('name')
                                ->pluck('name', 'id')
                                ->all())
                            ->preload()
                            ->unique(ignoreRecord: true)
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ')
                            ->visible(fn (string $operation): bool => $operation !== 'create'),
                        Select::make('department_id')
                            ->label('ដេប៉ាតឺម៉ង់')
                            ->options(fn (): array => \App\Models\Department::query()
                                ->orderBy('department_code')
                                ->get()
                                ->mapWithKeys(fn ($dept) => [$dept->department_id => $dept->department_code . ' - ' . $dept->department_name])
                                ->all())
                            ->searchable()
                            ->preload()
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ')
                            ->required(),
                        Select::make('academic_year_id')
                            ->label('ឆ្នាំសិក្សា')
                            ->relationship('academicYear', 'year_name')
                            ->preload()
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ')
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('semester_id', null);
                            })
                            ->required(),
                        Select::make('semester_id')
                            ->label('ឆមាស')
                            ->options(fn (Get $get): array => blank($get('academic_year_id'))
                                ? []
                                : Semester::query()
                                    ->where('academic_year_id', $get('academic_year_id'))
                                    ->orderBy('start_date')
                                    ->pluck('semester_name', 'semester_id')
                                    ->all())
                            ->disabled(fn (Get $get): bool => blank($get('academic_year_id')))
                            ->preload()
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ')
                            ->required(),
                        Select::make('status')
                            ->label('ស្ថានភាព')
                            ->options([
                                'active' => 'កំពុងសិក្សា',
                                'inactive' => 'ផ្អាក',
                                'graduated' => 'បញ្ចប់ការសិក្សា',
                            ])
                            ->default('active')
                            ->required(),

                        TextInput::make('first_name')
                            ->label('នាមខ្លួន')
                            ->required()
                            ->maxLength(100),
                        TextInput::make('last_name')
                            ->label('នាមត្រកូល')
                            ->maxLength(100),
                        Select::make('gender')
                            ->label('ភេទ')
                            ->options([
                                'male' => 'ប្រុស',
                                'female' => 'ស្រី',
                                'other' => 'ផ្សេងៗ',
                            ])
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ'),
                        DatePicker::make('date_of_birth')
                            ->label('ថ្ងៃខែឆ្នាំកំណើត')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        TextInput::make('phone')
                            ->label('លេខទូរស័ព្ទ')
                            ->tel()
                            ->maxLength(30),
                        TextInput::make('email')
                            ->label('អ៊ីមែល')
                            ->email()
                            ->required()
                            ->maxLength(150)
                            ->unique(ignoreRecord: true)
                            ->rules(fn (string $operation): array => $operation === 'create' ? ['unique:users,email'] : []),
                        TextInput::make('account_password')
                            ->label('ពាក្យសម្ងាត់គណនី')
                            ->password()
                            ->revealable()
                            ->required(fn (string $operation): bool => $operation === 'create')
                            ->dehydrated(fn (string $operation): bool => $operation === 'create')
                            ->minLength(8)
                            ->maxLength(255)
                            ->suffixAction(
                                Action::make('generatePassword')
                                    ->label('បង្កើត')
                                    ->icon('heroicon-o-key')
                                    ->action(function (Set $set): void {
                                        $set('account_password', Str::password(16));
                                    })
                            )
                            ->visible(fn (string $operation): bool => $operation === 'create')
                            ->columnSpanFull(),
                        Textarea::make('address')
                            ->label('អាសយដ្ឋាន')
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
