<?php

namespace App\Filament\Admin\Resources\ClassRooms;

use App\Filament\Admin\Resources\ClassRooms\Pages\CreateClassRoom;
use App\Filament\Admin\Resources\ClassRooms\Pages\EditClassRoom;
use App\Filament\Admin\Resources\ClassRooms\Pages\ListClassRooms;
use App\Filament\Admin\Resources\ClassRooms\Pages\ViewClassRoom;
use App\Filament\Admin\Resources\ClassRooms\Schemas\ClassRoomForm;
use App\Filament\Admin\Resources\ClassRooms\Tables\ClassRoomsTable;
use App\Models\ClassRoom;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;

class ClassRoomResource extends Resource
{
    protected static ?string $model = ClassRoom::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedRectangleStack;

    protected static ?string $recordTitleAttribute = 'class_name';

    protected static bool $shouldRegisterNavigation = false;

    public static function form(Schema $schema): Schema
    {
        return ClassRoomForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ClassRoomsTable::configure($table);
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
            'index' => ListClassRooms::route('/'),
            'create' => CreateClassRoom::route('/create'),
            'view' => ViewClassRoom::route('/{record}'),
            'edit' => EditClassRoom::route('/{record}/edit'),
        ];
    }
}
