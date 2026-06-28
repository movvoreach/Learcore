@php
    $userName = filament()->auth()->user()?->name ?? 'User';
@endphp

<div class="lc-topbar-session" aria-label="Current session">
    <div class="lc-topbar-session-time">
        <span class="lc-topbar-date" data-lc-current-date>{{ now()->format('l, F j, Y') }}</span>
        <span class="lc-topbar-time" data-lc-current-time>{{ now()->format('h:i A') }}</span>
    </div>

    <div class="lc-topbar-session-user">
        <span>Logged in as</span>
        <strong>ážŸáž¶ážŸáŸ’ážáŸ’ážšáž¶áž…áž¶ážšáŸ’áž™: {{ $userName }}</strong>
    </div>
</div>

<script>
    (() => {
        const updateTopbarClock = () => {
            const dateFormatter = new Intl.DateTimeFormat('en-US', {
                weekday: 'long',
                month: 'long',
                day: 'numeric',
                year: 'numeric',
            })
            const timeFormatter = new Intl.DateTimeFormat('en-US', {
                hour: 'numeric',
                minute: '2-digit',
                second: '2-digit',
                hour12: true,
            })
            const now = new Date()

            document.querySelectorAll('[data-lc-current-date]').forEach((element) => {
                element.textContent = dateFormatter.format(now)
            })

            document.querySelectorAll('[data-lc-current-time]').forEach((element) => {
                element.textContent = timeFormatter.format(now)
            })
        }

        if (! window.lcTopbarClockInterval) {
            updateTopbarClock()
            window.lcTopbarClockInterval = window.setInterval(updateTopbarClock, 1000)
        }

        if (! window.lcTopbarClockNavigationBound) {
            window.lcTopbarClockNavigationBound = true
            document.addEventListener('livewire:navigated', updateTopbarClock)
        }
    })()
</script>
