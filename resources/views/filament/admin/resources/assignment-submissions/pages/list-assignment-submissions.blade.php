<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    <style>
        .assignment-submission-page {
            color: #24304a;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 14px;
            line-height: 1.65;
        }

        .assignment-title {
            margin: 0 0 6px;
            color: #273149;
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .assignment-breadcrumb {
            margin-bottom: 24px;
            color: #929ab0;
            font-size: 12px;
        }

        .assignment-card {
            border: 1px solid #dce2f0;
            border-radius: 6px;
            background: #fff;
            box-shadow: 0 10px 28px rgba(31, 41, 55, .055);
        }

        .assignment-summary {
            margin-bottom: 26px;
        }

        .assignment-summary-main {
            padding: 30px 28px 28px;
            text-align: center;
        }

        .assignment-summary-main h2 {
            margin: 0;
            color: #1f2a44;
            font-size: 30px;
            font-weight: 800;
            letter-spacing: 0;
        }

        .assignment-summary-main p {
            margin: 8px 0 0;
            color: #2d3760;
            font-size: 15px;
            font-weight: 500;
        }

        .assignment-summary-meta {
            display: flex;
            justify-content: space-between;
            gap: 16px;
            border-top: 1px solid #e0e5f1;
            background: #fbfcff;
            padding: 18px 22px;
            color: #626b83;
            font-size: 14px;
            line-height: 1.75;
        }

        .assignment-summary-meta strong {
            color: #47516a;
            font-weight: 700;
        }

        .assignment-panel-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #e0e5f1;
            padding: 17px 18px;
            color: #4d5872;
            font-size: 15px;
            font-weight: 700;
        }

        .assignment-table-wrap {
            padding: 18px;
            overflow-x: auto;
        }

        .assignment-table {
            width: 100%;
            min-width: 1240px;
            border-collapse: collapse;
            border: 1px solid #1f2937;
            background: #fff;
            color: #26324d;
            font-size: 12px;
        }

        .assignment-table th {
            border: 1px solid #1f2937;
            background: #e4e7ff;
            padding: 11px 10px;
            color: #303852;
            text-align: left;
            vertical-align: top;
            font-weight: 800;
            line-height: 1.5;
        }

        .assignment-table td {
            border: 1px solid #1f2937;
            padding: 11px 10px;
            vertical-align: middle;
            line-height: 1.55;
        }

        .assignment-table tbody tr:hover {
            background: #f8faff;
        }

        .text-center {
            text-align: center;
        }

        .assignment-link {
            color: #4459f0;
            font-weight: 800;
            text-decoration: none;
        }

        .assignment-link:hover {
            color: #2738bc;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .muted {
            color: #626b80;
            font-size: 11px;
            line-height: 1.5;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 84px;
            min-height: 28px;
            border-radius: 4px;
            padding: 4px 8px;
            font-weight: 800;
        }

        .status-submitted {
            background: #eef2ff;
            color: #3730a3;
        }

        .status-graded {
            background: #dcfce7;
            color: #166534;
        }

        .status-reviewed {
            background: #e0f2fe;
            color: #075985;
        }

        .status-needs_revision {
            background: #fef3c7;
            color: #92400e;
        }

        .action-row {
            display: flex;
            justify-content: center;
            gap: 8px;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            min-height: 30px;
            border: 0;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            font-size: 12px;
            font-weight: 800;
            transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            filter: brightness(.96);
        }

        .action-btn-green {
            min-width: 92px;
            background: #22c55e;
            box-shadow: 0 6px 14px rgba(34, 197, 94, .18);
        }

        .action-btn-blue {
            background: #5865f2;
            box-shadow: 0 6px 14px rgba(88, 101, 242, .18);
        }

        .action-btn-gray {
            background: #64748b;
        }

        .action-btn-disabled {
            cursor: not-allowed;
            opacity: .45;
        }

        .empty-state {
            padding: 42px 18px;
            color: #68738a;
            text-align: center;
            font-size: 15px;
        }

        .assignment-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            border-top: 1px solid #e0e5f1;
            padding: 14px 18px 18px;
            color: #4d5872;
            font-size: 13px;
        }

        .pagination {
            display: flex;
            align-items: center;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .page-item {
            margin-left: -1px;
        }

        .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 38px;
            min-height: 34px;
            border: 1px solid #cfd6e6;
            background: #fff;
            color: #34405b;
            text-decoration: none;
            font-weight: 800;
            line-height: 1;
        }

        .page-item:first-child .page-link {
            border-top-left-radius: 5px;
            border-bottom-left-radius: 5px;
        }

        .page-item:last-child .page-link {
            border-top-right-radius: 5px;
            border-bottom-right-radius: 5px;
        }

        .page-item.active .page-link {
            border-color: #5865f2;
            background: #5865f2;
            color: #fff;
        }

        .page-item.disabled .page-link {
            cursor: not-allowed;
            background: #f8fafc;
            color: #98a2b3;
        }

        .fi-header-actions,
        .fi-page-header-actions {
            display: none !important;
        }

        @media (max-width: 768px) {
            .assignment-summary-meta,
            .assignment-pagination {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>

    <div class="assignment-submission-page">
        <h1 class="assignment-title">Assignment Submissions</h1>
        <div class="assignment-breadcrumb">Home &gt; Assessment &gt; Assignment Submissions</div>

        <section class="assignment-card assignment-summary">
            <div class="assignment-summary-main">
                <h2>Submission Review Queue</h2>
                <p>Review submitted homework, open attached files, and publish teacher scores back to students.</p>
            </div>
            <div class="assignment-summary-meta">
                <div>
                    <div><strong>Total submissions:</strong> {{ $totalSubmissions }}</div>
                    <div><strong>Waiting review:</strong> {{ $pendingSubmissions }}</div>
                </div>
                <div style="text-align: right;">
                    <div><strong>Graded:</strong> {{ $gradedSubmissions }}</div>
                    <div><strong>Rows per page:</strong> 10</div>
                </div>
            </div>
        </section>

        <section class="assignment-card">
            <div class="assignment-panel-header">
                <span>Submission List</span>
                <span class="muted">Teachers only see submissions from assigned courses.</span>
            </div>

            @if($submissions->isEmpty())
                <div class="empty-state">No assignment submissions found.</div>
            @else
                <div class="assignment-table-wrap">
                    <table class="assignment-table">
                        <thead>
                            <tr>
                                <th class="text-center">No.<br><span class="muted">Code</span></th>
                                <th>Student<br><span class="muted">Department</span></th>
                                <th>Course<br><span class="muted">Assignment</span></th>
                                <th class="text-center">Submitted<br><span class="muted">Due date</span></th>
                                <th class="text-center">File</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Score</th>
                                <th class="text-center">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($submissions as $submission)
                                @php
                                    $student = $submission->student;
                                    $assignment = $submission->assignment;
                                    $course = $assignment?->lesson?->course;
                                    $studentName = trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')) ?: 'Unknown student';
                                    $status = $submission->status ?: 'submitted';
                                    $statusLabel = match ($status) {
                                        'graded' => 'Graded',
                                        'reviewed' => 'Reviewed',
                                        'needs_revision' => 'Needs revision',
                                        default => 'Submitted',
                                    };
                                @endphp

                                <tr>
                                    <td class="text-center">
                                        <div>{{ $submissions->firstItem() + $loop->index }}</div>
                                        <div class="muted">{{ $student?->student_code ?? str_pad((string) $submission->assignment_submission_id, 4, '0', STR_PAD_LEFT) }}</div>
                                    </td>
                                    <td>
                                        @if($student)
                                            <a class="assignment-link" href="{{ \App\Filament\Admin\Resources\Students\StudentResource::getUrl('edit', ['record' => $student->student_id]) }}">
                                                {{ $studentName }}
                                            </a>
                                        @else
                                            <span>{{ $studentName }}</span>
                                        @endif
                                        <div class="muted">{{ $student?->department?->department_name ?? '-' }}</div>
                                    </td>
                                    <td>
                                        <div>{{ $course?->course_name ?? 'No course' }}</div>
                                        <div class="muted">{{ $assignment?->title ?? 'No assignment' }}</div>
                                    </td>
                                    <td class="text-center">
                                        <div>{{ $submission->submitted_at?->format('m/d/Y H:i') ?? '-' }}</div>
                                        <div class="muted">{{ $assignment?->due_at?->format('m/d/Y') ?? 'No due date' }}</div>
                                    </td>
                                    <td class="text-center">
                                        @if($submission->attachmentPublicUrl())
                                            <a class="action-btn action-btn-blue" href="{{ $submission->attachmentPublicUrl() }}" target="_blank" title="Open file">
                                                <i class="fas fa-file-alt"></i>
                                            </a>
                                        @else
                                            <span class="action-btn action-btn-gray action-btn-disabled" title="No file">
                                                <i class="fas fa-minus"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <span class="status-badge status-{{ $status }}">{{ $statusLabel }}</span>
                                    </td>
                                    <td class="text-center">
                                        @if(filled($submission->score))
                                            <strong>{{ number_format((float) $submission->score, 2) }}</strong>
                                            <div class="muted">/ {{ number_format((float) ($assignment?->max_score ?? 100), 0) }}</div>
                                        @else
                                            <span class="muted">Not graded</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        <div class="action-row">
                                            <a class="action-btn action-btn-green" href="{{ \App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource::getUrl('edit', ['record' => $submission->assignment_submission_id]) }}">
                                                Review
                                            </a>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="assignment-pagination">
                    <div>
                        Showing {{ $submissions->firstItem() }} to {{ $submissions->lastItem() }} of {{ $submissions->total() }} submissions
                    </div>
                    <nav aria-label="Assignment submission pagination">
                        <ul class="pagination">
                            @if($submissions->onFirstPage())
                                <li class="page-item disabled"><span class="page-link">Previous</span></li>
                            @else
                                <li class="page-item"><a class="page-link" href="{{ $submissions->previousPageUrl() }}">Previous</a></li>
                            @endif

                            @foreach($submissions->getUrlRange(1, $submissions->lastPage()) as $page => $url)
                                @if($page === $submissions->currentPage())
                                    <li class="page-item active"><span class="page-link">{{ $page }}</span></li>
                                @else
                                    <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                                @endif
                            @endforeach

                            @if($submissions->hasMorePages())
                                <li class="page-item"><a class="page-link" href="{{ $submissions->nextPageUrl() }}">Next</a></li>
                            @else
                                <li class="page-item disabled"><span class="page-link">Next</span></li>
                            @endif
                        </ul>
                    </nav>
                </div>
            @endif
        </section>
    </div>
</x-filament-panels::page>
