<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    <style>
        .semesters-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .semesters-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .semesters-list-show .fa,
        .semesters-list-show .fas,
        .semesters-list-show .fa-solid {
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
            width: min(760px, 100%);
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

        .ss-modal-input:focus {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        .ss-modal-check {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-height: 42px;
            color: #59617e;
            cursor: pointer;
            user-select: none;
        }

        .ss-modal-check input {
            width: 18px;
            height: 18px;
            accent-color: #5866f5;
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
        .dark .ss-modal-check {
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

            .ss-modal-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>

    <div class="semesters-list-show"
         x-data="{
            showCreateSemesterModal: @js($showCreateSemesterModal),
            openSemesterModal() {
                this.showCreateSemesterModal = true;
                this.$nextTick(() => {
                    this.initAcademicYearSelect();
                });
            },
            closeSemesterModal() {
                this.showCreateSemesterModal = false;
            },
            initAcademicYearSelect() {
                if (! window.jQuery || ! window.jQuery.fn.select2 || ! this.$refs.semesterAcademicYearSelect || ! this.$refs.semesterModal) {
                    return;
                }

                const select = window.jQuery(this.$refs.semesterAcademicYearSelect);

                if (select.hasClass('select2-hidden-accessible')) {
                    select.select2('destroy');
                }

                select.select2({
                    theme: 'bootstrap4',
                    width: '100%',
                    placeholder: this.$refs.semesterAcademicYearSelect.dataset.placeholder || '',
                    dropdownParent: window.jQuery(this.$refs.semesterModal),
                    allowClear: true,
                });
            },
            nullableInt(value) {
                return value ? parseInt(value, 10) : null;
            },
            async submitSemester() {
                $wire.showCreateSemesterModal = true;
                $wire.semesterAcademicYearId = this.nullableInt(this.$refs.semesterAcademicYearSelect?.value);
                $wire.semesterName = this.$refs.semesterNameInput?.value || null;
                $wire.semesterStartDate = this.$refs.semesterStartDateInput?.value || null;
                $wire.semesterEndDate = this.$refs.semesterEndDateInput?.value || null;
                $wire.semesterIsActive = !! this.$refs.semesterIsActiveInput?.checked;
                await $wire.createSemester();
            },
         }"
         x-init="$nextTick(() => { if (showCreateSemesterModal) openSemesterModal() })"
         x-on:close-create-semester-modal.window="closeSemesterModal()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <!-- No filters needed for semesters table -->
            </div>

            <div class="ss-actions-group" style="display: flex; gap: 6px;">
                @if (\App\Filament\Admin\Resources\Semesters\SemesterResource::canCreate())
                    <button class="ss-tool" type="button" x-on:click="openSemesterModal()" title="បញ្ចូលឆមាស">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">បញ្ជី</div>

            <div class="ss-heading">
                <h2>បញ្ជីឆមាស</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\Semesters\SemesterResource::canCreate())
            <div class="ss-modal-backdrop"
                 x-show="showCreateSemesterModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeSemesterModal()">
                <form class="ss-modal"
                      x-ref="semesterModal"
                      x-on:submit.prevent="submitSemester()"
                      x-on:click.outside="closeSemesterModal()"
                      x-show="showCreateSemesterModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <h3 class="ss-modal-title">
                            <span><i class="fa-solid fas fa-plus-circle"></i></span>
                            បញ្ចូលឆមាស
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="closeSemesterModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-grid">
                            <div class="ss-modal-field--full ss-select2-wrap">
                                <label class="ss-modal-label" for="semester-academic-year-id">ឆ្នាំសិក្សា <span class="ss-required">*</span></label>
                                <select id="semester-academic-year-id"
                                        class="ss-modal-input"
                                        x-ref="semesterAcademicYearSelect"
                                        data-placeholder="ជ្រើសរើសឆ្នាំសិក្សា">
                                    <option value="">ជ្រើសរើសឆ្នាំសិក្សា</option>
                                    @foreach(\App\Models\AcademicYear::query()->orderByDesc('start_date')->orderBy('year_name')->get() as $academicYear)
                                        <option value="{{ $academicYear->academic_year_id }}" @selected((int) $semesterAcademicYearId === (int) $academicYear->academic_year_id)>
                                            {{ $academicYear->year_name }}
                                        </option>
                                    @endforeach
                                </select>
                                @error('semesterAcademicYearId') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full">
                                <label class="ss-modal-label" for="semester-name">ឈ្មោះឆមាស <span class="ss-required">*</span></label>
                                <input id="semester-name" class="ss-modal-input" type="text" x-ref="semesterNameInput" value="{{ $semesterName }}" placeholder="ឧ. ឆមាសទី ១">
                                @error('semesterName') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="semester-start-date">ថ្ងៃចាប់ផ្តើម <span class="ss-required">*</span></label>
                                <input id="semester-start-date" class="ss-modal-input" type="date" x-ref="semesterStartDateInput" value="{{ $semesterStartDate }}">
                                @error('semesterStartDate') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="semester-end-date">ថ្ងៃបញ្ចប់ <span class="ss-required">*</span></label>
                                <input id="semester-end-date" class="ss-modal-input" type="date" x-ref="semesterEndDateInput" value="{{ $semesterEndDate }}">
                                @error('semesterEndDate') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full">
                                <label class="ss-modal-check" for="semester-is-active">
                                    <input id="semester-is-active" type="checkbox" x-ref="semesterIsActiveInput" @checked($semesterIsActive)>
                                    <span>កំពុងប្រើប្រាស់</span>
                                </label>
                                @error('semesterIsActive') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeSemesterModal()">បោះបង់</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createSemester">
                            <span wire:loading.remove wire:target="createSemester">រក្សាទុក</span>
                            <span wire:loading wire:target="createSemester">កំពុងរក្សាទុក...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-filament-panels::page>
