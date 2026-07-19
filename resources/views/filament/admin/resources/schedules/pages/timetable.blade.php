<x-filament-panels::page>
    @include('filament.admin.resources.schedules.partials.schedule-page-scope')

    <div
        x-data
        x-init="
            document.documentElement.classList.add('lc-schedules-index-page');
            document.body.classList.add('lc-schedules-index-page');

            const cleanupScheduleIndexScope = () => {
                document.documentElement.classList.remove('lc-schedules-index-page');
                document.body.classList.remove('lc-schedules-index-page');
            };

            document.addEventListener('livewire:navigating', cleanupScheduleIndexScope, { once: true });
        "
        hidden
    ></div>

    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    <style>
        .schedule-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .schedule-show *,
        .schedule-show button,
        .schedule-show select,
        .schedule-show input {
            font-family: inherit;
            letter-spacing: 0;
        }

        .schedule-show .fa,
        .schedule-show .fas,
        .schedule-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .schedule-show .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .schedule-show .fab {
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

        .ss-modal-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 62px;
            padding: 0 18px;
            border-bottom: 1px solid #e3e5ef;
        }

        .ss-modal-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 19px;
            font-weight: 400;
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
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 16px;
            padding: 24px 18px 26px;
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

        .ss-modal-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .ss-modal-foot {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            min-height: 62px;
            padding: 0 18px;
            border-top: 1px solid #e3e5ef;
        }

        .ss-modal-cancel,
        .ss-modal-add {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 42px;
            border: 0;
            border-radius: 3px;
            padding: 0 18px;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-modal-cancel {
            background: #eef0f7;
            color: #59617e;
        }

        .ss-modal-add {
            min-width: 132px;
            background: #5866f5;
            color: #fff;
            font-weight: 500;
        }

        @media (max-width: 768px) {
            .ss-modal-body {
                grid-template-columns: 1fr;
            }
        }

        .fi-header-actions,
        .fi-page-header-actions {
            display: none !important;
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
        }

        .ss-heading h2 {
            margin: 0;
            color: #3a405f;
            font-size: 36px;
            font-weight: 400;
            line-height: 1.35;
        }

        .ss-heading p {
            margin: 7px 0 0;
            font-size: 16px;
            line-height: 1.7;
        }

        /* Table styles */
        .ss-table {
            width: 100%;
            min-width: 900px;
            border-collapse: collapse;
            border: 1px solid #cbd4ec;
            color: #38405f;
            font-size: 14px;
            margin-top: 24px;
        }

        .ss-table th,
        .ss-table td {
            border: 1px solid #cbd4ec;
            padding: 12px;
            vertical-align: middle;
        }

        .ss-table th {
            background: #dfe2ff;
            text-align: center;
            font-size: 15px;
            font-weight: 600;
            color: #3a405f;
        }

        .ss-table td {
            background: #fff;
        }

        .timetable-time {
            font-weight: 600;
            color: #3a405f;
            background: #f4f6ff !important;
            white-space: nowrap;
            width: 120px;
            text-align: center;
        }

        .tt-subject {
            color: #5866f5;
            font-weight: 500;
            margin-bottom: 4px;
        }

        .tt-subject a {
            display: block;
            padding: 8px 10px;
            background: #f8faff;
            border: 1px solid #e2e8f0;
            border-radius: 4px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.02);
            transition: all 0.15s ease;
            text-decoration: none;
            color: inherit;
            text-align: center;
        }

        .tt-subject a:hover {
            background: #f1f4ff;
            border-color: #5866f5;
            color: #4351e6;
            box-shadow: 0 3px 6px rgba(88, 102, 245, 0.08);
        }

        .tt-subject-actions {
            display: flex;
            justify-content: center;
            gap: 6px;
            padding: 0 10px 8px;
            background: #f8faff;
            border-right: 1px solid #e2e8f0;
            border-bottom: 1px solid #e2e8f0;
            border-left: 1px solid #e2e8f0;
            border-radius: 0 0 4px 4px;
        }

        .tt-subject-edit {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            width: auto !important;
            min-height: 28px;
            padding: 4px 10px !important;
            border: 0 !important;
            border-radius: 3px !important;
            background: #22c55e !important;
            color: #fff !important;
            font-size: 12px;
            font-weight: 700;
            box-shadow: none !important;
        }

        .break-row {
            background-color: #e0f2fe;
            height: 38px;
        }

        .break-row td {
            background-color: #e0f2fe !important;
            color: #0369a1;
            font-weight: 600;
            font-size: 15px;
            text-align: center;
        }

        /* Dark mode compatibility */
        .dark .ss-toolbar {
            background: #1e293b;
            box-shadow: none;
            border: 1px solid #334155;
        }

        .dark .ss-select {
            background: #0f172a;
            border-color: #334155;
            color: #94a3b8;
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

        .dark .ss-table {
            border-color: #334155;
            color: #cbd5e1;
        }

        .dark .ss-table th {
            background: #334155;
            color: #f1f5f9;
            border-color: #475569;
        }

        .dark .ss-table td {
            background: #1e293b;
            border-color: #334155;
        }

        .dark .timetable-time {
            background: #0f172a !important;
            color: #cbd5e1;
        }

        .dark .tt-subject a {
            background: #0f172a;
            border-color: #334155;
        }

        .dark .tt-subject a:hover {
            background: #1e293b;
            border-color: #5866f5;
            color: #818cf8;
        }

        .dark .break-row td {
            background-color: #0c4a6e !important;
            color: #38bdf8;
        }

        .print-header, .print-footer { display: none; }
    </style>

    <div class="schedule-show"
         x-data="{
            showCreateScheduleModal: false,
            editScheduleId: null,
            scheduleSelects() {
                return [
                    this.$refs.scheduleDepartmentSelect,
                    this.$refs.scheduleAcademicYearSelect,
                    this.$refs.scheduleSemesterSelect,
                    this.$refs.scheduleCourseSelect,
                    this.$refs.scheduleTeacherSelect,
                    this.$refs.scheduleClassSelect,
                    this.$refs.scheduleDaySelect,
                ].filter(Boolean);
            },
            initScheduleModal() {
                this.$nextTick(() => {
                    if (! this.$refs.scheduleModal) {
                        return;
                    }

                    this.$refs.scheduleDepartmentSelect.onchange = () => {
                        this.setScheduleField('scheduleDepartmentId', this.nullableInt(this.$refs.scheduleDepartmentSelect.value));
                        this.filterScheduleModalOptions();
                    };
                    this.$refs.scheduleAcademicYearSelect.onchange = () => {
                        this.setScheduleField('scheduleAcademicYearId', this.nullableInt(this.$refs.scheduleAcademicYearSelect.value));
                        this.filterScheduleModalOptions();
                    };
                    this.$refs.scheduleSemesterSelect.onchange = () => {
                        this.setScheduleField('scheduleSemesterId', this.nullableInt(this.$refs.scheduleSemesterSelect.value));
                        this.filterScheduleModalOptions();
                    };
                    this.$refs.scheduleCourseSelect.onchange = () => {
                        this.setScheduleField('scheduleCourseId', this.nullableInt(this.$refs.scheduleCourseSelect.value));
                        this.filterScheduleModalOptions();
                    };
                    this.$refs.scheduleTeacherSelect.onchange = () => this.setScheduleField('scheduleTeacherId', this.nullableInt(this.$refs.scheduleTeacherSelect.value));
                    this.$refs.scheduleClassSelect.onchange = () => this.setScheduleField('scheduleClassId', this.nullableInt(this.$refs.scheduleClassSelect.value));
                    this.$refs.scheduleDaySelect.onchange = () => this.setScheduleField('scheduleDay', this.$refs.scheduleDaySelect.value || null);

                    this.filterScheduleModalOptions();
                    this.syncScheduleModalValues();
                });
            },
            setScheduleField(field, value) {
                this.$wire.set(field, value, false);
            },
            syncScheduleModalValues() {
                this.setScheduleField('scheduleDepartmentId', this.nullableInt(this.$refs.scheduleDepartmentSelect?.value));
                this.setScheduleField('scheduleAcademicYearId', this.nullableInt(this.$refs.scheduleAcademicYearSelect?.value));
                this.setScheduleField('scheduleSemesterId', this.nullableInt(this.$refs.scheduleSemesterSelect?.value));
                this.setScheduleField('scheduleCourseId', this.nullableInt(this.$refs.scheduleCourseSelect?.value));
                this.setScheduleField('scheduleTeacherId', this.nullableInt(this.$refs.scheduleTeacherSelect?.value));
                this.setScheduleField('scheduleClassId', this.nullableInt(this.$refs.scheduleClassSelect?.value));
                this.setScheduleField('scheduleDay', this.$refs.scheduleDaySelect?.value || null);
            },
            syncFormFromLivewire() {
                this.$nextTick(() => {
                    if (this.$refs.scheduleDepartmentSelect) {
                        this.$refs.scheduleDepartmentSelect.value = this.$wire.scheduleDepartmentId || '';
                    }
                    if (this.$refs.scheduleAcademicYearSelect) {
                        this.$refs.scheduleAcademicYearSelect.value = this.$wire.scheduleAcademicYearId || '';
                    }
                    if (this.$refs.scheduleSemesterSelect) {
                        this.$refs.scheduleSemesterSelect.value = this.$wire.scheduleSemesterId || '';
                    }
                    if (this.$refs.scheduleCourseSelect) {
                        this.$refs.scheduleCourseSelect.value = this.$wire.scheduleCourseId || '';
                    }
                    if (this.$refs.scheduleTeacherSelect) {
                        this.$refs.scheduleTeacherSelect.value = this.$wire.scheduleTeacherId || '';
                    }
                    if (this.$refs.scheduleClassSelect) {
                        this.$refs.scheduleClassSelect.value = this.$wire.scheduleClassId || '';
                    }
                    if (this.$refs.scheduleDaySelect) {
                        this.$refs.scheduleDaySelect.value = this.$wire.scheduleDay || '';
                    }
                    this.filterScheduleModalOptions();
                });
            },
            filterScheduleModalOptions() {
                const departmentId = this.$refs.scheduleDepartmentSelect?.value || '';
                const academicYearId = this.$refs.scheduleAcademicYearSelect?.value || '';
                const semesterId = this.$refs.scheduleSemesterSelect?.value || '';
                const courseId = this.$refs.scheduleCourseSelect?.value || '';

                this.filterOptions(this.$refs.scheduleTeacherSelect, { departmentId });
                this.filterOptions(this.$refs.scheduleCourseSelect, { departmentId, academicYearId, semesterId });
                this.filterOptions(this.$refs.scheduleClassSelect, { departmentId, academicYearId, semesterId, courseId });
            },
            filterOptions(select, filters) {
                if (! select) {
                    return;
                }

                Array.from(select.options).forEach((option) => {
                    if (! option.value) {
                        option.hidden = false;
                        option.disabled = false;
                        return;
                    }

                    const visible = (! filters.departmentId || ! option.dataset.departmentId || option.dataset.departmentId === filters.departmentId)
                        && (! filters.academicYearId || ! option.dataset.academicYearId || option.dataset.academicYearId === filters.academicYearId)
                        && (! filters.semesterId || ! option.dataset.semesterId || option.dataset.semesterId === filters.semesterId)
                        && (! filters.courseId || ! option.dataset.courseId || option.dataset.courseId === filters.courseId);

                    option.hidden = ! visible;
                    option.disabled = ! visible;
                });

                if (select.selectedOptions[0]?.disabled) {
                    select.value = '';
                    select.dispatchEvent(new Event('change', { bubbles: true }));
                }
            },
            nullableInt(value) {
                return value ? parseInt(value, 10) : null;
            },
            resetScheduleModalUi() {
                this.editScheduleId = null;
                this.scheduleSelects().forEach((element) => {
                    element.value = '';
                });
            },
            closeScheduleModal() {
                this.showCreateScheduleModal = false;
                this.resetScheduleModalUi();
            },
         }"
         x-on:close-create-schedule-modal.window="showCreateScheduleModal = false; resetScheduleModalUi()"
         x-on:open-edit-schedule-modal.window="showCreateScheduleModal = true; editScheduleId = $wire.editScheduleId; initScheduleModal(); syncFormFromLivewire()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                @if(!$isTeacher && !$isStudent)
                    <div class="ss-select2-wrap" wire:ignore x-data="{
                        value: @entangle('department_id'),
                        initSelect2() {
                            let select = window.jQuery(this.$refs.selectElement).select2({
                                theme: 'bootstrap4',
                                width: '100%',
                                placeholder: 'ជ្រើសរើសដេប៉ាតឺម៉ង់ (All Departments)',
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
                            <option value="">ដេប៉ាតឺម៉ង់ (All Departments)</option>
                            @foreach($departments as $dept)
                                <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <div class="ss-select2-wrap" wire:ignore x-data="{
                        value: @entangle('teacher_id'),
                        initSelect2() {
                            let select = window.jQuery(this.$refs.selectElement).select2({
                                theme: 'bootstrap4',
                                width: '100%',
                                placeholder: 'ទាំងអស់ (All Teachers)',
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
                            <option value="">ទាំងអស់ (All Teachers)</option>
                            @foreach($teachers as $teacher)
                                <option value="{{ $teacher->teacher_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
                            @endforeach
                        </select>
                    </div>
                @endif

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
                        @foreach($academicYears as $ay)
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
                        @foreach($semesters as $sem)
                            <option value="{{ $sem->semester_id }}">{{ $sem->semester_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ss-actions-group" style="display: flex; gap: 6px;">
                @if (\App\Filament\Admin\Resources\Schedules\ScheduleResource::canCreate())
                    <button class="ss-tool" type="button" title="បញ្ចូល" x-on:click="showCreateScheduleModal = true; resetScheduleModalUi(); initScheduleModal()">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                @endif

                <button onclick="printTimetable()" class="ss-tool" type="button" title="បោះពុម្ពកាលវិភាគ">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\Schedules\ScheduleResource::canCreate())
            <div class="ss-modal-backdrop"
                 wire:key="create-schedule-modal"
                 x-show="showCreateScheduleModal"
                 x-transition.opacity
                 x-cloak
                 x-on:click.self="closeScheduleModal()"
                 x-on:keydown.escape.window="closeScheduleModal()">
                <form class="ss-modal"
                      x-ref="scheduleModal"
                      wire:submit.prevent="saveSchedule"
                      x-on:click.stop
                      x-show="showCreateScheduleModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <h3 class="ss-modal-title">
                            <i class="fa-solid fas fa-calendar-plus"></i>
                            <span x-text="editScheduleId ? 'កែសម្រួលកាលវិភាគ (Edit Schedule)' : 'បញ្ចូលកាលវិភាគ (Add Schedule)'"></span>
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="closeScheduleModal()">x</button>
                    </div>

                    <div class="ss-modal-body">
                        <label>
                            <span class="ss-modal-label">ដេប៉ាតឺម៉ង់ (Department)</span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleDepartmentSelect" data-placeholder="ជ្រើសរើសដេប៉ាតឺម៉ង់ (Department)">
                                    <option value="">ជ្រើសរើសដេប៉ាតឺម៉ង់ (Department)</option>
                                    @foreach($departments as $department)
                                        <option value="{{ $department->department_id }}">{{ $department->department_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleDepartmentId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ឆ្នាំសិក្សា (Academic Year)</span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleAcademicYearSelect" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សា (Academic Year)">
                                    <option value="">ជ្រើសរើសឆ្នាំសិក្សា (Academic Year)</option>
                                    @foreach($academicYears as $academicYear)
                                        <option value="{{ $academicYear->academic_year_id }}">{{ $academicYear->year_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleAcademicYearId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ឆមាស (Semester)</span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleSemesterSelect" data-placeholder="ជ្រើសរើសឆមាស (Semester)">
                                    <option value="">ជ្រើសរើសឆមាស (Semester)</option>
                                    @foreach($semesters as $semester)
                                        <option value="{{ $semester->semester_id }}">{{ $semester->semester_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleSemesterId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">វគ្គសិក្សា (Course)</span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleCourseSelect" data-placeholder="ជ្រើសរើសវគ្គសិក្សា (Course)">
                                    <option value="">ជ្រើសរើសវគ្គសិក្សា (Course)</option>
                                    @foreach($courses as $course)
                                        <option wire:key="schedule-course-option-{{ $course->course_id }}"
                                                value="{{ $course->course_id }}"
                                                data-department-id="{{ $course->department_id }}"
                                                data-academic-year-id="{{ $course->academic_year_id }}"
                                                data-semester-id="{{ $course->semester_id }}">
                                            {{ trim(($course->course_code ?? '').' - '.$course->course_name, ' -') }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleCourseId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">គ្រូបង្រៀន (Teacher)<span class="ss-required">*</span></span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleTeacherSelect" data-placeholder="ជ្រើសរើសគ្រូបង្រៀន (Teacher)" required>
                                    <option value="">ជ្រើសរើសគ្រូបង្រៀន (Teacher)</option>
                                    @foreach($teachers as $teacher)
                                        <option wire:key="schedule-teacher-option-{{ $teacher->teacher_id }}" value="{{ $teacher->teacher_id }}" data-department-id="{{ $teacher->department_id }}">
                                            {{ trim(($teacher->first_name ?? '').' '.($teacher->last_name ?? '')) }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleTeacherId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ថ្នាក់រៀន (Class)<span class="ss-required">*</span></span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleClassSelect" data-placeholder="ជ្រើសរើសថ្នាក់រៀន (Class)" required>
                                    <option value="">ជ្រើសរើសថ្នាក់រៀន (Class)</option>
                                    @foreach($classRooms as $classRoom)
                                        <option wire:key="schedule-class-option-{{ $classRoom->class_room_id }}" value="{{ $classRoom->class_room_id }}"
                                                data-department-id="{{ $classRoom->course?->department_id }}"
                                                data-academic-year-id="{{ $classRoom->academic_year_id ?? $classRoom->course?->academic_year_id }}"
                                                data-semester-id="{{ $classRoom->course?->semester_id }}"
                                                data-course-id="{{ $classRoom->course_id }}">
                                            {{ $classRoom->class_name }}{{ $classRoom->class_code ? ' - '.$classRoom->class_code : '' }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            @error('scheduleClassId')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ថ្ងៃ (Day)<span class="ss-required">*</span></span>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select class="ss-modal-input" x-ref="scheduleDaySelect" data-placeholder="ជ្រើសរើសថ្ងៃ (Day)" required>
                                    <option value="">ជ្រើសរើសថ្ងៃ (Day)</option>
                                    <option value="monday">ចន្ទ (Monday)</option>
                                    <option value="tuesday">អង្គារ (Tuesday)</option>
                                    <option value="wednesday">ពុធ (Wednesday)</option>
                                    <option value="thursday">ព្រហស្បតិ៍ (Thursday)</option>
                                    <option value="friday">សុក្រ (Friday)</option>
                                    <option value="saturday">សៅរ៍ (Saturday)</option>
                                    <option value="sunday">អាទិត្យ (Sunday)</option>
                                </select>
                            </div>
                            @error('scheduleDay')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ម៉ោងចាប់ផ្តើម (Start Time)<span class="ss-required">*</span></span>
                            <input class="ss-modal-input" type="time" wire:model.defer="scheduleStartTime" required>
                            @error('scheduleStartTime')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>

                        <label>
                            <span class="ss-modal-label">ម៉ោងបញ្ចប់ (End Time)<span class="ss-required">*</span></span>
                            <input class="ss-modal-input" type="time" wire:model.defer="scheduleEndTime" required>
                            @error('scheduleEndTime')<div class="ss-modal-error">{{ $message }}</div>@enderror
                        </label>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeScheduleModal()">ត្រឡប់</button>
                        <button class="ss-modal-add" type="submit" wire:loading.attr="disabled" wire:target="createSchedule">
                            <span wire:loading.remove wire:target="createSchedule">រក្សាទុក</span>
                            <span wire:loading wire:target="createSchedule">កំពុងរក្សាទុក...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div id="print-header-content" class="print-header" style="flex-direction: column; width: 100%; margin-bottom: 5px;">
            <table style="width: 100%; border-collapse: collapse; text-align: center;">
                <tr>
                    <td style="width: 150px; border: 1px solid #000; background-color: #00b0f0; color: white; font-weight: 600; -webkit-print-color-adjust: exact; print-color-adjust: exact;">
                        LMS LOGO
                    </td>
                    <td style="border: 1px solid #000; padding: 10px;">
                        <h2 style="margin: 0; color: #0070c0; font-size: 20px;">
                            @php
                                $selectedDept = collect($departments)->firstWhere('department_id', $department_id);
                                echo $selectedDept ? $selectedDept->department_name : 'Faculty of Information Technology';
                            @endphp
                        </h2>
                        <h3 style="margin: 0; color: #0070c0; font-size: 16px;">
                            Academic Year 
                            @php
                                $selectedYear = collect($academicYears)->firstWhere('academic_year_id', $academic_year_id);
                                echo $selectedYear ? $selectedYear->year_name : '____-____';
                            @endphp
                        </h3>
                        <h3 style="margin: 0; color: #0070c0; font-size: 16px;">
                            @php
                                $selectedSemester = collect($semesters)->firstWhere('semester_id', $semester_id);
                                echo $selectedSemester ? $selectedSemester->semester_name : 'Semester __';
                            @endphp
                        </h3>
                        <h2 style="margin: 0; color: #0070c0; font-size: 18px;">Time Table</h2>
                    </td>
                </tr>
            </table>
            <div style="text-align: right; color: red; font-weight: 600; margin-top: 5px; font-size: 16px;">Room: ___</div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">កាលវិភាគ</div>

            <div class="ss-heading">
                <h2>កាលវិភាគសិក្សា</h2>
                <p>
                    @php
                        $selectedDept = collect($departments)->firstWhere('department_id', $department_id);
                        echo $selectedDept ? $selectedDept->department_name : 'ដេប៉ាតឺម៉ង់ទាំងអស់';
                    @endphp
                </p>
            </div>

            <div id="print-table-content" class="timetable-wrapper">
                <table class="ss-table">
                    <thead>
                        <tr>
                            <th style="width: 120px;">ម៉ោង (Time)</th>
                            <th>ចន្ទ (M)</th>
                            <th>អង្គារ (T)</th>
                            <th>ពុធ (W)</th>
                            <th>ព្រហស្បតិ៍ (TH)</th>
                            <th>សុក្រ (F)</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $hasShownBreak = false;
                        @endphp
                        @forelse($timeSlots as $timeKey => $slotData)
                            @php
                                $startCarbon = \Carbon\Carbon::parse($slotData['start_time']);
                                $isAfternoon = $startCarbon->hour >= 12;
                                
                                if ($isAfternoon && !$hasShownBreak) {
                                    echo '<tr class="break-row"><td colspan="6">សម្រាក / ពេលរសៀល (Afternoon Session)</td></tr>';
                                    $hasShownBreak = true;
                                }
                            @endphp
                            <tr wire:key="schedule-slot-{{ md5($timeKey) }}">
                                <td class="timetable-time">
                                    {{ $startCarbon->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($slotData['end_time'])->format('H:i') }}
                                </td>
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <td>
                                        @if(isset($slotData['days'][$day]))
                                            @foreach($slotData['days'][$day] as $schedule)
                                                <div class="tt-subject" wire:key="schedule-item-{{ $schedule->id }}">
                                                    <a href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('show', ['record' => $schedule]) }}">
                                                        <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                                                            {{ $schedule->classRoom->class_name ?? 'Class' }}
                                                        </div>
                                                        <div style="font-size: 12px; opacity: 0.9;">
                                                            {{ $schedule->course?->course_name ?? $schedule->classRoom?->course?->course_name ?? '-' }}
                                                        </div>
                                                        <div style="font-size: 12px; opacity: 0.85;">
                                                            {{ $schedule->teacher->first_name ?? '' }} {{ $schedule->teacher->last_name ?? '' }}
                                                        </div>
                                                    </a>
                                                    @if(\App\Filament\Admin\Resources\Schedules\ScheduleResource::canEdit($schedule))
                                                        <div class="tt-subject-actions">
                                                            <button class="tt-subject-edit"
                                                                    type="button"
                                                                    x-on:click="$wire.editSchedule({{ $schedule->id }})"
                                                                    title="Edit schedule">
                                                                Edit
                                                            </button>
                                                        </div>
                                                    @endif
                                                </div>
                                            @endforeach
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="text-align: center; padding: 40px; color: #59617e;">
                                    មិនមានទិន្នន័យកាលវិភាគទេ (No schedule data available)
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div id="print-footer-content" class="print-footer" style="width: 100%; justify-content: space-between; margin-top: 30px; font-weight: 600; color: #0070c0; font-size: 14px;">
            <div style="text-align: left;">
                <p style="margin: 0;">Date: {{ date('F d, Y') }}</p>
                <p style="margin: 0;">Vice-Director of Academic Affairs</p>
                <br><br><br>
                <p style="margin: 0;">__________________________</p>
            </div>
            <div style="text-align: right;">
                <p style="margin: 0;">Date: {{ date('F d, Y') }}</p>
                <p style="margin: 0;">Dean of The Faculty</p>
                <br><br><br>
                <p style="margin: 0;">__________________________</p>
            </div>
        </div>
    </div>

    <script>
        window.printTimetable = function() {
            var header = document.getElementById('print-header-content').outerHTML;
            var table = document.getElementById('print-table-content').outerHTML;
            var footer = document.getElementById('print-footer-content').outerHTML;
            
            var printWindow = window.open('', '_blank');
            printWindow.document.write('<html><head><title>Print Timetable</title>');
            printWindow.document.write('<style>');
            printWindow.document.write('body { font-family: "Battambang", "Noto Sans Khmer", sans-serif; background: white; margin: 0; padding: 20px; font-weight: 400; letter-spacing: 0; }');
            printWindow.document.write('a { text-decoration: none; color: inherit; }');
            printWindow.document.write('.timetable-wrapper { margin-top: 20px; border: 1px solid #cbd4ec; border-collapse: collapse; }');
            printWindow.document.write('.ss-table { width: 100%; border-collapse: collapse; font-size: 14px; text-align: center; }');
            printWindow.document.write('.ss-table th, .ss-table td { border: 1px solid #cbd4ec; padding: 12px; }');
            printWindow.document.write('.ss-table th { background-color: #dfe2ff !important; color: #3a405f; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-size: 15px; font-weight: 600; }');
            printWindow.document.write('.break-row td { background-color: #e0f2fe !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; color: #0369a1 !important; font-weight: 600; }');
            printWindow.document.write('.tt-subject { color: #5866f5 !important; font-weight: 400; margin-bottom: 4px; }');
            printWindow.document.write('.tt-subject.afternoon { color: #00b050 !important; }');
            printWindow.document.write('.print-header, .print-footer { display: flex !important; width: 100%; }');
            printWindow.document.write('.print-header { flex-direction: column; margin-bottom: 10px; }');
            printWindow.document.write('.print-footer { flex-direction: row; justify-content: space-between; margin-top: 30px; font-weight: 600; color: #0070c0 !important; font-size: 14px; }');
            printWindow.document.write('@media print { @page { size: landscape; margin: 1cm; } }');
            printWindow.document.write('</' + 'style>');
            printWindow.document.write('</' + 'head><body>');
            printWindow.document.write(header);
            printWindow.document.write(table);
            printWindow.document.write(footer);
            printWindow.document.write('</' + 'body></' + 'html>');
            
            printWindow.document.close();
            printWindow.focus();
            
            setTimeout(function() {
                printWindow.print();
                printWindow.close();
            }, 500);
        }
    </script>
</x-filament-panels::page>
