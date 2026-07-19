<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Dashboard as KhmerDashboard;
use App\Filament\Admin\Pages\Reports\ActivityReport;
use App\Filament\Admin\Pages\Reports\AttendanceReport;
use App\Filament\Admin\Pages\Reports\ExamReport;
use App\Filament\Admin\Pages\Reports\FinanceReport;
use App\Filament\Admin\Pages\Reports\StudentReport;
use App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
use App\Filament\Admin\Resources\Attendances\AttendanceResource;
use App\Filament\Admin\Resources\Enrollments\EnrollmentResource;
use App\Filament\Admin\Resources\Students\StudentResource;
use App\Filament\Admin\Resources\Users\UserResource;
use App\Filament\Admin\Resources\Faculties\FacultyResource;
use App\Filament\Admin\Resources\Departments\DepartmentResource;
use App\Filament\Admin\Resources\AcademicYears\AcademicYearResource;
use App\Filament\Admin\Resources\Semesters\SemesterResource;
use App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource;
use App\Filament\Admin\Resources\ActivityLogResource;
use App\Filament\Admin\Resources\CmsPages\CmsPageResource;
use App\Filament\Admin\Resources\FrontendSettings\FrontendSettingResource;
use App\Filament\Admin\Resources\Languages\LanguageResource;
use App\Filament\Admin\Resources\NavigationGroups\NavigationGroupResource;
use App\Filament\Admin\Resources\NavigationItems\NavigationItemResource;
use App\Filament\Admin\Resources\Translations\TranslationResource;
use App\Filament\Admin\Resources\AssessmentGrades\AssessmentGradeResource;
use App\Filament\Admin\Resources\AssessmentQuestions\AssessmentQuestionResource;
use App\Filament\Admin\Resources\AssessmentResults\AssessmentResultResource;
use App\Filament\Admin\Resources\Certificates\CertificateResource;
use App\Filament\Admin\Resources\ContentAssignments\ContentAssignmentResource;
use App\Filament\Admin\Resources\ContentChapters\ContentChapterResource;
use App\Filament\Admin\Resources\ContentDocuments\ContentDocumentResource;
use App\Filament\Admin\Resources\ContentLessons\ContentLessonResource;
use App\Filament\Admin\Resources\ContentResources\ContentResourceResource;
use App\Filament\Admin\Resources\ContentVideos\ContentVideoResource;
use App\Filament\Admin\Resources\CourseModules\CourseModuleResource;
use App\Filament\Admin\Resources\Courses\CourseResource;
use App\Filament\Admin\Resources\ClassRooms\ClassRoomResource;
use App\Filament\Admin\Resources\CourseAssignments\CourseAssignmentResource;
use App\Filament\Admin\Resources\CourseCategories\CourseCategoryResource;
use App\Filament\Admin\Resources\ExamCandidates\ExamCandidateResource;
use App\Filament\Admin\Resources\Exams\ExamResource;
use App\Filament\Admin\Resources\ExamSubmissions\ExamSubmissionResource;
use App\Filament\Admin\Resources\QuestionBanks\QuestionBankResource;
use App\Filament\Admin\Resources\QuestionOptions\QuestionOptionResource;
use App\Filament\Admin\Resources\Quizzes\QuizResource;
use App\Filament\Admin\Resources\Permissions\PermissionResource;
use App\Filament\Admin\Resources\Roles\RoleResource;
use App\Filament\Admin\Resources\StudentProgresses\StudentProgressResource;
use App\Filament\Admin\Resources\Teachers\TeacherResource;
use App\Filament\Admin\Resources\Schedules\ScheduleResource;
use App\Http\Middleware\EnsureStudentFilamentAccess;
use BackedEnum;
use Closure;
use Filament\FontProviders\LocalFontProvider;
use Filament\Support\Assets\Css;
use Filament\Support\Assets\Js;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Support\Enums\Width;
use Filament\Support\Icons\Heroicon;
use Filament\View\PanelsRenderHook;
use Filament\Widgets\AccountWidget;
use Filament\Widgets\FilamentInfoWidget;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    private const GROUP_USERS = 'groups.users';

    private const GROUP_ACADEMIC = 'groups.academic';

    private const GROUP_STUDENTS = 'groups.students';

    private const GROUP_TEACHERS = 'groups.teachers';

    private const GROUP_CONTENT = 'groups.content';

    private const GROUP_ASSESSMENT = 'groups.assessment';

    private const GROUP_COMMUNICATION = 'groups.communication';

    private const GROUP_FINANCE = 'groups.finance';

    private const GROUP_REPORTS = 'groups.reports';

    private const GROUP_SETTINGS = 'groups.settings';

    private const GROUP_API = 'groups.api';

    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login(\App\Filament\Admin\Pages\Auth\Login::class)
            ->profile()
            ->brandName('ប្រព័ន្ធគ្រប់គ្រងការសិក្សា')
            ->brandLogo(asset('backend/dist/img/logo.png'))
            ->brandLogoHeight('3.8rem')
            ->favicon(asset('backend/dist/img/logo.png'))
            ->font('Battambang', url: asset('fonts/battambang.css'), provider: LocalFontProvider::class)
            ->databaseNotifications(fn (): bool => Schema::hasTable('notifications'))
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
            ->assets([
                Js::make('jquery-cdn', 'https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js'),
                Css::make('select2-cdn-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css'),
                Css::make('select2-bootstrap4-cdn-css', 'https://cdnjs.cloudflare.com/ajax/libs/select2-bootstrap4-theme/1.5.2/select2-bootstrap4.min.css'),
                Js::make('select2-cdn-js', 'https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.full.min.js'),
            ])
            ->sidebarWidth('20rem')
            ->collapsedSidebarWidth('4.75rem')
            ->sidebarCollapsibleOnDesktop()
            ->collapsibleNavigationGroups()

            // =========================
            // Resources / Pages
            // =========================
            ->discoverResources(in: app_path('Filament/Admin/Resources'), for: 'App\Filament\Admin\Resources')
            ->discoverPages(in: app_path('Filament/Admin/Pages'), for: 'App\Filament\Admin\Pages')
            ->pages([
                KhmerDashboard::class,
            ])

            // =========================
            // Navigation
            // =========================
            ->navigationGroups($this->lmsNavigationGroups())
            ->navigationItems($this->lmsNavigationItems())

            // =========================
            // Widgets
            // =========================
            ->discoverWidgets(in: app_path('Filament/Admin/Widgets'), for: 'App\Filament\Admin\Widgets')
            ->widgets([
                AccountWidget::class,
                FilamentInfoWidget::class,
            ])

            ->userMenuItems([
                'profile' => MenuItem::make()
                    ->label('មើលប្រវត្តិរូប')
                    ->icon('heroicon-o-user-circle')
                    ->url(fn (): string => url('/admin/my-profile')),
                'notifications' => MenuItem::make()
                    ->label('ការជូនដំណឹង')
                    ->icon('heroicon-o-bell')
                    ->url(fn (): string => url('/admin/notifications')),
                'home' => MenuItem::make()
                    ->label('ចូលគេហទំព័រ')
                    ->icon('heroicon-o-globe-alt')
                    ->url('/learning'),
            ])

            ->renderHook(
                PanelsRenderHook::GLOBAL_SEARCH_AFTER,
                fn (): HtmlString => new HtmlString(view('filament.admin.partials.language-switcher')->render()),
            )

            ->renderHook(
                PanelsRenderHook::SCRIPTS_AFTER,
                function (): HtmlString {
                    $user = auth()->user();
                    $locale = app()->getLocale();

                    $welcomeText = match($locale) {
                        'km' => 'សូមស្វាគមន៍',
                        'fr' => 'Bienvenue',
                        'zh' => '欢迎',
                        default => 'Welcome',
                    };

                    $nameText = $user ? e($user->name) : 'Guest';

                    $roleText = 'Administrator';
                    if ($user) {
                        if ($user->hasRole('student')) {
                            $roleText = match($locale) {
                                'km' => 'សិស្ស',
                                'fr' => 'Étudiant',
                                'zh' => '学生',
                                default => 'Student',
                            };
                        } elseif ($user->hasRole('teacher')) {
                            $roleText = match($locale) {
                                'km' => 'គ្រូបង្រៀន',
                                'fr' => 'Enseignant',
                                'zh' => '教师',
                                default => 'Teacher',
                            };
                        } else {
                            $roleText = match($locale) {
                                'km' => 'អ្នកគ្រប់គ្រង',
                                'fr' => 'Administrateur',
                                'zh' => '管理员',
                                default => 'Administrator',
                            };
                        }
                    } else {
                        $nameText = match($locale) {
                            'km' => 'ភ្ញៀវ',
                            'fr' => 'Invité',
                            'zh' => '访客',
                            default => 'Guest',
                        };
                    }

                    $searchPlaceholder = match($locale) {
                        'km' => 'ស្វែងរកវគ្គសិក្សា មេរៀន ការប្រឡងខ្លី...',
                        'fr' => 'Rechercher des cours, leçons, quiz...',
                        'zh' => '搜索课程、课时、测验...',
                        default => 'Search courses, lessons, quizzes...',
                    };

                    $lessonEditorAssets = Vite::withEntryPoints(['resources/js/app.js'])->toHtml();

                    return new HtmlString($lessonEditorAssets . <<<HTML
                    <script>
                        (() => {
                            let hoverOpenedSidebar = false

                            const desktopSidebarCanHover = () => false

                            const sidebarStore = () => window.Alpine?.store?.('sidebar')

                            const syncSidebarToggleState = () => {
                                const store = sidebarStore()

                                if (! store) {
                                    return
                                }

                                document.body.classList.toggle('lc-sidebar-is-open', store.isOpen)
                                document.body.classList.toggle('lc-sidebar-is-collapsed', ! store.isOpen)
                            }

                            const bindSidebarHover = () => {
                                const sidebar = document.querySelector('.fi-main-sidebar')

                                if (! sidebar || sidebar.dataset.hoverExpandBound === 'true') {
                                    return
                                }

                                sidebar.dataset.hoverExpandBound = 'true'

                                sidebar.addEventListener('mouseenter', () => {
                                    const store = sidebarStore()

                                    if (! desktopSidebarCanHover() || ! store || store.isOpen) {
                                        return
                                    }

                                    hoverOpenedSidebar = true
                                    document.body.classList.add('fi-sidebar-hover-open')
                                    store.open()
                                    syncSidebarToggleState()
                                })

                                sidebar.addEventListener('mouseleave', () => {
                                    const store = sidebarStore()

                                    if (! hoverOpenedSidebar || ! store) {
                                        return
                                    }

                                    hoverOpenedSidebar = false
                                    document.body.classList.remove('fi-sidebar-hover-open')
                                    store.close()
                                    syncSidebarToggleState()
                                })
                            }

                            const bindSidebarToggleClicks = () => {
                                document
                                    .querySelectorAll('.fi-topbar-open-collapse-sidebar-btn, .fi-topbar-close-collapse-sidebar-btn, .fi-sidebar-open-collapse-sidebar-btn, .fi-sidebar-close-collapse-sidebar-btn')
                                    .forEach((button) => {
                                        if (button.dataset.sidebarStateBound === 'true') {
                                            return
                                        }

                                        button.dataset.sidebarStateBound = 'true'
                                        button.addEventListener('click', () => window.setTimeout(syncSidebarToggleState, 0))
                                    })
                            }

                            const customizeTopbar = () => {
                                const trigger = document.querySelector('.fi-user-menu-trigger');
                                if (trigger && !trigger.classList.contains('lc-customized')) {
                                    trigger.classList.add('lc-customized');

                                    const infoDiv = document.createElement('div');
                                    infoDiv.className = 'lc-user-info-wrapper';
                                    infoDiv.innerHTML = `
                                        <span class="lc-user-name">{$welcomeText}, {$nameText}</span>
                                        <span class="lc-user-role">{$roleText}</span>
                                    `;
                                    trigger.appendChild(infoDiv);

                                    const chevron = document.createElement('span');
                                    chevron.className = 'lc-user-chevron';
                                    chevron.innerHTML = `
                                        <svg fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24" style="width: 10px; height: 10px;">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"/>
                                        </svg>
                                    `;
                                    trigger.appendChild(chevron);
                                }

                                const searchInput = document.querySelector('.fi-global-search-field input');
                                if (searchInput) {
                                    searchInput.placeholder = '{$searchPlaceholder}';
                                }
                            }

                            const bindSidebarUi = () => {
                                bindSidebarHover()
                                bindSidebarToggleClicks()
                                syncSidebarToggleState()
                                customizeTopbar()
                            }

                            document.addEventListener('DOMContentLoaded', () => {
                                bindSidebarUi();
                                const topbarEnd = document.querySelector('.fi-topbar-end');
                                if (topbarEnd) {
                                    const observer = new MutationObserver(customizeTopbar);
                                    observer.observe(topbarEnd, { childList: true, subtree: true });
                                }
                            })
                            document.addEventListener('livewire:navigated', bindSidebarUi)
                            document.addEventListener('alpine:initialized', bindSidebarUi)
                            bindSidebarUi()
                        })()
                    </script>
HTML
                    );
                }
            )

            ->renderHook(
                PanelsRenderHook::FOOTER,
                function (): HtmlString {
                    $year = date('Y');
                    return new HtmlString(<<<HTML
                    <div style="
                        text-align: center;
                        padding: 14px 24px;
                        font-size: 12px;
                        color: #94a3b8;
                        border-top: 1px solid #e2e8f0;
                        background: #ffffff;
                        font-family: 'Battambang', 'Noto Sans Khmer', ui-sans-serif, sans-serif;
                        letter-spacing: 0.01em;
                        position: sticky;
                        bottom: 0;
                        z-index: 40;
                        box-shadow: 0 -1px 8px rgba(0,0,0,0.06);
                    ">
                        &copy; {$year} <strong style="color:#64748b;">Learning Management System (LMS). All Rights Reserved.</strong>
                    </div>
HTML);
                }
            )

            // =========================
            // Middleware
            // =========================
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
                \App\Http\Middleware\SetLocale::class,
            ])
            ->maxContentWidth(Width::Full)
            ->authMiddleware([
                Authenticate::class,
                EnsureStudentFilamentAccess::class,
            ]);
    }

    // =========================
    // NAV GROUPS
    // =========================
    private function lmsNavigationGroups(): array
    {
        return [
            NavigationGroup::make($this->adminLabel(self::GROUP_USERS)),
            NavigationGroup::make($this->adminLabel(self::GROUP_ACADEMIC)),
            NavigationGroup::make($this->adminLabel(self::GROUP_STUDENTS)),
            NavigationGroup::make($this->adminLabel(self::GROUP_TEACHERS)),
            NavigationGroup::make($this->adminLabel(self::GROUP_CONTENT)),
            NavigationGroup::make($this->adminLabel(self::GROUP_ASSESSMENT)),
            NavigationGroup::make($this->adminLabel(self::GROUP_REPORTS))->collapsed(),
            NavigationGroup::make($this->adminLabel(self::GROUP_SETTINGS)),
        ];
    }

    // =========================
    // NAV ITEMS
    // =========================
    private function lmsNavigationItems(): array
    {
        return [
            // ==========================================
            // Student-Only Navigation Items
            // ==========================================
            NavigationItem::make($this->adminLabel('nav.my_courses'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/courses.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->isActiveWhen(fn (): bool => request()->routeIs('filament.admin.pages.dashboard') && !request()->has('tab'))
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(10),

            NavigationItem::make($this->adminLabel('nav.available_courses'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/course.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(20),

            NavigationItem::make($this->adminLabel('nav.schedule'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/schedule.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => ScheduleResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(ScheduleResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(30),

            NavigationItem::make($this->adminLabel('nav.assignments'))
                ->icon(Heroicon::OutlinedClipboardDocumentCheck)
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(40),

            NavigationItem::make($this->adminLabel('nav.quizzes_exams'))
                ->icon(Heroicon::OutlinedQuestionMarkCircle)
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(50),

            NavigationItem::make($this->adminLabel('nav.grades'))
                ->icon(Heroicon::OutlinedListBullet)
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(60),

            NavigationItem::make($this->adminLabel('nav.attendance'))
                ->icon(Heroicon::OutlinedCalendarDays)
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(70),

            NavigationItem::make($this->adminLabel('nav.certificates'))
                ->icon(Heroicon::OutlinedAcademicCap)
                ->url(fn (): string => KhmerDashboard::getUrl())
                ->visible(fn (): bool => auth()->user()?->isStudent() ?? false)
                ->sort(80),

            // ==========================================
            // Teacher-Only Navigation Items
            // ==========================================
            NavigationItem::make($this->adminLabel('nav.my_courses'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/courses.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => CourseResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(CourseResource::getRouteBaseName().'.*') && !request()->routeIs(CourseResource::getRouteBaseName().'.create'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(10),


            NavigationItem::make($this->adminLabel('nav.course_content'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/ducs.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => ContentLessonResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(ContentLessonResource::getRouteBaseName().'.*') || request()->routeIs(ContentChapterResource::getRouteBaseName().'.*') || request()->routeIs(ContentVideoResource::getRouteBaseName().'.*') || request()->routeIs(ContentDocumentResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(30),

            NavigationItem::make($this->adminLabel('nav.students'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/students.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => StudentResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(StudentResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(40),

            NavigationItem::make($this->adminLabel('nav.assignment_submissions'))
                ->icon($this->sidebarIcon('fas fa-file-upload', '#9333ea'))
                ->url(fn (): string => AssignmentSubmissionResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(AssignmentSubmissionResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(50),

            NavigationItem::make($this->adminLabel('nav.submissions'))
                ->icon($this->sidebarIcon('fas fa-inbox', '#4f46e5'))
                ->url(fn (): string => ExamSubmissionResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(ExamSubmissionResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(60),

            NavigationItem::make($this->adminLabel('nav.gradebook'))
                ->icon(Heroicon::OutlinedCheckBadge)
                ->url(fn (): string => AssessmentGradeResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(AssessmentGradeResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(70),

            NavigationItem::make($this->adminLabel('nav.attendance'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/presence.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => AttendanceResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(AttendanceResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(80),

            NavigationItem::make($this->adminLabel('nav.schedule'))
                ->icon(new HtmlString('<img src="'.e(asset('Icons/schedule.png')).'" alt="" class="fi-sidebar-item-icon" />'))
                ->url(fn (): string => ScheduleResource::getUrl('index'))
                ->isActiveWhen(fn (): bool => request()->routeIs(ScheduleResource::getRouteBaseName().'.*'))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(85),

            NavigationItem::make($this->adminLabel('nav.reports'))
                ->icon(Heroicon::OutlinedUsers)
                ->url(fn (): string => StudentReport::getUrl())
                ->isActiveWhen(fn (): bool => request()->routeIs(StudentReport::getRouteName()))
                ->visible(fn (): bool => auth()->user()?->isTeacher() ?? false)
                ->sort(90),

            // ==========================================
            // Admin Navigation Items
            // ==========================================
            $this->resourceNavItem($this->adminLabel('nav.users'), self::GROUP_USERS, 10, asset('Icons/users.png'), UserResource::class),
            $this->resourceNavItem($this->adminLabel('nav.roles'), self::GROUP_USERS, 20, asset('Icons/roles.png'), RoleResource::class),
            $this->resourceNavItem($this->adminLabel('nav.permissions'), self::GROUP_USERS, 30,  asset('Icons/permission.png'), PermissionResource::class),

            $this->resourceNavItem($this->adminLabel('nav.faculties'), self::GROUP_ACADEMIC, 10, asset('Icons/faculty.png'), FacultyResource::class),
            $this->resourceNavItem($this->adminLabel('nav.departments'), self::GROUP_ACADEMIC, 20, asset('Icons/department.png'), DepartmentResource::class),
            $this->resourceNavItem($this->adminLabel('nav.academic_years'), self::GROUP_ACADEMIC, 30, asset('Icons/yearacademic.png'), AcademicYearResource::class),
            $this->resourceNavItem($this->adminLabel('nav.semesters'), self::GROUP_ACADEMIC, 40, asset('Icons/semester.png'), SemesterResource::class),

            $this->resourceNavItem($this->adminLabel('nav.teachers'), self::GROUP_TEACHERS, 10, asset('Icons/teacher.png'), TeacherResource::class),
            $this->resourceNavItem($this->adminLabel('nav.course_assignments'), self::GROUP_TEACHERS, 20, asset('Icons/teacherasign.png'), CourseAssignmentResource::class),
            $this->resourceNavItem($this->adminLabel('nav.class_schedules'), self::GROUP_TEACHERS, 35, asset('Icons/schedule.png'), ScheduleResource::class),

            $this->resourceNavItem($this->adminLabel('nav.course_categories'), self::GROUP_CONTENT, 10, asset('Icons/course.png'), CourseCategoryResource::class),
            $this->resourceNavItem($this->adminLabel('nav.courses'), self::GROUP_CONTENT, 15, asset('Icons/courses.png'), CourseResource::class),
            $this->resourceNavItem($this->adminLabel('nav.class_rooms'), self::GROUP_CONTENT, 18, asset('Icons/course.png'), ClassRoomResource::class),
            $this->resourceNavItem($this->adminLabel('nav.modules'), self::GROUP_CONTENT, 19, asset('Icons/modules.png'), CourseModuleResource::class),
            // $this->resourceNavItem($this->adminLabel('nav.chapters'), self::GROUP_CONTENT, 20, asset('Icons/content-chapters.png'), ContentChapterResource::class),
            $this->resourceNavItem($this->adminLabel('nav.lessons'), self::GROUP_CONTENT, 30, asset('Icons/ducs.png'), ContentLessonResource::class),
            $this->resourceNavItem($this->adminLabel('nav.videos'), self::GROUP_CONTENT, 40, $this->sidebarIcon('fas fa-play-circle', '#0284c7'), ContentVideoResource::class),
            $this->resourceNavItem($this->adminLabel('nav.documents'), self::GROUP_CONTENT, 50, $this->sidebarIcon('fas fa-file-pdf', '#dc2626'), ContentDocumentResource::class),
            $this->resourceNavItem($this->adminLabel('nav.assignments'), self::GROUP_CONTENT, 60, $this->sidebarIcon('fas fa-clipboard-list', '#7c3aed'), ContentAssignmentResource::class),

            $this->resourceNavItem($this->adminLabel('nav.students'), self::GROUP_STUDENTS, 10, asset('Icons/students.png'), StudentResource::class),
            $this->resourceNavItem($this->adminLabel('nav.enrollments'), self::GROUP_STUDENTS, 20, asset('Icons/enrollments.png'), EnrollmentResource::class),
            $this->resourceNavItem($this->adminLabel('nav.attendance'), self::GROUP_STUDENTS, 30, asset('Icons/presence.png'), AttendanceResource::class),
            $this->resourceNavItem($this->adminLabel('nav.promotions'), self::GROUP_STUDENTS, 40, asset('Icons/students.png'), StudentPromotionResource::class),


            $this->resourceNavItem($this->adminLabel('nav.submissions'), self::GROUP_ASSESSMENT, 80, $this->sidebarIcon('fas fa-inbox', '#4f46e5'), ExamSubmissionResource::class),
            $this->resourceNavItem($this->adminLabel('nav.assignment_submissions'), self::GROUP_ASSESSMENT, 85, $this->sidebarIcon('fas fa-file-upload', '#9333ea'), AssignmentSubmissionResource::class),
            $this->resourceNavItem($this->adminLabel('nav.student_progress'), self::GROUP_ASSESSMENT, 110, $this->sidebarIcon('fas fa-chart-bar', '#0f766e'), StudentProgressResource::class),
            $this->resourceNavItem($this->adminLabel('nav.certificates'), self::GROUP_ASSESSMENT, 120, $this->sidebarIcon('fas fa-certificate', '#dc2626'), CertificateResource::class),

            $this->pageNavItem($this->adminLabel('nav.student_reports'), self::GROUP_REPORTS, 10, $this->sidebarIcon('fas fa-user-graduate', '#2563eb'), StudentReport::class),
            $this->pageNavItem($this->adminLabel('nav.attendance_reports'), self::GROUP_REPORTS, 20, $this->sidebarIcon('fas fa-calendar-check', '#16a34a'), AttendanceReport::class),
            $this->pageNavItem($this->adminLabel('nav.exam_reports'), self::GROUP_REPORTS, 30, $this->sidebarIcon('fas fa-file-alt', '#7c3aed'), ExamReport::class),
            $this->pageNavItem($this->adminLabel('nav.finance_reports'), self::GROUP_REPORTS, 40, $this->sidebarIcon('fas fa-money-bill-wave', '#15803d'), FinanceReport::class),
            $this->resourceNavItem('Audit Log', self::GROUP_REPORTS, 50, $this->sidebarIcon('fas fa-history', '#64748b'), ActivityLogResource::class),
            $this->pageNavItem($this->adminLabel('nav.activity_logs'), self::GROUP_REPORTS, 60, $this->sidebarIcon('fas fa-chart-line', '#64748b'), ActivityReport::class),
            $this->resourceNavItem($this->adminLabel('nav.languages'), self::GROUP_SETTINGS, 10, $this->sidebarIcon('fas fa-language', '#0891b2'), LanguageResource::class),
            $this->resourceNavItem($this->adminLabel('nav.translations'), self::GROUP_SETTINGS, 20, $this->sidebarIcon('fas fa-exchange-alt', '#4f46e5'), TranslationResource::class),
            $this->resourceNavItem('Frontend Settings', self::GROUP_SETTINGS, 30, $this->sidebarIcon('fas fa-sliders-h', '#f97316'), FrontendSettingResource::class),
            $this->resourceNavItem('CMS Pages', self::GROUP_SETTINGS, 40, $this->sidebarIcon('fas fa-file-alt', '#2563eb'), CmsPageResource::class),
            $this->resourceNavItem('Navigation Groups', self::GROUP_SETTINGS, 50, $this->sidebarIcon('fas fa-layer-group', '#0891b2'), NavigationGroupResource::class),
            $this->resourceNavItem('Navigation Items', self::GROUP_SETTINGS, 60, $this->sidebarIcon('fas fa-bars', '#16a34a'), NavigationItemResource::class),
        ];
    }

    private function adminLabel(string $key): Closure
    {
        return fn (): string => __("admin.{$key}");
    }

    private function sidebarIcon(string $class, string $color): HtmlString
    {
        return new HtmlString('<i class="'.e($class).'" style="font-size:22px;color:'.e($color).'"></i>');
    }

    private function navItem(string|Closure $label, string $group, int $sort, string|BackedEnum|HtmlString|null $icon, string|Closure|null $url = null): NavigationItem
    {
        return NavigationItem::make($label)
            ->group($this->adminLabel($group))
            ->icon($icon)
            ->sort($sort)
            ->url($url ?? '#')
            ->visible(fn (): bool => $this->canShowNavItem($group));
    }

    private function resourceNavItem(string|Closure $label, string $group, int $sort, string|BackedEnum|HtmlString|null $icon, string $resource, ?Closure $isActiveWhen = null, array $urlParameters = []): NavigationItem
    {
        return $this->navItem($label, $group, $sort, $icon, fn (): string => $resource::getUrl(parameters: $urlParameters))
            ->visible(fn (): bool => $this->canShowResourceNavItem($resource))
            ->isActiveWhen($isActiveWhen ?? fn (): bool => request()->routeIs($resource::getRouteBaseName().'.*'));
    }

    private function pageNavItem(string|Closure $label, string $group, int $sort, string|BackedEnum|HtmlString|null $icon, string $page): NavigationItem
    {
        return $this->navItem($label, $group, $sort, $icon, fn (): string => $page::getUrl())
            ->isActiveWhen(fn (): bool => request()->routeIs($page::getRouteName()));
    }

    private function canShowNavItem(string $group): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->hasRole('super_admin')) {
            return true;
        }

        return match ($group) {
            self::GROUP_USERS => $user->can('users.view') || $user->can('roles.view'),
            self::GROUP_ACADEMIC => $user->can('academic.view'),
            self::GROUP_TEACHERS => $user->can('lessons.view') || $user->can('courses.view'),
            self::GROUP_CONTENT => $user->can('courses.view') || $user->can('lessons.view'),
            self::GROUP_STUDENTS => $user->can('students.view'),
            self::GROUP_ASSESSMENT => $user->can('assessments.view'),
            self::GROUP_REPORTS => $user->can('view reports'),
            self::GROUP_SETTINGS => $user->can('manage settings') || $user->hasRole('admin'),
            default => $user->hasRole('admin'),
        };
    }

    private function canShowResourceNavItem(string $resource): bool
    {
        $user = auth()->user();
        if (!$user) {
            return false;
        }

        if ($user->hasRole('super_admin')) {
            return true;
        }

        // Map resources to specific Spatie permissions
        $permissionMap = [
            // User Management
            UserResource::class => 'users.view',
            RoleResource::class => 'roles.view',
            PermissionResource::class => 'roles.view',

            // Academic Management
            FacultyResource::class => 'academic.view',
            DepartmentResource::class => 'academic.view',
            AcademicYearResource::class => 'academic.view',
            SemesterResource::class => 'academic.view',

            // Teacher Management
            TeacherResource::class => 'users.view',
            CourseAssignmentResource::class => 'courses.view',
            ScheduleResource::class => 'courses.view',

            // Learning Content
            CourseCategoryResource::class => 'courses.view',
            CourseResource::class => 'courses.view',
            ClassRoomResource::class => 'courses.view',
            CourseModuleResource::class => 'courses.view',
            ContentLessonResource::class => 'lessons.view',
            ContentVideoResource::class => 'lessons.view',
            ContentDocumentResource::class => 'lessons.view',
            ContentAssignmentResource::class => 'lessons.view',

            // Student Management
            StudentResource::class => 'students.view',
            EnrollmentResource::class => 'students.view',
            AttendanceResource::class => 'attendance.view',
            StudentPromotionResource::class => 'promotions.view',

            // Assessment
            ExamSubmissionResource::class => 'assessments.view',
            AssignmentSubmissionResource::class => 'assessments.view',
            StudentProgressResource::class => 'assessments.view',
            CertificateResource::class => 'assessments.view',
        ];

        $permission = $permissionMap[$resource] ?? null;

        if ($permission && !$user->can($permission)) {
            return false;
        }

        return $resource::canAccess();
    }
}
