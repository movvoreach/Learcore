<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Resources\Pages\EditRecord;

class EditContentLesson extends EditRecord
{
    protected static string $resource = ContentLessonResource::class;
}
