<?php

namespace App\Filament\Admin\Resources\ClassRooms\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class ClassRoomForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('course_id')
                    ->label('វគ្គសិក្សា (Course)')
                    ->relationship('course', 'course_name')
                    ->getOptionLabelFromRecordUsing(fn ($record): string => trim(($record->course_code ?? '').' - '.$record->course_name, ' -'))
                    ->searchable()
                    ->preload()
                    ->required(),
                Select::make('academic_year_id')
                    ->label('ឆ្នាំសិក្សា (Academic Year)')
                    ->relationship('academicYear', 'year_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('class_code')
                    ->label('លេខកូដថ្នាក់ (Class Code)')
                    ->required(),
                TextInput::make('class_name')
                    ->label('ឈ្មោះថ្នាក់ (Class Name)')
                    ->required(),
                TextInput::make('room')
                    ->label('បន្ទប់រៀន (Room)'),
                TextInput::make('capacity')
                    ->label('សមត្ថភាព (Capacity)')
                    ->numeric()
                    ->minValue(1),
            ]);
    }
}
