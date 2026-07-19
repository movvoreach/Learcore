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

        .enrollment-summary-row {
            display: flex;
            justify-content: space-between;
            gap: 14px;
            margin: 0 0 18px;
            color: #59617e;
            font-size: 14px;
            flex-wrap: wrap;
        }

        .enrollment-table-wrap {
            overflow-x: auto;
            border: 1px solid #d6dceb;
            border-radius: 6px;
            background: #fff;
        }

        .enrollment-table {
            width: 100%;
            min-width: 1240px;
            border-collapse: collapse;
            border: 0;
            background: #fff;
            color: #26324d;
            font-size: 14px;
        }

        .enrollment-table th {
            border: 0;
            border-right: 1px solid #cfd6e8;
            border-bottom: 1px solid #b9c3dd;
            background: #dde3ff;
            padding: 14px 12px;
            color: #222b46;
            text-align: left;
            vertical-align: top;
            font-weight: 800;
            line-height: 1.55;
            font-size: 14px;
        }

        .enrollment-table td {
            border: 0;
            border-right: 1px solid #d9deea;
            border-bottom: 1px solid #d9deea;
            padding: 14px 12px;
            vertical-align: middle;
            line-height: 1.65;
            font-size: 14px;
        }

        .enrollment-table th:last-child,
        .enrollment-table td:last-child {
            border-right: 0;
        }

        .enrollment-table tbody tr:last-child td {
            border-bottom: 0;
        }

        .enrollment-table tbody tr:nth-child(even) {
            background: #fbfcff;
        }

        .enrollment-table tbody tr:hover {
            background: #f4f7ff;
        }

        .text-center {
            text-align: center;
        }

        .enrollment-link {
            color: #4459f0;
            font-weight: 800;
            text-decoration: none;
        }

        .enrollment-link:hover {
            color: #2738bc;
            text-decoration: underline;
            text-underline-offset: 3px;
        }

        .muted {
            color: #5f6b84;
            font-size: 12px;
            line-height: 1.55;
        }

        .status-badge {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 82px;
            min-height: 28px;
            border-radius: 4px;
            padding: 4px 8px;
            font-weight: 800;
        }

        .status-studying {
            background: #e0f2fe;
            color: #075985;
        }

        .status-completed {
            background: #dcfce7;
            color: #166534;
        }

        .status-cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .action-row {
            display: flex;
            justify-content: center;
            gap: 8px;
            align-items: center;
        }

        .action-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 34px;
            min-height: 34px;
            border: 0;
            border-radius: 4px;
            color: #fff;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            transition: background .15s ease, transform .15s ease, box-shadow .15s ease;
        }

        .action-btn:hover {
            transform: translateY(-1px);
            filter: brightness(.96);
        }

        .action-btn-green {
            min-width: 112px;
            background: #22c55e;
            box-shadow: 0 6px 14px rgba(34, 197, 94, .18);
        }

        .action-btn-blue {
            background: #5865f2;
            box-shadow: 0 6px 14px rgba(88, 101, 242, .18);
        }

        .w90 {
            width: 104px;
            min-height: 34px;
            border-radius: 4px;
            font-size: 13px;
            font-weight: 800;
        }

        .course-status-badge {
            display: inline-flex !important;
            align-items: center;
            justify-content: center;
            gap: 6px;
            width: 112px;
            min-height: 34px;
            border: 0 !important;
            border-radius: 6px !important;
            padding: 6px 12px !important;
            color: #ffffff !important;
            font-size: 13px;
            font-weight: 700;
            line-height: 1;
            text-decoration: none;
            box-shadow: 0 6px 14px rgba(15, 23, 42, .12);
            transition: background-color .3s ease, color .3s ease, box-shadow .3s ease, transform .3s ease;
        }

        .course-status-badge i {
            font-size: 12px;
            line-height: 1;
        }

        .course-status-badge:hover,
        .course-status-badge:focus-visible {
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 9px 18px rgba(15, 23, 42, .16);
        }

        .course-status-badge:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 3px rgba(77, 182, 242, .24), 0 9px 18px rgba(15, 23, 42, .16);
        }

        .course-status-badge.status-in-progress {
            background: #28a745 !important;
        }

        .course-status-badge.status-complete {
            background: #dc3545 !important;
            font-weight: 800;
        }

        .action-btn-red {
            background: #ef233c;
            box-shadow: 0 6px 14px rgba(239, 35, 60, .18);
        }

        .row-menu {
            position: relative;
            display: inline-flex;
        }

        .row-menu-panel {
            position: absolute;
            top: calc(100% + 6px);
            right: 0;
            z-index: 30;
            width: 210px;
            border: 1px solid #e1e5f0;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 14px 30px rgba(15, 23, 42, .16);
            text-align: left;
            overflow: hidden;
        }

        .row-menu-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            width: 100%;
            min-height: 42px;
            border: 0;
            background: #fff;
            color: #334155;
            padding: 9px 12px;
            text-decoration: none;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
        }

        .row-menu-item:hover {
            background: #f4f6ff;
            color: #2738bc;
        }

        .row-menu-item span {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .row-menu-separator {
            height: 1px;
            margin: 0;
            border: 0;
            background: #e5e7eb;
        }

        .enrollment-pagination {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            border-top: 1px solid #e0e5f1;
            margin-top: 18px;
            padding: 18px 2px 0;
            color: #64708b;
            font-size: 13px;
            font-weight: 600;
        }

        .enrollment-pagination nav {
            min-width: 0;
        }

        .enrollment-pagination .pagination-summary {
            white-space: nowrap;
        }

        .enrollment-pagination .pagination {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 7px;
            margin: 0;
            padding: 0;
            list-style: none;
            flex-wrap: wrap;
        }

        .enrollment-pagination .page-item {
            display: flex;
        }

        .enrollment-pagination .page-link,
        .enrollment-pagination .page-ellipsis {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 36px;
            height: 36px;
            border: 1px solid #dbe2f0;
            border-radius: 5px;
            background: #fff;
            color: #46516d;
            padding: 0 12px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 800;
            line-height: 1;
            box-shadow: 0 1px 2px rgba(44, 50, 89, .05);
            transition: background-color .15s ease, border-color .15s ease, color .15s ease, box-shadow .15s ease, transform .15s ease;
        }

        .enrollment-pagination .page-link:hover {
            border-color: #8791ff;
            background: #f4f6ff;
            color: #3542d8;
            box-shadow: 0 8px 18px rgba(79, 94, 247, .12);
            transform: translateY(-1px);
        }

        .enrollment-pagination .page-link:focus-visible {
            outline: 0;
            border-color: #5865f2;
            box-shadow: 0 0 0 3px rgba(88, 101, 242, .2);
        }

        .enrollment-pagination .pager-edge .page-link {
            min-width: 74px;
        }

        .enrollment-pagination .page-item.active .page-link {
            border-color: #5865f2;
            background: #5865f2;
            color: #fff;
            box-shadow: 0 10px 20px rgba(88, 101, 242, .24);
            transform: none;
        }

        .enrollment-pagination .page-item.disabled .page-link {
            cursor: not-allowed;
            border-color: #e5eaf3;
            background: #f8fafc;
            color: #a3adbd;
            box-shadow: none;
            transform: none;
        }

        .enrollment-pagination .page-ellipsis {
            border-color: transparent;
            background: transparent;
            color: #98a2b3;
            padding: 0 4px;
            box-shadow: none;
        }

        .empty-state {
            padding: 42px 18px;
            color: #68738a;
            text-align: center;
            font-size: 15px;
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

        .dark .enrollment-pagination {
            border-top-color: #334155;
            color: #cbd5e1;
        }

        .dark .enrollment-pagination .page-link {
            border-color: #334155;
            background: #0f172a;
            color: #d8dee9;
            box-shadow: none;
        }

        .dark .enrollment-pagination .page-link:hover {
            border-color: #6875f5;
            background: #172554;
            color: #ffffff;
        }

        .dark .enrollment-pagination .page-item.active .page-link {
            border-color: #6875f5;
            background: #6875f5;
            color: #ffffff;
        }

        .dark .enrollment-pagination .page-item.disabled .page-link {
            border-color: #263244;
            background: #111827;
            color: #64748b;
        }

        .dark .enrollment-pagination .page-ellipsis {
            color: #64748b;
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

        .ss-modal-submit-green {
            background: #22c55e;
            box-shadow: 0 8px 18px rgba(34, 197, 94, .2);
        }

        .ss-modal-cancel {
            background: #eef0f7;
            color: #59617e;
        }

        .ss-modal-cancel-dark {
            width: 100px;
            background: #1f2937;
            color: #fff;
        }

        .quick-enroll-modal {
            width: min(760px, 100%);
        }

        .quick-enroll-modal .ss-modal-grid > div:not(.quick-enroll-field) {
            display: none;
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

            .enrollment-pagination {
                align-items: flex-start;
                flex-direction: column;
            }

            .enrollment-pagination .pagination-summary {
                white-space: normal;
            }

            .enrollment-pagination .pagination {
                justify-content: flex-start;
            }

            .enrollment-pagination .page-link,
            .enrollment-pagination .page-ellipsis {
                min-width: 34px;
                height: 34px;
                padding: 0 10px;
            }

            .enrollment-pagination .pager-edge .page-link {
                min-width: 64px;
            }
        }

        /* Hide default Filament header actions globally on this page */
        .fi-header-actions,
        .fi-page-header-actions {
            display: none !important;
        }
    </style>

    <div class="enrollments-list-show"
         x-data="{
            showCreateEnrollmentModal: @js($showCreateEnrollmentModal),
            openEnrollmentModal(courseId = null, classRoomId = null, academicYearId = null, semesterId = null) {
                $wire.enrollmentCourseId = courseId;
                $wire.enrollmentClassRoomId = classRoomId;
                $wire.enrollmentAcademicYearId = academicYearId;
                $wire.enrollmentSemesterId = semesterId;
                $wire.enrollmentStudentCode = '';
                $wire.enrollmentStudentId = null;
                this.showCreateEnrollmentModal = true;
                this.$nextTick(() => {
                    if (this.$refs.enrollmentQuickCourseSelect && courseId) {
                        this.$refs.enrollmentQuickCourseSelect.value = courseId;
                    }

                    this.initQuickEnrollmentSelects();
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
            initQuickEnrollmentSelects() {
                if (! window.jQuery || ! window.jQuery.fn.select2 || ! this.$refs.enrollmentModal) {
                    this.$refs.enrollmentQuickStudentSelect?.focus();
                    return;
                }

                [
                    this.$refs.enrollmentQuickStudentSelect,
                    this.$refs.enrollmentQuickCourseSelect,
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
                        allowClear: false,
                    });
                });

                window.jQuery(this.$refs.enrollmentQuickStudentSelect).trigger('change.select2').select2('open');
            },
            async submitEnrollment() {
                $wire.showCreateEnrollmentModal = true;
                $wire.enrollmentStudentId = this.nullableInt(this.$refs.enrollmentQuickStudentSelect?.value);
                $wire.enrollmentCourseId = this.nullableInt(this.$refs.enrollmentQuickCourseSelect?.value) || $wire.enrollmentCourseId;
                await $wire.createEnrollmentByStudentCode();
            },
         }"
         x-init="$nextTick(() => { if (showCreateEnrollmentModal) initQuickEnrollmentSelects() })"
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
                            placeholder: 'ជ្រើសរើសឆ្នាំសិក្សា (All Academic Years)',
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
                        <option value="">ជ្រើសរើសឆ្នាំសិក្សា (All Academic Years)</option>
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
                            placeholder: 'ជ្រើសរើសឆមាស (All Semesters)',
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
                        <option value="">ជ្រើសរើសឆមាស (All Semesters)</option>
                        @foreach(\App\Models\Semester::all() as $sem)
                            <option value="{{ $sem->semester_id }}">{{ $sem->semester_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ss-actions-group" >
                @if (\App\Filament\Admin\Resources\Enrollments\EnrollmentResource::canCreate())
                    <button class="ss-tool" type="button" title="បញ្ចូលការចុះឈ្មោះ" x-on:click="openEnrollmentModal()">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="ss-card">

            <div class="ss-heading">
                <h2>បញ្ជីការចុះឈ្មោះ</h2>
            </div>

            <div>
                <div class="enrollment-summary-row">
                    <div>
                        <strong>សរុប:</strong> {{ $totalEnrollments }} enrollments ·
                        <strong>កំពុងសិក្សា:</strong> {{ $studyingEnrollments }} ·
                        <strong>បានបញ្ចប់:</strong> {{ $completedEnrollments }}
                    </div>
                    <div>បង្ហាញ 10 records first · enroll students to online courses</div>
                </div>

                @if($enrollments->isEmpty())
                    <div class="empty-state">មិនមានការចុះឈ្មោះត្រូវបង្ហាញទេ</div>
                @else
                    <div class="enrollment-table-wrap">
                        <table class="enrollment-table">
                            <thead>
                                <tr>
                                    <th class="text-center">No.<br><span class="muted">Code</span></th>
                                    <th>Student<br><span class="muted">Department</span></th>
                                    <th>Online Course<br><span class="muted">Course Information</span></th>
                                    <th>Class / Academic Year<br><span class="muted">Semester</span></th>
                                    <th class="text-center">Date<br><span class="muted">Enrolled</span></th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($enrollments as $enrollment)
                                    @php
                                        $student = $enrollment->student;
                                        $course = $enrollment->course;
                                        $studentName = trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')) ?: 'Unknown student';
                                        $status = $enrollment->status ?: 'studying';
                                        $statusLabel = match ($status) {
                                            'completed' => 'បានបញ្ចប់',
                                            'cancelled' => 'បានបោះបង់',
                                            default => 'កំពុងសិក្សា',
                                        };
                                    @endphp

                                    <tr>
                                        <td class="text-center">
                                            <div>{{ $enrollments->firstItem() + $loop->index }}</div>
                                            <div class="muted">{{ $student?->student_code ?? str_pad((string) $enrollment->enrollment_id, 4, '0', STR_PAD_LEFT) }}</div>
                                        </td>
                                        <td>
                                            @if($student)
                                                <a class="enrollment-link" href="{{ \App\Filament\Admin\Resources\Students\StudentResource::getUrl('edit', ['record' => $student->student_id]) }}">
                                                    {{ $studentName }}
                                                </a>
                                            @else
                                                <span>{{ $studentName }}</span>
                                            @endif
                                            <div class="muted">{{ $student?->department?->department_name ?? '-' }}</div>
                                        </td>
                                        <td>
                                            @if($course)
                                                <a class="enrollment-link" href="{{ \App\Filament\Admin\Pages\CourseStudents::getUrl(['course' => $course->course_id]) }}">
                                                    {{ $course->course_name }}
                                                </a>
                                            @else
                                                <span>No course</span>
                                            @endif
                                            <div class="muted">{{ $course?->course_code ?? '-' }} · {{ $course?->department?->department_name ?? 'Online course' }}</div>
                                        </td>
                                        <td>
                                            <div>{{ $enrollment->classRoom?->class_name ?? 'Online course' }}</div>
                                            <div class="muted">{{ $enrollment->academicYear?->year_name ?? '-' }} · {{ $enrollment->semester?->semester_name ?? '-' }}</div>
                                        </td>
                                        <td class="text-center">{{ $enrollment->enrollment_date?->format('m/d/Y') ?? '-' }}</td>
                                            <td style="text-align: center; vertical-align: middle">
                                                @if($status === 'studying')
                                                    <button type="button" class="btn course-status-badge status-in-progress" id="BtChangeStatus" value="{{ $enrollment->enrollment_id }}">
                                                        <i class="fa fa-spinner"></i> កំពុងសិក្សា
                                                    </button>
                                                @else
                                                    <button type="button" class="btn course-status-badge status-complete" id="BtChangeStatus" value="{{ $enrollment->enrollment_id }}">
                                                        <i class="fa fa-check-circle"></i> បញ្ចប់
                                                    </button>
                                                @endif
                                            </td>
                                        <td class="text-center">
                                            <div class="action-row">
                                                <div class="row-menu" x-data="{ open: false }" x-on:click.outside="open = false">
                                                    <button type="button"
                                                            class="action-btn action-btn-blue"
                                                            id="dropdownMenuLink{{ $enrollment->enrollment_id }}"
                                                            x-on:click="open = ! open"
                                                            aria-haspopup="true"
                                                            x-bind:aria-expanded="open.toString()"
                                                            title="More actions">
                                                        <i class="fas fa-ellipsis-v"></i>
                                                    </button>

                                                    <div class="row-menu-panel"
                                                         x-show="open"
                                                         x-transition
                                                         x-cloak
                                                         aria-labelledby="dropdownMenuLink{{ $enrollment->enrollment_id }}">
                                                        @if($course)
                                                            <a class="row-menu-item" href="{{ \App\Filament\Admin\Pages\CourseStudents::getUrl(['course' => $course->course_id]) }}">
                                                                <span><i class="fas fa-users"></i> និស្សិតក្នុងវគ្គ</span>
                                                                <i class="fas fa-chevron-right"></i>
                                                            </a>

                                                            <hr class="row-menu-separator">
                                                        @endif

                                                        <a class="row-menu-item" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('show', ['record' => $enrollment->enrollment_id]) }}">
                                                            <span><i class="fas fa-eye"></i> មើល</span>
                                                            <i class="fas fa-chevron-right"></i>
                                                        </a>

                                                        <hr class="row-menu-separator">

                                                        <button type="button" class="row-menu-item" x-on:click="open = false; openEnrollmentModal(@js($course?->course_id), @js($enrollment->class_room_id), @js($enrollment->academic_year_id), @js($enrollment->semester_id))">
                                                            <span><i class="fa fa-plus-circle" aria-hidden="true"></i> បញ្ចូល</span>
                                                            <i class="fas fa-chevron-right"></i>
                                                        </button>

                                                        <a class="row-menu-item" href="{{ \App\Filament\Admin\Resources\Enrollments\EnrollmentResource::getUrl('edit', ['record' => $enrollment->enrollment_id]) }}">
                                                            <span><i class="fa fa-minus-circle"></i> កែប្រែ</span>
                                                            <i class="fas fa-chevron-right"></i>
                                                        </a>

                                                        <hr class="row-menu-separator">

                                                        @if($course)
                                                            <a class="row-menu-item" href="{{ \App\Filament\Admin\Pages\CourseStudents::getUrl(['course' => $course->course_id]) }}">
                                                                <span><i class="fa fa-file"></i> របាយការណ៍វគ្គ</span>
                                                                <i class="fas fa-chevron-right"></i>
                                                            </a>
                                                        @endif

                                                        <a class="row-menu-item" href="{{ \App\Filament\Admin\Resources\Attendances\AttendanceResource::getUrl('index') }}">
                                                            <span><i class="fa fa-file"></i> របាយការណ៍វត្តមាន</span>
                                                            <i class="fas fa-chevron-right"></i>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="enrollment-pagination">
                        @php
                            $currentPage = $enrollments->currentPage();
                            $lastPage = $enrollments->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);

                            if ($currentPage <= 3) {
                                $endPage = min($lastPage, 5);
                            }

                            if ($currentPage >= $lastPage - 2) {
                                $startPage = max(1, $lastPage - 4);
                            }
                        @endphp

                        <div class="pagination-summary">
                            បង្ហាញ {{ $enrollments->firstItem() }} ដល់ {{ $enrollments->lastItem() }} នៃ {{ $enrollments->total() }} records
                        </div>
                        <nav aria-label="Enrollment pagination">
                            <ul class="pagination">
                                @if($enrollments->onFirstPage())
                                    <li class="page-item pager-edge disabled"><span class="page-link">Prev</span></li>
                                @else
                                    <li class="page-item pager-edge"><a class="page-link" href="{{ $enrollments->previousPageUrl() }}" rel="prev">Prev</a></li>
                                @endif

                                @if($startPage > 1)
                                    <li class="page-item"><a class="page-link" href="{{ $enrollments->url(1) }}">1</a></li>
                                    @if($startPage > 2)
                                        <li class="page-item" aria-hidden="true"><span class="page-ellipsis">...</span></li>
                                    @endif
                                @endif

                                @foreach(range($startPage, $endPage) as $page)
                                    @if($page === $enrollments->currentPage())
                                        <li class="page-item active" aria-current="page"><span class="page-link">{{ $page }}</span></li>
                                    @else
                                        <li class="page-item"><a class="page-link" href="{{ $enrollments->url($page) }}">{{ $page }}</a></li>
                                    @endif
                                @endforeach

                                @if($endPage < $lastPage)
                                    @if($endPage < $lastPage - 1)
                                        <li class="page-item" aria-hidden="true"><span class="page-ellipsis">...</span></li>
                                    @endif
                                    <li class="page-item"><a class="page-link" href="{{ $enrollments->url($lastPage) }}">{{ $lastPage }}</a></li>
                                @endif

                                @if($enrollments->hasMorePages())
                                    <li class="page-item pager-edge"><a class="page-link" href="{{ $enrollments->nextPageUrl() }}" rel="next">Next</a></li>
                                @else
                                    <li class="page-item pager-edge disabled"><span class="page-link">Next</span></li>
                                @endif
                            </ul>
                        </nav>
                    </div>
                @endif
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\Enrollments\EnrollmentResource::canCreate())
            <div class="ss-modal-backdrop"
                 x-show="showCreateEnrollmentModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeEnrollmentModal()">
                <form class="ss-modal quick-enroll-modal"
                      x-ref="enrollmentModal"
                      x-on:submit.prevent="submitEnrollment()"
                      x-on:click.outside="closeEnrollmentModal()"
                      x-show="showCreateEnrollmentModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <h3 class="ss-modal-title">
                            <span class="ss-modal-plus"><i class="fa-solid fas fa-user-plus"></i></span>
                            បញ្ចូលការចុះឈ្មោះ (Course Enrollment)
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="closeEnrollmentModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-grid">
                            <div class="ss-modal-field--full quick-enroll-field">
                                <label class="ss-modal-label" for="PoliceId_Enroll">លេខសម្គាល់និស្សិត (Student ID) <span class="ss-required">*</span></label>
                                <select id="PoliceId_Enroll"
                                        class="ss-modal-input"
                                        x-ref="enrollmentQuickStudentSelect"
                                        data-placeholder="Search by Student ID, Full Name, or Email">
                                    <option value="">Search by Student ID, Full Name, or Email</option>
                                    @foreach(\App\Models\Student::query()->orderBy('student_code')->orderBy('first_name')->get() as $student)
                                        @php($studentFullName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')))
                                        @php($studentLabel = trim(($student->student_code ?? '').' - '.$studentFullName.' - '.($student->email ?? ''), ' -'))
                                        <option value="{{ $student->student_id }}" @selected((int) $enrollmentStudentId === (int) $student->student_id)>
                                            {{ $studentLabel }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollmentStudentId') <div class="ss-modal-error" id="MsgEnroll">{{ $message }}</div> @enderror
                                @error('enrollmentStudentCode') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full quick-enroll-field">
                                <label class="ss-modal-label" for="quick-enrollment-course-id">Course <span class="ss-required">*</span></label>
                                <select id="quick-enrollment-course-id"
                                        class="ss-modal-input"
                                        x-ref="enrollmentQuickCourseSelect"
                                        data-placeholder="Search by course code or course title">
                                    <option value="">Search by course code or course title</option>
                                    @foreach(\App\Models\Course::query()->orderBy('course_code')->orderBy('course_name')->get() as $course)
                                        <option value="{{ $course->course_id }}" @selected((int) $enrollmentCourseId === (int) $course->course_id)>
                                            {{ trim(($course->course_code ?? '').' - '.$course->course_name, ' -') }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('enrollmentCourseId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>
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
                                <label class="ss-modal-label" for="enrollment-date">កាលបរិច្ឆេទចុះឈ្មោះ</label>
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
                                <label class="ss-modal-label" for="enrollment-note">កំណត់ចំណាំ</label>
                                <textarea id="enrollment-note" class="ss-modal-input" x-ref="enrollmentNoteInput">{{ $enrollmentNote }}</textarea>
                                @error('enrollmentNote') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel ss-modal-cancel-dark" type="button" x-on:click="closeEnrollmentModal()">បោះបង់</button>
                        <button class="ss-modal-submit ss-modal-submit-green" style="width: 120px;" type="submit" wire:loading.attr="disabled" wire:target="createEnrollmentByStudentCode">
                            <span wire:loading.remove wire:target="createEnrollmentByStudentCode"><i class="fa fa-plus-circle" aria-hidden="true"></i> បញ្ចូល</span>
                            <span wire:loading wire:target="createEnrollmentByStudentCode">កំពុងរក្សាទុក...</span>
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

