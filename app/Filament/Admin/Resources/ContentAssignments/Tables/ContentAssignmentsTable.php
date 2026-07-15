<?php

namespace App\Filament\Admin\Resources\ContentAssignments\Tables;

use App\Models\ContentAssignment;
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

class ContentAssignmentsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['chapter', 'lesson.course']))
            ->columns([
                TextColumn::make('content_path')
                    ->label('View detail')
                    ->state(fn (ContentAssignment $record): string => self::contentPathHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
                TextColumn::make('due_at')
                    ->label('ផុតកំណត់')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('max_score')
                    ->label('ពិន្ទុ')
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
                    ->icon(new HtmlString('<i class="fas fa-clipboard-list" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (ContentAssignment $record): string => $record->title ?: 'Assignment preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('3xl')
                    ->modalContent(fn (ContentAssignment $record) => view('filament.admin.resources.content-assignments.preview', [
                        'record' => $record,
                        'attachmentUrl' => self::attachmentPublicUrl($record),
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
            ->defaultSort('due_at');
    }

    private static function contentPathHtml(ContentAssignment $record): string
    {
        $path = e(self::contentPathText($record));
        $title = e($record->title ?: 'Assignment');
        $course = e($record->lesson?->course?->course_name ?? '');
        $chapter = e($record->chapter?->title ?? '');

        return <<<HTML
            <div style="display:grid;gap:4px">
                <div style="font-weight:700;color:#253052">{$path}</div>
                <div style="color:#5866f5">Assignment: {$title}</div>
                <div style="color:#6b7280;font-size:12px">{$course}</div>
                <div style="color:#6b7280;font-size:12px">{$chapter}</div>
            </div>
        HTML;
    }

    private static function contentPathText(ContentAssignment $record): string
    {
        $module = $record->lesson?->module_number
            ? 'Module '.$record->lesson->module_number
            : 'Module';
        $lesson = $record->lesson?->title ?: 'Lesson';

        return $module.' > '.$lesson.' > Assignment';
    }

    private static function attachmentPublicUrl(ContentAssignment $record): ?string
    {
        $path = trim((string) $record->attachment_path);

        if ($path === '') {
            return null;
        }

        if (str_starts_with($path, 'http://') || str_starts_with($path, 'https://')) {
            return $path;
        }

        return Storage::disk('public')->url($path);
    }
}
