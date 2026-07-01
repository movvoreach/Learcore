<?php

namespace App\Filament\Admin\Resources\Semesters\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SemesterForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ព័ត៌មានឆមាស')
                    ->columns(2)
                    ->schema([
                        Select::make('academic_year_id')
                            ->label('ឆ្នាំសិក្សា')
                            ->relationship('academicYear', 'year_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->placeholder('ជ្រើសរើសជម្រើសណាមួយ'),
                        TextInput::make('semester_name')
                            ->label('ឈ្មោះឆមាស')
                            ->placeholder('ឧ. ឆមាសទី ១')
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
                            ->label('កំពុងប្រើប្រាស់')
                            ->inline(false)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
