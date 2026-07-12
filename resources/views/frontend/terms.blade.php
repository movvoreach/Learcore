@php
    $learningLocale = session('learning_locale', 'km');

    $termsContent = [
        'km' => [
            'title' => 'លក្ខខណ្ឌនៃការប្រើប្រាស់ និងគោលការណ៍ឯកជនភាព',
            'date' => 'សៅរ៍, 11 កក្កដា 2026',
            'author' => 'LearnCore LMS',
            'views' => 'លក្ខខណ្ឌ និងឯកជនភាព',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'banner' => 'គោលការណ៍ឯកជនភាព និងលក្ខខណ្ឌនៃការប្រើប្រាស់ប្រព័ន្ធ LearnCore LMS',
            'intro' => 'សេចក្តីថ្លែងការណ៍អំពីគោលការណ៍ឯកជនភាព លក្ខខណ្ឌនៃការប្រើប្រាស់ ព្រមទាំងការរក្សាសិទ្ធិក្នុងការប្រើប្រាស់ប្រព័ន្ធគ្រប់គ្រងការសិក្សាឌីជីថល LearnCore LMS។',
            'sections' => [
                [
                    'title' => '១. សេចក្តីថ្លែងការណ៍រក្សាសិទ្ធិ និងការមិនទទួលខុសត្រូវ',
                    'content' => 'ក្រុមការងារអភិវឌ្ឍន៍ LearnCore LMS រក្សាសិទ្ធិគ្រប់យ៉ាងក្នុងគេហទំព័រនេះ (' . url('/') . ') ទាំងមូល និងសម្រាប់រាល់ឯកសារនៅលើគេហទំព័រនេះ ដែលត្រូវបានបង្កើតឡើងដោយ ឬក្នុងនាម LearnCore LMS។ លើកលែងតែមានការកត់សម្គាល់ផ្សេងពីនេះ សម្ភារៈនៅលើគេហទំព័រនេះត្រូវបានផ្តល់អាជ្ញាប័ណ្ណក្រោមអាជ្ញាប័ណ្ណ Creative Commons Attribution-NonCommercial-ShareAlike 3.0 (CC BY NC SA 3.0)។',
                    'list' => [
                        'ការប្រើប្រាស់សម្ភារៈទាំងអស់ ឬផ្នែកណាមួយនៅលើគេហទំព័រនេះ ត្រូវតែបញ្ជាក់ប្រភពដើមទាក់ទងនឹងសម្ភារៈដែលបានប្រើប្រាស់។',
                        'រក្សាសិទ្ធិគ្រប់យ៉ាងដោយ © LearnCore LMS ' . date('Y') . '។',
                        'សម្រាប់ការប្រើប្រាស់ឡើងវិញ ឬការចែកចាយឡើងវិញ អ្នកត្រូវតែបញ្ជាក់ឱ្យច្បាស់ដល់អ្នកដទៃអំពីលក្ខខណ្ឌអាជ្ញាប័ណ្ណ។ វិធីល្អបំផុតដើម្បីធ្វើដូចនេះគឺការភ្ជាប់ទៅកាន់អាជ្ញាប័ណ្ណ CC BY ដែលបានបញ្ជាក់ខាងលើ។',
                        'ក្នុងការប្រើប្រាស់សម្ភារៈរបស់ LearnCore LMS អ្នកមិនត្រូវបង្ហាញក្នុងន័យណាមួយថា LearnCore LMS គាំទ្ររូបអ្នក ឬការងាររបស់អ្នកឡើយ។'
                    ]
                ],
                [
                    'title' => '២. សម្ភារៈដែលត្រូវបានដកចេញ និងការរក្សាសិទ្ធិពិសេស',
                    'content' => 'សិទ្ធិទាំងអស់នៅក្នុងសម្ភារៈដែលបានរាយខាងក្រោមត្រូវបានរក្សាទុកយ៉ាងតឹងរ៉ឹង៖',
                    'list' => [
                        'ឡូហ្គោ និងនិមិត្តសញ្ញារបស់ LearnCore LMS',
                        'រាល់រូបភាព ក្រាហ្វិក និងទ្រព្យសម្បត្តិដែលមើលឃើញរបស់ប្រព័ន្ធ',
                        'រាល់សម្ភារៈ និងខ្លឹមសារសិក្សារបស់ភាគីទីបី'
                    ]
                ],
                [
                    'title' => '៣. ការបដិសេធមិនទទួលខុសត្រូវ',
                    'content' => 'ព័ត៌មាននៅលើគេហទំព័រនេះត្រូវបានបង្ហាញដោយ LearnCore LMS។ ស្របតាមគោលបំណងនៃធនធានអប់រំឌីជីថល គេហទំព័រនេះផ្តល់នូវបណ្ណាល័យធនធានអប់រំទូទៅដើម្បីបម្រើសកម្មភាពបណ្តុះបណ្តាល និងការបង្រៀន។ LearnCore LMS តាមដានគុណភាពនៃព័ត៌មានដែលមាននៅលើគេហទំព័រនេះ និងធ្វើបច្ចុប្បន្នភាពព័ត៌មានជាប្រចាំ។ ទោះជាយ៉ាងណាក៏ដោយ LearnCore LMS មិនធានាចំពោះខ្លឹមសារ ឬភាពជឿជាក់នៃសម្ភារៈណាមួយដែលមាននៅលើគេហទំព័រនេះ ឬនៅលើគេហទំព័រដែលបានភ្ជាប់ភ្ជាប់ឡើយ។ LearnCore LMS មិនទទួលខុសត្រូវចំពោះការជ្រៀតជ្រែក ការបាត់បង់ ការខូចខាត ឬការរំខានដល់ប្រព័ន្ធកុំព្យូទ័រផ្ទាល់ខ្លួនរបស់អ្នក ដែលកើតឡើងពាក់ព័ន្ធនឹងការប្រើប្រាស់គេហទំព័រនេះ ឬគេហទំព័រភ្ជាប់ណាមួយឡើយ។',
                    'list' => []
                ],
                [
                    'title' => '៤. តំណភ្ជាប់ទៅកាន់គេហទំព័រខាងក្រៅ',
                    'content' => 'តំណភ្ជាប់ទៅកាន់គេហទំព័រផ្សេងទៀតត្រូវបានបញ្ចូលដើម្បីភាពងាយស្រួល និងមិនបង្កើតជាការគាំទ្រសម្ភារៈនៅលើគេហទំព័រទាំងនោះ ឬអង្គការ ផលិតផល ឬសេវាកម្មពាក់ព័ន្ធណាមួយឡើយ។ ប្រសិនបើអ្នកបានរកឃើញតំណភ្ជាប់ដែលខូច សូមទាក់ទងមកយើងខ្ញុំ។',
                    'list' => []
                ],
                [
                    'title' => '៥. ការដាក់ស្នើជាសាធារណៈ',
                    'content' => 'គេហទំព័រនេះអាចមានមតិយោបល់ជាសាធារណៈដែលទទួលបានពីភាគីទីបី។ សម្ភារៈភាគីទីបីបែបនេះត្រូវបានចងក្រងឡើងដោយស្មោះត្រង់ ប៉ុន្តែមិនឆ្លុះបញ្ចាំងពីទស្សនៈរបស់ LearnCore LMS ឡើយ។ LearnCore LMS រក្សាសិទ្ធិក្នុងការបន្ថែម ផ្លាស់ប្តូរ ឬលុបព័ត៌មាននៅពេលណាក៏បាន និងដោយគ្មានការជូនដំណឹងជាមុន។',
                    'list' => []
                ]
            ]
        ],
        'en' => [
            'title' => 'Terms of Use and Privacy Policy',
            'date' => 'Saturday, July 11, 2026',
            'author' => 'LearnCore LMS',
            'views' => 'Terms & Privacy',
            'print' => 'Print',
            'email' => 'Email',
            'banner' => 'Privacy Policy & Terms of Use of LearnCore LMS',
            'intro' => 'Official privacy policy, disclaimer statements, copyright rules, and terms of use for the digital learning management platform LearnCore LMS.',
            'sections' => [
                [
                    'title' => '1. Copyright and Disclaimer Statement',
                    'content' => 'The LearnCore LMS Development Team retains copyright in this website (' . url('/') . ') as a whole and for all material on this website that is authored by or on behalf of LearnCore LMS. Unless otherwise noted, material on this website is licensed under a Creative Commons Attribution-NonCommercial-ShareAlike 3.0 License (CC BY NC SA 3.0).',
                    'list' => [
                        'Any use of all or part of the material on this website must include proper attribution in relation to the material used.',
                        'All rights reserved © LearnCore LMS ' . date('Y') . '.',
                        'For any reuse or distribution, you must make clear to others the license terms. The best way to do this is to link or refer to the CC BY license outlined above.',
                        'In using LearnCore LMS material you may not, in any way, suggest that LearnCore LMS endorses you or your work.'
                    ]
                ],
                [
                    'title' => '2. Material Excluded and Rights Reserved',
                    'content' => 'All rights in the materials listed below are strictly reserved:',
                    'list' => [
                        'LearnCore LMS branding and logo assets',
                        'All system graphics, visual interfaces, and media files',
                        'All third-party learning materials and copyrighted content'
                    ]
                ],
                [
                    'title' => '3. Disclaimer',
                    'content' => 'The information on this website is presented by LearnCore LMS. In line with the objectives of digital educational resources, this website offers a repository of general educational resources to serve training and teaching activities. LearnCore LMS monitors the quality of the information available on this website and updates the information regularly. However, LearnCore LMS does not make any warranty about the content or reliability of any material contained on this website or on any linked websites. LearnCore LMS accepts no responsibility for any interference, loss, damage, or disruption to your own computer system which arises in connection with your use of this website or any linked website.',
                    'list' => []
                ],
                [
                    'title' => '4. Links to External Websites',
                    'content' => 'Links to other websites are inserted for convenience and do not constitute endorsement of material at those sites, or any associated organisation, product or service. If you have found a broken link, please contact us.',
                    'list' => []
                ],
                [
                    'title' => '5. Public Submissions',
                    'content' => 'This website may contain public comment submissions received from third parties. Such third-party material is assembled in good faith, but does not necessarily reflect the considered views of LearnCore LMS. LearnCore LMS reserves the right to add, change, or delete information at any given time and without prior notification.',
                    'list' => []
                ]
            ]
        ]
    ];

    $termsText = $termsContent[$learningLocale] ?? $termsContent['km'];
@endphp

@extends('frontend.layouts.master')

@section('title', $termsText['title'].' | LearnCore LMS')

@section('content')
    <div id="page-content" class="row justify-content-center">
        <section id="region-main" class="col-12 col-lg-10">
            <div class="learning-about-article">
                <div id="k2Container" class="itemView learning-about-k2">
                    <div class="itemHeader">
                        <h2 class="itemTitle">{{ $termsText['title'] }}</h2>

                        <div class="row-fluid itemToolbar">
                            <span class="itemDateCreated">
                                <i class="fa fa-calendar" aria-hidden="true"></i>&nbsp;{{ $termsText['date'] }}
                            </span>

                            <span class="itemAuthor">
                                &nbsp;|&nbsp;
                                <i class="fa fa-user" aria-hidden="true"></i>&nbsp;{{ $termsText['author'] }}
                            </span>

                            <span class="itemHits">
                                &nbsp;|&nbsp;
                                <i class="fa fa-eye" aria-hidden="true"></i>&nbsp;{{ $termsText['views'] }}
                            </span>

                            <span>
                                &nbsp;|&nbsp;
                                <button type="button" class="learning-about-tool" data-no-loading onclick="window.print()">
                                    <i class="fa fa-print" aria-hidden="true"></i>&nbsp;{{ $termsText['print'] }}
                                </button>
                            </span>

                            <span>
                                &nbsp;|&nbsp;
                                <a class="learning-about-tool" href="mailto:?subject={{ rawurlencode($termsText['title']) }}" data-no-loading>
                                    <i class="fa fa-envelope" aria-hidden="true"></i>&nbsp;{{ $termsText['email'] }}
                                </a>
                            </span>
                        </div>
                    </div>

                    <div class="itemBody">
                        <div class="itemFullText">
                            <div class="learning-about-banner">
                                <h2>{{ $termsText['banner'] }}</h2>
                            </div>

                            <blockquote class="learning-about-summary">
                                <p>{{ $termsText['intro'] }}</p>
                            </blockquote>

                            <div class="learning-about-table mt-4">
                                @foreach($termsText['sections'] as $section)
                                    <article class="learning-about-row">
                                        <div class="learning-about-copy w-100">
                                            <h3 class="h4 mt-2 text-primary font-weight-bold">{{ $section['title'] }}</h3>
                                            <p class="text-justify mt-2" style="font-size: 15px; line-height: 1.8; color: #334155;">
                                                {!! $section['content'] !!}
                                            </p>
                                            @if(!empty($section['list']))
                                                <ul class="pl-4 mt-2" style="list-style-type: disc; color: #475569; line-height: 1.7;">
                                                    @foreach($section['list'] as $item)
                                                        <li class="mb-2" style="font-size: 14.5px;">{{ $item }}</li>
                                                    @endforeach
                                                </ul>
                                            @endif
                                        </div>
                                    </article>
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

        .learning-about-table {
            display: grid;
            gap: 18px;
        }

        .learning-about-row {
            padding: 18px 0 20px;
            border-bottom: 1px solid #e5edf5;
        }

        .learning-about-row:last-child {
            border-bottom: none;
        }
    </style>
@endpush
