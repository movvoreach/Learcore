<div class="learncore-splash" id="learncoreSplash" role="dialog" aria-modal="true" aria-labelledby="learncoreSplashTitle" aria-describedby="learncoreSplashDescription" hidden>
    <div class="learncore-splash__bg" aria-hidden="true">
        <span></span>
        <span></span>
        <span></span>
    </div>

    <div class="learncore-splash__panel" role="document">
        <button type="button" class="learncore-splash__skip-top" data-splash-close aria-label="Skip welcome screen">
            <i class="fas fa-times"></i>
        </button>

        <div class="learncore-splash__brand">
            <span class="learncore-splash__logo">
                <i class="fas fa-book-open"></i>
            </span>
            <div>
                <strong>LearnCore LMS</strong>
                <small>Learning Management System</small>
            </div>
        </div>

        <div class="learncore-splash__content">
            <div class="learncore-splash__copy">
                <span class="learncore-splash__eyebrow">Welcome back, student</span>
                <h1 id="learncoreSplashTitle">Welcome to LearnCore LMS</h1>
                <p id="learncoreSplashDescription">
                    Learn anytime, anywhere. Access your courses, track your progress, and build your skills.
                </p>

                <div class="learncore-splash__actions">
                    <button type="button" class="learncore-splash__primary" id="learncoreSplashContinue" data-splash-close>
                        Start Learning
                        <i class="fas fa-arrow-right"></i>
                    </button>
                    <button type="button" class="learncore-splash__secondary" data-splash-close>
                        Skip
                    </button>
                </div>
            </div>

            <div class="learncore-splash__announcement" aria-label="Featured announcements">
                <div class="learncore-splash__card-head">
                    <span><i class="fas fa-bullhorn"></i></span>
                    <div>
                        <strong>Featured Updates</strong>
                        <small>Latest learning announcements</small>
                    </div>
                </div>

                <ul>
                    <li>
                        <i class="fas fa-graduation-cap"></i>
                        <span>New courses available</span>
                    </li>
                    <li>
                        <i class="fas fa-calendar-alt"></i>
                        <span>Upcoming schedules</span>
                    </li>
                    <li>
                        <i class="fas fa-circle-info"></i>
                        <span>Important notices</span>
                    </li>
                </ul>

                <div class="learncore-splash__progress" aria-hidden="true">
                    <span></span>
                </div>
            </div>
        </div>

        <div class="learncore-splash__loader" aria-hidden="true">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>

@push('styles')
    <style>
        .learncore-splash[hidden] {
            display: none !important;
        }

        body.learncore-splash-open {
            overflow: hidden;
        }

        .learncore-splash {
            position: fixed;
            inset: 0;
            z-index: 10000;
            display: grid;
            place-items: center;
            overflow: hidden;
            background:
                linear-gradient(135deg, rgba(239, 246, 255, .96), rgba(255, 255, 255, .94)),
                radial-gradient(circle at 16% 20%, rgba(37, 99, 235, .22), transparent 34%),
                radial-gradient(circle at 82% 16%, rgba(14, 165, 233, .18), transparent 30%);
            padding: 24px;
            opacity: 0;
            visibility: hidden;
            transition: opacity .45s ease, visibility .45s ease;
        }

        .learncore-splash.is-visible {
            opacity: 1;
            visibility: visible;
        }

        .learncore-splash.is-leaving {
            opacity: 0;
            visibility: hidden;
        }

        .learncore-splash__bg span {
            position: absolute;
            display: block;
            border-radius: 999px;
            background: rgba(37, 99, 235, .12);
            filter: blur(2px);
            animation: learncore-splash-float 7s ease-in-out infinite;
        }

        .learncore-splash__bg span:nth-child(1) {
            width: 220px;
            height: 220px;
            left: 8%;
            top: 13%;
        }

        .learncore-splash__bg span:nth-child(2) {
            width: 160px;
            height: 160px;
            right: 11%;
            top: 18%;
            animation-delay: -2s;
        }

        .learncore-splash__bg span:nth-child(3) {
            width: 260px;
            height: 260px;
            right: 17%;
            bottom: 8%;
            animation-delay: -4s;
        }

        .learncore-splash__panel {
            position: relative;
            width: min(1060px, 100%);
            overflow: hidden;
            border: 1px solid rgba(147, 197, 253, .46);
            border-radius: 28px;
            background: rgba(255, 255, 255, .72);
            box-shadow: 0 30px 80px rgba(15, 23, 42, .18);
            backdrop-filter: blur(20px);
            padding: 34px;
            transform: translateY(18px) scale(.98);
            transition: transform .45s ease;
        }

        .learncore-splash.is-visible .learncore-splash__panel {
            transform: translateY(0) scale(1);
        }

        .learncore-splash__skip-top {
            position: absolute;
            top: 22px;
            right: 22px;
            width: 40px;
            height: 40px;
            display: grid;
            place-items: center;
            border: 1px solid rgba(148, 163, 184, .28);
            border-radius: 999px;
            background: rgba(255, 255, 255, .82);
            color: #475569;
        }

        .learncore-splash__brand {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            margin-bottom: 28px;
        }

        .learncore-splash__logo {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            border-radius: 18px;
            background: linear-gradient(135deg, #2563eb, #0ea5e9);
            color: #fff;
            font-size: 25px;
            box-shadow: 0 16px 30px rgba(37, 99, 235, .28);
        }

        .learncore-splash__brand strong,
        .learncore-splash__brand small {
            display: block;
        }

        .learncore-splash__brand strong {
            color: #0f172a;
            font-size: 20px;
            font-weight: 900;
        }

        .learncore-splash__brand small {
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .learncore-splash__content {
            display: grid;
            grid-template-columns: minmax(0, 1.05fr) minmax(300px, .72fr);
            align-items: stretch;
            gap: 28px;
        }

        .learncore-splash__copy {
            padding: 18px 8px 12px 0;
        }

        .learncore-splash__eyebrow {
            display: inline-flex;
            align-items: center;
            min-height: 30px;
            border-radius: 999px;
            background: #dbeafe;
            color: #1d4ed8;
            padding: 0 12px;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .learncore-splash h1 {
            max-width: 620px;
            margin: 20px 0 18px;
            color: #0f172a;
            font-size: clamp(34px, 5vw, 62px);
            line-height: 1.05;
            font-weight: 900;
            letter-spacing: 0;
        }

        .learncore-splash p {
            max-width: 650px;
            margin: 0;
            color: #475569;
            font-size: 18px;
            line-height: 1.8;
        }

        .learncore-splash__actions {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-top: 30px;
        }

        .learncore-splash__primary,
        .learncore-splash__secondary {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 14px;
            padding: 0 22px;
            font-weight: 900;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease;
        }

        .learncore-splash__primary {
            border: 0;
            background: #2563eb;
            color: #fff;
            box-shadow: 0 16px 28px rgba(37, 99, 235, .28);
        }

        .learncore-splash__secondary {
            border: 1px solid #cbd5e1;
            background: rgba(255, 255, 255, .78);
            color: #334155;
        }

        .learncore-splash__primary:hover,
        .learncore-splash__secondary:hover,
        .learncore-splash__skip-top:hover {
            transform: translateY(-2px);
        }

        .learncore-splash__announcement {
            border: 1px solid rgba(203, 213, 225, .78);
            border-radius: 24px;
            background:
                linear-gradient(180deg, rgba(255, 255, 255, .82), rgba(239, 246, 255, .78));
            padding: 24px;
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .72);
        }

        .learncore-splash__card-head {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 22px;
        }

        .learncore-splash__card-head > span {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 14px;
            background: #eff6ff;
            color: #2563eb;
            font-size: 19px;
        }

        .learncore-splash__card-head strong,
        .learncore-splash__card-head small {
            display: block;
        }

        .learncore-splash__card-head strong {
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
        }

        .learncore-splash__card-head small {
            color: #64748b;
            font-size: 13px;
            font-weight: 800;
        }

        .learncore-splash__announcement ul {
            display: grid;
            gap: 12px;
            margin: 0;
            padding: 0;
            list-style: none;
        }

        .learncore-splash__announcement li {
            min-height: 54px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-radius: 16px;
            background: rgba(255, 255, 255, .76);
            color: #1e293b;
            padding: 0 14px;
            font-weight: 900;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .05);
        }

        .learncore-splash__announcement li i {
            width: 34px;
            height: 34px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: #dbeafe;
            color: #2563eb;
        }

        .learncore-splash__progress {
            height: 5px;
            overflow: hidden;
            border-radius: 999px;
            background: #dbeafe;
            margin-top: 22px;
        }

        .learncore-splash__progress span {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            background: linear-gradient(90deg, #2563eb, #0ea5e9);
            transform-origin: left;
            animation: learncore-splash-progress 4.5s linear forwards;
        }

        .learncore-splash__loader {
            display: flex;
            justify-content: center;
            gap: 7px;
            margin-top: 26px;
        }

        .learncore-splash__loader span {
            width: 8px;
            height: 8px;
            border-radius: 999px;
            background: #2563eb;
            animation: learncore-splash-dot 1s ease-in-out infinite;
        }

        .learncore-splash__loader span:nth-child(2) {
            animation-delay: .16s;
        }

        .learncore-splash__loader span:nth-child(3) {
            animation-delay: .32s;
        }

        @keyframes learncore-splash-float {
            0%,
            100% {
                transform: translate3d(0, 0, 0);
            }

            50% {
                transform: translate3d(0, -18px, 0);
            }
        }

        @keyframes learncore-splash-progress {
            from {
                transform: scaleX(0);
            }

            to {
                transform: scaleX(1);
            }
        }

        @keyframes learncore-splash-dot {
            0%,
            100% {
                opacity: .35;
                transform: translateY(0);
            }

            50% {
                opacity: 1;
                transform: translateY(-5px);
            }
        }

        @media (max-width: 860px) {
            .learncore-splash__panel {
                padding: 26px;
            }

            .learncore-splash__content {
                grid-template-columns: 1fr;
            }

            .learncore-splash__copy {
                padding-right: 0;
            }
        }

        @media (max-width: 540px) {
            .learncore-splash {
                padding: 14px;
            }

            .learncore-splash__panel {
                max-height: calc(100vh - 28px);
                overflow-y: auto;
                border-radius: 22px;
                padding: 22px;
            }

            .learncore-splash__brand {
                padding-right: 44px;
            }

            .learncore-splash__logo {
                width: 50px;
                height: 50px;
            }

            .learncore-splash p {
                font-size: 16px;
            }

            .learncore-splash__primary,
            .learncore-splash__secondary {
                width: 100%;
            }
        }

        @media (prefers-reduced-motion: reduce) {
            .learncore-splash,
            .learncore-splash__panel,
            .learncore-splash__bg span,
            .learncore-splash__progress span,
            .learncore-splash__loader span {
                animation: none !important;
                transition: none !important;
            }
        }
    </style>
@endpush

@push('scripts')
    <script>
        (function () {
            const splash = document.getElementById('learncoreSplash');

            if (!splash) {
                return;
            }

            const storageKey = 'learncore_lms_splash_seen_at';
            const dayInMs = 24 * 60 * 60 * 1000;
            const now = Date.now();
            const storage = {
                get() {
                    try {
                        return Number(window.localStorage.getItem(storageKey) || 0);
                    } catch (error) {
                        return 0;
                    }
                },
                set() {
                    try {
                        window.localStorage.setItem(storageKey, String(Date.now()));
                    } catch (error) {
                        // Storage can be unavailable in some privacy modes.
                    }
                },
            };
            const previous = storage.get();
            const shouldShow = !previous || now - previous > dayInMs;
            const continueButton = document.getElementById('learncoreSplashContinue');
            let closeTimer = null;
            let lastFocused = null;

            function closeSplash() {
                storage.set();
                window.clearTimeout(closeTimer);
                splash.classList.add('is-leaving');
                splash.classList.remove('is-visible');

                window.setTimeout(function () {
                    splash.hidden = true;
                    document.body.classList.remove('learncore-splash-open');

                    if (lastFocused && typeof lastFocused.focus === 'function') {
                        lastFocused.focus();
                    }
                }, 460);
            }

            function trapFocus(event) {
                if (event.key !== 'Tab') {
                    return;
                }

                const focusable = splash.querySelectorAll('button, [href], input, select, textarea, [tabindex]:not([tabindex="-1"])');
                const first = focusable[0];
                const last = focusable[focusable.length - 1];

                if (!first || !last) {
                    return;
                }

                if (event.shiftKey && document.activeElement === first) {
                    event.preventDefault();
                    last.focus();
                } else if (!event.shiftKey && document.activeElement === last) {
                    event.preventDefault();
                    first.focus();
                }
            }

            if (!shouldShow) {
                splash.hidden = true;
                return;
            }

            lastFocused = document.activeElement;
            splash.hidden = false;
            document.body.classList.add('learncore-splash-open');

            window.requestAnimationFrame(function () {
                splash.classList.add('is-visible');
                continueButton?.focus();
            });

            closeTimer = window.setTimeout(closeSplash, 4500);

            splash.querySelectorAll('[data-splash-close]').forEach(function (button) {
                button.addEventListener('click', closeSplash);
            });

            splash.addEventListener('keydown', trapFocus);

            document.addEventListener('keydown', function (event) {
                if (!splash.hidden && event.key === 'Escape') {
                    closeSplash();
                }
            });
        })();
    </script>
@endpush
