<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureStudentFilamentAccess
{
    /**
     * @param  Closure(Request): Response  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        $user?->loadMissing(['roles', 'student', 'teacher']);

        if (! $user?->isStudent()) {
            return $next($request);
        }

        $allowed = $request->is('admin')
            || $request->is('admin/course')
            || $request->is('admin/my-courses/*')
            || $request->is('admin/logout')
            || $request->is('admin/profile')
            || $request->is('admin/profile/*');

        abort_unless($allowed, 403);

        return $next($request);
    }
}
