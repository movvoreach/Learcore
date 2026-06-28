<?php

namespace App\Filament\Admin\Resources\Faculties\Schemas;

use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class FacultyForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Section::make('ព័ត៌មានមហាវិទ្យាល័យ')
                    ->columns(2)
                    ->schema([
                        TextInput::make('faculty_code')
                            ->label('លេខកូដមហាវិទ្យាល័យ')
                            ->placeholder('បង្កើតដោយស្វ័យប្រវត្តិ')
                            ->disabled()
                            ->dehydrated(false)
                            ->columnSpanFull()
                            ->maxLength(30),
                        TextInput::make('faculty_name')
                            ->label('ឈ្មោះមហាវិទ្យាល័យ')
                            ->required()
                            ->maxLength(150)
                            ->columnSpanFull(),
                    ])
                    ->columnSpanFull(),
            ]);
    }
}
