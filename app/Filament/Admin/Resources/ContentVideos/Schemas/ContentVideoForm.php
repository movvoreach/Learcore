<?php

namespace App\Filament\Admin\Resources\ContentVideos\Schemas;

use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Schema;

class ContentVideoForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Select::make('content_lesson_id')->label('មេរៀន')->relationship('lesson', 'title')->searchable()->preload()->default(fn (): ?int => request()->integer('content_lesson_id') ?: null)->required(),
                Select::make('content_chapter_id')->label('ជំពូក')->relationship('chapter', 'title')->searchable()->preload(),
                TextInput::make('title')->label('ចំណងជើងវីដេអូ')->required()->maxLength(180),
                Textarea::make('description')->label('ការពិពណ៌នា')->columnSpanFull(),
                FileUpload::make('video_path')
                    ->label('ឯកសារវីដេអូ')
                    ->disk('public')
                    ->directory('learning/videos')
                    ->acceptedFileTypes(['video/mp4', 'video/webm', 'video/quicktime'])
                    ->maxSize(512000)
                    ->downloadable()
                    ->openable(),
                TextInput::make('video_url')->label('តំណវីដេអូ')->url()->maxLength(255),
                TextInput::make('duration_seconds')->label('រយៈពេលវិនាទី')->numeric(),
                TextInput::make('sort_order')->label('លំដាប់')->numeric()->default(0)->required(),
                Toggle::make('is_published')->label('បង្ហាញសម្រាប់សិស្ស')->default(false),
            ]);
    }
}
