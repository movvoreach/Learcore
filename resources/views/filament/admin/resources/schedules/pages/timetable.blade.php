<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    <style>
        .tt-filters,
        .timetable-wrapper,
        .print-header,
        .print-footer {
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.6;
            letter-spacing: 0;
        }

        .tt-filters *,
        .timetable-wrapper *,
        .print-header *,
        .print-footer * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .tt-filters .fa,
        .tt-filters .fas,
        .tt-filters .fa-solid,
        .timetable-wrapper .fa,
        .timetable-wrapper .fas,
        .timetable-wrapper .fa-solid,
        .print-header .fa,
        .print-header .fas,
        .print-header .fa-solid,
        .print-footer .fa,
        .print-footer .fas,
        .print-footer .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .timetable-wrapper {
            overflow-x: auto;
            margin-top: 8px;
            background: #ffffff;
            border: 1px solid #000;
        }
        .timetable-grid {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
            font-weight: 400;
            text-align: center;
            min-width: 800px;
        }
        .timetable-grid th, .timetable-grid td {
            border: 1px solid #000;
            padding: 12px;
            vertical-align: middle;
        }
        .timetable-grid th {
            font-weight: 600;
            color: #000;
            background-color: #ff0000;
            font-size: 16px;
        }
        .timetable-time {
            font-weight: 600;
            color: #000;
            white-space: nowrap;
            width: 120px;
        }
        .tt-subject {
            color: #0070c0;
            margin-bottom: 4px;
        }
        .tt-subject.afternoon {
            color: #00b050;
        }
        .break-row {
            background-color: #00b0f0;
            height: 24px;
        }
        
        /* Filter Styles */
        .tt-filters {
            display: flex;
            gap: 16px;
            margin-bottom: 20px;
            align-items: center;
            flex-wrap: wrap;
        }
        .tt-select {
            padding: 8px 12px;
            border-radius: 8px;
            border: 1px solid #cbd5e1;
            font-size: 14px;
            font-weight: 400;
            color: #334155;
            background: #fff;
            min-width: 200px;
        }
        .dark .timetable-wrapper {
            background: #1e293b;
        }
        .dark .timetable-grid th, .dark .timetable-grid td {
            border-color: #334155;
        }
        .dark .tt-subject { color: #60a5fa; }
        .dark .tt-time { color: #e2e8f0; }

        .print-header, .print-footer { display: none; }
    </style>

    <div class="tt-filters">
        @if(!$isTeacher && !$isStudent)
        <select wire:model.live="department_id" class="tt-select">
            <option value="">ដេប៉ាតឺម៉ង់ (All Departments)</option>
            @foreach($departments as $dept)
                <option value="{{ $dept->department_id }}">{{ $dept->department_name }}</option>
            @endforeach
        </select>
        
        <select wire:model.live="teacher_id" class="tt-select">
            <option value="">ទាំងអស់ (All Teachers)</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->teacher_id }}">{{ $teacher->first_name }} {{ $teacher->last_name }}</option>
            @endforeach
        </select>
        @endif

        <select wire:model.live="academic_year_id" class="tt-select">
            <option value="">ឆ្នាំសិក្សា (All Academic Years)</option>
            @foreach($academicYears as $ay)
                <option value="{{ $ay->academic_year_id }}">{{ $ay->year_name }}</option>
            @endforeach
        </select>

        <select wire:model.live="semester_id" class="tt-select">
            <option value="">ឆមាស (All Semesters)</option>
            @foreach($semesters as $sem)
                <option value="{{ $sem->semester_id }}">{{ $sem->semester_name }}</option>
            @endforeach
        </select>
        
        <button onclick="printTimetable()" style="background-color: #0070c0; color: white; border: none; padding: 9px 15px; border-radius: 8px; cursor: pointer; font-weight: 600;">
            🖨️ Print Schedule
        </button>
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

    <div id="print-table-content" class="timetable-wrapper">
        <table class="timetable-grid">
            <thead>
                <tr>
                    <th>Time</th>
                    <th>M</th>
                    <th>T</th>
                    <th>W</th>
                    <th>TH</th>
                    <th>F</th>
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
                            echo '<tr class="break-row"><td colspan="6" style="text-align: center; font-weight: 600; color: #fff; font-size: 16px;">ពេលរសៀល</td></tr>';
                            $hasShownBreak = true;
                        }
                    @endphp
                    <tr>
                        <td class="timetable-time">
                            {{ $startCarbon->format('g:i') }} - 
                            {{ \Carbon\Carbon::parse($slotData['end_time'])->format('g:i') }}
                        </td>
                        @foreach(['monday', 'tuesday', 'wednesday', 'thursday', 'friday'] as $day)
                            <td>
                                @if(isset($slotData['days'][$day]))
                                    @foreach($slotData['days'][$day] as $schedule)
                                        <div class="tt-subject {{ $isAfternoon ? 'afternoon' : '' }}">
                                            <a href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('show', ['record' => $schedule]) }}" style="text-decoration: none; color: inherit;">
                                                {{ $schedule->classRoom->class_name ?? 'Class' }} ({{ $schedule->teacher->first_name ?? '' }} {{ $schedule->teacher->last_name ?? '' }})
                                            </a>
                                        </div>
                                    @endforeach
                                @endif
                            </td>
                        @endforeach
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" style="text-align: center; padding: 40px;">
                            មិនមានទិន្នន័យកាលវិភាគទេ (No schedule data available)
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
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
            printWindow.document.write('.timetable-wrapper { margin-top: 20px; border: 1px solid #000; border-collapse: collapse; }');
            printWindow.document.write('.timetable-grid { width: 100%; border-collapse: collapse; font-size: 14px; text-align: center; }');
            printWindow.document.write('.timetable-grid th, .timetable-grid td { border: 1px solid #000; padding: 12px; }');
            printWindow.document.write('.timetable-grid th { background-color: #ff0000 !important; color: #000; -webkit-print-color-adjust: exact; print-color-adjust: exact; font-size: 16px; font-weight: 600; }');
            printWindow.document.write('.break-row td { background-color: #00b0f0 !important; -webkit-print-color-adjust: exact; print-color-adjust: exact; color: #fff !important; font-weight: 600; }');
            printWindow.document.write('.tt-subject { color: #0070c0 !important; font-weight: 400; margin-bottom: 4px; }');
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
