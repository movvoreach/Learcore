<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AssignmentSubmissionForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema->components([
            Select::make('status')
                ->options([
                    'submitted' => 'Submitted',
                    'reviewed' => 'Reviewed',
                    'needs_revision' => 'Needs revision',
                ])
                ->required(),
            TextInput::make('score')
                ->numeric()
                ->minValue(0),
            Textarea::make('feedback')
                ->rows(5)
                ->columnSpanFull(),
            Textarea::make('response')
                ->rows(8)
                ->disabled()
                ->columnSpanFull(),
            TextInput::make('attachment_url')
                ->url()
                ->disabled()
                ->columnSpanFull(),
        ]);
    }
}
