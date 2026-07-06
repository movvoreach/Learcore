<?php

namespace App\Providers\Filament;

use App\Filament\Admin\Pages\Dashboard as KhmerDashboard;
use App\Filament\Admin\Pages\Reports\ActivityReport;
use App\Filament\Admin\Pages\Reports\AttendanceReport;
use App\Filament\Admin\Pages\Reports\ExamReport;
use App\Filament\Admin\Pages\Reports\FinanceReport;
use App\Filament\Admin\Pages\Reports\StudentReport;
use App\Filament\Admin\Resources\AssignmentSubmissions\AssignmentSubmissionResource;
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
use Illuminate\Support\HtmlString;
use Illuminate\View\Middleware\ShareErrorsFromSession;

class AdminPanelProvider extends PanelProvider
{
    private const GROUP_USERS = 'គ្រប់គ្រងអ្នកប្រើប្រាស់';

    private const GROUP_ACADEMIC = 'គ្រប់គ្រងការសិក្សា';

    private const GROUP_STUDENTS = 'គ្រប់គ្រងនិស្សិត';

    private const GROUP_TEACHERS = 'គ្រប់គ្រងគ្រូបង្រៀន';

    private const GROUP_CONTENT = 'មាតិកាសិក្សា';

    private const GROUP_ASSESSMENT = 'ការវាយតម្លៃ';

    private const GROUP_COMMUNICATION = 'ការទំនាក់ទំនង';

    private const GROUP_FINANCE = 'ហិរញ្ញវត្ថុ';

    private const GROUP_REPORTS = 'របាយការណ៍';

    private const GROUP_SETTINGS = 'ការកំណត់';

    private const GROUP_API = 'ចំណុចប្រទាក់កម្មវិធី';

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
            ->colors([
                'primary' => Color::Amber,
            ])
            ->viteTheme('resources/css/filament/admin/theme.css')
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
                PanelsRenderHook::SCRIPTS_AFTER,
                function (): HtmlString {
                    $user = auth()->user();
                    $nameText = $user ? e($user->name) : 'Guest';
                    $roleText = 'Administrator';
                    if ($user) {
                        if ($user->hasRole('student')) {
                            $roleText = 'Student';
                        } elseif ($user->hasRole('teacher')) {
                            $roleText = 'Teacher';
                        }
                    }

                    return new HtmlString(<<<HTML
                    <script>
                        (() => {
                            let hoverOpenedSidebar = false

                            const desktopSidebarCanHover = () => (
                                window.matchMedia('(min-width: 1024px)').matches &&
                                document.body.classList.contains('fi-body-has-sidebar-collapsible-on-desktop') &&
                                ! document.body.classList.contains('fi-body-has-top-navigation')
                            )

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
                                        <span class="lc-user-name">{$nameText}</span>
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
                                    searchInput.placeholder = 'Search courses, lessons, quizzes...';
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
            NavigationGroup::make(self::GROUP_USERS),
            NavigationGroup::make(self::GROUP_ACADEMIC),
            NavigationGroup::make(self::GROUP_STUDENTS),
            NavigationGroup::make(self::GROUP_TEACHERS),
            NavigationGroup::make(self::GROUP_CONTENT),
            NavigationGroup::make(self::GROUP_ASSESSMENT),
            NavigationGroup::make(self::GROUP_REPORTS)->collapsed(),
            NavigationGroup::make(self::GROUP_SETTINGS),
        ];
    }

    // =========================
    // NAV ITEMS
    // =========================
    private function lmsNavigationItems(): array
    {
        return [
            $this->resourceNavItem('តួនាទី', self::GROUP_USERS, 20, asset('Icons/roles.png'), RoleResource::class),
            $this->resourceNavItem('សិទ្ធិ', self::GROUP_USERS, 30,  asset('Icons/permission.png'), PermissionResource::class),

            $this->resourceNavItem('គ្រូបង្រៀន', self::GROUP_TEACHERS, 10, asset('Icons/teacher.png'), TeacherResource::class),
            $this->resourceNavItem('ចាត់តាំងវគ្គសិក្សា', self::GROUP_TEACHERS, 20, asset('Icons/teacherasign.png'), CourseAssignmentResource::class),
            $this->resourceNavItem('កាលវិភាគសិក្សា', self::GROUP_TEACHERS, 35, asset('Icons/schedule.png'), ScheduleResource::class),

            $this->resourceNavItem('ប្រភេទវគ្គសិក្សា', self::GROUP_CONTENT, 10, asset('Icons/course.png'), CourseCategoryResource::class),
            $this->resourceNavItem('វគ្គសិក្សា', self::GROUP_CONTENT, 15, asset('Icons/courses.png'), CourseResource::class),
            $this->resourceNavItem('ថ្នាក់រៀន', self::GROUP_CONTENT, 18, asset('Icons/course.png'), ClassRoomResource::class),
            $this->resourceNavItem('ជំពូក', self::GROUP_CONTENT, 20, asset('Icons/content-chapters.png'), ContentChapterResource::class),
            $this->resourceNavItem('មេរៀន', self::GROUP_CONTENT, 30, asset('Icons/ducs.png'), ContentLessonResource::class),
            $this->resourceNavItem('វីដេអូ', self::GROUP_CONTENT, 40, Heroicon::OutlinedVideoCamera, ContentVideoResource::class),
            $this->resourceNavItem('ឯកសារ', self::GROUP_CONTENT, 50, Heroicon::OutlinedDocumentText, ContentDocumentResource::class),
            $this->resourceNavItem('កិច្ចការ', self::GROUP_CONTENT, 60, Heroicon::OutlinedClipboardDocumentCheck, ContentAssignmentResource::class),
            $this->resourceNavItem('ធនធាន', self::GROUP_CONTENT, 70, Heroicon::OutlinedFolderOpen, ContentResourceResource::class),

            $this->resourceNavItem('តេស្តខ្លី', self::GROUP_ASSESSMENT, 10, Heroicon::OutlinedQuestionMarkCircle, QuizResource::class),
            $this->resourceNavItem('ធនាគារសំណួរ', self::GROUP_ASSESSMENT, 20, Heroicon::OutlinedCircleStack, QuestionBankResource::class),
            $this->resourceNavItem('សំណួរ', self::GROUP_ASSESSMENT, 30, Heroicon::OutlinedListBullet, AssessmentQuestionResource::class),
            $this->resourceNavItem('ជម្រើសចម្លើយ', self::GROUP_ASSESSMENT, 40, Heroicon::OutlinedCheckCircle, QuestionOptionResource::class),
            $this->resourceNavItem('ការប្រឡង', self::GROUP_ASSESSMENT, 50, Heroicon::OutlinedPencilSquare, ExamResource::class, fn (): bool => request()->routeIs(ExamResource::getRouteBaseName().'.*') && request()->query('view') !== 'schedule'),
            $this->resourceNavItem('កាលវិភាគប្រឡង', self::GROUP_ASSESSMENT, 60, Heroicon::OutlinedCalendarDays, ExamResource::class, fn (): bool => request()->routeIs(ExamResource::getRouteBaseName().'.*') && request()->query('view') === 'schedule', ['view' => 'schedule']),
            $this->resourceNavItem('បេក្ខជនប្រឡង', self::GROUP_ASSESSMENT, 70, Heroicon::OutlinedUserGroup, ExamCandidateResource::class),
            $this->resourceNavItem('ការដាក់ស្នើ', self::GROUP_ASSESSMENT, 80, Heroicon::OutlinedInboxStack, ExamSubmissionResource::class),
            $this->resourceNavItem('Assignment Submissions', self::GROUP_ASSESSMENT, 85, Heroicon::OutlinedInboxArrowDown, AssignmentSubmissionResource::class),
            $this->resourceNavItem('ការដាក់ពិន្ទុ', self::GROUP_ASSESSMENT, 90, Heroicon::OutlinedCheckBadge, AssessmentGradeResource::class),
            $this->resourceNavItem('លទ្ធផល', self::GROUP_ASSESSMENT, 100, Heroicon::OutlinedTrophy, AssessmentResultResource::class),
            $this->resourceNavItem('វឌ្ឍនភាពនិស្សិត', self::GROUP_ASSESSMENT, 110, Heroicon::OutlinedChartBar, StudentProgressResource::class),
            $this->resourceNavItem('វិញ្ញាបនបត្រ', self::GROUP_ASSESSMENT, 120, Heroicon::OutlinedDocumentCheck, CertificateResource::class),

            $this->pageNavItem('របាយការណ៍និស្សិត', self::GROUP_REPORTS, 10, Heroicon::OutlinedUsers, StudentReport::class),
            $this->pageNavItem('របាយការណ៍វត្តមាន', self::GROUP_REPORTS, 20, Heroicon::OutlinedCalendarDateRange, AttendanceReport::class),
            $this->pageNavItem('របាយការណ៍ប្រឡង', self::GROUP_REPORTS, 30, Heroicon::OutlinedDocumentCheck, ExamReport::class),
            $this->pageNavItem('របាយការណ៍ហិរញ្ញវត្ថុ', self::GROUP_REPORTS, 40, Heroicon::OutlinedBanknotes, FinanceReport::class),
            $this->pageNavItem('កំណត់ត្រាសកម្មភាព', self::GROUP_REPORTS, 50, Heroicon::OutlinedQueueList, ActivityReport::class),
        ];
    }

    private function navItem(string $label, string $group, int $sort, string|BackedEnum|null $icon, string|Closure|null $url = null): NavigationItem
    {
        return NavigationItem::make($label)
            ->group($group)
            ->icon($icon)
            ->sort($sort)
            ->url($url ?? '#')
            ->visible(fn (): bool => ! auth()->user()?->isStudent());
    }

    private function resourceNavItem(string $label, string $group, int $sort, string|BackedEnum|null $icon, string $resource, ?Closure $isActiveWhen = null, array $urlParameters = []): NavigationItem
    {
        return $this->navItem($label, $group, $sort, $icon, fn (): string => $resource::getUrl(parameters: $urlParameters))
            ->visible(fn (): bool => $this->canShowResourceNavItem($resource))
            ->isActiveWhen($isActiveWhen ?? fn (): bool => request()->routeIs($resource::getRouteBaseName().'.*'));
    }

    private function pageNavItem(string $label, string $group, int $sort, string|BackedEnum|null $icon, string $page): NavigationItem
    {
        return $this->navItem($label, $group, $sort, $icon, fn (): string => $page::getUrl())
            ->isActiveWhen(fn (): bool => request()->routeIs($page::getRouteName()));
    }

    private function canShowResourceNavItem(string $resource): bool
    {
        if (! auth()->user()?->isStudent()) {
            return $resource::canAccess();
        }

        return $resource === CourseResource::class && $resource::canAccess();
    }
}
