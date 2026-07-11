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

        .fi-header-actions,
        .fi-ac-actions,
        .fi-ac,
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

    <div class="schedule-show">
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
                    <button class="ss-tool" type="button" title="បញ្ចូល" wire:click="mountAction('createSchedule')">
                        <i class="fa fa-plus-circle"></i>
                    </button>
                @endif

                <button onclick="printTimetable()" class="ss-tool" type="button" title="បោះពុម្ពកាលវិភាគ">
                    <i class="fas fa-print"></i>
                </button>
            </div>
        </div>

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
                            <tr>
                                <td class="timetable-time">
                                    {{ $startCarbon->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($slotData['end_time'])->format('H:i') }}
                                </td>
                                @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                                    <td>
                                        @if(isset($slotData['days'][$day]))
                                            @foreach($slotData['days'][$day] as $schedule)
                                                <div class="tt-subject">
                                                    <a href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('show', ['record' => $schedule]) }}">
                                                        <div style="font-weight: 600; font-size: 14px; margin-bottom: 2px;">
                                                            {{ $schedule->classRoom->class_name ?? 'Class' }}
                                                        </div>
                                                        <div style="font-size: 12px; opacity: 0.85;">
                                                            {{ $schedule->teacher->first_name ?? '' }} {{ $schedule->teacher->last_name ?? '' }}
                                                        </div>
                                                    </a>
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
            printWindow.document.write('body { font-family: Battambang, "Noto Sans Khmer", sans-serif; background: white; margin: 0; padding: 20px; font-weight: 400; letter-spacing: 0; }');
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
