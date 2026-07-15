<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    @php
        $classRoom = $record;
        $course = $classRoom->course;
        $enrollments = $this->getEnrollments();
        $studentMetrics = $this->getStudentMetrics($enrollments);
        $certificates = $this->getCertificates($enrollments);
        $studentOptions = $this->getStudentOptions();
        $canManageClassStudents = $this->canManageClassStudents();
        $canEditClassScores = $this->canEditClassScores();
        $teacherName = $this->getTeacherName();
        $attendanceSheetUrl = $this->getAttendanceSheetUrl();
    @endphp

    <style>
        .classroom-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .classroom-show *,
        .classroom-show button,
        .classroom-show input,
        .classroom-show select,
        .classroom-show textarea {
            font-family: inherit;
            letter-spacing: 0;
        }

        .classroom-show .fa,
        .classroom-show .fas,
        .classroom-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .ss-toolbar {
            display: flex;
            justify-content: flex-end;
            gap: 6px;
            width: 100%;
            min-height: 64px;
            margin: 0 auto 30px;
            padding: 14px 22px;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
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
        }

        .ss-tool-text {
            gap: 6px;
            padding: 0 14px;
            font-size: 15px;
        }

        .ss-menu-wrap {
            position: relative;
        }

        .ss-action-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 50;
            width: 178px;
            border: 1px solid #e4e7f2;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(31, 41, 55, .12);
        }

        .ss-action-menu button {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
            min-height: 38px;
            border: 0;
            background: #fff;
            color: #3f4566;
            padding: 7px 12px;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }

        .ss-action-menu button:hover {
            background: #f4f6ff;
        }

        .ss-menu-left {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .ss-card {
            position: relative;
            overflow: visible;
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
            background: #f3132e;
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
            border-top: 26px solid #f3132e;
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
            color: #3a405f;
            font-size: 16px;
            line-height: 1.7;
        }

        .ss-meta {
            display: grid;
            grid-template-columns: minmax(240px, 1fr) minmax(240px, 1fr);
            gap: 12px;
            padding: 24px 16px 12px;
            font-size: 16px;
            line-height: 1.9;
        }

        .ss-meta-right {
            text-align: right;
        }

        .ss-table-wrap {
            width: 100%;
            max-width: 100%;
            overflow-x: auto;
            overflow-y: hidden;
            border: 1px solid #111827;
            -webkit-overflow-scrolling: touch;
            scrollbar-gutter: stable;
        }

        .ss-table-wrap::-webkit-scrollbar {
            height: 10px;
        }

        .ss-table-wrap::-webkit-scrollbar-track {
            background: #eef0f7;
        }

        .ss-table-wrap::-webkit-scrollbar-thumb {
            border-radius: 999px;
            background: #9aa2c7;
        }

        .ss-table {
            width: 100%;
            min-width: 1450px;
            border-collapse: collapse;
            border: 0;
            color: #38405f;
            font-size: 14px;
        }

        .ss-table th,
        .ss-table td {
            border: 1px solid #111827;
            padding: 10px;
            vertical-align: middle;
        }

        .ss-table th {
            background: #dfe2ff;
            text-align: left;
            font-size: 14px;
            font-weight: 400;
        }

        .ss-table td {
            background: #fff;
        }

        .ss-center {
            text-align: center;
        }

        .ss-name {
            font-weight: 400;
        }

        .ss-muted {
            display: block;
            margin-top: 2px;
            color: #59617e;
            font-size: 12px;
        }

        .ss-input {
            width: 100%;
            height: 42px;
            border: 1px solid #cfd4ec;
            border-radius: 3px;
            background: #fff;
            color: #59617e;
            padding: 8px 12px;
            text-align: left;
            font: inherit;
            box-shadow: none;
        }

        .ss-score-input {
            min-width: 82px;
            text-align: center;
        }

        .ss-result {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 58px;
            min-height: 28px;
            border-radius: 2px;
            padding: 0 8px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .ss-result.is-pass {
            background: #dcfce7;
            color: #166534;
        }

        .ss-result.is-fail {
            background: #fee2e2;
            color: #991b1b;
        }

        .ss-check {
            width: 18px;
            height: 18px;
            accent-color: #5866f5;
        }

        .ss-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 32px;
            border: 0;
            border-radius: 2px;
            background: #f3132e;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-more {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 32px;
            border: 0;
            border-radius: 2px;
            background: #5866f5;
            color: #fff;
            font-size: 20px;
            font-weight: 700;
        }

        .ss-certificate-btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 32px;
            border: 0;
            border-radius: 2px;
            background: #16a34a;
            color: #fff;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-cert-status {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 28px;
            border-radius: 2px;
            background: #eef0f7;
            color: #59617e;
            padding: 0 8px;
            font-size: 12px;
            white-space: nowrap;
        }

        .ss-cert-status.is-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .ss-cert-status.is-issued {
            background: #dcfce7;
            color: #166534;
        }

        .ss-certificate-modal {
            width: min(820px, 100%);
        }

        .ss-certificate-list {
            display: grid;
            gap: 10px;
        }

        .ss-certificate-row {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 14px;
            align-items: center;
            border: 1px solid #e1e5f4;
            border-radius: 4px;
            background: #fff;
            padding: 12px 14px;
        }

        .ss-certificate-meta {
            min-width: 0;
        }

        .ss-certificate-actions {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 8px;
        }

        .ss-certificate-request {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-height: 36px;
            border: 0;
            border-radius: 3px;
            background: #16a34a;
            color: #fff;
            padding: 0 12px;
            font-size: 13px;
            cursor: pointer;
        }

        .ss-certificate-blocked {
            color: #7a819f;
            font-size: 12px;
            text-align: right;
        }

        .ss-empty {
            padding: 34px;
            border: 1px dashed #b8bdd5;
            background: #fff;
            color: #59617e;
            text-align: center;
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

        .ss-modal,
        .ss-confirm-modal {
            width: min(640px, 100%);
            border-radius: 4px;
            background: #fff;
            color: #3f4566;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .22);
        }

        .ss-confirm-modal {
            width: min(562px, 100%);
        }

        .ss-modal-head,
        .ss-confirm-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 62px;
            padding: 0 18px;
            border-bottom: 1px solid #e3e5ef;
        }

        .ss-modal-title,
        .ss-confirm-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 19px;
            font-weight: 400;
        }

        .ss-modal-description {
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

        .ss-modal-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .ss-modal-foot,
        .ss-confirm-foot {
            display: flex;
            align-items: center;
            justify-content: flex-end;
            gap: 10px;
            min-height: 62px;
            padding: 0 18px;
            border-top: 1px solid #e3e5ef;
        }

        .ss-modal-cancel,
        .ss-confirm-cancel {
            min-height: 42px;
            border: 0;
            border-radius: 3px;
            background: #2d2d39;
            color: #fff;
            padding: 0 18px;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-modal-add,
        .ss-confirm-delete {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            min-width: 142px;
            min-height: 42px;
            border: 0;
            border-radius: 3px;
            background: #5866f5;
            color: #fff;
            padding: 0 18px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
        }

        .ss-confirm-delete {
            background: #f3132e;
        }

        .ss-confirm-body {
            padding: 19px 18px;
            color: #59617e;
            font-size: 16px;
            line-height: 1.8;
        }

        @media (max-width: 768px) {
            .ss-toolbar {
                margin-bottom: 18px;
                padding: 10px;
            }

            .ss-card {
                padding: 20px 12px;
                overflow: visible;
            }

            .ss-ribbon {
                position: relative;
                left: 0;
                width: 72px;
                height: 66px;
                margin-bottom: 28px;
                padding-top: 20px;
            }

            .ss-ribbon::after {
                bottom: -20px;
                border-left-width: 36px;
                border-right-width: 36px;
                border-top-width: 20px;
            }

            .ss-heading {
                padding: 0 0 14px;
            }

            .ss-heading h2 {
                font-size: 26px;
            }

            .ss-meta {
                grid-template-columns: 1fr;
                padding: 16px 4px 10px;
            }

            .ss-meta-right {
                text-align: left;
            }

            .ss-table-wrap {
                margin: 0 -4px;
                border-radius: 3px;
            }

            .ss-table {
                min-width: 1340px;
                font-size: 12px;
            }

            .ss-table th,
            .ss-table td {
                padding: 7px 6px;
            }

            .ss-table th:nth-child(2),
            .ss-table td:nth-child(2) {
                position: sticky;
                left: 0;
                z-index: 2;
                min-width: 178px;
                box-shadow: 1px 0 0 #111827;
            }

            .ss-table th:nth-child(2) {
                z-index: 3;
            }

            .ss-input {
                height: 36px;
                padding: 6px 8px;
                font-size: 12px;
            }

            .ss-score-input {
                min-width: 68px;
            }

            .ss-result {
                min-width: 50px;
                min-height: 24px;
                font-size: 11px;
            }
        }

        @media print {
            .fi-topbar,
            .fi-sidebar,
            .fi-main-sidebar,
            .fi-header,
            .fi-breadcrumbs,
            .ss-toolbar,
            .ss-modal-backdrop,
            .ss-delete,
            .ss-more {
                display: none !important;
            }

            .ss-card {
                box-shadow: none;
            }

            .ss-table-wrap {
                overflow: visible;
                border: 0;
            }
        }
    </style>

    <div class="classroom-show"
         x-data="{
            showAddStudentModal: false,
            showClassMenu: false,
            showDeleteStudentModal: false,
            showCertificateOverviewModal: false,
            showCertificateRequestModal: false,
            deleteEnrollmentId: null,
            certificateStudentId: null,
            certificateStudentName: '',
            initStudentSelect() {
                this.$nextTick(() => {
                    if (! window.jQuery || ! window.jQuery.fn.select2 || ! this.$refs.studentSelect) {
                        return;
                    }

                    const select = window.jQuery(this.$refs.studentSelect);

                    if (select.hasClass('select2-hidden-accessible')) {
                        select.select2('destroy');
                    }

                    select.select2({
                        theme: 'bootstrap4',
                        width: '100%',
                        placeholder: 'Search by name or student code...',
                        dropdownParent: window.jQuery(this.$refs.addStudentModal),
                    });

                    select.off('change.classStudent').on('change.classStudent', () => {
                        this.$wire.set('studentId', select.val() ? parseInt(select.val(), 10) : null);
                    });
                });
            },
         }"
         @close-add-student-modal.window="
            showAddStudentModal = false;
            if (window.jQuery && $refs.studentSelect) {
                window.jQuery($refs.studentSelect).val('').trigger('change.select2');
            }
        "
         @close-certificate-overview-modal.window="showCertificateOverviewModal = false">
        <div class="ss-toolbar">
            @if($canManageClassStudents)
                <button class="ss-tool" type="button" title="Enroll student" x-on:click="showAddStudentModal = true; initStudentSelect()">
                    <i class="fa fa-plus-circle"></i>
                </button>
            @endif

            <a class="ss-tool" href="{{ \App\Filament\Admin\Resources\ClassRooms\ClassRoomResource::getUrl('index') }}" title="Back">
                <i class="fa fa-minus-circle"></i>
            </a>

            <button class="ss-tool" type="button" title="Certificate requests" x-on:click="showCertificateOverviewModal = true">
                <i class="fa-solid fa-award"></i>
            </button>

            <div class="ss-menu-wrap" x-on:click.outside="showClassMenu = false">
                <button class="ss-tool ss-tool-text" type="button" title="Actions" x-on:click="showClassMenu = ! showClassMenu">
                    Actions <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="ss-action-menu" x-show="showClassMenu" x-transition x-cloak>
                    @if($attendanceSheetUrl)
                        <button type="button" x-on:click="window.location.href = @js($attendanceSheetUrl)">
                            <span class="ss-menu-left"><i class="fas fa-folder"></i> Attendance</span>
                        </button>
                    @endif
                    <button type="button" x-on:click="window.print(); showClassMenu = false">
                        <span class="ss-menu-left"><i class="fas fa-print"></i> Print students</span>
                    </button>
                </div>
            </div>
        </div>

        @if($canManageClassStudents)
            <div class="ss-modal-backdrop"
                 x-show="showAddStudentModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="showAddStudentModal = false">
                <form class="ss-modal"
                      x-ref="addStudentModal"
                      wire:submit.prevent="addStudentToClass"
                      x-on:click.outside="showAddStudentModal = false"
                      x-show="showAddStudentModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fas fa-user-plus"></i></span>
                                Enroll student
                            </h3>
                            <p class="ss-modal-description">Search by name or student code to enroll into this class.</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="showAddStudentModal = false">x</button>
                    </div>

                    <div class="ss-modal-body">
                        <label class="ss-modal-label" for="class-student-id">Student <span class="ss-required">*</span></label>
                        <div class="ss-select2-wrap" wire:ignore>
                            <select id="class-student-id"
                                    class="ss-modal-input"
                                    x-ref="studentSelect"
                                    x-init="initStudentSelect()">
                                <option value="">Search by name or student code...</option>
                                @foreach($studentOptions as $studentOption)
                                    @php
                                        $optionName = trim(($studentOption->first_name ?? '').' '.($studentOption->last_name ?? ''));
                                        $optionLabel = trim(($studentOption->student_code ?? '').' - '.$optionName);
                                    @endphp
                                    <option value="{{ $studentOption->student_id }}">{{ $optionLabel }}</option>
                                @endforeach
                            </select>
                        </div>
                        @error('studentId')
                            <div class="ss-modal-error">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="showAddStudentModal = false">Cancel</button>
                        <button class="ss-modal-add" type="submit" wire:loading.attr="disabled" wire:target="addStudentToClass">
                            <i class="fa fa-plus-circle"></i>
                            <span wire:loading.remove wire:target="addStudentToClass">Enroll student</span>
                            <span wire:loading wire:target="addStudentToClass">Saving...</span>
                        </button>
                    </div>
                </form>
            </div>

            <div class="ss-modal-backdrop"
                 x-show="showDeleteStudentModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="showDeleteStudentModal = false">
                <div class="ss-confirm-modal"
                     x-on:click.outside="showDeleteStudentModal = false"
                     x-show="showDeleteStudentModal"
                     x-transition>
                    <div class="ss-confirm-head">
                        <h3 class="ss-confirm-title">
                            <i class="fas fa-exclamation-triangle"></i>
                            Remove student
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="showDeleteStudentModal = false">x</button>
                    </div>
                    <div class="ss-confirm-body">
                        Are you sure you want to remove this student from the class?
                    </div>
                    <div class="ss-confirm-foot">
                        <button class="ss-confirm-delete"
                                type="button"
                                x-on:click="$wire.removeEnrollment(deleteEnrollmentId); showDeleteStudentModal = false">
                            <i class="fas fa-trash-alt"></i>
                            Remove
                        </button>
                        <button class="ss-confirm-cancel" type="button" x-on:click="showDeleteStudentModal = false">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        @if($canEditClassScores)
            @php
                $eligibleCertificateCount = $enrollments->filter(function ($enrollment) use ($studentMetrics, $certificates): bool {
                    $metrics = $studentMetrics->get($enrollment->student_id, ['score' => null]);
                    $certificate = $certificates->get($enrollment->student_id);

                    return (! $certificate || $certificate->status === 'revoked')
                        && $this->isCertificateEligible($enrollment->status, $metrics['score']);
                })->count();
                $pendingCertificateCount = $certificates->filter(fn ($certificate): bool => $certificate->status === 'pending')->count();
                $issuedCertificateCount = $certificates->filter(fn ($certificate): bool => $certificate->status === 'issued')->count();
            @endphp

            <div class="ss-modal-backdrop"
                 x-show="showCertificateOverviewModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="showCertificateOverviewModal = false">
                <div class="ss-modal ss-certificate-modal"
                     x-on:click.outside="showCertificateOverviewModal = false"
                     x-show="showCertificateOverviewModal"
                     x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span><i class="fa-solid fa-award"></i></span>
                                Certificate requests
                            </h3>
                            <p class="ss-modal-description">Request certificates here. Admin will see pending requests and notifications.</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="showCertificateOverviewModal = false">x</button>
                    </div>

                    <div class="ss-modal-body">
                        @if($enrollments->isEmpty())
                            <div class="ss-empty">No students are enrolled in this class yet.</div>
                        @else
                            <div class="ss-confirm-body" style="padding:0">
                                Send one certificate request for this class. All eligible students will be sent to admin at once.
                                <div class="ss-muted">
                                    New ready: {{ $eligibleCertificateCount }} |
                                    Pending: {{ $pendingCertificateCount }} |
                                    Issued: {{ $issuedCertificateCount }} |
                                    Total students: {{ $enrollments->count() }}
                                </div>
                                <div class="ss-muted">Eligible means completed/pass status and score 50 or higher.</div>
                            </div>
                        @endif
                    </div>

                    <div class="ss-modal-foot">
                        @if(! $enrollments->isEmpty())
                            <button class="ss-modal-add"
                                    type="button"
                                    wire:click="requestClassCertificates"
                                    wire:loading.attr="disabled"
                                    wire:target="requestClassCertificates">
                                <i class="fas fa-paper-plane"></i>
                                <span wire:loading.remove wire:target="requestClassCertificates">Request class</span>
                                <span wire:loading wire:target="requestClassCertificates">Sending...</span>
                            </button>
                        @endif
                        <button class="ss-modal-cancel" type="button" x-on:click="showCertificateOverviewModal = false">Close</button>
                    </div>
                </div>
            </div>

            <div class="ss-modal-backdrop"
                 x-show="showCertificateRequestModal"
                 x-transition.opacity
                 x-cloak
                 x-on:keydown.escape.window="showCertificateRequestModal = false"
                 x-on:close-certificate-request-modal.window="showCertificateRequestModal = false">
                <div class="ss-confirm-modal"
                     x-on:click.outside="showCertificateRequestModal = false"
                     x-show="showCertificateRequestModal"
                     x-transition>
                    <div class="ss-confirm-head">
                        <h3 class="ss-confirm-title">
                            <i class="fas fa-certificate"></i>
                            Request certificate
                        </h3>
                        <button class="ss-modal-close" type="button" x-on:click="showCertificateRequestModal = false">x</button>
                    </div>
                    <div class="ss-confirm-body">
                        Send certificate request to admin for <strong x-text="certificateStudentName"></strong>?
                        <div class="ss-muted">First step only: Admin will review the pending request in Certificates.</div>
                        @error('certificateStudentId')
                            <div class="ss-modal-error">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="ss-confirm-foot">
                        <button class="ss-confirm-delete"
                                style="background:#16a34a"
                                type="button"
                                x-on:click="$wire.requestCertificate(certificateStudentId)">
                            <i class="fas fa-paper-plane"></i>
                            Request
                        </button>
                        <button class="ss-confirm-cancel" type="button" x-on:click="showCertificateRequestModal = false">Cancel</button>
                    </div>
                </div>
            </div>
        @endif

        <div class="ss-card">
            <div class="ss-ribbon">New</div>

            <div class="ss-heading">
                <h2>{{ $classRoom->class_name ?? 'Class students' }}</h2>
                <p>Course: {{ $course?->course_name ?? '-' }}</p>
                <p>Teacher: {{ $teacherName }}</p>
            </div>

            <div class="ss-meta">
                <div>
                    <div>Class ID: {{ str_pad((string) $classRoom->class_room_id, 3, '0', STR_PAD_LEFT) }}</div>
                    <div>Class code: {{ $classRoom->class_code ?? '-' }}</div>
                    <div>Room: {{ $classRoom->room ?? '-' }}</div>
                </div>
                <div class="ss-meta-right">
                    <div>Academic year: {{ $classRoom->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>Semester: {{ $course?->semester?->semester_name ?? '-' }}</div>
                    <div>Total: {{ $enrollments->count() }} students</div>
                </div>
            </div>

            @if($enrollments->isEmpty())
                <div class="ss-empty">No students are enrolled in this class yet.</div>
            @else
                <div class="ss-table-wrap" role="region" aria-label="Class student scores" tabindex="0">
                    <table class="ss-table">
                        <thead>
                            <tr>
                                <th class="ss-center" style="width: 66px;">No.</th>
                                <th style="width: 230px;">Student name - code</th>
                                <th style="width: 150px;">Status</th>
                                <th class="ss-center" style="width: 126px;">Gender</th>
                                <th class="ss-center" style="width: 138px;">Attendance</th>
                                <th class="ss-center" style="width: 112px;">Attendance 10%</th>
                                <th class="ss-center" style="width: 112px;">Attribute 10%</th>
                                <th class="ss-center" style="width: 112px;">Midterm 20%</th>
                                <th class="ss-center" style="width: 130px;">Homework 20%</th>
                                <th class="ss-center" style="width: 112px;">Final 40%</th>
                                <th class="ss-center" style="width: 104px;">Total 100</th>
                                <th class="ss-center" style="width: 92px;">Result</th>
                                <th style="width: 142px;">Note</th>
                                <th class="ss-center" style="width: 74px;">Action</th>
                                <th class="ss-center" style="width: 70px;">More</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($enrollments as $enrollment)
                                @php
                                    $student = $enrollment->student;
                                    $studentName = trim(($student?->first_name ?? '').' '.($student?->last_name ?? '')) ?: '-';
                                    $metrics = $studentMetrics->get($enrollment->student_id, [
                                        'score' => null,
                                        'attendance_score' => 0,
                                        'attribute_score' => 0,
                                        'midterm_score' => 0,
                                        'assignment_score' => 0,
                                        'final_score' => 0,
                                        'result' => 'fail',
                                        'attendance_present' => 0,
                                        'attendance_total' => 0,
                                        'attendance_percent' => 0,
                                    ]);
                                    $certificate = $certificates->get($enrollment->student_id);
                                    $isCertificateEligible = $this->isCertificateEligible($enrollment->status, $metrics['score']);
                                @endphp
                                <tr wire:key="class-enrollment-{{ $enrollment->enrollment_id }}">
                                <td class="ss-center">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="ss-name">{{ $studentName }}</span>
                                    <span class="ss-muted">{{ $student?->student_code ?? '-' }}</span>
                                </td>
                                <td>{{ $enrollment->status ?? '-' }}</td>
                                <td class="ss-center">
                                    <input class="ss-input" type="text" value="{{ $student?->gender ?? '-' }}" readonly>
                                </td>
                                <td class="ss-center">
                                    <span class="ss-name">{{ $metrics['attendance_present'] }}/{{ $metrics['attendance_total'] }}</span>
                                    <span class="ss-muted">{{ $metrics['attendance_percent'] }}%</span>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           value="{{ number_format((float) $metrics['attendance_score'], 2, '.', '') }}"
                                           readonly>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           min="0"
                                           max="10"
                                           step="0.01"
                                           wire:model.lazy="attributeScores.{{ $enrollment->student_id }}"
                                           wire:change="saveGradeScores({{ $enrollment->student_id }})"
                                           @if(! $canEditClassScores) readonly @endif>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           min="0"
                                           max="20"
                                           step="0.01"
                                           wire:model.lazy="midtermScores.{{ $enrollment->student_id }}"
                                           wire:change="saveGradeScores({{ $enrollment->student_id }})"
                                           @if(! $canEditClassScores) readonly @endif>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           value="{{ number_format((float) $metrics['assignment_score'], 2, '.', '') }}"
                                           readonly>
                                    <span class="ss-muted">from submissions</span>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           min="0"
                                           max="40"
                                           step="0.01"
                                           wire:model.lazy="finalScores.{{ $enrollment->student_id }}"
                                           wire:change="saveGradeScores({{ $enrollment->student_id }})"
                                           @if(! $canEditClassScores) readonly @endif>
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-score-input"
                                           type="number"
                                           value="{{ number_format((float) $metrics['score'], 2, '.', '') }}"
                                           readonly>
                                </td>
                                <td class="ss-center">
                                    <span class="ss-result {{ $metrics['result'] === 'pass' ? 'is-pass' : 'is-fail' }}">
                                        {{ $metrics['result'] }}
                                    </span>
                                </td>
                                <td>
                                    <input class="ss-input" type="text" value="{{ $enrollment->note ?? 'Registered' }}" readonly>
                                </td>
                                <td class="ss-center">
                                    @if($canManageClassStudents)
                                        <button class="ss-delete"
                                                type="button"
                                                x-on:click="deleteEnrollmentId = {{ $enrollment->enrollment_id }}; showDeleteStudentModal = true"
                                                title="Remove">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="ss-center">
                                    @if($certificate)
                                        <span class="ss-cert-status {{ $certificate->status === 'issued' ? 'is-issued' : 'is-pending' }}">
                                            {{ $certificate->status }}
                                        </span>
                                    @elseif($canEditClassScores && $isCertificateEligible)
                                        <span class="ss-cert-status is-issued">ready</span>
                                    @else
                                        <span class="ss-more" title="More">...</span>
                                    @endif
                                </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>
</x-filament-panels::page>
