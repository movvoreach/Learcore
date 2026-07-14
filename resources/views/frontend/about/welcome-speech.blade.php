@php
    $learningLocale = session('learning_locale', 'km');

    $content = [
        'km' => [
            'title' => 'សុន្ទរកថាស្វាគមន៍ពីនាយកវិទ្យាស្ថាន',
            'banner' => 'ស្វាគមន៍មកកាន់វិទ្យាស្ថានសេនប៉ូល (SPI)',
            'director_name' => 'លោកជំទាវបណ្ឌិត ភឿង សកុណា',
            'director_title' => 'នាយិកាវិទ្យាស្ថានសេនប៉ូល',
            'date' => 'ច័ន្ទ, 13 កក្កដា 2026',
            'author' => 'SPI Admin',
            'views' => 'ទំព័រព័ត៌មាន',
            'print' => 'បោះពុម្ព',
            'email' => 'Email',
            'intro' => 'ក្នុងនាមគណៈគ្រប់គ្រង បុគ្គលិក និងសាស្ត្រាចារ្យទាំងអស់នៃវិទ្យាស្ថានសេនប៉ូល (SPI) ខ្ញុំមានសេចក្តីសោមនស្សរីករាយយ៉ាងក្រៃលែងក្នុងការស្វាគមន៍យ៉ាងកក់ក្តៅចំពោះសិស្ស និស្សិត និងភ្ញៀវកិត្តិយសទាំងអស់ដែលបានចូលមកកាន់ប្រព័ន្ធគ្រប់គ្រងការសិក្សាឌីជីថល LearnCore LMS របស់យើង។',
            'paragraphs' => [
                'វិទ្យាស្ថានសេនប៉ូល (SPI) ត្រូវបានបង្កើតឡើងក្នុងគោលបំណងផ្តល់ការអប់រំកម្រិតឧត្តមសិក្សាប្រកបដោយគុណភាព សីលធម៌ និងការទទួលខុសត្រូវខ្ពស់ ដើម្បីចូលរួមចំណែកអភិវឌ្ឍធនធានមនុស្សនៅក្នុងប្រទេសកម្ពុជា។ យើងជឿជាក់ថា ការអប់រំគឺជាគ្រឹះដ៏រឹងមាំតែមួយគត់សម្រាប់ការកសាងអនាគតដ៏ភ្លឺស្វាង។',
                'តាមរយៈការប្រើប្រាស់ប្រព័ន្ធ LearnCore LMS នេះ យើងប្តេជ្ញាបង្កើនលទ្ធភាព និងភាពងាយស្រួលក្នុងការសិក្សារបស់និស្សិតគ្រប់រូប។ មិនថាអ្នកស្ថិតនៅទីកន្លែងណាក៏ដោយ អ្នកអាចទទួលបានការបណ្តុះបណ្តាល មេរៀន វីដេអូ និងការទំនាក់ទំនងដោយផ្ទាល់ជាមួយសាស្ត្រាចារ្យយ៉ាងឆាប់រហ័ស និងមានប្រសិទ្ធភាពបំផុត។',
                'ខ្ញុំសូមជូនពរឱ្យនិស្សិតទាំងអស់ទទួលបានជោគជ័យក្នុងការសិក្សា និងអភិវឌ្ឍខ្លួនឱ្យក្លាយជាពលរដ្ឋល្អ ជំនាញច្បាស់លាស់ និងមានមនសិការស្នេហាជាតិខ្ពស់ ដើម្បីអនាគតខ្លួនឯង គ្រួសារ និងសង្គមជាតិទាំងមូល។',
            ],
            'closing' => 'សូមអរគុណ និងសូមជូនពរជួបតែសេចក្តីសុខ សេចក្តីចម្រើន!',
        ],
        'en' => [
            'title' => 'Welcome Speech from the Director',
            'banner' => 'Welcome to St. Paul Institute (SPI)',
            'director_name' => 'Dr. Phon Sophal',
            'director_title' => 'Director of St. Paul Institute',
            'date' => 'Monday, July 13, 2026',
            'author' => 'SPI Admin',
            'views' => 'Information page',
            'print' => 'Print',
            'email' => 'Email',
            'intro' => 'On behalf of the management, staff, and professors of St. Paul Institute (SPI), I am absolutely delighted to extend a warm welcome to all students, lecturers, and esteemed guests visiting our digital LearnCore LMS.',
            'paragraphs' => [
                'St. Paul Institute (SPI) was established to provide higher education with outstanding academic quality, ethics, and high responsibility, contributing directly to the human resource development of Cambodia. We believe that quality education is the solid foundation for building a successful future.',
                'By integrating the LearnCore LMS platform, we are committed to enhancing access to quality education for every student. Wherever you are, you can access courses, videos, documents, and interact with your lecturers seamlessly and efficiently.',
                'I wish all students a wonderful, productive academic journey and hope you develop yourselves into highly capable, ethical professionals ready to make a positive impact on society.',
            ],
            'closing' => 'Thank you and wish you all the very best!',
        ],
    ];

    // Fallbacks for French and Chinese to avoid missing content
    $content['fr'] = [
        'title' => 'Discours de bienvenue du Directeur',
        'banner' => 'Bienvenue à l\'Institut Saint Paul (SPI)',
        'director_name' => 'Dr. Phon Sophal',
        'director_title' => 'Directeur de l\'Institut Saint Paul',
        'date' => 'Lundi, 13 Juillet 2026',
        'author' => 'SPI Admin',
        'views' => 'Page d\'information',
        'print' => 'Imprimer',
        'email' => 'Email',
        'intro' => 'Au nom de la direction, du personnel et des professeurs de l\'Institut Saint Paul (SPI), je suis ravi d\'adresser un accueil chaleureux à tous les étudiants et invités sur notre portail LearnCore LMS.',
        'paragraphs' => [
            'L\'Institut Saint Paul a pour mission de dispenser un enseignement supérieur de qualité, éthique et responsable. Nous croyons que l\'éducation est le pilier de l\'avenir.',
            'Avec LearnCore LMS, nous facilitons l\'accès à l\'apprentissage numérique où que vous soyez.',
        ],
        'closing' => 'Merci et bonne réussite à tous !',
    ];

    $content['zh'] = [
        'title' => '校长欢迎致辞',
        'banner' => '欢迎来到圣保罗学院 (SPI)',
        'director_name' => 'Dr. Phon Sophal',
        'director_title' => '圣保罗学院校长',
        'date' => '2026年7月13日',
        'author' => 'SPI 管理员',
        'views' => '信息页面',
        'print' => '打印',
        'email' => '电子邮件',
        'intro' => '我谨代表圣保罗学院（SPI）的全体管理层、员工和教授，向所有登录 LearnCore 学习管理系统的学生、教师和来宾致以最热烈的欢迎。',
        'paragraphs' => [
            '圣保罗学院（SPI）旨在提供具有卓越学术质量、道德规范和高度责任感的教育，为柬埔寨的人才培养做出贡献。',
            '通过集成 LearnCore LMS 平台，我们致力于提高每位学生获取优质教育的机会。',
        ],
        'closing' => '谢谢大家，祝大家前程似锦！',
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
                    <div class="learning-about-banner" style="background: linear-gradient(135deg, #1e3a8a 0%, #3b82f6 100%);">
                        <h2>{{ $text['banner'] }}</h2>
                    </div>

                    <blockquote class="learning-about-summary">
                        <p>{{ $text['intro'] }}</p>
                    </blockquote>

                    <div style="font-size: 16px; line-height: 1.8; color: #334155; margin-bottom: 40px;">
                        @foreach($text['paragraphs'] as $para)
                            <p style="margin-bottom: 20px; text-indent: 30px;">{{ $para }}</p>
                        @endforeach
                    </div>

                    <div style="text-align: right; border-top: 1px dashed #e2e8f0; padding-top: 20px;">
                        <h4 style="margin: 0; font-weight: 800; color: #1e3a8a;">{{ $text['director_name'] }}</h4>
                        <p style="margin: 4px 0 0; font-size: 14px; color: #64748b;">{{ $text['director_title'] }}</p>
                        <p style="margin: 8px 0 0; font-style: italic; font-weight: 600; color: #059669;">{{ $text['closing'] }}</p>
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
            border-left: 4px solid #3b82f6;
            padding-left: 20px;
            margin: 24px 0;
            font-style: italic;
            color: #475569;
        }
    </style>
@endpush
