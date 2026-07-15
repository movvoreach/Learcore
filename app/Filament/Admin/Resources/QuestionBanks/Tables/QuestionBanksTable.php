<?php

namespace App\Filament\Admin\Resources\QuestionBanks\Tables;

use App\Models\QuestionBank;
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

class QuestionBanksTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query): Builder => $query->with(['course', 'subject'])->withCount('questions'))
            ->columns([
                TextColumn::make('bank_detail')
                    ->label('View detail')
                    ->state(fn (QuestionBank $record): string => self::bankDetailHtml($record))
                    ->html()
                    ->searchable(['title'])
                    ->wrap(),
                TextColumn::make('questions_count')
                    ->label('សំណួរ')
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('សកម្ម')
                    ->boolean(),
            ])
            ->recordActions([
                Action::make('preview')
                    ->label('View preview')
                    ->icon(new HtmlString('<i class="fas fa-database" style="font-size:20px"></i>'))
                    ->color('info')
                    ->iconButton()
                    ->tooltip('View preview')
                    ->modalHeading(fn (QuestionBank $record): string => $record->title ?: 'Question bank preview')
                    ->modalSubmitAction(false)
                    ->modalCancelActionLabel('Close')
                    ->modalWidth('3xl')
                    ->modalContent(fn (QuestionBank $record) => view('filament.admin.resources.question-banks.preview', [
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

    private static function bankDetailHtml(QuestionBank $record): string
    {
        $title = e($record->title ?: 'Question bank');
        $course = e($record->course?->course_name ?? '');
        $subject = e($record->subject?->subject_name ?? '');

        return <<<HTML
            <div style="display:flex;align-items:flex-start;gap:10px">
                <div style="display:grid;place-items:center;width:34px;height:34px;border-radius:6px;background:#cffafe;color:#0891b2;font-size:17px;flex:0 0 auto">
                    <i class="fas fa-database"></i>
                </div>
                <div style="display:grid;gap:4px">
                    <div style="font-weight:700;color:#253052">Question Bank > {$title}</div>
                    <div style="color:#5866f5">{$course}</div>
                    <div style="color:#6b7280;font-size:12px">{$subject}</div>
                </div>
            </div>
        HTML;
    }
}
