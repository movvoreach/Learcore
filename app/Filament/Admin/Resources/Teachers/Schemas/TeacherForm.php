<?php

namespace App\Filament\Admin\Resources\Teachers\Schemas;

use Filament\Actions\Action;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class TeacherForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('teacher_code')
                    ->label('លេខកូដគ្រូ')
                    ->placeholder('TC001')
                    ->disabled()
                    ->dehydrated(false)
                    ->maxLength(30),
                Select::make('department_id')
                    ->label('ដេប៉ាតឺម៉ង់')
                    ->relationship('department', 'department_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('employment_type')
                    ->label('ប្រភេទការងារ')
                    ->options([
                        'full_time' => 'ពេញម៉ោង',
                        'part_time' => 'ក្រៅម៉ោង',
                    ])
                    ->default('full_time')
                    ->searchable()
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
                    ]),
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
                    ->visible(fn (string $operation): bool => $operation === 'create'),
                TextInput::make('specialization')
                    ->label('ជំនាញ')
                    ->maxLength(150),
                DatePicker::make('hire_date')
                    ->label('ថ្ងៃចូលធ្វើការ')
                    ->native(false)
                    ->displayFormat('d/m/Y'),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'active' => 'កំពុងបង្រៀន',
                        'inactive' => 'ផ្អាក',
                        'resigned' => 'លាឈប់',
                    ])
                    ->default('active')
                    ->required(),
                Textarea::make('address')
                    ->label('អាសយដ្ឋាន')
                    ->columnSpanFull(),
            ]);
    }
}
