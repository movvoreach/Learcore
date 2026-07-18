<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use App\Models\ContentLesson;
use App\Models\CourseModule;
use Filament\Resources\Pages\CreateRecord;
use Filament\Support\Exceptions\Halt;
use Illuminate\Support\Str;

class CreateContentLesson extends CreateRecord
{
    protected static string $resource = ContentLessonResource::class;

    protected string $view = 'filament.admin.resources.content-lessons.pages.create-content-lesson';

    protected function mutateFormDataBeforeCreate(array $data): array
    {
        $data['slug'] = $this->uniqueSlug($data['slug'] ?? $data['title'] ?? null);
        $data = $this->syncModuleData($data);

        if (filled($data['course_module_id'])) {
            $data['position'] = (ContentLesson::query()
                ->where('course_module_id', $data['course_module_id'])
                ->max('position') ?? 0) + 1;
        } elseif (filled($data['course_id'])) {
            $data['position'] = (ContentLesson::query()
                ->where('course_id', $data['course_id'])
                ->where('module_number', $data['module_number'] ?? 1)
                ->max('position') ?? 0) + 1;
        }

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

    protected function getRedirectUrl(): string
    {
        return $this->getResourceUrl('show', ['record' => $this->record]);
    }

    protected function afterCreate(): void
    {
        $this->redirect($this->getRedirectUrl(), navigate: false);

        throw new Halt();
    }

    private function uniqueSlug(?string $value): string
    {
        $baseSlug = Str::slug($value ?: '') ?: 'lesson';
        $slug = $baseSlug;
        $index = 2;

        while (ContentLesson::withTrashed()->where('slug', $slug)->exists()) {
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

        if (! $module && filled($data['course_id'] ?? null)) {
            $moduleNumber = (int) ($data['module_number'] ?? 1);

            $module = CourseModule::query()->firstOrCreate(
                [
                    'course_id' => $data['course_id'],
                    'module_number' => $moduleNumber,
                ],
                [
                    'title' => $data['module_title'] ?: 'Course Module '.$moduleNumber,
                ],
            );
        }

        if ($module) {
            $data['course_module_id'] = $module->course_module_id;
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
