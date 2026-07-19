# LearnCore Technical Report / របាយការណ៍បច្ចេកទេស LearnCore

## 1. Project Overview / ព័ត៌មានទូទៅអំពីគម្រោង

**Khmer Explanation (ភាសាខ្មែរ):**  
LearnCore គឺជា Learning Management System (LMS) សម្រាប់គ្រប់គ្រងការសិក្សា វគ្គសិក្សា មេរៀន សិស្ស គ្រូ ការចុះឈ្មោះ វត្តមាន កិច្ចការ តេស្តខ្លី ការប្រឡង ពិន្ទុ សញ្ញាបត្រ ការជជែកពិភាក្សា របាយការណ៍ និងមាតិកា Frontend/CMS។ អ្នកប្រើប្រាស់សំខាន់ៗមាន `super_admin`, `admin`, `teacher`, និង `student`។ គម្រោងប្រើ Laravel MVC ជាមួយ Filament Admin Panel និង Blade frontend។ File ពាក់ព័ន្ធ៖ `composer.json`, `routes/web.php`, `app/Models/*`, `app/Filament/Admin/*`, `resources/views/frontend/*`, `database/migrations/*`។

**English Explanation:**  
LearnCore is a Learning Management System for managing courses, lessons, students, teachers, enrollments, attendance, assignments, quizzes, exams, grades, certificates, discussions, reports, and frontend/CMS content. Main users are `super_admin`, `admin`, `teacher`, and `student`. The project uses Laravel MVC with a Filament admin panel and Blade frontend. Related files: `composer.json`, `routes/web.php`, `app/Models/*`, `app/Filament/Admin/*`, `resources/views/frontend/*`, `database/migrations/*`.

## 2. System Architecture / ស្ថាបត្យកម្មប្រព័ន្ធ

**Khmer Explanation (ភាសាខ្មែរ):**  
ប្រព័ន្ធនេះប្រើ MVC និង Client-Server Architecture។ Browser ផ្ញើ Request ទៅ Laravel route, middleware ពិនិត្យ locale/auth/permission, controller ឬ Filament page ដំណើរការ business logic, service class ជួយគ្រប់គ្រង logic សំខាន់ៗ, model ប្រើ Eloquent ORM ទាក់ទង database, បន្ទាប់មក response ត្រូវបង្ហាញជា Blade/Filament page ឬ JSON។  

```text
Browser
↓
Route: routes/web.php
↓
Middleware: SetLocale, auth, EnsureStudentFilamentAccess, CSRF/session
↓
Controller / Filament Page
↓
Service: app/Services/*
↓
Model: app/Models/*
↓
Database: database/migrations/*
↓
Response: Blade / Filament / JSON
```

**English Explanation:**  
The system uses MVC and a client-server architecture. The browser sends a request to Laravel routes, middleware handles locale/auth/permission checks, controllers or Filament pages process the request, service classes handle focused business logic, Eloquent models communicate with the database, then a Blade/Filament page or JSON response is returned.

## 3. Backend Technology / បច្ចេកវិទ្យា Backend

**Khmer Explanation (ភាសាខ្មែរ):**

| Technology | Version / Status | Purpose | Configuration / Usage Files |
|---|---:|---|---|
| PHP | `^8.2` | ភាសាសម្រាប់ Backend | `composer.json`, `Dockerfile` |
| Laravel Framework | `12.62.0` installed | Web framework, routing, MVC, ORM, queue, validation | `composer.json`, `artisan`, `bootstrap/app.php` |
| Eloquent ORM | Laravel built-in | ទាក់ទង database តាម Model | `app/Models/*`, `database/migrations/*` |
| Filament | `5.6.7` installed | Admin panel, resources, forms, tables, pages | `app/Providers/Filament/AdminPanelProvider.php`, `app/Filament/Admin/*` |
| Authentication | Session guard | Login/logout និង user session | `config/auth.php`, `routes/web.php`, Filament login |
| Authorization | Spatie Permission + Policies | Role/permission control | `config/permission.php`, `database/migrations/2026_06_18_141958_create_permission_tables.php`, `app/Policies/*` |
| Queue | Database queue | Background jobs and failed job handling | `.env.example`, `config/queue.php`, `database/migrations/0001_01_01_000002_create_jobs_table.php` |
| Cache | Database cache | Cache settings/localization/dashboard data | `.env.example`, `config/cache.php`, `database/migrations/0001_01_01_000001_create_cache_table.php`, `app/Services/SettingService.php` |
| Storage | Laravel filesystem | Upload avatars, editor images/videos, public files | `config/filesystems.php`, `app/Http/Controllers/Admin/LessonEditorUploadController.php` |
| Email | Log mailer in example env | Development email logging | `.env.example`, `config/mail.php` |
| Background Jobs | Queue tables exist; queue listener in composer script | Queue processing support | `composer.json`, `AppServiceProvider.php` queue failure listener |
| API | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No `routes/api.php` found in inspected files | `routes/web.php` only |

**English Explanation:**  
The backend is Laravel 12 on PHP 8.2. It uses Eloquent ORM, Filament for admin CRUD, session authentication, Spatie Laravel Permission for roles/permissions, database-backed queue/cache/session tables, Laravel filesystem storage, and log mail in the example environment. A separate API route file was not found.

## 4. Frontend Technology / បច្ចេកវិទ្យា Frontend

**Khmer Explanation (ភាសាខ្មែរ):**  
Frontend ប្រើ Blade templates, Tailwind CSS 4, Vite 7, Axios, Filament/Livewire UI, Font Awesome assets, custom public icons, Battambang Khmer fonts, និង TipTap rich text editor សម្រាប់ lesson editor។ Vue/React components និង state management library មិនបានរកឃើញទេ។

| Technology | Purpose | Configuration / Usage Files |
|---|---|---|
| Blade | Server-rendered frontend pages | `resources/views/frontend/*`, `resources/views/filament/*` |
| Tailwind CSS | CSS framework | `package.json`, `resources/css/app.css`, `resources/css/filament/admin/theme.css` |
| Vite | Asset build tool | `vite.config.js`, `package.json` |
| Axios | AJAX helper | `resources/js/bootstrap.js` |
| TipTap | Rich text editor for lessons | `resources/js/app.js`, editor upload route |
| Font Awesome | Admin icons | `public/backend/plugins/fontawesome-free`, `AppServiceProvider.php` |
| Chart.js/uPlot/Summernote/Dropzone/Toastr assets | Static admin plugin assets present | `public/backend/plugins/*` |
| Vue/React | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No `.vue` or React component usage found |
| State Management | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No Vuex/Pinia/Redux/Zustand found |

**English Explanation:**  
The frontend uses Blade templates, Tailwind CSS 4, Vite 7, Axios, Filament/Livewire UI, Font Awesome/static icon assets, Battambang Khmer fonts, and TipTap for lesson editing. Vue, React, and dedicated frontend state-management libraries were not found.

## 5. Database Design / ការរចនា Database

**Khmer Explanation (ភាសាខ្មែរ):**  
`.env.example` កំណត់ `DB_CONNECTION=sqlite` សម្រាប់ development example។ Dockerfile ដំឡើង PostgreSQL PHP extensions (`pdo_pgsql`, `pgsql`) សម្រាប់ production/container compatibility។ Tables សំខាន់ៗមាន `users`, `roles`, `permissions`, `faculties`, `departments`, `academic_years`, `semesters`, `students`, `teachers`, `course_categories`, `courses`, `course_modules`, `content_lessons`, `content_chapters`, `content_videos`, `content_documents`, `content_resources`, `content_assignments`, `enrollments`, `attendances`, `student_progresses`, `quizzes`, `question_banks`, `assessment_questions`, `question_options`, `exams`, `exam_candidates`, `exam_submissions`, `assessment_grades`, `assessment_results`, `certificates`, `course_completion_requests`, `discussion_posts`, `discussion_comments`, `discussion_reactions`, `languages`, `translations`, `settings`, `pages`, `navigation_groups`, `navigation_items`, `notifications`, `jobs`, `cache`, និង `sessions`។  

Relationships ត្រូវបានកំណត់ក្នុង Models ដូចជា `Course` has many `ContentLesson`, `CourseModule` has many `ContentLesson`, `Student` has many `Enrollment`, `Schedule` belongs to many `Student`, `DiscussionPost` has many `DiscussionComment`, និង `User` has one `Student`/`Teacher`។

**English Explanation:**  
`.env.example` uses `DB_CONNECTION=sqlite` for the example development environment. The Dockerfile installs PostgreSQL extensions for container/production compatibility. The migrations define academic, LMS content, assessment, enrollment, progress, certificate, discussion, localization, CMS/navigation, notification, queue, cache, and session tables. Relationships are implemented in Eloquent models, including course-to-lessons, module-to-lessons, student-to-enrollments, schedule-to-students, discussion post-to-comments, and user-to-student/teacher.

## 6. Packages & Dependencies / បណ្ណាល័យ និង Packages

**Khmer Explanation (ភាសាខ្មែរ):**

| Package | Version | Purpose | Location Used |
|---|---:|---|---|
| `laravel/framework` | `12.62.0` | Core Laravel framework | Whole app |
| `filament/filament` | `5.6.7` | Admin panel/resources | `app/Filament/Admin/*` |
| `filament/notifications` | `5.6.7` | Filament notifications | Admin pages/resources |
| `spatie/laravel-permission` | `6.25.0` | Roles and permissions | `User.php`, `config/permission.php`, seeders |
| `ktith/laravel-exception-notifier` | `1.0.8` | Exception notification | `bootstrap/app.php`, `AppServiceProvider.php`, `.env.example` |
| `laravel/tinker` | `2.11.1` | REPL/dev tool | Composer dependency |
| `phpunit/phpunit` | `11.5.55` | Testing | `tests/*`, `phpunit.xml` |
| `laravel/pint` | `1.29.1` | PHP formatter | Dev dependency |
| `laravel/sail` | `1.62.0` | Laravel Docker dev tooling | Dev dependency |
| `vite` | `7.3.5` | Frontend build | `vite.config.js` |
| `tailwindcss` | `4.3.1` | CSS framework | `resources/css/*` |
| `laravel-vite-plugin` | `2.1.0` | Laravel + Vite bridge | `vite.config.js` |
| `axios` | `1.17.0` | HTTP/AJAX helper | `resources/js/bootstrap.js` |
| `@tiptap/*` | `3.28.0` | Rich text editor | `resources/js/app.js` |
| `lowlight` | `3.3.0` | Code highlighting support package | Installed; direct import not found in `resources/js/app.js` |
| PDF package | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No composer PDF package found | N/A |
| Excel package | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | CSV export is custom, no Excel package found | `ReportExportController.php` |

**English Explanation:**  
The project’s important packages are Laravel, Filament, Filament Notifications, Spatie Permission, exception notifier, PHPUnit/Pint/Sail dev tools, Vite, Tailwind, Axios, and TipTap. Dedicated PDF and Excel packages were not found; report export currently streams CSV manually.

## 7. Development Environment / បរិស្ថានអភិវឌ្ឍន៍

**Khmer Explanation (ភាសាខ្មែរ):**  
Project ត្រូវការ PHP `^8.2`, Composer, Node.js/npm, Vite, និង Git។ Composer scripts មាន `composer setup`, `composer dev`, និង `composer test`។ `composer dev` បើក Laravel server, queue listener, pail logs, និង Vite ជាមួយ `concurrently`។ Dockerfile មាន multi-stage build: Composer dependencies, Node asset build, និង PHP-FPM + Nginx + Supervisor production image។ `docker-compose.yml` មិនបានរកឃើញទេ។

**English Explanation:**  
The project requires PHP `^8.2`, Composer, Node.js/npm, Vite, and Git. Composer scripts include `setup`, `dev`, and `test`. The `dev` script runs Laravel server, queue listener, Pail logs, and Vite via Concurrently. The Dockerfile provides a multi-stage production image with Composer, Node build, PHP-FPM, Nginx, and Supervisor. `docker-compose.yml` was not found.

## 8. Project Folder Structure / រចនាសម្ព័ន្ធ Folder

**Khmer Explanation (ភាសាខ្មែរ):**

| Folder/File | Purpose |
|---|---|
| `app/` | Models, controllers, services, policies, providers, Filament admin code |
| `bootstrap/` | Laravel bootstrapping, routing/middleware/provider registration |
| `config/` | Laravel configuration files |
| `database/` | Migrations, seeders, factories |
| `public/` | Web root, compiled assets, icons, fonts, static admin plugins |
| `resources/` | Blade views, CSS, JavaScript source |
| `routes/` | Web and console routes |
| `storage/` | Logs, framework cache/views/sessions, app storage |
| `tests/` | PHPUnit feature/unit test skeletons |
| `vendor/` | Composer packages |
| `node_modules/` | npm packages |
| `docker/` | Nginx, Supervisor, entrypoint configuration |

**English Explanation:**  
The folder structure follows Laravel conventions, with additional Filament admin code under `app/Filament/Admin`, frontend Blade pages under `resources/views/frontend`, static admin assets under `public/backend/plugins`, and production container configuration under `docker/`.

## 9. Design Patterns / គំរូការរចនា Code

**Khmer Explanation (ភាសាខ្មែរ):**

| Pattern | Found? | Example Files |
|---|---|---|
| MVC | Found | `routes/web.php`, `app/Http/Controllers/*`, `app/Models/*`, `resources/views/*` |
| Service Layer | Found | `app/Services/StudentCourseProgressService.php`, `CourseCompletionService.php`, `LocalizationService.php` |
| Policy | Found | `app/Policies/CoursePolicy.php`, `StudentPolicy.php`, `LanguagePolicy.php` |
| Middleware | Found | `SetLocale.php`, `EnsureStudentFilamentAccess.php` |
| Dependency Injection / Container Binding | Found | `AppServiceProvider.php` binds Filament loading/login response/translation loader |
| Facade | Found | `Cache`, `DB`, `Storage`, `Gate`, `Route`, `Auth`, `Notification` usages |
| Factory | Found | `database/factories/UserFactory.php` |
| Observer | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No observer class found |
| Repository | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No repository layer found |
| Singleton | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | No project-specific singleton found |

**English Explanation:**  
The project uses MVC, service classes, policies, middleware, Laravel’s dependency injection/container, facades, and a user factory. Repository, observer, and project-specific singleton patterns were not found.

## 10. Security / សុវត្ថិភាពប្រព័ន្ធ

**Khmer Explanation (ភាសាខ្មែរ):**  
Authentication ប្រើ Laravel session guard និង Filament login។ Authorization ប្រើ Spatie roles/permissions, policies, `Gate::before` សម្រាប់ `super_admin`, និង middleware `EnsureStudentFilamentAccess`។ CSRF protection មានក្នុង Filament panel middleware និង Laravel web routes។ SQL injection ត្រូវបានកាត់បន្ថយដោយ Eloquent/query builder។ Validation មានក្នុង controllers/pages ដូចជា profile update, quiz submit, assignment submit, lesson editor upload។ Password hashing ប្រើ Laravel default hashed cast ក្នុង `User.php`។ File upload security មាន validation type/size/mime ក្នុង `LessonEditorUploadController.php`។ Production security headers ត្រូវបានបន្ថែមក្នុង `AppServiceProvider.php` និង Nginx config។

**English Explanation:**  
Security uses Laravel session authentication, Filament login, Spatie roles/permissions, policies, a `Gate::before` super-admin bypass, and student access middleware. CSRF protection is enabled in the web/Filament middleware stack. Eloquent/query builder reduces SQL injection risk. Validation is used in controllers/pages. Password hashing uses Laravel defaults in the user model. File uploads validate type, MIME, and size. Production security headers are added in `AppServiceProvider.php` and `docker/nginx.conf`.

## 11. Performance Optimization / ការកែលម្អល្បឿន

**Khmer Explanation (ភាសាខ្មែរ):**  
Project មាន database cache, deferred Filament table loading (`Table::configureUsing(...deferLoading())`), eager loading (`with(...)`) នៅ controllers/resources/pages, pagination, dashboard/settings/localization cache, Vite asset build, និង migration `2026_06_24_000001_add_filament_performance_indexes.php` សម្រាប់ indexes ច្រើន។ Queue support មាន database queue និង failed job listener។

**English Explanation:**  
Performance features include database cache, deferred Filament table loading, eager loading via `with(...)`, pagination, cached dashboard/settings/localization data, Vite asset building, and a dedicated migration for performance indexes. Queue support exists through database queues and failed-job notification handling.

## 12. API Documentation / ឯកសារ API

**Khmer Explanation (ភាសាខ្មែរ):**  
Separate API routes មិនបានរកឃើញទេ។ `routes/api.php` មិនមានក្នុង project file list។ មាន JSON response តូចៗនៅ web routes/controllers ដូចជា lesson editor upload និង discussion reactions។  

**English Explanation:**  
A separate API layer was not found. `routes/api.php` is not present. Some web endpoints return JSON, such as lesson editor upload and discussion reaction toggles.

## 13. Configuration Files / ឯកសារ Configuration

**Khmer Explanation (ភាសាខ្មែរ):**

| File | Explanation |
|---|---|
| `composer.json` | PHP packages, scripts, Laravel autoload |
| `composer.lock` | Exact installed PHP package versions |
| `package.json` | npm packages and Vite scripts |
| `package-lock.json` | Exact installed npm versions |
| `vite.config.js` | Vite input files and Tailwind plugin |
| `.env.example` | Example app/database/cache/session/queue/mail/Telegram settings |
| `config/*` | Laravel auth, cache, database, filesystems, mail, queue, services, session, permission config |
| `phpunit.xml` | PHPUnit test configuration |
| `artisan` | Laravel CLI entry point |
| `Dockerfile` | Production image build |
| `docker/nginx.conf` | Nginx public web root and PHP forwarding |
| `docker-compose.yml` | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ |

**English Explanation:**  
The project includes standard Laravel, Composer, npm, Vite, PHPUnit, Dockerfile, and Nginx configuration files. Docker Compose was requested for inspection but was not found.

## 14. User Request Flow / ដំណើរការពេល User ប្រើប្រាស់ប្រព័ន្ធ

**Khmer Explanation (ភាសាខ្មែរ):**

```text
User opens /learning or /admin
↓
routes/web.php receives request
↓
SetLocale middleware sets language
↓
auth / Filament / EnsureStudentFilamentAccess checks access
↓
frontendController, admin controller, or Filament page handles request
↓
Service class handles business logic when needed
↓
Eloquent model reads/writes database
↓
Blade / Filament / JSON response returns to browser
```

**English Explanation:**  
When a user opens the learning site or admin panel, Laravel routes receive the request, middleware sets locale and checks access, controllers or Filament pages process the action, services handle deeper business logic, Eloquent models read/write the database, and the browser receives a Blade, Filament, or JSON response.

## 15. Technology Summary Table / តារាងសង្ខេបបច្ចេកវិទ្យា

| Technology | Version / Status | Purpose | Configuration File | Usage Location |
|---|---:|---|---|---|
| PHP | `^8.2` | Backend language | `composer.json` | Whole backend |
| Laravel | `12.62.0` | Web framework | `composer.json` | Whole app |
| Filament | `5.6.7` | Admin panel | `composer.json` | `app/Filament/Admin` |
| Spatie Permission | `6.25.0` | Role/permission | `config/permission.php` | `User.php`, policies, resources |
| SQLite | Example default | Development DB | `.env.example` | Database connection |
| PostgreSQL extensions | Docker installed | Container DB support | `Dockerfile` | PHP runtime |
| Vite | `7.3.5` | Asset build | `vite.config.js` | `resources/css`, `resources/js` |
| Tailwind CSS | `4.3.1` | Styling | `package.json` | CSS files |
| Axios | `1.17.0` | AJAX helper | `package.json` | `resources/js/bootstrap.js` |
| TipTap | `3.28.0` | Rich text editor | `package.json` | `resources/js/app.js` |
| PHPUnit | `11.5.55` | Tests | `phpunit.xml` | `tests/*` |
| Docker Compose | Not Found in Project / មិនមាននៅក្នុងគម្រោងនេះទេ | N/A | N/A | N/A |

## 16. Recommendations / ការណែនាំកែលម្អ

**Khmer Explanation (ភាសាខ្មែរ):**

1. បន្ថែម README project-specific ជំនួស Laravel default README ដើម្បីពន្យល់ setup, roles, login, migration, seed, build, test។
2. បន្ថែម feature tests សម្រាប់ login, roles, course access, quiz submit, assignment submit, certificate workflow, និង upload validation។
3. បន្ថែម `routes/api.php` ប្រសិនបើត្រូវការ mobile app ឬ external integration។
4. បន្ថែម Docker Compose បើ project ត្រូវការ local container development ជាមួយ database/queue services។
5. កំណត់ file upload scan/cleanup policy សម្រាប់ production។
6. បន្តប្រើ eager loading/indexes ដើម្បីបន្ថយ N+1 query ក្នុង Filament resources និង frontend course pages។
7. ពិនិត្យ rich text HTML sanitization policy សម្រាប់ lesson/discussion content ដើម្បីកាត់បន្ថយ XSS risk។
8. បន្ថែម CI pipeline សម្រាប់ `composer test`, `npm run build`, និង Laravel Pint។

**English Explanation:**

1. Add a project-specific README to replace the default Laravel README with setup, roles, login, migration, seed, build, and test instructions.
2. Add feature tests for login, roles, course access, quiz submission, assignment submission, certificate workflow, and upload validation.
3. Add `routes/api.php` only if mobile or external integrations are needed.
4. Add Docker Compose if local container development needs database/queue services.
5. Define upload scanning and cleanup policy for production.
6. Continue using eager loading and indexes to reduce N+1 queries in Filament resources and frontend course pages.
7. Review rich text HTML sanitization for lesson/discussion content to reduce XSS risk.
8. Add CI for `composer test`, `npm run build`, and Laravel Pint.

## Inspection Notes / កំណត់ចំណាំពីការត្រួតពិនិត្យ

**Khmer Explanation (ភាសាខ្មែរ):**  
Report នេះផ្អែកលើ files ពិតដែលបាន inspect៖ `composer.json`, `composer.lock`, `package.json`, `package-lock.json`, `.env.example`, `vite.config.js`, `artisan`, `routes/`, `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `public/`, `storage/`, `tests/`, `Dockerfile`, `docker/`, និង `README.md`។ `docker-compose.yml`, `routes/api.php`, Vue/React, repository layer, observer classes, PDF package, និង Excel package មិនបានរកឃើញទេ។

**English Explanation:**  
This report is based on inspected real files: `composer.json`, `composer.lock`, `package.json`, `package-lock.json`, `.env.example`, `vite.config.js`, `artisan`, `routes/`, `app/`, `bootstrap/`, `config/`, `database/`, `resources/`, `public/`, `storage/`, `tests/`, `Dockerfile`, `docker/`, and `README.md`. `docker-compose.yml`, `routes/api.php`, Vue/React, a repository layer, observer classes, PDF package, and Excel package were not found.
