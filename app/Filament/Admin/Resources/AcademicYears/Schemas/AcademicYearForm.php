<?php

namespace App\Filament\Admin\Resources\AcademicYears\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class AcademicYearForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ព័ត៌មានឆ្នាំសិក្សា')
                    ->columns(2)
                    ->schema([
                        TextInput::make('year_name')
                            ->label('ឆ្នាំសិក្សា')
                            ->placeholder('ឧ. 2026-2027')
                            ->required()
                            ->maxLength(50)
                            ->unique(ignoreRecord: true),
                        Toggle::make('is_active')
                            ->label('កំពុងប្រើប្រាស់')
                            ->inline(false),
                        DatePicker::make('start_date')
                            ->label('ថ្ងៃចាប់ផ្តើម')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                        DatePicker::make('end_date')
                            ->label('ថ្ងៃបញ្ចប់')
                            ->native(false)
                            ->displayFormat('d/m/Y'),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
