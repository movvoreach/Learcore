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
                TextInput::make('class_name')
                    ->label('Class Name')
                    ->required()
                    ->maxLength(150),
                TextInput::make('table')
                    ->label('Table')
                    ->maxLength(255),
                Select::make('status')
                    ->label('Status')
                    ->options([
                        'active' => 'Active',
                        'inactive' => 'Inactive',
                    ])
                    ->default('active')
                    ->required(),
            ]);
    }
}
