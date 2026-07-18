<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    @endonce

    <style>
        .lesson-create-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .lesson-create-show *,
        .lesson-create-show button,
        .lesson-create-show input,
        .lesson-create-show select,
        .lesson-create-show textarea {
            font-family: inherit;
            letter-spacing: 0;
        }

        .lesson-create-show .fa,
        .lesson-create-show .fas,
        .lesson-create-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .lc-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            min-height: 64px;
            margin-bottom: 24px;
            padding: 14px 22px;
            border-radius: 4px;
            background: #fff;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
        }

        .lc-toolbar-title {
            margin: 0;
            color: #3a405f;
            font-size: 22px;
            font-weight: 500;
            line-height: 1.4;
        }

        .lc-toolbar-subtitle {
            margin-top: 2px;
            color: #737b98;
            font-size: 13px;
        }

        .lc-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-width: 48px;
            height: 42px;
            border-radius: 0;
            background: #5866f5;
            color: #fff;
            text-decoration: none;
            font-size: 20px;
        }

        .lc-card {
            position: relative;
            border-radius: 5px;
            background: #fff;
            padding: 26px 22px 24px;
            box-shadow: 0 2px 8px rgba(44, 50, 89, .08);
        }

        .lc-ribbon {
            position: absolute;
            top: 0;
            left: 22px;
            width: 90px;
            height: 94px;
            padding-top: 31px;
            background: #5866f5;
            color: #fff;
            text-align: center;
            font-size: 14px;
            font-weight: 700;
        }

        .lc-ribbon::after {
            content: "";
            position: absolute;
            left: 0;
            right: 0;
            bottom: -26px;
            border-left: 45px solid transparent;
            border-right: 45px solid transparent;
            border-top: 26px solid #5866f5;
        }

        .lc-heading {
            padding: 0 100px 18px;
            border-bottom: 1px solid #d8dbe8;
            text-align: center;
        }

        .lc-heading h2 {
            margin: 0;
            color: #3a405f;
            font-size: 32px;
            font-weight: 400;
            line-height: 1.35;
        }

        .lc-heading p {
            margin: 6px 0 0;
            color: #737b98;
            font-size: 14px;
        }

        .lc-form-wrap {
            padding-top: 24px;
        }

        .lesson-create-show .filepond--root {
            font-family: inherit;
            min-height: 344px;
        }

        .lesson-create-show .filepond--panel-root {
            border-radius: 0;
            background: #dce9ec;
        }

        .lesson-create-show .filepond--drop-label {
            position: relative;
            min-height: 344px;
            color: #123c4a;
        }

        .lesson-create-show .filepond--drop-label::before {
            content: "";
            position: absolute;
            inset: 8px;
            border: 2px dashed #9cbcc3;
            pointer-events: none;
        }

        .lesson-create-show .filepond--drop-label label {
            width: 100%;
            cursor: pointer;
        }

        .lc-upload-placeholder {
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 14px;
            min-height: 310px;
            text-align: center;
        }

        .lc-upload-icon {
            color: #93b4bc;
            font-size: 64px;
            line-height: 1;
        }

        .lc-upload-title {
            color: #123c4a;
            font-size: 20px;
            font-weight: 400;
        }

        .lc-upload-title .filepond--label-action {
            color: #123c4a;
            font-weight: 700;
            text-decoration: none;
        }

        .lc-upload-note {
            color: #5f7f87;
            font-size: 13px;
        }

        .dark .lc-toolbar,
        .dark .lc-card {
            border: 1px solid #334155;
            background: #1e293b;
            box-shadow: none;
        }

        .dark .lc-heading {
            border-bottom-color: #334155;
        }

        .dark .lc-heading h2,
        .dark .lc-toolbar-title {
            color: #f1f5f9;
        }

        @media (max-width: 768px) {
            .lc-toolbar {
                align-items: flex-start;
                padding: 12px;
            }

            .lc-card {
                padding: 20px 12px;
            }

            .lc-ribbon {
                position: relative;
                left: 0;
                width: 72px;
                height: 66px;
                margin-bottom: 28px;
                padding-top: 20px;
            }

            .lc-ribbon::after {
                bottom: -20px;
                border-left-width: 36px;
                border-right-width: 36px;
                border-top-width: 20px;
            }

            .lc-heading {
                padding: 0 0 14px;
            }

            .lc-heading h2 {
                font-size: 24px;
            }

            .lesson-create-show .filepond--root,
            .lesson-create-show .filepond--drop-label {
                min-height: 260px;
            }

            .lc-upload-placeholder {
                min-height: 226px;
            }
        }
    </style>

    <div class="lesson-create-show" wire:key="content-lesson-create-page">
        <div class="lc-toolbar">
            <div>
                <h1 class="lc-toolbar-title">បញ្ចូលមេរៀន</h1>
                <div class="lc-toolbar-subtitle">បង្កើតមេរៀន វីដេអូ ឯកសារ កិច្ចការ ឬសំណួរ</div>
            </div>

            <a class="lc-back" href="{{ \App\Filament\Admin\Resources\ContentLessons\ContentLessonResource::getUrl('index') }}" title="ត្រឡប់">
                <i class="fa fa-minus-circle"></i>
            </a>
        </div>

        <div class="lc-card">
            <div class="lc-ribbon">New</div>

            <div class="lc-heading">
                <h2>បញ្ចូលមេរៀន</h2>
                <p>ជ្រើសរើសប្រភេទមាតិកា ហើយបំពេញព័ត៌មានមេរៀន</p>
            </div>

            <div class="lc-form-wrap">
                {{ $this->content }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
