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
                ->label('Status')
                ->options([
                    'submitted' => 'Submitted',
                    'graded' => 'Graded',
                    'reviewed' => 'Reviewed',
                    'needs_revision' => 'Needs revision',
                ])
                ->required(),
            TextInput::make('score')
                ->label('Score')
                ->numeric()
                ->minValue(0),
            Textarea::make('feedback')
                ->label('Teacher Feedback')
                ->rows(5)
                ->columnSpanFull(),
            Textarea::make('response')
                ->label('Student Response')
                ->rows(8)
                ->disabled()
                ->columnSpanFull(),
            TextInput::make('attachment_url')
                ->label('Submitted Document URL')
                ->url()
                ->disabled()
                ->helperText('Use the Open file action on the submissions table to view the student document.')
                ->columnSpanFull(),
        ]);
    }
}
