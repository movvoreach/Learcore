<?php

namespace App\Filament\Admin\Resources\CourseCategories\Schemas;

use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CourseCategoryForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('category_code')
                    ->label('លេខកូដប្រភេទវគ្គសិក្សា')
                    ->required()
                    ->maxLength(30)
                    ->unique(ignoreRecord: true),
                TextInput::make('category_name')
                    ->label('ឈ្មោះប្រភេទវគ្គសិក្សា')
                    ->required()
                    ->maxLength(150),
                Textarea::make('description')
                    ->label('ការពិពណ៌នា')
                    ->columnSpanFull(),
            ]);
    }
}
