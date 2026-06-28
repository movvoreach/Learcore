<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Resources\Pages\CreateRecord;

class CreateContentLesson extends CreateRecord
{
    protected static string $resource = ContentLessonResource::class;
}
