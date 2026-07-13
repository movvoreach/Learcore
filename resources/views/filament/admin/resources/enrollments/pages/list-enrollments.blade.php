<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    <style>
        .enrollments-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .enrollments-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .enrollments-list-show .fa,
        .enrollments-list-show .fas,
        .enrollments-list-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .enrollments-list-show .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .enrollments-list-show .fab {
            font-family: "Font Awesome 5 Brands" !important;
            font-weight: 400 !important;
        }

        /* Toolbar / Filters */
        .ss-toolbar {
            display: flex;
            align-items: center;
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
            gap: 12px;
            flex-wrap: wrap;
        }

        .ss-select {
            height: 42px;
            border: 1px solid #cfd4ec;
            border-radius: 3px;
            background: #fff;
            color: #59617e;
            padding: 8px 12px;
            font-size: 14px;
            min-width: 200px;
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-select:focus {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        .ss-select2-wrap {
            min-width: 200px;
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
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-select2-wrap .select2-container--bootstrap4 .select2-selection--single .select2-selection__rendered,
        .ss-select2-wrap .select2-container--default .select2-selection--single .select2-selection__rendered {
            height: 40px;
            padding: 8px 12px;
            color: #59617e;
            line-height: 24px;
            text-align: left;
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
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-select2-wrap .select2-container--bootstrap4 .select2-selection--single .select2-selection__arrow,
        .ss-select2-wrap .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 40px;
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

        /* Dark mode support for select2 */
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

        .dark .select2-results__option {
            background-color: #0f172a !important;
            color: #94a3b8 !important;
        }

        .dark .select2-results__option--highlighted[aria-selected] {
            background-color: #4f5ef7 !important;
            color: #ffffff !important;
        }

        .dark .select2-results__option[aria-selected=true] {
            background-color: #1e293b !important;
            color: #ffffff !important;
        }

        .ss-tool {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 54px;
            height: 46px;
            border: 0;
            border-radius: 0;
            background: #5866f5;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            transition: background-color .15s ease;
        }

        .ss-tool:hover {
            background: #4351e6;
        }

        /* Card styles */
        .ss-card {
            position: relative;
            overflow-x: auto;
            border-radius: 5px;
            background: #fff;
            padding: 26px 22px 24px;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
        }

        .ss-ribbon {
            position: absolute;
            top: 0;
            left: 22px;
            width: 90px;
            height: 94px;
            padding-top: 33px;
            background: #5866f5;
            color: #fff;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
        }

        .ss-ribbon::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -26px;
            border-left: 45px solid transparent;
            border-right: 45px solid transparent;
            border-top: 26px solid #5866f5;
        }

        .ss-heading {
            padding: 0 100px 16px;
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

        .dark .ss-card {
            background: #1e293b;
            box-shadow: none;
            border: 1px solid #334155;
        }

        .dark .ss-heading {
            border-bottom-color: #334155;
        }

        .dark .ss-heading h2 {
            color: #f1f5f9;
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
            width: min(980px, 100%);
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

        .ss-modal-plus {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            color: #3f4566;
            font-size: 17px;
            line-height: 1;
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

        .ss-modal-error {
            margin-top: 5px;
            color: #dc2626;
            font-size: 13px;
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

        .dark .ss-modal {
            background: #1e293b;
            color: #f1f5f9;
            border: 1px solid #334155;
        }

        .dark .ss-modal-head,
        .dark .ss-modal-foot {
            border-color: #334155;
        }

        .dark .ss-modal-label {
            color: #cbd5e1;
        }

        .dark .ss-modal-input {
            background: #0f172a;
            border-color: #334155;
            color: #e2e8f0;
        }

        @media (max-width: 768px) {
            .ss-modal-grid {
                grid-template-columns: 1fr;
            }
        }

        /* Hide default Filament header actions globally on this page */
        .fi-header-actions,
        .fi-ac-actions,
        .fi-ac,
        .fi-page-header-actions {
            display: none !important;
        }
    </style>

    <div class="enrollments-list-show"
         x-data="{
            showCreateEnrollmentModal: @js($showCreateEnrollmentModal),
            openEnrollmentModal() {
                this.showCreateEnrollmentModal = true;
                this.$nextTick(() => {
                    if (this.$refs.enrollmentDateInput && ! this.$refs.enrollmentDateInput.value) {
                        this.$refs.enrollmentDateInput.value = new Date().toISOString().slice(0, 10);
                    }

                    this.initEnrollmentSelects();
                    this.filterEnrollmentDepartmentFields();
                    this.filterEnrollmentSemesters();
                });
            },
            closeEnrollmentModal() {
                this.showCreateEnrollmentModal = false;
            },
            initEnrollmentSelects() {
                if (! window.jQuery || ! window.jQuery.fn.select2 || ! this.$refs.enrollmentModal) {
                    return;
                }

                [
                    this.$refs.enrollmentDepartmentSelect,
                    this.$refs.enrollmentStudentSelect,
                    this.$refs.enrollmentCourseSelect,
                    this.$refs.enrollmentAcademicYearSelect,
                    this.$refs.enrollmentSemesterSelect,
                    this.$refs.enrollmentStatusSelect,
                ].filter(Boolean).forEach((element) => {
                    const select = window.jQuery(element);

                    if (select.hasClass('select2-hidden-accessible')) {
                        select.select2('destroy');
                    }

                    select.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: element.dataset.placeholder || '',
                        dropdownParent: window.jQuery(this.$refs.enrollmentModal),
                        allowClear: element.dataset.allowClear === 'true',
                    });
                });

                window.jQuery(this.$refs.enrollmentDepartmentSelect)
                    .off('change.enrollmentModal')
                    .on('change.enrollmentModal', () => this.filterEnrollmentDepartmentFields());

                window.jQuery(this.$refs.enrollmentAcademicYearSelect)
                    .off('change.enrollmentModal')
                    .on('change.enrollmentModal', () => this.filterEnrollmentSemesters());
            },
            filterSelectByDepartment(selectElement, departmentId) {
                if (! selectElement) {
                    return;
                }

                let selectedIsVisible = true;

                Array.from(selectElement.options).forEach((option) => {
                    if (! option.value) {
                        option.hidden = false;
                        option.disabled = false;
                        return;
                    }

                    const visible = ! departmentId || option.dataset.department === departmentId;
                    option.hidden = ! visible;
                    option.disabled = ! visible;

                    if (option.selected && ! visible) {
                        selectedIsVisible = false;
                    }
                });

                if (! selectedIsVisible) {
                    selectElement.value = '';
                }

                if (window.jQuery && window.jQuery.fn.select2) {
                    window.jQuery(selectElement).trigger('change.select2');
                }
            },
            filterEnrollmentDepartmentFields() {
                const departmentId = this.$refs.enrollmentDepartmentSelect?.value || '';

                this.filterSelectByDepartment(this.$refs.enrollmentStudentSelect, departmentId);
                this.filterSelectByDepartment(this.$refs.enrollmentCourseSelect, departmentId);
            },
            filterEnrollmentSemesters() {
                if (! this.$refs.enrollmentSemesterSelect) {
                    return;
                }

                const yearId = this.$refs.enrollmentAcademicYearSelect?.value || '';
                const semesterSelect = this.$refs.enrollmentSemesterSelect;
                let selectedIsVisible = true;

                Array.from(semesterSelect.options).forEach((option) => {
                    if (! option.value) {
                        option.hidden = false;
                        return;
                    }

                    const visible = ! yearId || option.dataset.year === yearId;
                    option.hidden = ! visible;
                    option.disabled = ! visible;

                    if (option.selected && ! visible) {
                        selectedIsVisible = false;
                    }
                });

                semesterSelect.disabled = ! yearId;

                if (! selectedIsVisible) {
                    semesterSelect.value = '';
                }

                if (window.jQuery && window.jQuery.fn.select2) {
                    window.jQuery(semesterSelect).trigger('change.select2');
                }
            },
            nullableInt(value) {
                return value ? parseInt(value, 10) : null;
            },
            async submitEnrollment() {
                $wire.showCreateEnrollmentModal = true;
                $wire.enrollmentDepartmentId = this.nullableInt(this.$refs.enrollmentDepartmentSelect?.value);
                $wire.enrollmentStudentId = this.nullableInt(this.$refs.enrollmentStudentSelect?.value);
                $wire.enrollmentCourseId = this.nullableInt(this.$refs.enrollmentCourseSelect?.value);
                $wire.enrollmentAcademicYearId = this.nullableInt(this.$refs.enrollmentAcademicYearSelect?.value);
                $wire.enrollmentSemesterId = this.nullableInt(this.$refs.enrollmentSemesterSelect?.value);
                $wire.enrollmentDate = this.$refs.enrollmentDateInput?.value || null;
                $wire.enrollmentStatus = this.$refs.enrollmentStatusSelect?.value || 'studying';
                $wire.enrollmentNote = this.$refs.enrollmentNoteInput?.value || null;
                await $wire.createEnrollment();
            },
         }"
         x-init="$nextTick(() => { if (showCreateEnrollmentModal) openEnrollmentModal() })"
         x-on:close-create-enrollment-modal.window="closeEnrollmentModal()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <div class="ss-select2-wrap" wire:ignore x-data="{
                    value: @entangle('course_id'),
                    initSelect2() {
                        let select = window.jQuery(this.$refs.selectElement).select2({
                            theme: 'bootstrap4',
                            width: '100%',
                            placeholder: 'ជ្រើសរើសវគ្គសិក្សា (All Courses)',
                            allowClear: true
                        });
                        if (this.value) {
                            select.val(this.value).trigger('change.select2');
                        }
                        select.on('change', () => {
                            this.value = select.val() || null;
                        });
                        this.$watch('value', (val) => {
                            select.val(val).trigger('change.select2');
                        });
                    }
                }" x-init="initSelect2()">
                    <select x-ref="selectElement" class="ss-select">
                        <option value="">ជ្រើសរើសវគ្គសិក្សា (All Courses)</option>
                        @foreach(\App\Models\Course::all() as $course)
                            <option value="{{ $course->course_id }}">{{ $course->course_name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div class="ss-select2-wrap" wire:ignore x-data="{
                    value: @entangle('academic_year_id'),
                    initSelect2() {
                        let select = window.jQuery(this.$refs.selectElement).select2({
                            theme: 'bootstrap4',
                            width: '100%',
                            placeholder: 'ឆ្នាំសិក្សា (All Academic Years)',
                            allowClear: true
                        });
                        if (this.value) {
                            select.val(this.value).trigger('change.select2');
                        }
                        select.on('change', () => {
                            this.value = select.val() || null;
                        });
                        this.$watch('value', (val) => {
                            select.val(val).trigger('change.select2');
                        });
                    }
                }" x-init="initSelect2()">
                    <select x-ref="selectElement" class="ss-select">
                        <option value="">ឆ្នាំសិក្សា (All Academic Years)</option>
                        @foreach(\App\Models\AcademicYear::all() as $ay)
                            <option value="{{ $ay->academic_year_id }}">{{ $ay->year_name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="ss-select2-wrap" wire:ignore x-data="{
                    value: @entangle('semester_id'),
                    initSelect2() {
                        let select = window.jQuery(this.$refs.selectElement).select2({
                            theme: 'bootstrap4',
                            width: '100%',
                            placeholder: 'ឆមាស (All Semesters)',
                            allowClear: true
                        });
                        if (this.value) {
                            select.val(this.value).trigger('change.select2');
                        }
                        select.on('change', () => {
                            this.value = select.val() || null;
                        });
                        this.$watch('value', (val) => {
                            select.val(val).trigger('change.select2');
                        });
                    }
                }" x-init="initSelect2()">
                    <select x-ref="selectElement" class="ss-select">
                        <option value="">ឆមាស (All Semesters)</option>
                        @foreach(\App\Models\Semester::all() as $sem)
                            <option value="{{ $sem->semester_id }}">{{ $sem->semester_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ss-actions-group" style="display: flex; gap: 6px;">
                @if (\App\Filament\Admin\Resources\Enrollments\EnrollmentResource::canCreate())
                    <button class="ss-tool" type="button" title="ចុះឈ្មោះចូលរៀន" x-on:click="openEnrollmentModal()">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">បញ្ជី</div>

            <div class="ss-heading">
                <h2>ការចុះឈ្មោះចូលរៀន</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\Enrollments\EnrollmentResource::canCreate())
            <div class="ss-modal-backdrop"
                 x-show="showCreateEnrollmentModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeEnrollmentModal()">
                <form class="ss-modal"
                      x-ref="enrollmentModal"
                      x-on:submit.prevent="submitEnrollment()"
                      x-on:click.outside="closeEnrollmentModal()"
                      x-show="showCreateEnrollmentModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <h3 class="ss-modal-title">
                            <span class="ss-modal-plus"><i class="fa-solid fas fa-user-plus"></i></span>
                            ចុះឈ្មោះចូលរៀន
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="closeEnrollmentModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-grid">
                            <div class="ss-modal-field--full">
                                <label class="ss-modal-label" for="enrollment-department-id">ដេប៉ាតឺម៉ង់</label>
                                <select id="enrollment-department-id" class="ss-modal-input" x-ref="enrollmentDepartmentSelect" data-placeholder="ជ្រើសរើសដេប៉ាតឺម៉ង់" data-allow-clear="true">
                                    <option value="">ជ្រើសរើសដេប៉ាតឺម៉ង់</option>
                                    @foreach(\App\Models\Department::query()->orderBy('department_code')->orderBy('department_name')->get() as $department)
                                        <option value="{{ $department->department_id }}" @selected((int) $enrollmentDepartmentId === (int) $department->department_id)>
                                            {{ trim(($department->department_code ?? '').' - '.$department->department_name, ' -') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollmentDepartmentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-student-id">និស្សិត <span class="ss-required">*</span></label>
                                <select id="enrollment-student-id" class="ss-modal-input" x-ref="enrollmentStudentSelect" data-placeholder="ជ្រើសរើសនិស្សិត">
                                    <option value="">ជ្រើសរើសនិស្សិត</option>
                                    @foreach(\App\Models\Student::query()->orderBy('student_code')->orderBy('first_name')->get() as $student)
                                        @php($studentName = trim(($student->student_code ?? '').' - '.($student->first_name ?? '').' '.($student->last_name ?? '')))
                                        <option value="{{ $student->student_id }}" data-department="{{ $student->department_id }}" @selected((int) $enrollmentStudentId === (int) $student->student_id)>{{ $studentName }}</option>
                                    @endforeach
                                </select>
                                @error('enrollmentStudentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-course-id">វគ្គសិក្សា <span class="ss-required">*</span></label>
                                <select id="enrollment-course-id" class="ss-modal-input" x-ref="enrollmentCourseSelect" data-placeholder="ជ្រើសរើសវគ្គសិក្សា">
                                    <option value="">ជ្រើសរើសវគ្គសិក្សា</option>
                                    @foreach(\App\Models\Course::query()->orderBy('course_name')->get() as $course)
                                        <option value="{{ $course->course_id }}" data-department="{{ $course->department_id }}" @selected((int) $enrollmentCourseId === (int) $course->course_id)>{{ $course->course_name }}</option>
                                    @endforeach
                                </select>
                                @error('enrollmentCourseId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-academic-year-id">ឆ្នាំសិក្សា</label>
                                <select id="enrollment-academic-year-id" class="ss-modal-input" x-ref="enrollmentAcademicYearSelect" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សា" data-allow-clear="true">
                                    <option value="">ជ្រើសរើសឆ្នាំសិក្សា</option>
                                    @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                        <option value="{{ $academicYear->academic_year_id }}" @selected((int) $enrollmentAcademicYearId === (int) $academicYear->academic_year_id)>{{ $academicYear->year_name }}</option>
                                    @endforeach
                                </select>
                                @error('enrollmentAcademicYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-semester-id">ឆមាស</label>
                                <select id="enrollment-semester-id" class="ss-modal-input" x-ref="enrollmentSemesterSelect" data-placeholder="ជ្រើសរើសឆមាស" data-allow-clear="true" @disabled(blank($enrollmentAcademicYearId))>
                                    <option value="">ជ្រើសរើសឆមាស</option>
                                    @foreach(\App\Models\Semester::query()->orderBy('start_date')->get() as $semester)
                                        <option value="{{ $semester->semester_id }}" data-year="{{ $semester->academic_year_id }}" @selected((int) $enrollmentSemesterId === (int) $semester->semester_id)>{{ $semester->semester_name }}</option>
                                    @endforeach
                                </select>
                                @error('enrollmentSemesterId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-date">ថ្ងៃចុះឈ្មោះ</label>
                                <input id="enrollment-date" class="ss-modal-input" type="date" x-ref="enrollmentDateInput" value="{{ $enrollmentDate }}">
                                @error('enrollmentDate') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="enrollment-status">ស្ថានភាព <span class="ss-required">*</span></label>
                                <select id="enrollment-status" class="ss-modal-input" x-ref="enrollmentStatusSelect" data-placeholder="ជ្រើសរើសស្ថានភាព">
                                    <option value="studying" @selected($enrollmentStatus === 'studying')>កំពុងសិក្សា</option>
                                    <option value="completed" @selected($enrollmentStatus === 'completed')>បានបញ្ចប់</option>
                                    <option value="cancelled" @selected($enrollmentStatus === 'cancelled')>បានបោះបង់</option>
                                </select>
                                @error('enrollmentStatus') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full">
                                <label class="ss-modal-label" for="enrollment-note">កំណត់សម្គាល់</label>
                                <textarea id="enrollment-note" class="ss-modal-input" x-ref="enrollmentNoteInput">{{ $enrollmentNote }}</textarea>
                                @error('enrollmentNote') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeEnrollmentModal()">បោះបង់</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createEnrollment">
                            <span wire:loading.remove wire:target="createEnrollment">រក្សាទុក</span>
                            <span wire:loading wire:target="createEnrollment">កំពុងរក្សាទុក...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>

    <script>
        (function() {
            const url = new URL(window.location);
            if (url.searchParams.has('openEnrollmentModal')) {
                url.searchParams.delete('openEnrollmentModal');
                window.history.replaceState({}, document.title, url.pathname + url.search);
            }
        })();
    </script>
</x-filament-panels::page>

