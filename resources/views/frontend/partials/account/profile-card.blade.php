@php
    // --- Names ---
    $firstName  = $student?->first_name  ?: (strtok($user->name, ' ') ?: 'Student');
    $lastName   = $student?->last_name   ?: (trim(str_replace($firstName, '', $user->name)) ?: '');
    $firstNameKh = $student?->first_name_kh ?: '';
    $lastNameKh  = $student?->last_name_kh  ?: '';
    $displayName = trim("$firstName $lastName") ?: $user->name ?: 'Student';
    $displayNameKh = trim("$lastNameKh $firstNameKh");

    // --- Avatar ---
    $avatarUrl = $user->avatar
        ? (str_starts_with($user->avatar, 'http') ? $user->avatar : asset('storage/'.$user->avatar))
        : asset('backend/dist/img/avatar.png');

    // --- Student info ---
    $studentCode   = $student?->student_code  ?: '—';
    $gender        = $student?->gender        ?: 'Prefer not to say';
    $dob           = $student?->date_of_birth ? $student->date_of_birth->format('d/m/Y') : '—';
    $phone         = $student?->phone         ?: '—';
    $email         = $student?->email         ?: $user->email ?: '—';
    $address       = $student?->address       ?: '—';
    $status        = ucfirst($student?->status ?: 'active');

    // --- Academic info ---
    $deptName      = $student?->department?->department_name  ?: '—';
    $yearName      = $student?->academicYear?->year_name       ?: '—';
    $semesterName  = $student?->semester?->semester_name       ?: '—';

    // --- Role / labels ---
    $roleLabel   = $user->isStudent() ? 'Learner' : ($user->isTeacher() ? 'Instructor' : 'Administrator');
    $academyLabel = $student?->department?->department_name ?: 'Saint Paul Institute';

    // --- Stats ---
    $badgesCount     = $student ? $student->certificates()->count()                              : 0;
    $completedCount  = $student ? $student->enrollments()->where('status', 'completed')->count() : 0;
    $enrollCount     = $student ? $student->enrollments()->count()                               : 0;

    // --- Language ---
    $learningLocale = session('learning_locale', 'en');
@endphp

<div class="netacad-profile">
    {{-- Back button --}}
    <a href="{{ route('dashboard') }}" class="netacad-back-btn" aria-label="Back to learning">
        <i class="fas fa-arrow-left"></i>
        <span>Back</span>
    </a>

    {{-- Alerts --}}
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

    {{-- ── Hero banner ── --}}
    <section class="netacad-hero">
        <div class="netacad-hero__inner">
            <form method="POST"
                  action="{{ route('frontend.account.profile.update') }}"
                  enctype="multipart/form-data"
                  class="netacad-identity"
                  id="netacadProfileForm">
                @csrf
                <input type="hidden" name="firstName" value="{{ old('firstName', $firstName) }}">
                <input type="hidden" name="lastName"  value="{{ old('lastName',  $lastName) }}">
                <input type="hidden" name="gender"    value="{{ old('gender',    $gender) }}">

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
                    @if($displayNameKh)
                        <p class="netacad-user-kh">{{ $displayNameKh }}</p>
                    @endif
                    <p>{{ $roleLabel }} <b></b> {{ $academyLabel }}</p>
                    @if($studentCode !== '—')
                        <span class="netacad-badge-code">ID: {{ $studentCode }}</span>
                    @endif
                </div>
            </form>

            <div class="netacad-stats" aria-label="Learning summary">
                <div class="netacad-stat">
                    <i class="fas fa-award"></i>
                    <strong>{{ $badgesCount ?: 0 }}</strong>
                    <span>Badges Earned</span>
                </div>
                <div class="netacad-stat">
                    <i class="fas fa-book-open"></i>
                    <strong>{{ $enrollCount }}</strong>
                    <span>Enrolled Courses</span>
                </div>
                <div class="netacad-stat">
                    <i class="fas fa-graduation-cap"></i>
                    <strong>{{ $completedCount }}</strong>
                    <span>Completed</span>
                </div>
            </div>
        </div>
    </section>

    {{-- ── Tabs ── --}}
    <section class="netacad-body">
        <nav class="netacad-tabs" aria-label="Profile tabs">
            <button type="button" class="netacad-tab is-active" data-netacad-tab="profile">
                <i class="far fa-user"></i><span>Profile</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="badges">
                <i class="fas fa-award"></i><span>Badges &amp; Certificates</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="history">
                <i class="fas fa-history"></i><span>Learning History</span>
            </button>
            <button type="button" class="netacad-tab" data-netacad-tab="transcript">
                <i class="far fa-file-alt"></i><span>Transcript</span>
            </button>
        </nav>

        {{-- ── Profile Tab ── --}}
        <div class="netacad-panel" data-netacad-panel="profile">
            <div class="netacad-two-col">

                {{-- Personal Info Card --}}
                <div class="netacad-info-card">
                    <div class="netacad-info-card__head">
                        <i class="fas fa-user-circle"></i>
                        <h2>Personal Information</h2>
                    </div>
                    <dl class="netacad-info-list">
                        <div>
                            <dt>Full Name (EN)</dt>
                            <dd>{{ $displayName ?: '—' }}</dd>
                        </div>
                        @if($displayNameKh)
                        <div>
                            <dt>Full Name (KH)</dt>
                            <dd>{{ $displayNameKh }}</dd>
                        </div>
                        @endif
                        <div>
                            <dt>Student Code</dt>
                            <dd>{{ $studentCode }}</dd>
                        </div>
                        <div>
                            <dt>Gender</dt>
                            <dd>{{ $gender }}</dd>
                        </div>
                        <div>
                            <dt>Date of Birth</dt>
                            <dd>{{ $dob }}</dd>
                        </div>
                        <div>
                            <dt>Phone</dt>
                            <dd>{{ $phone }}</dd>
                        </div>
                        <div>
                            <dt>Email</dt>
                            <dd>{{ $email }}</dd>
                        </div>
                        <div>
                            <dt>Address</dt>
                            <dd>{{ $address }}</dd>
                        </div>
                        <div>
                            <dt>Status</dt>
                            <dd><span class="netacad-status netacad-status--{{ strtolower($student?->status ?? 'active') }}">{{ $status }}</span></dd>
                        </div>
                    </dl>
                </div>

                {{-- Academic Info + Edit Form --}}
                <div class="netacad-info-col-right">
                    {{-- Academic Card --}}
                    <div class="netacad-info-card">
                        <div class="netacad-info-card__head">
                            <i class="fas fa-university"></i>
                            <h2>Academic Information</h2>
                        </div>
                        <dl class="netacad-info-list">
                            <div>
                                <dt>Department</dt>
                                <dd>{{ $deptName }}</dd>
                            </div>
                            <div>
                                <dt>Academic Year</dt>
                                <dd>{{ $yearName }}</dd>
                            </div>
                            <div>
                                <dt>Semester</dt>
                                <dd>{{ $semesterName }}</dd>
                            </div>
                            <div>
                                <dt>Role</dt>
                                <dd>{{ $roleLabel }}</dd>
                            </div>
                        </dl>
                    </div>

                    {{-- Edit Form --}}
                    <form method="POST"
                          action="{{ route('frontend.account.profile.update') }}"
                          enctype="multipart/form-data"
                          class="netacad-form">
                        @csrf
                        <h2>Edit Basic Info</h2>
                        <div class="netacad-form-grid">
                            <label>First Name
                                <input name="firstName" type="text" required value="{{ old('firstName', $firstName) }}">
                            </label>
                            <label>Last Name
                                <input name="lastName" type="text" required value="{{ old('lastName', $lastName) }}">
                            </label>
                            <label>Default Language
                                <select name="defaultLanguage">
                                    <option value="en" {{ $learningLocale === 'en' ? 'selected' : '' }}>English</option>
                                    <option value="km" {{ $learningLocale === 'km' ? 'selected' : '' }}>ខ្មែរ</option>
                                </select>
                            </label>
                            <label>Email
                                <input type="email" value="{{ $user->email }}" disabled>
                            </label>
                            <label>Gender
                                <select name="gender">
                                    @foreach(['Prefer not to say', 'Male', 'Female', 'Non-binary'] as $g)
                                        <option value="{{ $g }}" {{ ($student?->gender === $g || $gender === $g) ? 'selected' : '' }}>{{ $g }}</option>
                                    @endforeach
                                </select>
                            </label>
                        </div>
                        <button type="submit" class="netacad-save">Save Changes</button>
                    </form>
                </div>

            </div>
        </div>

        {{-- ── Badges Tab ── --}}
        <div class="netacad-panel is-hidden" data-netacad-panel="badges">
            @if($badgesCount > 0)
                <div class="netacad-card-grid">
                    @foreach($student->certificates as $cert)
                        <article class="netacad-achievement-card">
                            <div class="netacad-ribbon">Certificate</div>
                            <div class="netacad-medal">
                                <i class="fas fa-certificate"></i>
                            </div>
                            <span>Achievement</span>
                            <h2>{{ $cert->course?->course_name ?? 'Course Certificate' }}</h2>
                            @if($cert->issued_at)
                                <p class="netacad-cert-date">{{ $cert->issued_at->format('d/m/Y') }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            @else
                <div class="netacad-empty">
                    <i class="fas fa-award"></i>
                    <p>No badges or certificates earned yet. Complete a course to earn your first certificate!</p>
                </div>
            @endif
        </div>

        {{-- ── Learning History Tab ── --}}
        <div class="netacad-panel is-hidden" data-netacad-panel="history">
            @if($enrollments->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Course Code</th>
                                <th>Course Name</th>
                                <th>Enrollment Date</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enroll)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $enroll->course?->course_code ?? '—' }}</td>
                                    <td>{{ $enroll->course?->course_name ?? '—' }}</td>
                                    <td>{{ $enroll->enrollment_date?->format('d/m/Y') ?? '—' }}</td>
                                    <td>
                                        <span class="netacad-status netacad-status--{{ strtolower($enroll->status) }}">
                                            {{ ucfirst($enroll->status) }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="netacad-empty">
                    <i class="fas fa-book-open"></i>
                    <p>No learning history recorded. Enroll in a course to get started!</p>
                </div>
            @endif
        </div>

        {{-- ── Transcript Tab ── --}}
        <div class="netacad-panel is-hidden" data-netacad-panel="transcript">
            @if($grades->isNotEmpty())
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Assessment</th>
                                <th>Category</th>
                                <th>Graded At</th>
                                <th>Score</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($grades as $grade)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $grade->exam?->title ?? $grade->quiz?->title ?? $grade->assignment?->title ?? '—' }}</td>
                                    <td>{{ $grade->exam ? 'Exam' : ($grade->quiz ? 'Quiz' : 'Assignment') }}</td>
                                    <td>{{ $grade->graded_at?->format('d/m/Y H:i') ?? '—' }}</td>
                                    <td>
                                        <strong class="{{ (float)$grade->score >= 50 ? 'text-success' : 'text-danger' }}">
                                            {{ number_format((float)$grade->score, 1) }}%
                                        </strong>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="netacad-empty">
                    <i class="far fa-file-alt"></i>
                    <p>No graded items found yet.</p>
                </div>
            @endif
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

    /* Back button */
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
        border: 1px solid rgba(255,255,255,.28);
        border-radius: 999px;
        background: rgba(7,21,47,.72);
        color: #fff;
        font-size: 14px;
        font-weight: 800;
        text-decoration: none;
        box-shadow: 0 12px 28px rgba(0,0,0,.18);
        backdrop-filter: blur(10px);
        transition: transform .18s ease, background .18s ease, box-shadow .18s ease;
    }
    .netacad-back-btn:hover {
        background: rgba(7,21,47,.92);
        color: #fff;
        text-decoration: none;
        transform: translateY(-1px);
        box-shadow: 0 16px 34px rgba(0,0,0,.22);
    }
    .netacad-back-btn i { font-size: 13px; }

    /* Alerts */
    .netacad-alert {
        max-width: 1574px;
        margin: 18px auto;
        padding: 12px 18px;
        border-radius: 4px;
        font-weight: 700;
    }
    .netacad-alert--success { background: #eaf8ee; color: #207a35; }
    .netacad-alert--danger  { background: #fdecec; color: #b91c1c; }

    /* Hero */
    .netacad-hero {
        min-height: 248px;
        color: #fff;
        background:
            radial-gradient(ellipse at 71% -46%, transparent 0 39%, rgba(0,183,255,.42) 39.2% 39.7%, transparent 40% 43%, rgba(0,183,255,.36) 43.2% 43.7%, transparent 44% 47%, rgba(0,183,255,.3) 47.2% 47.7%, transparent 48%),
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

    /* Avatar */
    .netacad-avatar {
        position: relative;
        width: 156px;
        height: 156px;
        flex: 0 0 156px;
        border: 8px solid rgba(255,255,255,.95);
        border-radius: 50%;
        background: #e7ebf0;
        box-shadow: inset 0 0 0 8px #f7f9fb;
    }
    .netacad-avatar img {
        width: 100%; height: 100%;
        border-radius: 50%;
        object-fit: cover;
    }
    .netacad-avatar input { display: none; }
    .netacad-avatar__edit {
        position: absolute;
        right: -12px; bottom: 15px;
        width: 45px; height: 45px;
        display: grid; place-items: center;
        margin: 0;
        border: 7px solid #fff;
        border-radius: 50%;
        background: #61b84c;
        color: #fff;
        cursor: pointer;
    }

    /* User block */
    .netacad-user span {
        display: block;
        margin-bottom: 8px;
        font-size: 24px;
        line-height: 1;
    }
    .netacad-user h1 {
        margin: 0 0 8px;
        color: #fff;
        font-size: 42px;
        font-weight: 300;
        line-height: 1.1;
    }
    .netacad-user-kh {
        margin: 0 0 6px;
        color: rgba(255,255,255,.85);
        font-size: 18px;
    }
    .netacad-user p {
        margin: 4px 0 0;
        color: rgba(255,255,255,.74);
        font-size: 16px;
    }
    .netacad-user b {
        width: 7px; height: 7px;
        display: inline-block;
        margin: 0 7px 2px;
        border-radius: 50%;
        background: rgba(255,255,255,.7);
    }
    .netacad-badge-code {
        display: inline-block;
        margin-top: 8px;
        padding: 3px 12px;
        border-radius: 999px;
        background: rgba(255,255,255,.18);
        color: #fff;
        font-size: 13px;
        font-weight: 700;
        letter-spacing: 1px;
        border: 1px solid rgba(255,255,255,.3);
    }

    /* Stats */
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
        min-width: 180px;
    }
    .netacad-stat + .netacad-stat {
        border-left: 1px solid rgba(255,255,255,.22);
        padding-left: 48px;
    }
    .netacad-stat i { grid-row: span 2; color: #b45cff; font-size: 35px; }
    .netacad-stat:first-child i  { color: #f4b82f; }
    .netacad-stat:nth-child(2) i { color: #05aae8; }
    .netacad-stat:nth-child(3) i { color: #6abb46; }
    .netacad-stat strong { color: #6abb46; font-size: 36px; font-weight: 300; line-height: 1; }
    .netacad-stat span   { color: #fff; font-size: 13px; font-weight: 700; }

    /* Body */
    .netacad-body {
        max-width: 1574px;
        margin: 0 auto;
        padding: 0 24px 60px;
    }

    /* Tabs */
    .netacad-tabs {
        display: flex;
        align-items: center;
        overflow-x: auto;
        border-bottom: 1px solid #d9dee5;
        margin-bottom: 0;
    }
    .netacad-tab {
        position: relative;
        min-height: 54px;
        display: inline-flex;
        align-items: center;
        gap: 14px;
        padding: 0 32px;
        border: 0;
        border-right: 2px solid #e0e4e8;
        background: transparent;
        color: #273241;
        font-size: 18px;
        font-weight: 700;
        white-space: nowrap;
        cursor: pointer;
        transition: color .15s;
    }
    .netacad-tab i { color: #05aae8; font-size: 22px; font-weight: 400; }
    .netacad-tab:nth-child(1) i { color: #ff8b1a; }
    .netacad-tab:nth-child(2) i { color: #a764ff; }
    .netacad-tab:nth-child(3) i { color: #189df4; }
    .netacad-tab:nth-child(4) i { color: #16a34a; }
    .netacad-tab.is-active::after {
        content: "";
        position: absolute;
        right: 32px; bottom: 0; left: 32px;
        height: 3px;
        background: #66be4a;
    }

    /* Panels */
    .netacad-panel { padding-top: 40px; }
    .netacad-panel.is-hidden { display: none; }

    /* Two-column profile layout */
    .netacad-two-col {
        display: grid;
        grid-template-columns: minmax(0,1fr) minmax(0,1.2fr);
        gap: 28px;
        align-items: start;
    }
    .netacad-info-col-right {
        display: grid;
        gap: 24px;
    }

    /* Info cards */
    .netacad-info-card {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        overflow: hidden;
    }
    .netacad-info-card__head {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 16px 22px;
        background: linear-gradient(90deg, #15315e, #063f50);
        color: #fff;
    }
    .netacad-info-card__head i { font-size: 18px; }
    .netacad-info-card__head h2 {
        margin: 0;
        font-size: 16px;
        font-weight: 700;
    }
    .netacad-info-list {
        margin: 0;
        padding: 0 22px;
        list-style: none;
    }
    .netacad-info-list div {
        display: grid;
        grid-template-columns: 160px 1fr;
        gap: 8px;
        padding: 10px 0;
        border-bottom: 1px solid #f1f5f9;
        align-items: baseline;
    }
    .netacad-info-list div:last-child { border-bottom: 0; }
    .netacad-info-list dt {
        color: #64748b;
        font-size: 13px;
        font-weight: 600;
        text-transform: uppercase;
        letter-spacing: .4px;
    }
    .netacad-info-list dd {
        margin: 0;
        color: #1e293b;
        font-size: 15px;
        font-weight: 500;
        word-break: break-word;
    }

    /* Status badge */
    .netacad-status {
        display: inline-block;
        padding: 2px 10px;
        border-radius: 999px;
        font-size: 12px;
        font-weight: 700;
        text-transform: capitalize;
    }
    .netacad-status--active,
    .netacad-status--completed   { background: #dcfce7; color: #16a34a; }
    .netacad-status--inactive,
    .netacad-status--dropped     { background: #fee2e2; color: #dc2626; }
    .netacad-status--enrolled    { background: #dbeafe; color: #2563eb; }
    .netacad-status--pending     { background: #fef9c3; color: #854d0e; }

    /* Edit form */
    .netacad-form {
        padding: 24px;
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        background: #f8fafc;
    }
    .netacad-form h2 { margin: 0 0 18px; font-size: 17px; font-weight: 800; color: #1e293b; }
    .netacad-form-grid {
        display: grid;
        grid-template-columns: repeat(2, minmax(0,1fr));
        gap: 14px;
    }
    .netacad-form label { display: grid; gap: 6px; color: #374151; font-size: 13px; font-weight: 700; margin: 0; }
    .netacad-form input,
    .netacad-form select {
        height: 40px;
        border: 1px solid #cbd5e1;
        border-radius: 6px;
        padding: 0 12px;
        background: #fff;
        font-size: 14px;
        transition: border-color .15s;
    }
    .netacad-form input:focus,
    .netacad-form select:focus { outline: 0; border-color: #3b82f6; box-shadow: 0 0 0 3px rgba(59,130,246,.15); }
    .netacad-save {
        height: 42px;
        margin-top: 18px;
        border: 0;
        border-radius: 6px;
        background: #006dff;
        color: #fff;
        padding: 0 28px;
        font-size: 15px;
        font-weight: 700;
        cursor: pointer;
        transition: background .15s;
    }
    .netacad-save:hover { background: #005de8; }

    /* Certificate cards */
    .netacad-card-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(220px, 1fr));
        gap: 22px;
    }
    .netacad-achievement-card {
        min-height: 260px;
        display: flex;
        flex-direction: column;
        align-items: center;
        padding: 18px 22px 14px;
        border: 1px solid #d9dee5;
        border-radius: 10px;
        background: #fff;
        text-align: center;
    }
    .netacad-ribbon {
        min-width: 110px; margin-bottom: 14px;
        padding: 5px 14px;
        border-left: 5px solid #4f8a40;
        background: #c9e8c4;
        color: #102134;
        font-size: 14px; font-weight: 700;
    }
    .netacad-medal {
        width: 100px; height: 100px;
        display: grid; place-items: center;
        margin-bottom: 16px;
        border: 4px double #6bbf4a;
        border-radius: 50%;
        color: #6bbf4a;
        font-size: 40px;
    }
    .netacad-achievement-card span { margin-top: auto; color: #3e4857; font-size: 13px; letter-spacing: 6px; text-transform: uppercase; }
    .netacad-achievement-card h2   { max-width: 100%; margin: 10px 0 0; color: #061426; font-size: 18px; font-weight: 800; line-height: 1.2; }
    .netacad-cert-date             { margin: 6px 0 0; color: #64748b; font-size: 12px; }

    /* Empty state */
    .netacad-empty {
        display: grid;
        place-items: center;
        gap: 14px;
        padding: 60px 20px;
        border: 1px dashed #cbd5e1;
        border-radius: 10px;
        color: #64748b;
        text-align: center;
    }
    .netacad-empty i { color: #66be4a; font-size: 40px; }
    .netacad-empty p { margin: 0; font-size: 15px; }

    /* Table overrides */
    .netacad-panel .table th { background: #f1f5f9; font-size: 13px; font-weight: 700; }
    .netacad-panel .table td { font-size: 14px; vertical-align: middle; }

    /* Responsive */
    @media (max-width: 1200px) {
        .netacad-hero__inner { padding: 34px 32px; }
        .netacad-two-col { grid-template-columns: 1fr; }
    }
    @media (max-width: 900px) {
        .netacad-stats { flex-direction: column; gap: 20px; align-items: flex-start; }
        .netacad-stat + .netacad-stat { border-left: 0; padding-left: 0; }
    }
    @media (max-width: 767px) {
        .netacad-back-btn { top: 12px; left: 12px; min-height: 38px; padding: 0 13px; }
        .netacad-hero__inner,
        .netacad-identity { flex-direction: column; align-items: flex-start; gap: 22px; }
        .netacad-avatar { width: 110px; height: 110px; flex-basis: 110px; }
        .netacad-user h1 { font-size: 28px; }
        .netacad-tab { padding: 0 18px; font-size: 14px; }
        .netacad-form-grid { grid-template-columns: 1fr; }
        .netacad-info-list div { grid-template-columns: 130px 1fr; }
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const tabs   = document.querySelectorAll('[data-netacad-tab]');
        const panels = document.querySelectorAll('[data-netacad-panel]');

        tabs.forEach(function (tab) {
            tab.addEventListener('click', function () {
                const target = tab.dataset.netacadTab;
                tabs.forEach(function (t) { t.classList.toggle('is-active', t === tab); });
                panels.forEach(function (p) { p.classList.toggle('is-hidden', p.dataset.netacadPanel !== target); });
            });
        });

        // Avatar instant preview + auto-submit
        const fileInput = document.getElementById('file-input');
        const preview   = document.getElementById('netacadAvatarPreview');
        const form      = document.getElementById('netacadProfileForm');

        if (fileInput && preview) {
            fileInput.addEventListener('change', function () {
                const file = this.files[0];
                if (!file) return;
                const reader = new FileReader();
                reader.onload = function (e) { preview.src = e.target.result; };
                reader.readAsDataURL(file);
                if (form) window.setTimeout(function () { form.submit(); }, 120);
            });
        }
    });
</script>
