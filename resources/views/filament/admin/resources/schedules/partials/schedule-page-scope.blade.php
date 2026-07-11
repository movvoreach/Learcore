<div
    x-data
    x-init="
        document.documentElement.classList.add('lc-schedules-page');
        document.body.classList.add('lc-schedules-page');

        const cleanupScheduleScope = () => {
            document.documentElement.classList.remove('lc-schedules-page');
            document.body.classList.remove('lc-schedules-page');
        };

        document.addEventListener('livewire:navigating', cleanupScheduleScope, { once: true });
    "
    hidden
></div>
