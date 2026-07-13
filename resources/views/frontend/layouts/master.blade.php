<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ $currentLanguage?->direction ?? 'ltr' }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Moodle LMS')</title>
    <link rel="icon" type="image/png" href="{{ asset('backend/dist/img/spilogo.png') }}">
    <link rel="stylesheet" href="{{ asset('backend/plugins/fontawesome-free/css/all.min.css') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Battambang:wght@400;600;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('backend/dist/css/adminlte.min.css') }}">

    @stack('styles')

    <style>
        :root {
            --learning-orange: #ff5b00;
            --learning-orange-dark: #f04d00;
            --learning-blue: #2563eb;
            --learning-blue-soft: #eaf1ff;
            --learning-ink: #111827;
            --learning-muted: #64748b;
            --learning-line: #e5eaf1;
            --learning-soft: #f4f6f9;
            --learning-panel: #ffffff;
            --learning-shadow: 0 18px 42px rgba(15, 23, 42, .10);
        }

        * {
            box-sizing: border-box;
        }

        body.frontend-page {
            min-height: 100vh;
            margin: 0;
            background: #f8fafc;
            color: var(--learning-ink);
            font-family: 'Battambang', 'Segoe UI', Arial, sans-serif;
        }

        body.lesson-media-fullscreen {
            overflow: hidden;
        }

        body.is-page-loading {
            overflow: hidden;
        }

        .frontend-main {
            min-height: 100vh;
            padding-top: 82px;
            background: #f8fafc;
        }

        .page-loading-overlay {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: grid;
            place-items: center;
            background: #fff;
            opacity: 0;
            visibility: hidden;
            pointer-events: none;
            transition: opacity .18s ease, visibility .18s ease;
        }

        body.is-page-loading .page-loading-overlay {
            opacity: 1;
            visibility: visible;
            pointer-events: auto;
        }

        .page-loading-mark {
            position: relative;
            width: 68px;
            height: 68px;
            display: grid;
            place-items: center;
            color: #1478ff;
        }

        .page-loading-mark::before {
            content: "";
            position: absolute;
            inset: 0;
            border: 2px solid rgba(20, 120, 255, .12);
            border-top-color: #1478ff;
            border-radius: 50%;
            animation: page-loading-spin .8s linear infinite;
        }

        .page-loading-mark i {
            position: relative;
            font-size: 31px;
            animation: page-loading-pulse 1.15s ease-in-out infinite;
        }

        @keyframes page-loading-spin {
            to {
                transform: rotate(360deg);
            }
        }

        @keyframes page-loading-pulse {
            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.08);
            }
        }

        .learning-navbar {
            min-height: 82px;
            display: flex;
            flex-direction: column;
            align-items: center;
            border-bottom: 1px solid rgba(226, 232, 240, .78);
            background: rgba(255, 255, 255, .88);
            box-shadow: 0 14px 36px rgba(15, 23, 42, .08);
            backdrop-filter: blur(18px);
            z-index: 1030;
            font-family: 'Battambang', 'Segoe UI', Arial, sans-serif;
        }

        .learning-navbar__inner {
            width: 100%;
            max-width: 1520px;
            min-height: 82px;
            display: flex;
            align-items: center;
            gap: 20px;
            margin: 0 auto;
            padding: 0 34px;
        }

        .learning-brand {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            min-width: 270px;
            color: inherit;
            border-radius: 16px;
            padding: 7px 9px 7px 0;
            transition: background .18s ease, transform .18s ease;
        }

        .learning-brand:hover,
        .learning-nav__link:hover,
        .learning-search a:hover,
        .learning-action:hover,
        .learning-login:hover,
        .learning-cta:hover,
        .learning-user__button:hover,
        .learning-language__button:hover {
            text-decoration: none;
        }

        .learning-brand:hover {
            background: rgba(239, 246, 255, .74);
            transform: translateY(-1px);
        }

        .learning-brand__icon {
            width: 52px;
            height: 52px;
            display: grid;
            place-items: center;
            flex: 0 0 52px;
            border-radius: 15px;
            background:
                radial-gradient(circle at 30% 20%, rgba(255, 255, 255, .38), transparent 30%),
                linear-gradient(135deg, var(--learning-orange), #ff8a1f);
            color: #fff;
            font-size: 22px;
            box-shadow: 0 13px 26px rgba(255, 91, 0, .28);
        }

        .learning-brand__text {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            min-width: 0;
        }

        .learning-brand__text strong {
            color: #111827;
            font-family: 'Battambang', 'Segoe UI', Arial, sans-serif;
            font-size: 25px;
            line-height: 1;
            font-weight: 900;
            letter-spacing: 0;
            white-space: nowrap;
        }

        .learning-brand__text strong span {
            color: var(--learning-orange);
        }

        .learning-brand__text small {
            min-height: 24px;
            display: inline-flex;
            align-items: center;
            max-width: 270px;
            overflow: hidden;
            padding: 0 10px;
            border: 1px solid rgba(37, 99, 235, .12);
            border-radius: 999px;
            background: var(--learning-blue-soft);
            color: var(--learning-blue);
            font-size: 11px;
            font-weight: 800;
            text-overflow: ellipsis;
            white-space: nowrap;
        }

        .learning-nav {
            align-items: center;
            gap: 8px;
            margin-left: auto;
            border: 1px solid rgba(226, 232, 240, .72);
            border-radius: 15px;
            background: rgba(248, 250, 252, .72);
            padding: 5px;
        }

        .learning-nav__link {
            position: relative;
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            border-radius: 11px;
            color: #667085;
            padding: 0 14px;
            font-size: 15px;
            font-weight: 900;
            white-space: nowrap;
            transition: background .18s ease, color .18s ease, box-shadow .18s ease, transform .18s ease;
        }

        .learning-nav__link i {
            font-size: 13px;
        }

        .learning-nav__link:hover,
        .learning-nav__link.is-active {
            background: #fff;
            color: var(--learning-orange);
            box-shadow: 0 8px 18px rgba(15, 23, 42, .08);
            transform: translateY(-1px);
        }

        .learning-search {
            width: min(390px, 29vw);
            align-items: center;
            min-height: 44px;
            padding: 0;
            border-radius: 12px;
            background: transparent;
            color: #7a8495;
            font-size: 14px;
            font-weight: 900;
            white-space: nowrap;
        }

        .learning-search__group {
            width: 100%;
            min-height: 46px;
            display: grid;
            grid-template-columns: 42px minmax(0, 1fr) auto 40px;
            align-items: center;
            overflow: hidden;
            border: 1px solid rgba(203, 213, 225, .86);
            border-radius: 15px;
            background: rgba(248, 250, 252, .88);
            box-shadow: inset 0 1px 0 rgba(255, 255, 255, .84);
            transition: border-color .18s ease, box-shadow .18s ease, background .18s ease, transform .18s ease;
        }

        .learning-search__group:focus-within {
            border-color: #93c5fd;
            background: #fff;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .10), 0 14px 28px rgba(15, 23, 42, .08);
            transform: translateY(-1px);
        }

        .learning-search__icon {
            color: #94a3b8;
            text-align: center;
        }

        .learning-search__input {
            width: 100%;
            min-width: 0;
            height: 42px;
            border: 0;
            outline: 0;
            background: transparent;
            color: #111827;
            font: inherit;
            font-weight: 700;
        }

        .learning-search__input::placeholder {
            color: #94a3b8;
            opacity: 1;
        }

        .learning-search__clear,
        .learning-search__button {
            width: 34px;
            height: 34px;
            display: inline-grid;
            place-items: center;
            border: 0;
            border-radius: 10px;
            background: transparent;
            color: #64748b;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .learning-search__clear:hover {
            background: #e2e8f0;
            color: #334155;
            transform: scale(1.03);
        }

        .learning-search__button {
            margin-right: 4px;
            background: linear-gradient(135deg, var(--learning-orange), #ff8a1f);
            color: #fff;
            box-shadow: 0 8px 16px rgba(255, 91, 0, .22);
        }

        .learning-search__button:hover {
            background: var(--learning-orange-dark);
            transform: translateY(-1px);
        }

        .learning-search a {
            color: #5f6878;
        }

        .learning-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-left: auto;
        }

        .learning-action,
        .learning-login,
        .learning-cta,
        .learning-language__button,
        .learning-user__button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 12px;
            font-size: 14px;
            font-weight: 900;
            white-space: nowrap;
            transition: transform .18s ease, box-shadow .18s ease, background .18s ease, color .18s ease, border-color .18s ease;
        }

        .learning-login:focus-visible,
        .learning-cta:focus-visible,
        .learning-language__button:focus-visible,
        .learning-user__button:focus-visible,
        .learning-nav__link:focus-visible,
        .learning-search__clear:focus-visible,
        .learning-search__button:focus-visible {
            outline: 0;
            box-shadow: 0 0 0 4px rgba(37, 99, 235, .14);
        }

        .learning-action--outline {
            padding: 0 18px;
            border: 1px solid #dbe3ee;
            background: #fff;
            color: #475569;
        }

        .learning-action--outline i {
            color: var(--learning-orange);
        }

        .learning-login {
            border: 1px solid transparent;
            padding: 0 14px;
            color: #111827;
        }

        .learning-login:hover {
            border-color: #fed7aa;
            background: #fff7ed;
            color: var(--learning-orange);
            transform: translateY(-1px);
        }

        .learning-cta {
            padding: 0 24px;
            background: linear-gradient(135deg, var(--learning-orange), #ff8a1f);
            color: #fff;
            box-shadow: 0 13px 22px rgba(255, 91, 0, .24);
        }

        .learning-cta:hover {
            color: #fff;
            background: var(--learning-orange-dark);
            transform: translateY(-1px);
        }

        .learning-user__button {
            padding: 0 14px;
            border: 1px solid rgba(226, 232, 240, .92);
            background: #fff;
            color: #111827;
            cursor: pointer;
        }

        .learning-user__button:hover,
        .learning-language__button:hover {
            border-color: #cbd5e1;
            background: #fff;
            box-shadow: 0 10px 22px rgba(15, 23, 42, .10);
            transform: translateY(-1px);
        }

        .learning-language__button {
            padding: 0 14px;
            border: 1px solid rgba(219, 227, 238, .96);
            background: rgba(248, 250, 252, .9);
            color: #475569;
            cursor: pointer;
        }

        .learning-language__button i {
            color: var(--learning-blue);
        }

        .learning-language__button.dropdown-toggle::after,
        .learning-user__button.dropdown-toggle::after {
            margin-left: 2px;
            opacity: .58;
        }

        .learning-language .dropdown-item.active,
        .learning-language .dropdown-item:active {
            background: #eaf1ff;
            color: #2563eb;
            font-weight: 900;
        }

        .learning-language .dropdown-menu,
        .learning-user .dropdown-menu {
            overflow: hidden;
            margin-top: 10px;
            border: 1px solid rgba(226, 232, 240, .92);
            border-radius: 14px;
            background: rgba(255, 255, 255, .98);
            box-shadow: var(--learning-shadow);
            padding: 6px;
        }

        .learning-language .dropdown-item,
        .learning-user .dropdown-item {
            min-height: 42px;
            display: flex;
            align-items: center;
            border-radius: 10px;
            color: #334155;
            font-weight: 800;
            transition: background .18s ease, color .18s ease, transform .18s ease;
        }

        .learning-language .dropdown-item:hover,
        .learning-user .dropdown-item:hover {
            background: #f8fafc;
            color: var(--learning-orange);
            transform: translateX(2px);
        }

        .learning-user .dropdown-divider {
            margin: 6px 4px;
        }

        .learning-user__button img {
            width: 32px;
            height: 32px;
            border: 2px solid #fff;
            border-radius: 50%;
            object-fit: cover;
            box-shadow: 0 0 0 1px rgba(203, 213, 225, .95);
        }

        .learning-search--mobile {
            width: min(100% - 32px, 720px);
            margin: 0 auto 14px;
        }

        .learning-nav--mobile {
            width: min(100% - 32px, 720px);
            display: flex;
            justify-content: space-between;
            margin: 0 auto 10px;
            overflow-x: auto;
            scrollbar-width: none;
        }

        .learning-nav--mobile::-webkit-scrollbar {
            display: none;
        }

        .learning-nav--mobile .learning-nav__link {
            flex: 1 0 auto;
            justify-content: center;
            min-width: 0;
            padding: 0 12px;
            font-size: 13px;
        }

        .learning-slideshow {
            min-height: 610px;
            display: flex;
            align-items: center;
            overflow: hidden;
            background:
                radial-gradient(circle, rgba(255, 255, 255, .14) 1px, transparent 1px),
                linear-gradient(115deg, #1843bf 0%, #25378f 48%, #171748 100%);
            background-size: 22px 22px, cover;
            color: #fff;
        }

        .learning-slideshow__inner {
            width: 100%;
            max-width: 1520px;
            display: grid;
            grid-template-columns: minmax(0, 1.1fr) minmax(420px, .82fr);
            align-items: center;
            gap: 74px;
            margin: 0 auto;
            padding: 70px 34px 82px;
        }

        .learning-slide-copy {
            max-width: 820px;
        }

        .learning-slide-badge {
            width: max-content;
            max-width: 100%;
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 9px;
            margin-bottom: 26px;
            padding: 0 18px;
            border: 1px solid rgba(255, 143, 35, .42);
            border-radius: 999px;
            background: rgba(255, 91, 0, .14);
            color: #ffb12d;
            font-size: 14px;
            font-weight: 900;
        }

        .learning-slide-copy h1 {
            margin: 0;
            color: #fff;
            font-size: 54px;
            line-height: 1.35;
            font-weight: 900;
            letter-spacing: 0;
        }

        .learning-slide-copy h1 span {
            display: block;
            color: #ffb21f;
        }

        .learning-slide-copy p {
            max-width: 760px;
            margin: 28px 0 38px;
            color: rgba(255, 255, 255, .86);
            font-size: 18px;
            line-height: 1.9;
            font-weight: 600;
        }

        .learning-slide-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 18px;
        }

        .learning-slide-btn {
            min-height: 58px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0 34px;
            border-radius: 13px;
            font-size: 17px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .learning-slide-btn:hover {
            text-decoration: none;
        }

        .learning-slide-btn--primary {
            background: var(--learning-orange);
            color: #fff;
            box-shadow: 0 18px 32px rgba(255, 91, 0, .25);
        }

        .learning-slide-btn--primary:hover {
            color: #fff;
            background: var(--learning-orange-dark);
        }

        .learning-slide-btn--ghost {
            border: 1px solid rgba(255, 255, 255, .20);
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .learning-slide-btn--ghost:hover {
            color: #fff;
            background: rgba(255, 255, 255, .13);
        }

        .learning-notice-card {
            align-self: center;
            min-height: 330px;
            padding: 28px 32px;
            border: 1px solid rgba(255, 255, 255, .12);
            border-radius: 28px;
            background: rgba(60, 83, 164, .62);
            box-shadow: 0 24px 60px rgba(5, 10, 45, .26);
            backdrop-filter: blur(4px);
        }

        .learning-notice-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            padding-bottom: 22px;
            border-bottom: 1px solid rgba(255, 255, 255, .14);
        }

        .learning-notice-title {
            display: inline-flex;
            align-items: center;
            gap: 14px;
            min-width: 0;
        }

        .learning-notice-title i {
            color: #ff9f1c;
            font-size: 24px;
        }

        .learning-notice-title strong {
            color: #fff;
            font-size: 21px;
            font-weight: 900;
            line-height: 1.4;
        }

        .learning-notice-head span {
            min-height: 24px;
            display: inline-flex;
            align-items: center;
            padding: 0 12px;
            border-radius: 999px;
            background: #16c784;
            color: #fff;
            font-size: 12px;
            font-weight: 900;
            white-space: nowrap;
        }

        .learning-notice-list {
            display: grid;
            gap: 26px;
            padding-top: 24px;
        }

        .learning-notice-item {
            display: grid;
            grid-template-columns: minmax(0, 1fr) auto;
            gap: 22px;
        }

        .learning-notice-item small,
        .learning-notice-item time {
            color: #ffb554;
            font-size: 13px;
            font-weight: 900;
        }

        .learning-notice-item h2 {
            margin: 8px 0 7px;
            color: #fff;
            font-size: 17px;
            line-height: 1.55;
            font-weight: 900;
        }

        .learning-notice-item p {
            margin: 0;
            color: rgba(255, 255, 255, .68);
            font-size: 14px;
            line-height: 1.7;
            font-weight: 600;
        }

        .learning-programs {
            overflow: hidden;
            background:
                linear-gradient(180deg, #ffffff 0%, #f8fafc 42%, #eef5ff 100%);
        }

        .learning-stats {
            max-width: 1460px;
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 18px;
            margin: 42px auto 0;
            padding: 0 34px 34px;
            border-bottom: 0;
            background: #fff;
            box-shadow: none;
        }

        .learning-stat {
            position: relative;
            overflow: hidden;
            min-height: 210px;
            display: flex;
            flex-direction: column;
            align-items: flex-start;
            justify-content: center;
            padding: 28px;
            border: 1px solid rgba(203, 213, 225, .82);
            border-radius: 8px;
            background:
                linear-gradient(145deg, rgba(255, 255, 255, .98), rgba(248, 250, 252, .92));
            box-shadow: 0 18px 38px rgba(15, 23, 42, .08);
            text-align: center;
            transition: transform .24s ease, box-shadow .24s ease, border-color .24s ease;
        }

        .learning-stat::after {
            content: "";
            position: absolute;
            right: -38px;
            bottom: -46px;
            width: 130px;
            height: 130px;
            border-radius: 50%;
            background: rgba(20, 93, 255, .07);
        }

        .learning-stat:hover {
            transform: translateY(-5px);
            border-color: rgba(20, 93, 255, .28);
            box-shadow: 0 24px 48px rgba(15, 23, 42, .12);
        }

        .learning-stat-icon {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            margin-bottom: 20px;
            border-radius: 8px;
            color: #fff;
            font-size: 19px;
            box-shadow: 0 12px 22px rgba(15, 23, 42, .14);
        }

        .learning-stat-icon--students {
            background: linear-gradient(135deg, #2563eb, #06b6d4);
        }

        .learning-stat-icon--courses {
            background: linear-gradient(135deg, #ff7a1a, #f59e0b);
        }

        .learning-stat-icon--staff {
            background: linear-gradient(135deg, #7c3aed, #db2777);
        }

        .learning-stat-icon--progress {
            background: linear-gradient(135deg, #16a34a, #14b8a6);
        }

        .learning-stat strong {
            display: block;
            color: #0f172a;
            font-size: 54px;
            line-height: 1;
            font-weight: 900;
            white-space: nowrap;
        }

        .learning-stat > span:not(.learning-stat-icon) {
            display: block;
            margin-top: 14px;
            color: #0f172a;
            font-size: 18px;
            font-weight: 900;
            text-align: left;
        }

        .learning-stat small {
            display: block;
            margin-top: 8px;
            color: #64748b;
            font-size: 14px;
            font-weight: 700;
            text-align: left;
        }

        .learning-programs__inner {
            max-width: 1520px;
            margin: 0 auto;
            padding: 86px 34px 96px;
        }

        .learning-section-head {
            max-width: 850px;
            margin: 0 auto 52px;
            text-align: center;
        }

        .learning-section-eyebrow {
            min-height: 32px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 16px;
            padding: 0 16px;
            border: 1px solid rgba(20, 93, 255, .15);
            border-radius: 999px;
            background: #eaf1ff;
            color: #145dff;
            font-size: 13px;
            font-weight: 900;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .learning-section-head h2 {
            margin: 0;
            color: #07152f;
            font-size: 42px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-section-head p {
            margin: 18px 0 0;
            color: #64748b;
            font-size: 17px;
            line-height: 1.9;
            font-weight: 600;
        }

        .learning-program-grid {
            display: grid;
            grid-template-columns: repeat(4, minmax(0, 1fr));
            gap: 22px;
        }

        .learning-program-card {
            position: relative;
            overflow: hidden;
            min-height: 300px;
            display: flex;
            flex-direction: column;
            padding: 28px;
            border: 1px solid rgba(203, 213, 225, .86);
            border-radius: 8px;
            background:
                linear-gradient(180deg, #ffffff 0%, #f8fbff 100%);
            box-shadow: 0 16px 34px rgba(15, 23, 42, .08);
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        }

        .learning-program-card::before {
            content: "";
            position: absolute;
            inset: 0 0 auto;
            height: 4px;
            background: linear-gradient(90deg, #145dff, #06b6d4);
            opacity: .85;
        }

        .learning-program-card:nth-child(2)::before {
            background: linear-gradient(90deg, #ff5b00, #f59e0b);
        }

        .learning-program-card:nth-child(3)::before {
            background: linear-gradient(90deg, #8b35ff, #06b6d4);
        }

        .learning-program-card:nth-child(4)::before {
            background: linear-gradient(90deg, #ec1680, #ff7a1a);
        }

        .learning-program-card:hover {
            transform: translateY(-7px);
            border-color: rgba(24, 62, 188, .22);
            box-shadow: 0 24px 52px rgba(15, 23, 42, .14);
        }

        .learning-program-year {
            width: max-content;
            min-height: 28px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 18px;
            padding: 0 11px;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            font-size: 12px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .learning-program-icon {
            width: 66px;
            height: 66px;
            display: grid;
            place-items: center;
            margin-bottom: 26px;
            border-radius: 8px;
            font-size: 28px;
            box-shadow: inset 0 0 0 1px rgba(255, 255, 255, .64);
        }

        .learning-program-icon--blue {
            background: #eaf1ff;
            color: #145dff;
        }

        .learning-program-icon--orange {
            background: #fff2e5;
            color: #ff5b00;
        }

        .learning-program-icon--purple {
            background: #f3e8ff;
            color: #8b35ff;
        }

        .learning-program-icon--pink {
            background: #fde7f3;
            color: #ec1680;
        }

        .learning-program-card h3 {
            margin: 0;
            color: #07152f;
            font-size: 20px;
            line-height: 1.45;
            font-weight: 900;
        }

        .learning-program-card p {
            margin: 12px 0 24px;
            color: #64748b;
            font-size: 15px;
            line-height: 1.75;
            font-weight: 600;
        }

        .learning-program-card a {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: max-content;
            max-width: 100%;
            margin-top: auto;
            padding: 0 18px;
            border: 1px solid rgba(20, 93, 255, .18);
            border-radius: 8px;
            background: #fff;
            color: #145dff;
            font-size: 15px;
            font-weight: 900;
            text-decoration: none;
            transition: background .2s ease, color .2s ease, border-color .2s ease;
        }

        .learning-program-card a:hover {
            border-color: #145dff;
            background: #145dff;
            color: #fff;
        }

        .learning-program-card a i {
            transition: transform .2s ease;
        }

        .learning-program-card:hover a i {
            transform: translateX(5px);
        }

        .learning-courses {
            background: #fff;
        }

        .learning-courses__inner {
            max-width: 1520px;
            margin: 0 auto;
            padding: 86px 34px 98px;
        }

        .learning-courses-head {
            display: flex;
            align-items: end;
            justify-content: space-between;
            gap: 28px;
            padding-bottom: 34px;
            border-bottom: 1px solid #e5e7eb;
        }

        .learning-courses-head h2 {
            margin: 0;
            color: #07152f;
            font-size: 39px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-courses-head p {
            max-width: 850px;
            margin: 12px 0 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-courses-head > a {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #145dff;
            font-size: 16px;
            font-weight: 900;
            text-decoration: none;
            white-space: nowrap;
        }

        .learning-courses-head > a i {
            transition: transform .2s ease;
        }

        .learning-courses-head > a:hover i {
            transform: translateX(5px);
        }

        .learning-course-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
            padding-top: 60px;
        }

        .learning-course-card {
            overflow: hidden;
            border: 1px solid #e1e7ef;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(15, 23, 42, .10);
            transition: transform .3s ease, box-shadow .3s ease, border-color .3s ease;
        }

        .learning-course-card:hover {
            transform: translateY(-9px);
            border-color: rgba(20, 93, 255, .22);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .15);
        }

        .learning-course-thumb {
            position: relative;
            height: 222px;
            overflow: hidden;
            background: #dbe4ef;
        }

        .learning-course-thumb img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform .4s ease;
        }

        .learning-course-card:hover .learning-course-thumb img {
            transform: scale(1.06);
        }

        .learning-course-thumb::after {
            content: "";
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, rgba(2, 6, 23, .22), rgba(2, 6, 23, 0) 55%);
            pointer-events: none;
        }

        .learning-course-tags {
            position: absolute;
            top: 14px;
            left: 14px;
            right: 14px;
            z-index: 1;
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .learning-course-tags span,
        .learning-course-tags strong {
            min-height: 32px;
            display: inline-flex;
            align-items: center;
            padding: 0 13px;
            border-radius: 9px;
            font-size: 14px;
            font-weight: 900;
            white-space: nowrap;
        }

        .learning-course-tags span {
            background: #f8fafc;
            color: #111827;
        }

        .learning-course-tags strong {
            background: #15c77a;
            color: #fff;
        }

        .learning-course-card:nth-child(n+2) .learning-course-tags strong {
            background: #ff9f0a;
        }

        .learning-course-body {
            padding: 26px;
        }

        .learning-course-rating {
            display: flex;
            align-items: center;
            gap: 5px;
            margin-bottom: 14px;
            color: #64748b;
            font-size: 15px;
            font-weight: 700;
        }

        .learning-course-rating i,
        .learning-course-rating strong {
            color: #ff9900;
        }

        .learning-course-card h3 {
            min-height: 56px;
            margin: 0;
            color: #07152f;
            font-size: 19px;
            line-height: 1.45;
            font-weight: 900;
        }

        .learning-course-card p {
            min-height: 72px;
            margin: 10px 0 18px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.7;
            font-weight: 600;
        }

        .learning-course-meta {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 9px;
            padding: 16px 0;
            border-top: 1px solid #edf1f6;
            color: #64748b;
            font-size: 12px;
            font-weight: 800;
        }

        .learning-course-meta span {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            min-width: 0;
            white-space: nowrap;
        }

        .learning-course-meta i {
            color: #94a3b8;
        }

        .learning-course-teacher {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 14px;
            margin: 4px 0 20px;
        }

        .learning-course-teacher span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            min-width: 0;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .learning-course-teacher img {
            width: 34px;
            height: 34px;
            flex: 0 0 34px;
            border-radius: 50%;
            object-fit: cover;
        }

        .learning-course-teacher strong {
            min-height: 32px;
            display: inline-flex;
            align-items: center;
            padding: 0 14px;
            border-radius: 10px;
            background: #eafff1;
            color: #0f9f5b;
            font-size: 13px;
            font-weight: 900;
            white-space: nowrap;
        }

        .learning-course-btn {
            min-height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            border-radius: 12px;
            background: #020817;
            color: #fff;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
        }

        .learning-course-btn:hover {
            color: #fff;
            text-decoration: none;
            background: #111827;
        }

        .learning-course-btn--light {
            background: #fff7ed;
            color: #ff5b00;
        }

        .learning-course-btn--light:hover {
            background: #ffedd5;
            color: #ff5b00;
        }

        .learning-course-pagination {
            display: flex;
            justify-content: center;
            margin-top: 42px;
        }

        .learning-course-pagination nav {
            width: 100%;
        }

        .learning-course-pagination nav > div:first-child {
            display: none;
        }

        .learning-course-pagination .flex {
            display: flex;
        }

        .learning-course-pagination .hidden {
            display: none;
        }

        .learning-course-pagination svg {
            width: 18px;
            height: 18px;
            display: inline-block;
            vertical-align: middle;
        }

        .learning-course-pagination a,
        .learning-course-pagination span {
            text-decoration: none;
        }

        .learning-course-pagination nav > div:last-child {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .learning-course-pagination nav > div:last-child > div:first-child {
            display: none;
        }

        .learning-course-pagination nav > div:last-child > div:last-child {
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .learning-course-pagination nav > div:last-child > div:last-child > span {
            display: inline-flex;
            align-items: center;
            gap: 0;
            overflow: hidden;
            border: 1px solid #dbe3ee;
            border-radius: 12px;
            background: #fff;
            box-shadow: 0 8px 20px rgba(15, 23, 42, .08);
        }

        .learning-course-pagination nav > div:last-child > div:last-child > span > * {
            min-width: 44px;
            height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            border-left: 1px solid #dbe3ee;
            color: #1f2937;
            font-size: 14px;
            font-weight: 900;
        }

        .learning-course-pagination nav > div:last-child > div:last-child > span > *:first-child {
            border-left: 0;
        }

        .learning-course-pagination a:hover {
            background: #f8fafc;
            color: var(--learning-orange);
        }

        .learning-course-pagination [aria-current="page"] span {
            background: var(--learning-orange);
            color: #fff;
        }

        .learning-course-pagination [aria-disabled="true"] span {
            color: #94a3b8;
            background: #f8fafc;
        }

        .learning-catalog {
            background: #fff;
        }

        .learning-catalog__inner {
            max-width: 1520px;
            margin: 0 auto;
            padding: 88px 34px 96px;
        }

        .learning-catalog-head {
            padding-bottom: 30px;
            border-bottom: 1px solid #e5e7eb;
        }

        .learning-catalog-head h2 {
            margin: 0;
            color: #07152f;
            font-size: 42px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-catalog-head p {
            max-width: 980px;
            margin: 12px 0 0;
            color: #64748b;
            font-size: 17px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-catalog-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 22px;
            margin: 40px 0;
            padding: 20px;
            border: 1px solid #e6ebf2;
            border-radius: 18px;
            background: #f8fafc;
        }

        .learning-catalog-search {
            min-height: 48px;
            display: flex;
            align-items: center;
            gap: 12px;
            width: min(560px, 100%);
            margin: 0;
            padding: 0 18px;
            border: 1px solid #dbe3ee;
            border-radius: 13px;
            background: #fff;
            color: #94a3b8;
        }

        .learning-catalog-search input {
            width: 100%;
            border: 0;
            outline: 0;
            background: transparent;
            color: #0f172a;
            font: inherit;
            font-size: 15px;
            font-weight: 700;
        }

        .learning-catalog-sort {
            min-height: 48px;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 0 18px;
            border: 1px solid #dbe3ee;
            border-radius: 13px;
            background: #fff;
            color: #0f172a;
            font: inherit;
            font-size: 14px;
            font-weight: 900;
            box-shadow: 0 3px 8px rgba(15, 23, 42, .08);
            cursor: pointer;
        }

        .learning-catalog-layout {
            display: grid;
            grid-template-columns: 350px minmax(0, 1fr);
            gap: 38px;
            align-items: start;
        }

        .learning-catalog-filter {
            position: sticky;
            top: 104px;
            padding: 28px 26px;
            border: 1px solid #e6ebf2;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 3px 12px rgba(15, 23, 42, .08);
        }

        .learning-filter-head {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-bottom: 28px;
        }

        .learning-filter-head span {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            color: #0f172a;
            font-size: 17px;
            font-weight: 900;
        }

        .learning-filter-head i,
        .learning-filter-head button {
            color: var(--learning-orange);
        }

        .learning-filter-head button,
        .learning-filter-group button {
            border: 0;
            background: transparent;
            font: inherit;
            cursor: pointer;
        }

        .learning-filter-head button {
            font-size: 13px;
            font-weight: 900;
        }

        .learning-filter-group {
            display: grid;
            gap: 10px;
            margin-top: 24px;
        }

        .learning-filter-group h3 {
            margin: 0 0 8px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 900;
        }

        .learning-filter-group button {
            min-height: 36px;
            padding: 0 14px;
            border-radius: 10px;
            color: #475569;
            font-size: 14px;
            font-weight: 900;
            text-align: left;
            transition: background .18s ease, color .18s ease;
        }

        .learning-filter-group button:hover,
        .learning-filter-group button.is-active {
            background: #fff7ed;
            color: #f04d00;
        }

        .learning-catalog-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 28px;
        }

        .learning-catalog-card {
            overflow: hidden;
            border: 1px solid #e1e7ef;
            border-radius: 18px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(15, 23, 42, .10);
            transition: transform .28s ease, box-shadow .28s ease;
        }

        .learning-catalog-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .14);
        }

        .learning-catalog-card.is-hidden {
            display: none;
        }

        .learning-catalog-empty {
            display: none;
            grid-column: 1 / -1;
            padding: 38px;
            border: 1px dashed #cbd5e1;
            border-radius: 18px;
            color: #64748b;
            text-align: center;
            font-weight: 900;
        }

        .learning-course-detail {
            min-height: calc(100vh - 82px);
            display: grid;
            grid-template-columns: 438px minmax(0, 1fr);
            background: #fff;
        }

        .course-detail-sidebar {
            border-right: 1px solid #d9dee7;
            background: #fff;
        }

        .course-detail-cover {
            height: 248px;
            overflow: hidden;
            background: #dbe4ef;
        }

        .course-detail-cover img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .course-detail-summary {
            padding: 32px;
            border-bottom: 1px solid #d9dee7;
        }

        .course-detail-summary h1 {
            margin: 0 0 24px;
            color: #252538;
            font-size: 24px;
            line-height: 1.35;
            font-weight: 900;
        }

        .course-detail-progress {
            height: 10px;
            overflow: hidden;
            border-radius: 999px;
            background: #dbe7e4;
        }

        .course-detail-progress span {
            display: block;
            width: 100%;
            height: 100%;
            border-radius: inherit;
            background: #28aa9b;
        }

        .course-detail-summary strong {
            display: block;
            margin-top: 12px;
            color: #252525;
            font-size: 28px;
            line-height: 1;
            font-weight: 900;
            text-align: center;
        }

        .course-detail-summary small {
            font-size: 16px;
            font-weight: 900;
        }

        .course-detail-menu {
            display: grid;
            gap: 10px;
            padding: 32px 0;
        }

        .course-detail-menu a {
            min-height: 76px;
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 0 28px;
            border-left: 4px solid transparent;
            color: #30363c;
            font-size: 20px;
            font-weight: 800;
            text-decoration: none;
        }

        .course-detail-menu a.is-active {
            border-left-color: #07152f;
            color: #07152f;
        }

        .course-detail-menu i {
            width: 24px;
            text-align: center;
        }

        .course-detail-built {
            width: max-content;
            margin: 24px auto 34px;
            padding: 4px 10px;
            border-radius: 5px;
            background: #050505;
            color: #fff;
            font-size: 20px;
            line-height: 1.35;
        }

        .course-detail-built strong {
            color: #d4ff00;
        }

        .course-detail-content {
            padding: 94px 66px;
        }

        .course-detail-content h2 {
            margin: 0 0 44px;
            color: #07152f;
            font-size: 30px;
            font-weight: 900;
        }

        .course-next-btn {
            min-height: 44px;
            display: flex;
            align-items: center;
            width: 100%;
            margin-bottom: 38px;
            border-radius: 7px;
            background: #d6eeec;
            color: #fff;
            font-size: 22px;
            font-weight: 900;
            text-decoration: none;
        }

        .course-next-btn:hover {
            color: #fff;
            text-decoration: none;
        }

        .course-next-btn::before {
            content: "";
            width: 0;
        }

        .course-next-btn {
            gap: 12px;
        }

        .course-next-btn {
            padding-left: 24px;
        }

        .course-next-btn i {
            margin-left: 8px;
        }

        .course-next-btn > * {
            position: relative;
            z-index: 1;
        }

        .course-next-btn {
            background: linear-gradient(90deg, #5bc1b5 0 260px, #d6eeec 260px 100%);
        }

        .course-module {
            margin-top: 28px;
        }

        .course-module h3 {
            margin: 0 0 16px 20px;
            color: #07152f;
            font-size: 22px;
            font-weight: 900;
        }

        .course-lesson-list {
            background: #fafafa;
        }

        .course-lesson {
            min-height: 66px;
            display: grid;
            grid-template-columns: 46px 46px minmax(0, 1fr);
            align-items: center;
            gap: 12px;
            padding: 0 20px;
            border-bottom: 1px solid #eceff3;
            color: #17313a;
            text-decoration: none;
        }

        .course-lesson:hover {
            background: #f4fbfa;
            color: #17313a;
            text-decoration: none;
        }

        .course-check {
            width: 25px;
            height: 25px;
            display: grid;
            place-items: center;
            border-radius: 50%;
            background: #25aaa1;
            color: #fff;
            font-size: 13px;
        }

        .course-video {
            width: 30px;
            height: 24px;
            display: grid;
            place-items: center;
            border: 2px solid #526569;
            border-radius: 2px;
            color: #526569;
            font-size: 14px;
        }

        .course-lesson strong {
            font-size: 19px;
            line-height: 1.4;
            font-weight: 500;
        }

        .course-lesson-menu {
            gap: 0;
            padding: 36px 0 0;
        }

        .course-lesson-menu h2 {
            margin: 28px 20px 16px;
            color: #07152f;
            font-size: 20px;
            font-weight: 900;
        }

        .course-lesson-menu a {
            min-height: 82px;
            display: grid;
            grid-template-columns: 36px 34px minmax(0, 1fr);
            gap: 10px;
            padding: 10px 20px;
            border-left: 0;
            border-bottom: 1px solid #e8eef3;
            color: #17313a;
            font-size: 18px;
        }

        .course-lesson-menu a.is-active {
            background: #9de6de;
            color: #17313a;
        }

        .course-lesson-menu a strong {
            font-weight: 500;
        }

        .course-lesson-menu a small {
            display: inline;
            color: inherit;
            font-size: inherit;
        }

        .course-lesson-menu a.is-active .course-check {
            background: transparent;
            border: 2px solid #23aaa0;
            color: transparent;
        }

        .is-lesson-view {
            grid-template-columns: 438px minmax(0, 1fr);
        }

        .course-player {
            padding: 36px 66px 80px;
            background: #fff;
        }

        .course-player-head {
            padding-bottom: 46px;
            border-bottom: 1px solid #222;
        }

        .course-player-head h1 {
            display: flex;
            align-items: center;
            gap: 16px;
            margin: 0;
            color: #111827;
            font-size: 30px;
            line-height: 1.35;
            font-weight: 900;
        }

        .course-player-stage {
            max-width: 980px;
            margin: 90px auto 0;
        }

        .course-media-toolbar {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 18px;
            margin-bottom: 22px;
        }

        .course-media-tabs,
        .course-media-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            flex-wrap: wrap;
        }

        .course-media-tabs button,
        .course-media-actions button {
            min-height: 42px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 16px;
            border: 1px solid #dbe3ee;
            border-radius: 9px;
            background: #fff;
            color: #0f172a;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
        }

        .course-media-tabs button.is-active {
            border-color: #25aaa1;
            background: #e8fbf8;
            color: #168d84;
        }

        .course-media-actions button {
            background: #f8fafc;
        }

        .course-media-shell {
            padding: 0;
            background: #fff;
        }

        .course-media-panel {
            display: none;
        }

        .course-media-panel.is-active {
            display: block;
        }

        .course-video-preview {
            background: #fff;
        }

        .learning-course-detail.is-sidebar-hidden {
            grid-template-columns: 0 minmax(0, 1fr);
        }

        .learning-course-detail.is-sidebar-hidden .course-detail-sidebar {
            display: none;
        }

        .learning-course-detail.is-sidebar-hidden .course-player-stage {
            max-width: 1120px;
        }

        .course-media-shell.is-fullscreen {
            position: fixed;
            inset: 0;
            z-index: 3000;
            overflow: auto;
            padding: 42px;
            background: #fff;
        }

        .course-media-shell.is-fullscreen .course-video-preview,
        .course-media-shell.is-fullscreen .course-document-preview {
            max-width: 1180px;
            margin: 0 auto;
        }

        .course-video-title {
            max-width: 975px;
            margin: 0 auto 58px;
            padding: 34px 24px;
            background: #f47a2a;
            color: #fff;
            font-size: 44px;
            line-height: 1.25;
            font-weight: 500;
            text-align: center;
        }

        .course-video-line {
            height: 3px;
            margin: 0 0 20px;
            background: #8d8d8d;
        }

        .course-instructor-preview {
            display: grid;
            grid-template-columns: 310px minmax(0, 1fr);
            gap: 36px;
            align-items: center;
        }

        .course-instructor-preview img {
            width: 310px;
            height: 310px;
            border-radius: 50%;
            object-fit: cover;
        }

        .course-instructor-preview h2,
        .course-instructor-preview p {
            margin: 0 0 14px;
            color: #050505;
            font-size: 31px;
            line-height: 1.25;
            font-weight: 500;
        }

        .course-document-preview {
            padding: 24px;
            border: 1px solid #dbe3ee;
            border-radius: 12px;
            background: #f8fafc;
        }

        .course-document-page {
            max-width: 860px;
            min-height: 540px;
            margin: 0 auto;
            padding: 54px;
            border: 1px solid #e5e7eb;
            border-radius: 8px;
            background: #fff;
            box-shadow: 0 12px 30px rgba(15, 23, 42, .08);
        }

        .course-document-page span {
            color: #25aaa1;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .course-document-page h2 {
            margin: 14px 0 18px;
            color: #07152f;
            font-size: 34px;
            font-weight: 900;
        }

        .course-document-page p,
        .course-document-page li {
            color: #334155;
            font-size: 18px;
            line-height: 1.8;
            font-weight: 600;
        }

        .course-document-page ul {
            display: grid;
            gap: 12px;
            margin-top: 24px;
        }

        .course-play-button {
            width: 136px;
            height: 136px;
            display: grid;
            place-items: center;
            margin: 0 0 -5px 100px;
            border: 0;
            border-radius: 50%;
            background: rgba(170, 170, 170, .62);
            color: #fff;
            font-size: 58px;
            cursor: pointer;
        }

        .course-player-actions {
            display: flex;
            justify-content: space-between;
            gap: 18px;
            margin-top: 54px;
        }

        .course-outline-link {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            padding: 0 18px;
            border-radius: 9px;
            background: #f1f5f9;
            color: #0f172a;
            font-weight: 900;
            text-decoration: none;
        }

        .course-outline-link.is-next {
            background: #25aaa1;
            color: #fff;
        }

        .course-outline-link:hover {
            color: inherit;
            text-decoration: none;
        }

        .course-outline-link.is-next:hover {
            color: #fff;
        }

        .course-prerequisites {
            max-width: 980px;
            margin: 74px auto 0;
            color: #07152f;
        }

        .course-prerequisites h2 {
            margin: 0 0 24px;
            font-size: 30px;
            font-weight: 900;
            text-decoration: underline;
        }

        .course-prerequisites h3 {
            margin: 28px 0 18px;
            font-size: 21px;
            font-weight: 900;
        }

        .course-prerequisites ul {
            display: grid;
            gap: 18px;
            margin: 0 0 0 28px;
            padding-left: 22px;
            font-size: 21px;
            line-height: 1.55;
        }

        .course-prerequisites a {
            color: #00a6a6;
            text-decoration: underline;
        }

        .course-complete-row {
            display: flex;
            justify-content: center;
            margin: 60px 0 42px;
        }

        .course-complete-btn {
            min-height: 52px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
            padding: 0 22px;
            border-radius: 7px;
            background: #25aaa1;
            color: #fff;
            font-size: 20px;
            font-weight: 900;
            text-decoration: none;
        }

        .course-complete-btn:hover {
            color: #fff;
            text-decoration: none;
            background: #209d94;
        }

        .course-discussion {
            position: relative;
            max-width: 100%;
            margin: 0 auto;
            border: 1px solid #d5dde5;
            border-radius: 5px;
            background: #fff;
        }

        .course-discussion-label {
            position: absolute;
            top: -1px;
            left: -1px;
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            padding: 0 18px;
            border-radius: 4px;
            background: #20302d;
            color: #fff;
            font-size: 18px;
            font-weight: 900;
        }

        .course-discussion-inner {
            padding: 56px 42px 42px;
        }

        .course-discussion h2 {
            margin: 0 0 34px;
            color: #07152f;
            font-size: 24px;
            font-weight: 900;
        }

        .course-comment-form {
            display: grid;
            grid-template-columns: 98px minmax(0, 1fr);
            gap: 28px;
            margin-bottom: 28px;
        }

        .course-comment-avatar img,
        .course-comment img {
            width: 76px;
            height: 76px;
            border-radius: 50%;
            object-fit: cover;
            background: #d9d9d9;
        }

        .course-comment-box {
            position: relative;
            padding: 22px 26px;
            border-radius: 5px;
            background: #f3f4f8;
        }

        .course-comment-box::before {
            content: "";
            position: absolute;
            left: -14px;
            top: 28px;
            width: 28px;
            height: 28px;
            background: #f3f4f8;
            transform: rotate(45deg);
        }

        .course-comment-box strong,
        .course-comment strong {
            display: block;
            margin-bottom: 12px;
            color: #526075;
            font-size: 19px;
            font-weight: 900;
        }

        .course-comment-box textarea {
            width: 100%;
            min-height: 104px;
            resize: vertical;
            padding: 16px 18px;
            border: 1px solid #cfd7e2;
            border-radius: 7px;
            background: #fff;
            color: #07152f;
            font: inherit;
            font-size: 16px;
            outline: 0;
        }

        .course-comment-actions {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 16px;
            margin-top: 14px;
        }

        .course-comment-actions small {
            color: #7b8798;
            font-size: 13px;
            font-weight: 700;
        }

        .course-comment-actions button {
            min-height: 40px;
            padding: 0 16px;
            border: 0;
            border-radius: 7px;
            background: #25aaa1;
            color: #fff;
            font: inherit;
            font-weight: 900;
            cursor: pointer;
        }

        .course-comment-list {
            display: grid;
            gap: 16px;
            margin-left: 126px;
        }

        .course-comment {
            display: grid;
            grid-template-columns: 54px minmax(0, 1fr);
            gap: 16px;
            align-items: start;
        }

        .course-comment img {
            width: 54px;
            height: 54px;
        }

        .course-comment div {
            padding: 16px 18px;
            border-radius: 7px;
            background: #f8fafc;
        }

        .course-comment p {
            margin: 0;
            color: #344054;
            font-size: 15px;
            line-height: 1.7;
            font-weight: 600;
        }

        .course-comment small {
            display: block;
            margin: -6px 0 10px;
            color: #7b8798;
            font-size: 12px;
            font-weight: 700;
        }

        .course-discussion-image {
            min-height: 38px;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            margin-top: 10px;
            margin-right: 10px;
            border: 1px solid #cfd7e2;
            border-radius: 6px;
            background: #fff;
            color: #52627a;
            padding: 0 12px;
            font-size: 14px;
            font-weight: 900;
            cursor: pointer;
        }

        .course-discussion-image input {
            position: absolute;
            width: 1px;
            height: 1px;
            opacity: 0;
            pointer-events: none;
        }

        .course-discussion-error {
            display: block;
            margin-top: 8px;
            color: #b42318;
            font-size: 13px;
            font-weight: 800;
        }

        .course-discussion-login,
        .course-discussion-empty {
            border-radius: 7px;
            background: #f8fafc;
            color: #52627a;
            padding: 16px 18px;
            font-weight: 800;
        }

        .course-comment .course-discussion-post-image {
            width: min(420px, 100%);
            height: auto;
            max-height: 280px;
            display: block;
            margin-top: 12px;
            border-radius: 7px;
            object-fit: contain;
            background: #e8eef6;
        }

        .course-comment .course-discussion-actions,
        .course-discussion-reply > div .course-discussion-actions {
            display: flex;
            align-items: center;
            gap: 10px;
            margin-top: 12px;
            padding: 0;
            border-radius: 0;
            background: transparent;
        }

        .course-discussion-react {
            min-height: 34px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border: 1px solid #d8e1ee;
            border-radius: 999px;
            background: #fff;
            color: #52627a;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 900;
            transition: background-color .18s ease, border-color .18s ease, color .18s ease, transform .18s ease, box-shadow .18s ease;
        }

        .course-discussion-react i {
            color: #9aa8ba;
            transition: color .18s ease, transform .18s ease;
        }

        .course-discussion-react strong {
            color: inherit;
            font-size: 12px;
        }

        .course-discussion-react:hover,
        .course-discussion-react:focus-visible {
            border-color: #f5a4b8;
            color: #d92d5c;
            box-shadow: 0 8px 20px rgba(217, 45, 92, .12);
            transform: translateY(-1px);
        }

        .course-discussion-react:hover i,
        .course-discussion-react:focus-visible i,
        .course-discussion-react.is-reacted i {
            color: #e11d48;
            transform: scale(1.08);
        }

        .course-discussion-react.is-reacted {
            border-color: #fecdd3;
            background: #fff1f2;
            color: #be123c;
        }

        .course-discussion-react.is-pulsing i {
            animation: discussion-heart-pulse .42s ease;
        }

        .course-discussion-reaction-count {
            min-height: 32px;
            display: inline-flex;
            align-items: center;
            gap: 7px;
            border-radius: 999px;
            background: #fff;
            color: #52627a;
            padding: 0 11px;
            font-size: 13px;
            font-weight: 900;
        }

        .course-discussion-reaction-count i {
            color: #e11d48;
        }

        @keyframes discussion-heart-pulse {
            0% {
                transform: scale(1);
            }

            45% {
                transform: scale(1.36);
            }

            100% {
                transform: scale(1.04);
            }
        }

        .course-discussion-replies {
            display: grid;
            gap: 12px;
            margin-top: 16px;
            padding: 0;
            background: transparent;
        }

        .course-discussion-reply {
            display: grid;
            grid-template-columns: 40px minmax(0, 1fr);
            gap: 10px;
            padding: 0;
            background: transparent;
        }

        .course-discussion-reply img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            object-fit: cover;
        }

        .course-discussion-reply > div {
            padding: 12px 14px;
            border: 1px solid #e5ebf3;
            border-radius: 7px;
            background: #fff;
        }

        .course-discussion-reply-form {
            display: grid;
            gap: 8px;
            margin-top: 4px;
            padding: 0;
            background: transparent;
        }

        .course-discussion-reply-form textarea {
            width: 100%;
            min-height: 72px;
            resize: vertical;
            border: 1px solid #d9e2ef;
            border-radius: 7px;
            background: #fff;
            color: #26364b;
            padding: 10px 12px;
            outline: 0;
        }

        .course-discussion-reply-form button {
            justify-self: start;
            min-height: 36px;
            border: 0;
            border-radius: 6px;
            background: #237dbe;
            color: #fff;
            padding: 0 14px;
            font-weight: 900;
        }

        .learning-cta-band {
            min-height: 495px;
            display: flex;
            align-items: center;
            background:
                radial-gradient(circle, rgba(255, 255, 255, .20) 1px, transparent 1px),
                linear-gradient(135deg, #ff6800 0%, #ff8c00 100%);
            background-size: 25px 25px, cover;
            color: #fff;
        }

        .learning-cta-band__inner {
            width: 100%;
            max-width: 900px;
            margin: 0 auto;
            padding: 70px 24px;
            text-align: center;
        }

        .learning-cta-icon {
            width: 66px;
            height: 66px;
            display: grid;
            place-items: center;
            margin: 0 auto 26px;
            color: rgba(255, 255, 255, .76);
            font-size: 45px;
        }

        .learning-cta-band h2 {
            margin: 0;
            color: #fff;
            font-size: 38px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-cta-band p {
            max-width: 780px;
            margin: 28px auto 34px;
            color: rgba(255, 255, 255, .90);
            font-size: 17px;
            line-height: 1.9;
            font-weight: 700;
        }

        .learning-cta-band__actions {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px;
        }

        .learning-cta-band__actions a {
            min-height: 44px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 9px;
            padding: 0 24px;
            border: 1px solid rgba(255, 255, 255, .34);
            border-radius: 13px;
            background: rgba(255, 255, 255, .12);
            color: #fff;
            font-size: 15px;
            font-weight: 900;
            text-decoration: none;
            transition: background .2s ease, transform .2s ease;
        }

        .learning-cta-band__actions a:hover {
            transform: translateY(-2px);
            background: rgba(255, 255, 255, .20);
            color: #fff;
            text-decoration: none;
        }

        .learning-services {
            background: #fff;
        }

        .learning-services__inner {
            max-width: 920px;
            margin: 0 auto;
            padding: 95px 24px 72px;
            text-align: center;
        }

        .learning-services h2 {
            margin: 0;
            color: #07152f;
            font-size: 39px;
            line-height: 1.38;
            font-weight: 900;
        }

        .learning-services p {
            margin: 18px auto 0;
            color: #64748b;
            font-size: 17px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-news {
            background: #fff;
        }

        .learning-news__inner {
            max-width: 1520px;
            margin: 0 auto;
            padding: 0 34px 98px;
        }

        .learning-news-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 40px;
        }

        .learning-news-card {
            min-height: 265px;
            padding: 32px;
            border: 1px solid #e5eaf1;
            border-radius: 18px;
            background: #f8fafc;
            transition: transform .28s ease, box-shadow .28s ease, border-color .28s ease;
        }

        .learning-news-card.is-featured {
            background: #fff;
            border-color: #cfe0ff;
        }

        .learning-news-card:hover {
            transform: translateY(-7px);
            box-shadow: 0 18px 38px rgba(15, 23, 42, .12);
        }

        .learning-news-meta {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            margin-bottom: 22px;
            color: #94a3b8;
            font-size: 13px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .learning-news-meta span,
        .learning-news-card a {
            color: #145dff;
        }

        .learning-news-card h2 {
            margin: 0;
            color: #07152f;
            font-size: 20px;
            line-height: 1.55;
            font-weight: 900;
        }

        .learning-news-card p {
            min-height: 64px;
            margin: 18px 0 22px;
            color: #64748b;
            font-size: 15px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-news-card a {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            padding-top: 16px;
            border-top: 1px solid #e7edf5;
            width: 100%;
            font-size: 14px;
            font-weight: 900;
            text-decoration: none;
        }

        .learning-news-card a i {
            transition: transform .2s ease;
        }

        .learning-news-card a:hover i {
            transform: translateX(5px);
        }

        .learning-faq {
            border-top: 1px solid #edf1f6;
            background: #f8fafc;
        }

        .learning-faq__inner {
            max-width: 940px;
            margin: 0 auto;
            padding: 98px 24px 94px;
        }

        .learning-faq-head {
            margin-bottom: 58px;
            text-align: center;
        }

        .learning-faq-head h2 {
            margin: 0;
            color: #07152f;
            font-size: 40px;
            line-height: 1.35;
            font-weight: 900;
        }

        .learning-faq-head p {
            margin: 16px 0 0;
            color: #64748b;
            font-size: 16px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-faq-list {
            display: grid;
            gap: 20px;
        }

        .learning-faq-item {
            overflow: hidden;
            border: 1px solid #e1e7ef;
            border-radius: 16px;
            background: #fff;
            box-shadow: 0 3px 10px rgba(15, 23, 42, .08);
        }

        .learning-faq-question {
            width: 100%;
            min-height: 76px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            padding: 0 26px;
            border: 0;
            background: transparent;
            color: #07152f;
            font: inherit;
            font-size: 18px;
            font-weight: 900;
            text-align: left;
            cursor: pointer;
        }

        .learning-faq-question i {
            color: #64748b;
            transition: transform .22s ease;
        }

        .learning-faq-item.is-open .learning-faq-question i {
            transform: rotate(180deg);
        }

        .learning-faq-answer {
            display: none;
            padding: 0 26px 24px;
            color: #64748b;
            font-size: 15px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-faq-item.is-open .learning-faq-answer {
            display: block;
        }

        .learning-faq-answer p {
            margin: 0;
            padding-top: 18px;
            border-top: 1px solid #edf1f6;
        }

        .learning-footer {
            background: #07152f;
            color: #dbe7ff;
        }

        .learning-footer__inner {
            max-width: 1520px;
            display: grid;
            grid-template-columns: minmax(280px, 1.4fr) repeat(3, minmax(180px, .7fr));
            gap: 42px;
            margin: 0 auto;
            padding: 62px 34px;
        }

        .learning-footer-logo {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            color: #fff;
            text-decoration: none;
        }

        .learning-footer-logo:hover {
            color: #fff;
            text-decoration: none;
        }

        .learning-footer-logo span {
            width: 44px;
            height: 44px;
            display: grid;
            place-items: center;
            border-radius: 12px;
            background: var(--learning-orange);
        }

        .learning-footer-logo strong,
        .learning-footer h3 {
            font-size: 20px;
            font-weight: 900;
        }

        .learning-footer-brand p,
        .learning-footer-contact p {
            margin: 18px 0 0;
            color: #aab8d2;
            font-size: 15px;
            line-height: 1.8;
            font-weight: 600;
        }

        .learning-footer h3 {
            margin: 0 0 18px;
            color: #fff;
        }

        .learning-footer-links,
        .learning-footer-contact {
            display: grid;
            align-content: start;
            gap: 10px;
        }

        .learning-footer-links a,
        .learning-footer-contact a {
            color: #aab8d2;
            font-size: 15px;
            font-weight: 700;
            text-decoration: none;
        }

        .learning-footer-links a:hover,
        .learning-footer-contact a:hover {
            color: #fff;
        }

        .learning-footer-contact p i {
            width: 20px;
            color: var(--learning-orange);
        }

        .learning-footer-contact div {
            display: flex;
            gap: 10px;
            margin-top: 14px;
        }

        .learning-footer-contact div a {
            width: 38px;
            height: 38px;
            display: grid;
            place-items: center;
            border-radius: 10px;
            background: rgba(255, 255, 255, .08);
            color: #fff;
        }

        .learning-footer-bottom {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 20px;
            max-width: 1520px;
            margin: 0 auto;
            padding: 22px 34px;
            border-top: 1px solid rgba(255, 255, 255, .10);
            color: #8ea0bf;
            font-size: 14px;
            font-weight: 700;
        }

        .reveal-item {
            opacity: 0;
            transform: translateY(28px);
            transition: opacity .7s ease, transform .7s ease;
            transition-delay: var(--reveal-delay, 0ms);
        }

        .reveal-item.is-visible {
            opacity: 1;
            transform: translateY(0);
        }

        @media (max-width: 1200px) {
            .learning-navbar__inner {
                gap: 12px;
                padding: 0 20px;
            }

            .learning-brand {
                min-width: 220px;
            }

            .learning-brand__text small {
                max-width: 210px;
            }

            .learning-search {
                width: min(320px, 27vw);
            }

            .learning-actions {
                gap: 8px;
            }

            .learning-slideshow__inner {
                grid-template-columns: 1fr;
                gap: 42px;
            }

            .learning-notice-card {
                max-width: 760px;
            }

            .learning-program-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .learning-course-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .learning-catalog-layout {
                grid-template-columns: 280px minmax(0, 1fr);
                gap: 24px;
            }

            .learning-catalog-grid {
                grid-template-columns: repeat(2, minmax(0, 1fr));
            }

            .learning-news-grid,
            .learning-footer__inner {
                grid-template-columns: 1fr;
            }
        }

        @media (max-width: 992px) {
            .learning-navbar {
                height: auto;
                min-height: 90px;
            }

            .learning-navbar__inner {
                flex-wrap: wrap;
                justify-content: space-between;
                min-height: 76px;
                padding: 14px 16px;
            }

            .learning-brand {
                min-width: 0;
            }

            .learning-brand__text {
                align-items: flex-start;
                flex-direction: column;
                gap: 5px;
            }

            .learning-actions {
                margin-left: 0;
            }

            .frontend-main {
                padding-top: 156px;
            }

            .learning-slideshow {
                min-height: auto;
            }

            .learning-slideshow__inner {
                padding: 52px 16px 64px;
            }

            .learning-slide-copy h1 {
                font-size: 38px;
            }

            .learning-slide-copy p {
                font-size: 16px;
            }

            .learning-stats {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                margin-top: 0;
                padding: 44px 16px 28px;
            }

            .learning-stat {
                min-height: 190px;
                padding: 24px;
            }

            .learning-programs__inner {
                padding: 70px 16px;
            }

            .learning-section-head h2 {
                font-size: 31px;
            }

            .learning-courses__inner {
                padding: 68px 16px;
            }

            .learning-catalog__inner {
                padding: 68px 16px;
            }

            .learning-courses-head {
                align-items: start;
                flex-direction: column;
            }

            .learning-courses-head h2,
            .learning-catalog-head h2 {
                font-size: 31px;
            }

            .learning-catalog-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .learning-catalog-search,
            .learning-catalog-sort {
                width: 100%;
            }

            .learning-catalog-layout {
                grid-template-columns: 1fr;
            }

            .learning-catalog-filter {
                position: static;
            }

            .learning-course-detail {
                grid-template-columns: 1fr;
            }

            .course-detail-sidebar {
                border-right: 0;
                border-bottom: 1px solid #d9dee7;
            }

            .course-detail-content {
                padding: 52px 16px;
            }

            .course-detail-menu {
                grid-template-columns: repeat(2, minmax(0, 1fr));
                padding: 16px;
            }

            .course-detail-menu a {
                min-height: 58px;
                border-left: 0;
                border-bottom: 3px solid transparent;
                padding: 0 12px;
                font-size: 16px;
            }

            .course-detail-menu a.is-active {
                border-bottom-color: #07152f;
            }

            .course-lesson-menu {
                grid-template-columns: 1fr;
            }

            .course-lesson-menu a {
                border-bottom: 1px solid #e8eef3;
            }

            .course-player {
                padding: 36px 16px 64px;
            }

            .course-player-stage {
                margin-top: 48px;
            }

            .course-media-toolbar {
                align-items: stretch;
                flex-direction: column;
            }

            .course-media-tabs,
            .course-media-actions,
            .course-media-tabs button,
            .course-media-actions button {
                width: 100%;
            }

            .course-instructor-preview {
                grid-template-columns: 1fr;
                justify-items: center;
                text-align: center;
            }

            .course-play-button {
                margin: 0 auto 18px;
            }

            .learning-cta-band {
                min-height: 420px;
            }

            .learning-cta-band h2,
            .learning-services h2,
            .learning-faq-head h2 {
                font-size: 31px;
            }

            .learning-news__inner {
                padding: 0 16px 70px;
            }
        }

        @media (max-width: 767px) {
            .frontend-main {
                padding-top: 204px;
            }
        }

        @media (max-width: 576px) {
            .learning-brand__text strong {
                font-size: 20px;
            }

            .learning-brand__text small {
                max-width: 145px;
                font-size: 10px;
            }

            .learning-action--outline {
                display: none;
            }

            .learning-brand__icon {
                width: 44px;
                height: 44px;
                flex-basis: 44px;
                font-size: 19px;
            }

            .learning-navbar__inner {
                gap: 8px;
                padding: 12px 12px;
            }

            .learning-language__button,
            .learning-user__button,
            .learning-login,
            .learning-cta {
                min-height: 38px;
                padding-left: 11px;
                padding-right: 11px;
                border-radius: 10px;
            }

            .learning-cta {
                padding: 0 16px;
            }

            .learning-search--mobile {
                width: calc(100% - 24px);
                margin-bottom: 12px;
            }

            .frontend-main {
                padding-top: 204px;
            }

            .learning-slide-copy h1 {
                font-size: 30px;
            }

            .learning-slide-actions,
            .learning-slide-btn {
                width: 100%;
            }

            .learning-notice-card {
                padding: 22px 18px;
                border-radius: 18px;
            }

            .learning-notice-head,
            .learning-notice-item {
                grid-template-columns: 1fr;
                align-items: start;
            }

            .learning-notice-head {
                display: grid;
            }

            .learning-stats,
            .learning-program-grid,
            .learning-course-grid,
            .learning-catalog-grid {
                grid-template-columns: 1fr;
            }

            .learning-stats {
                gap: 14px;
                padding-top: 28px;
            }

            .learning-stat {
                min-height: 172px;
            }

            .learning-stat strong {
                font-size: 48px;
            }

            .learning-section-head {
                margin-bottom: 34px;
            }

            .learning-course-grid {
                padding-top: 34px;
            }

            .learning-course-thumb {
                height: 196px;
            }

            .learning-course-meta {
                grid-template-columns: 1fr;
            }

            .learning-catalog-toolbar {
                margin: 28px 0;
                padding: 14px;
            }

            .learning-catalog-filter {
                padding: 22px 18px;
            }

            .course-detail-cover {
                height: 210px;
            }

            .course-detail-summary {
                padding: 24px 18px;
            }

            .course-detail-content h2 {
                font-size: 26px;
            }

            .course-next-btn {
                background: #5bc1b5;
                font-size: 18px;
            }

            .course-lesson {
                grid-template-columns: 32px 34px minmax(0, 1fr);
                padding: 12px;
            }

            .course-lesson strong {
                font-size: 16px;
            }

            .course-player-head h1 {
                font-size: 24px;
            }

            .course-video-title {
                margin-bottom: 38px;
                font-size: 30px;
            }

            .course-instructor-preview img {
                width: 230px;
                height: 230px;
            }

            .course-instructor-preview h2,
            .course-instructor-preview p {
                font-size: 24px;
            }

            .course-media-shell.is-fullscreen {
                padding: 18px;
            }

            .course-document-preview {
                padding: 12px;
            }

            .course-document-page {
                min-height: auto;
                padding: 28px 20px;
            }

            .course-document-page h2 {
                font-size: 26px;
            }

            .course-player-actions,
            .course-outline-link {
                width: 100%;
            }

            .course-player-actions {
                flex-direction: column;
            }

            .course-prerequisites {
                margin-top: 48px;
            }

            .course-prerequisites h2 {
                font-size: 26px;
            }

            .course-prerequisites h3,
            .course-prerequisites ul {
                font-size: 18px;
            }

            .course-discussion-inner {
                padding: 54px 18px 24px;
            }

            .course-comment-form {
                grid-template-columns: 1fr;
                gap: 16px;
            }

            .course-comment-box::before {
                display: none;
            }

            .course-comment-actions {
                align-items: stretch;
                flex-direction: column;
            }

            .course-comment-list {
                margin-left: 0;
            }

            .learning-cta-band__inner {
                padding: 56px 16px;
            }

            .learning-cta-band__actions,
            .learning-cta-band__actions a {
                width: 100%;
            }

            .learning-services__inner {
                padding: 70px 16px 54px;
            }

            .learning-news-card {
                padding: 24px;
            }

            .learning-news-meta,
            .learning-footer-bottom {
                align-items: start;
                flex-direction: column;
            }

            .learning-faq__inner {
                padding: 70px 16px;
            }

            .learning-faq-question {
                min-height: 66px;
                padding: 0 18px;
                font-size: 16px;
            }

            .learning-faq-answer {
                padding: 0 18px 20px;
            }

            .learning-footer__inner,
            .learning-footer-bottom {
                padding-left: 16px;
                padding-right: 16px;
            }
        }
    </style>
</head>

<body class="frontend-page">
    <div class="page-loading-overlay" id="pageLoadingOverlay" aria-hidden="true">
        <div class="page-loading-mark" role="status" aria-label="Loading">
            <i class="fas fa-book-open"></i>
        </div>
    </div>

    @include('frontend.partials.header')

    <main class="frontend-main">
        @yield('content')
    </main>

    @include('frontend.partials.footer')

    <script src="https://code.jquery.com/jquery-3.7.1.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.3/js/bootstrap.bundle.min.js"></script>
    <script src="{{ asset('backend/dist/js/adminlte.min.js') }}"></script>
    <script>
        $(function() {
            const showPageLoading = () => $('body').addClass('is-page-loading');
            const hidePageLoading = () => $('body').removeClass('is-page-loading');
            const $revealItems = $('.reveal-item');
            let countersStarted = false;

            window.addEventListener('pageshow', hidePageLoading);
            window.addEventListener('pagehide', hidePageLoading);

            $(document).on('click', 'a[href]', function(event) {
                if (event.defaultPrevented || event.metaKey || event.ctrlKey || event.shiftKey || event.altKey) {
                    return;
                }

                const href = $(this).attr('href');
                const target = ($(this).attr('target') || '').toLowerCase();

                if (!href
                    || href === '#'
                    || href.startsWith('#')
                    || href.startsWith('javascript:')
                    || href.startsWith('mailto:')
                    || href.startsWith('tel:')
                    || target === '_blank'
                    || $(this).is('[download], [data-no-loading]')) {
                    return;
                }

                try {
                    const url = new URL(href, window.location.href);

                    if (url.origin === window.location.origin && url.href !== window.location.href) {
                        showPageLoading();
                    }
                } catch (error) {
                    showPageLoading();
                }
            });

            $(document).on('submit', 'form', function(event) {
                if (!event.isDefaultPrevented() && !$(this).is('[data-no-loading]')) {
                    showPageLoading();
                }
            });

            $revealItems.each(function(index) {
                $(this).css('--reveal-delay', `${Math.min(index * 80, 480)}ms`);
            });

            function revealOnScroll() {
                const windowBottom = $(window).scrollTop() + $(window).height();

                $revealItems.each(function() {
                    const $item = $(this);

                    if (windowBottom > $item.offset().top + 80) {
                        $item.addClass('is-visible');
                    }
                });

                const $counterSection = $('[data-counter-section]');

                if (!countersStarted && $counterSection.length && windowBottom > $counterSection.offset().top + 80) {
                    countersStarted = true;

                    $('.js-counter').each(function() {
                        const $counter = $(this);
                        const target = Number($counter.data('count')) || 0;

                        $({ value: 0 }).animate({ value: target }, {
                            duration: 1400,
                            easing: 'swing',
                            step(now) {
                                $counter.text(Math.floor(now).toLocaleString());
                            },
                            complete() {
                                $counter.text(target.toLocaleString());
                            },
                        });
                    });
                }
            }

            revealOnScroll();
            $(window).on('scroll resize', revealOnScroll);

            $('a[href^="#"]').on('click', function(event) {
                const targetSelector = $(this).attr('href');
                const $target = $(targetSelector);

                if ($target.length) {
                    event.preventDefault();
                    $('html, body').animate({
                        scrollTop: $target.offset().top - 90,
                    }, 520);
                }
            });

            const $catalogCards = $('.learning-catalog-card');
            const $catalogGrid = $('#catalogGrid');
            let activeCatalogFilter = 'all';
            let sortDescending = true;

            function applyCatalogFilters() {
                const query = ($('#catalogSearch').val() || '').trim().toLowerCase();
                let visibleCount = 0;

                $catalogCards.each(function() {
                    const $card = $(this);
                    const matchesFilter = activeCatalogFilter === 'all'
                        || $card.data('year') === activeCatalogFilter
                        || $card.data('type') === activeCatalogFilter;
                    const matchesSearch = !query || String($card.data('search')).toLowerCase().includes(query);
                    const shouldShow = matchesFilter && matchesSearch;

                    $card.toggleClass('is-hidden', !shouldShow);

                    if (shouldShow) {
                        visibleCount += 1;
                    }
                });

                $('.learning-catalog-empty').remove();

                if (!visibleCount) {
                    $catalogGrid.append('<div class="learning-catalog-empty">មិនមានមុខវិជ្ជាដែលត្រូវនឹងការស្វែងរកទេ។</div>');
                    $('.learning-catalog-empty').fadeIn(180);
                }
            }

            $('[data-filter]').on('click', function() {
                activeCatalogFilter = $(this).data('filter');
                $('[data-filter]').removeClass('is-active');
                $(`[data-filter="${activeCatalogFilter}"]`).addClass('is-active');
                applyCatalogFilters();
            });

            $('#catalogSearch').on('input', applyCatalogFilters);


            $('.learning-faq-question').on('click', function() {
                const $item = $(this).closest('.learning-faq-item');
                const isOpen = $item.hasClass('is-open');

                $('.learning-faq-item.is-open')
                    .removeClass('is-open')
                    .find('.learning-faq-answer')
                    .stop(true, true)
                    .slideUp(220);

                if (!isOpen) {
                    $item
                        .addClass('is-open')
                        .find('.learning-faq-answer')
                        .stop(true, true)
                        .slideDown(220);
                }
            });

            $('#lessonCommentForm').on('submit', function(event) {
                event.preventDefault();

                const $input = $('#lessonCommentInput');
                const comment = $input.val().trim();

                if (!comment) {
                    $input.focus();
                    return;
                }

                const safeComment = $('<div>').text(comment).html();
                const commentHtml = `
                    <article class="course-comment" style="display: none;">
                        <img src="{{ asset('backend/dist/img/avatar.png') }}" alt="">
                        <div>
                            <strong>{{ Auth::user()->name ?? 'Student' }}</strong>
                            <p>${safeComment}</p>
                        </div>
                    </article>
                `;

                $('#lessonCommentList').prepend(commentHtml);
                $('#lessonCommentList .course-comment:first').slideDown(220);
                $input.val('').focus();
            });

            $('[data-media-panel]').on('click', function() {
                const panel = $(this).data('media-panel');

                $('[data-media-panel]').removeClass('is-active');
                $(this).addClass('is-active');
                $('[data-media-panel-content]').removeClass('is-active');
                $(`[data-media-panel-content="${panel}"]`).addClass('is-active');
            });

            $('#toggleLessonSidebar').on('click', function() {
                const $detail = $('.learning-course-detail');
                const hidden = !$detail.hasClass('is-sidebar-hidden');

                $detail.toggleClass('is-sidebar-hidden', hidden);
                $(this).html(hidden
                    ? '<i class="fas fa-columns"></i> Show sidebar'
                    : '<i class="fas fa-columns"></i> Hide sidebar');
            });

            $('#toggleLessonFullscreen').on('click', function() {
                const $shell = $('#lessonMediaShell');
                const isFullscreen = !$shell.hasClass('is-fullscreen');

                $shell.toggleClass('is-fullscreen', isFullscreen);
                $('body').toggleClass('lesson-media-fullscreen', isFullscreen);
                $(this).html(isFullscreen
                    ? '<i class="fas fa-compress"></i> Exit full screen'
                    : '<i class="fas fa-expand"></i> Full screen');
            });

            $(document).on('keydown', function(event) {
                if (event.key === 'Escape' && $('#lessonMediaShell').hasClass('is-fullscreen')) {
                    $('#toggleLessonFullscreen').trigger('click');
                }
            });
        });
    </script>
    @stack('scripts')
</body>

</html>
