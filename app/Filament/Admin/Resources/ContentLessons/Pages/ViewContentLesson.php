<?php

namespace App\Filament\Admin\Resources\ContentLessons\Pages;

use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use Filament\Actions\Action;
use Filament\Resources\Pages\ViewRecord;

class ViewContentLesson extends ViewRecord
{
    protected static string $resource = ContentLessonResource::class;

    protected string $view = 'filament.admin.resources.content-lessons.pages.view-content-lesson';

    protected static ?string $title = 'Lesson Detail';

    protected static ?string $breadcrumb = 'Detail';

    public function getMaxContentWidth(): ?string
    {
        return 'full';
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('edit')
                ->label('Edit Lesson')
                ->icon('heroicon-o-pencil-square')
                ->url(fn (): string => ContentLessonResource::getUrl('edit', ['record' => $this->record])),
        ];
    }

    public function mount(int|string $record): void
    {
        parent::mount($record);

        $this->record->load([
            'course.category',
            'chapters' => fn ($query) => $query->orderBy('sort_order')->orderBy('content_chapter_id'),
            'videos' => fn ($query) => $query->orderBy('sort_order')->orderBy('content_video_id'),
            'documents' => fn ($query) => $query->orderBy('sort_order')->orderBy('content_document_id'),
            'assignments',
            'quizzes',
            'resources',
        ]);
    }
}
