@php
    $studyYears = [
        [
            'year' => 'ឆ្នាំទី១',
            'en' => 'Year 1',
            'title' => 'គណិតវិទ្យា ភាសាអង់គ្លេស និងបច្ចេកវិទ្យា',
            'description' => 'ចាប់ផ្តើមពីមូលដ្ឋានគ្រឹះដែលជួយឱ្យអ្នកយល់ពីការគណនា ការទំនាក់ទំនងជាភាសាអង់គ្លេស និងជំនាញបច្ចេកវិទ្យាដំបូង។',
            'icon' => 'fa-book-open',
            'tone' => 'blue',
            'skills' => ['Mathematics', 'English Communication', 'Computer Basics'],
        ],
        [
            'year' => 'ឆ្នាំទី២',
            'en' => 'Year 2',
            'title' => 'អភិវឌ្ឍកម្មវិធី Java និង MySQL',
            'description' => 'បង្កើនជំនាញសរសេរកម្មវិធី ជាមួយ Java និងការគ្រប់គ្រងទិន្នន័យដោយ MySQL សម្រាប់ការងារអភិវឌ្ឍកម្មវិធី។',
            'icon' => 'fa-database',
            'tone' => 'orange',
            'skills' => ['Java Programming', 'MySQL Database', 'Application Logic'],
        ],
        [
            'year' => 'ឆ្នាំទី៣',
            'en' => 'Year 3',
            'title' => 'ការគ្រប់គ្រងបណ្តាញ និងបច្ចេកទេសកុំព្យូទ័រ',
            'description' => 'សិក្សាអំពីបណ្តាញ ការថែទាំប្រព័ន្ធ និងបច្ចេកទេសកុំព្យូទ័រដែលត្រូវការសម្រាប់បរិស្ថានការងារពិត។',
            'icon' => 'fa-network-wired',
            'tone' => 'purple',
            'skills' => ['Networking', 'Computer Maintenance', 'System Support'],
        ],
        [
            'year' => 'ឆ្នាំទី៤',
            'en' => 'Year 4',
            'title' => 'គម្រោងបញ្ចប់ និងការត្រៀមខ្លួនសម្រាប់ការងារ',
            'description' => 'បញ្ចប់ជាមួយគម្រោងជាក់ស្តែង ការរៀបចំ Portfolio និងជំនាញសម្ភាសន៍ការងារដើម្បីចូលទីផ្សារការងារ។',
            'icon' => 'fa-briefcase',
            'tone' => 'pink',
            'skills' => ['Final Project', 'Portfolio', 'Career Readiness'],
        ],
    ];
@endphp

@extends('frontend.layouts.master')

@section('title', 'កម្មវិធីសិក្សា | Moodle LMS')

@section('content')
    <section class="program-page-hero">
        <div class="program-page-hero__inner">
            <div>
                <span class="program-page-eyebrow">Learning Path</span>
                <h1>ជ្រើសរើសឆ្នាំសិក្សារបស់អ្នក ហើយចាប់ផ្តើមរៀនឥឡូវនេះ</h1>
                <p>កម្មវិធីសិក្សាត្រូវបានរៀបចំជាចំណុចច្បាស់ៗពីមូលដ្ឋាន ដល់គម្រោងបញ្ចប់ ដើម្បីជួយអ្នកកសាងជំនាញបច្ចេកវិទ្យា និងត្រៀមខ្លួនសម្រាប់ការងារ។</p>
                <div class="program-page-actions">
                    <a href="{{ route('dashboard') }}">
                        ចូលទៅ Dashboard
                        <i class="fas fa-arrow-right"></i>
                    </a>
                    <a href="{{ route('frontend.courses') }}" class="is-light">
                        មើលមុខវិជ្ជា
                        <i class="fas fa-book"></i>
                    </a>
                </div>
            </div>

            <div class="program-page-summary">
                <strong>4</strong>
                <span>ឆ្នាំសិក្សា</span>
                <p>រៀនតាមជំហាន ជាមួយមេរៀន និងជំនាញសំខាន់ៗសម្រាប់និស្សិត IT។</p>
            </div>
        </div>
    </section>

    <section class="program-page-content">
        <div class="program-page-head">
            <h2>ផ្លូវសិក្សា ៤ ឆ្នាំ</h2>
            <p>ចុចលើប៊ូតុង “ចូលរៀន” ដើម្បីត្រឡប់ទៅ Dashboard និងបន្តការសិក្សារបស់អ្នក។</p>
        </div>

        <div class="program-year-grid">
            @foreach($studyYears as $index => $year)
                <article class="program-year-card program-year-card--{{ $year['tone'] }}">
                    <div class="program-year-top">
                        <span class="program-year-icon">
                            <i class="fas {{ $year['icon'] }}"></i>
                        </span>
                        <strong>{{ str_pad((string) ($index + 1), 2, '0', STR_PAD_LEFT) }}</strong>
                    </div>

                    <h3>{{ $year['year'] }} <small>({{ $year['en'] }})</small></h3>
                    <p>{{ $year['title'] }}</p>
                    <div class="program-year-desc">{{ $year['description'] }}</div>

                    <div class="program-year-skills">
                        @foreach($year['skills'] as $skill)
                            <span>{{ $skill }}</span>
                        @endforeach
                    </div>

                    <a href="{{ route('dashboard') }}" class="program-year-btn">
                        ចូលរៀន
                        <i class="fas fa-arrow-right"></i>
                    </a>
                </article>
            @endforeach
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .program-page-hero {
            background:
                linear-gradient(120deg, rgba(15, 23, 42, .86), rgba(37, 99, 235, .72)),
                url("{{ asset('backend/img/course-image-default.png') }}") center / cover;
            color: #fff;
        }

        .program-page-hero__inner {
            max-width: 1240px;
            min-height: 430px;
            display: grid;
            grid-template-columns: minmax(0, 1fr) 320px;
            align-items: center;
            gap: 34px;
            margin: 0 auto;
            padding: 64px 24px;
        }

        .program-page-eyebrow {
            color: #bfdbfe;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .program-page-hero h1 {
            max-width: 820px;
            margin: 16px 0 18px;
            font-size: 44px;
            line-height: 1.25;
            font-weight: 900;
        }

        .program-page-hero p {
            max-width: 760px;
            margin: 0;
            color: rgba(255, 255, 255, .86);
            font-size: 17px;
            line-height: 1.85;
        }

        .program-page-actions {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            margin-top: 30px;
        }

        .program-page-actions a,
        .program-year-btn {
            min-height: 46px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            border-radius: 8px;
            background: #ff5b00;
            color: #fff;
            padding: 0 20px;
            font-weight: 900;
            text-decoration: none;
        }

        .program-page-actions a:hover,
        .program-year-btn:hover {
            color: #fff;
            text-decoration: none;
            transform: translateY(-2px);
        }

        .program-page-actions a.is-light {
            border: 1px solid rgba(255, 255, 255, .42);
            background: rgba(255, 255, 255, .12);
        }

        .program-page-summary {
            border: 1px solid rgba(255, 255, 255, .24);
            border-radius: 8px;
            background: rgba(255, 255, 255, .12);
            padding: 28px;
            backdrop-filter: blur(8px);
        }

        .program-page-summary strong {
            display: block;
            font-size: 74px;
            line-height: 1;
            font-weight: 900;
        }

        .program-page-summary span {
            display: block;
            margin-top: 8px;
            font-size: 22px;
            font-weight: 900;
        }

        .program-page-summary p {
            margin-top: 16px;
            font-size: 15px;
        }

        .program-page-content {
            max-width: 1240px;
            margin: 0 auto;
            padding: 72px 24px 92px;
        }

        .program-page-head {
            max-width: 760px;
            margin-bottom: 34px;
        }

        .program-page-head h2 {
            margin: 0;
            color: #111827;
            font-size: 36px;
            font-weight: 900;
        }

        .program-page-head p {
            margin: 12px 0 0;
            color: #64748b;
            font-size: 17px;
            line-height: 1.75;
        }

        .program-year-grid {
            display: grid;
            grid-template-columns: repeat(2, minmax(0, 1fr));
            gap: 22px;
        }

        .program-year-card {
            position: relative;
            overflow: hidden;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            padding: 28px;
            box-shadow: 0 16px 34px rgba(15, 23, 42, .06);
            transition: transform .2s ease, box-shadow .2s ease;
        }

        .program-year-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 22px 44px rgba(15, 23, 42, .13);
        }

        .program-year-top {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 22px;
        }

        .program-year-icon {
            width: 58px;
            height: 58px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            font-size: 24px;
        }

        .program-year-top strong {
            color: #e2e8f0;
            font-size: 54px;
            line-height: 1;
            font-weight: 900;
        }

        .program-year-card h3 {
            margin: 0;
            color: #111827;
            font-size: 25px;
            font-weight: 900;
        }

        .program-year-card h3 small {
            color: #64748b;
            font-size: 16px;
        }

        .program-year-card p {
            margin: 10px 0 12px;
            color: #1f2937;
            font-size: 18px;
            font-weight: 900;
            line-height: 1.55;
        }

        .program-year-desc {
            color: #64748b;
            font-size: 15px;
            line-height: 1.8;
        }

        .program-year-skills {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
            margin: 22px 0;
        }

        .program-year-skills span {
            min-height: 30px;
            display: inline-flex;
            align-items: center;
            border-radius: 999px;
            background: #f1f5f9;
            color: #475569;
            padding: 0 12px;
            font-size: 13px;
            font-weight: 900;
        }

        .program-year-btn {
            width: 100%;
        }

        .program-year-card--blue .program-year-icon {
            background: #eaf1ff;
            color: #145dff;
        }

        .program-year-card--orange .program-year-icon {
            background: #fff2e5;
            color: #ff5b00;
        }

        .program-year-card--purple .program-year-icon {
            background: #f3e8ff;
            color: #8b35ff;
        }

        .program-year-card--pink .program-year-icon {
            background: #fde7f3;
            color: #ec1680;
        }

        @media (max-width: 992px) {
            .program-page-hero__inner,
            .program-year-grid {
                grid-template-columns: 1fr;
            }

            .program-page-hero h1 {
                font-size: 34px;
            }
        }
    </style>
@endpush
