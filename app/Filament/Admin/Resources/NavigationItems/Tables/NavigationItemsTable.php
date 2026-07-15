<?php

namespace App\Filament\Admin\Resources\NavigationItems\Tables;

use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class NavigationItemsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('group.name')->label('Group')->sortable(),
                TextColumn::make('parent.title')->label('Parent')->placeholder('-'),
                TextColumn::make('title')->label('Title')->searchable()->sortable(),
                TextColumn::make('page.title')->label('Page')->placeholder('-'),
                TextColumn::make('url')->label('URL')->limit(40)->placeholder('-'),
                TextColumn::make('sort_order')->label('Order')->sortable(),
                IconColumn::make('is_active')->label('Active')->boolean(),
            ])
            ->recordActions([
                EditAction::make()->iconButton(),
                DeleteAction::make()->iconButton(),
            ])
            ->toolbarActions([BulkActionGroup::make([DeleteBulkAction::make()])])
            ->reorderable('sort_order')
            ->defaultSort('sort_order');
    }
}
