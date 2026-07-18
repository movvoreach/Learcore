<x-filament-panels::page>
    @if (auth()->user()?->isStudent())
        {{ $this->table }}
    @else
        @php
            $requests = $this->completionRequests();
            $selected = $this->selectedRequest();
            $report = $this->selectedReport();
            $isAdmin = auth()->user()?->hasAnyRole(['super_admin', 'admin']);
            $statusLabels = ['pending' => 'Pending Review', 'approved' => 'Approved', 'rejected' => 'Rejected'];
        @endphp

        <style>
            .ccr-page { font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif; color:#0f172a; }
            .ccr-header { display:flex; justify-content:space-between; gap:16px; align-items:flex-end; margin-bottom:18px; }
            .ccr-title { font-size:30px; font-weight:800; margin:0; }
            .ccr-sub { color:#64748b; margin:6px 0 0; }
            .ccr-grid { display:grid; grid-template-columns:minmax(0, 1fr) 420px; gap:18px; align-items:start; }
            .ccr-card { background:#fff; border:1px solid #dbe3ef; border-radius:8px; box-shadow:0 12px 30px rgba(15,23,42,.06); overflow:hidden; }
            .ccr-card-pad { padding:18px; }
            .ccr-table { width:100%; border-collapse:separate; border-spacing:0; font-size:14px; }
            .ccr-table th { color:#64748b; font-size:12px; text-align:left; padding:14px 16px; background:#f8fafc; border-bottom:1px solid #e2e8f0; }
            .ccr-table td { padding:15px 16px; border-bottom:1px solid #edf2f7; vertical-align:middle; }
            .ccr-course { font-weight:800; color:#0f172a; }
            .ccr-muted { color:#64748b; font-size:12px; }
            .ccr-badge { display:inline-flex; align-items:center; gap:6px; min-height:28px; padding:4px 10px; border-radius:6px; font-size:12px; font-weight:800; }
            .ccr-badge.pending { background:#fff7ed; color:#c2410c; }
            .ccr-badge.approved { background:#dcfce7; color:#15803d; }
            .ccr-badge.rejected { background:#fee2e2; color:#b91c1c; }
            .ccr-progress { height:8px; border-radius:999px; background:#e2e8f0; overflow:hidden; min-width:110px; }
            .ccr-progress span { display:block; height:100%; background:#00b390; }
            .ccr-actions { display:flex; flex-wrap:wrap; gap:8px; }
            .ccr-btn { border:1px solid #cbd5e1; background:#fff; color:#0f172a; border-radius:6px; padding:8px 11px; font-weight:800; font-size:12px; transition:.2s ease; }
            .ccr-btn:hover { transform:translateY(-1px); box-shadow:0 8px 16px rgba(15,23,42,.12); }
            .ccr-btn.primary { background:#2563eb; border-color:#2563eb; color:#fff; }
            .ccr-btn.success { background:#16a34a; border-color:#16a34a; color:#fff; }
            .ccr-btn.danger { background:#dc3545; border-color:#dc3545; color:#fff; }
            .ccr-detail-title { display:flex; justify-content:space-between; gap:12px; align-items:flex-start; padding:18px; border-bottom:1px solid #e2e8f0; }
            .ccr-detail-title h2 { margin:0; font-size:20px; font-weight:900; }
            .ccr-stats { display:grid; grid-template-columns:repeat(4, minmax(0,1fr)); gap:12px; margin-bottom:18px; }
            .ccr-stat { background:#f8fafc; border:1px solid #e2e8f0; border-radius:8px; padding:13px; }
            .ccr-stat strong { display:block; font-size:22px; }
            .ccr-lessons { display:grid; gap:10px; }
            .ccr-module { border:1px solid #e2e8f0; border-radius:8px; overflow:hidden; }
            .ccr-module summary { cursor:pointer; padding:13px 14px; font-weight:900; background:#f8fbff; }
            .ccr-module ul { margin:0; padding:8px 18px 14px 34px; color:#475569; }
            .ccr-modal { position:fixed; inset:0; z-index:60; display:grid; place-items:center; background:rgba(15,23,42,.45); padding:20px; }
            .ccr-modal-box { width:min(560px, 100%); background:#fff; border-radius:8px; padding:20px; box-shadow:0 24px 70px rgba(15,23,42,.25); }
            .ccr-textarea { width:100%; min-height:130px; border:1px solid #cbd5e1; border-radius:8px; padding:12px; margin:12px 0; }
            .dark .ccr-card, .dark .ccr-modal-box { background:#1e293b; border-color:#334155; color:#f8fafc; }
            .dark .ccr-table th, .dark .ccr-stat, .dark .ccr-module summary { background:#0f172a; border-color:#334155; }
            .dark .ccr-course, .dark .ccr-title, .dark .ccr-detail-title h2 { color:#f8fafc; }
            @media (max-width: 1200px) { .ccr-grid { grid-template-columns:1fr; } }
            @media (max-width: 760px) { .ccr-stats { grid-template-columns:repeat(2, minmax(0,1fr)); } .ccr-table { min-width:920px; } }
        </style>

        <div class="ccr-page">
            <div class="ccr-header">
                <div>
                    <h1 class="ccr-title">Certificate Approval Requests</h1>
                    <p class="ccr-sub">Completed courses submitted by teachers for admin certificate approval.</p>
                </div>
            </div>

            <div class="ccr-grid">
                <div class="ccr-card" style="overflow:auto">
                    <table class="ccr-table">
                        <thead>
                            <tr>
                                <th>Course Name</th>
                                <th>Teacher</th>
                                <th>Students</th>
                                <th>Progress</th>
                                <th>Completed Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($requests as $request)
                                @php
                                    $summary = $request->summary ?? [];
                                    $total = (int) ($summary['total_students'] ?? 0);
                                    $completed = (int) ($summary['completed_students'] ?? 0);
                                    $percent = (float) ($summary['completion_percentage'] ?? 0);
                                    $teacherName = trim(($request->teacher?->first_name ?? '').' '.($request->teacher?->last_name ?? '')) ?: 'N/A';
                                @endphp
                                <tr>
                                    <td>
                                        <div class="ccr-course">{{ $request->course?->course_name }}</div>
                                        <div class="ccr-muted">{{ $request->course?->course_code }}</div>
                                    </td>
                                    <td>{{ $teacherName }}</td>
                                    <td>{{ $completed }}/{{ $total }}</td>
                                    <td>
                                        <strong>{{ number_format($percent, 0) }}%</strong>
                                        <div class="ccr-progress"><span style="width:{{ min(100, $percent) }}%"></span></div>
                                    </td>
                                    <td>{{ $request->completed_at?->format('M d, Y') }}</td>
                                    <td><span class="ccr-badge {{ $request->status }}">{{ $statusLabels[$request->status] ?? ucfirst($request->status) }}</span></td>
                                    <td>
                                        <div class="ccr-actions">
                                            <button type="button" class="ccr-btn primary" wire:click="viewRequest({{ $request->id }})">View Details</button>
                                            @if ($isAdmin && $request->isPending())
                                                <button type="button" class="ccr-btn success" wire:click="approveRequest({{ $request->id }})">Approve</button>
                                                <button type="button" class="ccr-btn danger" wire:click="openRejectRequest({{ $request->id }})">Reject</button>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr><td colspan="7" style="text-align:center; padding:34px; color:#64748b;">No course completion requests yet.</td></tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="ccr-card">
                    @if ($selected && $report)
                        @php
                            $lessonsByModule = $selected->course->contentLessons->groupBy(fn ($lesson) => $lesson->module_number ?: 1);
                            $teacherName = trim(($selected->teacher?->first_name ?? '').' '.($selected->teacher?->last_name ?? '')) ?: 'N/A';
                        @endphp
                        <div class="ccr-detail-title">
                            <div>
                                <h2>{{ $selected->course?->course_name }}</h2>
                                <div class="ccr-muted">Teacher: {{ $teacherName }}</div>
                            </div>
                            <span class="ccr-badge {{ $selected->status }}">{{ $statusLabels[$selected->status] ?? ucfirst($selected->status) }}</span>
                        </div>
                        <div class="ccr-card-pad">
                            <div class="ccr-stats">
                                <div class="ccr-stat"><span class="ccr-muted">Students</span><strong>{{ $report['total_students'] }}</strong></div>
                                <div class="ccr-stat"><span class="ccr-muted">Completed</span><strong>{{ $report['completed_students'] }}</strong></div>
                                <div class="ccr-stat"><span class="ccr-muted">Lessons</span><strong>{{ $report['total_lessons'] }}</strong></div>
                                <div class="ccr-stat"><span class="ccr-muted">Progress</span><strong>{{ number_format($report['completion_percentage'], 0) }}%</strong></div>
                            </div>

                            <h3 style="font-size:16px; font-weight:900; margin:0 0 10px;">Course Information</h3>
                            <div class="ccr-muted" style="margin-bottom:14px;">
                                Duration: {{ $report['duration_minutes'] }} min · Modules: {{ $report['total_modules'] }} · Required quizzes: {{ $report['required_quizzes'] }} · Required assignments: {{ $report['required_assignments'] }}
                            </div>

                            <div class="ccr-lessons">
                                @foreach ($lessonsByModule as $moduleNumber => $lessons)
                                    <details class="ccr-module">
                                        <summary>Module {{ $moduleNumber }}: {{ $lessons->first()?->module_title ?: 'Lessons' }}</summary>
                                        <ul>
                                            @foreach ($lessons as $lesson)
                                                <li>{{ $lesson->title }} <span class="ccr-muted">({{ ucfirst($lesson->content_type ?? 'Lesson') }})</span></li>
                                            @endforeach
                                        </ul>
                                    </details>
                                @endforeach
                            </div>

                            <h3 style="font-size:16px; font-weight:900; margin:20px 0 10px;">Student Completion</h3>
                            <div style="overflow:auto;">
                                <table class="ccr-table">
                                    <thead>
                                        <tr>
                                            <th>Student Name</th>
                                            <th>Enrollment Date</th>
                                            <th>Lesson Progress</th>
                                            <th>Quiz Result</th>
                                            <th>Assignment Result</th>
                                            <th>Final Score</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($report['students'] as $row)
                                            @php($studentName = trim(($row['student']->first_name ?? '').' '.($row['student']->last_name ?? '')))
                                            <tr>
                                                <td>{{ $studentName ?: $row['student']->student_code }}</td>
                                                <td>{{ $row['enrollment']->enrollment_date?->format('M d, Y') }}</td>
                                                <td>{{ number_format($row['lesson_progress'], 0) }}%</td>
                                                <td>{{ $row['quiz_result'] }}</td>
                                                <td>{{ $row['assignment_result'] }}</td>
                                                <td>{{ $row['final_score'] ?? '-' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @else
                        <div class="ccr-card-pad" style="color:#64748b;">Select a request to view details.</div>
                    @endif
                </div>
            </div>

            @if ($rejectingRequestId)
                <div class="ccr-modal">
                    <form class="ccr-modal-box" wire:submit.prevent="rejectRequest">
                        <h2 style="margin:0; font-size:22px; font-weight:900;">Reject completion request</h2>
                        <textarea class="ccr-textarea" wire:model="rejectionReason" placeholder="Enter reject reason"></textarea>
                        @error('rejectionReason') <div style="color:#dc3545; font-weight:800;">{{ $message }}</div> @enderror
                        <div class="ccr-actions" style="justify-content:flex-end;">
                            <button type="button" class="ccr-btn" wire:click="$set('rejectingRequestId', null)">Cancel</button>
                            <button type="submit" class="ccr-btn danger">Reject Request</button>
                        </div>
                    </form>
                </div>
            @endif
        </div>
    @endif
</x-filament-panels::page>
