<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    @endonce

    <style>
        .academic-years-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .academic-years-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .academic-years-list-show .fa,
        .academic-years-list-show .fas,
        .academic-years-list-show .fa-solid {
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

    <div class="academic-years-list-show"
         x-data="{
            showCreateAcademicYearModal: @js($showCreateAcademicYearModal),
            openAcademicYearModal() {
                this.showCreateAcademicYearModal = true;
                $wire.openCreateAcademicYearModal();
            },
            closeAcademicYearModal() {
                this.showCreateAcademicYearModal = false;
                $wire.closeCreateAcademicYearModal();
            },
            async submitAcademicYear() {
                $wire.showCreateAcademicYearModal = true;
                $wire.academicYearName = this.$refs.academicYearNameInput?.value || null;
                $wire.academicYearStartDate = this.$refs.academicYearStartDateInput?.value || null;
                $wire.academicYearEndDate = this.$refs.academicYearEndDateInput?.value || null;
                $wire.academicYearIsActive = !! this.$refs.academicYearIsActiveInput?.checked;
                await $wire.createAcademicYear();
            },
         }"
         x-on:close-create-academic-year-modal.window="closeAcademicYearModal()">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <!-- No filters needed for academic years table -->
            </div>

            <div class="ss-actions-group" >
                @if (\App\Filament\Admin\Resources\AcademicYears\AcademicYearResource::canCreate())
                    <button class="ss-tool" type="button" x-on:click="openAcademicYearModal()" title="បញ្ចូលឆ្នាំសិក្សា">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </button>
                @endif
            </div>
        </div>

        <div class="ss-card">

            <div class="ss-heading">
                <h2>ឆ្នាំសិក្សា</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>

        @if (\App\Filament\Admin\Resources\AcademicYears\AcademicYearResource::canCreate())
            <div class="ss-modal-backdrop"
                 x-show="showCreateAcademicYearModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="closeAcademicYearModal()">
                <form class="ss-modal"
                      x-ref="academicYearModal"
                      x-on:submit.prevent="submitAcademicYear()"
                      x-on:click.outside="closeAcademicYearModal()"
                      x-show="showCreateAcademicYearModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <h3 class="ss-modal-title">
                            <span><i class="fa-solid fas fa-plus-circle"></i></span>
                            បញ្ចូលឆ្នាំសិក្សា
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="closeAcademicYearModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-grid">
                            <div class="ss-modal-field--full">
                                <label class="ss-modal-label" for="academic-year-name">ឆ្នាំសិក្សា <span class="ss-required">*</span></label>
                                <input id="academic-year-name" class="ss-modal-input" type="text" x-ref="academicYearNameInput" value="{{ $academicYearName }}" placeholder="ឧ. 2026-2027">
                                @error('academicYearName') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="academic-year-start-date">ថ្ងៃចាប់ផ្តើម</label>
                                <input id="academic-year-start-date" class="ss-modal-input" type="date" x-ref="academicYearStartDateInput" value="{{ $academicYearStartDate }}">
                                @error('academicYearStartDate') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div>
                                <label class="ss-modal-label" for="academic-year-end-date">ថ្ងៃបញ្ចប់</label>
                                <input id="academic-year-end-date" class="ss-modal-input" type="date" x-ref="academicYearEndDateInput" value="{{ $academicYearEndDate }}">
                                @error('academicYearEndDate') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="ss-modal-field--full">
                                <label class="ss-modal-check" for="academic-year-is-active">
                                    <input id="academic-year-is-active" type="checkbox" x-ref="academicYearIsActiveInput" @checked($academicYearIsActive)>
                                    <span>កំពុងប្រើប្រាស់</span>
                                </label>
                                @error('academicYearIsActive') <div class="ss-modal-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeAcademicYearModal()">បោះបង់</button>
                        <button class="ss-modal-submit" type="submit" wire:loading.attr="disabled" wire:target="createAcademicYear">
                            <span wire:loading.remove wire:target="createAcademicYear">រក្សាទុក</span>
                            <span wire:loading wire:target="createAcademicYear">កំពុងរក្សាទុក...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif
    </div>
</x-filament-panels::page>
