<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
    @endonce

    <style>
        .categories-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .categories-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .categories-list-show .fa,
        .categories-list-show .fas,
        .categories-list-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .categories-list-show .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .categories-list-show .fab {
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

        /* Hide default Filament header actions globally on this page */
        .fi-header-actions,
        .fi-page-header-actions {
            display: none !important;
        }
    </style>

    <div class="categories-list-show">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <!-- No filters needed for course categories table -->
            </div>
            
            <div class="ss-actions-group" >
                @if (\App\Filament\Admin\Resources\CourseCategories\CourseCategoryResource::canCreate())
                    <a class="ss-tool" href="{{ \App\Filament\Admin\Resources\CourseCategories\CourseCategoryResource::getUrl('create') }}" title="??????????????????????">
                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="ss-card">

            <div class="ss-heading">
                <h2>????????????????</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
