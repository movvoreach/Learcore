<?php

namespace App\Filament\Admin\Resources\CourseModules\Schemas;

use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class CourseModuleForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('Module Information')
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('Course')
                            ->relationship('course', 'course_name')
                            ->searchable()
                            ->preload()
                            ->required()
                            ->live(onBlur: true)
                            ->columnSpan(6),

                        Forms\Components\TextInput::make('module_number')
                            ->label('Module Number')
                            ->numeric()
                            ->helperText('Leave empty to auto generate inside the selected course.')
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('title')
                            ->label('Title')
                            ->required()
                            ->maxLength(255)
                            ->columnSpan(9),

                        Forms\Components\Textarea::make('description')
                            ->label('Description')
                            ->rows(4)
                            ->columnSpanFull(),
                    ]),
            ]);
    }

}
