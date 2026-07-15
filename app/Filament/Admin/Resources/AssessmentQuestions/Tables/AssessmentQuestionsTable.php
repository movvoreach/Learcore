<?php

namespace App\Filament\Admin\Resources\AssessmentQuestions\Tables;

use App\Models\AssessmentQuestion;
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

class AssessmentQuestionsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['bank.course', 'bank.subject', 'lesson'])->withCount('options'))
            ->columns([
                TextColumn::make('question_detail')
                    ->label('View detail')
                    ->state(fn (AssessmentQuestion $record): string => self::questionDetailHtml($record))
                    ->html()
                    ->searchable(['question_text'])
                    ->wrap(),
                TextColumn::make('question_type')
                    ->label('ប្រភេទ')
                    ->badge(),
                TextColumn::make('points')
                    ->label('ពិន្ទុ')
                    ->sortable(),
                TextColumn::make('options_count')
                    ->label('ជម្រើស')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('សកម្ម')
                    ->boolean(),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('View preview')
                    ->icon(new HtmlString('<i class="fas fa-list-ul" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading('Question preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('3xl')
                    ->modalContent(fn (AssessmentQuestion $record) => view('filament.admin.resources.assessment-questions.preview', [
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
            ->defaultSort('created_at', 'desc');
    }

    private static function questionDetailHtml(AssessmentQuestion $record): string
    {
        $question = e(str($record->question_text ?: 'Question')->limit(120));
        $bank = e($record->bank?->title ?? '');
        $lesson = e($record->lesson?->title ?? '');

        return <<<HTML
            <div style="display:flex;align-items:flex-start;gap:10px">
                <div style="display:grid;place-items:center;width:34px;height:34px;border-radius:6px;background:#dbeafe;color:#2563eb;font-size:17px;flex:0 0 auto">
                    <i class="fas fa-list-ul"></i>
                </div>
                <div style="display:grid;gap:4px">
                    <div style="font-weight:700;color:#253052">{$question}</div>
                    <div style="color:#5866f5">Bank: {$bank}</div>
                    <div style="color:#6b7280;font-size:12px">Lesson: {$lesson}</div>
                </div>
            </div>
        HTML;
    }
}
