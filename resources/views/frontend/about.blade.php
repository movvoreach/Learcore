@php
    $learningLocale = session('learning_locale', 'km');
    $aboutText = [
        'km' => [
            'eyebrow' => 'អំពីប្រព័ន្ធសិក្សា',
            'title' => 'ប្រព័ន្ធគ្រប់គ្រងកម្មវិធីសិក្សា',
            'intro' => 'យើងបង្កើតបទពិសោធន៍សិក្សាដែលងាយប្រើ ស្អាត និងជួយឱ្យសិស្សអាចចូលរៀនមេរៀនបានលឿន។',
            'mission_title' => 'បេសកកម្ម',
            'mission' => 'ផ្តល់វេទិកាសិក្សាដែលរៀបចំមេរៀន វគ្គសិក្សា និងការចូលរួមរបស់សិស្សឱ្យមានរបៀបរៀបរយ។',
            'vision_title' => 'ចក្ខុវិស័យ',
            'vision' => 'ធ្វើឱ្យការសិក្សាឌីជីថលមានភាពងាយស្រួល សមរម្យ និងអាចប្រើប្រាស់បានសម្រាប់គ្រប់គ្នា។',
            'features_title' => 'មុខងារសំខាន់ៗ',
            'features' => [
                'គ្រប់គ្រងវគ្គសិក្សា និងមេរៀន',
                'មើលមាតិកាវីដេអូ និងឯកសារ',
                'តាមដានការសិក្សា និងការចូលរួម',
            ],
        ],
        'en' => [
            'eyebrow' => 'About the learning system',
            'title' => 'Learning Management System',
            'intro' => 'We build a clean, simple learning experience that helps students open lessons and continue studying quickly.',
            'mission_title' => 'Mission',
            'mission' => 'Provide an organized platform for courses, lessons, and student participation.',
            'vision_title' => 'Vision',
            'vision' => 'Make digital learning easier, more useful, and more accessible for everyone.',
            'features_title' => 'Key Features',
            'features' => [
                'Manage courses and lessons',
                'View video and document content',
                'Track learning and participation',
            ],
        ],
    ][$learningLocale] ?? [];
@endphp

@extends('frontend.layouts.master')

@section('title', $aboutText['title'].' | Moodle LMS')

@section('content')
    <section class="learning-about-page">
        <div class="learning-about-hero">
            <span>{{ $aboutText['eyebrow'] }}</span>
            <h1>{{ $aboutText['title'] }}</h1>
            <p>{{ $aboutText['intro'] }}</p>
        </div>

        <div class="learning-about-grid">
            <article>
                <i class="fas fa-bullseye"></i>
                <h2>{{ $aboutText['mission_title'] }}</h2>
                <p>{{ $aboutText['mission'] }}</p>
            </article>

            <article>
                <i class="fas fa-lightbulb"></i>
                <h2>{{ $aboutText['vision_title'] }}</h2>
                <p>{{ $aboutText['vision'] }}</p>
            </article>

            <article>
                <i class="fas fa-layer-group"></i>
                <h2>{{ $aboutText['features_title'] }}</h2>
                <ul>
                    @foreach($aboutText['features'] as $feature)
                        <li>{{ $feature }}</li>
                    @endforeach
                </ul>
            </article>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .learning-about-page {
            max-width: 1180px;
            margin: 0 auto;
            padding: 72px 24px 96px;
        }

        .learning-about-hero {
            max-width: 820px;
            margin-bottom: 42px;
        }

        .learning-about-hero span {
            color: #2563eb;
            font-size: 14px;
            font-weight: 900;
            text-transform: uppercase;
        }

        .learning-about-hero h1 {
            margin: 16px 0 18px;
            color: #111827;
            font-size: 44px;
            line-height: 1.25;
            font-weight: 900;
        }

        .learning-about-hero p {
            margin: 0;
            color: #64748b;
            font-size: 18px;
            line-height: 1.8;
        }

        .learning-about-grid {
            display: grid;
            grid-template-columns: repeat(3, minmax(0, 1fr));
            gap: 18px;
        }

        .learning-about-grid article {
            min-height: 250px;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            background: #fff;
            padding: 28px;
            box-shadow: 0 14px 28px rgba(15, 23, 42, .05);
        }

        .learning-about-grid i {
            width: 46px;
            height: 46px;
            display: grid;
            place-items: center;
            border-radius: 8px;
            background: #eaf1ff;
            color: #2563eb;
            font-size: 20px;
        }

        .learning-about-grid h2 {
            margin: 22px 0 12px;
            color: #111827;
            font-size: 22px;
            font-weight: 900;
        }

        .learning-about-grid p,
        .learning-about-grid li {
            color: #64748b;
            font-size: 16px;
            line-height: 1.75;
        }

        .learning-about-grid ul {
            margin: 0;
            padding-left: 20px;
        }

        @media (max-width: 992px) {
            .learning-about-grid {
                grid-template-columns: 1fr;
            }

            .learning-about-hero h1 {
                font-size: 34px;
            }
        }
    </style>
@endpush
