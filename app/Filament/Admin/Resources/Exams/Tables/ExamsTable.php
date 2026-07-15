<?php

namespace App\Filament\Admin\Resources\Exams\Tables;

use App\Models\Exam;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\HtmlString;

class ExamsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course', 'subject']))
            ->columns([
                TextColumn::make('exam_detail')
                    ->label('View detail')
                    ->state(fn (Exam $record): string => self::examDetailHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
                TextColumn::make('exam_date')
                    ->label('កាលបរិច្ឆេទ')
                    ->date()
                    ->sortable(),
                TextColumn::make('start_time')
                    ->label('ចាប់ផ្តើម'),
                TextColumn::make('status')
                    ->label('ស្ថានភាព')
                    ->badge()
                    ->sortable(),
                TextColumn::make('total_score')
                    ->label('ពិន្ទុសរុប')
                    ->sortable(),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('View preview')
                    ->icon(new HtmlString('<i class="fas fa-pen-square" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (Exam $record): string => $record->title ?: 'Exam preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('3xl')
                    ->modalContent(fn (Exam $record) => view('filament.admin.resources.exams.preview', [
                        'record' => $record,
                    ])),
                EditAction::make()
                    ->iconButton()
                    ->tooltip('កែសម្រួល'),
                DeleteAction::make()
                    ->iconButton()
                    ->tooltip('លុប'),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->defaultSort('exam_date', 'desc');
    }

    private static function examDetailHtml(Exam $record): string
    {
        $title = e($record->title ?: 'Exam');
        $course = e($record->course?->course_name ?? '');
        $subject = e($record->subject?->subject_name ?? '');

        return <<<HTML
            <div style="display:flex;align-items:flex-start;gap:10px">
                <div style="display:grid;place-items:center;width:34px;height:34px;border-radius:6px;background:#ede9fe;color:#7c3aed;font-size:17px;flex:0 0 auto">
                    <i class="fas fa-pen-square"></i>
                </div>
                <div style="display:grid;gap:4px">
                    <div style="font-weight:700;color:#253052">Exam > {$title}</div>
                    <div style="color:#5866f5">{$course}</div>
                    <div style="color:#6b7280;font-size:12px">{$subject}</div>
                </div>
            </div>
        HTML;
    }
}
