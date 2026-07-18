<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Teacher Notifications</title>
    <link rel="stylesheet" href="{{ asset('fonts/battambang.css') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <style>
        body { margin:0; background:#f8fafc; color:#0f172a; font-family:"Battambang", "Noto Sans Khmer", ui-sans-serif, system-ui, sans-serif; }
        .tn-page { max-width:980px; margin:0 auto; padding:34px 18px; }
        .tn-top { display:flex; justify-content:space-between; gap:16px; align-items:center; margin-bottom:22px; }
        .tn-top h1 { margin:0; font-size:30px; font-weight:900; }
        .tn-back { display:inline-flex; align-items:center; gap:8px; color:#2563eb; font-weight:800; text-decoration:none; }
        .tn-card { background:#fff; border:1px solid #dbe3ef; border-radius:8px; box-shadow:0 16px 40px rgba(15,23,42,.07); overflow:hidden; }
        .tn-item { display:flex; gap:14px; padding:18px; border-bottom:1px solid #edf2f7; }
        .tn-item:last-child { border-bottom:0; }
        .tn-icon { width:42px; height:42px; border-radius:8px; display:grid; place-items:center; background:#dcfce7; color:#15803d; flex:0 0 auto; }
        .tn-item.rejected .tn-icon { background:#fee2e2; color:#b91c1c; }
        .tn-item strong { display:block; font-size:16px; font-weight:900; }
        .tn-item p { margin:4px 0 6px; color:#475569; }
        .tn-item span { color:#94a3b8; font-size:12px; font-weight:700; }
        .tn-empty { padding:40px; text-align:center; color:#64748b; }
    </style>
</head>
<body>
    <main class="tn-page">
        <div class="tn-top">
            <div>
                <h1>Teacher Notifications</h1>
                <div style="color:#64748b;">Course approvals, certificate generation, and rejected requests.</div>
            </div>
            <a class="tn-back" href="{{ url('/admin') }}"><i class="fa fa-arrow-left"></i> Back to dashboard</a>
        </div>

        <section class="tn-card">
            @forelse($notifications as $notification)
                @php($data = $notification->data ?? [])
                <article class="tn-item {{ ($data['type'] ?? '') === 'course_completion_rejected' ? 'rejected' : '' }}">
                    <div class="tn-icon">
                        <i class="fa {{ ($data['type'] ?? '') === 'course_completion_rejected' ? 'fa-times-circle' : 'fa-check-circle' }}"></i>
                    </div>
                    <div>
                        <strong>{{ $data['title'] ?? 'Notification' }}</strong>
                        <p>{{ $data['message'] ?? '' }}</p>
                        <span>{{ $notification->created_at?->diffForHumans() }}</span>
                    </div>
                </article>
            @empty
                <div class="tn-empty">No notifications yet.</div>
            @endforelse
        </section>

        <div style="margin-top:18px;">{{ $notifications->links() }}</div>
    </main>
</body>
</html>
