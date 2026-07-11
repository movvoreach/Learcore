<x-filament-panels::page>
    @once
        <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2/css/select2.min.css') }}">
        <link rel="stylesheet" href="{{ asset('backend/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
        <script src="{{ asset('backend/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ asset('backend/plugins/select2/js/select2.full.min.js') }}"></script>
    @endonce

    <style>
        .users-list-show {
            color: #3f4566;
            font-family: "Battambang", "Noto Sans Khmer", "Khmer OS Siemreap", ui-sans-serif, system-ui, sans-serif;
            font-size: 100%;
            font-weight: 400;
            line-height: 1.65;
            letter-spacing: 0;
        }

        .users-list-show * {
            font-family: inherit;
            letter-spacing: 0;
        }

        .users-list-show .fa,
        .users-list-show .fas,
        .users-list-show .fa-solid {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 900 !important;
        }

        .users-list-show .far {
            font-family: "Font Awesome 5 Free" !important;
            font-weight: 400 !important;
        }

        .users-list-show .fab {
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
        .fi-ac-actions,
        .fi-ac,
        .fi-page-header-actions {
            display: none !important;
        }
    </style>

    <div class="users-list-show">
        <div class="ss-toolbar">
            <div class="ss-filters-group">
                <div class="ss-select2-wrap" wire:ignore x-data="{
                    value: @entangle('role_id'),
                    initSelect2() {
                        let select = window.jQuery(this.$refs.selectElement).select2({
                            theme: 'bootstrap4',
                            width: '100%',
                            placeholder: 'ជ្រើសរើសតួនាទី (All Roles)',
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
                        <option value="">ជ្រើសរើសតួនាទី (All Roles)</option>
                        @foreach(\Spatie\Permission\Models\Role::all() as $role)
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div class="ss-actions-group" style="display: flex; gap: 6px;">
                @if (\App\Filament\Admin\Resources\Users\UserResource::canCreate())
                    <a class="ss-tool" href="{{ \App\Filament\Admin\Resources\Users\UserResource::getUrl('create') }}" title="បញ្ចូលអ្នកប្រើប្រាស់">
                        <i class="fa fa-plus-circle"></i>
                    </a>
                @endif
            </div>
        </div>

        <div class="ss-card">
            <div class="ss-ribbon">បញ្ជី</div>

            <div class="ss-heading">
                <h2>បញ្ជីអ្នកប្រើប្រាស់</h2>
            </div>

            <div>
                {{ $this->table }}
            </div>
        </div>
    </div>
</x-filament-panels::page>
