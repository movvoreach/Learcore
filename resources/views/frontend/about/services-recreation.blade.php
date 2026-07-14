@php
    $learningLocale = session('learning_locale', 'km');

    $content = [
        'km' => [
            'title' => 'សេវាកម្ម និងការកម្សាន្ត',
            'banner' => 'សេវាកម្ម / ការកម្សាន្ត និងការលំហែកាយ',
            'date' => 'ច័ន្ទ, 13 កក្កដា 2026',
            'author' => 'SPI Admin',
            'views' => 'ទំព័រព័ត៌មាន',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'intro' => 'វិទ្យាស្ថានសេនប៉ូល (SPI) មិនត្រឹមតែផ្តោតលើការសិក្សាប៉ុណ្ណោះទេ ប៉ុន្តែយើងក៏យកចិត្តទុកដាក់ខ្ពស់លើសុខុមាលភាព និងសកម្មភាពកម្សាន្តរបស់និស្សិតផងដែរ។',
            'services' => [
                [
                    'icon' => '🤝',
                    'title' => 'សេវាកម្មប្រឹក្សាយោបល់ការងារ',
                    'desc' => 'យើងផ្តល់ការណែនាំ និងជួយនិស្សិតក្នុងការរៀបចំប្រវត្តិរូបសង្ខេប (CV) ត្រៀមខ្លួនសម្រាប់សម្ភាសន៍ការងារ និងផ្សារភ្ជាប់ទំនាក់ទំនងជាមួយក្រុមហ៊ុនធំៗ។'
                ],
                [
                    'icon' => '⚽',
                    'title' => 'កីឡា និងការកម្សាន្ត',
                    'desc' => 'វិទ្យាស្ថានមានតារាងបាល់ទាត់ ទីលានបាល់ទះ និងកន្លែងលេងកីឡាផ្សេងៗ ដើម្បីលើកកម្ពស់សុខភាពកាយសម្បទា និងបង្កើតមិត្តភាព។'
                ],
                [
                    'icon' => '🚌',
                    'title' => 'សេវាកម្មដឹកជញ្ជូន និងស្នាក់នៅ',
                    'desc' => 'យើងជួយសម្របសម្រួល និងណែនាំកន្លែងស្នាក់នៅដែលមានសុវត្ថិភាព និងតម្លៃសមរម្យនៅជិតវិទ្យាស្ថានសម្រាប់សិស្សមកពីបណ្តាខេត្តឆ្ងាយៗ។'
                ]
            ]
        ],
        'en' => [
            'title' => 'Services and Recreation',
            'banner' => 'Services & Student Recreation',
            'date' => 'Monday, July 13, 2026',
            'author' => 'SPI Admin',
            'views' => 'Information page',
            'print' => 'Print',
            'email' => 'Email',
            'intro' => 'At St. Paul Institute (SPI), we focus not only on academic excellence but also on promoting student well-being and recreational activities.',
            'services' => [
                [
                    'icon' => '🤝',
                    'title' => 'Career Counseling Services',
                    'desc' => 'We provide regular guidance for CV writing, job interview preparation, and organize career fairs to connect students directly with major employers.'
                ],
                [
                    'icon' => '⚽',
                    'title' => 'Sports and Recreation',
                    'desc' => 'SPI features standard football pitches, volleyball courts, and indoor recreation zones to encourage fitness, mental health, and team solidarity.'
                ],
                [
                    'icon' => '🚌',
                    'title' => 'Accommodation Support',
                    'desc' => 'We assist students from distant provinces in finding safe, comfortable, and affordable housing facilities near the campus.'
                ]
            ]
        ],
        'fr' => [
            'title' => 'Services et Loisirs',
            'banner' => 'Services et Récréation',
            'date' => 'Lundi, 13 Juillet 2026',
            'author' => 'SPI Admin',
            'views' => 'Page d\'information',
            'print' => 'Imprimer',
            'email' => 'Email',
            'intro' => 'À l\'Institut Saint Paul (SPI), nous offrons des services d\'accompagnement complets pour assurer le bien-être de nos étudiants.',
            'services' => [
                [
                    'icon' => '🤝',
                    'title' => 'Orientation Professionnelle',
                    'desc' => 'Aide à la rédaction de CV et préparation aux entretiens d\'embauche.'
                ],
                [
                    'icon' => '⚽',
                    'title' => 'Sports et Activités',
                    'desc' => 'Terrains de football et de volley-ball disponibles pour les étudiants.'
                ]
            ]
        ],
        'zh' => [
            'title' => '学生服务与休闲活动',
            'banner' => '学生服务与休闲娱乐',
            'date' => '2026年7月13日',
            'author' => 'SPI 管理员',
            'views' => '信息页面',
            'print' => '打印',
            'email' => '电子邮件',
            'intro' => '在圣保罗学院（SPI），我们不仅关注学术成果，还致力于丰富学生的校园生活。',
            'services' => [
                [
                    'icon' => '🤝',
                    'title' => '职业咨询服务',
                    'desc' => '提供简历撰写、面试技巧指导，并举办校园招聘会。'
                ],
                [
                    'icon' => '⚽',
                    'title' => '体育休闲项目',
                    'desc' => '拥有标准的足球场、排球场，促进身心健康与团队协作。'
                ]
            ]
        ]
    ];

    $text = $content[$learningLocale] ?? $content['km'];
@endphp

@extends('frontend.layouts.master')

@section('title', $text['title'].' | LearnCore LMS')

@section('content')
    <section class="learning-about-article">
        <div id="k2Container" class="itemView learning-about-k2">
            <div class="itemHeader">
                <h2 class="itemTitle">{{ $text['title'] }}</h2>

                <div class="row-fluid itemToolbar">
                    <span class="itemDateCreated">
                        <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $text['date'] }}
                    </span>

                    <span class="itemAuthor">
                        &nbsp;|&nbsp;
                        <i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ $text['author'] }}
                    </span>

                    <span class="itemHits">
                        &nbsp;|&nbsp;
                        <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $text['views'] }}
                    </span>

                    <span>
                        &nbsp;|&nbsp;
                        <button type="button" class="learning-about-tool" data-no-loading onclick="window.print()">
                            <i class="fa fa-print" aria-hidden="true"></i>&nbsp;{{ $text['print'] }}
                        </button>
                    </span>

                    <span>
                        &nbsp;|&nbsp;
                        <a class="learning-about-tool" href="mailto:?subject={{ rawurlencode($text['title']) }}" data-no-loading>
                            <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{ $text['email'] }}
                        </a>
                    </span>
                </div>
            </div>

            <div class="itemBody">
                <div class="itemFullText">
                    <div class="learning-about-banner" style="background: linear-gradient(135deg, #0284c7 0%, #06b6d4 100%);">
                        <h2>{{ $text['banner'] }}</h2>
                    </div>

                    <blockquote class="learning-about-summary">
                        <p>{{ $text['intro'] }}</p>
                    </blockquote>

                    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 24px; margin: 36px 0;">
                        @foreach($text['services'] as $serv)
                            <div style="border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; background: #fff; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.05);">
                                <div style="font-size: 36px; margin-bottom: 14px;">{{ $serv['icon'] }}</div>
                                <h3 style="margin: 0 0 10px; font-size: 18px; font-weight: 800; color: #0284c7;">{{ $serv['title'] }}</h3>
                                <p style="margin: 0; font-size: 14px; line-height: 1.7; color: #475569;">{{ $serv['desc'] }}</p>
                            </div>
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
            font-family: 'Battambang', 'Khmer OS Siemreap', Arial, sans-serif;
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
            font-size: 28px;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 10px;
        }

        .learning-about-k2 .itemToolbar {
            font-size: 13px;
            color: #64748b;
        }

        .learning-about-tool {
            background: none;
            border: none;
            color: #64748b;
            padding: 0;
            cursor: pointer;
            text-decoration: none;
            transition: color 0.2s;
        }

        .learning-about-tool:hover {
            color: #2563eb;
        }

        .learning-about-banner {
            padding: 40px;
            border-radius: 16px;
            color: #fff;
            margin: 28px 0;
            text-align: center;
        }

        .learning-about-banner h2 {
            margin: 0;
            font-size: 24px;
            font-weight: 800;
        }

        .learning-about-summary {
            border-left: 4px solid #06b6d4;
            padding-left: 20px;
            margin: 24px 0;
            font-style: italic;
            color: #475569;
        }
    </style>
@endpush
