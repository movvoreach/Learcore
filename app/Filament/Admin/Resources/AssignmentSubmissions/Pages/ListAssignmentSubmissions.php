<?php

namespace App\Filament\Admin\Resources\AssignmentSubmissions\Pages;

use App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use Filament\Resources\Pages\ListRecords;

class ListAssignmentSubmissions extends ListRecords
{
    protected static string $resource = AssignmentSubmissionResource::class;

    protected string $view = 'filament.admin.resources.assignment-submissions.pages.list-assignment-submissions';
}
