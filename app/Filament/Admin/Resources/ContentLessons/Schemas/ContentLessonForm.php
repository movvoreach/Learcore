<?php

namespace App\Filament\Admin\Resources\ContentLessons\Schemas;

use App\Models\CourseModule;
use Filament\Forms;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Components\Utilities\Get;
use Filament\Schemas\Components\Utilities\Set;
use Filament\Schemas\Schema;
use Illuminate\Support\HtmlString;
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
                            ->preload()
                            ->default(fn (): ?int => request()->integer('course_id') ?: null)
                            ->required()
                            ->columnSpan(6),

                        Forms\Components\Select::make('course_module_id')
                            ->label('Module')
                            ->options(fn (): array => CourseModule::query()
                                ->with('course')
                                ->orderBy('course_id')
                                ->orderBy('module_number')
                                ->get()
                                ->mapWithKeys(fn (CourseModule $module): array => [
                                    $module->course_module_id => trim(($module->course?->course_name ?? 'Course').' / Module '.$module->module_number.' - '.$module->title),
                                ])
                                ->all())
                            ->searchable()
                            ->preload()
                            ->createOptionForm([
                                Forms\Components\Select::make('course_id')
                                    ->label('វគ្គសិក្សា')
                                    ->relationship('course', 'course_name')
                                    ->required()
                                    ->preload()
                                    ->searchable(),
                                Forms\Components\TextInput::make('title')
                                    ->label('ចំណងជើងម៉ូឌុល')
                                    ->required()
                                    ->maxLength(255),
                                Forms\Components\TextInput::make('module_number')
                                    ->label('លេខម៉ូឌុល')
                                    ->numeric()
                                    ->placeholder('ទុកឲ្យទទេសម្រាប់ការកើនឡើងស្វ័យប្រវត្តិ (Auto-increment)'),
                                Forms\Components\Textarea::make('description')
                                    ->label('ការពិពណ៌នា')
                                    ->rows(3),
                            ])
                            ->createOptionUsing(function (array $data): int {
                                $module = CourseModule::create($data);
                                return $module->course_module_id;
                            })
                            ->default(fn (): ?int => request()->integer('course_module_id') ?: null)
                            ->live()
                            ->afterStateUpdated(function (Set $set, ?int $state): void {
                                if (! $state) {
                                    return;
                                }

                                $module = CourseModule::query()->find($state);

                                if (! $module) {
                                    return;
                                }

                                $set('course_id', $module->course_id);
                                $set('module_number', $module->module_number);
                                $set('module_title', $module->title);
                                $set('position', self::nextLessonNumber($module->course_module_id));
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
                            ->readOnly()
                            ->columnSpan(3),

                        Forms\Components\TextInput::make('module_title')
                            ->label('ចំណងជើងម៉ូឌុល')
                            ->maxLength(255)
                            ->readOnly()
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
                            ->toolbarButtons([
                                'bold',
                                'italic',
                                'underline',
                                'strike',
                                'link',
                                'textColor',
                                'highlight',
                                'h1',
                                'h2',
                                'h3',
                                'paragraph',
                                'alignStart',
                                'alignCenter',
                                'alignEnd',
                                'alignJustify',
                                'blockquote',
                                'codeBlock',
                                'bulletList',
                                'orderedList',
                                'table',
                                'attachFiles',
                                'horizontalRule',
                                'undo',
                                'redo',
                            ])
                            ->fileAttachmentsDirectory('learning/editor')
                            ->fileAttachmentsDisk('public')
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

                        Forms\Components\Placeholder::make('video_upload_note')
                            ->label('')
                            ->content(fn (): HtmlString => new HtmlString('
                                <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:12px;margin-top:2px">
                                    <div style="display:flex;gap:12px;align-items:center;border:1px solid #bbf7d0;background:#f0fdf4;border-radius:6px;padding:12px">
                                        <img src="'.e(asset('backend/img/video.png')).'" alt="Video" style="width:48px;height:48px;object-fit:contain;flex:0 0 auto">
                                        <div style="line-height:1.65">
                                            <strong style="display:block;color:#166534">Upload Video</strong>
                                            <span style="color:#365f45">សូម Upload តែឯកសារវីដេអូប៉ុណ្ណោះ៖ .mp4, .webm, .mov។ ទំហំអតិបរមា 500MB។</span>
                                        </div>
                                    </div>
                                    <div style="display:flex;gap:12px;align-items:center;border:1px solid #fecaca;background:#fff1f2;border-radius:6px;padding:12px">
                                        <img src="'.e(asset('backend/img/doc.png')).'" alt="Document" style="width:48px;height:48px;object-fit:contain;flex:0 0 auto">
                                        <div style="line-height:1.65">
                                            <strong style="display:block;color:#991b1b">Do not upload document</strong>
                                            <span style="color:#7f1d1d">កុំ Upload ឯកសារ PDF, Word, PowerPoint, ZIP ឬរូបភាព នៅពេលជ្រើសរើសប្រភេទ Video។</span>
                                        </div>
                                    </div>
                                </div>
                            '))
                            ->visible(fn (Get $get): bool => $get('content_type') === 'video')
                            ->columnSpanFull(),

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
                            ->placeholder(fn (Get $get): ?string => $get('content_type') === 'video'
                                ? '<div class="lc-upload-placeholder">
                                    <span class="lc-upload-icon"><i class="fa fa-download"></i></span>
                                    <span class="lc-upload-title"><span class="filepond--label-action">Choose a file</span> or drag it here.</span>
                                    <span class="lc-upload-note">អនុញ្ញាតតែ .mp4, .webm, .mov | អតិបរមា 500MB</span>
                                </div>'
                                : null)
                            ->panelLayout(fn (Get $get): string => $get('content_type') === 'video' ? 'integrated' : 'compact')
                            ->imagePreviewHeight(fn (Get $get): ?string => $get('content_type') === 'video' ? '120px' : null)
                            ->uploadingMessage('កំពុង Upload...')
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
                            ->live()
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

    private static function nextLessonNumber(int $courseModuleId): int
    {
        return ((int) CourseModule::query()
            ->find($courseModuleId)
            ?->lessons()
            ->max('position')) + 1;
    }
}
