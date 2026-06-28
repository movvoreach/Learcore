<?php

namespace App\Filament\Admin\Resources\AcademicYears\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AcademicYearsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('year_name')
                    ->label('ឆ្នាំសិក្សា')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('start_date')
                    ->label('ថ្ងៃចាប់ផ្តើម')
                    ->date()
                    ->sortable(),
                TextColumn::make('end_date')
                    ->label('ថ្ងៃបញ្ចប់')
                    ->date()
                    ->sortable(),
                IconColumn::make('is_active')
                    ->label('កំពុងប្រើប្រាស់')
                    ->boolean(),
            ])
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('ឆ្នាំសិក្សាត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('ឆ្នាំសិក្សាត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('ឆ្នាំសិក្សាដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ])
            ->defaultSort('created_at', 'desc');
    }
}
