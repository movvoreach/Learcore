<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
        <script>
            (() => {
                const cleanAssignTeacherQuery = () => {
                    const url = new URL(window.location.href);

                    if (! url.searchParams.has('assignTeacher')) {
                        return;
                    }

                    url.searchParams.delete('assignTeacher');
                    window.history.replaceState({}, '', url.toString());
                };

                cleanAssignTeacherQuery();
            })();
        </script>
    @endonce

    <style>
        .courses-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .courses-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .courses-list-show .fa,
        .courses-list-show .fas,
        .courses-list-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .courses-list-show .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .courses-list-show .fab {
            font-family: "Font Awesome 5 Brands" !important;
            font-weight: 400 !important;
        }

        /* Toolbar / Filters */
        .ss-toolbar {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 16px;
            width: 100%;
            min-height: 64px;
            margin: 0 auto 30px;
            padding: 14px 22px;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
            flex-wrap: wrap;
        }

        .ss-filters-group {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            flex: 1 1 520px;
            min-width: 260px;
        }

        .ss-filters-group:empty::before {
            content: "";
            display: block;
            min-height: 46px;
        }

        .ss-actions-group {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .ss-tool {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            height: 46px;
            border: 0;
            border-radius: 4px;
            background: #5866f5;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            box-shadow: 0 8px 18px rgba(88, 102, 245, .24);
            transition: transform .15s ease, box-shadow .15s ease, background-color .15s ease;
        }

        .ss-tool:hover {
            background: #4351e6;
            color: #fff;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px rgba(67, 81, 230, .28);
        }

        .ss-filters-group .fi-ta-filters-above-content-ctn {
            width: 100%;
            margin: 0 !important;
            padding: 0 !important;
            border: 0 !important;
            background: transparent !important;
            box-shadow: none !important;
        }

        .ss-filters-group .fi-ta-filters {
            display: flex;
            align-items: flex-end;
            gap: 12px;
            flex-wrap: wrap;
            width: 100%;
        }

        .ss-filters-group .fi-ta-filters-header {
            display: flex;
            align-items: center;
            gap: 10px;
            min-height: 46px;
            margin: 0 !important;
        }

        .ss-filters-group .fi-ta-filters-heading {
            margin: 0 !important;
            color: #3a405f;
            font-size: 15px;
            font-weight: 700;
            line-height: 1;
            white-space: nowrap;
        }

        .ss-filters-group .fi-ta-filters-header .fi-link {
            min-height: 38px;
            border-radius: 4px;
            padding: 0 12px;
            background: #fff5f5;
            color: #dc3545 !important;
            font-weight: 700;
        }

        .ss-filters-group .fi-sc.fi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(190px, 1fr)) !important;
            align-items: end;
            gap: 10px !important;
            flex: 1 1 420px;
        }

        .ss-filters-group .fi-fo-field-label {
            color: #64748b;
            font-size: 12px;
            font-weight: 700;
        }

        .ss-filters-group .fi-input-wrp {
            min-height: 42px;
            border-radius: 4px !important;
            border-color: #dbe3ef !important;
            background: #f8fbff !important;
            box-shadow: none !important;
        }

        .courses-list-show .lc-course-actions {
            min-height: 38px;
            border-radius: 4px !important;
            background: #5866f5 !important;
            color: #fff !important;
            font-size: 13px !important;
            font-weight: 800 !important;
            box-shadow: 0 8px 18px rgba(88, 102, 245, .24) !important;
        }

        .courses-list-show .lc-course-actions:hover,
        .courses-list-show .lc-course-actions:focus-visible {
            background: #4351e6 !important;
            color: #fff !important;
        }

        .courses-list-show .fi-dropdown-list-item,
        .courses-list-show .fi-dropdown-list-item-label {
            color: #0f172a !important;
        }

        .dark .courses-list-show .fi-dropdown-list-item,
        .dark .courses-list-show .fi-dropdown-list-item-label {
            color: #f8fafc !important;
        }

        .ss-modal-backdrop {
            position: fixed;
            inset: 0;
            z-index: 60;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            overflow-y: auto;
            background: rgba(0, 0, 0, .48);
            padding: 42px 20px;
        }

        .ss-modal {
            width: min(860px, 100%);
            border-radius: 4px;
            background: #fff;
            color: #3f4566;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .22);
        }

        .ss-modal-head,
        .ss-modal-foot {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 62px;
            padding: 0 18px;
            border-bottom: 1px solid #e3e5ef;
        }

        .ss-modal-foot {
            justify-content: flex-end;
            gap: 10px;
            border-top: 1px solid #e3e5ef;
            border-bottom: 0;
        }

        .ss-modal-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 19px;
            font-weight: 400;
        }

        .ss-modal-subtitle {
            margin: 4px 0 0;
            color: #7a819f;
            font-size: 13px;
            line-height: 1.6;
        }

        .ss-modal-close {
            border: 0;
            background: transparent;
            color: #777;
            font-size: 28px;
            font-weight: 600;
            cursor: pointer;
        }

        .ss-modal-body {
            padding: 24px 18px 26px;
        }

        .ss-modal-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
        }

        .ss-modal-field--full {
            grid-column: 1 / -1;
        }

        .ss-modal-label {
            display: block;
            margin-bottom: 5px;
            color: #59617e;
            font-size: 14px;
        }

        .ss-required {
            color: #f3132e;
        }

        .ss-modal-input {
            width: 100%;
            min-height: 42px;
            border: 1px solid #cfd4ec;
            border-radius: 3px;
            background: #fff;
            padding: 8px 12px;
            color: #59617e;
            font: inherit;
            box-shadow: none;
        }

        textarea.ss-modal-input {
            min-height: 94px;
            resize: vertical;
        }

        .ss-modal-input:focus {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        .ss-modal-submit,
        .ss-modal-cancel {
            min-height: 42px;
            border: 0;
            border-radius: 3px;
            padding: 0 18px;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-modal-submit {
            background: #5866f5;
            color: #fff;
        }

        .ss-modal-cancel {
            background: #eef0f7;
            color: #59617e;
        }

        .ss-modal-error {
            margin-top: 5px;
            color: #dc2626;
            font-size: 13px;
        }

        .ss-select2-wrap .select2-container {
            width: 100% !important;
        }

        .ss-select2-wrap .select2-container--bootstrap4 .select2-selection,
        .ss-select2-wrap .select2-container--default .select2-selection--single {
            min-height: 42px;
            border: 1px solid #cfd4ec !important;
            border-radius: 3px !important;
            background: #fff !important;
            color: #59617e;
            box-shadow: none !important;
        }

        .ss-select2-wrap .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
        .ss-select2-wrap .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 40px;
            padding: 8px 12px;
            color: #59617e;
            line-height: 24px;
        }

        .ss-select2-wrap .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow,
        .ss-select2-wrap .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
        }

        .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field,
        .select2-container--default .select2-search--dropdown .select2-search__field {
            min-height: 42px;
            border: 1px solid #cfd4ec !important;
            border-radius: 3px !important;
            background: #fff !important;
            color: #59617e;
            padding: 8px 12px;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            box-shadow: none !important;
        }

        .ss-select2-wrap .select2-container--open .select2-selection,
        .ss-select2-wrap .select2-container--focus .select2-selection,
        .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field:focus,
        .select2-container--default .select2-search--dropdown .select2-search__field:focus {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        /* Card styles */
        .ss-card {
            position: relative;
            overflow: visible;
            border-radius: 5px;
            background: #fff;
            padding: 26px 22px 24px;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
        }

        .courses-list-show .fi-ta-content,
        .courses-list-show .fi-ta-table-ctn {
            overflow-x: auto;
        }

        .ss-heading {
            padding: 0 0 16px;
            border-bottom: 1px solid #d8dbe8;
            text-align: center;
            margin-bottom: 24px;
        }

        .ss-heading h2 {
            margin: 0;
            color: #3a405f;
            font-size: 36px;
            font-weight: 400;
            line-height: 1.35;
        }

        /* Dark mode compatibility */
        .dark .ss-toolbar {
            background: #1e293b;
            box-shadow: none;
            border: 1px solid #334155;
        }

        .dark .ss-filters-group .fi-ta-filters-heading {
            color: #f1f5f9;
        }

        .dark .ss-filters-group .fi-ta-filters-header .fi-link {
            background: rgba(220, 53, 69, .14);
        }

        .dark .ss-filters-group .fi-input-wrp {
            background: #0f172a !important;
            border-color: #334155 !important;
        }

        .dark .ss-card {
            background: #1e293b;
            box-shadow: none;
            border: 1px solid #334155;
        }

        .dark .ss-modal {
            background: #1e293b;
            border: 1px solid #334155;
            color: #f1f5f9;
        }

        .dark .ss-heading {
            border-bottom-color: #334155;
        }

        .dark .ss-heading h2 {
            color: #f1f5f9;
        }

        .dark .ss-modal-head,
        .dark .ss-modal-foot {
            border-color: #334155;
        }

        .dark .ss-modal-label,
        .dark .ss-modal-subtitle {
            color: #cbd5e1;
        }

        .dark .ss-modal-input {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        .dark .ss-select2-wrap .select2-container--bootstrap4 .select2-selection,
        .dark .ss-select2-wrap .select2-container--default .select2-selection--single {
            background: #0f172a !important;
            border-color: #334155 !important;
            color: #94a3b8;
        }

        .dark .ss-select2-wrap .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
        .dark .ss-select2-wrap .select2-container--default .select2-selection--single .select2-selection__rendered {
            color: #94a3b8 !important;
        }

        .dark .select2-dropdown {
            background-color: #0f172a !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        .dark .select2-container--bootstrap4 .select2-search--dropdown .select2-search__field,
        .dark .select2-container--default .select2-search--dropdown .select2-search__field {
            background-color: #1e293b !important;
            border-color: #334155 !important;
            color: #94a3b8 !important;
        }

        /* Hide default Filament header actions globally on this page */
        .fi-header-actions,
        .fi-header-actions-ctn,
        .fi-page-header-actions {
            display: none !important;
        }
    </style>

    <div class="courses-list-show"
         x-data="{
            showAssignTeacherModal: @js($showAssignTeacherModal),
            assignCourseId: @js($assignCourseId),
            assignCourseName: @js($assignCourseName),
            assignDepartmentId: @js($assignDepartmentId),
            assignTeacherId: @js($assignTeacherId),
            openAssignTeacherModal(payload = null) {
                if (payload) {
                    this.assignCourseId = payload.courseId || null;
                    this.assignCourseName = payload.courseName || null;
                    this.assignDepartmentId = payload.departmentId || null;
                    this.assignTeacherId = payload.teacherId || null;
                }

                this.showAssignTeacherModal = true;
                this.$nextTick(() => {
                    this.initAssignTeacherSelects();

                    if (this.$refs.assignDepartmentSelect && window.jQuery) {
                        window.jQuery(this.$refs.assignDepartmentSelect)
                            .val(this.assignDepartmentId ? String(this.assignDepartmentId) : '')
                            .trigger('change.select2');
                    }

                    if (this.$refs.assignTeacherSelect && window.jQuery) {
                        this.filterAssignTeachers();
                        window.jQuery(this.$refs.assignTeacherSelect)
                            .val(this.assignTeacherId ? String(this.assignTeacherId) : '')
                            .trigger('change');
                    }
                });
            },
            closeAssignTeacherModal() {
                this.showAssignTeacherModal = false;
                $wire.closeAssignTeacherModal();
                const url = new URL(window.location.href);

                if (url.searchParams.has('assignTeacher')) {
                    url.searchParams.delete('assignTeacher');
                    window.history.replaceState({}, '', url.toString());
                }
            },
            initAssignTeacherSelects() {
                if (! window.jQuery || ! window.jQuery.fn.select2 || ! this.$refs.assignTeacherModal) {
                    return;
                }

                [
                    this.$refs.assignDepartmentSelect,
                    this.$refs.assignTeacherSelect,
                ].filter(Boolean).forEach((element) => {
                    const select = window.jQuery(element);

                    if (select.hasClass('select2-hidden-accessible')) {
                        select.select2('destroy');
                    }

                    select.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: element.dataset.placeholder || '',
                        dropdownParent: window.jQuery(this.$refs.assignTeacherModal),
                        allowClear: element.dataset.allowClear === 'true',
                    });
                });

                window.jQuery(this.$refs.assignDepartmentSelect)
                    .off('change.assignTeacherDepartment')
                    .on('change.assignTeacherDepartment', () => {
                        this.assignDepartmentId = this.nullableInt(this.$refs.assignDepartmentSelect?.value);
                        this.assignTeacherId = null;
                        this.filterAssignTeachers();
                    });
            },
            filterAssignTeachers() {
                if (! window.jQuery || ! this.$refs.assignTeacherSelect) {
                    return;
                }

                const teacherSelect = window.jQuery(this.$refs.assignTeacherSelect);
                const departmentId = this.$refs.assignDepartmentSelect?.value || '';

                if (! teacherSelect.data('all-options')) {
                    teacherSelect.data('all-options', teacherSelect.children().clone());
                }

                const currentValue = teacherSelect.val();
                const allOptions = teacherSelect.data('all-options');

                teacherSelect.empty();

                allOptions.each(function () {
                    const option = window.jQuery(this);
                    const optionDepartmentId = option.data('department-id') ? String(option.data('department-id')) : '';
                    const optionValue = option.attr('value') || '';

                    if (! optionValue || ! departmentId || optionDepartmentId === String(departmentId)) {
                        teacherSelect.append(option.clone());
                    }
                });

                if (currentValue && teacherSelect.find(`option[value='${currentValue}']`).length) {
                    teacherSelect.val(currentValue);
                } else {
                    teacherSelect.val('');
                }

                teacherSelect.trigger('change.select2');
            },
            nullableInt(value) {
                return value ? parseInt(value, 10) : null;
            },
            async submitAssignTeacher() {
                const departmentId = this.nullableInt(this.$refs.assignDepartmentSelect?.value);
                const teacherId = this.nullableInt(this.$refs.assignTeacherSelect?.value);

                $wire.showAssignTeacherModal = true;
                await $wire.saveTeacherAssignment(this.assignCourseId, departmentId, teacherId);
            },
         }"
         x-on:open-assign-teacher-modal.window="openAssignTeacherModal($event.detail)"
         x-on:open-assign-teacher-local.window="openAssignTeacherModal($event.detail)"
         x-on:close-assign-teacher-modal.window="closeAssignTeacherModal()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <!-- No filters needed for courses table -->
            </div>
            
            <div class="ss-actions-group">
                @if (\App\Filament\Admin\Resources\Courses\CourseResource::canCreate() && !auth()->user()?->isStudent())
                    <a class="ss-tool" href="{{ \App\Filament\Admin\Resources\Courses\CourseResource::getUrl('create') }}" title="បញ្ចូលវគ្គសិក្សា">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="ss-card">
            <div class="ss-heading">
                <h2>វគ្គសិក្សា</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>

        @if (! auth()->user()?->isStudent())
            <div class="ss-modal-backdrop"
                 x-show="showAssignTeacherModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeAssignTeacherModal()">
                <form class="ss-modal"
                      x-ref="assignTeacherModal"
                      x-on:submit.prevent="submitAssignTeacher()"
                      x-on:click.outside="closeAssignTeacherModal()"
                      x-show="showAssignTeacherModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fas fa-chalkboard-teacher"></i></span>
                                Assign Teacher: <span x-text="assignCourseName || '-'"></span>
                            </h3>
                            <p class="ss-modal-subtitle">Select a teacher for this course.</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="closeAssignTeacherModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-grid">
                            <div class="ss-modal-field--full ss-select2-wrap">
                                <label class="ss-modal-label" for="assign-department-id">Department</label>
                                <select id="assign-department-id" class="ss-modal-input" x-ref="assignDepartmentSelect" data-placeholder="Select Department" data-allow-clear="true">
                                    <option value="">All Departments</option>
                                    @foreach(\App\Models\Department::query()->orderBy('department_name')->get() as $department)
                                        <option value="{{ $department->department_id }}" @selected((int) $assignDepartmentId === (int) $department->department_id)>{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                                @error('assignDepartmentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full ss-select2-wrap">
                                <label class="ss-modal-label" for="assign-teacher-id">Teacher <span class="ss-required">*</span></label>
                                <select id="assign-teacher-id" class="ss-modal-input" x-ref="assignTeacherSelect" data-placeholder="ជ្រើសរើសTeacher">
                                    <option value="">ជ្រើសរើសTeacher</option>
                                    @foreach(\App\Models\Teacher::query()->orderBy('teacher_code')->orderBy('first_name')->get() as $teacher)
                                        @php($teacherName = trim(($teacher->teacher_code ?? '').' - '.($teacher->first_name ?? '').' '.($teacher->last_name ?? '')))
                                        <option value="{{ $teacher->teacher_id }}" data-department-id="{{ $teacher->department_id }}" @selected((int) $assignTeacherId === (int) $teacher->teacher_id)>{{ $teacherName }}</option>
                                    @endforeach
                                </select>
                                @error('assignTeacherId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeAssignTeacherModal()">Cancel</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="saveTeacherAssignment">
                            <span wire:loading.remove wire:target="saveTeacherAssignment">Save Assignment</span>
                            <span wire:loading wire:target="saveTeacherAssignment">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-filament-panels::page>
