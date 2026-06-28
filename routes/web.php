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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
})->name('dashboard');

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
