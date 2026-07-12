<section class="learning-courses learning-courses--moeys" id="featured-courses">
    <div class="learning-courses__inner">
        <div class="learning-courses-head reveal-item">
            <h2>
                <i class="fas fa-bars" aria-hidden="true"></i>
                វគ្គសិក្សាកំពុងដំណើរការ
            </h2>

            <button
                type="button"
                class="learning-courses-toggle"
                data-toggle-course-info
                data-no-loading
                aria-label="Hide course information"
                aria-expanded="true"
            >
                <i class="far fa-window-maximize" aria-hidden="true"></i>
            </button>
        </div>

        <div class="learning-course-grid">
            @forelse($courses as $course)
                @php
                    $courseTitle = $course->title ?? $course->course_name ?? 'Untitled Course';
                    $courseSlug = $course->slug ?? \Illuminate\Support\Str::slug($courseTitle.'-'.$course->getKey());
                    $courseImage = !empty($course->image) && file_exists(public_path('storage/' . $course->image))
                        ? asset('storage/'.$course->image)
                        : asset('backend/img/course-image-default.png');
                    $categoryName = optional($course->category)->category_name ?? 'Uncategorized';
                    $instructor = $course->instructor;
                    $teacherName = trim((optional($instructor)->first_name ?? '').' '.(optional($instructor)->last_name ?? ''));
                    $instructorName = optional(optional($instructor)->user)->name ?? ($teacherName ?: 'Instructor not assigned');
                    $rating = $course->rating ?? null;
                    $reviews = $course->reviews_count ?? $course->rating_count ?? null;
                    $lessonsCount = $course->lessons_count ?? $course->number_of_lessons ?? 0;
                    $durationMinutes = $course->total_duration_minutes ?? null;
                    $duration = $course->duration ?? ($durationMinutes ? round($durationMinutes / 60, 1).' hours' : 'Duration not set');
                    $studentsCount = $course->students_count ?? $course->total_students ?? 0;
                    $level = $course->level ?? optional($course->academicYear)->year_name ?? 'All levels';
                    $status = $course->status ?? 'Active';
                    $price = $course->price ?? null;
                    $discountPrice = $course->discount_price ?? null;
                    $createdDate = optional($course->created_at)->format('M d, Y') ?? 'Date not set';
                @endphp

                <article class="learning-course-card reveal-item">
                    <div class="learning-course-shell">
                        <a href="{{ route('frontend.courses.show', $courseSlug) }}" class="learning-course-thumb">
                            <img src="{{ $courseImage }}" alt="{{ $courseTitle }}">
                        </a>

                        <a href="{{ route('frontend.courses.show', $courseSlug) }}" class="learning-course-title">
                            {{ \Illuminate\Support\Str::limit($courseTitle, 34) }}
                        </a>

                        <div class="learning-course-info">
                            <div class="learning-course-tags">
                                <span>{{ $categoryName }}</span>
                                <strong>{{ $status }}</strong>
                            </div>

                            <div class="learning-course-rating">
                                <i class="fas fa-star" aria-hidden="true"></i>
                                <strong>{{ $rating ?? 'N/A' }}</strong>
                                <span>{{ $reviews ? '('.$reviews.')' : '' }}</span>
                            </div>

                            <p>{{ \Illuminate\Support\Str::limit($course->short_description ?? $course->description ?? 'No description available.', 95) }}</p>

                            <div class="learning-course-meta">
                                <span><i class="far fa-clock" aria-hidden="true"></i> {{ $duration }}</span>
                                <span><i class="far fa-bookmark" aria-hidden="true"></i> {{ $lessonsCount }} lessons</span>
                                <span><i class="far fa-user" aria-hidden="true"></i> {{ $studentsCount }} students</span>
                                <span><i class="fas fa-layer-group" aria-hidden="true"></i> {{ $level }}</span>
                                <span><i class="far fa-calendar" aria-hidden="true"></i> {{ $createdDate }}</span>
                                <span><i class="fas fa-tag" aria-hidden="true"></i> {{ is_null($price) ? 'Price not set' : '$'.number_format((float) $price, 2) }}</span>
                                @if(!is_null($discountPrice))
                                    <span><i class="fas fa-percent" aria-hidden="true"></i> ${{ number_format((float) $discountPrice, 2) }}</span>
                                @endif
                            </div>

                            <div class="learning-course-teacher">
                                <span><img src="{{ asset('backend/dist/img/avatar.png') }}" alt=""> {{ $instructorName }}</span>
                                <strong>{{ $status }}</strong>
                            </div>

                            <a href="{{ route('frontend.courses.show', $courseSlug) }}" class="learning-course-btn">
                                View Course
                            </a>
                        </div>
                    </div>
                </article>
            @empty
                <div class="learning-course-empty">
                    <img src="{{ asset('backend/img/course-image-default.png') }}" width="180" alt="Default Course Image">
                    <h4>{{ auth()->user()?->isStudent() ? 'មិនទាន់មានវគ្គសិក្សាសម្រាប់គណនីរបស់អ្នកទេ។' : 'មិនទាន់មានវគ្គសិក្សាសាធារណៈទេ។' }}</h4>
                    <p>សូមពិនិត្យម្តងទៀតនៅពេលក្រោយ។</p>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="learning-course-pagination">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

@once
    <style>
        .learning-courses--moeys {
            background: #fff;
        }

        .learning-courses--moeys .learning-courses__inner {
            max-width: 1410px;
            padding: 58px 28px 72px;
        }

        .learning-courses--moeys .learning-courses-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 0 30px;
            border-bottom: 0;
        }

        .learning-courses--moeys .learning-courses-head h2 {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            color: #243447;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.35;
        }

        .learning-courses--moeys .learning-courses-head h2 i {
            color: #34404c;
            font-size: 23px;
        }

        .learning-courses--moeys .learning-courses-toggle {
            width: 32px;
            height: 32px;
            display: inline-grid;
            place-items: center;
            border: 0;
            background: transparent;
            color: #999;
            font-size: 23px;
            text-decoration: none;
            cursor: pointer;
        }

        .learning-courses--moeys .learning-courses-toggle:hover {
            color: #009b8b;
        }

        .learning-courses--moeys .learning-courses-toggle:focus-visible {
            outline: 2px solid #009b8b;
            outline-offset: 3px;
        }

        .learning-courses--moeys .learning-course-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
            padding-top: 0;
        }

        .learning-courses--moeys .learning-course-card {
            overflow: hidden;
            border: 2px solid #009b8b;
            border-radius: 0;
            background: #fff;
            box-shadow: 3px 3px 0 #00675e;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .learning-courses--moeys .learning-course-card:hover {
            transform: translateY(-3px);
            border-color: #008779;
            box-shadow: 5px 5px 0 #00675e;
        }

        .learning-courses--moeys .learning-course-shell {
            display: flex;
            flex-direction: column;
            min-height: 100%;
            padding: 34px 20px 24px;
            color: inherit;
        }

        .learning-courses--moeys .learning-course-shell a {
            text-decoration: none;
        }

        .learning-courses--moeys .learning-course-thumb {
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 190px;
            margin-bottom: 22px;
            overflow: hidden;
            background: #fff;
        }

        .learning-courses--moeys .learning-course-thumb::after,
        .learning-courses--moeys .learning-course-tags,
        .learning-courses--moeys .learning-course-tags::before {
            display: none;
        }

        .learning-courses--moeys .learning-course-thumb img {
            width: 100%;
            max-height: 190px;
            object-fit: contain;
            transition: none;
        }

        .learning-courses--moeys .learning-course-card:hover .learning-course-thumb img {
            transform: none;
        }

        .learning-courses--moeys .learning-course-title {
            min-height: 56px;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            padding: 10px 12px;
            background: #009b8b;
            color: #fff;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
            font-size: 20px;
            font-weight: 700;
            line-height: 1.4;
            text-align: center;
        }

        .learning-courses--moeys .learning-course-title:hover {
            color: #fff;
        }

        .learning-courses--moeys .learning-course-info {
            display: flex;
            flex: 1;
            flex-direction: column;
            padding-top: 16px;
            color: #475569;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
        }

        .learning-courses--moeys.is-info-hidden .learning-course-info {
            display: none;
        }

        .learning-courses--moeys.is-info-hidden .learning-course-shell {
            padding-bottom: 31px;
        }

        .learning-courses--moeys .learning-course-info .learning-course-tags {
            position: static;
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 10px;
        }

        .learning-courses--moeys .learning-course-info .learning-course-tags span,
        .learning-courses--moeys .learning-course-info .learning-course-tags strong {
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            max-width: 100%;
            overflow: hidden;
            padding: 0 10px;
            border-radius: 0;
            font-size: 12px;
            font-weight: 700;
            line-height: 1;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-courses--moeys .learning-course-info .learning-course-tags span {
            background: #eef8f6;
            color: #00776b;
        }

        .learning-courses--moeys .learning-course-info .learning-course-tags strong {
            flex: 0 0 auto;
            background: #009b8b;
            color: #fff;
        }

        .learning-courses--moeys .learning-course-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 8px;
            color: #64748b;
            font-size: 13px;
            font-weight: 700;
        }

        .learning-courses--moeys .learning-course-rating i,
        .learning-courses--moeys .learning-course-rating strong {
            color: #f59e0b;
        }

        .learning-courses--moeys .learning-course-info p {
            min-height: 58px;
            margin: 0 0 12px;
            color: #52616f;
            font-size: 13px;
            font-weight: 600;
            line-height: 1.55;
        }

        .learning-courses--moeys .learning-course-meta {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 7px 10px;
            padding: 12px 0;
            border-top: 1px solid #e5f2f0;
            border-bottom: 1px solid #e5f2f0;
            color: #64748b;
            font-size: 11px;
            font-weight: 700;
        }

        .learning-courses--moeys .learning-course-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            min-width: 0;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-courses--moeys .learning-course-meta i {
            width: 14px;
            flex: 0 0 14px;
            color: #009b8b;
            text-align: center;
        }

        .learning-courses--moeys .learning-course-teacher {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin: 12px 0 14px;
        }

        .learning-courses--moeys .learning-course-teacher span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
            overflow: hidden;
            color: #243447;
            font-size: 12px;
            font-weight: 700;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-courses--moeys .learning-course-teacher img {
            width: 26px;
            height: 26px;
            flex: 0 0 26px;
            border-radius: 50%;
            object-fit: cover;
        }

        .learning-courses--moeys .learning-course-teacher strong {
            min-height: 26px;
            display: inline-flex;
            align-items: center;
            padding: 0 9px;
            background: #eef8f6;
            color: #00776b;
            font-size: 11px;
            font-weight: 700;
            white-space: nowrap;
        }

        .learning-courses--moeys .learning-course-btn {
            min-height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-top: auto;
            background: #243447;
            color: #fff;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none;
        }

        .learning-courses--moeys .learning-course-btn:hover {
            background: #009b8b;
            color: #fff;
        }

        .learning-courses--moeys .learning-course-empty {
            grid-column: 1 / -1;
            padding: 44px 20px;
            text-align: center;
        }

        .learning-courses--moeys .learning-course-empty h4 {
            margin-top: 16px;
            color: #243447;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
            font-size: 22px;
            font-weight: 700;
        }

        .learning-courses--moeys .learning-course-empty p {
            margin: 6px 0 0;
            color: #64748b;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
        }



        @media (max-width: 767.98px) {
            .learning-courses--moeys .learning-courses__inner {
                padding: 36px 16px 54px;
            }

            .learning-courses--moeys .learning-course-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .learning-courses--moeys .learning-course-shell {
                padding: 24px 12px 18px;
            }

            .learning-courses--moeys .learning-course-thumb {
                min-height: 130px;
                margin-bottom: 16px;
            }

            .learning-courses--moeys .learning-course-thumb img {
                max-height: 130px;
            }

            .learning-courses--moeys .learning-course-title {
                min-height: 50px;
                font-size: 16px;
            }

            .learning-courses--moeys .learning-course-meta {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 479.98px) {
            .learning-courses--moeys .learning-course-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
@endonce

@push('scripts')
    <script>
        $(function() {
            $('[data-toggle-course-info]').on('click', function(event) {
                event.preventDefault();

                const $button = $(this);
                const $section = $button.closest('.learning-courses--moeys');
                const isHidden = !$section.hasClass('is-info-hidden');

                $section.toggleClass('is-info-hidden', isHidden);
                $button.attr({
                    'aria-expanded': String(!isHidden),
                    'aria-label': isHidden ? 'Show course information' : 'Hide course information',
                });
                $button.find('i')
                    .toggleClass('fa-window-maximize', !isHidden)
                    .toggleClass('fa-window-restore', isHidden);
            });
        });
    </script>
@endpush
