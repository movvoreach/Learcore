<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    <style>
        .promotions-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .promotions-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .promotions-list-show .fa,
        .promotions-list-show .fas,
        .promotions-list-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

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

        .ss-actions-group {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .ss-tool {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            min-width: 48px;
            height: 42px;
            border: 0;
            border-radius: 0;
            background: #5866f5;
            color: #f97316;
            font-size: 18px;
            font-weight: 700;
            text-decoration: none;
            cursor: pointer;
            line-height: 1;
            transition: background-color .15s ease, color .15s ease, transform .15s ease;
        }

        .ss-tool:hover {
            background: #4351e6;
            color: #fb923c;
            transform: translateY(-1px);
        }

        .ss-tool i {
            line-height: 1;
        }

        .ss-tool--primary {
            background: #2563eb;
            color: #f97316;
        }

        .ss-tool--primary:hover {
            background: #1d4ed8;
            color: #fb923c;
        }

        .ss-tool--muted {
            background: #4b5563;
            color: #ffffff;
        }

        .ss-tool--muted:hover {
            background: #374151;
            color: #ffffff;
        }

        .ss-tool--success {
            background: #0d9488;
            color: #ffffff;
        }

        .ss-tool--success:hover {
            background: #0f766e;
            color: #ffffff;
        }

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

        .ss-modal-subtitle {
            margin: 4px 0 0;
            color: #7a819f;
            font-size: 13px;
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
            padding: 22px 18px 24px;
        }

        .ss-modal-section {
            margin-bottom: 18px;
        }

        .ss-modal-section:last-child {
            margin-bottom: 0;
        }

        .ss-section-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0 0 10px;
            color: #3a405f;
            font-size: 15px;
            font-weight: 600;
        }

        .ss-modal-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 14px;
        }

        .ss-modal-grid--two {
            grid-template-columns: repeat(2, minmax(0, 1fr));
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

        .ss-modal-input:focus {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        textarea.ss-modal-input {
            min-height: 92px;
            resize: vertical;
        }

        .ss-info-box {
            min-height: 58px;
            border: 1px solid #e1e5f2;
            border-radius: 4px;
            background: #f8f9fd;
            padding: 9px 12px;
        }

        .ss-info-label {
            display: block;
            margin-bottom: 3px;
            color: #7a819f;
            font-size: 12px;
        }

        .ss-info-value {
            display: block;
            color: #3f4566;
            font-size: 14px;
            min-height: 22px;
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

        .ss-select2-wrap .select2-container--open .select2-selection__rendered,
        .ss-select2-wrap .select2-container--focus .select2-selection__rendered {
            color: #4f5ef7 !important;
        }

        .dark .ss-toolbar,
        .dark .ss-card,
        .dark .ss-modal {
            background: #1e293b;
            border: 1px solid #334155;
            box-shadow: none;
            color: #f1f5f9;
        }

        .dark .ss-heading,
        .dark .ss-modal-head,
        .dark .ss-modal-foot {
            border-color: #334155;
        }

        .dark .ss-heading h2,
        .dark .ss-section-title,
        .dark .ss-info-value {
            color: #f1f5f9;
        }

        .dark .ss-modal-label,
        .dark .ss-modal-subtitle,
        .dark .ss-info-label {
            color: #cbd5e1;
        }

        .dark .ss-modal-input,
        .dark .ss-info-box {
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

        .fi-header-actions,
        .fi-page-header-actions {
            display: none !important;
        }

        @media (max-width: 768px) {
            .ss-heading {
                padding-inline: 0;
            }

            .ss-modal-grid,
            .ss-modal-grid--two {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="promotions-list-show"
         x-data="{
            showCreatePromotionModal: @js($showCreatePromotionModal),
            showGroupPromotionModal: @js($showGroupPromotionModal),
            showNextPromotionModal: @js($showNextPromotionModal),
            currentDepartment: '',
            currentYear: '',
            currentSemester: '',
            openPromotionModal() {
                this.showCreatePromotionModal = true;
                this.$nextTick(() => {
                    this.initPromotionSelects();
                    this.updateCurrentStudentInfo();
                    this.filterTargetSemesters();
                });
            },
            closePromotionModal() {
                this.showCreatePromotionModal = false;
            },
            openGroupPromotionModal() {
                this.showGroupPromotionModal = true;
                this.$nextTick(() => {
                    this.initGroupPromotionSelects();
                    this.filterSemesterSelect(this.$refs.groupFromYearSelect, this.$refs.groupFromSemesterSelect);
                    this.filterSemesterSelect(this.$refs.groupToYearSelect, this.$refs.groupToSemesterSelect);
                });
            },
            closeGroupPromotionModal() {
                this.showGroupPromotionModal = false;
            },
            openNextPromotionModal() {
                this.showNextPromotionModal = true;
                this.$nextTick(() => {
                    this.initNextPromotionSelects();
                    this.filterSemesterSelect(this.$refs.nextFromYearSelect, this.$refs.nextFromSemesterSelect);
                });
            },
            closeNextPromotionModal() {
                this.showNextPromotionModal = false;
            },
            initSelect2Elements(elements, modalRef) {
                if (! window.jQuery || ! window.jQuery.fn.select2 || ! modalRef) {
                    return;
                }

                elements.filter(Boolean).forEach((element) => {
                    const select = window.jQuery(element);

                    if (select.hasClass('select2-hidden-accessible')) {
                        select.select2('destroy');
                    }

                    select.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: element.dataset.placeholder || '',
                        dropdownParent: window.jQuery(modalRef),
                        allowClear: element.dataset.allowClear === 'true',
                    });
                });
            },
            initPromotionSelects() {
                this.initSelect2Elements([
                    this.$refs.promotionStudentSelect,
                    this.$refs.promotionToYearSelect,
                    this.$refs.promotionToSemesterSelect,
                ], this.$refs.promotionModal);

                window.jQuery(this.$refs.promotionStudentSelect)
                    .off('change.promotionModal')
                    .on('change.promotionModal', () => this.updateCurrentStudentInfo());

                window.jQuery(this.$refs.promotionToYearSelect)
                    .off('change.promotionModal')
                    .on('change.promotionModal', () => this.filterTargetSemesters());
            },
            initGroupPromotionSelects() {
                this.initSelect2Elements([
                    this.$refs.groupFromDepartmentSelect,
                    this.$refs.groupFromYearSelect,
                    this.$refs.groupFromSemesterSelect,
                    this.$refs.groupToYearSelect,
                    this.$refs.groupToSemesterSelect,
                ], this.$refs.groupPromotionModal);

                window.jQuery(this.$refs.groupFromYearSelect)
                    .off('change.groupPromotionModal')
                    .on('change.groupPromotionModal', () => this.filterSemesterSelect(this.$refs.groupFromYearSelect, this.$refs.groupFromSemesterSelect));

                window.jQuery(this.$refs.groupToYearSelect)
                    .off('change.groupPromotionModal')
                    .on('change.groupPromotionModal', () => this.filterSemesterSelect(this.$refs.groupToYearSelect, this.$refs.groupToSemesterSelect));
            },
            initNextPromotionSelects() {
                this.initSelect2Elements([
                    this.$refs.nextFromDepartmentSelect,
                    this.$refs.nextFromYearSelect,
                    this.$refs.nextFromSemesterSelect,
                ], this.$refs.nextPromotionModal);

                window.jQuery(this.$refs.nextFromYearSelect)
                    .off('change.nextPromotionModal')
                    .on('change.nextPromotionModal', () => this.filterSemesterSelect(this.$refs.nextFromYearSelect, this.$refs.nextFromSemesterSelect));
            },
            updateCurrentStudentInfo() {
                const option = this.$refs.promotionStudentSelect?.selectedOptions?.[0];

                this.currentDepartment = option?.dataset.departmentName || '';
                this.currentYear = option?.dataset.yearName || '';
                this.currentSemester = option?.dataset.semesterName || '';
            },
            filterTargetSemesters() {
                this.filterSemesterSelect(this.$refs.promotionToYearSelect, this.$refs.promotionToSemesterSelect);
            },
            filterSemesterSelect(yearSelect, semesterSelect) {
                if (! semesterSelect) {
                    return;
                }

                const yearId = yearSelect?.value || '';
                let selectedIsVisible = true;

                Array.from(semesterSelect.options).forEach((option) => {
                    if (! option.value) {
                        option.hidden = false;
                        option.disabled = false;
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
            async submitPromotion() {
                $wire.showCreatePromotionModal = true;
                $wire.promotionStudentId = this.nullableInt(this.$refs.promotionStudentSelect?.value);
                $wire.promotionToYearId = this.nullableInt(this.$refs.promotionToYearSelect?.value);
                $wire.promotionToSemesterId = this.nullableInt(this.$refs.promotionToSemesterSelect?.value);
                $wire.promotionNote = this.$refs.promotionNoteInput?.value || null;
                await $wire.createStudentPromotion();
            },
            async submitGroupPromotion() {
                $wire.showGroupPromotionModal = true;
                $wire.groupFromDepartmentId = this.nullableInt(this.$refs.groupFromDepartmentSelect?.value);
                $wire.groupFromYearId = this.nullableInt(this.$refs.groupFromYearSelect?.value);
                $wire.groupFromSemesterId = this.nullableInt(this.$refs.groupFromSemesterSelect?.value);
                $wire.groupToYearId = this.nullableInt(this.$refs.groupToYearSelect?.value);
                $wire.groupToSemesterId = this.nullableInt(this.$refs.groupToSemesterSelect?.value);
                $wire.groupNote = this.$refs.groupNoteInput?.value || null;
                await $wire.createGroupPromotion();
            },
            async submitNextPromotion() {
                $wire.showNextPromotionModal = true;
                $wire.nextFromDepartmentId = this.nullableInt(this.$refs.nextFromDepartmentSelect?.value);
                $wire.nextFromYearId = this.nullableInt(this.$refs.nextFromYearSelect?.value);
                $wire.nextFromSemesterId = this.nullableInt(this.$refs.nextFromSemesterSelect?.value);
                $wire.nextNote = this.$refs.nextNoteInput?.value || null;
                await $wire.createNextPromotion();
            },
         }"
         x-init="$nextTick(() => { if (showCreatePromotionModal) openPromotionModal(); if (showGroupPromotionModal) openGroupPromotionModal(); if (showNextPromotionModal) openNextPromotionModal(); })"
         x-on:close-create-promotion-modal.window="closePromotionModal()"
         x-on:close-group-promotion-modal.window="closeGroupPromotionModal()"
         x-on:close-next-promotion-modal.window="closeNextPromotionModal()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <!-- No filters needed for promotions table -->
            </div>

            <div class="ss-actions-group">
                @if (\App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource::canCreate())
                    <button class="ss-tool ss-tool--primary" type="button" title="ដំឡើងឆមាសនិស្សិត" x-on:click="openPromotionModal()">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                    <button class="ss-tool ss-tool--muted" type="button" title="ដំឡើងឆមាសជាក្រុម" x-on:click="openGroupPromotionModal()">
                        <i class="fa fa-users"></i>
                    </button>
                    <button class="ss-tool ss-tool--success" type="button" title="Promote Group Next" x-on:click="openNextPromotionModal()">
                        <i class="fa fa-arrow-circle-right"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">បញ្ជី</div>

            <div class="ss-heading">
                <h2>ការដំឡើងឆមាសនិស្សិត</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\StudentPromotions\StudentPromotionResource::canCreate())
            <div class="ss-modal-backdrop"
                 x-show="showCreatePromotionModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closePromotionModal()">
                <form class="ss-modal"
                      x-ref="promotionModal"
                      x-on:submit.prevent="submitPromotion()"
                      x-on:click.outside="closePromotionModal()"
                      x-show="showCreatePromotionModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fas fa-level-up-alt"></i></span>
                                ដំឡើងឆមាសនិស្សិត
                            </h3>
                            <p class="ss-modal-subtitle">ជ្រើសនិស្សិតម្នាក់ ហើយកំណត់ឆ្នាំសិក្សា និងឆមាសគោលដៅ។</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="closePromotionModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-user-graduate"></i> ជ្រើសរើសនិស្សិត</h4>
                            <div class="ss-modal-grid">
                                <div class="ss-modal-field--full ss-select2-wrap">
                                    <label class="ss-modal-label" for="promotion-student-id">និស្សិត <span class="ss-required">*</span></label>
                                    <select id="promotion-student-id" class="ss-modal-input" x-ref="promotionStudentSelect" data-placeholder="ជ្រើសរើសនិស្សិត">
                                        <option value="">ជ្រើសរើសនិស្សិត</option>
                                        @foreach(\App\Models\Student::query()->with(['department', 'academicYear', 'semester'])->orderBy('student_code')->get() as $student)
                                            @php($studentName = trim(($student->student_code ?? '').' - '.($student->first_name ?? '').' '.($student->last_name ?? '')))
                                            <option value="{{ $student->student_id }}"
                                                    data-department-name="{{ $student->department?->department_name }}"
                                                    data-year-name="{{ $student->academicYear?->year_name }}"
                                                    data-semester-name="{{ $student->semester?->semester_name }}"
                                                    @selected((int) $promotionStudentId === (int) $student->student_id)>
                                                {{ $studentName }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('promotionStudentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-info-circle"></i> ព័ត៌មានបច្ចុប្បន្ន</h4>
                            <div class="ss-modal-grid">
                                <div class="ss-info-box">
                                    <span class="ss-info-label">ដេប៉ាតឺម៉ង់</span>
                                    <span class="ss-info-value" x-text="currentDepartment || '-'"></span>
                                </div>
                                <div class="ss-info-box">
                                    <span class="ss-info-label">ឆ្នាំសិក្សា</span>
                                    <span class="ss-info-value" x-text="currentYear || '-'"></span>
                                </div>
                                <div class="ss-info-box">
                                    <span class="ss-info-label">ឆមាស</span>
                                    <span class="ss-info-value" x-text="currentSemester || '-'"></span>
                                </div>
                            </div>
                        </div>

                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-bullseye"></i> គោលដៅ</h4>
                            <div class="ss-modal-grid ss-modal-grid--two">
                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="promotion-to-year-id">ឆ្នាំសិក្សាថ្មី <span class="ss-required">*</span></label>
                                    <select id="promotion-to-year-id" class="ss-modal-input" x-ref="promotionToYearSelect" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សាថ្មី">
                                        <option value="">ជ្រើសរើសឆ្នាំសិក្សាថ្មី</option>
                                        @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                            <option value="{{ $academicYear->academic_year_id }}" @selected((int) $promotionToYearId === (int) $academicYear->academic_year_id)>
                                                {{ $academicYear->year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('promotionToYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="promotion-to-semester-id">ឆមាសថ្មី <span class="ss-required">*</span></label>
                                    <select id="promotion-to-semester-id" class="ss-modal-input" x-ref="promotionToSemesterSelect" data-placeholder="ជ្រើសរើសឆមាសថ្មី" @disabled(blank($promotionToYearId))>
                                        <option value="">ជ្រើសរើសឆមាសថ្មី</option>
                                        @foreach(\App\Models\Semester::query()->orderBy('start_date')->orderBy('semester_name')->get() as $semester)
                                            <option value="{{ $semester->semester_id }}" data-year="{{ $semester->academic_year_id }}" @selected((int) $promotionToSemesterId === (int) $semester->semester_id)>
                                                {{ $semester->semester_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('promotionToSemesterId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-modal-field--full">
                                    <label class="ss-modal-label" for="promotion-note">កំណត់សម្គាល់</label>
                                    <textarea id="promotion-note" class="ss-modal-input" x-ref="promotionNoteInput">{{ $promotionNote }}</textarea>
                                    @error('promotionNote') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closePromotionModal()">បោះបង់</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createStudentPromotion">
                            <span wire:loading.remove wire:target="createStudentPromotion">ដំឡើងឆមាស</span>
                            <span wire:loading wire:target="createStudentPromotion">កំពុងដំឡើង...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="ss-modal-backdrop"
                 x-show="showGroupPromotionModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeGroupPromotionModal()">
                <form class="ss-modal"
                      x-ref="groupPromotionModal"
                      x-on:submit.prevent="submitGroupPromotion()"
                      x-on:click.outside="closeGroupPromotionModal()"
                      x-show="showGroupPromotionModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fas fa-users"></i></span>
                                ដំឡើងឆមាសជាក្រុម
                            </h3>
                            <p class="ss-modal-subtitle">ប្រព័ន្ធនឹងដំឡើងឆមាសនិស្សិតទាំងអស់ដែលត្រូវនឹងលក្ខខណ្ឌដើម។ មាតិកាវគ្គសិក្សា មេរៀន មុខវិជ្ជា និងម៉ូឌុល មិនត្រូវបានផ្លាស់ប្តូរទេ។</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="closeGroupPromotionModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-map-marker-alt"></i> ពី</h4>
                            <div class="ss-modal-grid">
                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="group-from-department-id">ដេប៉ាតឺម៉ង់ <span class="ss-required">*</span></label>
                                    <select id="group-from-department-id" class="ss-modal-input" x-ref="groupFromDepartmentSelect" data-placeholder="ជ្រើសរើសដេប៉ាតឺម៉ង់">
                                        <option value="">ជ្រើសរើសដេប៉ាតឺម៉ង់</option>
                                        @foreach(\App\Models\Department::query()->orderBy('department_name')->get() as $department)
                                            <option value="{{ $department->department_id }}" @selected((int) $groupFromDepartmentId === (int) $department->department_id)>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('groupFromDepartmentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="group-from-year-id">ឆ្នាំសិក្សា <span class="ss-required">*</span></label>
                                    <select id="group-from-year-id" class="ss-modal-input" x-ref="groupFromYearSelect" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សា">
                                        <option value="">ជ្រើសរើសឆ្នាំសិក្សា</option>
                                        @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                            <option value="{{ $academicYear->academic_year_id }}" @selected((int) $groupFromYearId === (int) $academicYear->academic_year_id)>
                                                {{ $academicYear->year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('groupFromYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="group-from-semester-id">ឆមាស <span class="ss-required">*</span></label>
                                    <select id="group-from-semester-id" class="ss-modal-input" x-ref="groupFromSemesterSelect" data-placeholder="ជ្រើសរើសឆមាស" @disabled(blank($groupFromYearId))>
                                        <option value="">ជ្រើសរើសឆមាស</option>
                                        @foreach(\App\Models\Semester::query()->orderBy('start_date')->orderBy('semester_name')->get() as $semester)
                                            <option value="{{ $semester->semester_id }}" data-year="{{ $semester->academic_year_id }}" @selected((int) $groupFromSemesterId === (int) $semester->semester_id)>
                                                {{ $semester->semester_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('groupFromSemesterId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>

                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-bullseye"></i> ទៅ</h4>
                            <div class="ss-modal-grid ss-modal-grid--two">
                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="group-to-year-id">ឆ្នាំសិក្សាថ្មី <span class="ss-required">*</span></label>
                                    <select id="group-to-year-id" class="ss-modal-input" x-ref="groupToYearSelect" data-placeholder="ជ្រើសរើសឆ្នាំសិក្សាថ្មី">
                                        <option value="">ជ្រើសរើសឆ្នាំសិក្សាថ្មី</option>
                                        @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                            <option value="{{ $academicYear->academic_year_id }}" @selected((int) $groupToYearId === (int) $academicYear->academic_year_id)>
                                                {{ $academicYear->year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('groupToYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="group-to-semester-id">ឆមាសថ្មី <span class="ss-required">*</span></label>
                                    <select id="group-to-semester-id" class="ss-modal-input" x-ref="groupToSemesterSelect" data-placeholder="ជ្រើសរើសឆមាសថ្មី" @disabled(blank($groupToYearId))>
                                        <option value="">ជ្រើសរើសឆមាសថ្មី</option>
                                        @foreach(\App\Models\Semester::query()->orderBy('start_date')->orderBy('semester_name')->get() as $semester)
                                            <option value="{{ $semester->semester_id }}" data-year="{{ $semester->academic_year_id }}" @selected((int) $groupToSemesterId === (int) $semester->semester_id)>
                                                {{ $semester->semester_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('groupToSemesterId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-modal-field--full">
                                    <label class="ss-modal-label" for="group-note">កំណត់សម្គាល់</label>
                                    <textarea id="group-note" class="ss-modal-input" x-ref="groupNoteInput">{{ $groupNote }}</textarea>
                                    @error('groupNote') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeGroupPromotionModal()">បោះបង់</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createGroupPromotion">
                            <span wire:loading.remove wire:target="createGroupPromotion">ដំឡើងឆមាសជាក្រុម</span>
                            <span wire:loading wire:target="createGroupPromotion">កំពុងដំឡើង...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="ss-modal-backdrop"
                 x-show="showNextPromotionModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeNextPromotionModal()">
                <form class="ss-modal"
                      x-ref="nextPromotionModal"
                      x-on:submit.prevent="submitNextPromotion()"
                      x-on:click.outside="closeNextPromotionModal()"
                      x-show="showNextPromotionModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fas fa-arrow-circle-right"></i></span>
                                Promote Group to Next Semester
                            </h3>
                            <p class="ss-modal-subtitle">Promotes every matching active student to the next semester in sequence while preserving academic history.</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="closeNextPromotionModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-section">
                            <h4 class="ss-section-title"><i class="fa fa-map-marker-alt"></i> Current placement</h4>
                            <div class="ss-modal-grid">
                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="next-from-department-id">Department <span class="ss-required">*</span></label>
                                    <select id="next-from-department-id" class="ss-modal-input" x-ref="nextFromDepartmentSelect" data-placeholder="Select department">
                                        <option value="">Select department</option>
                                        @foreach(\App\Models\Department::query()->orderBy('department_name')->get() as $department)
                                            <option value="{{ $department->department_id }}" @selected((int) $nextFromDepartmentId === (int) $department->department_id)>
                                                {{ $department->department_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nextFromDepartmentId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="next-from-year-id">Academic Year <span class="ss-required">*</span></label>
                                    <select id="next-from-year-id" class="ss-modal-input" x-ref="nextFromYearSelect" data-placeholder="Select academic year">
                                        <option value="">Select academic year</option>
                                        @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                            <option value="{{ $academicYear->academic_year_id }}" @selected((int) $nextFromYearId === (int) $academicYear->academic_year_id)>
                                                {{ $academicYear->year_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nextFromYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-select2-wrap">
                                    <label class="ss-modal-label" for="next-from-semester-id">Semester <span class="ss-required">*</span></label>
                                    <select id="next-from-semester-id" class="ss-modal-input" x-ref="nextFromSemesterSelect" data-placeholder="Select semester" @disabled(blank($nextFromYearId))>
                                        <option value="">Select semester</option>
                                        @foreach(\App\Models\Semester::query()->orderBy('start_date')->orderBy('semester_name')->get() as $semester)
                                            <option value="{{ $semester->semester_id }}" data-year="{{ $semester->academic_year_id }}" @selected((int) $nextFromSemesterId === (int) $semester->semester_id)>
                                                {{ $semester->semester_name }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('nextFromSemesterId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="ss-modal-field--full">
                                    <label class="ss-modal-label" for="next-note">Note</label>
                                    <textarea id="next-note" class="ss-modal-input" x-ref="nextNoteInput">{{ $nextNote }}</textarea>
                                    @error('nextNote') <div class="ss-modal-error">{{ $message }}</div> @enderror
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeNextPromotionModal()">Cancel</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createNextPromotion">
                            <span wire:loading.remove wire:target="createNextPromotion">Promote Group Next</span>
                            <span wire:loading wire:target="createNextPromotion">Promoting...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-filament-panels::page>
