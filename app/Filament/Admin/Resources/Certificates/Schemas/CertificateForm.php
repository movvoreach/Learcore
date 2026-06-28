<?php

namespace App\Filament\Admin\Resources\Certificates\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class CertificateForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('certificate_no')
                    ->label('លេខវិញ្ញាបនបត្រ')
                    ->required()
                    ->maxLength(50)
                    ->unique(ignoreRecord: true),
                Select::make('student_id')
                    ->label('និស្សិត')
                    ->relationship('student', 'first_name')
                    ->searchable(['student_code', 'first_name', 'last_name'])
                    ->preload(false)
                    ->required(),
                Select::make('course_id')
                    ->label('វគ្គសិក្សា')
                    ->relationship('course', 'course_name')
                    ->searchable()
                    ->preload(false),
                DatePicker::make('issued_date')
                    ->label('ថ្ងៃចេញវិញ្ញាបនបត្រ'),
                Select::make('status')
                    ->label('ស្ថានភាព')
                    ->options([
                        'issued' => 'បានចេញ',
                        'pending' => 'កំពុងរង់ចាំ',
                        'revoked' => 'បានដកហូត',
                    ])
                    ->default('issued')
                    ->required(),
                Textarea::make('note')
                    ->label('កំណត់សម្គាល់')
                    ->columnSpanFull(),
            ]);
    }
}
