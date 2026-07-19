<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    @php
        $lesson = $record;
        $course = $lesson->course;
        $typeLabel = match ($lesson->content_type) {
            'video' => 'Video',
            'file' => 'Document',
            'assignment' => 'Assignment',
            'quiz' => 'Quiz',
            'url' => 'URL',
            'page' => 'Page',
            default => 'Lesson',
        };
        $statusLabel = $lesson->is_published ? 'Published' : 'Draft';
        $visibilityLabel = match ($lesson->visibility) {
            'hidden' => 'Hidden',
            'scheduled' => 'Scheduled',
            default => 'Visible',
        };
        $editUrl = \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('edit', ['record' => $lesson]);
        $indexUrl = \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index');
    @endphp

    <style>
        .lesson-show {
            width: 100%;
            color: #172033;
            font-family: "Battambang", "Noto Sans Khmer", system-ui, sans-serif;
            letter-spacing: 0;
        }

        .lesson-show * {
            box-sizing: border-box;
            letter-spacing: 0;
        }

        .lesson-hero,
        .lesson-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #ffffff;
            box-shadow: 0 14px 32px rgba(15, 23, 42, .06);
        }

        .lesson-hero {
            display: grid;
            grid-template-columns: 1fr auto;
            gap: 18px;
            padding: 22px;
            margin-bottom: 18px;
        }

        .lesson-title {
            margin: 0 0 8px;
            color: #0f172a;
            font-size: 30px;
            font-weight: 900;
            line-height: 1.3;
        }

        .lesson-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin-top: 12px;
        }

        .lesson-pill {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border-radius: 6px;
            background: #eef6ff;
            color: #1d4ed8;
            padding: 7px 10px;
            font-size: 13px;
            font-weight: 800;
        }

        .lesson-pill-green {
            background: #dcfce7;
            color: #166534;
        }

        .lesson-pill-gray {
            background: #f1f5f9;
            color: #475569;
        }

        .lesson-actions {
            display: flex;
            align-items: flex-start;
            gap: 10px;
        }

        .lesson-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-height: 40px;
            border-radius: 6px;
            border: 1px solid #cbd5e1;
            background: #ffffff;
            color: #334155;
            padding: 0 14px;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
            transition: background-color .2s ease, border-color .2s ease, color .2s ease, box-shadow .2s ease;
        }

        .lesson-btn-primary {
            border-color: #4db6f2;
            background: #4db6f2;
            color: #061826;
        }

        .lesson-btn:hover {
            border-color: #4db6f2;
            background: #eaf7ff;
            color: #075985;
            box-shadow: 0 8px 18px rgba(77, 182, 242, .16);
        }

        .lesson-grid {
            display: grid;
            grid-template-columns: minmax(0, 1.45fr) minmax(320px, .55fr);
            gap: 18px;
        }

        .lesson-card {
            padding: 18px;
        }

        .lesson-card-title {
            margin: 0 0 12px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
        }

        .lesson-body {
            color: #334155;
            line-height: 1.8;
        }

        .lesson-body :where(p, ul, ol) {
            margin-bottom: 12px;
        }

        .lesson-info-list {
            display: grid;
            gap: 12px;
            margin: 0;
        }

        .lesson-info-row {
            display: flex;
            justify-content: space-between;
            gap: 12px;
            border-bottom: 1px solid #eef2f7;
            padding-bottom: 10px;
        }

        .lesson-info-row:last-child {
            border-bottom: 0;
            padding-bottom: 0;
        }

        .lesson-label {
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .lesson-value {
            color: #0f172a;
            font-weight: 900;
            text-align: right;
        }

        .asset-list {
            display: grid;
            gap: 10px;
        }

        .asset-item {
            display: flex;
            align-items: flex-start;
            justify-content: space-between;
            gap: 12px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #f8fbff;
            padding: 12px;
        }

        .asset-name {
            color: #0f172a;
            font-weight: 900;
        }

        .asset-note {
            color: #64748b;
            font-size: 13px;
        }

        .empty-note {
            border: 1px dashed #cbd5e1;
            border-radius: 8px;
            color: #64748b;
            padding: 18px;
            text-align: center;
        }

        @media (max-width: 1024px) {
            .lesson-hero,
            .lesson-grid {
                grid-template-columns: 1fr;
            }

            .lesson-actions {
                flex-wrap: wrap;
            }
        }
    </style>

    <div class="lesson-show">
        <section class="lesson-hero">
            <div>
                <div class="lesson-pill lesson-pill-gray">{{ $course?->course_name ?? 'No course' }}</div>
                <h1 class="lesson-title">{{ $lesson->title }}</h1>
                <div class="lesson-meta">
                    <span class="lesson-pill"><i class="fas fa-layer-group"></i> Module {{ $lesson->module_number }}: {{ $lesson->module_title ?: 'Course Module' }}</span>
                    <span class="lesson-pill"><i class="fas fa-list-ol"></i> Lesson {{ $lesson->position }}</span>
                    <span class="lesson-pill"><i class="fas fa-shapes"></i> {{ $typeLabel }}</span>
                    <span class="lesson-pill"><i class="fas fa-clock"></i> {{ $lesson->duration_minutes ?: 0 }} min</span>
                    <span class="lesson-pill {{ $lesson->is_published ? 'lesson-pill-green' : 'lesson-pill-gray' }}"><i class="fas fa-circle"></i> {{ $statusLabel }}</span>
                </div>
            </div>

            <div class="lesson-actions">
                <a class="lesson-btn" href="{{ $indexUrl }}"><i class="fas fa-arrow-left"></i> Back</a>
                <a class="lesson-btn lesson-btn-primary" href="{{ $editUrl }}"><i class="fas fa-edit"></i> Edit Lesson</a>
            </div>
        </section>

        <div class="lesson-grid">
            <section class="lesson-card">
                <h2 class="lesson-card-title">Lesson Content</h2>
                @if(filled($lesson->summary))
                    <p class="lesson-body">{{ $lesson->summary }}</p>
                @endif

                @if(filled($lesson->body))
                    <div class="lesson-body" style="margin-bottom: 18px;">{!! $lesson->body !!}</div>
                @endif

                @if($lesson->content_type === 'video')
                    @php
                        $embedUrl = null;
                        $isYouTube = false;
                        if (filled($lesson->video_url)) {
                            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:[^/]+/.+/|(?:v|e(?:mbed)?)/|.*[?&]v=)|youtu\.be/)([^"&?/ ]{11})%i', $lesson->video_url, $match)) {
                                $isYouTube = true;
                                $embedUrl = 'https://www.youtube.com/embed/' . $match[1];
                            }
                        }
                    @endphp

                    <div style="margin-bottom: 18px;">
                        @if($isYouTube && $embedUrl)
                            <div style="position: relative; padding-bottom: 56.25%; height: 0; overflow: hidden; border-radius: 8px; border: 1px solid #e2e8f0; background: #000;">
                                <iframe src="{{ $embedUrl }}" style="position: absolute; top: 0; left: 0; width: 100%; height: 100%; border: 0;" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>
                        @elseif(filled($lesson->video_url))
                            <div style="border-radius: 8px; border: 1px solid #e2e8f0; background: #000; overflow: hidden;">
                                <video controls style="width: 100%; max-height: 480px; display: block;" preload="metadata">
                                    <source src="{{ $lesson->video_url }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @elseif(filled($lesson->file_path))
                            <div style="border-radius: 8px; border: 1px solid #e2e8f0; background: #000; overflow: hidden;">
                                <video controls style="width: 100%; max-height: 480px; display: block;" preload="metadata">
                                    <source src="{{ asset('storage/'.$lesson->file_path) }}">
                                    Your browser does not support the video tag.
                                </video>
                            </div>
                        @else
                            <div class="empty-note">មិនទាន់មានវីដេអូទេ (No video file or URL has been uploaded yet)</div>
                        @endif
                    </div>

                    @if(filled($lesson->video_url) || filled($lesson->file_path))
                        <div class="asset-item" style="margin-top: 10px;">
                            <div>
                                <div class="asset-name">ព័ត៌មានវីដេអូ / Video Metadata</div>
                                <div class="asset-note">{{ $lesson->video_url ?: $lesson->file_path }}</div>
                            </div>
                            <a class="lesson-btn" href="{{ filled($lesson->video_url) ? $lesson->video_url : asset('storage/'.$lesson->file_path) }}" target="_blank" rel="noopener">
                                <i class="fas fa-external-link-alt"></i> បើកក្នុងផ្ទាំងថ្មី (Open)
                            </a>
                        </div>
                    @endif
                @elseif($lesson->content_type === 'url' && filled($lesson->external_url))
                    <div class="asset-item">
                        <div>
                            <div class="asset-name">External lesson link</div>
                            <div class="asset-note">{{ $lesson->external_url }}</div>
                        </div>
                        <a class="lesson-btn" href="{{ $lesson->external_url }}" target="_blank" rel="noopener">Open</a>
                    </div>
                @elseif($lesson->content_type === 'file' && filled($lesson->file_path))
                    <div class="asset-item">
                        <div>
                            <div class="asset-name">Lesson file</div>
                            <div class="asset-note">{{ $lesson->file_path }}</div>
                        </div>
                        <a class="lesson-btn" href="{{ asset('storage/'.$lesson->file_path) }}" target="_blank" rel="noopener">Open</a>
                    </div>
                @elseif(!filled($lesson->body) && !filled($lesson->summary))
                    <div class="empty-note">No lesson content has been added yet.</div>
                @endif
            </section>

            <aside class="lesson-card">
                <h2 class="lesson-card-title">Lesson Settings</h2>
                <dl class="lesson-info-list">
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Course</dt>
                        <dd class="lesson-value">{{ $course?->course_name ?? '-' }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Category</dt>
                        <dd class="lesson-value">{{ $course?->category?->category_name ?? '-' }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Visibility</dt>
                        <dd class="lesson-value">{{ $visibilityLabel }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Completion Required</dt>
                        <dd class="lesson-value">{{ $lesson->completion_required ? 'Yes' : 'No' }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Comments</dt>
                        <dd class="lesson-value">{{ $lesson->allow_comments ? 'Allowed' : 'Disabled' }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Available From</dt>
                        <dd class="lesson-value">{{ $lesson->available_from?->format('M d, Y H:i') ?? '-' }}</dd>
                    </div>
                    <div class="lesson-info-row">
                        <dt class="lesson-label">Available Until</dt>
                        <dd class="lesson-value">{{ $lesson->available_until?->format('M d, Y H:i') ?? '-' }}</dd>
                    </div>
                </dl>
            </aside>
        </div>

        <section class="lesson-card" style="margin-top:18px">
            <h2 class="lesson-card-title">Attached Learning Items</h2>
            <div class="asset-list">
                @forelse($lesson->chapters as $chapter)
                    <div class="asset-item">
                        <div>
                            <div class="asset-name"><i class="fas fa-book-open"></i> {{ $chapter->title }}</div>
                            <div class="asset-note">{{ $chapter->summary ?: 'Chapter content' }}</div>
                        </div>
                        <span class="lesson-pill {{ $chapter->is_published ? 'lesson-pill-green' : 'lesson-pill-gray' }}">{{ $chapter->is_published ? 'Published' : 'Draft' }}</span>
                    </div>
                @empty
                    @if($lesson->videos->isEmpty() && $lesson->documents->isEmpty() && $lesson->assignments->isEmpty() && $lesson->quizzes->isEmpty())
                        <div class="empty-note">No chapters, videos, documents, assignments, or quizzes are attached.</div>
                    @endif
                @endforelse

                @foreach($lesson->videos as $video)
                    <div class="asset-item">
                        <div>
                            <div class="asset-name"><i class="fas fa-play-circle"></i> {{ $video->title }}</div>
                            <div class="asset-note">{{ $video->video_url ?: $video->video_path ?: 'Video asset' }}</div>
                        </div>
                        <span class="lesson-pill">{{ $video->duration_seconds ? round($video->duration_seconds / 60).' min' : 'Video' }}</span>
                    </div>
                @endforeach

                @foreach($lesson->documents as $document)
                    <div class="asset-item">
                        <div>
                            <div class="asset-name"><i class="fas fa-file-alt"></i> {{ $document->title }}</div>
                            <div class="asset-note">{{ $document->file_path ?: 'Document asset' }}</div>
                        </div>
                        @if($document->file_path)
                            <a class="lesson-btn" href="{{ asset('storage/'.$document->file_path) }}" target="_blank" rel="noopener">Open</a>
                        @endif
                    </div>
                @endforeach

                @foreach($lesson->assignments as $assignment)
                    <div class="asset-item">
                        <div>
                            <div class="asset-name"><i class="fas fa-clipboard-list"></i> {{ $assignment->title }}</div>
                            <div class="asset-note">Due: {{ $assignment->due_at?->format('M d, Y H:i') ?? '-' }} | Max score: {{ $assignment->max_score ?? '-' }}</div>
                        </div>
                        <span class="lesson-pill">Assignment</span>
                    </div>
                @endforeach

                @foreach($lesson->quizzes as $quiz)
                    <div class="asset-item">
                        <div>
                            <div class="asset-name"><i class="fas fa-question-circle"></i> {{ $quiz->title }}</div>
                            <div class="asset-note">Time limit: {{ $quiz->time_limit_minutes ?? '-' }} min | Passing: {{ $quiz->passing_score ?? '-' }}</div>
                        </div>
                        <span class="lesson-pill">Quiz</span>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
</x-filament-panels::page>
