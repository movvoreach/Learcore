<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    @php
        $classRoom = $schedule->classRoom;
        $course = $schedule->course ?? $classRoom?->course;
        $teacher = $schedule->teacher;
        $teacherName = $teacher ? trim(($teacher->first_name ?? '').' '.($teacher->last_name ?? '')) : '-';
        $dayLabel = match ($schedule->day) {
            'monday' => '????',
            'tuesday' => '??????',
            'wednesday' => '???',
            'thursday' => '??????????',
            'friday' => '?????',
            'saturday' => '????',
            'sunday' => '???????',
            default => $schedule->day,
        };
        $timeLabel = \Carbon\Carbon::parse($schedule->start_time)->format('H:i').' - '.\Carbon\Carbon::parse($schedule->end_time)->format('H:i');
    @endphp

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
        .schedule-show input,
        .schedule-show select,
        .schedule-show textarea {
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

        .ss-tool-green {
            background: #22c55e;
        }

        .ss-menu-wrap {
            position: relative;
        }

        .ss-action-menu {
            position: absolute;
            top: calc(100% + 8px);
            right: 0;
            z-index: 50;
            width: 180px;
            border: 1px solid #e4e7f2;
            border-radius: 3px;
            background: #fff;
            box-shadow: 0 12px 28px rgba(31, 41, 55, .12);
        }

        .ss-action-menu a,
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
            text-decoration: none;
            font-size: 14px;
            font-weight: 400;
            cursor: pointer;
        }

        .ss-action-menu a:hover,
        .ss-action-menu button:hover {
            background: #f4f6ff;
        }

        .ss-menu-left {
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .ss-menu-left i {
            width: 14px;
            color: #3f4566;
            text-align: center;
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

        .ss-table {
            width: 100%;
            min-width: 1280px;
            border-collapse: collapse;
            border: 1px solid #111827;
            color: #38405f;
            font-size: 14px;
        }

        .ss-table th,
        .ss-table td {
            border: 1px solid #111827;
            padding: 10px 10px;
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
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-select {
            min-width: 112px;
            background: #fff;
        }

        .ss-check {
            width: 18px;
            height: 18px;
            accent-color: #5866f5;
        }

        .ss-month-attendance {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-width: 220px;
            flex-wrap: wrap;
        }

        .ss-month-day {
            display: inline-flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 3px;
            color: #59617e;
            font-size: 12px;
        }

        .ss-month-date {
            min-width: 24px;
            line-height: 1.2;
        }

        .ss-month-check {
            width: 19px;
            height: 19px;
            accent-color: #16a34a;
            cursor: pointer;
        }

        .ss-month-day.is-present .ss-month-date {
            color: #16a34a;
            font-weight: 700;
        }

        .ss-month-day.is-absent .ss-month-date {
            color: #dc2626;
            font-weight: 700;
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

        .ss-delete[disabled] {
            cursor: not-allowed;
            opacity: .65;
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

        .ss-empty {
            padding: 34px;
            border: 1px dashed #b8bdd5;
            background: #fff;
            color: #59617e;
            text-align: center;
        }

        .ss-print-page {
            display: none;
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
            width: min(640px, 100%);
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

        .ss-modal-description {
            margin: 4px 0 0;
            color: #7a819f;
            font-size: 13px;
            line-height: 1.6;
        }

        .ss-modal-plus {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-radius: 999px;
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
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-modal-field {
            display: block;
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
            transition: border-color .15s ease, box-shadow .15s ease, color .15s ease;
        }

        .ss-modal-input:focus,
        .ss-modal-input.ss-input-active,
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

        .ss-input:focus,
        .ss-input.ss-input-active {
            outline: 0 !important;
            border-color: #4f5ef7 !important;
            color: #4f5ef7 !important;
            box-shadow: 0 0 0 3px rgba(79, 94, 247, .22) !important;
        }

        .ss-modal-error {
            margin-top: 6px;
            color: #dc2626;
            font-size: 13px;
        }

        .ss-modal-add {
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
            transition: background-color .15s ease;
        }

        .ss-modal-add:hover {
            background: #4351e6;
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

        .ss-modal-cancel {
            min-height: 42px;
            border: 0;
            border-radius: 3px;
            background: #eef0f7;
            color: #59617e;
            padding: 0 18px;
            font-size: 14px;
            cursor: pointer;
        }

        .ss-confirm-modal {
            width: min(562px, 100%);
            border-radius: 4px;
            background: #fff;
            color: #3f4566;
            box-shadow: 0 18px 40px rgba(0, 0, 0, .22);
        }

        .ss-confirm-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            min-height: 62px;
            padding: 0 18px;
            border-bottom: 1px solid #e3e5ef;
        }

        .ss-confirm-title {
            display: flex;
            align-items: center;
            gap: 8px;
            margin: 0;
            font-size: 19px;
            font-weight: 400;
        }

        .ss-confirm-title i {
            color: #3f4566;
        }

        .ss-confirm-body {
            padding: 19px 18px;
            border-bottom: 1px solid #e3e5ef;
            color: #59617e;
            font-size: 16px;
            line-height: 1.8;
        }

        .ss-confirm-foot {
            display: flex;
            justify-content: flex-end;
            gap: 9px;
            padding: 18px;
        }

        .ss-confirm-delete,
        .ss-confirm-cancel {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            min-width: 112px;
            height: 46px;
            border: 0;
            color: #fff;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
        }

        .ss-confirm-delete {
            background: #f3132e;
        }

        .ss-confirm-cancel {
            background: #2d2d39;
        }

        @media (max-width: 768px) {
            .ss-toolbar {
                margin-bottom: 18px;
                padding: 10px;
            }

            .ss-card {
                padding: 20px 12px;
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
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            body {
                background: #fff !important;
            }

            .fi-topbar,
            .fi-sidebar,
            .fi-main-sidebar,
            .fi-header,
            .fi-breadcrumbs,
            .ss-toolbar,
            .ss-card,
            .ss-modal-backdrop {
                display: none !important;
            }

            .fi-main,
            .fi-page,
            .fi-page-main,
            .fi-page-content {
                margin: 0 !important;
                padding: 0 !important;
                max-width: none !important;
                background: #fff !important;
                box-shadow: none !important;
            }

            .schedule-show {
                color: #29304f !important;
                background: #fff !important;
            }

            .ss-print-page {
                display: block !important;
                width: 100%;
                margin: 0 auto;
                padding: 0;
                border: 0;
                border-radius: 0;
                background: #fff;
                box-shadow: none;
            }

            .ss-print-header,
            .ss-print-title,
            .ss-print-meta,
            .ss-print-table {
                break-inside: avoid;
            }

            .ss-print-table tr {
                break-inside: avoid;
            }
        }
    </style>

    <script>
        function printList(pageId) {
            var printPage = document.getElementById(pageId);

            if (! printPage) {
                alert('???????????????????????????????!');
                return;
            }

            var old = document.getElementById('ss-print-frame');
            if (old) {
                old.parentNode.removeChild(old);
            }

            var iframe = document.createElement('iframe');
            iframe.id = 'ss-print-frame';
            iframe.style.cssText = 'position:fixed;top:-9999px;left:-9999px;width:1px;height:1px;border:0;visibility:hidden;';
            document.body.appendChild(iframe);

            var fontUrl = '{{ asset("fonts/battambang.css") }}';
            var title = '????????????';
            var doc = iframe.contentDocument || iframe.contentWindow.document;

            doc.open();
            doc.write(
                '<!DOCTYPE html>' +
                '<html lang="km"><head>' +
                '<meta charset="utf-8">' +
                '<title>' + title + '</title>' +
                '<link rel="stylesheet" href="' + fontUrl + '">' +
                '<style>' +
                '@page{size:A4 portrait;margin:10mm 9mm 12mm;}' +
                '*{box-sizing:border-box;letter-spacing:0;}' +
                'html,body{margin:0;padding:0;background:#fff;color:#1f2937;font-family:"Battambang","Noto Sans Khmer","Khmer OS Siemreap",sans-serif;font-size:9px;line-height:1.45;}' +
                '.ss-print-page{display:block;width:100%;min-height:277mm;background:#fff;}' +
                '.ss-print-header{display:grid;grid-template-columns:1fr 1fr;gap:40mm;min-height:47mm;color:#1700b8;text-align:center;}' +
                '.ss-print-header h3{margin:0 0 1mm;font-size:10px;font-weight:700;line-height:1.55;}' +
                '.ss-print-header p{margin:0;font-size:8px;line-height:1.55;}' +
                '.ss-print-line{margin-top:4mm !important;}' +
                '.ss-print-title{text-align:center;color:#1f2937;margin-bottom:5mm;}' +
                '.ss-print-title h2{margin:0;font-size:12px;font-weight:700;line-height:1.4;}' +
                '.ss-print-title p{margin:1mm 0 0;font-size:8px;line-height:1.45;}' +
                '.ss-print-meta{display:grid;grid-template-columns:1fr 1fr;gap:8mm;margin:0 0 2mm;color:#1f2937;font-size:8px;line-height:1.65;}' +
                '.ss-print-meta-right{text-align:right;}' +
                '.ss-print-table{width:100%;border-collapse:collapse;table-layout:fixed;color:#1f2937;font-size:7px;line-height:1.35;}' +
                '.ss-print-table th,.ss-print-table td{border:1px solid #000;padding:1.6mm 1.2mm;vertical-align:middle;background:#fff;color:#1f2937;}' +
                '.ss-print-table th{font-weight:700;text-align:center;}' +
                '.ss-print-center{text-align:center;}' +
                '.ss-print-note{height:6mm;}' +
                '.ss-print-footer{position:fixed;right:0;bottom:-7mm;color:#1f2937;font-size:8px;}' +
                '.ss-print-footer:after{content:counter(page);}' +
                'thead{display:table-header-group;}tr{break-inside:avoid;page-break-inside:avoid;}' +
                '</' + 'style>' +
                '</' + 'head><body>' +
                printPage.outerHTML +
                '</' + 'body></' + 'html>'
            );
            doc.close();

            setTimeout(function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();

                setTimeout(function() {
                    if (iframe.parentNode) {
                        iframe.parentNode.removeChild(iframe);
                    }
                }, 2000);
            }, 600);
        }
    </script>

    <div class="schedule-show"
         x-data="{
            showAddStudentModal: false,
            showScheduleMenu: false,
            showDeleteStudentModal: false,
            deleteStudentId: null,
            setStudentId(value) {
                this.$wire.set('studentId', value, false);
            },
            closeAddStudentModal() {
                this.showAddStudentModal = false;

                if (window.jQuery && this.$refs.studentSelect) {
                    window.jQuery(this.$refs.studentSelect).val('').trigger('change.select2');
                }
            },
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
                        placeholder: '??????????????? ? ???????...',
                        dropdownParent: select.closest('.ss-select2-wrap'),
                    });

                    select.off('change.scheduleStudent').on('change.scheduleStudent', () => {
                        this.setStudentId(select.val() ? parseInt(select.val(), 10) : null);
                    });
                });
            },
         }"
         @close-add-student-modal.window="
            closeAddStudentModal();
        ">
        <div class="ss-toolbar">
          
            @if($canManageScheduleStudents)
                <button class="ss-tool" type="button" title="??????" x-on:click="showAddStudentModal = true; setStudentId(null); initStudentSelect()">
                   <i class="fa fa-plus-circle"></i>
                </button>
            @endif
            @if(\App\Filament\Admin\Resources\Schedules\ScheduleResource::canEdit($schedule))
                <a class="ss-tool"
                   href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('edit', ['record' => $schedule]) }}"
                   title="??????????????">
                    <i class="fa fa-edit"></i>
                </a>
            @endif
            <a class="ss-tool" href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('index') }}" title="??????"><i class="fa fa-minus-circle"></i></a>
            <div class="ss-menu-wrap" x-on:click.outside="showScheduleMenu = false">
                <button class="ss-tool ss-tool-text"
                        type="button"
                        title="??????"
                        x-on:click="showScheduleMenu = ! showScheduleMenu">
                    ?????? <i class="fas fa-ellipsis-v"></i>
                </button>
                <div class="ss-action-menu" x-show="showScheduleMenu" x-transition x-cloak>
                    <button type="button" x-on:click="printList('print-student-page'); showScheduleMenu = false">
                        <span class="ss-menu-left"><i class="fas fa-print"></i> ????????????????????</span>
                    </button>
                    <a href="{{ \App\Filament\Admin\Resources\Schedules\ScheduleResource::getUrl('attendance-sheet', ['record' => $schedule]) }}">
                        <span class="ss-menu-left"><i class="fas fa-folder"></i> ????????????</span>
                        <i class="fas fa-chevron-right"></i>
                    </a>
                    <button type="button" x-on:click="printList('print-score-page'); showScheduleMenu = false">
                        <span class="ss-menu-left"><i class="fas fa-print"></i> ???????????</span>
                    </button>
                    <button type="button" x-on:click="printList('print-task-page'); showScheduleMenu = false">
                        <span class="ss-menu-left"><i class="fas fa-print"></i> ?????????????</span>
                    </button>
                    <button type="button" x-on:click="printList('print-other-page'); showScheduleMenu = false">
                        <span class="ss-menu-left"><i class="fas fa-print"></i> ???????????</span>
                    </button>
                </div>
            </div>
        </div>


        @if($canManageScheduleStudents)
            <div class="ss-modal-backdrop"
                 wire:key="add-student-modal"
                 x-show="showAddStudentModal"
                 x-transition.opacity
                 x-cloak
                 x-on:click.self="closeAddStudentModal()"
                 x-on:keydown.escape.window="closeAddStudentModal()">
                <form class="ss-modal"
                      x-ref="addStudentModal"
                      wire:submit.prevent="addStudentByCode"
                      x-on:click.stop
                      x-show="showAddStudentModal"
                      x-transition>
                    <div class="ss-modal-head">
                        <div>
                            <h3 class="ss-modal-title">
                                <span class="ss-modal-plus"><i class="fa-solid fas fa-user-plus"></i></span>
                                ?????????????
                            </h3>
                            <p class="ss-modal-description">?????????????????????? ? ??????? ???????????????????????????????</p>
                        </div>
                        <button class="ss-modal-close" type="button" x-on:click="closeAddStudentModal()">×</button>
                    </div>

                    <div class="ss-modal-body">
                        <div class="ss-modal-field">
                            <label class="ss-modal-label" for="schedule-student-code">
                                ??????????????? <span class="ss-required">*</span>
                            </label>
                            <div class="ss-select2-wrap" wire:ignore>
                                <select id="schedule-student-code"
                                        class="ss-modal-input"
                                        x-ref="studentSelect"
                                        x-init="initStudentSelect()">
                                    <option value="">??????????????? ? ???????...</option>
                                    @foreach($studentOptions as $studentOption)
                                        @php
                                            $optionName = trim(($studentOption->first_name ?? '').' '.($studentOption->last_name ?? ''));
                                            $optionLabel = trim(($studentOption->student_code ?? '').' - '.$optionName);
                                        @endphp
                                        <option wire:key="schedule-student-option-{{ $studentOption->student_id }}" value="{{ $studentOption->student_id }}">{{ $optionLabel }}</option>
                                    @endforeach
                                </select>
                            </div>
                            @error('studentId')
                                <div class="ss-modal-error">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <div class="ss-modal-foot">
                        <button class="ss-modal-cancel" type="button" x-on:click="closeAddStudentModal()">??????</button>
                        <button class="ss-modal-add" type="submit" wire:loading.attr="disabled" wire:target="addStudentByCode">
                            <i class="fa fa-plus-circle"></i>
                            <span wire:loading.remove wire:target="addStudentByCode">?????????????</span>
                            <span wire:loading wire:target="addStudentByCode">?????????????...</span>
                        </button>
                    </div>
                </form>
            </div>
        @endif

        <div class="ss-modal-backdrop"
             wire:key="delete-student-modal"
             x-show="showDeleteStudentModal"
             x-transition.opacity
             x-cloak
             x-on:click.self="showDeleteStudentModal = false"
             x-on:keydown.escape.window="showDeleteStudentModal = false">
            <div class="ss-confirm-modal" 
                 x-on:click.stop
                 x-show="showDeleteStudentModal"
                 x-transition>
                <div class="ss-confirm-head">
                    <h3 class="ss-confirm-title">
                        <i class="fas fa-exclamation-triangle"></i>
                        ?????
                    </h3>
                    <button class="ss-modal-close" type="button" x-on:click="showDeleteStudentModal = false">×</button>
                </div>
                <div class="ss-confirm-body">
                    ?????????????????????????????????????????????
                </div>
                <div class="ss-confirm-foot">
                    <button class="ss-confirm-delete"
                            type="button"
                            x-on:click="$wire.removeStudent(deleteStudentId); showDeleteStudentModal = false">
                        <i class="fas fa-trash-alt"></i>
                        ???
                    </button>
                    <button class="ss-confirm-cancel" type="button" x-on:click="showDeleteStudentModal = false">
                        ??????
                    </button>
                </div>
            </div>
        </div>

        <div class="ss-print-page" id="print-student-page" aria-hidden="true">
            <div class="ss-print-header">
                <div>
                    <h3>??????????? ????? ???????</h3>
                    <p>????????????????????????? ????????</p>
                    <p>????????????? / ???????????</p>
                    <p class="ss-print-line">???: .................</p>
                </div>
                <div>
                    <h3>?????????????????????</h3>
                    <p>???? ????? ?????????????</p>
                    <p>********</p>
                </div>
            </div>

            <div class="ss-print-title">
                <h2>????????????????</h2>
                <p>?????????: {{ $course?->course_name ?? '-' }}</p>
                <p>??????????: {{ $teacherName }}</p>
            </div>

            <div class="ss-print-meta">
                <div>
                    <div>??????????????: {{ str_pad((string) $schedule->getKey(), 3, '0', STR_PAD_LEFT) }}</div>
                    <div>????????????: {{ $classRoom?->class_code ?? '-' }}</div>
                    <div>?????????: {{ $dayLabel }} ({{ $timeLabel }})</div>
                </div>
                <div class="ss-print-meta-right">
                    <div>???????????: {{ $classRoom?->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>???????????: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    <div>?????: {{ $totalStudents }} ????</div>
                </div>
            </div>

            <table class="ss-print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">??????</th>
                        <th style="width: 10%;">???????</th>
                        <th style="width: 18%;">??????-???</th>
                        <th style="width: 5%;">???</th>
                        <th style="width: 24%;">??????????????? ?????????????</th>
                        <th style="width: 12%;">?????? / ??????</th>
                        <th style="width: 14%;">???????????</th>
                        <th style="width: 12%;">??????</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php
                            $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-';
                        @endphp
                        <tr>
                            <td class="ss-print-center">{{ $loop->iteration }}</td>
                            <td class="ss-print-center">{{ $student->student_code ?? '-' }}</td>
                            <td>{{ $studentName }}</td>
                            <td class="ss-print-center">{{ $student->gender ?? '-' }}</td>
                            <td></td>
                            <td class="ss-print-center">???????</td>
                            <td class="ss-print-center">{{ $student->phone ?? '000 000 000' }}</td>
                            <td></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="ss-print-center ss-print-note">????????????????????????????????????</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

            <div class="ss-print-footer"></div>
        </div>

        {{-- Score List Print Page --}}
        <div class="ss-print-page" id="print-score-page" aria-hidden="true">
            <div class="ss-print-header">
                <div>
                    <h3>??????????? ????? ???????</h3>
                    <p>????????????????????????? ????????</p>
                    <p>????????????? / ???????????</p>
                    <p class="ss-print-line">???: .................</p>
                </div>
                <div>
                    <h3>?????????????????????</h3>
                    <p>???? ????? ?????????????</p>
                    <p>********</p>
                </div>
            </div>
            <div class="ss-print-title">
                <h2>?????????????????</h2>
                <p>?????????: {{ $course?->course_name ?? '-' }}</p>
                <p>??????????: {{ $teacherName }}</p>
            </div>
            <div class="ss-print-meta">
                <div>
                    <div>??????????????: {{ str_pad((string) $schedule->getKey(), 3, '0', STR_PAD_LEFT) }}</div>
                    <div>????????????: {{ $classRoom?->class_code ?? '-' }}</div>
                    <div>?????????: {{ $dayLabel }} ({{ $timeLabel }})</div>
                </div>
                <div class="ss-print-meta-right">
                    <div>???????????: {{ $classRoom?->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>???????????: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    <div>?????: {{ $totalStudents }} ????</div>
                </div>
            </div>
            <table class="ss-print-table">
                <thead>
                    <tr>
                        <th style="width: 6%;">??????</th>
                        <th style="width: 12%;">???????</th>
                        <th style="width: 25%;">??????-???</th>
                        <th style="width: 6%;">???</th>
                        <th style="width: 15%;">??????</th>
                        <th style="width: 15%;">???????</th>
                        <th style="width: 21%;">???????</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-'; @endphp
                        <tr>
                            <td class="ss-print-center">{{ $loop->iteration }}</td>
                            <td class="ss-print-center">{{ $student->student_code ?? '-' }}</td>
                            <td>{{ $studentName }}</td>
                            <td class="ss-print-center">{{ $student->gender ?? '-' }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="ss-print-center ss-print-note">????????????????????????????????????</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="ss-print-footer"></div>
        </div>

        {{-- Task List Print Page --}}
        <div class="ss-print-page" id="print-task-page" aria-hidden="true">
            <div class="ss-print-header">
                <div>
                    <h3>??????????? ????? ???????</h3>
                    <p>????????????????????????? ????????</p>
                    <p>????????????? / ???????????</p>
                    <p class="ss-print-line">???: .................</p>
                </div>
                <div>
                    <h3>?????????????????????</h3>
                    <p>???? ????? ?????????????</p>
                    <p>********</p>
                </div>
            </div>
            <div class="ss-print-title">
                <h2>?????????????</h2>
                <p>?????????: {{ $course?->course_name ?? '-' }}</p>
                <p>??????????: {{ $teacherName }}</p>
            </div>
            <div class="ss-print-meta">
                <div>
                    <div>??????????????: {{ str_pad((string) $schedule->getKey(), 3, '0', STR_PAD_LEFT) }}</div>
                    <div>????????????: {{ $classRoom?->class_code ?? '-' }}</div>
                    <div>?????????: {{ $dayLabel }} ({{ $timeLabel }})</div>
                </div>
                <div class="ss-print-meta-right">
                    <div>???????????: {{ $classRoom?->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>???????????: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    <div>?????: {{ $totalStudents }} ????</div>
                </div>
            </div>
            <table class="ss-print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">??????</th>
                        <th style="width: 10%;">???????</th>
                        <th style="width: 18%;">??????-???</th>
                        <th style="width: 5%;">???</th>
                        <th style="width: 12%;">???????????</th>
                        <th style="width: 12%;">???????????</th>
                        <th style="width: 12%;">???????</th>
                        <th style="width: 12%;">????</th>
                        <th style="width: 14%;">???????</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-'; @endphp
                        <tr>
                            <td class="ss-print-center">{{ $loop->iteration }}</td>
                            <td class="ss-print-center">{{ $student->student_code ?? '-' }}</td>
                            <td>{{ $studentName }}</td>
                            <td class="ss-print-center">{{ $student->gender ?? '-' }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @empty
                        <tr><td colspan="9" class="ss-print-center ss-print-note">????????????????????????????????????</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="ss-print-footer"></div>
        </div>

        {{-- Other List Print Page --}}
        <div class="ss-print-page" id="print-other-page" aria-hidden="true">
            <div class="ss-print-header">
                <div>
                    <h3>??????????? ????? ???????</h3>
                    <p>????????????????????????? ????????</p>
                    <p>????????????? / ???????????</p>
                    <p class="ss-print-line">???: .................</p>
                </div>
                <div>
                    <h3>?????????????????????</h3>
                    <p>???? ????? ?????????????</p>
                    <p>********</p>
                </div>
            </div>
            <div class="ss-print-title">
                <h2>???????????</h2>
                <p>?????????: {{ $course?->course_name ?? '-' }}</p>
                <p>??????????: {{ $teacherName }}</p>
            </div>
            <div class="ss-print-meta">
                <div>
                    <div>??????????????: {{ str_pad((string) $schedule->getKey(), 3, '0', STR_PAD_LEFT) }}</div>
                    <div>????????????: {{ $classRoom?->class_code ?? '-' }}</div>
                    <div>?????????: {{ $dayLabel }} ({{ $timeLabel }})</div>
                </div>
                <div class="ss-print-meta-right">
                    <div>???????????: {{ $classRoom?->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>???????????: {{ \Carbon\Carbon::now()->format('d/m/Y') }}</div>
                    <div>?????: {{ $totalStudents }} ????</div>
                </div>
            </div>
            <table class="ss-print-table">
                <thead>
                    <tr>
                        <th style="width: 5%;">??????</th>
                        <th style="width: 12%;">???????</th>
                        <th style="width: 20%;">??????-???</th>
                        <th style="width: 5%;">???</th>
                        <th style="width: 18%;">?????? ?</th>
                        <th style="width: 18%;">?????? ?</th>
                        <th style="width: 22%;">???????</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $student)
                        @php $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-'; @endphp
                        <tr>
                            <td class="ss-print-center">{{ $loop->iteration }}</td>
                            <td class="ss-print-center">{{ $student->student_code ?? '-' }}</td>
                            <td>{{ $studentName }}</td>
                            <td class="ss-print-center">{{ $student->gender ?? '-' }}</td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                    @empty
                        <tr><td colspan="7" class="ss-print-center ss-print-note">????????????????????????????????????</td></tr>
                    @endforelse
                </tbody>
            </table>
            <div class="ss-print-footer"></div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">????</div>

            <div class="ss-heading">
                <h2>{{ $classRoom?->class_name ?? '????????????' }}</h2>
                <p>?????????: {{ $course?->course_name ?? '-' }}</p>
                <p>??????????: {{ $teacherName }}</p>
            </div>

            <div class="ss-meta">
                <div>
                    <div>??????????????: {{ str_pad((string) $schedule->getKey(), 3, '0', STR_PAD_LEFT) }}</div>
                    <div>????????????: {{ $classRoom?->class_code ?? '-' }}</div>
                    <div>?????????: {{ $dayLabel }} ({{ $timeLabel }})</div>
                </div>
                <div class="ss-meta-right">
                    <div>???????????: {{ $classRoom?->academicYear?->year_name ?? $course?->academicYear?->year_name ?? '-' }}</div>
                    <div>????: {{ $course?->semester?->semester_name ?? '-' }}</div>
                    <div>?????: {{ $totalStudents }} ????</div>
                </div>
            </div>

            @if($students->isEmpty())
                <div class="ss-empty">????????????????????????????????????</div>
            @else
                <table class="ss-table">
                    <thead>
                        <tr>
                            <th class="ss-center" style="width: 70px;">?.?</th>
                            <th style="width: 230px;">????????????-??????</th>
                            <th>?????????????????</th>
                            <th style="width: 160px;">??????????????</th>
                            <th class="ss-center" style="width: 90px;">??????</th>
                            <th class="ss-center" style="width: 130px;">???</th>
                            <th class="ss-center" style="width: 240px;">???????</th>
                            <th style="width: 150px;">???????</th>
                            <th class="ss-center" style="width: 80px;">????????</th>
                            <th class="ss-center" style="width: 70px;">??????</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($students as $student)
                            @php
                                $enrollment = $enrollmentsByStudent->get($student->student_id);
                                $studentName = trim(($student->first_name ?? '').' '.($student->last_name ?? '')) ?: '-';
                                $isAttachedToSchedule = $studentIdsAttachedToSchedule->contains((int) $student->student_id);
                            @endphp
                            <tr wire:key="schedule-student-{{ $student->student_id }}">
                                <td class="ss-center">{{ $loop->iteration }}</td>
                                <td>
                                    <span class="ss-name">{{ $studentName }}</span>
                                    <span class="ss-muted">{{ $student->student_code ?? '-' }}</span>
                                </td>
                                <td>
                                    {{ $course?->course_name ?? '-' }}
                                    <span class="ss-muted">{{ $course?->course_code ?? $classRoom?->class_code ?? '-' }}</span>
                                </td>
                                <td>{{ $enrollment?->status ?? $student->status ?? '-' }}</td>
                                <td class="ss-center">
                                    <input class="ss-input"
                                           type="text"
                                           value="0.00"
                                           readonly
                                           tabindex="0"
                                           x-on:focus="$el.classList.add('ss-input-active')"
                                           x-on:click="$el.classList.add('ss-input-active')"
                                           x-on:blur="$el.classList.remove('ss-input-active')">
                                </td>
                                <td class="ss-center">
                                    <input class="ss-input ss-select"
                                           type="text"
                                           value="{{ $student->gender ?? '-' }}"
                                           readonly
                                           tabindex="0"
                                           x-on:focus="$el.classList.add('ss-input-active')"
                                           x-on:click="$el.classList.add('ss-input-active')"
                                           x-on:blur="$el.classList.remove('ss-input-active')">
                                </td>
                                <td class="ss-center">
                                    <div class="ss-month-attendance">
                                        @forelse($monthDates as $date)
                                            @php
                                                $attendanceKey = $student->student_id.'|'.$date->toDateString();
                                                $attendance = $monthAttendances->get($attendanceKey);
                                                $isPresent = $attendance?->status === 'present';
                                                $isAbsent = $attendance?->status === 'absent';
                                            @endphp
                                            <label class="ss-month-day {{ $isPresent ? 'is-present' : ($isAbsent ? 'is-absent' : '') }}"
                                                   title="{{ $date->format('Y-m-d') }} - {{ $isPresent ? '??' : '?????' }}">
                                                <span class="ss-month-date">{{ $date->format('d') }}</span>
                                                <input class="ss-month-check"
                                                       type="checkbox"
                                                       @checked($isPresent)
                                                       x-on:change="
                                                            $el.closest('.ss-month-day').classList.toggle('is-present', $el.checked);
                                                            $el.closest('.ss-month-day').classList.toggle('is-absent', ! $el.checked);
                                                       "
                                                       wire:change="setMonthAttendance({{ $student->student_id }}, '{{ $date->toDateString() }}', $event.target.checked)">
                                            </label>
                                        @empty
                                            <span class="ss-muted">-</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td>
                                    <input class="ss-input"
                                           type="text"
                                           value="{{ $enrollment?->note ?? '??????' }}"
                                           readonly
                                           tabindex="0"
                                           x-on:focus="$el.classList.add('ss-input-active')"
                                           x-on:click="$el.classList.add('ss-input-active')"
                                           x-on:blur="$el.classList.remove('ss-input-active')">
                                </td>
                                <td class="ss-center">
                                    @if($canManageScheduleStudents && $isAttachedToSchedule)
                                        <button class="btn btn-danger btn-xs ss-delete"
                                                id="BtDelete"
                                                type="button"
                                                value="{{ $student->student_id }}"
                                                x-on:click="deleteStudentId = {{ $student->student_id }}; showDeleteStudentModal = true"
                                                title="???">
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @else
                                        <button class="btn btn-danger btn-xs ss-delete"
                                                id="BtDelete"
                                                type="button"
                                                value="{{ $student->student_id }}"
                                                title="???"
                                                disabled>
                                            <i class="fas fa-trash-alt"></i>
                                        </button>
                                    @endif
                                </td>
                                <td class="ss-center">
                                    <span class="ss-more" title="??????">?</span>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
</x-filament-panels::page>
