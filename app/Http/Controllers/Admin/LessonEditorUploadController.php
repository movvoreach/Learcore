<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LessonEditorUploadController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
        abort_unless($request->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']), 403);

        $validated = $request->validate([
            'file' => ['required', 'file', 'max:512000'],
            'type' => ['required', 'in:image,video'],
        ]);

        $rules = $validated['type'] === 'image'
            ? ['image', 'mimes:jpg,jpeg,png,gif,webp', 'max:12288']
            : ['mimetypes:video/mp4,video/webm,video/quicktime', 'max:512000'];

        $request->validate([
            'file' => ['required', 'file', ...$rules],
        ]);

        $directory = $validated['type'] === 'image'
            ? 'learning/editor/images'
            : 'learning/editor/videos';
        $path = $request->file('file')->store($directory, 'public');

        return response()->json([
            'type' => $validated['type'],
            'path' => $path,
            'url' => Storage::disk('public')->url($path),
        ]);
    }
}
