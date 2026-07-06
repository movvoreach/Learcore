<section class="learning-courses" id="featured-courses">
    <div class="learning-courses__inner">
        <div class="learning-courses-head reveal-item">
            <div>
                <h2>Available Courses</h2>
                <p>Browse the latest courses and continue learning with lessons prepared for your program.</p>
            </div>
            <a href="{{ route('frontend.courses') }}">
                View all courses
                <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <div class="learning-course-grid">
            @forelse($courses as $course)
                @php
                    $courseTitle = $course->title ?? $course->course_name ?? 'Untitled Course';
                    $courseSlug = $course->slug ?? \Illuminate\Support\Str::slug($courseTitle.'-'.$course->getKey());
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
                    <div class="learning-course-thumb">
                        @if(!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                            <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $courseTitle }}">
                        @else
                            <img src="{{ asset('backend/img/course-image-default.png') }}" alt="Default Course Image">
                        @endif
                        <div class="learning-course-tags">
                            <span>{{ $categoryName }}</span>
                            <strong>{{ $status }}</strong>
                        </div>
                    </div>
                    <div class="learning-course-body">
                        <div class="learning-course-rating">
                            <i class="fas fa-star"></i>
                            <strong>{{ $rating ?? 'N/A' }}</strong>
                            <span>{{ $reviews ? '('.$reviews.')' : '' }}</span>
                        </div>
                        <h3>{{ $courseTitle }}</h3>
                        <p>{{ \Illuminate\Support\Str::limit($course->short_description ?? $course->description ?? 'No description available.', 120) }}</p>
                        <div class="learning-course-meta">
                            <span><i class="far fa-clock"></i> {{ $duration }}</span>
                            <span><i class="far fa-bookmark"></i> {{ $lessonsCount }} lessons</span>
                            <span><i class="far fa-user"></i> {{ $studentsCount }} students</span>
                            <span><i class="fas fa-layer-group"></i> {{ $level }}</span>
                            <span><i class="far fa-calendar"></i> {{ $createdDate }}</span>
                            <span><i class="fas fa-tag"></i> {{ is_null($price) ? 'Price not set' : '$'.number_format((float) $price, 2) }}</span>
                            @if(!is_null($discountPrice))
                                <span><i class="fas fa-percent"></i> ${{ number_format((float) $discountPrice, 2) }}</span>
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
                </article>
            @empty
                <div class="col-12 text-center py-5">
                    <img src="{{ asset('backend/img/course-image-default.png') }}" width="180" alt="Default Course Image">
                    <h4 class="mt-3">No Courses Available</h4>
                    <p>Please check back later.</p>
                </div>
            @endforelse
        </div>

        @if($courses->hasPages())
            <div class="learning-course-pagination">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>
