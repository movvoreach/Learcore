<x-filament-panels::page>
    @include('filament.admin.resources.schedules.partials.schedule-page-scope')

    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    @php
        $classRoom = $schedule->classRoom;
        $course = $schedule->course ?? $classRoom?->course;
        $teacher = $schedule->teacher;
        $teacherName = $teacher ? trim(($teacher->first_name ?? '').' '.($teacher->last_name ?? '')) : '-';
        $timeLabel = \Carbon\Carbon::parse($schedule->start_time)->format('H:i').' - '.\Carbon\Carbon::parse($schedule->end_time)->format('H:i');
    @endphp

    <style>
        .as-page {
            color: #4a5274;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.6;
            letter-spacing: 0;
        }

        .as-page *,
        .as-page button,
        .as-page input {
            font-family: inherit;
            letter-spacing: 0;
        }

        .as-page .fa,
        .as-page .fas,
        .as-page .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .as-page .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .as-page .fab {
            font-family: "Font Awesome 5 Brands" !important;
            font-weight: 400 !important;
        }

        .as-toolbar,
        .as-filter {
            margin-bottom: 34px;
            padding: 14px 22px;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
        }

        .as-toolbar {
            display: flex;
            justify-content: flex-end;
        }

        .as-print {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 46px;
            height: 36px;
            border: 0;
            background: #24c85a;
            color: #fff;
            cursor: pointer;
        }

        .as-filter-row {
            display: grid;
            grid-template-columns: 190px minmax(120px, 1fr) 150px minmax(160px, 1fr) 112px;
            align-items: center;
        }

        .as-label {
            height: 52px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #ffc84d;
            color: #38405f;
            font-weight: 400;
        }

        .as-input {
            height: 52px;
            border: 1px solid #cfd4ec;
            background: #fff;
            color: #4f5ef7;
            padding: 8px 14px;
            font: inherit;
        }

        .as-input:focus {
            outline: 0;
            border-color: #4f5ef7;
            box-shadow: 0 0 0 2px rgba(79, 94, 247, .16);
        }

        .as-search {
            height: 52px;
            border: 0;
            background: #ffc84d;
            color: #1f2937;
            font-size: 18px;
            cursor: pointer;
        }

        .as-table-wrap {
            overflow-x: auto;
            background: #fff;
        }

        .as-table {
            width: 100%;
            min-width: 1260px;
            border-collapse: collapse;
            border: 1px solid #000;
            background: #fff;
            color: #4a5274;
            font-size: 13px;
        }

        .as-table th,
        .as-table td {
            border: 1px solid #000;
            padding: 5px 7px;
            vertical-align: middle;
        }

        .as-meta td {
            height: 34px;
            font-size: 15px;
        }

        .as-signature {
            height: 90px;
            text-align: center;
            vertical-align: top;
            padding-top: 34px !important;
        }

        .as-student-no {
            width: 34px;
            text-align: center;
        }

        .as-student-name {
            min-width: 210px;
        }

        .as-student-gender {
            width: 42px;
            text-align: center;
        }

        .as-student-code {
            width: 70px;
            text-align: center;
        }

        .as-date-cell {
            width: 28px;
            min-width: 28px;
            text-align: center;
            padding: 4px 2px !important;
        }

        .as-check {
            width: 16px;
            height: 16px;
            accent-color: #24c85a;
            cursor: pointer;
        }

        .as-empty {
            padding: 34px;
            border: 1px dashed #b8bdd5;
            background: #fff;
            text-align: center;
        }

        @media (max-width: 900px) {
            .as-filter-row {
                grid-template-columns: 1fr;
            }
        }

        @media print {
            @page {
                size: A4 landscape;
                margin: 8mm;
            }

            html,
            body {
                width: auto !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                background: #fff !important;
            }

            .fi-sidebar,
            .fi-main-sidebar,
            .fi-topbar,
            .fi-header,
            .fi-breadcrumbs,
            .as-toolbar,
            .as-filter {
                display: none !important;
            }

            .fi-main,
            .fi-page,
            .fi-page-main,
            .fi-page-content,
            .as-page {
                display: block !important;
                width: 100% !important;
                max-width: none !important;
                min-width: 0 !important;
                height: auto !important;
                margin: 0 !important;
                padding: 0 !important;
                overflow: visible !important;
                background: #fff !important;
                box-shadow: none !important;
            }

            .as-table-wrap {
                display: block !important;
                width: 100% !important;
                overflow: visible !important;
                background: #fff !important;
            }

            .as-table {
                width: 100% !important;
                min-width: 0 !important;
                table-layout: fixed;
                border-collapse: collapse !important;
                color: #111827 !important;
                font-size: 8px !important;
                line-height: 1.25 !important;
            }

            .as-table th,
            .as-table td {
                border: 1px solid #000 !important;
                padding: 2px 3px !important;
                color: #111827 !important;
                background: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .as-meta td {
                height: 22px !important;
                font-size: 9px !important;
            }

            .as-signature {
                height: 48px !important;
                padding-top: 18px !important;
            }

            .as-student-no {
                width: 24px !important;
            }

            .as-student-name {
                width: 120px !important;
                min-width: 0 !important;
            }

            .as-student-gender {
                width: 30px !important;
            }

            .as-student-code {
                width: 54px !important;
            }

            .as-date-cell {
                width: auto !important;
                min-width: 0 !important;
                padding: 1px !important;
            }

            .as-check {
                width: 10px !important;
                height: 10px !important;
                margin: 0 !important;
                accent-color: #111827 !important;
            }

            .as-empty {
                display: block !important;
                color: #111827 !important;
            }
        }
    </style>



    <script>
        function printSheet() {
            var table = document.querySelector('.as-page .as-table');
            if (!table) {
                alert('???????????!');
                return;
            }

            // Capture current checkbox states before cloning
            var checks = [];
            table.querySelectorAll('input[type="checkbox"]').forEach(function(cb) {
                checks.push(cb.checked);
            });

            var tableHtml = table.outerHTML;

            // Remove existing print iframe if any
            var old = document.getElementById('as-print-frame');
            if (old) old.parentNode.removeChild(old);

            var iframe = document.createElement('iframe');
            iframe.id = 'as-print-frame';
            iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:1px;height:1px;border:0;visibility:hidden;';
            document.body.appendChild(iframe);

            var fontUrl = '{{ asset("fonts/battambang.css") }}';

            var doc = iframe.contentDocument || iframe.contentWindow.document;
            doc.open();
            doc.write(
                '<!DOCTYPE html>' +
                '<html lang="km"><head>' +
                '<meta charset="utf-8">' +
                '<title>\u1794\u1789\u17d2\u1787\u17b9\u179c\u178f\u17d2\u178f\u1798\u17b6\u1793</title>' +
                '<link rel="stylesheet" href="' + fontUrl + '">' +
                '<style>' +
                'html,body{margin:0;padding:2mm;background:#fff;font-family:"Battambang","Noto Sans Khmer",sans-serif;font-size:9px;color:#111827;}' +
                'table{width:100%;border-collapse:collapse;table-layout:fixed;}' +
                'th,td{border:1px solid #000;padding:2px 3px;vertical-align:middle;color:#111827;background:#fff;}' +
                'tr.as-meta td{height:20px;font-size:9px;}' +
                '.as-date-cell{text-align:center;padding:1px !important;}' +
                '.as-student-no{width:22px;text-align:center;}' +
                '.as-student-name{width:110px;}' +
                '.as-student-gender{width:26px;text-align:center;}' +
                '.as-student-code{width:50px;text-align:center;}' +
                '.as-signature{height:44px;text-align:center;vertical-align:top;padding-top:16px !important;}' +
                'input[type=checkbox]{width:9px;height:9px;accent-color:#111;}' +
                '</' + 'style>' +
                '</' + 'head><body>' +
                tableHtml +
                '</' + 'body></' + 'html>'
            );
            doc.close();

            // Sync checkbox states after writing
            var newChecks = doc.querySelectorAll('input[type="checkbox"]');
            checks.forEach(function(checked, i) {
                if (newChecks[i]) newChecks[i].checked = checked;
            });

            // Wait for font to load then print
            setTimeout(function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
                setTimeout(function() {
                    if (iframe.parentNode) iframe.parentNode.removeChild(iframe);
                }, 2000);
            }, 600);
        }
    </script>


    <div class="as-page">
        <div class="as-toolbar">
            <button class="as-print" type="button" onclick="printSheet()" title="????????">
                <i class="fas fa-print"></i>
            </button>
        </div>


        <div class="as-filter">
            <div class="as-filter-row">
                <label class="as-label" for="days-count">?????????</label>
                <input id="days-count" class="as-input" type="number" min="1" max="62" wire:model.defer="daysCount">

                <label class="as-label" for="start-date">?????????????</label>
                <input id="start-date" class="as-input" type="date" wire:model.defer="startDate">

                <button class="as-search" type="button" wire:click="$refresh" title="???????">
                    <i class="fas fa-search"></i>
                </button>
            </div>
        </div>

        @if($students->isEmpty())
            <div class="as-empty">??????????????????????????????????????????</div>
        @else
            <div class="as-table-wrap">
                <table class="as-table">
                    <tbody>
                        <tr class="as-meta">
                            <td colspan="4">????????????</td>
                            <td colspan="16">????????????: {{ $classRoom?->class_code ?? '-' }}</td>
                            <td colspan="{{ max($dates->count() - 16, 1) }}">?????????: {{ $course?->course_name ?? '-' }}</td>
                        </tr>
                        <tr class="as-meta">
                            <td colspan="4">?????????: {{ $timeLabel }}</td>
                            <td colspan="16">??????????: {{ $teacherName }}</td>
                            <td colspan="{{ max($dates->count() - 16, 1) }}">??: {{ $monthLabel }}</td>
                        </tr>
                        <tr>
                            <td colspan="4" class="as-signature">Instructor's Signature</td>
                            @foreach($dates as $date)
                                <td class="as-date-cell">&nbsp;</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="4" class="as-date-cell">Monthly</td>
                            @foreach($dates as $date)
                                <td class="as-date-cell">{{ $date->format('M') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="4" class="as-date-cell">Weekday</td>
                            @foreach($dates as $date)
                                <td class="as-date-cell">{{ $date->format('D') }}</td>
                            @endforeach
                        </tr>
                        <tr>
                            <td colspan="4" class="as-date-cell">Today's Date</td>
                            @foreach($dates as $date)
                                <td class="as-date-cell">{{ $date->format('j') }}</td>
                            @endforeach
                        </tr>

                        @foreach($students as $student)
                            @php
                                $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-';
                            @endphp
                            <tr>
                                <td class="as-student-no">{{ $loop->iteration }}</td>
                                <td class="as-student-name">{{ $studentName }}</td>
                                <td class="as-student-gender">{{ $student->gender ?? '-' }}</td>
                                <td class="as-student-code">{{ $student->student_code ?? '-' }}</td>
                                @foreach($dates as $date)
                                    @php
                                        $attendanceKey = $student->student_id.'|'.$date->toDateString();
                                        $isPresent = $attendances->has($attendanceKey);
                                    @endphp
                                    <td class="as-date-cell">
                                        <input class="as-check"
                                               type="checkbox"
                                               wire:key="attendance-{{ $student->student_id }}-{{ $date->toDateString() }}"
                                               @checked($isPresent)
                                               wire:change="setAttendance({{ $student->student_id }}, '{{ $date->toDateString() }}', $event.target.checked)">
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</x-filament-panels::page>
