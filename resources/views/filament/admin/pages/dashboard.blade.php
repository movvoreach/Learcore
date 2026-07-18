<x-filament-panels::page>
    <style>
        .db-page {
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            color: #1e293b;
            display: grid;
            gap: 24px;
            transition: color 0.3s;
        }
        .dark .db-page {
            color: #f1f5f9;
        }

        /* 2-Column Layout */
        .db-container {
            display: grid;
            grid-template-columns: 2.3fr 1fr;
            gap: 24px;
            align-items: start;
        }
        @media (max-width: 1280px) {
            .db-container {
                grid-template-columns: 1fr;
            }
        }

        /* Cards & Widgets */
        .db-card {
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.02);
            transition: border-color 0.2s, box-shadow 0.2s;
        }
        .db-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.04);
        }
        .dark .db-card {
            background: #1e293b;
            border-color: #334155;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        }
        .dark .db-card:hover {
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
        }

        /* Welcome Banner */
        .db-banner {
            background: linear-gradient(135deg, #2563eb 0%, #3b82f6 50%, #60a5fa 100%);
            border-radius: 20px;
            color: #ffffff;
            padding: 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            position: relative;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(37, 99, 235, 0.2);
            margin-bottom: 24px;
        }
        .db-banner::before {
            content: "";
            position: absolute;
            top: -20%;
            right: -10%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(255, 255, 255, 0.15) 0%, transparent 70%);
            border-radius: 50%;
            pointer-events: none;
        }
        .db-banner-content {
            z-index: 10;
            max-width: 60%;
        }
        .db-banner-greeting {
            font-size: 14px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.9);
            margin-bottom: 8px;
        }
        .db-banner-title {
            font-size: 32px;
            font-weight: 900;
            line-height: 1.2;
            margin: 0 0 10px;
        }
        .db-banner-subtitle {
            font-size: 15px;
            color: rgba(255, 255, 255, 0.85);
            margin: 0 0 24px;
        }
        .db-banner-btn {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: #ffffff;
            color: #1d4ed8;
            font-weight: 700;
            font-size: 13px;
            padding: 10px 22px;
            border-radius: 99px;
            text-decoration: none;
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.1);
            transition: all 0.2s;
        }
        .db-banner-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.15);
            background: #f8fafc;
        }
        .db-banner-btn svg {
            width: 14px;
            height: 14px;
        }
        .db-banner-ill {
            flex-shrink: 0;
            z-index: 10;
        }

        /* Stats Grid */
        .db-stats-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        @media (max-width: 1024px) {
            .db-stats-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }
        }
        @media (max-width: 640px) {
            .db-stats-grid {
                grid-template-columns: 1fr;
            }
        }

        .db-stat-card {
            display: flex;
            align-items: center;
            gap: 16px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 16px;
            padding: 18px 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.01);
            transition: all 0.2s;
        }
        .db-stat-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.04);
        }
        .dark .db-stat-card {
            background: #1e293b;
            border-color: #334155;
        }

        .db-stat-icon {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 12px;
            font-size: 20px;
            flex-shrink: 0;
        }

        .db-stat-info {
            min-width: 0;
        }
        .db-stat-label {
            font-size: 11px;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.03em;
            margin-bottom: 2px;
        }
        .dark .db-stat-label {
            color: #94a3b8;
        }
        .db-stat-value {
            font-size: 22px;
            font-weight: 900;
            color: #0f172a;
            line-height: 1.1;
        }
        .dark .db-stat-value {
            color: #ffffff;
        }
        .db-stat-subtext {
            font-size: 11px;
            font-weight: 600;
            margin-top: 3px;
        }

        /* Lists Header */
        .section-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 16px;
            margin-top: 8px;
        }
        .section-title {
            font-size: 18px;
            font-weight: 900;
            color: #0f172a;
            margin: 0;
        }
        .dark .section-title {
            color: #ffffff;
        }
        .section-link {
            font-size: 13px;
            font-weight: 700;
            color: #2563eb;
            text-decoration: none;
            transition: color 0.2s;
        }
        .section-link:hover {
            color: #1d4ed8;
        }

        /* Continue Learning List */
        .continue-list {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            margin-bottom: 28px;
        }
        @media (max-width: 768px) {
            .continue-list {
                grid-template-columns: 1fr;
            }
        }

        .continue-card {
            display: flex;
            gap: 16px;
            align-items: center;
            padding: 16px;
        }

        .continue-thumb {
            width: 76px;
            height: 76px;
            border-radius: 12px;
            background: linear-gradient(135deg, #e0e7ff 0%, #c7d2fe 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
        }

        .continue-details {
            flex: 1;
            min-width: 0;
        }

        .continue-course-title {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 3px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dark .continue-course-title {
            color: #ffffff;
        }

        .continue-instructor {
            font-size: 12px;
            color: #64748b;
            margin-bottom: 10px;
        }
        .dark .continue-instructor {
            color: #94a3b8;
        }

        .continue-progress-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 6px;
        }
        .dark .continue-progress-row {
            color: #cbd5e1;
        }

        .progress-bar-bg {
            height: 6px;
            border-radius: 99px;
            background: #e2e8f0;
            overflow: hidden;
        }
        .dark .progress-bar-bg {
            background: #334155;
        }
        .progress-bar-fill {
            height: 100%;
            background: #3b82f6;
            border-radius: 99px;
        }

        .continue-btn {
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            border-radius: 8px;
            padding: 5px 12px;
            border: none;
            cursor: pointer;
            transition: all 0.2s;
            text-decoration: none;
        }
        .continue-btn:hover {
            background: #2563eb;
            color: #ffffff;
        }
        .dark .continue-btn {
            background: rgba(37, 99, 235, 0.15);
            color: #60a5fa;
        }
        .dark .continue-btn:hover {
            background: #2563eb;
            color: #ffffff;
        }

        /* My Courses Grid */
        .courses-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 20px;
        }
        @media (max-width: 768px) {
            .courses-grid {
                grid-template-columns: 1fr;
            }
        }

        .course-item-card {
            padding: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
        }

        .course-thumb-container {
            height: 140px;
            position: relative;
            background: linear-gradient(135deg, #1e1b4b 0%, #311042 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 40px;
            color: #ffffff;
        }

        .course-tag {
            position: absolute;
            top: 12px;
            left: 12px;
            background: #f59e0b;
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            padding: 3px 10px;
            border-radius: 99px;
            text-transform: uppercase;
        }

        .course-heart {
            position: absolute;
            top: 12px;
            right: 12px;
            background: rgba(255, 255, 255, 0.9);
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ef4444;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }

        .course-body {
            padding: 20px;
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .course-level {
            font-size: 10px;
            font-weight: 700;
            text-transform: uppercase;
            color: #10b981;
            margin-bottom: 6px;
        }

        .course-item-title {
            font-size: 16px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 10px;
            line-height: 1.35;
        }
        .dark .course-item-title {
            color: #ffffff;
        }

        .course-rating-row {
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 12px;
            color: #64748b;
            margin-bottom: 16px;
        }
        .dark .course-rating-row {
            color: #94a3b8;
        }
        .rating-val {
            color: #f59e0b;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 3px;
        }

        .course-meta-icons {
            display: flex;
            align-items: center;
            gap: 16px;
            font-size: 12px;
            color: #64748b;
            border-top: 1px solid #eef2f7;
            padding-top: 14px;
            margin-top: auto;
        }
        .dark .course-meta-icons {
            color: #94a3b8;
            border-color: #334155;
        }
        .meta-icon-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-weight: 600;
        }
        .meta-icon-item svg {
            width: 15px;
            height: 15px;
        }

        /* Sidebar Widgets (Right Side) */
        .right-sidebar {
            display: grid;
            gap: 20px;
        }

        /* Goal Widget */
        .goal-content {
            display: flex;
            align-items: center;
            gap: 18px;
            margin-top: 10px;
        }
        .goal-info {
            min-width: 0;
        }
        .goal-title {
            font-size: 15px;
            font-weight: 800;
            color: #0f172a;
            margin: 0 0 4px;
        }
        .dark .goal-title {
            color: #ffffff;
        }
        .goal-sub {
            font-size: 12px;
            color: #64748b;
        }
        .dark .goal-sub {
            color: #94a3b8;
        }

        /* Learning Streak */
        .streak-val {
            font-size: 28px;
            font-weight: 900;
            color: #0f172a;
            margin: 10px 0 16px;
        }
        .dark .streak-val {
            color: #ffffff;
        }
        .streak-days {
            display: flex;
            justify-content: space-between;
            gap: 4px;
        }
        .day-dot {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            border: 1px solid #cbd5e1;
            color: #475569;
        }
        .dark .day-dot {
            border-color: #475569;
            color: #cbd5e1;
        }
        .day-dot.completed {
            background: #22c55e;
            border-color: #22c55e;
            color: #ffffff;
        }
        .day-dot.active {
            background: #2563eb;
            border-color: #2563eb;
            color: #ffffff;
        }
        .day-dot.dot {
            border-color: #e2e8f0;
            background: #f8fafc;
            color: #94a3b8;
        }
        .dark .day-dot.dot {
            border-color: #334155;
            background: #1e293b;
            color: #64748b;
        }

        /* Quote Card */
        .quote-card {
            background: linear-gradient(135deg, #1e1b4b 0%, #311042 100%);
            color: #ffffff;
            position: relative;
            overflow: hidden;
            border: none;
        }
        .quote-card::after {
            content: "";
            position: absolute;
            bottom: -30px;
            right: -30px;
            width: 110px;
            height: 110px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.25) 0%, transparent 70%);
            border-radius: 50%;
        }
        .quote-icon {
            font-size: 40px;
            font-weight: 900;
            line-height: 1;
            color: rgba(255, 255, 255, 0.25);
            margin-bottom: -10px;
        }
        .quote-text {
            font-size: 14px;
            font-style: italic;
            line-height: 1.6;
            margin: 0 0 12px;
            position: relative;
            z-index: 10;
        }
        .quote-author {
            font-size: 12px;
            font-weight: 700;
            color: rgba(255, 255, 255, 0.7);
            margin: 0;
            position: relative;
            z-index: 10;
        }

        /* Deadline List */
        .deadline-list {
            display: grid;
            gap: 12px;
            margin-top: 12px;
        }
        .deadline-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .deadline-info {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
        }
        .deadline-icon-box {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            background: #f1f5f9;
            color: #64748b;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        .dark .deadline-icon-box {
            background: #1e293b;
            color: #94a3b8;
        }
        .deadline-icon-box svg {
            width: 16px;
            height: 16px;
        }
        .deadline-title {
            font-size: 12px;
            font-weight: 750;
            color: #0f172a;
            margin: 0 0 2px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dark .deadline-title {
            color: #ffffff;
        }
        .deadline-due {
            font-size: 11px;
            color: #64748b;
        }
        .dark .deadline-due {
            color: #94a3b8;
        }
        .deadline-priority {
            font-size: 10px;
            font-weight: 800;
            padding: 2px 8px;
            border-radius: 4px;
            text-transform: uppercase;
        }
        .priority-high {
            background: #fee2e2;
            color: #ef4444;
        }
        .dark .priority-high {
            background: rgba(239, 68, 68, 0.15);
        }
        .priority-medium {
            background: #fef3c7;
            color: #d97706;
        }
        .dark .priority-medium {
            background: rgba(217, 119, 6, 0.15);
        }

        /* Message List */
        .msg-list {
            display: grid;
            gap: 16px;
            margin-top: 12px;
        }
        .msg-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
        }
        .msg-sender {
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: 0;
        }
        .msg-avatar {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: linear-gradient(135deg, #cbd5e1 0%, #94a3b8 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 14px;
            font-weight: 700;
            color: #ffffff;
            flex-shrink: 0;
        }
        .msg-body-content {
            min-width: 0;
        }
        .msg-name {
            font-size: 12px;
            font-weight: 850;
            color: #0f172a;
            margin: 0 0 2px;
        }
        .dark .msg-name {
            color: #ffffff;
        }
        .msg-preview {
            font-size: 11px;
            color: #64748b;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .dark .msg-preview {
            color: #94a3b8;
        }
        .msg-right {
            text-align: right;
            font-size: 10px;
            color: #94a3b8;
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            gap: 4px;
            flex-shrink: 0;
        }
        .msg-dot {
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #3b82f6;
        }

        /* Friends Online */
        .friends-list {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 12px;
        }
        .friend-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            border: 2px solid #ffffff;
            background: linear-gradient(135deg, #e2e8f0 0%, #cbd5e1 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 11px;
            font-weight: 700;
            color: #475569;
            margin-left: -8px;
            flex-shrink: 0;
        }
        .dark .friend-avatar {
            border-color: #1e293b;
            color: #cbd5e1;
        }
        .friend-avatar:first-child {
            margin-left: 0;
        }
        .friend-avatar.more {
            background: #eff6ff;
            color: #1d4ed8;
            font-size: 11px;
            font-weight: 700;
            border-color: #ffffff;
        }
        .dark .friend-avatar.more {
            background: #1e293b;
            color: #60a5fa;
            border-color: #1e293b;
        }
    </style>

    <div class="db-page">
        @if ($mode === 'student')
            @if (! $student)
                <section class="db-card">
                    <h2 class="section-title">Student Profile Not Linked</h2>
                    <p style="color: #64748b; margin-top: 8px;">Please request your system administrator to associate your User account with a Student record in the system.</p>
                </section>
            @else
                <div class="db-container">
                    {{-- Left Column (Main Board) --}}
                    <div>
                        {{-- Welcome Banner --}}
                        <div class="db-banner">
                            <div class="db-banner-content">
                                <div class="db-banner-greeting">Good Morning, {{ auth()->user()->name }}! 👋</div>
                                <h1 class="db-banner-title">Welcome back,</h1>
                                <p class="db-banner-subtitle">Continue your learning journey and achieve your academic goals.</p>
                                <a href="#continue-learning" class="db-banner-btn">
                                    Continue Learning
                                    <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"/></svg>
                                </a>
                            </div>
                            <div class="db-banner-ill">
                                <svg width="220" height="150" viewBox="0 0 220 150" fill="none">
                                    <circle cx="160" cy="80" r="45" fill="white" fill-opacity="0.12" />
                                    <rect x="30" y="30" width="130" height="90" rx="10" fill="white" fill-opacity="0.08" stroke="white" stroke-opacity="0.15" stroke-width="1.5" />
                                    <path d="M110 50 L125 75 L95 75 Z" fill="white" fill-opacity="0.25" />
                                    <rect x="70" y="85" width="50" height="25" rx="4" fill="white" fill-opacity="0.15" />
                                    <circle cx="50" cy="50" r="8" fill="#f59e0b" />
                                    <circle cx="140" cy="100" r="6" fill="#10b981" />
                                    <!-- Laptop stand drawing -->
                                    <path d="M20 130 L200 130" stroke="white" stroke-opacity="0.2" stroke-width="3" stroke-linecap="round" />
                                </svg>
                            </div>
                        </div>

                        {{-- 10-Statistics Cards Grid --}}
                        <div class="db-stats-grid">
                            {{-- 1. Total Courses --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #eff6ff; color: #2563eb;">📚</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Total Courses</div>
                                    <div class="db-stat-value">{{ $courses->count() }}</div>
                                    <div class="db-stat-subtext" style="color: #16a34a;">+2 this month</div>
                                </div>
                            </div>

                            {{-- 2. Current Courses --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #f0fdf4; color: #16a34a;">⏳</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Current Courses</div>
                                    <div class="db-stat-value">{{ $courses->where('lessons_count', '>', 0)->count() ?: 1 }}</div>
                                    <div class="db-stat-subtext" style="color: #64748b;">In Progress</div>
                                </div>
                            </div>

                            {{-- 3. Completed Courses --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #f5f3ff; color: #7c3aed;">🏆</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Completed Courses</div>
                                    <div class="db-stat-value">{{ $progressByCourse->where('progress_percent', 100)->count() }}</div>
                                    <div class="db-stat-subtext" style="color: #16a34a;">+4 this month</div>
                                </div>
                            </div>

                            {{-- 4. Certificates Earned --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #fff7ed; color: #ea580c;">🎖</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Certificates Earned</div>
                                    <div class="db-stat-value">{{ $student->certificates->count() }}</div>
                                    <div class="db-stat-subtext" style="color: #2563eb; cursor: pointer;">View All</div>
                                </div>
                            </div>

                            {{-- 5. Assignments Pending --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #fff1f2; color: #e11d48;">📝</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Pending Tasks</div>
                                    <div class="db-stat-value">{{ $assignments->count() }}</div>
                                    <div class="db-stat-subtext" style="color: #e11d48;">Due Soon</div>
                                </div>
                            </div>

                            {{-- 6. Quizzes Completed --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #f0fdfa; color: #0d9488;">✓</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Quizzes Finished</div>
                                    <div class="db-stat-value">18</div>
                                    <div class="db-stat-subtext" style="color: #64748b;">This Month</div>
                                </div>
                            </div>

                            {{-- 7. Average Score --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #fffbeb; color: #d97706;">⭐</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Average Score</div>
                                    <div class="db-stat-value">85%</div>
                                    <div class="db-stat-subtext" style="color: #16a34a;">+5% this month</div>
                                </div>
                            </div>

                            {{-- 8. Learning Hours --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #f8fafc; color: #475569;">⏱</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Learning Hours</div>
                                    <div class="db-stat-value">48h 30m</div>
                                    <div class="db-stat-subtext" style="color: #64748b;">This Month</div>
                                </div>
                            </div>

                            {{-- 9. Attendance --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #fdf2f8; color: #db2777;">🗓</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Attendance</div>
                                    <div class="db-stat-value">92%</div>
                                    <div class="db-stat-subtext" style="color: #64748b;">This Month</div>
                                </div>
                            </div>

                            {{-- 10. Ranking --}}
                            <div class="db-stat-card">
                                <div class="db-stat-icon" style="background: #ecfeff; color: #0891b2;">🎖</div>
                                <div class="db-stat-info">
                                    <div class="db-stat-label">Ranking</div>
                                    <div class="db-stat-value">#4</div>
                                    <div class="db-stat-subtext" style="color: #0891b2;">Top 10%</div>
                                </div>
                            </div>
                        </div>

                        {{-- Continue Learning --}}
                        <div id="continue-learning">
                            <div class="section-header">
                                <h3 class="section-title">Continue Learning</h3>
                                <a href="#" class="section-link">View All</a>
                            </div>

                            <div class="continue-list">
                                @forelse ($courses->take(4) as $course)
                                    @php
                                        $progress = (float) optional($progressByCourse->get($course->course_id))->progress_percent;
                                        $teacher = $course->courseAssignments->first()?->teacher;
                                        $teacherName = $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'No teacher';
                                    @endphp
                                    <div class="db-card continue-card">
                                        <div class="continue-thumb">
                                            {{ mb_strtoupper(mb_substr($course->course_name, 0, 1)) }}
                                        </div>
                                        <div class="continue-details">
                                            <h4 class="continue-course-title">{{ $course->course_name }}</h4>
                                            <div class="continue-instructor">{{ $teacherName }}</div>
                                            <div class="continue-progress-row">
                                                <span>{{ $course->lessons_count }} Lessons</span>
                                                <span>{{ number_format($progress, 0) }}%</span>
                                            </div>
                                            <div class="progress-bar-bg" style="margin-bottom: 12px;">
                                                <div class="progress-bar-fill" style="width: {{ min(100, max(0, $progress)) }}%;"></div>
                                            </div>
                                            <a class="continue-btn" href="{{ \App\Filament\Admin\Pages\StudentCourse::getUrl(['course' => $course->course_id]) }}">
                                                Resume
                                            </a>
                                        </div>
                                    </div>
                                @empty
                                    <div class="db-card" style="grid-column: span 2;">
                                        <p style="color: #64748b; margin: 0;">No active courses found.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>

                        {{-- My Courses --}}
                        <div>
                            <div class="section-header">
                                <h3 class="section-title">My Courses</h3>
                                <a href="#" class="section-link">View All</a>
                            </div>

                            <div class="courses-grid">
                                @forelse ($courses as $course)
                                    @php
                                        $progress = (float) optional($progressByCourse->get($course->course_id))->progress_percent;
                                        $teacher = $course->courseAssignments->first()?->teacher;
                                        $teacherName = $teacher ? trim($teacher->first_name.' '.$teacher->last_name) : 'Teacher unassigned';
                                    @endphp
                                    <div class="db-card course-item-card">
                                        <div class="course-thumb-container">
                                            {{ mb_strtoupper(mb_substr($course->course_name, 0, 1)) }}
                                            <span class="course-tag">Popular</span>
                                            <div class="course-heart">♥</div>
                                        </div>
                                        <div class="course-body">
                                            <div>
                                                <div class="course-level">Beginner</div>
                                                <h4 class="course-item-title">{{ $course->course_name }}</h4>
                                                <div class="course-rating-row">
                                                    <span class="rating-val">⭐ 4.8</span>
                                                    <span>(1.2k ratings)</span>
                                                    <span>· {{ $teacherName }}</span>
                                                </div>
                                            </div>

                                            <div class="continue-progress-row" style="margin-bottom: 6px;">
                                                <span>Progress</span>
                                                <span>{{ number_format($progress, 0) }}%</span>
                                            </div>
                                            <div class="progress-bar-bg" style="margin-bottom: 16px;">
                                                <div class="progress-bar-fill" style="width: {{ min(100, max(0, $progress)) }}%;"></div>
                                            </div>

                                            <div class="course-meta-icons">
                                                <div class="meta-icon-item">
                                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                                    12h 30m
                                                </div>
                                                <div class="meta-icon-item">
                                                    <svg fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                                    {{ $course->lessons_count }} Lessons
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @empty
                                    <div class="db-card" style="grid-column: span 2;">
                                        <p style="color: #64748b; margin: 0;">No courses assigned.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Right Column (Sidebar widgets) --}}
                    <div class="right-sidebar">
                        {{-- Today's Goal --}}
                        <div class="db-card">
                            <div class="section-header" style="margin: 0 0 10px;">
                                <h4 class="goal-title" style="font-size: 14px; font-weight: 850;">Today's Goal</h4>
                                <a href="#" class="section-link" style="font-size: 11px;">Edit Goal</a>
                            </div>
                            <div class="goal-content">
                                <svg width="76" height="76" viewBox="0 0 80 80">
                                    <circle cx="40" cy="40" r="32" stroke="#f1f5f9" stroke-width="6" fill="transparent" />
                                    <circle cx="40" cy="40" r="32" stroke="#2563eb" stroke-width="6" fill="transparent" stroke-dasharray="201" stroke-dashoffset="50.25" stroke-linecap="round" />
                                    <text x="40" y="46" font-size="15" font-weight="900" text-anchor="middle" fill="#0f172a">75%</text>
                                </svg>
                                <div class="goal-info">
                                    <div class="goal-title">3 of 4 Completed</div>
                                    <div class="goal-sub">Keep it up! You're doing great.</div>
                                </div>
                            </div>
                        </div>

                        {{-- Learning Streak --}}
                        <div class="db-card">
                            <div class="goal-title" style="font-size: 14px; font-weight: 850;">Learning Streak 🔥</div>
                            <div class="streak-val">12 <span style="font-size: 14px; font-weight: 600; color: #64748b;">Days</span></div>
                            <div class="streak-days">
                                <span class="day-dot completed">M</span>
                                <span class="day-dot completed">T</span>
                                <span class="day-dot completed">W</span>
                                <span class="day-dot completed">T</span>
                                <span class="day-dot active">F</span>
                                <span class="day-dot dot">S</span>
                                <span class="day-dot dot">S</span>
                            </div>
                        </div>

                        {{-- Quote Card --}}
                        <div class="db-card quote-card">
                            <div class="quote-icon">“</div>
                            <p class="quote-text">The beautiful thing about learning is that no one can take it away from you.</p>
                            <h5 class="quote-author">- B.B. King</h5>
                        </div>

                        {{-- Upcoming Deadlines --}}
                        <div class="db-card">
                            <div class="section-header" style="margin: 0 0 12px;">
                                <h4 class="goal-title" style="font-size: 14px; font-weight: 850;">Upcoming Deadlines</h4>
                                <a href="#" class="section-link" style="font-size: 11px;">View All</a>
                            </div>
                            <div class="deadline-list">
                                <div class="deadline-item">
                                    <div class="deadline-info">
                                        <div class="deadline-icon-box">
                                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                                        </div>
                                        <div>
                                            <div class="deadline-title">UI/UX Design Assignment</div>
                                            <div class="deadline-due">Due in 2 days</div>
                                        </div>
                                    </div>
                                    <span class="deadline-priority priority-high">High</span>
                                </div>
                                <div class="deadline-item">
                                    <div class="deadline-info">
                                        <div class="deadline-icon-box">
                                            <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <div>
                                            <div class="deadline-title">Database System Quiz</div>
                                            <div class="deadline-due">Due in 4 days</div>
                                        </div>
                                    </div>
                                    <span class="deadline-priority priority-medium">Medium</span>
                                </div>
                            </div>
                        </div>

                        {{-- Recent Messages --}}
                        <div class="db-card">
                            <div class="section-header" style="margin: 0 0 12px;">
                                <h4 class="goal-title" style="font-size: 14px; font-weight: 850;">Recent Messages</h4>
                                <a href="#" class="section-link" style="font-size: 11px;">View All</a>
                            </div>
                            <div class="msg-list">
                                <div class="msg-item">
                                    <div class="msg-sender">
                                        <div class="msg-avatar" style="background: linear-gradient(135deg, #3b82f6 0%, #1d4ed8 100%);">DS</div>
                                        <div class="msg-body-content">
                                            <div class="msg-name">David Smith</div>
                                            <div class="msg-preview">Hey! Can you share the notes?</div>
                                        </div>
                                    </div>
                                    <div class="msg-right">
                                        <div>10m ago</div>
                                        <span class="msg-dot"></span>
                                    </div>
                                </div>
                                <div class="msg-item">
                                    <div class="msg-sender">
                                        <div class="msg-avatar" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">SJ</div>
                                        <div class="msg-body-content">
                                            <div class="msg-name">Sarah Johnson</div>
                                            <div class="msg-preview">About tomorrow's lecture timing...</div>
                                        </div>
                                    </div>
                                    <div class="msg-right">
                                        <div>1h ago</div>
                                    </div>
                                </div>
                                <div class="msg-item">
                                    <div class="msg-sender">
                                        <div class="msg-avatar" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">MB</div>
                                        <div class="msg-body-content">
                                            <div class="msg-name">Michael Brown</div>
                                            <div class="msg-preview">Thanks for the help!</div>
                                        </div>
                                    </div>
                                    <div class="msg-right">
                                        <div>3h ago</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        {{-- Friends Online --}}
                        <div class="db-card">
                            <div class="section-header" style="margin: 0 0 10px;">
                                <h4 class="goal-title" style="font-size: 14px; font-weight: 850;">Friends Online</h4>
                                <a href="#" class="section-link" style="font-size: 11px;">View All</a>
                            </div>
                            <div class="friends-list">
                                <div class="friend-avatar" style="background: linear-gradient(135deg, #93c5fd 0%, #1d4ed8 100%);">AD</div>
                                <div class="friend-avatar" style="background: linear-gradient(135deg, #a7f3d0 0%, #059669 100%);">LM</div>
                                <div class="friend-avatar" style="background: linear-gradient(135deg, #fde68a 0%, #d97706 100%);">KT</div>
                                <div class="friend-avatar" style="background: linear-gradient(135deg, #fbcfe8 0%, #db2777 100%);">PR</div>
                                <div class="friend-avatar" style="background: linear-gradient(135deg, #ddd 0%, #555 100%);">JS</div>
                                <div class="friend-avatar more">+12</div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        @elseif ($mode === 'teacher')
            {{-- ═══════════════════════════════════════════════════════════ --}}
            {{-- TEACHER DASHBOARD                                          --}}
            {{-- ═══════════════════════════════════════════════════════════ --}}
            <style>
                .teacher-banner {
                    background: linear-gradient(135deg, #7c3aed 0%, #6366f1 50%, #818cf8 100%);
                    border-radius: 20px;
                    color: #ffffff;
                    padding: 36px 40px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    position: relative;
                    overflow: hidden;
                    box-shadow: 0 10px 30px rgba(124, 58, 237, 0.25);
                    margin-bottom: 28px;
                }
                .teacher-banner::before {
                    content: "";
                    position: absolute;
                    top: -30%;
                    right: -8%;
                    width: 280px;
                    height: 280px;
                    background: radial-gradient(circle, rgba(255,255,255,0.12) 0%, transparent 70%);
                    border-radius: 50%;
                    pointer-events: none;
                }
                .teacher-banner-content { z-index: 10; max-width: 60%; }
                .teacher-banner-greeting {
                    font-size: 13px; font-weight: 700; text-transform: uppercase;
                    letter-spacing: 0.06em; color: rgba(255,255,255,0.85); margin-bottom: 6px;
                }
                .teacher-banner-title {
                    font-size: 28px; font-weight: 900; line-height: 1.2; margin: 0 0 8px;
                }
                .teacher-banner-subtitle {
                    font-size: 14px; color: rgba(255,255,255,0.8); margin: 0;
                }

                .teacher-stats-grid {
                    display: grid;
                    grid-template-columns: repeat(3, minmax(0, 1fr));
                    gap: 16px;
                    margin-bottom: 28px;
                }
                @media (max-width: 1024px) {
                    .teacher-stats-grid { grid-template-columns: repeat(2, minmax(0, 1fr)); }
                }
                @media (max-width: 640px) {
                    .teacher-stats-grid { grid-template-columns: 1fr; }
                }
                .teacher-stat-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 16px;
                    padding: 20px;
                    display: flex;
                    align-items: center;
                    gap: 16px;
                    text-decoration: none;
                    color: inherit;
                    transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
                    box-shadow: 0 2px 8px rgba(0,0,0,0.02);
                }
                .teacher-stat-card:hover {
                    transform: translateY(-3px);
                    box-shadow: 0 12px 28px rgba(0,0,0,0.06);
                    border-color: #c4b5fd;
                }
                .dark .teacher-stat-card {
                    background: #1e293b;
                    border-color: #334155;
                }
                .dark .teacher-stat-card:hover {
                    border-color: #6366f1;
                    box-shadow: 0 12px 28px rgba(0,0,0,0.2);
                }
                .teacher-stat-icon {
                    width: 48px;
                    height: 48px;
                    border-radius: 14px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 22px;
                    flex-shrink: 0;
                }
                .teacher-stat-info { min-width: 0; flex: 1; }
                .teacher-stat-label {
                    font-size: 12px; font-weight: 600; color: #64748b;
                    margin-bottom: 4px; text-transform: uppercase; letter-spacing: 0.03em;
                }
                .dark .teacher-stat-label { color: #94a3b8; }
                .teacher-stat-value {
                    font-size: 26px; font-weight: 800; color: #0f172a; line-height: 1;
                }
                .dark .teacher-stat-value { color: #f1f5f9; }
                .teacher-stat-sub {
                    font-size: 11px; color: #94a3b8; margin-top: 2px;
                }

                .teacher-section-title {
                    font-size: 18px;
                    font-weight: 800;
                    color: #0f172a;
                    margin: 0 0 16px;
                    display: flex;
                    align-items: center;
                    gap: 8px;
                }
                .dark .teacher-section-title { color: #f1f5f9; }

                .teacher-course-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 14px;
                    padding: 18px 20px;
                    display: flex;
                    align-items: center;
                    gap: 14px;
                    transition: all 0.2s;
                }
                .teacher-course-card:hover {
                    box-shadow: 0 6px 20px rgba(0,0,0,0.04);
                    border-color: #c4b5fd;
                }
                .dark .teacher-course-card {
                    background: #1e293b;
                    border-color: #334155;
                }
                .teacher-course-icon {
                    width: 42px; height: 42px; border-radius: 12px;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 18px; flex-shrink: 0;
                }
                .teacher-course-info { min-width: 0; flex: 1; }
                .teacher-course-name {
                    font-size: 14px; font-weight: 700; color: #0f172a;
                    white-space: nowrap; overflow: hidden; text-overflow: ellipsis;
                }
                .dark .teacher-course-name { color: #f1f5f9; }
                .teacher-course-meta {
                    font-size: 11px; color: #64748b; margin-top: 2px;
                }
                .dark .teacher-course-meta { color: #94a3b8; }
                .teacher-course-badge {
                    font-size: 11px; font-weight: 700; padding: 4px 12px;
                    border-radius: 20px; background: #f0fdf4; color: #16a34a;
                    white-space: nowrap;
                }
                .dark .teacher-course-badge {
                    background: rgba(22, 163, 106, 0.15);
                }

                .teacher-submission-item {
                    display: flex;
                    align-items: center;
                    gap: 12px;
                    padding: 12px 0;
                    border-bottom: 1px solid #f1f5f9;
                }
                .teacher-submission-item:last-child { border-bottom: none; }
                .dark .teacher-submission-item { border-color: #1e293b; }
                .teacher-sub-avatar {
                    width: 36px; height: 36px; border-radius: 10px;
                    display: flex; align-items: center; justify-content: center;
                    font-size: 14px; font-weight: 700; color: #fff; flex-shrink: 0;
                }
                .teacher-sub-info { min-width: 0; flex: 1; }
                .teacher-sub-name {
                    font-size: 13px; font-weight: 700; color: #0f172a;
                }
                .dark .teacher-sub-name { color: #f1f5f9; }
                .teacher-sub-detail {
                    font-size: 11px; color: #64748b; margin-top: 1px;
                }
                .dark .teacher-sub-detail { color: #94a3b8; }
                .teacher-sub-time {
                    font-size: 10px; color: #94a3b8; white-space: nowrap;
                }

                .teacher-no-profile {
                    text-align: center;
                    padding: 60px 20px;
                }
                .teacher-no-profile-icon {
                    font-size: 48px; margin-bottom: 16px;
                }
                .teacher-no-profile h2 {
                    font-size: 20px; font-weight: 800; color: #0f172a; margin: 0 0 8px;
                }
                .dark .teacher-no-profile h2 { color: #f1f5f9; }
                .teacher-no-profile p {
                    color: #64748b; font-size: 14px;
                }
            </style>

            @if (! $teacher)
                <section class="db-card teacher-no-profile">
                    <div class="teacher-no-profile-icon">👨‍🏫</div>
                    <h2>គណនីគ្រូបង្រៀនមិនទាន់ត្រូវបានភ្ជាប់</h2>
                    <p>សូមទាក់ទងអ្នកគ្រប់គ្រងប្រព័ន្ធដើម្បីភ្ជាប់គណនីអ្នកប្រើប្រាស់របស់អ្នកជាមួយកំណត់ត្រាគ្រូបង្រៀន។</p>
                </section>
            @else
                {{-- Welcome Banner --}}
                <div class="teacher-banner">
                    <div class="teacher-banner-content">
                        <div class="teacher-banner-greeting">សួស្តី, {{ auth()->user()->name }}! 👋</div>
                        <h1 class="teacher-banner-title">ផ្ទាំងគ្រប់គ្រងគ្រូបង្រៀន</h1>
                        <p class="teacher-banner-subtitle">គ្រប់គ្រងវគ្គសិក្សា សិស្ស និងមាតិកាសិក្សារបស់អ្នក។</p>
                    </div>
                    <div style="z-index: 10;">
                        <svg width="180" height="120" viewBox="0 0 180 120" fill="none">
                            <circle cx="130" cy="60" r="40" fill="white" fill-opacity="0.1"/>
                            <rect x="20" y="25" width="100" height="70" rx="8" fill="white" fill-opacity="0.08" stroke="white" stroke-opacity="0.15" stroke-width="1.5"/>
                            <path d="M70 45 L85 65 L55 65 Z" fill="white" fill-opacity="0.2"/>
                            <circle cx="40" cy="40" r="6" fill="#f59e0b"/>
                            <circle cx="120" cy="85" r="5" fill="#10b981"/>
                            <rect x="50" y="72" width="40" height="15" rx="3" fill="white" fill-opacity="0.12"/>
                        </svg>
                    </div>
                </div>

                {{-- Stats Grid --}}
                <div class="teacher-stats-grid">
                    <a href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #ede9fe; color: #7c3aed;">📚</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">វគ្គសិក្សារបស់ខ្ញុំ</div>
                            <div class="teacher-stat-value">{{ $myCourses->count() }}</div>
                            <div class="teacher-stat-sub">My Courses</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('create') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #dbeafe; color: #2563eb;">➕</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">បង្កើតវគ្គសិក្សា</div>
                            <div class="teacher-stat-value" style="font-size: 16px;">បង្កើតថ្មី</div>
                            <div class="teacher-stat-sub">Create Course</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #fef3c7; color: #d97706;">📖</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">មាតិកាវគ្គសិក្សា</div>
                            <div class="teacher-stat-value">{{ $myCourses->sum('content_lessons_count') }}</div>
                            <div class="teacher-stat-sub">Course Content (Lessons)</div>
                        </div>
                    </a>

                    <div class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #f0fdf4; color: #16a34a;">👥</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">សិស្សក្នុងវគ្គសិក្សា</div>
                            <div class="teacher-stat-value">{{ $totalStudents }}</div>
                            <div class="teacher-stat-sub">Students</div>
                        </div>
                    </div>

                    <a href="{{ \App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #fce7f3; color: #db2777;">📝</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">កិច្ចការ</div>
                            <div class="teacher-stat-value">{{ $totalAssignments }}</div>
                            <div class="teacher-stat-sub">Assignments</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\Exams\ExamResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #e0f2fe; color: #0284c7;">🧪</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">តេស្ត / ប្រឡង</div>
                            <div class="teacher-stat-value">{{ $totalQuizzes }}</div>
                            <div class="teacher-stat-sub">Quizzes / Exams</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #fef9c3; color: #ca8a04;">📊</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">សៀវភៅពិន្ទុ</div>
                            <div class="teacher-stat-value">{{ $totalGrades }}</div>
                            <div class="teacher-stat-sub">Gradebook</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\Attendances\AttendanceResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #ecfdf5; color: #059669;">✅</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">វត្តមាន</div>
                            <div class="teacher-stat-value">{{ $totalAttendance }}</div>
                            <div class="teacher-stat-sub">Attendance</div>
                        </div>
                    </a>

                    <a href="{{ \App\Filament\Admin\Resources\Certificates\CertificateResource::getUrl('index') }}" class="teacher-stat-card">
                        <div class="teacher-stat-icon" style="background: #fdf2f8; color: #e11d48;">🏆</div>
                        <div class="teacher-stat-info">
                            <div class="teacher-stat-label">វិញ្ញាបនបត្រ</div>
                            <div class="teacher-stat-value">{{ $totalCertificates }}</div>
                            <div class="teacher-stat-sub">Certificates</div>
                        </div>
                    </a>
                </div>

                {{-- Two Column Layout --}}
                <div class="db-container">
                    {{-- My Courses --}}
                    <div>
                        <div class="db-card">
                            <h3 class="teacher-section-title">📚 វគ្គសិក្សារបស់ខ្ញុំ — My Courses</h3>
                            <div style="display: grid; gap: 10px;">
                                @forelse ($myCourses as $course)
                                    <div class="teacher-course-card">
                                        <div class="teacher-course-icon" style="background: #ede9fe; color: #7c3aed;">📘</div>
                                        <div class="teacher-course-info">
                                            <div class="teacher-course-name">{{ $course->course_name }}</div>
                                            <div class="teacher-course-meta">
                                                {{ $course->department?->department_name }} · {{ $course->academicYear?->year_name }} · {{ $course->semester?->semester_name }}
                                            </div>
                                        </div>
                                        <span class="teacher-course-badge">{{ $course->content_lessons_count }} មេរៀន</span>
                                    </div>
                                @empty
                                    <div style="text-align: center; padding: 30px; color: #94a3b8;">
                                        <div style="font-size: 32px; margin-bottom: 8px;">📭</div>
                                        <p>មិនមានវគ្គសិក្សាដែលបានចាត់តាំង។</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>

                    {{-- Right Sidebar --}}
                    <div class="right-sidebar">
                        {{-- Teacher Info --}}
                        <div class="db-card">
                            <h3 class="teacher-section-title">👤 ព័ត៌មានគ្រូ</h3>
                            <div style="display: grid; gap: 8px; font-size: 13px;">
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b;">ឈ្មោះ</span>
                                    <span style="font-weight: 700;">{{ $teacher->first_name }} {{ $teacher->last_name }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b;">នាយកដ្ឋាន</span>
                                    <span style="font-weight: 700;">{{ $teacher->department?->department_name ?? '—' }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b;">ឯកទេស</span>
                                    <span style="font-weight: 700;">{{ $teacher->specialization ?? '—' }}</span>
                                </div>
                                <div style="display: flex; justify-content: space-between;">
                                    <span style="color: #64748b;">ស្ថានភាព</span>
                                    <span style="font-weight: 700; color: #16a34a;">{{ ucfirst($teacher->status) }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Recent Submissions --}}
                        <div class="db-card">
                            <h3 class="teacher-section-title">📬 ការដាក់ស្នើថ្មីៗ</h3>
                            @forelse ($recentSubmissions as $sub)
                                <div class="teacher-submission-item">
                                    @php
                                        $colors = ['#6366f1', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', '#ec4899', '#14b8a6', '#f97316'];
                                        $color = $colors[$loop->index % count($colors)];
                                        $initials = strtoupper(substr($sub->student?->first_name ?? 'S', 0, 1) . substr($sub->student?->last_name ?? 'T', 0, 1));
                                    @endphp
                                    <div class="teacher-sub-avatar" style="background: {{ $color }};">{{ $initials }}</div>
                                    <div class="teacher-sub-info">
                                        <div class="teacher-sub-name">{{ $sub->student?->first_name }} {{ $sub->student?->last_name }}</div>
                                        <div class="teacher-sub-detail">{{ $sub->assignment?->lesson?->course?->course_name }}</div>
                                    </div>
                                    <div class="teacher-sub-time">{{ $sub->created_at?->diffForHumans() }}</div>
                                </div>
                            @empty
                                <div style="text-align: center; padding: 20px; color: #94a3b8;">
                                    <p style="font-size: 13px;">មិនមានការដាក់ស្នើថ្មីៗ។</p>
                                </div>
                            @endforelse
                        </div>
                    </div>
                </div>
            @endif
        @else
            {{-- Admin/Teacher Dashboard --}}
            <style>
                .admin-stats-grid {
                    display: grid;
                    grid-template-columns: repeat(2, minmax(0, 1fr));
                    gap: 24px;
                    margin-bottom: 24px;
                }
                @media (max-width: 1024px) {
                    .admin-stats-grid {
                        grid-template-columns: 1fr;
                    }
                }
                .admin-stat-card {
                    background: #ffffff;
                    border: 1px solid #e2e8f0;
                    border-radius: 4px;
                    padding: 24px;
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    box-shadow: 0 1px 3px rgba(0,0,0,0.05);
                    color: inherit;
                    text-decoration: none;
                    cursor: pointer;
                    transition: border-color 0.2s, box-shadow 0.2s, transform 0.2s;
                }
                .admin-stat-card:hover {
                    border-color: #cbd5e1;
                    box-shadow: 0 10px 24px rgba(15,23,42,0.08);
                    transform: translateY(-2px);
                }
                .admin-stat-card:focus-visible {
                    outline: 3px solid rgba(37, 99, 235, 0.35);
                    outline-offset: 3px;
                }
                .dark .admin-stat-card {
                    background: #1e293b;
                    border-color: #334155;
                }
                .dark .admin-stat-card:hover {
                    border-color: #475569;
                    box-shadow: 0 10px 24px rgba(0,0,0,0.24);
                }
                .admin-stat-info {
                    display: flex;
                    flex-direction: column;
                    gap: 12px;
                }
                .admin-stat-label {
                    font-size: 15px;
                    color: #64748b;
                    font-family: 'Battambang', 'Khmer OS Siemreap', sans-serif;
                }
                .dark .admin-stat-label {
                    color: #94a3b8;
                }
                .admin-stat-value {
                    font-size: 24px;
                    font-weight: 500;
                    color: #334155;
                }
                .dark .admin-stat-value {
                    color: #e2e8f0;
                }
                .admin-stat-icon {
                    width: 56px;
                    height: 56px;
                    border-radius: 50%;
                    background-color: #e0e7ff;
                    color: #4f46e5;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                    font-size: 24px;
                }
                .dark .admin-stat-icon {
                    background-color: rgba(79, 70, 229, 0.2);
                    color: #818cf8;
                }
            </style>
            <section class="admin-stats-grid">
                @foreach ($stats as $stat)
                    @php($statUrl = $stat['url'] ?? null)
                    @if($statUrl)
                        <a href="{{ $statUrl }}" class="admin-stat-card" aria-label="{{ $stat['label'] }}">
                    @else
                        <div class="admin-stat-card">
                    @endif
                        <div class="admin-stat-info">
                            <div class="admin-stat-label">{{ $stat['label'] }}</div>
                            <div class="admin-stat-value">{{ $stat['value'] }}</div>
                        </div>
                        <div class="admin-stat-icon">
                            @if(isset($stat['fa_icon']))
                                <i class="{{ $stat['fa_icon'] }}"></i>
                            @else
                                {{ $stat['icon'] }}
                            @endif
                        </div>
                    @if($statUrl)
                        </a>
                    @else
                        </div>
                    @endif
                @endforeach
            </section>

            <div class="db-container" style="grid-template-columns: 1fr 1fr;">
                <div class="db-card">
                    <h3 class="section-title" style="margin-bottom: 16px;">Recent Courses</h3>
                    <div class="db-stats-grid" style="grid-template-columns: 1fr; gap: 12px; margin-bottom: 0;">
                        @foreach ($courses as $course)
                            <div class="db-stat-card" style="padding: 14px;">
                                <div class="db-stat-icon" style="background: #f0fdf4; color: #16a34a; width:36px; height:36px; font-size:16px;">📚</div>
                                <div style="min-width: 0; flex: 1;">
                                    <div class="continue-course-title" style="font-size:13px;">{{ $course->course_name }}</div>
                                    <div class="continue-instructor" style="margin-bottom: 0; font-size:11px;">
                                        {{ $course->department?->department_name }} · {{ $course->academicYear?->year_name }} · {{ $course->semester?->semester_name }}
                                    </div>
                                </div>
                                <span class="continue-btn" style="padding: 4px 10px; font-size: 10px;">{{ $course->content_lessons_count }} Lessons</span>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="db-card">
                    <h3 class="section-title" style="margin-bottom: 16px;">Recent Students</h3>
                    <div class="db-stats-grid" style="grid-template-columns: 1fr; gap: 12px; margin-bottom: 0;">
                        @foreach ($recentStudents as $student)
                            <div class="db-stat-card" style="padding: 14px;">
                                <div class="db-stat-icon" style="background: #f5f3ff; color: #7c3aed; width:36px; height:36px; font-size:16px;">🎓</div>
                                <div style="min-width: 0; flex: 1;">
                                    <div class="continue-course-title" style="font-size:13px;">{{ trim($student->first_name.' '.$student->last_name) }}</div>
                                    <div class="continue-instructor" style="margin-bottom: 0; font-size:11px;">
                                        {{ $student->department?->department_name }} · {{ $student->academicYear?->year_name }} · {{ $student->semester?->semester_name }}
                                    </div>
                                </div>
                                <span class="continue-btn" style="padding: 4px 10px; font-size: 10px; background: #fdf2f8; color: #db2777;">
                                    {{ $student->status }}
                                </span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>
