<?php

use App\Models\Certificate;
use App\Models\ContentAssignment;
use App\Models\ContentLesson;
use App\Models\ContentResource;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Student;
use App\Models\StudentProgress;
use App\Http\Controllers\Admin\ReportExportController;
use App\Http\Controllers\frontend\frontendController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', fn () => redirect()->route('login'));

Route::get('/learning', [frontendController::class, 'index'])->name('dashboard');
Route::get('/learning/about', [frontendController::class, 'about'])->name('frontend.about');
Route::get('/learning/terms', [frontendController::class, 'terms'])->name('frontend.terms');
Route::get('/learning/faqs', [frontendController::class, 'faqs'])->name('frontend.faqs');
Route::get('/learning/programs', [frontendController::class, 'programs'])->name('frontend.programs');
Route::middleware('auth')->prefix('/learning/account')->name('frontend.account.')->group(function (): void {
    Route::get('/', [frontendController::class, 'accountDashboard'])->name('dashboard');
    Route::get('/profile', [frontendController::class, 'accountProfile'])->name('profile');
    Route::get('/edit', [frontendController::class, 'accountEdit'])->name('edit');
    Route::get('/grades', [frontendController::class, 'accountGrades'])->name('grades');
    Route::get('/settings', [frontendController::class, 'accountSettings'])->name('settings');
    Route::get('/notifications', [frontendController::class, 'accountNotifications'])->name('notifications');
    Route::get('/calendar', [frontendController::class, 'accountCalendar'])->name('calendar');
});
Route::get('/learning/language/{locale}', function (Request $request, string $locale) {
    if (! in_array($locale, ['km', 'en'], true)) {
        abort(404);
    }

    $request->session()->put('learning_locale', $locale);

    return redirect()->back();
})->name('frontend.language');
Route::get('/learningavailable', [frontendController::class, 'courses'])->name('frontend.learningavailable');
Route::get('/learning/courses', [frontendController::class, 'courses'])->name('frontend.courses');
Route::post('/learning/courses/{course}/discussion', [frontendController::class, 'storeCourseDiscussion'])
    ->middleware('auth')
    ->name('frontend.courses.discussion.store');
Route::post('/learning/courses/{course}/lessons/{lesson}/discussion', [frontendController::class, 'storeLessonDiscussion'])
    ->middleware('auth')
    ->name('frontend.courses.lessons.discussion.store');
Route::post('/learning/courses/{course}/lessons/{lesson}/quizzes/{quiz}/submit', [frontendController::class, 'submitQuiz'])
    ->middleware('auth')
    ->name('frontend.courses.lessons.quizzes.submit');
Route::post('/learning/courses/{course}/lessons/{lesson}/assignments/{assignment}/submit', [frontendController::class, 'submitAssignment'])
    ->middleware('auth')
    ->name('frontend.courses.lessons.assignments.submit');
Route::post('/learning/discussion/{discussionPost}/comments', [frontendController::class, 'storeDiscussionComment'])
    ->middleware('auth')
    ->name('frontend.discussion.comments.store');
Route::post('/learning/discussion/posts/{discussionPost}/reaction', [frontendController::class, 'togglePostReaction'])
    ->middleware('auth')
    ->name('frontend.discussion.posts.reaction');
Route::post('/learning/discussion/comments/{discussionComment}/reaction', [frontendController::class, 'toggleCommentReaction'])
    ->middleware('auth')
    ->name('frontend.discussion.comments.reaction');
Route::get('/learning/courses/{course}/lessons/{lesson}', [frontendController::class, 'lesson'])->name('frontend.courses.lessons.show');
Route::get('/learning/courses/{course}', [frontendController::class, 'courseDetail'])->name('frontend.courses.show');

Route::get('/login', fn () => redirect()->route('filament.admin.auth.login'))->name('login');

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');

Route::middleware('auth')->prefix('admin/reports')->name('admin.reports.')->group(function (): void {
    Route::get('{report}/excel', [ReportExportController::class, 'excel'])->name('excel');
    Route::get('{report}/print', [ReportExportController::class, 'print'])->name('print');
});
