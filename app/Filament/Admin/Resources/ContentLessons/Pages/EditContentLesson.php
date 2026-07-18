<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use App\Models\ContentLesson;
use App\Models\CourseModule;
use Filament\Resources\Pages\EditRecord;
use Illuminate\Support\Str;

class EditContentLesson extends EditRecord
{
    protected static string $resource = ContentLessonResource::class;

    protected function mutateFormDataBeforeSave(array $data): array
    {
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'] ?? null);
        $data = $this->syncModuleData($data);

        if (($data['visibility'] ?? null) !== 'scheduled') {
            $data['available_from'] = null;
            $data['available_until'] = null;
        }

        if (($data['content_type'] ?? null) !== 'url') {
            $data['external_url'] = null;
        }

        if (($data['content_type'] ?? null) !== 'video') {
            $data['video_url'] = null;
        }

        return $data;
    }

    private function uniqueSlug(?string $value): string
    {
        $baseSlug = Str::slug($value ?: '') ?: 'lesson';
        $slug = $baseSlug;
        $index = 2;

        while (ContentLesson::withTrashed()
            ->where('slug', $slug)
            ->whereKeyNot($this->record?->getKey())
            ->exists()) {
            $slug = "{$baseSlug}-{$index}";
            $index++;
        }

        return $slug;
    }

    /**
     * @param  array<string, mixed>  $data
     * @return array<string, mixed>
     */
    private function syncModuleData(array $data): array
    {
        $module = filled($data['course_module_id'] ?? null)
            ? CourseModule::query()->find($data['course_module_id'])
            : null;

        if ($module) {
            $data['course_id'] = $module->course_id;
            $data['module_number'] = $module->module_number;
            $data['module_title'] = $module->title;
        }

        return $data;
    }

    protected function getCancelFormAction(): \Filament\Actions\Action
    {
        return parent::getCancelFormAction()
            ->label('ត្រឡប់');
    }
}
