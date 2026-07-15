@php
    $branding ??= [];
    $navigationGroups ??= collect();
    $footerSettings ??= [];
    $contactSettings ??= [];
    $socialLinks ??= [];
    $siteName = $branding['site_name'] ?? 'LearnCore LMS';
    $footerLogo = $branding['footer_logo_url'] ?? null;
@endphp

@once
    <style>
        #page-footer {
            background-color: #07152f;
            color: #dbe7ff;
            padding: 40px 0 0;
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

        #page-footer .footer-links {
            display: flex;
            justify-content: center;
            flex-wrap: wrap;
            gap: 18px 28px;
            margin: 0;
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
            transition: all 0.3s ease;
        }

        #page-footer .socialicons a:hover {
            background: var(--learning-orange, #ff5b00);
            color: #ffffff;
            transform: translateY(-4px);
        }

        #page-footer .info.container2 {
            background: rgba(0, 0, 0, 0.25);
            padding: 30px 0;
            margin-top: 20px;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        #page-footer .footer-logo {
            max-height: 52px;
            max-width: 180px;
            object-fit: contain;
            margin-bottom: 12px;
        }

        #page-footer .tool_dataprivacy {
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: flex-end;
        }

        @media (max-width: 767.98px) {
            #page-footer .tool_dataprivacy {
                justify-content: center;
                margin-top: 15px;
            }
        }
    </style>
@endonce

<footer id="page-footer" class="d-none d-sm-block">
    <div id="course-footer"></div>
    <div class="container blockplace1">
        <div class="row">
            <div class="left-col col-12">
                <div class="footer-links">
                    @foreach($navigationGroups as $group)
                        @foreach($group->rootItems as $item)
                            <a href="{{ $item->resolvedUrl() }}" target="{{ $item->target ?: '_self' }}">{{ $item->translatedTitle() }}</a>
                        @endforeach
                    @endforeach
                </div>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-12 pagination-centered socialicons">
                <a target="_blank" title="Courses" href="{{ route('frontend.courses') }}"><i class="fa fa-search"></i></a>
                @if(! empty($socialLinks['facebook']))
                    <a target="_blank" title="Facebook {{ $siteName }}" href="{{ $socialLinks['facebook'] }}"><i class="fa fa-facebook-square"></i></a>
                @endif
                <a target="_blank" title="{{ $siteName }}" href="{{ route('dashboard') }}"><i class="fa fa-globe"></i></a>
                @if(! empty($socialLinks['youtube']))
                    <a target="_blank" title="Youtube {{ $siteName }}" href="{{ $socialLinks['youtube'] }}"><i class="fa fa-youtube-square"></i></a>
                @endif
            </div>
        </div>
    </div>

    <div class="info container2 clearfix">
        <div class="container">
            <div class="row">
                <div class="col-md-8 my-md-0 my-2">
                    <div style="color:#ffffff;padding:20px;max-width:100%;text-align:center;">
                        @if($footerLogo)
                            <img class="footer-logo" src="{{ $footerLogo }}" alt="{{ $siteName }}">
                        @endif
                        <p>{{ $siteName }} {{ $contactSettings['address'] ?? '' }}</p>
                        <p>{{ $contactSettings['phone'] ?? '' }} {{ $contactSettings['email'] ?? '' }}</p>
                        <p>Copyright &copy; 2023 - {{ date('Y') }} {{ $footerSettings['copyright'] ?? ($siteName.' All rights reserved.') }}</p>
                    </div>
                </div>
                <div class="col-md-4 my-md-0 my-2">
                    <div class="tool_dataprivacy">
                        <a href="{{ $footerSettings['privacy_url'] ?? '#' }}">Privacy summary</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</footer>
