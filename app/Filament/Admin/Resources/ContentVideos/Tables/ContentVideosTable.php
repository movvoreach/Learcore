<?php

namespace App\Filament\Admin\Resources\ContentVideos\Tables;

use App\Models\ContentVideo;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\HtmlString;

class ContentVideosTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['chapter', 'lesson.course']))
            ->columns([
                TextColumn::make('content_path')
                    ->label('View detail')
                    ->state(fn (ContentVideo $record): string => self::contentPathHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
                TextColumn::make('duration_seconds')
                    ->label('វិនាទី')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('ផ្សាយ')
                    ->boolean(),
            ])
            ->filters([
                SelectFilter::make('content_lesson_id')
                    ->label('មេរៀន')
                    ->relationship('lesson', 'title')
                    ->searchable()
                    ->preload(),
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                Action::make('preview')
                    ->label('View preview')
                    ->icon(new HtmlString('<i class="fas fa-play-circle" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (ContentVideo $record): string => $record->title ?: 'Video preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('5xl')
                    ->modalContent(fn (ContentVideo $record) => view('filament.admin.resources.content-videos.preview', [
                        'record' => $record,
                        'videoUrl' => self::videoPublicUrl($record),
                        'embedUrl' => self::youtubeEmbedUrl($record->video_url),
                        'contentPath' => self::contentPathText($record),
                    ])),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('កែសម្រួល'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('លុប'),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('sort_order');
    }

    private static function contentPathHtml(ContentVideo $record): string
    {
        $path = e(self::contentPathText($record));
        $title = e($record->title ?: 'Video');
        $course = e($record->lesson?->course?->course_name ?? '');
        $chapter = e($record->chapter?->title ?? '');

        return <<<HTML
            <div style="display:grid;gap:4px">
                <div style="font-weight:700;color:#253052">{$path}</div>
                <div style="color:#5866f5">Video: {$title}</div>
                <div style="color:#6b7280;font-size:12px">{$course}</div>
                <div style="color:#6b7280;font-size:12px">{$chapter}</div>
            </div>
        HTML;
    }

    private static function contentPathText(ContentVideo $record): string
    {
        $module = $record->lesson?->module_number
            ? 'Module '.$record->lesson->module_number
            : 'Module';
        $lesson = $record->lesson?->title ?: 'Lesson';

        return $module.' > '.$lesson.' > Video';
    }

    private static function videoPublicUrl(ContentVideo $record): ?string
    {
        $path = trim((string) $record->video_path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private static function youtubeEmbedUrl(?string $url): ?string
    {
        $url = trim((string) $url);

        if ($url === '') {
            return null;
        }

        if (preg_match('~(?:youtube\.com/(?:watch\?v=|embed/|shorts/)|youtu\.be/)([A-Za-z0-9_-]{6,})~', $url, $matches)) {
            return 'https://www.youtube.com/embed/'.$matches[1];
        }

        return null;
    }
}
