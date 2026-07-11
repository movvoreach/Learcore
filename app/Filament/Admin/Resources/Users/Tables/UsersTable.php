<?php

namespace App\Filament\Admin\Resources\Users\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class UsersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->modifyQueryUsing(fn (Builder $query, $livewire): Builder => $query
                ->with(['roles'])
                ->when($livewire && isset($livewire->role_id) && $livewire->role_id, fn ($q) => $q->whereHas('roles', fn ($r) => $r->where('roles.id', $livewire->role_id)))
            )
            ->columns([
                TextColumn::make('row_number')
                    ->label('No.')
                    ->rowIndex()
                    ->alignCenter(),

                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),

                TextColumn::make('email')
                    ->label('Email')
                    ->searchable()
                    ->sortable()
                    ->copyable(),

                TextColumn::make('roles.name')
                    ->label('Roles')
                    ->badge()
                    ->separator(','),

                TextColumn::make('created_at')
                    ->label('Created At')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([])
            ->recordActions([
                EditAction::make()
                    ->label('កែសម្រួល')
                    ->successNotificationTitle('អ្នកប្រើប្រាស់ត្រូវបានកែសម្រួលដោយជោគជ័យ!'),
                DeleteAction::make()
                    ->label('លុប')
                    ->successNotificationTitle('អ្នកប្រើប្រាស់ត្រូវបានលុបដោយជោគជ័យ!'),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make()
                        ->label('លុបដែលបានជ្រើសរើស')
                        ->successNotificationTitle('អ្នកប្រើប្រាស់ដែលបានជ្រើសរើសត្រូវបានលុបដោយជោគជ័យ!'),
                ]),
            ]);
    }
}
