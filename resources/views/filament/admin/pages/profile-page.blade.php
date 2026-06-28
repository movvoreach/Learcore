<x-filament-panels::page>
<style>
    .pf-page {
        font-family: "Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif;
        display: grid;
        gap: 24px;
    }

    /* ── Avatar Upload Section ────────────────────── */
    .pf-avatar-section {
        display: flex;
        align-items: center;
        gap: 28px;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 24px 32px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .dark .pf-avatar-section {
        background: #1e293b;
        border-color: #334155;
    }
    @media (max-width: 600px) {
        .pf-avatar-section { flex-direction: column; text-align: center; }
    }

    .pf-avatar-wrap {
        position: relative;
        flex-shrink: 0;
    }
    .pf-avatar-img {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        object-fit: cover;
        border: 3px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(0,0,0,0.1);
        display: block;
    }
    .pf-avatar-initials {
        width: 90px;
        height: 90px;
        border-radius: 50%;
        background: linear-gradient(135deg, #4f54c8, #7c3aed);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 30px;
        font-weight: 700;
        color: #fff;
        border: 3px solid #e2e8f0;
        box-shadow: 0 4px 16px rgba(79,84,200,0.3);
        text-transform: uppercase;
    }

    /* Camera overlay button */
    .pf-avatar-overlay {
        position: absolute;
        bottom: 0; right: 0;
        width: 28px; height: 28px;
        background: #4f54c8;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        cursor: pointer;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        border: 2px solid #fff;
        transition: background 0.2s, transform 0.15s;
    }
    .pf-avatar-overlay:hover { background: #3730a3; transform: scale(1.1); }
    .pf-avatar-overlay svg { width: 14px; height: 14px; color: #fff; }

    .pf-avatar-info { flex: 1; }
    .pf-avatar-name {
        font-size: 18px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 4px;
    }
    .dark .pf-avatar-name { color: #f1f5f9; }
    .pf-avatar-role {
        font-size: 13px;
        color: #64748b;
        margin-bottom: 14px;
    }

    /* Upload button */
    .pf-upload-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: #4f54c8;
        color: #fff;
        border: none;
        border-radius: 8px;
        padding: 8px 18px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s, transform 0.15s;
        font-family: inherit;
    }
    .pf-upload-btn:hover { background: #3730a3; transform: translateY(-1px); }
    .pf-upload-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; }

    .pf-remove-btn {
        display: inline-flex;
        align-items: center;
        gap: 7px;
        background: transparent;
        color: #dc2626;
        border: 1px solid #fca5a5;
        border-radius: 8px;
        padding: 8px 16px;
        font-size: 13px;
        font-weight: 600;
        cursor: pointer;
        transition: background 0.2s;
        font-family: inherit;
        margin-left: 8px;
    }
    .pf-remove-btn:hover { background: #fff1f2; }

    /* Preview before upload */
    .pf-preview {
        display: flex;
        align-items: center;
        gap: 12px;
        margin-top: 12px;
        padding: 10px 14px;
        background: #f8fafc;
        border: 1px dashed #cbd5e1;
        border-radius: 8px;
    }
    .dark .pf-preview { background: #0f172a; border-color: #475569; }
    .pf-preview img {
        width: 48px; height: 48px;
        border-radius: 8px; object-fit: cover;
    }
    .pf-preview-name { font-size: 13px; color: #475569; flex: 1; }
    .dark .pf-preview-name { color: #94a3b8; }

    /* Success / error alerts */
    .pf-alert-success {
        display: flex; align-items: center; gap: 10px;
        background: #f0fdf4; border: 1px solid #bbf7d0;
        color: #16a34a; border-radius: 8px; padding: 12px 16px;
        font-size: 13px; font-weight: 600;
    }
    .pf-alert-error {
        display: flex; align-items: center; gap: 10px;
        background: #fff1f2; border: 1px solid #fecdd3;
        color: #dc2626; border-radius: 8px; padding: 12px 16px;
        font-size: 13px; font-weight: 600;
    }

    /* Progress bar */
    .pf-progress {
        height: 4px;
        background: #e2e8f0;
        border-radius: 999px;
        overflow: hidden;
        margin-top: 8px;
    }
    .pf-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #4f54c8, #7c3aed);
        border-radius: 999px;
        transition: width 0.3s;
    }

    /* ── Outer card ───────────────────────────────── */
    .pf-outer {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        border-radius: 12px;
        padding: 28px 32px 36px;
        box-shadow: 0 1px 6px rgba(0,0,0,0.04);
    }
    .dark .pf-outer {
        background: #1e293b;
        border-color: #334155;
    }

    /* ── Card heading ─────────────────────────────── */
    .pf-heading {
        font-size: 16px;
        font-weight: 700;
        color: #1e293b;
        margin-bottom: 24px;
        padding-bottom: 16px;
        border-bottom: 1px solid #e2e8f0;
    }
    .dark .pf-heading {
        color: #f1f5f9;
        border-color: #334155;
    }

    /* ── Field ────────────────────────────────────── */
    .pf-field { margin-bottom: 16px; }
    .pf-label {
        font-size: 13px;
        font-weight: 600;
        color: #475569;
        margin-bottom: 6px;
        display: block;
    }
    .dark .pf-label { color: #94a3b8; }
    .pf-value {
        background: #eef0fb;
        border-radius: 8px;
        padding: 10px 14px;
        font-size: 14px;
        font-weight: 500;
        color: #1e293b;
        min-height: 40px;
        display: flex;
        align-items: center;
    }
    .dark .pf-value { background: #0f172a; color: #e2e8f0; }

    /* Password field */
    .pf-value-password {
        background: #4f54c8;
        color: #ffffff;
        font-size: 16px;
        letter-spacing: 3px;
        border-radius: 8px;
        padding: 10px 14px;
        min-height: 40px;
        display: flex;
        align-items: center;
        font-weight: 700;
    }

    /* ── Two-column row ───────────────────────────── */
    .pf-row-2 {
        display: grid;
        grid-template-columns: 1fr auto;
        gap: 16px;
        margin-bottom: 16px;
        align-items: end;
    }
    .pf-row-2 .pf-col-sm { min-width: 120px; }
    @media (max-width: 600px) {
        .pf-row-2 { grid-template-columns: 1fr; }
    }
</style>

@php
    $user      = $user ?? auth()->user();
    $userId    = str_pad($user->id, 4, '0', STR_PAD_LEFT);
    $createdAt = $user->created_at?->format('d/M/Y') ?? '—';
    $initial   = strtoupper(substr($user->name ?? 'U', 0, 2));
    $avatarUrl = $user->avatar ? Storage::disk('public')->url($user->avatar) : null;

    $roleMap = [
        'super_admin' => 'ស៊ូប៉ែអ្នកគ្រប់គ្រង',
        'admin'       => 'អ្នកគ្រប់គ្រង',
        'teacher'     => 'គ្រូបង្រៀន',
        'student'     => 'និស្សិត',
    ];
    $rawRole   = $user->getRoleNames()->first() ?? 'user';
    $roleLabel = $roleMap[$rawRole] ?? ucfirst($rawRole);

    $st = $student ?? null;
    $fullName = $st
        ? trim(($st->first_name ?? '') . ' ' . ($st->last_name ?? ''))
        : $user->name;
    $gender = $st?->gender ?? null;
    $genderLabel = match($gender) {
        'male'   => 'ប្រុស',
        'female' => 'ស្រី',
        default  => '—',
    };
@endphp

<div class="pf-page">

    {{-- ── AVATAR UPLOAD SECTION ───────────────────── --}}
    <div class="pf-avatar-section">
        <div class="pf-avatar-wrap">
            @if($avatarUrl)
                <img src="{{ $avatarUrl }}" alt="Avatar" class="pf-avatar-img" wire:key="avatar-{{ $user->avatar }}">
            @else
                <div class="pf-avatar-initials">{{ $initial }}</div>
            @endif

            {{-- Camera icon overlay --}}
            <label for="avatar-hidden-input" class="pf-avatar-overlay" title="ប្តូររូបភាព">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </label>
        </div>

        <div class="pf-avatar-info">
            <div class="pf-avatar-name">{{ $user->name }}</div>
            <div class="pf-avatar-role">{{ $roleLabel }}</div>

            {{-- Success message --}}
            @if($successMessage)
            <div class="pf-alert-success" style="margin-bottom:12px;">
                ✅ {{ $successMessage }}
            </div>
            @endif

            {{-- Validation errors --}}
            @error('avatarFile')
            <div class="pf-alert-error" style="margin-bottom:12px;">
                ⚠️ {{ $message }}
            </div>
            @enderror

            {{-- File input (hidden) --}}
            <input type="file"
                   id="avatar-hidden-input"
                   accept="image/*"
                   style="display:none;"
                   wire:model="avatarFile">

            {{-- Preview + upload controls once a file is selected --}}
            @if($avatarFile)
            <div class="pf-preview">
                <img src="{{ $avatarFile->temporaryUrl() }}" alt="preview">
                <span class="pf-preview-name">{{ $avatarFile->getClientOriginalName() }}</span>
                <button type="button" class="pf-upload-btn" wire:click="uploadAvatar" wire:loading.attr="disabled">
                    <svg wire:loading.remove wire:target="uploadAvatar" style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    <svg wire:loading wire:target="uploadAvatar" style="width:14px;height:14px;animation:spin 1s linear infinite;" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span wire:loading.remove wire:target="uploadAvatar">រក្សាទុក</span>
                    <span wire:loading wire:target="uploadAvatar">កំពុងដំណើរការ...</span>
                </button>
            </div>
            @else
            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                <label for="avatar-hidden-input" class="pf-upload-btn" style="cursor:pointer;">
                    <svg style="width:14px;height:14px;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/>
                    </svg>
                    ផ្លាស់ប្ដូររូបភាព
                </label>

                @if($user->avatar)
                <button type="button" class="pf-remove-btn" wire:click="removeAvatar" wire:confirm="តើអ្នកពិតជាចង់លុបរូបភាពនេះ?">
                    🗑 លុបរូបភាព
                </button>
                @endif
            </div>
            @endif

            {{-- Upload progress --}}
            <div wire:loading wire:target="avatarFile" style="margin-top:10px;">
                <div class="pf-progress">
                    <div class="pf-progress-bar" style="width:100%;"></div>
                </div>
                <p style="font-size:12px;color:#64748b;margin-top:4px;">កំពុងផ្ទុករូបភាព...</p>
            </div>
        </div>
    </div>

    {{-- ── PROFILE INFO CARD ────────────────────────── --}}
    <div class="pf-outer">
        <div class="pf-heading">ព័ត៌មានអ្នកប្រើប្រាស់</div>

        <div class="pf-field">
            <span class="pf-label">លេខសំគាល់គណនី</span>
            <div class="pf-value">{{ $userId }}</div>
        </div>

        <div class="pf-field">
            <span class="pf-label">ប្រភេទគណនី</span>
            <div class="pf-value">{{ $roleLabel }}</div>
        </div>

        <div class="pf-field">
            <span class="pf-label">ឈ្មោះគណនី</span>
            <div class="pf-value">{{ $user->name }}</div>
        </div>

        <div class="pf-field">
            <span class="pf-label">អ៊ីមែល</span>
            <div class="pf-value">{{ $user->email }}</div>
        </div>

        @if($st)
        <div class="pf-row-2">
            <div>
                <span class="pf-label">ឈ្មោះពេញ</span>
                <div class="pf-value">{{ $fullName ?: '—' }}</div>
            </div>
            <div class="pf-col-sm">
                <span class="pf-label">កេទ</span>
                <div class="pf-value">{{ $genderLabel }}</div>
            </div>
        </div>

        @if($st->department)
        <div class="pf-field">
            <span class="pf-label">នាយកដ្ឋាន</span>
            <div class="pf-value">{{ $st->department->department_name }}</div>
        </div>
        @endif

        @if($st->academicYear || $st->semester)
        <div class="pf-row-2">
            @if($st->academicYear)
            <div>
                <span class="pf-label">ឆ្នាំសិក្សា</span>
                <div class="pf-value">{{ $st->academicYear->year_name }}</div>
            </div>
            @endif
            @if($st->semester)
            <div class="pf-col-sm">
                <span class="pf-label">ឆមាស</span>
                <div class="pf-value">{{ $st->semester->semester_name }}</div>
            </div>
            @endif
        </div>
        @endif
        @endif

        <div class="pf-field">
            <span class="pf-label">កាលបរិច្ឆេទបង្កើត</span>
            <div class="pf-value">{{ $createdAt }}</div>
        </div>

        <div class="pf-field">
            <span class="pf-label">លេខសំងាត់</span>
            <div class="pf-value-password">xxxxxxxxxx</div>
        </div>
    </div>

</div>

<style>
@keyframes spin { from { transform: rotate(0deg); } to { transform: rotate(360deg); } }
</style>

</x-filament-panels::page>
