<x-filament-panels::page>
    <style>
        .cl-page {
            color: #1e293b;
            font-family: "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            transition: color 0.3s;
        }
        .dark .cl-page {
            color: #f1f5f9;
        }

        /* Banner Header */
        .cl-header {
            background: linear-gradient(135deg, #0f172a 0%, #1e1b4b 100%);
            border: 1px solid #312e81;
            color: #fff;
            padding: 32px;
            border-radius: 16px;
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.12);
            position: relative;
            overflow: hidden;
            margin-bottom: 24px;
        }
        .cl-header::before {
            content: "";
            position: absolute;
            top: -50%;
            right: -50%;
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }

        .cl-header-top {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 16px;
            position: relative;
            z-index: 10;
        }

        .cl-course-title {
            margin: 0;
            color: #ffffff;
            font-size: 28px;
            font-weight: 900;
            line-height: 1.2;
            text-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
        }

        .cl-course-code {
            display: inline-block;
            margin-top: 8px;
            padding: 4px 12px;
            border-radius: 8px;
            background: rgba(99, 102, 241, 0.2);
            border: 1px solid rgba(99, 102, 241, 0.4);
            color: #818cf8;
            font-size: 13px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .cl-meta-row {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 20px;
            position: relative;
            z-index: 10;
        }

        .cl-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            min-height: 32px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 99px;
            background: rgba(255, 255, 255, 0.04);
            padding: 5px 14px;
            color: #cbd5e1;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            transition: all 0.2s;
        }
        .cl-pill:hover {
            background: rgba(255, 255, 255, 0.1);
            color: #ffffff;
            border-color: rgba(255, 255, 255, 0.2);
        }

        /* Stats Grid */
        .cl-stats {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(130px, 1fr));
            gap: 12px;
            margin-top: 24px;
            position: relative;
            z-index: 10;
        }

        .cl-stat {
            background: rgba(255, 255, 255, 0.02);
            border: 1px solid rgba(255, 255, 255, 0.06);
            backdrop-filter: blur(12px);
            border-radius: 12px;
            padding: 16px 12px;
            text-align: center;
            transition: all 0.2s ease;
        }
        .cl-stat:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, 0.05);
            border-color: rgba(255, 255, 255, 0.12);
        }

        .cl-stat-value {
            color: #fff;
            font-size: 26px;
            font-weight: 900;
            text-shadow: 0 2px 10px rgba(99, 102, 241, 0.25);
        }

        .cl-stat-label {
            margin-top: 4px;
            color: #94a3b8;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        /* Buttons & Actions */
        .cl-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            border: none;
            border-radius: 10px;
            padding: 10px 20px;
            font-size: 13px;
            font-weight: 700;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cl-btn svg {
            width: 16px;
            height: 16px;
        }

        .cl-btn-primary {
            background: linear-gradient(135deg, #10b981 0%, #059669 100%);
            color: #fff;
            box-shadow: 0 4px 14px rgba(16, 185, 129, 0.25);
        }
        .cl-btn-primary:hover {
            background: linear-gradient(135deg, #059669 0%, #047857 100%);
            box-shadow: 0 6px 20px rgba(16, 185, 129, 0.35);
            transform: translateY(-1px);
        }

        .cl-btn-edit {
            background: #eff6ff;
            color: #2563eb;
            border: 1px solid #bfdbfe;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
        }
        .cl-btn-edit:hover {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }
        .dark .cl-btn-edit {
            background: #1e293b;
            color: #60a5fa;
            border-color: #334155;
        }
        .dark .cl-btn-edit:hover {
            background: #2563eb;
            color: #fff;
            border-color: #2563eb;
        }

        .cl-btn-delete {
            background: #fff5f5;
            color: #e11d48;
            border: 1px solid #fecdd3;
            font-size: 12px;
            padding: 5px 12px;
            border-radius: 6px;
            font-weight: 700;
        }
        .cl-btn-delete:hover {
            background: #e11d48;
            color: #fff;
            border-color: #e11d48;
        }
        .dark .cl-btn-delete {
            background: #1e293b;
            color: #fb7185;
            border-color: #334155;
        }
        .dark .cl-btn-delete:hover {
            background: #e11d48;
            color: #fff;
            border-color: #e11d48;
        }

        .cl-btn-back {
            background: rgba(255, 255, 255, 0.08);
            color: #cbd5e1;
            border: 1px solid rgba(255, 255, 255, 0.15);
        }
        .cl-btn-back:hover {
            background: rgba(255, 255, 255, 0.15);
            color: #fff;
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-1px);
        }

        .cl-quick-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 24px;
            padding-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.08);
            position: relative;
            z-index: 10;
        }

        .cl-mini-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 32px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            padding: 6px 12px;
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            text-decoration: none;
            transition: all 0.2s;
        }
        .cl-mini-btn:hover {
            border-color: #93c5fd;
            background: #eff6ff;
            color: #1d4ed8;
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.1);
        }
        .dark .cl-mini-btn {
            background: #1e293b;
            border-color: #334155;
            color: #cbd5e1;
        }
        .dark .cl-mini-btn:hover {
            background: #1e3a8a;
            border-color: #3b82f6;
            color: #60a5fa;
            box-shadow: 0 4px 12px rgba(59, 130, 246, 0.2);
        }

        .cl-mini-btn svg {
            width: 15px;
            height: 15px;
        }

        /* Lesson Card & Structure */
        .cl-lessons {
            display: grid;
            gap: 20px;
        }

        .cl-lesson-card {
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            background: #ffffff;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            overflow: hidden;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .cl-lesson-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.06);
            transform: translateY(-2px);
        }
        .dark .cl-lesson-card {
            border: 1px solid #334155;
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .dark .cl-lesson-card:hover {
            box-shadow: 0 12px 30px rgba(0, 0, 0, 0.25);
        }

        .cl-lesson-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 16px;
            padding: 20px 24px;
            background: #f8fafc;
            border-bottom: 1px solid #e2e8f0;
            cursor: pointer;
            user-select: none;
            transition: background-color 0.2s;
        }
        .dark .cl-lesson-header {
            background: #1e293b;
            border-bottom: 1px solid #334155;
        }
        .cl-lesson-header:hover {
            background: #f1f5f9;
        }
        .dark .cl-lesson-header:hover {
            background: #242f47;
        }

        .cl-lesson-info {
            display: flex;
            align-items: center;
            gap: 14px;
            flex: 1;
            min-width: 0;
        }

        .cl-lesson-toggle {
            color: #64748b;
            font-size: 16px;
            transition: transform 0.2s;
            flex-shrink: 0;
        }
        .cl-lesson-toggle.open {
            transform: rotate(90deg);
        }

        .cl-module-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border-radius: 10px;
            background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);
            color: #fff;
            font-size: 14px;
            font-weight: 800;
            flex-shrink: 0;
            box-shadow: 0 4px 10px rgba(37, 99, 235, 0.2);
        }

        .cl-lesson-title {
            color: #0f172a;
            font-size: 16px;
            font-weight: 800;
            line-height: 1.4;
        }
        .dark .cl-lesson-title {
            color: #f1f5f9;
        }

        .cl-lesson-badges {
            display: flex;
            align-items: center;
            gap: 6px;
            flex-wrap: wrap;
        }

        .cl-badge {
            display: inline-flex;
            align-items: center;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.03em;
        }

        .cl-badge-published {
            background: #dcfce7;
            color: #15803d;
            border: 1px solid #bbf7d0;
        }
        .dark .cl-badge-published {
            background: rgba(22, 163, 74, 0.15);
            color: #4ade80;
            border-color: rgba(22, 163, 74, 0.3);
        }

        .cl-badge-draft {
            background: #fef3c7;
            color: #b45309;
            border: 1px solid #fde68a;
        }
        .dark .cl-badge-draft {
            background: rgba(217, 119, 6, 0.15);
            color: #fbbf24;
            border-color: rgba(217, 119, 6, 0.3);
        }

        .cl-badge-type {
            background: #f0fdfa;
            color: #0d9488;
            border: 1px solid #ccfbf1;
        }
        .dark .cl-badge-type {
            background: rgba(13, 148, 136, 0.15);
            color: #2dd4bf;
            border-color: rgba(13, 148, 136, 0.3);
        }

        .cl-lesson-actions {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            flex-shrink: 0;
        }

        .cl-lesson-body {
            padding: 0 24px 24px;
        }

        /* Items Listing inside Lesson */
        .cl-section {
            margin-top: 20px;
        }

        .cl-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 12px;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-bottom: 1px solid #e2e8f0;
            padding-bottom: 8px;
        }
        .dark .cl-section-title {
            color: #94a3b8;
            border-color: #334155;
        }

        .cl-section-icon {
            width: 16px;
            height: 16px;
            color: #64748b;
        }
        .dark .cl-section-icon {
            color: #94a3b8;
        }

        .cl-items {
            display: grid;
            gap: 8px;
        }

        .cl-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 12px 18px;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            background: #ffffff;
            cursor: pointer;
            transition: all 0.2s ease;
            position: relative;
            overflow: hidden;
        }
        .dark .cl-item {
            border-color: #334155;
            background: #1b2234;
        }
        .cl-item:hover {
            transform: translateX(4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.04);
            background: #f8fafc;
            border-color: #cbd5e1;
        }
        .dark .cl-item:hover {
            background: #202b40;
            border-color: #475569;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
        }

        /* Type specific branding borders */
        .cl-item-chapter { border-left: 4px solid #6366f1; }
        .cl-item-video { border-left: 4px solid #10b981; }
        .cl-item-document { border-left: 4px solid #f59e0b; }
        .cl-item-assignment { border-left: 4px solid #f43f5e; }
        .cl-item-quiz { border-left: 4px solid #8b5cf6; }
        .cl-item-resource { border-left: 4px solid #14b8a6; }

        .cl-item-info {
            display: flex;
            align-items: center;
            gap: 12px;
            flex: 1;
            min-width: 0;
        }

        .cl-item-icon {
            width: 22px;
            height: 22px;
            color: #64748b;
            flex-shrink: 0;
        }
        .dark .cl-item-icon {
            color: #94a3b8;
        }

        .cl-item-name {
            color: #1e293b;
            font-size: 14px;
            font-weight: 700;
        }
        .dark .cl-item-name {
            color: #f1f5f9;
        }

        .cl-item-meta {
            color: #64748b;
            font-size: 11px;
            font-weight: 600;
            margin-top: 3px;
        }
        .dark .cl-item-meta {
            color: #94a3b8;
        }

        .cl-item-actions {
            display: flex;
            gap: 6px;
            flex-shrink: 0;
        }

        .cl-empty-section {
            padding: 16px;
            border: 1px dashed #cbd5e1;
            border-radius: 12px;
            color: #64748b;
            font-size: 13px;
            text-align: center;
            background: #f8fafc;
        }
        .dark .cl-empty-section {
            border-color: #475569;
            color: #94a3b8;
            background: #1b2234;
        }

        .cl-empty-lessons {
            padding: 60px;
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            color: #64748b;
            font-size: 16px;
            text-align: center;
            background: #ffffff;
        }
        .dark .cl-empty-lessons {
            border-color: #475569;
            color: #94a3b8;
            background: #1e293b;
        }

        @media (max-width: 768px) {
            .cl-header {
                padding: 20px;
            }
            .cl-header-top {
                flex-direction: column;
                align-items: stretch;
            }
            .cl-lesson-header {
                padding: 16px;
                flex-direction: column;
                align-items: flex-start;
            }
            .cl-lesson-actions {
                width: 100%;
                margin-top: 12px;
            }
            .cl-item {
                flex-direction: column;
                align-items: flex-start;
            }
            .cl-item-actions {
                width: 100%;
                margin-top: 8px;
                justify-content: flex-end;
            }
            .cl-btn, .cl-mini-btn {
                flex: 1;
                text-align: center;
            }
        }
    </style>

    <div class="cl-page" x-data="{ expandedLessons: @js($lessons->take(1)->pluck('content_lesson_id')->mapWithKeys(fn ($id) => [(string) $id => true])) }">
        {{-- Header --}}
        <div class="cl-header">
            <div class="cl-header-top">
                <div>
                    <h1 class="cl-course-title">{{ $course->course_name }}</h1>
                    <span class="cl-course-code">{{ $course->course_code }}</span>
                </div>
                <div style="display: flex; gap: 8px;">
                    <a href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('create', ['course_id' => $course->course_id]) }}"
                       class="cl-btn cl-btn-primary">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                        បន្ថែមមេរៀន
                    </a>
                    <a href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('index') }}"
                       class="cl-btn cl-btn-back">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                        ត្រឡប់ក្រោយ
                    </a>
                </div>
            </div>

            <div class="cl-meta-row">
                @if($course->department)
                    <span class="cl-pill">🏛 {{ $course->department->department_name }}</span>
                @endif
                @if($course->academicYear)
                    <span class="cl-pill">📅 {{ $course->academicYear->year_name }}</span>
                @endif
                @if($course->semester)
                    <span class="cl-pill">📚 {{ $course->semester->semester_name }}</span>
                @endif
                @if($course->category)
                    <span class="cl-pill">📂 {{ $course->category->category_name }}</span>
                @endif
                <span class="cl-pill">👨‍🏫 {{ $teacherName }}</span>
            </div>

            <div class="cl-stats">
                <div class="cl-stat">
                    <div class="cl-stat-value">{{ $totalLessons }}</div>
                    <div class="cl-stat-label">សរុបមេរៀន</div>
                </div>
                <div class="cl-stat">
                    <div class="cl-stat-value" style="color: #16a34a;">{{ $publishedCount }}</div>
                    <div class="cl-stat-label">បានផ្សាយ</div>
                </div>
                <div class="cl-stat">
                    <div class="cl-stat-value" style="color: #f59e0b;">{{ $draftCount }}</div>
                    <div class="cl-stat-label">សេចក្ដីព្រាង</div>
                </div>
                <div class="cl-stat">
                    <div class="cl-stat-value" style="color: #6366f1;">{{ $totalChapters }}</div>
                    <div class="cl-stat-label">ជំពូក</div>
                </div>
                <div class="cl-stat">
                    <div class="cl-stat-value" style="color: #ec4899;">{{ $totalAssignments }}</div>
                    <div class="cl-stat-label">កិច្ចការ</div>
                </div>
                <div class="cl-stat">
                    <div class="cl-stat-value" style="color: #8b5cf6;">{{ $totalQuizzes }}</div>
                    <div class="cl-stat-label">សំណួរ</div>
                </div>
            </div>

            <div class="cl-quick-actions">
                <a class="cl-mini-btn" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('create', ['course_id' => $course->course_id]) }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v14m7-7H5"/></svg>
                    បន្ថែមមេរៀន
                </a>
                <a class="cl-mini-btn" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index') }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    តារាងមេរៀន
                </a>
                <a class="cl-mini-btn" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('edit', ['record' => $course->course_id]) }}">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5M18.5 2.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
                    កែវគ្គសិក្សា
                </a>
            </div>
        </div>

        {{-- Lessons List --}}
        @if($lessons->isEmpty())
            <div class="cl-empty-lessons">
                មិនមានមេរៀនក្នុងវគ្គសិក្សានេះទេ។ ចុច "បន្ថែមមេរៀន" ដើម្បីចាប់ផ្ដើម។
            </div>
        @else
            <div class="cl-lessons">
                @foreach($lessons as $lesson)
                    <div class="cl-lesson-card">
                        {{-- Lesson Header --}}
                        <div class="cl-lesson-header"
                             role="button"
                             tabindex="0"
                             @click="expandedLessons[{{ $lesson->content_lesson_id }}] = !expandedLessons[{{ $lesson->content_lesson_id }}]"
                             @keydown.enter.prevent="expandedLessons[{{ $lesson->content_lesson_id }}] = !expandedLessons[{{ $lesson->content_lesson_id }}]"
                             @keydown.space.prevent="expandedLessons[{{ $lesson->content_lesson_id }}] = !expandedLessons[{{ $lesson->content_lesson_id }}]">
                            <div class="cl-lesson-info">
                                <span class="cl-lesson-toggle"
                                      :class="{ 'open': expandedLessons[{{ $lesson->content_lesson_id }}] }">▶</span>
                                <span class="cl-module-badge">{{ $lesson->module_number ?? $loop->iteration }}</span>
                                <div>
                                    <div class="cl-lesson-title">{{ $lesson->title }}</div>
                                    @if($lesson->module_title)
                                        <div style="color: #64748b; font-size: 12px; margin-top: 2px;">{{ $lesson->module_title }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="cl-lesson-badges">
                                <span class="cl-badge cl-badge-type">{{ ucfirst($lesson->content_type ?? 'lesson') }}</span>
                                @if($lesson->is_published)
                                    <span class="cl-badge cl-badge-published">✓ ផ្សាយ</span>
                                @else
                                    <span class="cl-badge cl-badge-draft">ព្រាង</span>
                                @endif
                            </div>

                            <div class="cl-lesson-actions" @click.stop>
                                <a href="{{ \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">ជំពូក</a>
                                <a href="{{ \App\Filament\Admin\Resources\ContentVideos\ContentVideoResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">វីដេអូ</a>
                                <a href="{{ \App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">ឯកសារ</a>
                                <a href="{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">កិច្ចការ</a>
                                <a href="{{ \App\Filament\Admin\Resources\Quizzes\QuizResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">សំណួរ</a>
                                <a href="{{ \App\Filament\Admin\Resources\ContentResources\ContentResourceResource::getUrl('create', ['content_lesson_id' => $lesson->content_lesson_id]) }}"
                                   class="cl-mini-btn">ធនធាន</a>
                                <a href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('edit', ['record' => $lesson->content_lesson_id]) }}"
                                   class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                <button type="button"
                                        class="cl-btn cl-btn-delete"
                                        wire:click="deleteLesson({{ $lesson->content_lesson_id }})"
                                        wire:confirm="តើអ្នកប្រាកដថាចង់លុបមេរៀននេះ?">លុប</button>
                            </div>
                        </div>

                        {{-- Lesson Body (Expandable) --}}
                        <div class="cl-lesson-body"
                             x-show="expandedLessons[{{ $lesson->content_lesson_id }}]"
                             x-collapse>

                            {{-- Chapters --}}
                            @if($lesson->chapters->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                        ជំពូក ({{ $lesson->chapters->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->chapters as $chapter)
                                            <div class="cl-item cl-item-chapter"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('edit', ['record' => $chapter->content_chapter_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $chapter->title }}</div>
                                                        <div class="cl-item-meta">លំដាប់: {{ $chapter->sort_order }} · {{ $chapter->is_published ? 'ផ្សាយ' : 'ព្រាង' }}</div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentChapters\ContentChapterResource::getUrl('edit', ['record' => $chapter->content_chapter_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('chapter', {{ $chapter->content_chapter_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបជំពូកនេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Videos --}}
                            @if($lesson->videos->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                        វីដេអូ ({{ $lesson->videos->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->videos as $video)
                                            <div class="cl-item cl-item-video"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\ContentVideos\ContentVideoResource::getUrl('edit', ['record' => $video->content_video_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $video->title }}</div>
                                                        <div class="cl-item-meta">{{ $video->duration_minutes ? $video->duration_minutes . ' នាទី' : '' }} · {{ $video->is_published ? 'ផ្សាយ' : 'ព្រាង' }}</div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentVideos\ContentVideoResource::getUrl('edit', ['record' => $video->content_video_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('video', {{ $video->content_video_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបវីដេអូនេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Documents --}}
                            @if($lesson->documents->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
                                        ឯកសារ ({{ $lesson->documents->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->documents as $document)
                                            <div class="cl-item cl-item-document"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource::getUrl('edit', ['record' => $document->content_document_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $document->title }}</div>
                                                        <div class="cl-item-meta">{{ $document->is_published ? 'ផ្សាយ' : 'ព្រាង' }}</div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource::getUrl('edit', ['record' => $document->content_document_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('document', {{ $document->content_document_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបឯកសារនេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Assignments --}}
                            @if($lesson->assignments->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                                        កិច្ចការ ({{ $lesson->assignments->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->assignments as $assignment)
                                            <div class="cl-item cl-item-assignment"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('edit', ['record' => $assignment->content_assignment_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $assignment->title }}</div>
                                                        <div class="cl-item-meta">
                                                            ពិន្ទុ: {{ $assignment->max_score ?? '-' }}
                                                            @if($assignment->due_at) · កាលបរិច្ឆេទផុតកំណត់: {{ $assignment->due_at->format('d/m/Y') }}@endif
                                                            · {{ $assignment->is_published ? 'ផ្សាយ' : 'ព្រាង' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('edit', ['record' => $assignment->content_assignment_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('assignment', {{ $assignment->content_assignment_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបកិច្ចការនេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Quizzes --}}
                            @if($lesson->quizzes->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        សំណួរ ({{ $lesson->quizzes->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->quizzes as $quiz)
                                            <div class="cl-item cl-item-quiz"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\Quizzes\QuizResource::getUrl('edit', ['record' => $quiz->quiz_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $quiz->title }}</div>
                                                        <div class="cl-item-meta">
                                                            ពិន្ទុជាប់: {{ $quiz->passing_score ?? '-' }}%
                                                            @if($quiz->time_limit_minutes) · {{ $quiz->time_limit_minutes }} នាទី @endif
                                                            · {{ $quiz->is_published ? 'ផ្សាយ' : 'ព្រាង' }}
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\Quizzes\QuizResource::getUrl('edit', ['record' => $quiz->quiz_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('quiz', {{ $quiz->quiz_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបសំណួរនេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Resources --}}
                            @if($lesson->resources->isNotEmpty())
                                <div class="cl-section">
                                    <h4 class="cl-section-title">
                                        <svg class="cl-section-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                        ធនធាន ({{ $lesson->resources->count() }})
                                    </h4>
                                    <div class="cl-items">
                                        @foreach($lesson->resources as $resource)
                                            <div class="cl-item cl-item-resource"
                                                 role="link"
                                                 tabindex="0"
                                                 onclick="window.location.href='{{ \App\Filament\Admin\Resources\ContentResources\ContentResourceResource::getUrl('edit', ['record' => $resource->content_resource_id]) }}'">
                                                <div class="cl-item-info">
                                                    <svg class="cl-item-icon" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
                                                    <div>
                                                        <div class="cl-item-name">{{ $resource->title }}</div>
                                                        <div class="cl-item-meta">{{ $resource->is_published ? 'ផ្សាយ' : 'ព្រាង' }}</div>
                                                    </div>
                                                </div>
                                                <div class="cl-item-actions" onclick="event.stopPropagation()">
                                                    <a href="{{ \App\Filament\Admin\Resources\ContentResources\ContentResourceResource::getUrl('edit', ['record' => $resource->content_resource_id]) }}"
                                                       class="cl-btn cl-btn-edit">កែសម្រួល</a>
                                                    <button type="button"
                                                            class="cl-btn cl-btn-delete"
                                                            wire:click="deleteContentItem('resource', {{ $resource->content_resource_id }})"
                                                            wire:confirm="តើអ្នកប្រាកដថាចង់លុបធនធាននេះ?">លុប</button>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            {{-- Empty state if no sub-items --}}
                            @if($lesson->chapters->isEmpty() && $lesson->videos->isEmpty() && $lesson->documents->isEmpty() && $lesson->assignments->isEmpty() && $lesson->quizzes->isEmpty() && $lesson->resources->isEmpty())
                                <div class="cl-empty-section" style="margin-top: 16px;">
                                    មេរៀននេះមិនទាន់មានមាតិកាទេ។
                                </div>
                            @endif
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</x-filament-panels::page>
