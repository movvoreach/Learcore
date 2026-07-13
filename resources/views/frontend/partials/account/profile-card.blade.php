@php
    $firstName = $student?->first_name ?: strtok($user->name, ' ');
    $lastName = $student?->last_name ?: trim(str_replace($firstName, '', $user->name));
    $badgesCount = $student ? $student->certificates()->count() : 0;
    $completedCount = $student ? $student->enrollments()->where('status', 'completed')->count() : 0;
    $learningLocale = session('learning_locale', 'en');
    $avatarUrl = $user->avatar
        ? (str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/'.$user->avatar))
        : asset('backend/dist/img/avatar.png');
    $roleLabel = $user->isStudent() ? 'Learner' : ($user->isTeacher() ? 'Instructor' : 'Administrator');
    $academyLabel = $student?->department?->department_name ?: 'Networking Academy';
    $achievementCards = collect([
        ['kind' => 'Achievement', 'icon' => 'fa-shield-alt', 'label' => 'Module', 'title' => 'Network Defense'],
        ['kind' => 'Achievement', 'icon' => 'fa-laptop-code', 'label' => 'Module', 'title' => 'Operating System and Endpoint...'],
        ['kind' => 'Achievement', 'icon' => 'fa-globe', 'label' => 'Module', 'title' => 'Network Security Basics'],
        ['kind' => 'Badge', 'icon' => 'fa-book-open', 'label' => 'Training', 'title' => 'CCNA: Introduction to Networks'],
    ]);
@endphp

<div class="netacad-profile">
    <a href="{{ route('dashboard') }}" class="netacad-back-btn" aria-label="Back to learning">
        <i class="fas fa-arrow-left"></i>
        <span>Back</span>
    </a>

    @if(session('success'))
        <div class="netacad-alert netacad-alert--success">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="netacad-alert netacad-alert--danger">
            <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
        </div>
    @endif

    <section class="netacad-hero">
        <div class="netacad-hero__inner">
            <form method="POST" action="{{ route('frontend.account.profile.update') }}" enctype="multipart/form-data" class="netacad-identity" id="netacadProfileForm">
                @csrf
                <input type="hidden" name="firstName" value="{{ old('firstName', $firstName) }}">
                <input type="hidden" name="lastName" value="{{ old('lastName', $lastName ?: $user->name) }}">
                <input type="hidden" name="gender" value="{{ old('gender', $student?->gender ?: 'Prefer not to say') }}">
                <div class="netacad-avatar">
                    <img src="{{ $avatarUrl }}" alt="{{ $displayName }}" id="netacadAvatarPreview">
                    <label for="file-input" class="netacad-avatar__edit" title="Change photo">
                        <i class="fas fa-camera"></i>
                    </label>
                    <input id="file-input" name="avatar" type="file" accept="image/jpg,image/png,image/jpeg">
                </div>

                <div class="netacad-user">
                    <span>Welcome,</span>
                    <h1>{{ $displayName }}</h1>
                    <p>{{ $roleLabel }} <b></b> {{ $academyLabel }}</p>
                </div>
            </form>

            <div class="netacad-stats" aria-label="Learning summary">
                <div class="netacad-stat">
                    <i class="fas fa-award"></i>
                    <strong>{{ $badgesCount ?: 1 }}</strong>
                    <span>Badges Earned</span>
                </div>
                <div class="netacad-stat">
                    <i class="fas fa-book-open"></i>
                    <strong>{{ $completedCount }}</strong>
                    <span>Courses Completed</span>
                </div>
            </div>
        </div>
    </section>

    <section class="netacad-body">
        <nav class="netacad-tabs" aria-label="Profile tabs">
            <button type="button" class="netacad-tab" data-netacad-tab="profile">
                <i class="far fa-user"></i><span>Profile</span>
            </button>
            <button type="button" class="netacad-tab is-active" data-netacad-tab="badges">
                <i class="fas fa-award"></i><span>Badges &amp; Certificates</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="discounts">
                <i class="fas fa-percent"></i><span>Discounts</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="history">
                <i class="fas fa-history"></i><span>Learning History</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="transcript">
                <i class="far fa-file-alt"></i><span>Transcript</span>
            </button>
        </nav>

        <div class="netacad-panel" data-netacad-panel="badges">
            <div class="netacad-subtabs">
                <button type="button" class="is-active">My Learning Achievements</button>
                <button type="button">My Awards</button>
            </div>

            <div class="netacad-toolbar">
                <label class="netacad-search">
                    <input type="search" placeholder="Search by name, course" aria-label="Search by name or course">
                    <i class="fas fa-search"></i>
                </label>

                <div class="netacad-filters">
                    <label>Offering
                        <select><option>All Offerings</option></select>
                    </label>
                    <label>Type
                        <select><option>All</option></select>
                    </label>
                    <label>Sort
                        <select><option>Latest</option></select>
                    </label>
                </div>
            </div>

            <div class="netacad-card-grid">
                @foreach($achievementCards as $card)
                    <article class="netacad-achievement-card">
                        <div class="netacad-ribbon">{{ $card['kind'] }}</div>
                        <div class="netacad-medal {{ $card['kind'] === 'Badge' ? 'netacad-medal--badge' : '' }}">
                            <i class="fas {{ $card['icon'] }}"></i>
                        </div>
                        <span>{{ $card['label'] }}</span>
                        <h2>{{ $card['title'] }}</h2>
                    </article>
                @endforeach
            </div>
        </div>

        <div class="netacad-panel is-hidden" data-netacad-panel="profile">
            <form method="POST" action="{{ route('frontend.account.profile.update') }}" enctype="multipart/form-data" class="netacad-form">
                @csrf
                <h2>Basic Information</h2>
                <div class="netacad-form-grid">
                    <label>First Name
                        <input name="firstName" type="text" required value="{{ old('firstName', $firstName) }}">
                    </label>
                    <label>Last Name
                        <input name="lastName" type="text" required value="{{ old('lastName', $lastName ?: $user->name) }}">
                    </label>
                    <label>Default Language
                        <select name="defaultLanguage">
                            <option value="en" {{ $learningLocale === 'en' ? 'selected' : '' }}>English (English)</option>
                            <option value="km" {{ $learningLocale === 'km' ? 'selected' : '' }}>Khmer</option>
                        </select>
                    </label>
                    <label>Email
                        <input type="email" value="{{ $user->email }}" disabled>
                    </label>
                    <label>Gender
                        <select name="gender">
                            @foreach(['Prefer not to say', 'Male', 'Female', 'Non-binary'] as $gender)
                                <option value="{{ $gender }}" {{ ($student?->gender === $gender) ? 'selected' : '' }}>{{ $gender }}</option>
                            @endforeach
                        </select>
                    </label>
                </div>
                <button type="submit" class="netacad-save">Save Changes</button>
            </form>
        </div>

        <div class="netacad-panel is-hidden" data-netacad-panel="discounts">
            <div class="netacad-empty"><i class="fas fa-tags"></i><p>No active discount vouchers available right now.</p></div>
        </div>

        <div class="netacad-panel is-hidden" data-netacad-panel="history">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr><th>Course Code</th><th>Course Name</th><th>Enrollment Date</th><th>Status</th></tr></thead>
                    <tbody>
                        @forelse($enrollments as $enroll)
                            <tr>
                                <td>{{ $enroll->course?->course_code }}</td>
                                <td>{{ $enroll->course?->course_name }}</td>
                                <td>{{ $enroll->enrollment_date?->format('d/m/Y') }}</td>
                                <td>{{ ucfirst($enroll->status) }}</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No learning history recorded.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="netacad-panel is-hidden" data-netacad-panel="transcript">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead><tr><th>Assessment</th><th>Category</th><th>Graded At</th><th>Score</th></tr></thead>
                    <tbody>
                        @forelse($grades as $grade)
                            <tr>
                                <td>{{ $grade->exam?->title ?? $grade->quiz?->title ?? $grade->assignment?->title ?? 'Assessment Item' }}</td>
                                <td>{{ $grade->exam ? 'Exam' : ($grade->quiz ? 'Quiz' : 'Assignment') }}</td>
                                <td>{{ $grade->graded_at?->format('d/m/Y H:i') }}</td>
                                <td>{{ number_format((float)$grade->score, 1) }}%</td>
                            </tr>
                        @empty
                            <tr><td colspan="4" class="text-center text-muted">No graded items found.</td></tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </section>
</div>

<style>
    .netacad-profile {
        position: relative;
        font-family: Arial, Helvetica, sans-serif;
        color: #1f2937;
        background: #fff;
    }

    .netacad-back-btn {
        position: fixed;
        top: 18px;
        left: 22px;
        z-index: 20;
        min-height: 42px;
        display: inline-flex;
        align-items: center;
        gap: 10px;
        padding: 0 16px;
        border: 1px solid rgba(255, 255, 255, .28);
        border-radius: 999px;
        background: rgba(7, 21, 47, .72);
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 12px 28px rgba(0, 0, 0, .18);
        backdrop-filter: blur(10px);
        transition: transform .18s ease, background .18s ease, box-shadow .18s ease;
    }

    .netacad-back-btn:hover {
        background: rgba(7, 21, 47, .92);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 16px 34px rgba(0, 0, 0, .22);
    }

    .netacad-back-btn i {
        font-size: 13px;
    }

    .netacad-alert {
        max-width: 1574px;
        margin: 18px auto;
        padding: 12px 18px;
        border-radius: 4px;
        font-weight: 700;
    }

    .netacad-alert--success {
        background: #eaf8ee;
        color: #207a35;
    }

    .netacad-alert--danger {
        background: #fdecec;
        color: #b91c1c;
    }

    .netacad-hero {
        min-height: 248px;
        color: #fff;
        background:
            radial-gradient(ellipse at 71% -46%, transparent 0 39%, rgba(0, 183, 255, .42) 39.2% 39.7%, transparent 40% 43%, rgba(0, 183, 255, .36) 43.2% 43.7%, transparent 44% 47%, rgba(0, 183, 255, .3) 47.2% 47.7%, transparent 48%),
            linear-gradient(117deg, #15315e 0%, #063f50 50%, #00704d 100%);
        overflow: hidden;
    }

    .netacad-hero__inner {
        max-width: 1600px;
        min-height: 248px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 60px;
        margin: 0 auto;
        padding: 36px 8%;
    }

    .netacad-identity {
        display: flex;
        align-items: center;
        gap: 54px;
        margin: 0;
    }

    .netacad-avatar {
        position: relative;
        width: 156px;
        height: 156px;
        flex: 0 0 156px;
        border: 8px solid rgba(255, 255, 255, .95);
        border-radius: 50%;
        background: #e7ebf0;
        box-shadow: inset 0 0 0 8px #f7f9fb;
    }

    .netacad-avatar img {
        width: 100%;
        height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }

    .netacad-avatar input {
        display: none;
    }

    .netacad-avatar__edit {
        position: absolute;
        right: -12px;
        bottom: 15px;
        width: 45px;
        height: 45px;
        display: grid;
        place-items: center;
        margin: 0;
        border: 7px solid #fff;
        border-radius: 50%;
        background: #61b84c;
        color: #fff;
        cursor: pointer;
    }

    .netacad-user span {
        display: block;
        margin-bottom: 8px;
        font-size: 24px;
        line-height: 1;
    }

    .netacad-user h1 {
        margin: 0 0 12px;
        color: #fff;
        font-size: 42px;
        font-weight: 300;
        line-height: 1.1;
    }

    .netacad-user p {
        margin: 0;
        color: rgba(255, 255, 255, .74);
        font-size: 16px;
    }

    .netacad-user b {
        width: 7px;
        height: 7px;
        display: inline-block;
        margin: 0 7px 2px;
        border-radius: 50%;
        background: rgba(255, 255, 255, .7);
    }

    .netacad-stats {
        display: flex;
        align-items: center;
        gap: 48px;
    }

    .netacad-stat {
        position: relative;
        display: grid;
        grid-template-columns: 44px auto;
        align-items: center;
        column-gap: 10px;
        min-width: 220px;
    }

    .netacad-stat + .netacad-stat {
        border-left: 1px solid rgba(255, 255, 255, .22);
        padding-left: 48px;
    }

    .netacad-stat i {
        grid-row: span 2;
        color: #b45cff;
        font-size: 35px;
    }

    .netacad-stat:first-child i {
        color: #f4b82f;
    }

    .netacad-stat strong {
        color: #6abb46;
        font-size: 36px;
        font-weight: 300;
        line-height: 1;
    }

    .netacad-stat span {
        color: #fff;
        font-size: 14px;
        font-weight: 700;
    }

    .netacad-body {
        max-width: 1574px;
        margin: 0 auto;
        padding: 60px 0 0;
    }

    .netacad-tabs {
        display: flex;
        align-items: center;
        gap: 0;
        overflow-x: auto;
        border-bottom: 1px solid #d9dee5;
    }

    .netacad-tab {
        position: relative;
        min-height: 54px;
        display: inline-flex;
        align-items: center;
        gap: 14px;
        padding: 0 34px;
        border: 0;
        border-right: 2px solid #e0e4e8;
        background: transparent;
        color: #273241;
        font-size: 20px;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
    }

    .netacad-tab i {
        color: #05aae8;
        font-size: 26px;
        font-weight: 400;
    }

    .netacad-tab:nth-child(1) i { color: #ff8b1a; }
    .netacad-tab:nth-child(2) i { color: #a764ff; }
    .netacad-tab:nth-child(3) i { color: #6fc047; }
    .netacad-tab:nth-child(5) i { color: #189df4; }

    .netacad-tab.is-active::after {
        content: "";
        position: absolute;
        right: 34px;
        bottom: 0;
        left: 34px;
        height: 3px;
        background: #66be4a;
    }

    .netacad-panel {
        padding-top: 56px;
    }

    .netacad-panel.is-hidden {
        display: none;
    }

    .netacad-subtabs {
        display: flex;
        align-items: center;
        gap: 0;
        border-bottom: 1px solid #d9dee5;
    }

    .netacad-subtabs button {
        position: relative;
        min-height: 50px;
        padding: 0 44px 0 0;
        margin-right: 44px;
        border: 0;
        border-right: 2px solid #e0e4e8;
        background: transparent;
        color: #2f3b4a;
        font-size: 17px;
        font-weight: 700;
        cursor: pointer;
    }

    .netacad-subtabs button.is-active::after {
        content: "";
        position: absolute;
        right: 40px;
        bottom: 0;
        left: 0;
        height: 4px;
        background: #66be4a;
    }

    .netacad-toolbar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 24px;
        margin: 25px 0 20px;
    }

    .netacad-search {
        position: relative;
        width: 267px;
        height: 44px;
        margin: 0;
        border: 2px solid #006dff;
        color: #3d4652;
        font-size: 17px;
        font-weight: 400;
    }

    .netacad-search input {
        width: 100%;
        height: 100%;
        border: 0;
        outline: 0;
        padding: 0 42px 0 22px;
        background: transparent;
        color: #3d4652;
        font-size: 17px;
    }

    .netacad-search input::placeholder {
        color: #3d4652;
        opacity: 1;
    }

    .netacad-search i {
        position: absolute;
        right: 13px;
        top: 13px;
        color: #00a8e8;
    }

    .netacad-filters {
        display: flex;
        align-items: center;
        gap: 12px;
    }

    .netacad-filters label {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        margin: 0;
        color: #000;
        font-size: 17px;
        font-weight: 400;
    }

    .netacad-filters select {
        min-width: 175px;
        height: 44px;
        border: 1px solid #d9dee5;
        padding: 0 34px 0 10px;
        background: #fff;
        font-size: 16px;
    }

    .netacad-card-grid {
        display: grid;
        grid-template-columns: repeat(4, minmax(0, 1fr));
        gap: 24px;
    }

    .netacad-achievement-card {
        min-height: 284px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 18px 24px 15px;
        border: 1px solid #d9dee5;
        border-radius: 9px;
        background: #fff;
        text-align: center;
    }

    .netacad-ribbon {
        min-width: 126px;
        margin-bottom: 16px;
        padding: 6px 16px;
        border-left: 6px solid #4f8a40;
        background: #c9e8c4;
        color: #102134;
        font-size: 16px;
        font-weight: 700;
    }

    .netacad-medal {
        width: 106px;
        height: 106px;
        display: grid;
        place-items: center;
        margin-bottom: 20px;
        border: 4px double #6bbf4a;
        border-radius: 50%;
        color: #6bbf4a;
        font-size: 44px;
    }

    .netacad-medal--badge {
        width: 106px;
        height: 106px;
        border: 0;
        border-radius: 8px;
        background: linear-gradient(160deg, #07b6e8, #1277cd 55%, #edf9ff 56%);
        color: #fff;
        font-size: 34px;
    }

    .netacad-achievement-card span {
        margin-top: auto;
        color: #3e4857;
        font-size: 14px;
        letter-spacing: 8px;
        text-transform: uppercase;
    }

    .netacad-achievement-card h2 {
        max-width: 100%;
        margin: 14px 0 0;
        color: #061426;
        font-size: 22px;
        font-weight: 800;
        line-height: 1.2;
    }

    .netacad-form {
        max-width: 920px;
        padding: 30px;
        border: 1px solid #d9dee5;
        border-radius: 8px;
    }

    .netacad-form h2 {
        margin: 0 0 22px;
        font-size: 22px;
        font-weight: 800;
    }

    .netacad-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0, 1fr));
        gap: 18px;
    }

    .netacad-form label {
        display: grid;
        gap: 8px;
        color: #3d4652;
        font-size: 14px;
        font-weight: 700;
    }

    .netacad-form input,
    .netacad-form select {
        height: 42px;
        border: 1px solid #cbd5e1;
        border-radius: 4px;
        padding: 0 12px;
    }

    .netacad-save {
        height: 42px;
        margin-top: 24px;
        border: 0;
        border-radius: 4px;
        background: #006dff;
        color: #fff;
        padding: 0 22px;
        font-weight: 700;
    }

    .netacad-empty {
        display: grid;
        place-items: center;
        gap: 12px;
        padding: 60px 20px;
        border: 1px dashed #cbd5e1;
        color: #64748b;
    }

    .netacad-empty i {
        color: #66be4a;
        font-size: 38px;
    }

    @media (max-width: 1200px) {
        .netacad-hero__inner {
            padding: 34px 32px;
        }

        .netacad-body {
            padding-right: 24px;
            padding-left: 24px;
        }

        .netacad-card-grid {
            grid-template-columns: repeat(2, minmax(0, 1fr));
        }

        .netacad-toolbar {
            align-items: stretch;
            flex-direction: column;
        }

        .netacad-filters {
            flex-wrap: wrap;
        }
    }

    @media (max-width: 767px) {
        .netacad-back-btn {
            top: 12px;
            left: 12px;
            min-height: 38px;
            padding: 0 13px;
        }

        .netacad-hero__inner,
        .netacad-identity,
        .netacad-stats {
            align-items: flex-start;
            flex-direction: column;
            gap: 24px;
        }

        .netacad-avatar {
            width: 126px;
            height: 126px;
            flex-basis: 126px;
        }

        .netacad-user h1 {
            font-size: 32px;
        }

        .netacad-stat + .netacad-stat {
            border-left: 0;
            padding-left: 0;
        }

        .netacad-tab {
            padding: 0 20px;
            font-size: 16px;
        }

        .netacad-card-grid,
        .netacad-form-grid {
            grid-template-columns: 1fr;
        }

        .netacad-filters,
        .netacad-filters label,
        .netacad-filters select,
        .netacad-search {
            width: 100%;
        }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs = document.querySelectorAll('[data-netacad-tab]');
        const panels = document.querySelectorAll('[data-netacad-panel]');

        tabs.forEach((tab) => {
            tab.addEventListener('click', function () {
                const target = tab.dataset.netacadTab;

                tabs.forEach((item) => item.classList.toggle('is-active', item === tab));
                panels.forEach((panel) => panel.classList.toggle('is-hidden', panel.dataset.netacadPanel !== target));
            });
        });

        const fileInput = document.getElementById('file-input');
        const preview = document.getElementById('netacadAvatarPreview');
        const avatarForm = document.getElementById('netacadProfileForm');

        if (fileInput && preview) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) {
                    return;
                }

                const reader = new FileReader();
                reader.onload = (event) => preview.setAttribute('src', event.target.result);
                reader.readAsDataURL(file);

                if (avatarForm) {
                    window.setTimeout(() => avatarForm.submit(), 120);
                }
            });
        }
    });
</script>
