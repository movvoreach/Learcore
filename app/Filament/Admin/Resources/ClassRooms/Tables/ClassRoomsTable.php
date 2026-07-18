<?php

namespace App\Filament\Admin\Resources\ClassRooms\Tables;

use App\Filament\Admin\Resources\ClassRooms\ClassRoomResource;
use App\Models\ClassRoom;
use Filament\Actions\Action;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ClassRoomsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('class_code')
                    ->label('Class Code')
                    ->searchable(),
                TextColumn::make('class_name')
                    ->label('Class Name')
                    ->searchable(),
                TextColumn::make('table')
                    ->label('Table')
                    ->searchable(),
                TextColumn::make('status')
                    ->label('Status')
                    ->badge()
                    ->color(fn (string $state): string => $state === 'active' ? 'success' : 'gray')
                    ->sortable(),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                Action::make('view_members')
                    ->label('View students')
                    ->icon(Heroicon::OutlinedUsers)
                    ->color('info')
                    ->url(fn (ClassRoom $record): string => ClassRoomResource::getUrl('view', ['record' => $record])),
                EditAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }
}
