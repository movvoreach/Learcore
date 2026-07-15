<?php

namespace App\Filament\Admin\Resources\ContentDocuments\Tables;

use App\Models\ContentDocument;
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

class ContentDocumentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['chapter', 'lesson.course']))
            ->columns([
                TextColumn::make('content_path')
                    ->label('View detail')
                    ->state(fn (ContentDocument $record): string => self::contentPathHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
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
                    ->icon(new HtmlString('<i class="fas fa-file-pdf" style="font-size:20px"></i>'))
                    ->color('danger')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (ContentDocument $record): string => $record->title ?: 'Document preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('5xl')
                    ->modalContent(fn (ContentDocument $record) => view('filament.admin.resources.content-documents.preview', [
                        'record' => $record,
                        'documentUrl' => self::documentPublicUrl($record),
                        'canPreview' => self::canPreviewDocument($record),
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

    private static function contentPathHtml(ContentDocument $record): string
    {
        $path = e(self::contentPathText($record));
        $title = e($record->title ?: 'Document');
        $course = e($record->lesson?->course?->course_name ?? '');
        $chapter = e($record->chapter?->title ?? '');

        return <<<HTML
            <div style="display:grid;gap:4px">
                <div style="font-weight:700;color:#253052">{$path}</div>
                <div style="color:#5866f5">Document: {$title}</div>
                <div style="color:#6b7280;font-size:12px">{$course}</div>
                <div style="color:#6b7280;font-size:12px">{$chapter}</div>
            </div>
        HTML;
    }

    private static function contentPathText(ContentDocument $record): string
    {
        $module = $record->lesson?->module_number
            ? 'Module '.$record->lesson->module_number
            : 'Module';
        $lesson = $record->lesson?->title ?: 'Lesson';

        return $module.' > '.$lesson.' > Document';
    }

    private static function documentPublicUrl(ContentDocument $record): ?string
    {
        $path = trim((string) $record->file_path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }

    private static function canPreviewDocument(ContentDocument $record): bool
    {
        $path = parse_url((string) $record->file_path, PHP_URL_PATH) ?: (string) $record->file_path;

        return strtolower(pathinfo($path, PATHINFO_EXTENSION)) === 'pdf';
    }
}
