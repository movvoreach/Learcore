<?php

namespace App\Filament\Admin\Resources;

use App\Filament\Admin\Resources\ActivityLogResource\Pages;
use App\Models\ActivityLog;
use Filament\Forms;
use Filament\Schemas\Schema;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Filters\Filter;
use Filament\Tables\Enums\FiltersLayout;
use Illuminate\Database\Eloquent\Model;

class ActivityLogResource extends Resource
{
    protected static ?string $model = ActivityLog::class;

    protected static string|\BackedEnum|null $navigationIcon = 'heroicon-o-document-magnifying-glass';
    protected static string|\UnitEnum|null $navigationGroup = 'ការកំណត់';
    protected static ?string $navigationLabel = 'សកម្មភាពអ្នកប្រើប្រាស់';
    protected static ?string $modelLabel = 'Activity Log';
    protected static ?string $pluralModelLabel = 'សកម្មភាពអ្នកប្រើប្រាស់';

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin']) ?? false;
    }

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->schema([
                Forms\Components\TextInput::make('id')->label('លេខ'),
                Forms\Components\TextInput::make('action')->label('សកម្មភាព'),
                Forms\Components\TextInput::make('model_type')->label('Model'),
                Forms\Components\KeyValue::make('old_values')->label('Old Values'),
                Forms\Components\KeyValue::make('new_values')->label('New Values'),
                Forms\Components\TextInput::make('ip_address')->label('អាស័យដ្ឋាន'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('លេខ')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.id')
                    ->label('លេខសំងាត់')
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('user.name')
                    ->label('ឈ្មោះ')
                    ->searchable(),
                Tables\Columns\TextColumn::make('action')
                    ->label('សកម្មភាព')
                    ->searchable(),
                Tables\Columns\TextColumn::make('description')
                    ->label('បរិយាយ')
                    ->state(function (ActivityLog $record): string {
                        $name = $record->user ? $record->user->name : 'System';
                        $time = $record->created_at->timezone('Asia/Phnom_Penh')->format('Y-m-d h:i:sa');
                        $ip = $record->ip_address ?? 'unknown IP';
                        $model = class_basename($record->model_type);
                        
                        if ($record->action === 'logged_in') {
                            return "{$name} logged in at {$time} from IP {$ip}.";
                        } elseif ($record->action === 'logged_out') {
                            return "{$name} logged out at {$time} from IP {$ip}.";
                        }
                        return "{$name} {$record->action} a {$model} at {$time} from IP {$ip}.";
                    }),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('ពេលវេលា')
                    ->dateTime('Y-m-d H:i:s', 'Asia/Phnom_Penh')
                    ->sortable(),
                Tables\Columns\TextColumn::make('ip_address')
                    ->label('អាស័យដ្ឋាន')
                    ->searchable(),
            ])
            ->filters([
                Filter::make('created_at')
                    ->form([
                        Forms\Components\DatePicker::make('created_from')
                            ->label('From Date')
                            ->native(true),
                        Forms\Components\DatePicker::make('created_until')
                            ->label('To Date')
                            ->native(true),
                    ])
                    ->query(function (Builder $query, array $data): Builder {
                        return $query
                            ->when(
                                $data['created_from'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '>=', $date),
                            )
                            ->when(
                                $data['created_until'],
                                fn (Builder $query, $date): Builder => $query->whereDate('created_at', '<=', $date),
                            );
                    })
                    ->columns(2)
            ], layout: FiltersLayout::AboveContent)
            ->recordActions([
                \Filament\Actions\ViewAction::make(),
            ])
            ->defaultSort('created_at', 'desc')
            ->description('Records from user_activity');
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListActivityLogs::route('/'),
            'view' => Pages\ViewActivityLog::route('/{record}'),
        ];
    }

    public static function canCreate(): bool
    {
        return false;
    }

    public static function canEdit(Model $record): bool
    {
        return false;
    }

    public static function canDelete(Model $record): bool
    {
        return false;
    }
}
