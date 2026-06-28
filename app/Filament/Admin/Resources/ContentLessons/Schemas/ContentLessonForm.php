<?php

namespace App\Filament\Admin\Resources\ContentLessons\Schemas;

use App\Models\ContentLesson;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\Str;

class ContentLessonForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(12)
            ->components([
                Section::make('ព័ត៌មានមេរៀន')
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        Forms\Components\Select::make('course_id')
                            ->label('វគ្គសិក្សា')
                            ->relationship('course', 'course_name')
                            ->searchable()
                            ->preload(false)
                            ->default(fn (): ?int => request()->integer('course_id') ?: null)
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state): void {
                                if (! $state) {
                                    $set('position', 1);

                                    return;
                                }

                                $nextPosition = ContentLesson::query()
                                    ->where('course_id', $state)
                                    ->max('position');

                                $set('position', ($nextPosition ?? 0) + 1);
                            })
                            ->required()
                            ->columnSpan(6),

                        Forms\Components\Select::make('content_type')
                            ->label('ប្រភេទមាតិកា')
                            ->options([
                                'lesson' => 'Lesson',
                                'page' => 'Page',
                                'video' => 'Video',
                                'file' => 'File',
                                'url' => 'URL',
                                'assignment' => 'Assignment',
                                'quiz' => 'Quiz',
                                'forum' => 'Forum',
                            ])
                            ->default('lesson')
                            ->live()
                            ->afterStateUpdated(function (Set $set): void {
                                $set('external_url', null);
                                $set('video_url', null);
                                $set('file_path', null);
                                $set('max_score', null);
                                $set('passing_score', null);
                            })
                            ->required()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('position')
                            ->label('លេខមេរៀន')
                            ->numeric()
                            ->default(1)
                            ->readOnly()
                            ->required()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('module_number')
                            ->label('លេខម៉ូឌុល')
                            ->numeric()
                            ->default(1)
                            ->required()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('module_title')
                            ->label('ចំណងជើងម៉ូឌុល')
                            ->maxLength(255)
                            ->columnSpan(9),

                        Forms\Components\TextInput::make('title')
                            ->label('ចំណងជើងមេរៀន')
                            ->required()
                            ->live(onBlur: true)
                            ->afterStateUpdated(function (Set $set, ?string $state): void {
                                $slug = Str::slug($state ?? '');

                                $set('slug', filled($slug) ? $slug : 'lesson-'.Str::random(8));
                            })
                            ->maxLength(255)
                            ->columnSpan(8),

                        Forms\Components\TextInput::make('slug')
                            ->label('Slug')
                            ->required()
                            ->unique(ignoreRecord: true)
                            ->maxLength(255)
                            ->columnSpan(4),
                    ]),

                Section::make('មាតិកាមេរៀន')
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        Forms\Components\Textarea::make('summary')
                            ->label('សេចក្ដីសង្ខេប')
                            ->rows(3)
                            ->columnSpanFull(),

                        Forms\Components\RichEditor::make('body')
                            ->label(fn (Get $get): string => match ($get('content_type')) {
                                'page' => 'ខ្លឹមសារទំព័រ',
                                'assignment' => 'សេចក្ដីណែនាំកិច្ចការ',
                                'quiz' => 'សេចក្ដីណែនាំសំណួរ',
                                'forum' => 'ប្រធានបទពិភាក្សា',
                                default => 'ខ្លឹមសារមេរៀន',
                            })
                            ->visible(fn (Get $get): bool => in_array($get('content_type'), ['lesson', 'page', 'assignment', 'quiz', 'forum'], true))
                            ->columnSpanFull(),

                        Forms\Components\TextInput::make('external_url')
                            ->label('External URL')
                            ->url()
                            ->maxLength(255)
                            ->required(fn (Get $get): bool => $get('content_type') === 'url')
                            ->visible(fn (Get $get): bool => $get('content_type') === 'url')
                            ->columnSpan(8),

                        Forms\Components\TextInput::make('video_url')
                            ->label('Video URL')
                            ->url()
                            ->maxLength(255)
                            ->visible(fn (Get $get): bool => $get('content_type') === 'video')
                            ->columnSpan(8),

                        Forms\Components\FileUpload::make('file_path')
                            ->label(fn (Get $get): string => $get('content_type') === 'video' ? 'Upload Video' : 'ឯកសារ / File')
                            ->disk('public')
                            ->directory(fn (Get $get): string => match ($get('content_type')) {
                                'video' => 'learning/videos',
                                'assignment' => 'learning/assignments',
                                'quiz' => 'learning/quizzes',
                                default => 'learning/files',
                            })
                            ->acceptedFileTypes(fn (Get $get): array => match ($get('content_type')) {
                                'video' => ['video/mp4', 'video/webm', 'video/quicktime'],
                                default => [
                                    'application/pdf',
                                    'application/msword',
                                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
                                    'application/vnd.ms-powerpoint',
                                    'application/vnd.openxmlformats-officedocument.presentationml.presentation',
                                    'application/zip',
                                ],
                            })
                            ->maxSize(fn (Get $get): int => $get('content_type') === 'video' ? 512000 : 51200)
                            ->downloadable()
                            ->openable()
                            ->visible(fn (Get $get): bool => in_array($get('content_type'), ['file', 'video', 'assignment', 'quiz'], true))
                            ->columnSpan(8),

                        Forms\Components\TextInput::make('duration_minutes')
                            ->label('រយៈពេល (នាទី)')
                            ->numeric()
                            ->visible(fn (Get $get): bool => in_array($get('content_type'), ['lesson', 'page', 'video'], true))
                            ->columnSpan(4),
                    ]),

                Section::make('ការកំណត់')
                    ->columnSpanFull()
                    ->columns(12)
                    ->schema([
                        Forms\Components\Select::make('visibility')
                            ->label('ការបង្ហាញ')
                            ->options([
                                'visible' => 'បង្ហាញ',
                                'hidden' => 'លាក់',
                                'scheduled' => 'កំណត់ពេល',
                            ])
                            ->default('visible')
                            ->required()
                            ->columnSpan(4),

                        Forms\Components\DateTimePicker::make('available_from')
                            ->label('ចាប់ផ្តើម')
                            ->visible(fn (Get $get): bool => $get('visibility') === 'scheduled')
                            ->columnSpan(4),

                        Forms\Components\DateTimePicker::make('available_until')
                            ->label('បញ្ចប់')
                            ->visible(fn (Get $get): bool => $get('visibility') === 'scheduled')
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('max_score')
                            ->label('ពិន្ទុសរុប')
                            ->numeric()
                            ->visible(fn (Get $get): bool => in_array($get('content_type'), ['assignment', 'quiz'], true))
                            ->columnSpan(4),

                        Forms\Components\TextInput::make('passing_score')
                            ->label('ពិន្ទុជាប់')
                            ->numeric()
                            ->visible(fn (Get $get): bool => in_array($get('content_type'), ['assignment', 'quiz'], true))
                            ->columnSpan(4),

                        Forms\Components\Toggle::make('completion_required')
                            ->label('តម្រូវឲ្យបញ្ចប់')
                            ->default(false)
                            ->columnSpan(3),

                        Forms\Components\Toggle::make('allow_comments')
                            ->label('អនុញ្ញាតមតិយោបល់')
                            ->default(false)
                            ->columnSpan(3),

                        Forms\Components\Toggle::make('is_published')
                            ->label('បង្ហាញសម្រាប់សិស្ស')
                            ->default(true)
                            ->columnSpan(3),
                    ]),
            ]);
    }
}
