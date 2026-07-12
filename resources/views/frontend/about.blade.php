@php
    $learningLocale = session('learning_locale', 'km');

    $aboutContent = [
        'km' => [
            'title' => 'សេចក្ដីសង្ខេបអំពីប្រព័ន្ធ LearnCore LMS',
            'date' => 'សៅរ៍, 11 កក្កដា 2026',
            'author' => 'LearnCore LMS',
            'views' => 'ទំព័រព័ត៌មាន',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'banner' => 'ប្រព័ន្ធគ្រប់គ្រងកម្មវិធីសិក្សា LearnCore LMS',
            'intro' => 'LearnCore LMS ជាប្រព័ន្ធគ្រប់គ្រងការសិក្សាឌីជីថល ដែលរៀបចំឡើងសម្រាប់គ្រប់គ្រងមុខវិជ្ជា មេរៀន សិស្ស និស្សិត គ្រូបង្រៀន ការវាយតម្លៃ និងការតាមដានការសិក្សា ឱ្យមានរបៀបរៀបរយ ងាយស្រួល និងមានប្រសិទ្ធភាព។',
            'sections' => [
                [
                    'number' => '១.',
                    'title' => 'គោលបំណងនៃប្រព័ន្ធ',
                    'items' => [
                        'ផ្តល់វេទិកាសិក្សាដែលអាចប្រើប្រាស់បានងាយស្រួល សម្រាប់សិស្ស និស្សិត និងគ្រូបង្រៀន។',
                        'រៀបចំមុខវិជ្ជា មេរៀន ឯកសារ វីដេអូ និងសកម្មភាពសិក្សា នៅក្នុងកន្លែងតែមួយ។',
                        'ជួយឱ្យអ្នកគ្រប់គ្រងអាចតាមដានស្ថានភាពវគ្គសិក្សា ការចូលរៀន និងលទ្ធផលសិក្សាបានច្បាស់លាស់។',
                    ],
                ],
                [
                    'number' => '២.',
                    'title' => 'មុខងារសំខាន់ៗ',
                    'items' => [
                        'គ្រប់គ្រងមុខវិជ្ជា វគ្គសិក្សា មេរៀន និងប្រភេទមុខវិជ្ជា។',
                        'បង្ហាញមេរៀនជាទម្រង់វីដេអូ ឯកសារ និងព័ត៌មានលម្អិតអំពីវគ្គសិក្សា។',
                        'គ្រប់គ្រងគណនីសិស្ស គ្រូបង្រៀន និងអ្នកគ្រប់គ្រងតាមតួនាទី។',
                        'តាមដានចំនួនមេរៀន រយៈពេលសិក្សា អ្នកចូលរួម តម្លៃ និងស្ថានភាពវគ្គសិក្សា។',
                        'ផ្តល់ផ្ទាំងគ្រប់គ្រងសម្រាប់មើលព័ត៌មានសង្ខេប និងដំណើរការសិក្សា។',
                    ],
                ],
                [
                    'number' => '៣.',
                    'title' => 'តួនាទីអ្នកប្រើប្រាស់',
                    'items' => [
                        'សិស្សអាចស្វែងរកមុខវិជ្ជា មើលព័ត៌មានវគ្គសិក្សា និងបន្តការសិក្សាតាមមេរៀន។',
                        'គ្រូបង្រៀនអាចរៀបចំមាតិកា គ្រប់គ្រងមេរៀន និងតាមដានការចូលរួមរបស់សិស្ស។',
                        'អ្នកគ្រប់គ្រងអាចគ្រប់គ្រងទិន្នន័យមូលដ្ឋាន អ្នកប្រើប្រាស់ កាលវិភាគ និងរបាយការណ៍។',
                    ],
                ],
                [
                    'number' => '៤.',
                    'title' => 'ទិសដៅអភិវឌ្ឍន៍',
                    'items' => [
                        'បន្តធ្វើឱ្យប្រព័ន្ធមានល្បឿនលឿន ស្អាត និងងាយស្រួលប្រើប្រាស់លើទូរស័ព្ទ និងកុំព្យូទ័រ។',
                        'ពង្រឹងការរៀបចំមាតិកាសិក្សា ការវាយតម្លៃ និងការតាមដានលទ្ធផល។',
                        'គាំទ្រការសិក្សាឌីជីថលឱ្យកាន់តែមានគុណភាព និងអាចចូលប្រើបានសម្រាប់អ្នកសិក្សាទាំងអស់។',
                    ],
                ],
            ],
        ],
        'en' => [
            'title' => 'Brief Overview of LearnCore LMS',
            'date' => 'Saturday, July 11, 2026',
            'author' => 'LearnCore LMS',
            'views' => 'Information page',
            'print' => 'Print',
            'email' => 'Email',
            'banner' => 'LearnCore Learning Management System',
            'intro' => 'LearnCore LMS is a digital learning management system for organizing courses, lessons, students, instructors, assessments, and learning progress in a clear and efficient way.',
            'sections' => [
                [
                    'number' => '1.',
                    'title' => 'System Objectives',
                    'items' => [
                        'Provide an easy learning platform for students and instructors.',
                        'Organize courses, lessons, documents, videos, and learning activities in one place.',
                        'Help administrators monitor courses, participation, and learning results.',
                    ],
                ],
                [
                    'number' => '2.',
                    'title' => 'Main Features',
                    'items' => [
                        'Manage subjects, courses, lessons, and categories.',
                        'Show lesson content, course details, videos, and documents.',
                        'Manage student, instructor, and administrator accounts by role.',
                        'Track lessons, duration, participants, price, and course status.',
                        'Provide dashboards for summaries and learning activity.',
                    ],
                ],
                [
                    'number' => '3.',
                    'title' => 'User Roles',
                    'items' => [
                        'Students can search courses, view details, and continue learning lessons.',
                        'Instructors can prepare content, manage lessons, and monitor participation.',
                        'Administrators can manage core data, users, schedules, and reports.',
                    ],
                ],
                [
                    'number' => '4.',
                    'title' => 'Development Direction',
                    'items' => [
                        'Keep the system fast, clean, and easy to use on mobile and desktop.',
                        'Improve learning content, assessment, and progress tracking.',
                        'Support higher-quality digital learning for all learners.',
                    ],
                ],
            ],
        ],
    ];

    $aboutText = $aboutContent[$learningLocale] ?? $aboutContent['km'];
@endphp

@extends('frontend.layouts.master')

@section('title', $aboutText['title'].' | LearnCore LMS')

@section('content')
    <section class="learning-about-article">
        <div id="k2Container" class="itemView learning-about-k2">
            <div class="itemHeader">
                <h2 class="itemTitle">{{ $aboutText['title'] }}</h2>

                <div class="row-fluid itemToolbar">
                    <span class="itemDateCreated">
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $aboutText['date'] }}
                    </span>

                    <span class="itemAuthor">
                        &nbsp;|&nbsp;
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ $aboutText['author'] }}
                    </span>

                    <span class="itemHits">
                        &nbsp;|&nbsp;
                        <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $aboutText['views'] }}
                    </span>

                    <span>
                        &nbsp;|&nbsp;
                        <button type="button" class="learning-about-tool" data-no-loading onclick="window.print()">
                            <i class="fa fa-print" aria-hidden="true"></i>&nbsp;{{ $aboutText['print'] }}
                        </button>
                    </span>

                    <span>
                        &nbsp;|&nbsp;
                        <a class="learning-about-tool" href="mailto:?subject={{ rawurlencode($aboutText['title']) }}" data-no-loading>
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{ $aboutText['email'] }}
                        </a>
                    </span>
                </div>
            </div>

            <div class="itemBody">
                <div class="itemFullText">
                    <div class="learning-about-banner">
                        <h2>{{ $aboutText['banner'] }}</h2>
                    </div>

                    <blockquote class="learning-about-summary">
                        <p>{{ $aboutText['intro'] }}</p>
                    </blockquote>

                    <div class="learning-about-table">
                        @foreach($aboutText['sections'] as $section)
                            <article class="learning-about-row">
                                <div class="learning-about-number">{{ $section['number'] }}</div>
                                <div class="learning-about-copy">
                                    <h2>{{ $section['title'] }}</h2>
                                    <ul>
                                        @foreach($section['items'] as $item)
                                            <li>{{ $item }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        .learning-about-article {
            max-width: 1180px;
            margin: 0 auto;
            padding: 56px 24px 86px;
            font-family: 'Battambang', 'Khmer OS Siemreap', 'Khmer OS Battambang', Arial, sans-serif;
        }

        .learning-about-k2 {
            color: #243447;
            background: #fff;
        }

        .learning-about-k2 .itemHeader {
            padding-bottom: 18px;
            border-bottom: 1px solid #dfe7ee;
        }

        .learning-about-k2 .itemTitle {
            margin: 0 0 12px;
            color: #14324d;
            font-size: 31px;
            font-weight: 700;
            line-height: 1.45;
        }

        .learning-about-k2 .itemToolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            gap: 4px;
            color: #64748b;
            font-size: 14px;
            line-height: 1.8;
        }

        .learning-about-k2 .itemToolbar i {
            color: #0c8df0;
        }

        .learning-about-tool {
            display: inline;
            border: 0;
            background: transparent;
            color: #0c70bf;
            padding: 0;
            font: inherit;
            text-decoration: none;
            cursor: pointer;
        }

        .learning-about-tool:hover {
            color: #005c9d;
            text-decoration: underline;
        }

        .learning-about-k2 .itemBody {
            padding-top: 26px;
        }

        .learning-about-banner {
            padding: 14px 22px;
            background: #0c8df0;
            text-align: center;
        }

        .learning-about-banner h2 {
            margin: 0;
            color: #fff;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.6;
            text-decoration: underline;
        }

        .learning-about-summary {
            margin: 24px 0;
            padding: 20px 24px;
            border-left: 5px solid #0c8df0;
            background: #f5fbff;
        }

        .learning-about-summary p {
            margin: 0;
            color: #334155;
            font-size: 17px;
            font-weight: 600;
            line-height: 1.9;
            text-align: justify;
        }

        .learning-about-table {
            display: grid;
            gap: 18px;
        }

        .learning-about-row {
            display: grid;
            grid-template-columns: 56px minmax(0, 1fr);
            gap: 18px;
            padding: 18px 0 20px;
            border-bottom: 1px solid #e5edf5;
        }

        .learning-about-number {
            color: #0c8df0;
            font-size: 25px;
            font-weight: 700;
            line-height: 1.5;
            text-align: right;
        }

        .learning-about-copy h2 {
            margin: 0 0 12px;
            color: #14324d;
            font-size: 24px;
            font-weight: 700;
            line-height: 1.55;
            text-align: justify;
        }

        .learning-about-copy ul {
            margin: 0;
            padding-left: 24px;
            list-style-type: square;
        }

        .learning-about-copy li {
            margin-bottom: 9px;
            color: #475569;
            font-size: 16px;
            font-weight: 500;
            line-height: 1.85;
            text-align: justify;
        }

        @media (max-width: 767.98px) {
            .learning-about-article {
                padding: 34px 16px 58px;
            }

            .learning-about-k2 .itemTitle {
                font-size: 24px;
            }

            .learning-about-banner h2 {
                font-size: 19px;
            }

            .learning-about-row {
                grid-template-columns: 1fr;
                gap: 6px;
            }

            .learning-about-number {
                text-align: left;
            }

            .learning-about-copy h2 {
                font-size: 20px;
            }
        }
    </style>
@endpush
