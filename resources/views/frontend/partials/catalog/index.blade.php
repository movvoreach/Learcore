@php
    $canManageCatalog = $canManageCatalog ?? (auth()->user()?->hasAnyRole(['super_admin', 'admin', 'teacher']) ?? false);
    $academicYears = $academicYears ?? collect();
    $departments = $departments ?? collect();
@endphp

@push('styles')
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
@endpush

<section class="learning-catalog" id="course-catalog">
    <div class="learning-catalog__inner">

        {{-- Hero Header --}}
        <div class="learning-catalog-hero reveal-item">
            <div class="learning-catalog-hero__text">
                <h2>បញ្ជីមុខវិជ្ជាសិក្សា</h2>
                <p>ស្វែងរកមុខវិជ្ជា ចែកតាមឆ្នាំសិក្សា និងជ្រើសរើសមេរៀនដែលសមស្របបំផុតសម្រាប់ការរៀនរបស់អ្នក។</p>
            </div>
            <div class="learning-catalog-hero__stats">
                <div class="catalog-stat">
                    <strong id="totalCourseStat">{{ $courses->total() }}</strong>
                    <span>មុខវិជ្ជាសរុប</span>
                </div>
                <div class="catalog-stat">
                    <strong>{{ $categories->count() }}</strong>
                    <span>ប្រភេទ</span>
                </div>
            </div>
        </div>

        @if($canManageCatalog)
        {{-- Toolbar --}}
        <form class="learning-catalog-toolbar reveal-item bg-white border rounded-3 shadow-sm" action="{{ route('frontend.courses') }}" method="GET">
            <label class="learning-catalog-search">
                <i class="fas fa-search"></i>
                <input type="search" id="catalogSearch" class="form-control border-0 shadow-none" name="search" value="{{ request('search') }}" placeholder="ស្វែងរកតាមឈ្មោះមុខវិជ្ជា ឬគ្រូបង្រៀន..." autocomplete="off">
                <span class="catalog-search-clear" id="catalogSearchClear" title="សម្អាត">&times;</span>
            </label>

            <div class="learning-catalog-toolbar__actions">
                <label class="learning-catalog-select">
                    <i class="fas fa-calendar-days"></i>
                    <select name="academic_year_id" id="catalogYearSelect" class="catalog-select2 form-control" aria-label="Select academic year" data-placeholder="ឆ្នាំសិក្សាទាំងអស់">
                        <option value="">ឆ្នាំសិក្សាទាំងអស់</option>
                        @foreach($academicYears as $academicYear)
                            <option value="{{ $academicYear->academic_year_id }}" @selected((string) request('academic_year_id') === (string) $academicYear->academic_year_id)>
                                {{ $academicYear->year_name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <label class="learning-catalog-select">
                    <i class="fas fa-building-columns"></i>
                    <select name="department_id" id="catalogDepartmentSelect" class="catalog-select2 form-control" aria-label="Select department" data-placeholder="ដេប៉ាតឺម៉ង់ទាំងអស់">
                        <option value="">ដេប៉ាតឺម៉ង់ទាំងអស់</option>
                        @foreach($departments as $department)
                            <option value="{{ $department->department_id }}" @selected((string) request('department_id') === (string) $department->department_id)>
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </label>

                <div class="learning-catalog-view-toggle btn-group" id="catalogViewToggle">
                    <button type="button" class="view-btn btn btn-warning is-active" data-view="grid" title="ទិដ្ឋភាពជាក្រឡា">
                        <i class="fas fa-th-large"></i>
                    </button>
                    <button type="button" class="view-btn btn btn-outline-secondary" data-view="list" title="ទិដ្ឋភាពជាបញ្ជី">
                        <i class="fas fa-list"></i>
                    </button>
                </div>

                <div class="learning-catalog-sort-wrapper" id="catalogSortWrapper">
                    <button type="button" class="learning-catalog-sort btn btn-light border" id="catalogSortToggle">
                        <i class="fas fa-arrow-down-wide-short"></i>
                        <span id="catalogSortLabel">ពេញនិយមបំផុត</span>
                        <i class="fas fa-chevron-down catalog-sort-chevron"></i>
                    </button>
                    <div class="learning-catalog-sort-dropdown" id="catalogSortDropdown">
                        <button type="button" class="sort-option is-active" data-sort="popular">
                            <i class="fas fa-fire"></i>
                            <span>ពេញនិយមបំផុត</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                        <button type="button" class="sort-option" data-sort="rating-desc">
                            <i class="fas fa-star"></i>
                            <span>វាយតម្លៃខ្ពស់បំផុត</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                        <button type="button" class="sort-option" data-sort="rating-asc">
                            <i class="fas fa-star-half-alt"></i>
                            <span>វាយតម្លៃទាបបំផុត</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                        <button type="button" class="sort-option" data-sort="newest">
                            <i class="fas fa-clock"></i>
                            <span>ថ្មីបំផុត</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                        <button type="button" class="sort-option" data-sort="name-asc">
                            <i class="fas fa-arrow-down-a-z"></i>
                            <span>ឈ្មោះ ក- org</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                        <button type="button" class="sort-option" data-sort="name-desc">
                            <i class="fas fa-arrow-up-z-a"></i>
                            <span>ឈ្មោះ org-ក</span>
                            <i class="fas fa-check sort-check"></i>
                        </button>
                    </div>
                </div>

                <button type="button" class="learning-catalog-filter-toggle btn btn-light border d-lg-none" id="catalogFilterToggle">
                    <i class="fas fa-sliders"></i>
                    <span>តម្រង</span>
                </button>
            </div>
        </form>
        @endif

        {{-- Result Counter --}}
        @if($canManageCatalog)
        <div class="learning-catalog-counter reveal-item">
            <span id="catalogResultCount">កំពុងបង្ហាញ <strong>{{ $courses->count() }}</strong> ក្នុងចំណោម <strong>{{ $courses->total() }}</strong> មុខវិជ្ជា</span>
        </div>
        @endif

        {{-- Layout --}}
        <div class="learning-catalog-layout {{ $canManageCatalog ? '' : 'learning-catalog-layout--student' }}">

            @if($canManageCatalog)
            {{-- Filter Sidebar --}}
            <aside class="learning-catalog-filter reveal-item bg-white border rounded-3" id="catalogFilterPanel">
                <div class="learning-filter-head">
                    <span><i class="fas fa-sliders"></i> ជ្រើសរើសមុខវិជ្ជា</span>
                    <button type="button" data-filter="all" class="filter-clear-btn">សម្អាតទាំងអស់</button>
                </div>

                <div class="learning-filter-group learning-filter-group--select">
                    <h3>ឆ្នាំសិក្សា</h3>
                    <select class="learning-sidebar-select catalog-select2 form-control" id="catalogSidebarYearFilter" data-filter-kind="academicYear" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សា">
                        <option value="all">គ្រប់ឆ្នាំសិក្សា ({{ $courses->total() }})</option>
                        @foreach($academicYears as $academicYear)
                            <option value="academic-year-{{ $academicYear->academic_year_id }}">
                                {{ $academicYear->year_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="learning-filter-group learning-filter-group--select">
                    <h3>ដេប៉ាតឺម៉ង់</h3>
                    <select class="learning-sidebar-select catalog-select2 form-control" id="catalogSidebarDepartmentFilter" data-filter-kind="department" data-placeholder="ជ្រើសរើសដេប៉ាតឺម៉ង់">
                        <option value="all">គ្រប់ដេប៉ាតឺម៉ង់</option>
                        @foreach($departments as $department)
                            <option value="department-{{ $department->department_id }}">
                                {{ $department->department_name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="learning-filter-group learning-filter-group--select">
                    <h3>ប្រភេទមុខវិជ្ជា</h3>
                    <select class="learning-sidebar-select catalog-select2 form-control" id="catalogSidebarCategoryFilter" data-filter-kind="type" data-placeholder="ជ្រើសរើសប្រភេទមុខវិជ្ជា">
                        <option value="all">គ្រប់ប្រភេទមុខវិជ្ជា</option>
                        @foreach($categories as $category)
                            <option value="cat-{{ $category->course_category_id }}">
                                {{ $category->category_name }}
                            </option>
                        @endforeach
                    </select>
                </div>
            </aside>

            {{-- Filter Overlay for Mobile --}}
            <div class="learning-catalog-overlay" id="catalogOverlay"></div>
            @endif

            {{-- Course Grid --}}
            <div class="learning-catalog-grid" id="catalogGrid">
                @forelse($courses as $course)
                    @php
                        $courseTitle = $course->title ?? $course->course_name ?? 'Untitled Course';
                        $courseSlug = $course->slug ?? \Illuminate\Support\Str::slug($courseTitle.'-'.$course->course_id);
                        $categoryName = optional($course->category)->category_name ?? 'Uncategorized';
                        $categoryId = optional($course->category)->course_category_id ?? 'uncategorized';
                        $departmentName = optional($course->department)->department_name ?? 'Department not assigned';
                        $departmentId = optional($course->department)->department_id ?? 'none';
                        $academicYearName = optional($course->academicYear)->year_name ?? 'Year not assigned';
                        $academicYearId = optional($course->academicYear)->academic_year_id ?? 'none';
                        $studyYear = 1;
                        if (preg_match('/(\d)/', (string) $course->course_code, $matches)) {
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
                        $isPrivateCourse = ($course->visibility ?? 'public') !== 'public';

                        $searchTags = strtolower(implode(' ', [
                            $courseTitle,
                            $categoryName,
                            $instructorName,
                            $studyYearLabel,
                            $departmentName,
                            $academicYearName
                        ]));
                    @endphp
                    <article class="learning-catalog-card reveal-item {{ $isPrivateCourse ? 'is-private' : '' }}"
                             data-year="year-{{ $studyYear }}"
                             data-type="cat-{{ $categoryId }}"
                             data-academic-year="academic-year-{{ $academicYearId }}"
                             data-department="department-{{ $departmentId }}"
                             data-visibility="{{ $course->visibility ?? 'public' }}"
                             data-rating="{{ $rating }}"
                             data-search="{{ $searchTags }}">
                        <div class="learning-course-thumb">
                            @if(!empty($course->image) && file_exists(public_path('storage/' . $course->image)))
                                <img src="{{ asset('storage/'.$course->image) }}" alt="{{ $courseTitle }}">
                            @else
                                <img src="{{ asset('backend/dist/img/photo3.jpg') }}" alt="{{ $courseTitle }}">
                            @endif
                            <div class="learning-course-badges">
                                <span class="badge-year">{{ $studyYearLabel }}</span>
                                @if($isPrivateCourse)
                                    <span class="badge-private" title="Private course">
                                        <i class="fas fa-lock"></i>
                                        <i class="fas fa-key"></i>
                                    </span>
                                @else
                                    <span class="badge-new">ថ្មី</span>
                                @endif
                            </div>
                        </div>
                        <div class="learning-course-body">
                            <div class="learning-course-category">
                                <i class="fas fa-folder"></i> {{ $categoryName }}
                            </div>
                            <h3 class="learning-course-title-text">{{ $courseTitle }}</h3>
                            <div class="learning-course-rating">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= floor($rating))
                                        <i class="fas fa-star"></i>
                                    @elseif($i - $rating < 1 && $i - $rating > 0)
                                        <i class="fas fa-star-half-alt"></i>
                                    @else
                                        <i class="far fa-star"></i>
                                    @endif
                                @endfor
                                <strong>{{ $rating }}</strong>
                                <span>({{ $reviews }})</span>
                            </div>
                            <p class="learning-course-desc">{{ \Illuminate\Support\Str::limit($course->description ?? 'No description available.', 100) }}</p>
                            <div class="learning-course-meta">
                                <span><i class="far fa-clock"></i> {{ $duration }}</span>
                                <span><i class="far fa-bookmark"></i> {{ $lessonsCount }} មេរៀន</span>
                                <span><i class="far fa-user"></i> {{ $studentsCount }} សិស្ស</span>
                            </div>
                            <div class="learning-course-footer">
                                <div class="learning-course-instructor">
                                    <img src="{{ asset('backend/dist/img/avatar.png') }}" alt="">
                                    <span>{{ $instructorName }}</span>
                                </div>
                                <a href="{{ route('frontend.courses.show', $courseSlug) }}" class="learning-course-btn">
                                    ចូលរៀន <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="learning-catalog-empty" style="display:block;">
                        <i class="fas fa-inbox"></i>
                        <h4>{{ auth()->user()?->isStudent() ? 'មិនមានមុខវិជ្ជាសម្រាប់គណនីរបស់អ្នកទេ។' : 'មិនមានមុខវិជ្ជាសាធារណៈទេ។' }}</h4>
                        <p>សូមពិនិត្យម្តងទៀតនៅពេលក្រោយ។</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Pagination --}}
        @if($courses->hasPages())
            <div class="learning-course-pagination">
                {{ $courses->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
</section>

@once
    <style>
        .learning-catalog {
            --catalog-ink: #102033;
            --catalog-muted: #64748b;
            --catalog-soft: #f6f8fb;
            --catalog-line: #e2e8f0;
            --catalog-brand: #f04d00;
            --catalog-brand-dark: #c2410c;
            --catalog-green: #15803d;
            --catalog-shadow-sm: 0 10px 24px rgba(15, 23, 42, .07);
            --catalog-shadow-md: 0 18px 44px rgba(15, 23, 42, .12);
        }

        /* ═══════════════════════════════════════════
           CATALOG — Hero Header
           ═══════════════════════════════════════════ */
        .learning-catalog-hero {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 32px;
            overflow: hidden;
            padding: 30px;
            border: 1px solid rgba(226, 232, 240, .92);
            border-radius: 24px;
            background:
                linear-gradient(135deg, rgba(255, 247, 237, .95), rgba(255, 255, 255, .96) 48%, rgba(236, 253, 245, .88)),
                radial-gradient(circle at top right, rgba(240, 77, 0, .14), transparent 34%);
            box-shadow: var(--catalog-shadow-sm);
        }

        .learning-catalog-hero::before {
            content: "";
            position: absolute;
            inset: 0;
            pointer-events: none;
            background-image:
                linear-gradient(rgba(15, 23, 42, .035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(15, 23, 42, .035) 1px, transparent 1px);
            background-size: 34px 34px;
            mask-image: linear-gradient(90deg, rgba(0, 0, 0, .7), transparent 78%);
        }

        .learning-catalog-hero__text,
        .learning-catalog-hero__stats {
            position: relative;
            z-index: 1;
        }

        .learning-catalog-hero__text h2 {
            margin: 0;
            color: var(--catalog-ink);
            font-size: 36px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-catalog-hero__text p {
            max-width: 680px;
            margin: 12px 0 0;
            color: var(--catalog-muted);
            font-size: 16px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-catalog-hero__stats {
            display: flex;
            gap: 14px;
            flex-shrink: 0;
        }

        .catalog-stat {
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-width: 118px;
            min-height: 94px;
            padding: 16px 18px;
            border: 1px solid rgba(187, 247, 208, .95);
            border-radius: 18px;
            background: rgba(255, 255, 255, .82);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .9), 0 14px 28px rgba(21, 128, 61, .09);
        }

        .catalog-stat strong {
            font-size: 30px;
            font-weight: 900;
            color: var(--catalog-green);
            line-height: 1;
        }

        .catalog-stat span {
            margin-top: 8px;
            font-size: 12px;
            font-weight: 700;
            color: #475569;
            text-align: center;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Toolbar
           ═══════════════════════════════════════════ */
        .learning-catalog-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            min-width: 0;
            margin: 24px 0 0;
            padding: 14px;
            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 18px;
            background: rgba(248, 250, 252, .92);
            box-shadow: 0 8px 22px rgba(15, 23, 42, .05);
        }

        .learning-catalog-search {
            position: relative;
            min-width: 0;
            min-height: 46px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: min(480px, 100%);
            margin: 0;
            padding: 0 18px;
            border: 1px solid var(--catalog-line);
            border-radius: 14px;
            background: #fff;
            color: #94a3b8;
            box-shadow: inset 0 1px 0 rgba(15, 23, 42, .02);
            transition: border-color .2s ease, box-shadow .2s ease, background .2s ease;
        }

        .learning-catalog-search:focus-within {
            border-color: var(--catalog-brand);
            background: #fff;
            box-shadow: 0 0 0 3px rgba(240, 77, 0, .1);
        }

        .learning-catalog-search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #0f172a;
            font: inherit;
            font-size: 14px;
            font-weight: 700;
        }

        .catalog-search-clear {
            display: none;
            font-size: 20px;
            font-weight: 900;
            color: #94a3b8;
            cursor: pointer;
            line-height: 1;
            padding: 2px 4px;
            transition: color .18s ease;
        }

        .catalog-search-clear:hover {
            color: #ef4444;
        }

        .catalog-search-clear.is-visible {
            display: block;
        }

        .learning-catalog-toolbar__actions {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            justify-content: flex-end;
            gap: 10px;
            min-width: 0;
        }

        .learning-catalog-select {
            min-width: 0;
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 0;
            padding: 0 12px;
            border: 1px solid var(--catalog-line);
            border-radius: 14px;
            background: #fff;
            color: var(--catalog-muted);
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .learning-catalog-select select {
            min-width: 160px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #0f172a;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        .learning-catalog-select:focus-within {
            border-color: var(--catalog-brand);
            box-shadow: 0 0 0 3px rgba(240, 77, 0, .1);
        }

        .learning-catalog-select .select2-container {
            min-width: 180px;
            max-width: 260px;
        }

        .learning-catalog-select .select2-container--default .select2-selection--single,
        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single {
            height: 40px;
            border: 0;
            background: transparent;
            display: flex;
            align-items: center;
        }

        .learning-catalog-select .select2-container--default .select2-selection--single .select2-selection__rendered,
        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            padding-left: 0;
            padding-right: 24px;
            color: var(--catalog-ink);
            font-size: 13px;
            font-weight: 800;
            line-height: 40px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-catalog-select .select2-container--default .select2-selection--single .select2-selection__arrow,
        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .learning-catalog-view-toggle {
            display: flex;
            gap: 0;
            border: 1px solid var(--catalog-line);
            border-radius: 12px;
            overflow: hidden;
            background: #fff;
        }

        .view-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 42px;
            height: 42px;
            border: 0;
            background: transparent;
            color: #94a3b8;
            font-size: 15px;
            cursor: pointer;
            transition: background .18s ease, color .18s ease;
        }

        .view-btn:hover {
            background: #f1f5f9;
            color: #475569;
        }

        .view-btn.is-active {
            background: var(--catalog-brand);
            color: #fff;
        }

        .learning-catalog-sort-wrapper {
            position: relative;
        }

        .learning-catalog-sort {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 0 16px;
            border: 1px solid var(--catalog-line);
            border-radius: 12px;
            background: #fff;
            color: var(--catalog-ink);
            font: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .learning-catalog-sort:hover,
        .learning-catalog-sort.is-open {
            border-color: var(--catalog-brand);
            box-shadow: 0 2px 6px rgba(240, 77, 0, .1);
        }

        .catalog-sort-chevron {
            font-size: 10px;
            transition: transform .25s ease;
        }

        .learning-catalog-sort.is-open .catalog-sort-chevron {
            transform: rotate(180deg);
        }

        /* Sort Dropdown */
        .learning-catalog-sort-dropdown {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            min-width: 240px;
            padding: 8px;
            border: 1px solid #e5e7eb;
            border-radius: 14px;
            background: #fff;
            box-shadow: 0 12px 36px rgba(15, 23, 42, .14), 0 4px 12px rgba(15, 23, 42, .06);
            z-index: 100;
            opacity: 0;
            visibility: hidden;
            transform: translateY(-8px) scale(.97);
            transition: opacity .22s ease, transform .22s ease, visibility .22s ease;
        }

        .learning-catalog-sort-dropdown.is-open {
            opacity: 1;
            visibility: visible;
            transform: translateY(0) scale(1);
        }

        .sort-option {
            display: flex;
            align-items: center;
            gap: 10px;
            width: 100%;
            min-height: 40px;
            padding: 0 14px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #475569;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            cursor: pointer;
            transition: background .15s ease, color .15s ease;
        }

        .sort-option:hover {
            background: #f8fafc;
            color: #0f172a;
        }

        .sort-option.is-active {
            background: #fff7ed;
            color: #ea580c;
            font-weight: 800;
        }

        .sort-option i:first-child {
            width: 18px;
            text-align: center;
            font-size: 13px;
            color: #94a3b8;
        }

        .sort-option.is-active i:first-child {
            color: #ea580c;
        }

        .sort-option span {
            flex: 1;
        }

        .sort-check {
            font-size: 11px;
            color: #ea580c;
            opacity: 0;
            transition: opacity .15s ease;
        }

        .sort-option.is-active .sort-check {
            opacity: 1;
        }

        .learning-catalog-filter-toggle {
            min-height: 42px;
            display: none;
            align-items: center;
            gap: 8px;
            padding: 0 16px;
            border: 1px solid #dbe3ee;
            border-radius: 10px;
            background: #fff;
            color: #0f172a;
            font: inherit;
            font-size: 13px;
            font-weight: 800;
            cursor: pointer;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Result Counter
           ═══════════════════════════════════════════ */
        .learning-catalog-counter {
            margin: 18px 0 0;
            padding: 0 4px;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
        }

        .learning-catalog-counter strong {
            color: #f04d00;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Filter Sidebar
           ═══════════════════════════════════════════ */
        .learning-catalog-layout {
            display: grid;
            grid-template-columns: 292px minmax(0, 1fr);
            gap: 28px;
            margin-top: 24px;
            align-items: start;
            min-width: 0;
        }

        .learning-catalog-layout--student {
            grid-template-columns: 1fr;
            margin-top: 32px;
        }

        .learning-catalog-filter {
            position: sticky;
            top: 100px;
            max-height: calc(100dvh - 124px);
            overflow-y: auto;
            overflow-x: hidden;
            overscroll-behavior: contain;
            padding: 24px 22px;
            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 18px;
            background: #fff;
            box-shadow: var(--catalog-shadow-sm);
            transition: box-shadow .25s ease;
            scrollbar-width: thin;
            scrollbar-color: #94a3b8 transparent;
        }

        .learning-catalog-filter::-webkit-scrollbar {
            width: 6px;
        }

        .learning-catalog-filter::-webkit-scrollbar-track {
            background: transparent;
        }

        .learning-catalog-filter::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: #cbd5e1;
        }

        .learning-catalog-filter::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
        }

        .learning-catalog-filter:hover {
            box-shadow: var(--catalog-shadow-md);
        }

        .learning-filter-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            margin-bottom: 22px;
            padding-bottom: 16px;
            border-bottom: 1px solid #f1f5f9;
        }

        .learning-filter-head > span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: var(--catalog-ink);
            font-size: 16px;
            font-weight: 900;
        }

        .learning-filter-head i {
            color: var(--catalog-brand);
        }

        .filter-clear-btn {
            border: 0;
            background: transparent;
            color: var(--catalog-brand);
            font: inherit;
            font-size: 12px;
            font-weight: 800;
            cursor: pointer;
            padding: 4px 10px;
            border-radius: 6px;
            transition: background .18s ease;
        }

        .filter-clear-btn:hover {
            background: #fff7ed;
        }

        .learning-filter-group {
            display: grid;
            gap: 4px;
            margin-top: 20px;
        }

        .learning-filter-group--select {
            gap: 8px;
        }

        .learning-filter-group h3 {
            margin: 0 0 8px;
            padding: 0 12px;
            color: #748298;
            font-size: 11px;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 0.6px;
        }

        .learning-sidebar-select {
            width: 100%;
        }

        .learning-filter-group .select2-container {
            width: 100% !important;
        }

        .learning-filter-group .select2-container--default .select2-selection--single,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single {
            height: 42px;
            border: 1px solid var(--catalog-line);
            border-radius: 12px;
            background: #fff;
            display: flex;
            align-items: center;
            transition: border-color .18s ease, box-shadow .18s ease;
        }

        .learning-filter-group .select2-container--open .select2-selection--single,
        .learning-filter-group .select2-container--focus .select2-selection--single {
            border-color: var(--catalog-brand);
            box-shadow: 0 0 0 3px rgba(240, 77, 0, .1);
        }

        .learning-filter-group .select2-container--default .select2-selection--single .select2-selection__rendered,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            width: 100%;
            padding-left: 12px;
            padding-right: 32px;
            color: #334155;
            font-size: 13px;
            font-weight: 800;
            line-height: 42px;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-filter-group .select2-container--default .select2-selection--single .select2-selection__arrow,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: 42px;
            right: 6px;
        }

        .select2-dropdown.learning-catalog-select2-dropdown {
            border-color: var(--catalog-line);
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .16);
        }

        .learning-catalog-select2-dropdown .select2-search--dropdown {
            padding: 8px;
        }

        .learning-catalog-select2-dropdown .select2-search--dropdown .select2-search__field {
            min-height: 36px;
            border: 1px solid #dbe3ee;
            border-radius: 8px;
            outline: 0;
            padding: 6px 10px;
        }

        .learning-catalog-select2-dropdown .select2-results__option {
            padding: 8px 12px;
            font-size: 13px;
            font-weight: 700;
        }

        .learning-catalog-select2-dropdown .select2-results__option--highlighted[aria-selected] {
            background: #fff7ed;
            color: var(--catalog-brand-dark);
        }

        .learning-filter-group button {
            display: flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            min-height: 38px;
            padding: 0 12px;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #475569;
            font: inherit;
            font-size: 13px;
            font-weight: 700;
            text-align: left;
            overflow: hidden;
            white-space: nowrap;
            text-overflow: ellipsis;
            cursor: pointer;
            transition: background .18s ease, color .18s ease, transform .12s ease;
        }

        .learning-filter-group button > i {
            flex: 0 0 auto;
        }

        .learning-filter-group button i {
            font-size: 12px;
            width: 16px;
            text-align: center;
            color: #94a3b8;
            transition: color .18s ease;
        }

        .learning-filter-group button:hover {
            background: #fff7ed;
            color: #ea580c;
        }

        .learning-filter-group button:hover i {
            color: #ea580c;
        }

        .learning-filter-group button.is-active {
            background: linear-gradient(135deg, #fff7ed 0%, #ffedd5 100%);
            color: var(--catalog-brand-dark);
            font-weight: 800;
        }

        .learning-filter-group button.is-active i {
            color: #ea580c;
        }

        .filter-count {
            margin-left: auto;
            flex: 0 0 auto;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 24px;
            height: 20px;
            padding: 0 6px;
            border-radius: 10px;
            background: #f1f5f9;
            color: #64748b;
            font-size: 11px;
            font-weight: 800;
        }

        .learning-filter-group button.is-active .filter-count {
            background: #ea580c;
            color: #fff;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Overlay for Mobile Filter
           ═══════════════════════════════════════════ */
        .learning-catalog-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(15, 23, 42, .45);
            z-index: 999;
            opacity: 0;
            transition: opacity .25s ease;
        }

        .learning-catalog-overlay.is-visible {
            display: block;
            opacity: 1;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Card Grid
           ═══════════════════════════════════════════ */
        .learning-catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(230px, 1fr));
            gap: 22px;
            min-width: 0;
        }

        .learning-catalog-card {
            position: relative;
            min-width: 0;
            overflow: hidden;
            border: 1px solid rgba(226, 232, 240, .95);
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 8px 22px rgba(15, 23, 42, .06);
            transition: transform .3s cubic-bezier(.4, 0, .2, 1),
                        box-shadow .3s cubic-bezier(.4, 0, .2, 1),
                        border-color .3s ease;
        }

        .learning-catalog-card:hover {
            transform: translateY(-5px);
            border-color: rgba(240, 77, 0, .2);
            box-shadow: var(--catalog-shadow-md);
        }

        .learning-catalog-card.is-private {
            border-color: #009688;
            box-shadow: 0 10px 24px rgba(0, 100, 86, .16);
        }

        .learning-catalog-card.is-private:hover {
            border-color: #009688;
            background: #f1fbf9;
            box-shadow: 0 18px 42px rgba(0, 100, 86, .22);
        }

        .learning-catalog-card.is-hidden {
            display: none;
        }

        /* Card Thumb */
        .learning-catalog-card .learning-course-thumb {
            position: relative;
            height: 176px;
            overflow: hidden;
            background: #e2e8f0;
        }

        .learning-catalog-card .learning-course-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .5s cubic-bezier(.4, 0, .2, 1);
        }

        .learning-catalog-card:hover .learning-course-thumb img {
            transform: scale(1.06);
        }

        .learning-course-badges {
            position: absolute;
            top: 12px;
            left: 12px;
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
            max-width: calc(100% - 24px);
        }

        .badge-year {
            padding: 4px 10px;
            border-radius: 999px;
            background: rgba(15, 23, 42, .7);
            backdrop-filter: blur(6px);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
        }

        .badge-new {
            padding: 4px 10px;
            border-radius: 999px;
            background: linear-gradient(135deg, var(--catalog-brand), #f97316);
            color: #fff;
            font-size: 11px;
            font-weight: 800;
        }

        .badge-private {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 9px;
            border: 1px solid #fff;
            border-radius: 999px;
            background: #009688;
            color: #fff;
            font-size: 11px;
            font-weight: 800;
            box-shadow: 0 2px 6px rgba(0, 100, 86, .28);
        }

        .badge-private i {
            font-size: 10px;
            line-height: 1;
        }

        /* Card Body */
        .learning-course-body {
            display: flex;
            min-height: 268px;
            flex-direction: column;
            padding: 18px 20px 20px;
        }

        .learning-course-category {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 8px;
            color: #748298;
            font-size: 12px;
            font-weight: 700;
        }

        .learning-course-category i {
            font-size: 10px;
        }

        .learning-course-title-text {
            margin: 0 0 10px;
            color: var(--catalog-ink);
            font-size: 16px;
            font-weight: 800;
            line-height: 1.45;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            transition: color .18s ease;
        }

        .learning-catalog-card:hover .learning-course-title-text {
            color: var(--catalog-brand);
        }

        .learning-catalog-card.is-private .learning-course-title-text {
            margin-bottom: 12px;
            padding: 7px 10px;
            border: 1px solid #fff;
            border-radius: 2px;
            background: #009688;
            color: #fff;
        }

        .learning-catalog-card.is-private:hover .learning-course-title-text {
            color: #fff;
        }

        .learning-course-rating {
            display: flex;
            align-items: center;
            gap: 4px;
            margin-bottom: 10px;
        }

        .learning-course-rating i {
            color: #f59e0b;
            font-size: 12px;
        }

        .learning-course-rating strong {
            color: var(--catalog-ink);
            font-size: 13px;
            font-weight: 800;
            margin-left: 2px;
        }

        .learning-course-rating span {
            color: #94a3b8;
            font-size: 12px;
            font-weight: 600;
        }

        .learning-course-desc {
            margin: 0 0 14px;
            color: #64748b;
            font-size: 13px;
            line-height: 1.65;
            font-weight: 600;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .learning-catalog-card .learning-course-meta {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
            margin-bottom: 16px;
            margin-top: auto;
        }

        .learning-catalog-card .learning-course-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            padding: 4px 10px;
            border-radius: 999px;
            background: #f8fafc;
            border: 1px solid #edf2f7;
            color: #475569;
            font-size: 11px;
            font-weight: 700;
        }

        .learning-catalog-card .learning-course-meta span i {
            font-size: 11px;
            color: #94a3b8;
        }

        /* Card Footer */
        .learning-course-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-top: 14px;
            border-top: 1px solid #f1f5f9;
        }

        .learning-course-instructor {
            display: flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .learning-course-instructor img {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid #f1f5f9;
            flex-shrink: 0;
        }

        .learning-course-instructor span {
            color: #475569;
            font-size: 12px;
            font-weight: 700;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .learning-catalog-card .learning-course-btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 12px;
            background: linear-gradient(135deg, var(--catalog-brand) 0%, var(--catalog-brand-dark) 100%);
            color: #fff;
            font-size: 12px;
            font-weight: 800;
            text-decoration: none;
            white-space: nowrap;
            flex-shrink: 0;
            transition: transform .18s ease, box-shadow .18s ease;
        }

        .learning-catalog-card .learning-course-btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(240, 77, 0, .3);
        }

        .learning-catalog-card .learning-course-btn i {
            font-size: 10px;
            transition: transform .18s ease;
        }

        .learning-catalog-card .learning-course-btn:hover i {
            transform: translateX(3px);
        }

        /* ═══════════════════════════════════════════
           CATALOG — List View
           ═══════════════════════════════════════════ */
        .learning-catalog-grid.is-list-view {
            grid-template-columns: 1fr;
            gap: 16px;
        }

        .learning-catalog-grid.is-list-view .learning-catalog-card {
            display: grid;
            grid-template-columns: 260px minmax(0, 1fr);
            border-radius: 18px;
        }

        .learning-catalog-grid.is-list-view .learning-course-thumb {
            height: 100%;
            min-height: 218px;
            border-radius: 18px 0 0 18px;
        }

        .learning-catalog-grid.is-list-view .learning-course-body {
            display: flex;
            flex-direction: column;
            justify-content: center;
            min-height: auto;
            padding: 20px 24px;
        }

        .learning-catalog-grid.is-list-view .learning-course-desc {
            -webkit-line-clamp: 3;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Empty State
           ═══════════════════════════════════════════ */
        .learning-catalog-empty {
            display: none;
            grid-column: 1 / -1;
            padding: 48px 24px;
            border: 2px dashed #e2e8f0;
            border-radius: 18px;
            text-align: center;
        }

        .learning-catalog-empty i {
            font-size: 48px;
            color: #cbd5e1;
            margin-bottom: 12px;
        }

        .learning-catalog-empty h4 {
            margin: 0 0 6px;
            color: #475569;
            font-size: 18px;
            font-weight: 800;
        }

        .learning-catalog-empty p {
            margin: 0;
            color: #94a3b8;
            font-size: 14px;
            font-weight: 600;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Pagination
           ═══════════════════════════════════════════ */
        .learning-course-pagination {
            display: flex;
            justify-content: center;
            margin-top: 48px;
        }

        .learning-course-pagination .pagination {
            display: flex;
            gap: 6px;
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .learning-course-pagination .page-link {
            display: flex;
            align-items: center;
            justify-content: center;
            min-width: 40px;
            height: 40px;
            padding: 0 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
            color: #475569;
            font-size: 14px;
            font-weight: 700;
            text-decoration: none;
            transition: all .18s ease;
        }

        .learning-course-pagination .page-link:hover {
            border-color: #f04d00;
            background: #fff7ed;
            color: #f04d00;
        }

        .learning-course-pagination .page-item.active .page-link {
            background: linear-gradient(135deg, #f04d00, #ea580c);
            border-color: #f04d00;
            color: #fff;
            box-shadow: 0 4px 12px rgba(240, 77, 0, .3);
        }

        .learning-course-pagination .page-item.disabled .page-link {
            opacity: .4;
            pointer-events: none;
        }

        /* ═══════════════════════════════════════════
           CATALOG — Card Animate In
           ═══════════════════════════════════════════ */
        @keyframes catalogCardIn {
            from {
                opacity: 0;
                transform: translateY(18px) scale(.97);
            }
            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .learning-catalog-card.animate-in {
            animation: catalogCardIn .35s cubic-bezier(.4, 0, .2, 1) forwards;
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE — Tablet
           ═══════════════════════════════════════════ */
        @media (max-width: 1199.98px) {
            .learning-catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .learning-catalog-layout {
                grid-template-columns: 260px minmax(0, 1fr);
                gap: 24px;
            }
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE — Small Tablet / Large Phone
           ═══════════════════════════════════════════ */
        @media (max-width: 991.98px) {
            .learning-catalog-hero {
                flex-direction: column;
                align-items: flex-start;
            }

            .learning-catalog-hero__text h2 {
                font-size: 30px;
            }

            .learning-catalog-toolbar {
                flex-wrap: wrap;
            }

            .learning-catalog-toolbar__actions {
                width: 100%;
                justify-content: flex-start;
            }

            .learning-catalog-select .select2-container {
                max-width: none;
            }

            .learning-catalog-filter-toggle {
                display: inline-flex !important;
            }

            .learning-catalog-layout {
                grid-template-columns: 1fr;
            }

            .learning-catalog-filter {
                position: fixed;
                top: 0;
                left: -320px;
                bottom: 0;
                width: min(320px, calc(100vw - 32px));
                max-height: 100dvh;
                z-index: 1000;
                border-radius: 0 18px 18px 0;
                padding-bottom: max(24px, env(safe-area-inset-bottom));
                overflow-y: auto;
                overflow-x: hidden;
                overscroll-behavior: contain;
                transition: left .35s cubic-bezier(.4, 0, .2, 1);
            }

            .learning-catalog-filter.is-open {
                left: 0;
            }

            .learning-catalog-grid.is-list-view .learning-catalog-card {
                grid-template-columns: 200px 1fr;
            }
        }

        /* ═══════════════════════════════════════════
           RESPONSIVE — Phone
           ═══════════════════════════════════════════ */
        @media (max-width: 767.98px) {
            .learning-catalog__inner {
                padding: 68px 16px;
            }

            .learning-catalog-hero__text h2 {
                font-size: 26px;
            }

            .learning-catalog-toolbar {
                padding: 12px;
                gap: 10px;
            }

            .learning-catalog-search {
                width: 100%;
            }

            .learning-catalog-select {
                width: 100%;
            }

            .learning-catalog-select .select2-container {
                width: 100% !important;
                min-width: 0;
            }

            .learning-catalog-select select {
                width: 100%;
            }

            .learning-catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                gap: 14px;
            }

            .learning-catalog-card .learning-course-thumb {
                height: 140px;
            }

            .learning-course-body {
                min-height: 0;
                padding: 14px 14px 16px;
            }

            .learning-course-title-text {
                font-size: 14px;
            }

            .learning-course-desc {
                display: none;
            }

            .learning-catalog-card .learning-course-meta span {
                font-size: 10px;
                padding: 3px 7px;
            }

            .learning-course-footer {
                flex-direction: column;
                align-items: stretch;
                gap: 10px;
            }

            .learning-catalog-card .learning-course-btn {
                justify-content: center;
            }

            .learning-catalog-grid.is-list-view .learning-catalog-card {
                grid-template-columns: 1fr;
            }

            .learning-catalog-grid.is-list-view .learning-course-thumb {
                height: 160px;
                border-radius: 14px 14px 0 0;
            }
        }

        @media (max-width: 479.98px) {
            .learning-catalog-grid {
                grid-template-columns: 1fr;
            }

            .learning-catalog-view-toggle {
                display: none;
            }

            .learning-catalog-hero__stats {
                width: 100%;
            }

            .catalog-stat {
                flex: 1;
            }
        }

        /* Bootstrap default reset for catalog controls */
        .learning-catalog-toolbar {
            align-items: center;
            padding: 1rem;
            border: 1px solid #dee2e6;
            border-radius: .75rem;
            background: #fff;
            box-shadow: 0 .125rem .25rem rgba(0, 0, 0, .075);
        }

        .learning-catalog-search,
        .learning-catalog-select,
        .learning-catalog-sort,
        .learning-catalog-filter-toggle,
        .learning-catalog-view-toggle {
            min-height: 38px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
            background: #fff;
            box-shadow: none;
        }

        .learning-catalog-search {
            width: min(450px, 100%);
            padding: 0 .75rem;
            gap: .5rem;
        }

        .learning-catalog-search:focus-within,
        .learning-catalog-select:focus-within,
        .learning-catalog-sort:hover,
        .learning-catalog-sort.is-open {
            border-color: #86b7fe;
            box-shadow: 0 0 0 .25rem rgba(13, 110, 253, .25);
        }

        .learning-catalog-search input {
            min-height: 36px;
            font-size: .875rem;
            font-weight: 400;
        }

        .learning-catalog-toolbar__actions {
            gap: .5rem;
        }

        .learning-catalog-select {
            height: 40px;
            padding: 0 .625rem;
            gap: .5rem;
        }

        .learning-catalog-select > i,
        .learning-catalog-search > i {
            color: #6c757d;
        }

        .learning-catalog-select .select2-container {
            width: 190px !important;
            min-width: 0;
            max-width: none;
        }

        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single {
            height: calc(1.5em + .75rem + 2px) !important;
            border: 0;
            border-radius: .25rem;
            background: transparent;
            box-shadow: none;
        }

        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single {
            border: 1px solid #ced4da;
            background: #fff;
        }

        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered {
            padding-left: .25rem;
            padding-right: 1.75rem;
            color: #495057;
            font-size: .875rem;
            font-weight: 400;
            line-height: calc(1.5em + .75rem);
        }

        .learning-catalog-select .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow,
        .learning-filter-group .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow {
            height: calc(1.5em + .75rem);
        }

        .select2-container--bootstrap4 .select2-dropdown.learning-catalog-select2-dropdown {
            border-color: #ced4da;
            border-radius: .25rem;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        }

        .learning-catalog-select2-dropdown .select2-search--dropdown {
            padding: .5rem;
        }

        .learning-catalog-select2-dropdown .select2-search--dropdown .select2-search__field {
            min-height: calc(1.5em + .75rem + 2px);
            padding: .375rem .75rem;
            border: 1px solid #ced4da;
            border-radius: .25rem;
            font-size: .875rem;
        }

        .learning-catalog-select2-dropdown .select2-results__option {
            padding: .375rem .75rem;
            font-size: .875rem;
            font-weight: 400;
        }

        .learning-catalog-select2-dropdown .select2-results__option--highlighted[aria-selected] {
            background: #0d6efd;
            color: #fff;
        }

        .learning-catalog-filter {
            border: 1px solid #dee2e6;
            border-radius: .75rem;
            box-shadow: none;
        }

        .learning-catalog-filter:hover {
            box-shadow: none;
        }

        .filter-clear-btn {
            color: #fd7e14;
            font-weight: 600;
        }

        .filter-clear-btn:hover {
            background: #fff3cd;
        }

        .learning-filter-group h3 {
            padding: 0;
            color: #6c757d;
            font-size: .8125rem;
            font-weight: 600;
            letter-spacing: 0;
            text-transform: none;
        }

        .learning-catalog-sort {
            min-height: 40px;
            padding: .375rem .75rem;
            color: #212529;
            font-size: .875rem;
            font-weight: 400;
        }

        .learning-catalog-sort-dropdown {
            border-radius: .375rem;
            box-shadow: 0 .5rem 1rem rgba(0, 0, 0, .15);
        }

        .view-btn {
            width: 40px;
            height: 38px;
        }

        .view-btn.is-active {
            background: #fd7e14;
            color: #fff;
        }

        @media (max-width: 767.98px) {
            .learning-catalog-select .select2-container {
                width: 100% !important;
            }
        }
    </style>
@endonce

@push('scripts')
<script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
<script>
$(function() {
    /* ────────────────────────────────
       Filter Count Badges
       ──────────────────────────────── */
    (function computeFilterCounts() {
        var $cards = $('.learning-catalog-card');
        var counts = {};

        $cards.each(function() {
            var yearKey = $(this).data('year');
            var typeKey = $(this).data('type');
            var academicYearKey = $(this).data('academic-year');
            var departmentKey = $(this).data('department');
            counts[yearKey] = (counts[yearKey] || 0) + 1;
            counts[typeKey] = (counts[typeKey] || 0) + 1;
            counts[academicYearKey] = (counts[academicYearKey] || 0) + 1;
            counts[departmentKey] = (counts[departmentKey] || 0) + 1;
        });

        $('[data-count-filter]').each(function() {
            var key = $(this).data('count-filter');
            $(this).text(counts[key] || 0);
        });
    })();

    /* ────────────────────────────────
       Search Clear Button
       ──────────────────────────────── */
    var $searchInput = $('#catalogSearch');
    var $clearBtn = $('#catalogSearchClear');

    $searchInput.on('input', function() {
        $clearBtn.toggleClass('is-visible', $(this).val().length > 0);
    });

    $clearBtn.on('click', function() {
        $searchInput.val('').trigger('input').focus();
    });

    if ($.fn.select2) {
        $('.catalog-select2').each(function() {
            var $select = $(this);
            $select.select2({
                theme: 'bootstrap4',
                width: '100%',
                dropdownAutoWidth: false,
                dropdownCssClass: 'learning-catalog-select2-dropdown',
                placeholder: $select.data('placeholder') || '',
                dropdownParent: $(document.body)
            });
        });
    }

    $('#catalogYearSelect, #catalogDepartmentSelect').on('change', function() {
        this.form.submit();
    });

    /* ────────────────────────────────
       Grid / List View Toggle
       ──────────────────────────────── */
    var $catalogGrid = $('#catalogGrid');

    $('#catalogViewToggle').on('click', '.view-btn', function() {
        var $btn = $(this);
        var viewMode = $btn.data('view');

        $('.view-btn').removeClass('is-active');
        $btn.addClass('is-active');

        if (viewMode === 'list') {
            $catalogGrid.addClass('is-list-view');
        } else {
            $catalogGrid.removeClass('is-list-view');
        }

        // Animate cards in
        var $visibleCards = $catalogGrid.find('.learning-catalog-card:not(.is-hidden)');
        $visibleCards.removeClass('animate-in');
        $visibleCards.each(function(i) {
            var $card = $(this);
            setTimeout(function() {
                $card.addClass('animate-in');
            }, i * 40);
        });
    });

    /* ────────────────────────────────
       Mobile Filter Panel
       ──────────────────────────────── */
    var $filterPanel = $('#catalogFilterPanel');
    var $overlay = $('#catalogOverlay');

    function openFilterPanel() {
        $filterPanel.addClass('is-open');
        $overlay.addClass('is-visible');
        $('body').css('overflow', 'hidden');
    }

    function closeFilterPanel() {
        $filterPanel.removeClass('is-open');
        $overlay.removeClass('is-visible');
        $('body').css('overflow', '');
    }

    $('#catalogFilterToggle').on('click', openFilterPanel);
    $overlay.on('click', closeFilterPanel);

    /* ────────────────────────────────
       Filter & Search Logic
       ──────────────────────────────── */
    var $catalogCards = $('.learning-catalog-card');
    var activeCatalogFilters = {
        academicYear: 'all',
        department: 'all',
        type: 'all'
    };
    var sortDescending = true;

    function applyCatalogFilters() {
        var query = ($searchInput.val() || '').trim().toLowerCase();
        var visibleCount = 0;

        $catalogCards.each(function(i) {
            var $card = $(this);
            var matchesAcademicYear = activeCatalogFilters.academicYear === 'all'
                || $card.data('academic-year') === activeCatalogFilters.academicYear;
            var matchesDepartment = activeCatalogFilters.department === 'all'
                || $card.data('department') === activeCatalogFilters.department;
            var matchesType = activeCatalogFilters.type === 'all'
                || $card.data('type') === activeCatalogFilters.type;
            var matchesFilter = matchesAcademicYear && matchesDepartment && matchesType;
            var matchesSearch = !query || String($card.data('search')).toLowerCase().indexOf(query) !== -1;
            var shouldShow = matchesFilter && matchesSearch;

            $card.toggleClass('is-hidden', !shouldShow);

            if (shouldShow) {
                visibleCount += 1;
                // Staggered animation
                $card.removeClass('animate-in');
                (function(card, delay) {
                    setTimeout(function() {
                        card.addClass('animate-in');
                    }, delay);
                })($card, visibleCount * 30);
            }
        });

        // Update counter
        $('#catalogResultCount').html(
            'កំពុងបង្ហាញ <strong>' + visibleCount + '</strong> ក្នុងចំណោម <strong>' + $catalogCards.length + '</strong> មុខវិជ្ជា'
        );

        // Empty state
        $('.learning-catalog-empty').remove();
        if (!visibleCount) {
            $catalogGrid.append(
                '<div class="learning-catalog-empty" style="display:block;">' +
                    '<i class="fas fa-inbox"></i>' +
                    '<h4>មិនមានមុខវិជ្ជាដែលត្រូវនឹងការស្វែងរកទេ។</h4>' +
                    '<p>សូមសាកល្បងស្វែងរកពាក្យផ្សេង ឬសម្អាតតម្រង។</p>' +
                '</div>'
            );
        }
    }

    $('.learning-sidebar-select').on('change', function() {
        var kind = $(this).data('filter-kind');

        if (kind && Object.prototype.hasOwnProperty.call(activeCatalogFilters, kind)) {
            activeCatalogFilters[kind] = $(this).val() || 'all';
        }

        applyCatalogFilters();
    });

    $('.filter-clear-btn').on('click', function() {
        activeCatalogFilters = {
            academicYear: 'all',
            department: 'all',
            type: 'all'
        };

        $('.learning-sidebar-select').val('all').trigger('change.select2');
        applyCatalogFilters();

        // Close mobile panel
        if (window.innerWidth < 992) {
            closeFilterPanel();
        }
    });

    /* Search */
    $searchInput.on('input', applyCatalogFilters);

    /* Sort Dropdown */
    var $sortToggle = $('#catalogSortToggle');
    var $sortDropdown = $('#catalogSortDropdown');
    var $sortLabel = $('#catalogSortLabel');
    var currentSort = 'popular';

    $sortToggle.on('click', function(e) {
        e.stopPropagation();
        var isOpen = $sortDropdown.hasClass('is-open');
        $sortDropdown.toggleClass('is-open', !isOpen);
        $sortToggle.toggleClass('is-open', !isOpen);
    });

    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('#catalogSortWrapper').length) {
            $sortDropdown.removeClass('is-open');
            $sortToggle.removeClass('is-open');
        }
    });

    // Sort option click
    $sortDropdown.on('click', '.sort-option', function() {
        var $opt = $(this);
        var sortKey = $opt.data('sort');

        if (sortKey === currentSort) {
            $sortDropdown.removeClass('is-open');
            $sortToggle.removeClass('is-open');
            return;
        }

        currentSort = sortKey;
        $('.sort-option').removeClass('is-active');
        $opt.addClass('is-active');
        $sortLabel.text($opt.find('span').text());

        // Sort logic
        var sortedCards = $catalogCards.get().sort(function(a, b) {
            var $a = $(a), $b = $(b);
            switch (sortKey) {
                case 'rating-desc':
                    return (Number($b.data('rating')) || 0) - (Number($a.data('rating')) || 0);
                case 'rating-asc':
                    return (Number($a.data('rating')) || 0) - (Number($b.data('rating')) || 0);
                case 'name-asc':
                    return String($a.data('search')).localeCompare(String($b.data('search')));
                case 'name-desc':
                    return String($b.data('search')).localeCompare(String($a.data('search')));
                case 'newest':
                    return $b.index() - $a.index();
                default: // popular
                    return (Number($b.data('rating')) || 0) - (Number($a.data('rating')) || 0);
            }
        });

        $catalogGrid.append(sortedCards);
        applyCatalogFilters();

        $sortDropdown.removeClass('is-open');
        $sortToggle.removeClass('is-open');
    });

    /* ────────────────────────────────
       Initial Card Animation
       ──────────────────────────────── */
    $catalogCards.each(function(i) {
        var $card = $(this);
        setTimeout(function() {
            $card.addClass('animate-in');
        }, i * 60);
    });
});
</script>
@endpush
