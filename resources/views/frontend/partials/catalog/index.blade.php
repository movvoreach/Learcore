<section class="learning-catalog" id="course-catalog">
    <div class="learning-catalog__inner">
        <div class="learning-catalog-head reveal-item">
            <h2>បញ្ជីមុខវិជ្ជាសិក្សា LMS</h2>
            <p>ស្វែងរកមុខវិជ្ជា ចែកតាមឆ្នាំសិក្សា និងជ្រើសរើសមេរៀនដែលសមស្របបំផុតសម្រាប់ការរៀនរបស់អ្នក។</p>
        </div>

        <div class="learning-catalog-toolbar reveal-item">
            <label class="learning-catalog-search">
                <i class="fas fa-search"></i>
                <input type="search" id="catalogSearch" placeholder="ស្វែងរកតាមឈ្មោះមុខវិជ្ជា ឬគ្រូបង្រៀន...">
            </label>

            <button type="button" class="learning-catalog-sort" id="catalogSort">
                <i class="fas fa-arrow-down-wide-short"></i>
                <span>ពេញនិយមបំផុត</span>
                <i class="fas fa-chevron-down"></i>
            </button>
        </div>

        <div class="learning-catalog-layout">
            <aside class="learning-catalog-filter reveal-item">
                <div class="learning-filter-head">
                    <span><i class="fas fa-sliders"></i> ជ្រើសរើសមុខវិជ្ជា</span>
                    <button type="button" data-filter="all">សម្អាតទាំងអស់</button>
                </div>

                <div class="learning-filter-group">
                    <h3>ឆ្នាំសិក្សា និងកម្រិត</h3>
                    <button type="button" class="is-active" data-filter="all">គ្រប់មុខវិជ្ជាទាំងអស់</button>
                    @foreach(range(1, 4) as $studyYear)
                        <button type="button" data-filter="year-{{ $studyYear }}">ឆ្នាំទី {{ $studyYear }}</button>
                    @endforeach
                </div>

                <div class="learning-filter-group">
                    <h3>ប្រភេទមុខវិជ្ជា</h3>
                    @foreach($categories as $category)
                        <button type="button" data-filter="cat-{{ $category->course_category_id }}">{{ $category->category_name }}</button>
                    @endforeach
                </div>
            </aside>

            <div class="learning-catalog-grid" id="catalogGrid">
                @forelse($courses as $course)
                    @php
                        $courseTitle = $course->title ?? $course->course_name ?? 'Untitled Course';
                        $courseSlug = $course->slug ?? \Illuminate\Support\Str::slug($courseTitle.'-'.$course->course_id);
                        $categoryName = optional($course->category)->category_name ?? 'Uncategorized';
                        $categoryId = optional($course->category)->course_category_id ?? 'uncategorized';
                        $studyYear = 1;
                        if (preg_match('/-(\d)/', (string) $course->course_code, $matches)) {
                            $studyYear = min(4, max(1, (int) $matches[1]));
                        }
                        $studyYearLabel = 'ឆ្នាំទី '.$studyYear;
                        
                        $instructor = $course->instructor;
                        $teacherName = trim((optional($instructor)->first_name ?? '').' '.(optional($instructor)->last_name ?? ''));
                        $instructorName = optional(optional($instructor)->user)->name ?? ($teacherName ?: 'Instructor not assigned');
                        
                        $rating = $course->rating ?? 4.5;
                        $reviews = $course->reviews_count ?? $course->rating_count ?? 12;
                        $lessonsCount = $course->lessons_count ?? $course->number_of_lessons ?? 0;
                        $durationMinutes = $course->total_duration_minutes ?? 0;
                        $duration = $course->duration ?? ($durationMinutes ? round($durationMinutes / 60, 1).' ម៉ោង' : '0 ម៉ោង');
                        $studentsCount = $course->students_count ?? $course->total_students ?? 0;
                        
                        $searchTags = strtolower(implode(' ', [
                            $courseTitle,
                            $categoryName,
                            $instructorName,
                            $studyYearLabel
                        ]));
                    @endphp
                    <article class="learning-catalog-card reveal-item"
                             data-year="year-{{ $studyYear }}" 
                             data-type="cat-{{ $categoryId }}" 
                             data-rating="{{ $rating }}" 
                             data-search="{{ $searchTags }}">
                        <div class="learning-course-thumb">
                            @if(!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                                <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $courseTitle }}">
                            @else
                                <img src="{{ asset('backend/dist/img/photo3.jpg') }}" alt="{{ $courseTitle }}">
                            @endif
                            <div class="learning-course-tags">
                                <span>{{ $studyYearLabel }}</span>
                                <strong>ថ្មីៗនេះ</strong>
                            </div>
                        </div>
                        <div class="learning-course-body">
                            <div class="learning-course-rating">
                                <i class="fas fa-star"></i> 
                                <strong>{{ $rating }}</strong> 
                                <span>({{ $reviews }})</span>
                            </div>
                            <h3>{{ $courseTitle }}</h3>
                            <p>{{ \Illuminate\Support\Str::limit($course->description ?? 'No description available.', 120) }}</p>
                            <div class="learning-course-meta">
                                <span><i class="far fa-clock"></i> {{ $duration }}</span>
                                <span><i class="far fa-bookmark"></i> {{ $lessonsCount }} មេរៀន</span>
                                <span><i class="far fa-user"></i> {{ $studentsCount }} សិស្ស</span>
                            </div>
                            <a href="{{ route('frontend.courses.show', $courseSlug) }}" class="learning-course-btn">ចូលរៀនឥឡូវនេះ</a>
                        </div>
                    </article>
                @empty
                    <div class="col-12 text-center py-5">
                        <h4 class="mt-3">{{ auth()->user()?->isStudent() ? 'No courses are available for your account at the moment.' : 'No public courses are available at the moment.' }}</h4>
                        <p>Please check back later.</p>
                    </div>
                @endforelse
            </div>
        </div>

        @if($courses->hasPages())
            <div class="learning-course-pagination">
                {{ $courses->links() }}
            </div>
        @endif
    </div>
</section>
