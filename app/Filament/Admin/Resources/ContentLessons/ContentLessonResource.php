<?php

namespace App\Filament\Admin\Resources\ContentLessons;

use App\Filament\Admin\Resources\ContentLessons\Pages\CreateContentLesson;
use App\Filament\Admin\Resources\ContentLessons\Pages\EditContentLesson;
use App\Filament\Admin\Resources\ContentLessons\Pages\ListContentLessons;
use App\Filament\Admin\Resources\ContentLessons\Pages\ViewContentLesson;
use App\Filament\Admin\Resources\ContentLessons\Schemas\ContentLessonForm;
use App\Filament\Admin\Resources\ContentLessons\Tables\ContentLessonsTable;
use App\Models\ContentLesson;
use BackedEnum;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;

class ContentLessonResource extends Resource
{
    protected static ?string $model = ContentLesson::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedBookOpen;

    protected static bool $shouldRegisterNavigation = false;

    public static function canAccess(): bool
    {
        return auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false;
    }

    protected static ?string $modelLabel = 'មេរៀន';

    protected static ?string $pluralModelLabel = 'មេរៀន';

    public static function form(Schema $schema): Schema
    {
        return ContentLessonForm::configure($schema);
    }

    public static function table(Table $table): Table
    {
        return ContentLessonsTable::configure($table);
    }

    public static function getEloquentQuery(): Builder
    {
        $query = parent::getEloquentQuery();
        $student = auth()->user()?->student;

        if (auth()->user()?->isStudent() && $student) {
            return $query
                ->availableToStudent($student)
                ->publishedForStudents();
        }

        return $query;
    }

    public static function getPages(): array
    {
        return [
            'index' => ListContentLessons::route('/'),
            'create' => CreateContentLesson::route('/create'),
            'show' => ViewContentLesson::route('/{record}/show'),
            'edit' => EditContentLesson::route('/{record}/edit'),
        ];
    }
}
