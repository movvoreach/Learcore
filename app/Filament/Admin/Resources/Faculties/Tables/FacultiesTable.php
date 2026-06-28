<?php

namespace App\Filament\Admin\Resources\Faculties\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class FacultiesTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('faculty_code')
                    ->label('លេខកូដ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('faculty_name')
                    ->label('ឈ្មោះមហាវិទ្យាល័យ')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('departments_count')
                    ->label('ចំនួនដេប៉ាតឺម៉ង់')
                    ->counts('departments')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->label('បានបង្កើត')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('មហាវិទ្យាល័យត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('មហាវិទ្យាល័យត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('មហាវិទ្យាល័យដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ]);
    }
}
