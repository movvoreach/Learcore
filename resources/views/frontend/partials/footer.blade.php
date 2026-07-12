@once
    <style>
        body.frontend-page .frontend-main,
        body.frontend-page #page-footer {
            font-weight: 400;
        }

        body.frontend-page .frontend-main p,
        body.frontend-page .frontend-main li,
        body.frontend-page .frontend-main span,
        body.frontend-page .frontend-main small,
        body.frontend-page .frontend-main time,
        body.frontend-page .frontend-main a,
        body.frontend-page #page-footer p,
        body.frontend-page #page-footer span,
        body.frontend-page #page-footer a {
            font-weight: 400 !important;
        }

        body.frontend-page .frontend-main h1,
        body.frontend-page .frontend-main h2,
        body.frontend-page .frontend-main h3,
        body.frontend-page .frontend-main h4,
        body.frontend-page .frontend-main strong,
        body.frontend-page #page-footer h3,
        body.frontend-page #page-footer strong {
            font-weight: 600 !important;
        }

        body.frontend-page .frontend-main .learning-slide-btn,
        body.frontend-page .frontend-main .learning-course-btn,
        body.frontend-page .frontend-main .learning-program-card a,
        body.frontend-page .frontend-main .learning-news-card a,
        body.frontend-page .frontend-main .learning-cta-band__actions a,
        body.frontend-page .frontend-main .learning-faq-question {
            font-weight: 500 !important;
        }

        body.frontend-page .frontend-main .learning-stat strong,
        body.frontend-page .frontend-main .js-counter {
            font-weight: 600 !important;
        }

        #page-footer {
            background-color: #07152f;
            color: #dbe7ff;
            padding: 40px 0 0 0;
            border-top: 1px solid rgba(255, 255, 255, 0.1);
        }

        #page-footer a {
            color: #aab8d2;
            text-decoration: none;
            transition: color 0.25s ease;
        }

        #page-footer a:hover {
            color: #ffffff;
        }

        #page-footer .blockplace1 {
            padding-bottom: 20px;
            border-bottom: 1px solid rgba(255, 255, 255, 0.08);
            margin-bottom: 20px;
        }

        #page-footer .blockplace1 a {
            color: #dbe7ff;
            font-weight: 500;
        }

        #page-footer .blockplace1 a:hover {
            color: var(--learning-orange, #ff5b00);
        }

        #page-footer .socialicons {
            text-align: center;
            margin-bottom: 30px;
        }

        #page-footer .socialicons a {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.06);
            color: #aab8d2;
            margin: 0 10px;
            font-size: 20px;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
        }

        #page-footer .socialicons a:hover {
            background: var(--learning-orange, #ff5b00);
            color: #ffffff;
            transform: translateY(-4px);
            box-shadow: 0 6px 15px rgba(255, 91, 0, 0.4);
        }

        #page-footer .info.container2 {
            background: rgba(0, 0, 0, 0.25);
            padding: 30px 0;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        #page-footer .tool_dataprivacy {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        #page-footer .tool_dataprivacy a {
            color: #aab8d2;
            font-weight: 500;
        }

        #page-footer .tool_dataprivacy a:hover {
            color: #ffffff;
            text-decoration: underline;
        }

        @media (max-width: 767.98px) {
            #page-footer .tool_dataprivacy {
                justify-content: center;
                margin-top: 15px;
            }
            #page-footer .left-col {
                text-align: center !important;
            }
            #page-footer .left-col p {
                text-align: center !important;
            }
        }
    </style>
@endonce

<footer id="page-footer" class="d-none d-sm-block">
    <div id="course-footer"></div>
    <div class="container blockplace1">
        <div class="row">
            <div class="left-col col-12">
                <p dir="ltr" style="text-align:right;"><br></p>
                <p dir="ltr" style="text-align:right;">
                    <a href="{{ route('frontend.about') }}">អំពីយើង</a>&nbsp; &nbsp; &nbsp;
                    <a href="{{ route('frontend.terms') }}">លក្ខខណ្ឌនៃការប្រើប្រាស់</a>&nbsp; &nbsp; &nbsp;
                    <a href="{{ route('frontend.faqs') }}">សំណួរដែលសួរញឹកញាប់</a><br>
                </p>
            </div>
        </div>
    </div>
    <div class="container">
        <div class="row">
            <div class="col-12 pagination-centered socialicons">
                <a target="_blank" title="ស្វែងរកវគ្គសិក្សា" href="{{ route('frontend.courses') }}"><i class="fa fa-search"></i></a>
                <a target="_blank" title="Facebook Page LearnCore" href="https://www.facebook.com/"><i class="fa fa-facebook-square"></i></a>
                <a target="_blank" title="LearnCore website" href="{{ route('dashboard') }}"><i class="fa fa-globe"></i></a>
                <a target="_blank" title="LearnCore Youtube" href="https://www.youtube.com/"><i class="fa fa-youtube-square"></i></a>
            </div>
        </div>
    </div>
    <div class="info container2 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-8 my-md-0 my-2">
                    <div class="tool_usertours-resettourcontainer"></div>
                    <div style="color:#FFFFFF;padding:20px;max-width:100%;">
                        <p style="text-align:center;"><span style="font-size:14.44px;">ប្រព័ន្ធគ្រប់គ្រងការសិក្សា LearnCore LMS អាសយដ្ឋាន៖ រាជធានីភ្នំពេញ ព្រះរាជាណាចក្រកម្ពុជា&nbsp;</span></p>
                        <p style="text-align:center;"><span style="font-size:14.44px;">ទូរសព្ទ៖ (៨៥៥) ២៣ ៩៩៩ ៩៩៩ អ៊ីមែល៖ info@learncore.com / webmaster@learncore.com</span></p>
                        <p style="text-align:center;"><span style="font-size:14.44px;">Copyright © 2023 - {{ date('Y') }} LearnCore LMS All rights reserved.</span></p>
                    </div>
                </div>
                <div class="col-md-4 my-md-0 my-2">
                    <div class="tool_dataprivacy">
                        <a href="#">សេចក្តីសង្ខេបពីការរក្សាទុកទិន្នន័យ</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>

