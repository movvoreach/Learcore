<?php

namespace App\Filament\Admin\Resources\Quizzes\Tables;

use App\Models\Quiz;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class QuizzesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['lesson.course']))
            ->columns([
                TextColumn::make('content_path')
                    ->label('View detail')
                    ->state(fn (Quiz $record): string => self::contentPathHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
                TextColumn::make('available_from')
                    ->label('ចាប់ផ្តើម')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('available_until')
                    ->label('បញ្ចប់')
                    ->dateTime()
                    ->sortable(),
                TextColumn::make('passing_score')
                    ->label('ពិន្ទុជាប់')
                    ->sortable(),
                IconColumn::make('is_published')
                    ->label('ផ្សាយ')
                    ->boolean(),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('View preview')
                    ->icon(new HtmlString('<i class="fas fa-question-circle" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (Quiz $record): string => $record->title ?: 'Quiz preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('3xl')
                    ->modalContent(fn (Quiz $record) => view('filament.admin.resources.quizzes.preview', [
                        'record' => $record,
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
            ->defaultSort('created_at', 'desc');
    }

    private static function contentPathHtml(Quiz $record): string
    {
        $path = e(self::contentPathText($record));
        $title = e($record->title ?: 'Quiz');
        $course = e($record->lesson?->course?->course_name ?? '');

        return <<<HTML
            <div style="display:grid;gap:4px">
                <div style="font-weight:700;color:#253052">{$path}</div>
                <div style="color:#5866f5">Quiz: {$title}</div>
                <div style="color:#6b7280;font-size:12px">{$course}</div>
            </div>
        HTML;
    }

    private static function contentPathText(Quiz $record): string
    {
        $module = $record->lesson?->module_number
            ? 'Module '.$record->lesson->module_number
            : 'Module';
        $lesson = $record->lesson?->title ?: 'Lesson';

        return $module.' > '.$lesson.' > Quiz';
    }
}
