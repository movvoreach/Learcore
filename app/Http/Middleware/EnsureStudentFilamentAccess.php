<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
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

        abort_unless($allowed, 403, 'ការចូលប្រើប្រាស់ត្រូវបានបដិសេធ');

        return $next($request);
    }
}
