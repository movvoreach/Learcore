<?php

namespace App\Filament\Admin\Resources\Users\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;
use Spatie\Permission\Models\Role;

class UserForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Section::make('ព័ត៌មានអ្នកប្រើប្រាស់')
                ->description('ព័ត៌មានគណនីជាមូលដ្ឋាន')
                ->schema([
                    TextInput::make('name')
                        ->label('ឈ្មោះពេញ')
                        ->required()
                        ->maxLength(255)
                        ->placeholder('បញ្ចូលឈ្មោះពេញ'),

                    TextInput::make('email')
                        ->label('អ៊ីមែល')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->unique(ignoreRecord: true)
                        ->placeholder('example@gmail.com'),

                    TextInput::make('password')
                        ->label('ពាក្យសម្ងាត់')
                        ->password()
                        ->revealable()
                        ->required(fn (string $operation): bool => $operation === 'create')
                        ->dehydrated(fn (?string $state): bool => filled($state))
                        ->minLength(8)
                        ->maxLength(255)
                        ->placeholder('បញ្ចូលពាក្យសម្ងាត់'),

                    Select::make('roles')
                        ->label('តួនាទី')
                        ->relationship('roles', 'name')
                        ->multiple()
                        ->options(fn (): array => Role::query()
                            ->orderBy('name')
                            ->pluck('name', 'id')
                            ->all())
                        ->preload()
                        ->searchable()
                        ->placeholder('ជ្រើសរើសតួនាទី'),
                ])
                ->columns(2)
                ->columnSpanFull(),
        ]);
    }
}
