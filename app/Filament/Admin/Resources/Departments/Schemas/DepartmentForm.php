<?php

namespace App\Filament\Admin\Resources\Departments\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class DepartmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ព័ត៌មានដេប៉ាតឺម៉ង់')
                    ->columns(2)
                    ->schema([
                        Select::make('faculty_id')
                            ->label('មហាវិទ្យាល័យ')
                            ->relationship('faculty', 'faculty_name')
                            ->searchable()
                            ->preload()
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ'),
                        TextInput::make('department_code')
                            ->label('លេខកូដដេប៉ាតឺម៉ង់')
                            ->default(fn () => \App\Models\Department::generateNextDepartmentCode())
                            ->disabled()
                            ->dehydrated(true)
                            ->maxLength(30),
                        TextInput::make('department_name')
                            ->label('ឈ្មោះដេប៉ាតឺម៉ង់')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull(),
                        TextInput::make('deans')
                            ->label('ប្រធានដេប៉ាតឺម៉ង់')
                            ->maxLength(255)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
