@php
    $learningLocale = session('learning_locale', 'km');

    $content = [
        'km' => [
            'title' => 'អតីតនិស្សិតវិទ្យាស្ថានសេនប៉ូល (SPI)',
            'banner' => 'បណ្តាញអតីតនិស្សិត និងជោគជ័យសិក្សា',
            'date' => 'ច័ន្ទ, 13 កក្កដា 2026',
            'author' => 'SPI Admin',
            'views' => 'ទំព័រព័ត៌មាន',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'intro' => 'និស្សិតបញ្ចប់ការសិក្សាពីវិទ្យាស្ថានសេនប៉ូល (SPI) បាននឹងកំពុងបម្រើការងារយ៉ាងសកម្មនៅក្នុងស្ថាប័នរដ្ឋ ឯកជន និងអង្គការមិនមែនរដ្ឋាភិបាលជាច្រើន ទាំងក្នុងប្រទេស និងក្រៅប្រទេស។',
            'sections' => [
                [
                    'year' => 'បណ្តាញអតីតនិស្សិត',
                    'title' => 'ការភ្ជាប់ទំនាក់ទំនងរវាងសិស្សចាស់ និងសិស្សថ្មី',
                    'text' => 'SPI តែងតែរៀបចំកម្មវិធីជួបជុំសិស្សចាស់ជាប្រចាំឆ្នាំ ដើម្បីចែករំលែកបទពិសោធន៍ការងារ ឱកាសការងារថ្មីៗ និងការជួយគាំទ្រគ្នាទៅវិញទៅមកក្នុងអាជីពវិជ្ជាជីវៈ។'
                ],
                [
                    'year' => 'រឿងរ៉ាវជោគជ័យ',
                    'title' => 'មោទនភាពរបស់វិទ្យាស្ថាន',
                    'text' => 'អតីតនិស្សិតជាច្រើនបានក្លាយជាអ្នកគ្រប់គ្រង អ្នកបង្កើតអាជីវកម្មផ្ទាល់ខ្លួន អ្នកជំនាញផ្នែកព័ត៌មានវិទ្យា និងគ្រូបង្រៀនដែលមានសមត្ថភាពខ្ពស់ ដែលកំពុងចូលរួមចំណែកអភិវឌ្ឍន៍សហគមន៍។'
                ]
            ]
        ],
        'en' => [
            'title' => 'SPI Alumni Network',
            'banner' => 'Alumni Network & Career Success',
            'date' => 'Monday, July 13, 2026',
            'author' => 'SPI Admin',
            'views' => 'Information page',
            'print' => 'Print',
            'email' => 'Email',
            'intro' => 'Graduates of St. Paul Institute (SPI) have successfully built careers across government ministries, private corporations, and non-governmental organizations domestically and globally.',
            'sections' => [
                [
                    'year' => 'Alumni Connection',
                    'title' => 'Connecting Past and Present Students',
                    'text' => 'SPI organizes annual alumni reunions to foster professional networking, share career opportunities, and provide mentorship for current students.'
                ],
                [
                    'year' => 'Success Stories',
                    'title' => 'Institute Pride',
                    'text' => 'Many of our graduates have gone on to become successful business managers, startup founders, software engineers, and community educators, demonstrating leadership in their fields.'
                ]
            ]
        ],
        'fr' => [
            'title' => 'Réseau des Anciens Élèves (Alumni)',
            'banner' => 'Réseau Alumni & Réussite',
            'date' => 'Lundi, 13 Juillet 2026',
            'author' => 'SPI Admin',
            'views' => 'Page d\'information',
            'print' => 'Imprimer',
            'email' => 'Email',
            'intro' => 'Les diplômés de l\'Institut Saint Paul (SPI) travaillent activement dans de nombreux secteurs professionnels.',
            'sections' => [
                [
                    'year' => 'Réseau',
                    'title' => 'Rencontres Annuelles',
                    'text' => 'Événements annuels pour partager les opportunités d\'emploi.'
                ]
            ]
        ],
        'zh' => [
            'title' => 'SPI 校友网络',
            'banner' => '校友网络与职业成功',
            'date' => '2026年7月13日',
            'author' => 'SPI 管理员',
            'views' => '信息页面',
            'print' => '打印',
            'email' => '电子邮件',
            'intro' => '圣保罗学院（SPI）的毕业生已在国内外多个政府机构、私营企业和非政府组织中成功建立了职业生涯。',
            'sections' => [
                [
                    'year' => '校友联络',
                    'title' => '连接新老学生',
                    'text' => 'SPI 举办年度校友聚会，以促进专业网络，并为在校生提供就业机会指导。'
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
                    <div class="learning-about-banner" style="background: linear-gradient(135deg, #ea580c 0%, #f97316 100%);">
                        <h2>{{ $text['banner'] }}</h2>
                    </div>

                    <blockquote class="learning-about-summary">
                        <p>{{ $text['intro'] }}</p>
                    </blockquote>

                    <div style="display: flex; flex-direction: column; gap: 32px; margin: 36px 0;">
                        @foreach($text['sections'] as $sec)
                            <div style="display: flex; flex-wrap: wrap; gap: 24px; padding: 24px; border: 1px solid #e2e8f0; border-radius: 14px; background: #fff;">
                                <div style="min-width: 140px; color: #ea580c; font-weight: 800; font-size: 18px;">
                                    🎓 {{ $sec['year'] }}
                                </div>
                                <div style="flex: 1; min-width: 280px;">
                                    <h3 style="margin: 0 0 10px; font-size: 16px; font-weight: 800; color: #1e293b;">{{ $sec['title'] }}</h3>
                                    <p style="margin: 0; font-size: 14px; line-height: 1.8; color: #475569;">{{ $sec['text'] }}</p>
                                </div>
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
            border-left: 4px solid #f97316;
            padding-left: 20px;
            margin: 24px 0;
            font-style: italic;
            color: #475569;
        }
    </style>
@endpush
