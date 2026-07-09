<?php

namespace App\Http\Middleware;

use App\Filament\Admin\Resources\Certificates\CertificateResource;
use App\Filament\Admin\Resources\Courses\CourseResource;
use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentFilamentAccess
{
    /**
     * Allowed Filament route name prefixes for student users.
     * Using route names instead of hard-coded URL strings is more
     * maintainable and won't silently break on URL path changes.
     */
    private const ALLOWED_ROUTE_PREFIXES = [
        'filament.admin.pages.dashboard',
        'filament.admin.pages.student-course',
        'filament.admin.pages.course-lessons',
        'filament.admin.auth.logout',
        'filament.admin.auth.profile',
        'filament.admin.pages.profile',
        'livewire.',
    ];

    /**
     * Resource list pages that student users can open in read-only/my-data mode.
     */
    private const ALLOWED_RESOURCE_INDEXES = [
        CourseResource::class,
        ScheduleResource::class,
        CertificateResource::class,
    ];

    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $user?->loadMissing(['roles', 'student', 'teacher']);

        // Non-student users pass through without restriction.
        if (! $user?->isStudent()) {
            return $next($request);
        }

        $currentRouteName = (string) $request->route()?->getName();

        // Allow Livewire AJAX update requests (required for Filament interactivity).
        if ($request->is('livewire/*')) {
            return $next($request);
        }

        // Check if the current route name starts with any of our allowed prefixes.
        $allowed = collect(self::ALLOWED_ROUTE_PREFIXES)
            ->contains(fn (string $prefix): bool => str_starts_with($currentRouteName, $prefix));

        if (! $allowed) {
            $allowed = collect(self::ALLOWED_RESOURCE_INDEXES)
                ->contains(fn (string $resource): bool => $currentRouteName === $resource::getRouteBaseName().'.index');
        }

        abort_unless($allowed, 403, 'ការចូលប្រើប្រាស់ត្រូវបានបដិសេធ');

        return $next($request);
    }
}
