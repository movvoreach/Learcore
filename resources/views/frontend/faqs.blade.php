@php
    $learningLocale = session('learning_locale', 'km');

    $faqsContent = [
        'km' => [
            'title' => 'សំណួរដែលសួរញឹកញាប់ (FAQs)',
            'date' => 'សៅរ៍, 11 កក្កដា 2026',
            'author' => 'LearnCore LMS',
            'views' => 'ទំព័រជំនួយ',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'banner' => 'សំណួរ និងចម្លើយដែលសួរញឹកញាប់អំពី LearnCore LMS',
            'intro' => 'ស្វែងយល់បន្ថែមអំពីរបៀបប្រើប្រាស់ប្រព័ន្ធ LearnCore LMS ដំណើរការសិក្សា ការប្រឡង ការដាក់ពិន្ទុ និងការទទួលបានវិញ្ញាបនបត្រ។',
            'faqs' => [
                [
                    'id' => 'faq1',
                    'question' => 'តើអ្វីទៅជាប្រព័ន្ធ LearnCore LMS?',
                    'answer' => 'LearnCore LMS គឺជាប្រព័ន្ធគ្រប់គ្រងការសិក្សាឌីជីថល (Learning Management System) ដែលត្រូវបានរចនាឡើងដើម្បីគ្រប់គ្រងរចនាសម្ព័ន្ធសិក្សា មុខវិជ្ជា ជំពូក មេរៀន សិស្ស គ្រូបង្រៀន កម្រងសំណួរ ការដាក់ពិន្ទុ និងការចេញវិញ្ញាបនបត្រស្វ័យប្រវត្ត។'
                ],
                [
                    'id' => 'faq2',
                    'question' => 'តើខ្ញុំអាចចូលរៀនវគ្គសិក្សារបស់ខ្ញុំដោយរបៀបណា?',
                    'answer' => 'ដំបូង ចូលប្រើប្រាស់គណនីរបស់អ្នកជាសិស្ស។ បន្ទាប់មក ចូលទៅកាន់ទំព័រដើម ឬទំព័រ «មុខវិជ្ជាសិក្សា» ស្វែងរកវគ្គសិក្សាដែលចង់រៀន រួចចុចលើប៊ូតុង «ចាប់ផ្តើមរៀន» ឬ «បន្តការសិក្សា» ដើម្បីចូលមើលមេរៀននីមួយៗ។'
                ],
                [
                    'id' => 'faq3',
                    'question' => 'តើវឌ្ឍនភាពសិក្សារបស់ខ្ញុំត្រូវបានតាមដានដោយរបៀបណា?',
                    'answer' => 'ប្រព័ន្ធនឹងតាមដានរាល់មេរៀនដែលអ្នកបានមើលរួច និងសកម្មភាពសិក្សាផ្សេងៗ រួចបង្ហាញជាភាគរយ (%) នៅលើវគ្គសិក្សានីមួយៗ។ នៅពេលអ្នកបំពេញគ្រប់មេរៀន និងកិច្ចការទាំងអស់ វឌ្ឍនភាពនឹងបង្ហាញ ១០០%។'
                ],
                [
                    'id' => 'faq4',
                    'question' => 'តើខ្ញុំត្រូវធ្វើកម្រងសំណួរ ឬប្រគល់កិច្ចការផ្ទះដោយរបៀបណា?',
                    'answer' => 'នៅខាងក្នុងមេរៀននីមួយៗ ប្រសិនបើមានកម្រងសំណួរ (Quizzes) ឬកិច្ចការផ្ទះ (Assignments) ដែលចាត់តាំងដោយគ្រូ អ្នកនឹងឃើញទម្រង់ ឬប៊ូតុងសម្រាប់ឆ្លើយសំណួរ ឬផ្ទុកឡើងឯកសារដើម្បីប្រគល់កិច្ចការផ្ទះដោយផ្ទាល់។'
                ],
                [
                    'id' => 'faq5',
                    'question' => 'តើខ្ញុំអាចទទួលបានវិញ្ញាបនបត្របញ្ចប់ការសិក្សាដោយរបៀបណា?',
                    'answer' => 'នៅពេលដែលអ្នកសម្រេចបានវឌ្ឍនភាពសិក្សា ១០០% និងឆ្លងកាត់ការវាយតម្លៃ ឬការប្រឡងទាំងអស់ដែលបានកំណត់ដោយជោគជ័យ វិញ្ញាបនបត្រ (Certificate) នឹងត្រូវបានបង្កើតឡើងដោយស្វ័យប្រវត្តសម្រាប់ឱ្យអ្នកទាញយកនៅក្នុងគណនីផ្ទាល់ខ្លួនរបស់អ្នក។'
                ]
            ]
        ],
        'en' => [
            'title' => 'Frequently Asked Questions (FAQs)',
            'date' => 'Saturday, July 11, 2026',
            'author' => 'LearnCore LMS',
            'views' => 'Help Center',
            'print' => 'Print',
            'email' => 'Email',
            'banner' => 'Frequently Asked Questions & Answers',
            'intro' => 'Learn more about how to use the LearnCore LMS, how to study, take assessments, view grading, and receive your certificates.',
            'faqs' => [
                [
                    'id' => 'faq1',
                    'question' => 'What is LearnCore LMS?',
                    'answer' => 'LearnCore LMS is a comprehensive digital Learning Management System designed to manage academic structures, courses, chapters, lessons, students, instructors, quizzes, grading, and automatic certificate generation.'
                ],
                [
                    'id' => 'faq2',
                    'question' => 'How can I access my courses?',
                    'answer' => 'First, log in using your student credentials. Go to the dashboard or the "Courses" page, browse available courses, select the course you wish to study, and click on the "Start Learning" or "Continue" button to view the lessons.'
                ],
                [
                    'id' => 'faq3',
                    'question' => 'How is my learning progress tracked?',
                    'answer' => 'The system monitors each lesson you complete and updates your status. Your progress is displayed as a completion percentage (%) on each course card and detail view, showing how much content you have finished.'
                ],
                [
                    'id' => 'faq4',
                    'question' => 'How do I take quizzes or submit assignments?',
                    'answer' => 'Inside each lesson details page, if there are quizzes or assignments assigned by the instructor, you will see a clear interface or button to take the quiz online or upload files to submit your assignment.'
                ],
                [
                    'id' => 'faq5',
                    'question' => 'How do I download my course certificate?',
                    'answer' => 'Once you achieve 100% course progress and successfully pass all required quizzes and assignments, a completion certificate will be automatically generated and made available for download in your student profile dashboard.'
                ]
            ]
        ]
    ];

    $faqsText = $faqsContent[$learningLocale] ?? $faqsContent['km'];
@endphp

@extends('frontend.layouts.master')

@section('title', $faqsText['title'].' | LearnCore LMS')

@section('content')
    <div id="page-content" class="row justify-content-center">
        <section id="region-main" class="col-12 col-lg-10">
            <div class="learning-about-article">
                <div id="k2Container" class="itemView learning-about-k2">
                    <div class="itemHeader">
                        <h2 class="itemTitle">{{ $faqsText['title'] }}</h2>

                        <div class="row-fluid itemToolbar">
                            <span class="itemDateCreated">
                                <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $faqsText['date'] }}
                            </span>

                            <span class="itemAuthor">
                                &nbsp;|&nbsp;
                                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ $faqsText['author'] }}
                            </span>

                            <span class="itemHits">
                                &nbsp;|&nbsp;
                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $faqsText['views'] }}
                            </span>

                            <span>
                                &nbsp;|&nbsp;
                                <button type="button" class="learning-about-tool" data-no-loading onclick="window.print()">
                                    <i class="fa fa-print" aria-hidden="true"></i>&nbsp;{{ $faqsText['print'] }}
                                </button>
                            </span>

                            <span>
                                &nbsp;|&nbsp;
                                <a class="learning-about-tool" href="mailto:?subject={{ rawurlencode($faqsText['title']) }}" data-no-loading>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{ $faqsText['email'] }}
                                </a>
                            </span>
                        </div>
                    </div>

                    <div class="itemBody">
                        <div class="itemFullText">
                            <div class="learning-about-banner">
                                <h2>{{ $faqsText['banner'] }}</h2>
                            </div>

                            <blockquote class="learning-about-summary">
                                <p>{{ $faqsText['intro'] }}</p>
                            </blockquote>

                            {{-- FAQ Bootstrap Accordion --}}
                            <div class="accordion learning-faq-accordion mt-5" id="faqAccordion">
                                @foreach($faqsText['faqs'] as $index => $faq)
                                    <div class="accordion-item mb-3 border rounded">
                                        <h2 class="accordion-header" id="heading{{ $faq['id'] }}">
                                            <button class="accordion-button collapsed font-weight-bold" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $faq['id'] }}" aria-expanded="false" aria-controls="collapse{{ $faq['id'] }}">
                                                <span class="mr-2 text-primary">Q:</span> {{ $faq['question'] }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $faq['id'] }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $faq['id'] }}" data-bs-parent="#faqAccordion">
                                            <div class="accordion-body text-secondary" style="font-size: 15px; line-height: 1.8; color: #475569; background: #fafbfc;">
                                                {!! $faq['answer'] !!}
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
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
            border-radius: 8px;
        }

        .learning-about-banner h2 {
            margin: 0;
            color: #fff;
            font-size: 22px;
            font-weight: 700;
            line-height: 1.6;
        }

        .learning-about-summary {
            margin: 24px 0;
            padding: 20px 24px;
            border-left: 5px solid #0c8df0;
            background: #f5fbff;
            border-radius: 4px;
        }

        .learning-about-summary p {
            margin: 0;
            color: #334155;
            font-size: 16px;
            font-weight: 600;
            line-height: 1.9;
            text-align: justify;
        }

        .learning-faq-accordion .accordion-item {
            border: 1px solid #e5edf5 !important;
            border-radius: 8px !important;
            overflow: hidden;
        }

        .learning-faq-accordion .accordion-button {
            background-color: #fff;
            color: #1e293b;
            font-size: 16px;
            padding: 18px 20px;
            font-family: 'Battambang', sans-serif;
            border: none;
            box-shadow: none;
        }

        .learning-faq-accordion .accordion-button:not(.collapsed) {
            background-color: #f8fafc;
            color: #0c8df0;
        }

        .learning-faq-accordion .accordion-button::after {
            background-size: 1.1rem;
        }

        .learning-faq-accordion .accordion-body {
            font-family: 'Battambang', sans-serif;
        }
    </style>
@endpush
