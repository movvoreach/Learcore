<?php

namespace App\Filament\Admin\Resources\ContentAssignments\Schemas;

use Filament\Forms\Components\DateTimePicker;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContentAssignmentForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload(false)->default(fn (): ?int => request()->integer('content_lesson_id') ?: null)->required(),
                Select::make('content_chapter_id')->label('ជំពូក')->relationship('chapter', 'title')->searchable()->preload(false),
                TextInput::make('title')->label('ចំណងជើងកិច្ចការ')->required()->maxLength(180),
                Textarea::make('instructions')->label('សេចក្តីណែនាំ')->rows(8)->columnSpanFull(),
                FileUpload::make('attachment_path')
                    ->label('ឯកសារភ្ជាប់')
                    ->disk('public')
                    ->directory('learning/assignments')
                    ->maxSize(51200)
                    ->downloadable()
                    ->openable(),
                DateTimePicker::make('due_at')->label('ថ្ងៃផុតកំណត់'),
                TextInput::make('max_score')->label('ពិន្ទុអតិបរមា')->numeric()->default(100)->required(),
                Toggle::make('allow_late_submission')->label('អនុញ្ញាតឱ្យដាក់យឺត')->default(false),
                Toggle::make('is_published')->label('បង្ហាញសម្រាប់សិស្ស')->default(false),
            ]);
    }
}
