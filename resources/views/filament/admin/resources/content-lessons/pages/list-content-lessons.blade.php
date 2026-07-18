<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    @endonce

    @php
        $lessonModel = \App\Models\ContentLesson::query();
        $totalLessons = (clone $lessonModel)->count();
        $publishedLessons = (clone $lessonModel)->where('is_published', true)->count();
        $draftLessons = max(0, $totalLessons - $publishedLessons);
        $moduleCount = (clone $lessonModel)->distinct('module_number')->count('module_number');
    @endphp

    <style>
        .content-lessons-index {
            color: #0f172a;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            letter-spacing: 0;
        }

        .content-lessons-index *,
        .content-lessons-index *::before,
        .content-lessons-index *::after {
            box-sizing: border-box;
            font-family: inherit;
            letter-spacing: 0;
        }

        .content-lessons-index .fa,
        .content-lessons-index .fas,
        .content-lessons-index .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .clx-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 18px;
            padding: 20px 22px;
            border: 1px solid #dbeafe;
            border-radius: 8px;
            background:
                linear-gradient(135deg, rgba(77, 182, 242, .14), rgba(0, 179, 144, .08)),
                #ffffff;
            box-shadow: 0 14px 34px rgba(15, 23, 42, .06);
        }

        .clx-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 8px;
            color: #0f766e;
            font-size: 13px;
            font-weight: 900;
        }

        .clx-title {
            margin: 0;
            color: #071827;
            font-size: clamp(24px, 2.4vw, 34px);
            font-weight: 900;
            line-height: 1.25;
        }

        .clx-subtitle {
            margin: 6px 0 0;
            color: #64748b;
            font-size: 14px;
            font-weight: 600;
        }

        .clx-create {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            min-height: 42px;
            padding: 0 16px;
            border: 1px solid #00a884;
            border-radius: 7px;
            background: #00B390;
            color: #001f1a;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
            box-shadow: 0 12px 24px rgba(0, 179, 144, .18);
            transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease;
        }

        .clx-create:hover {
            background: #08c49d;
            color: #001f1a;
            transform: translateY(-1px);
            box-shadow: 0 16px 30px rgba(0, 179, 144, .24);
        }

        .clx-stats {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 12px;
            margin-bottom: 18px;
        }

        .clx-stat {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            min-height: 92px;
            padding: 16px 18px;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 10px 26px rgba(15, 23, 42, .045);
        }

        .clx-stat-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .clx-stat-value {
            margin-top: 5px;
            color: #0f172a;
            font-size: 26px;
            font-weight: 900;
            line-height: 1;
        }

        .clx-stat-icon {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 8px;
            background: #eef6ff;
            color: #0284c7;
            font-size: 18px;
            flex: 0 0 auto;
        }

        .clx-stat-success .clx-stat-icon {
            background: #dcfce7;
            color: #15803d;
        }

        .clx-stat-warning .clx-stat-icon {
            background: #fef3c7;
            color: #b45309;
        }

        .clx-stat-accent .clx-stat-icon {
            background: #e0f2fe;
            color: #0369a1;
        }

        .clx-table-card {
            overflow: hidden;
            border: 1px solid #dbe3ef;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 16px 38px rgba(15, 23, 42, .06);
        }

        .clx-table-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            padding: 16px 18px;
            border-bottom: 1px solid #e2e8f0;
            background: #fbfdff;
        }

        .clx-table-title {
            margin: 0;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
        }

        .clx-table-note {
            margin: 3px 0 0;
            color: #64748b;
            font-size: 13px;
            font-weight: 600;
        }

        .clx-table-wrap {
            padding: 12px;
        }

        .content-lessons-index .fi-ta-ctn {
            border: 0 !important;
            border-radius: 0 !important;
            box-shadow: none !important;
        }

        .content-lessons-index .fi-ta-header,
        .content-lessons-index .fi-ta-content,
        .content-lessons-index .fi-ta-footer {
            border-radius: 0 !important;
        }

        .content-lessons-index .fi-ta-table thead {
            background: #f8fafc !important;
        }

        .content-lessons-index .fi-ta-table th {
            color: #475569 !important;
            font-size: 12px !important;
            font-weight: 900 !important;
            text-transform: none !important;
        }

        .content-lessons-index .fi-ta-table td {
            color: #0f172a !important;
            font-size: 13px !important;
            font-weight: 650 !important;
        }

        .content-lessons-index .fi-ta-row:hover {
            background: #f0f9ff !important;
        }

        .content-lessons-index .fi-badge {
            border-radius: 6px !important;
            font-weight: 900 !important;
        }

        .fi-header-actions,
        .fi-header-actions-ctn,
        .fi-page-header-actions {
            display: none !important;
        }

        .dark .content-lessons-index {
            color: #e5e7eb;
        }

        .dark .clx-header,
        .dark .clx-stat,
        .dark .clx-table-card {
            border-color: #334155;
            background: #111827;
            box-shadow: none;
        }

        .dark .clx-header {
            background:
                linear-gradient(135deg, rgba(56, 189, 248, .12), rgba(45, 212, 191, .08)),
                #111827;
        }

        .dark .clx-title,
        .dark .clx-stat-value,
        .dark .clx-table-title,
        .dark .content-lessons-index .fi-ta-table td {
            color: #f8fafc !important;
        }

        .dark .clx-subtitle,
        .dark .clx-stat-label,
        .dark .clx-table-note {
            color: #94a3b8;
        }

        .dark .clx-table-head,
        .dark .content-lessons-index .fi-ta-table thead {
            border-color: #334155;
            background: #0f172a !important;
        }

        .dark .content-lessons-index .fi-ta-table th {
            color: #cbd5e1 !important;
        }

        .dark .content-lessons-index .fi-ta-row:hover {
            background: rgba(14, 165, 233, .12) !important;
        }

        @media (max-width: 1100px) {
            .clx-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }

        @media (max-width: 720px) {
            .clx-header,
            .clx-table-head {
                align-items: stretch;
                flex-direction: column;
            }

            .clx-stats {
                grid-template-columns: 1fr;
            }

            .clx-create {
                width: 100%;
            }
        }
    </style>

    <div class="content-lessons-index">
        <section class="clx-header">
            <div>
                <div class="clx-eyebrow">
                    <i class="fas fa-book-open"></i>
                    Lesson Management
                </div>
                <h1 class="clx-title">??????????</h1>
                <p class="clx-subtitle">?????????????? ?????? ????????????? ??????????????????????????????</p>
            </div>

            @if (\App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::canCreate())
                <a class="clx-create" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('create') }}">
                    <i class="fas fa-plus"></i>
                    ???????????
                </a>
            @endif
        </section>

        <section class="clx-stats" aria-label="Lesson summary">
            <div class="clx-stat">
                <div>
                    <div class="clx-stat-label">?????????</div>
                    <div class="clx-stat-value">{{ $totalLessons }}</div>
                </div>
                <span class="clx-stat-icon"><i class="fas fa-book"></i></span>
            </div>

            <div class="clx-stat clx-stat-success">
                <div>
                    <div class="clx-stat-label">????????</div>
                    <div class="clx-stat-value">{{ $publishedLessons }}</div>
                </div>
                <span class="clx-stat-icon"><i class="fas fa-check-circle"></i></span>
            </div>

            <div class="clx-stat clx-stat-warning">
                <div>
                    <div class="clx-stat-label">????????????</div>
                    <div class="clx-stat-value">{{ $draftLessons }}</div>
                </div>
                <span class="clx-stat-icon"><i class="fas fa-pen"></i></span>
            </div>

            <div class="clx-stat clx-stat-accent">
                <div>
                    <div class="clx-stat-label">Module</div>
                    <div class="clx-stat-value">{{ $moduleCount }}</div>
                </div>
                <span class="clx-stat-icon"><i class="fas fa-layer-group"></i></span>
            </div>
        </section>

        <section class="clx-table-card">
            <div class="clx-table-head">
                <div>
                    <h2 class="clx-table-title">????????????</h2>
                    <p class="clx-table-note">??????? ?????? ??????? ????????????????????????????????</p>
                </div>
            </div>

            <div class="clx-table-wrap">
                {{ $this->table }}
            </div>
        </section>
    </div>
</x-filament-panels::page>
