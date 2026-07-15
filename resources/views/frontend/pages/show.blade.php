@extends('frontend.layouts.master')

@section('title', $page->seo_title ?: $page->title)

@push('styles')
    <style>
        .cms-page {
            max-width: 980px;
            margin: 0 auto;
            padding: 48px 18px 72px;
        }

        .cms-page__thumbnail {
            width: 100%;
            max-height: 360px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 28px;
        }

        .cms-page__title {
            color: #172554;
            font-size: 34px;
            font-weight: 700;
            margin-bottom: 24px;
        }

        .cms-page__content {
            color: #334155;
            line-height: 1.8;
            font-size: 16px;
        }
    </style>
@endpush

@section('content')
    <article class="cms-page">
        @if($page->thumbnail)
            <img class="cms-page__thumbnail" src="{{ \App\Services\BrandingService::assetUrl($page->thumbnail) }}" alt="{{ $page->title }}">
        @endif

        <h1 class="cms-page__title">{{ $page->title }}</h1>

        <div class="cms-page__content">
            {!! $page->content !!}
        </div>
    </article>
@endsection
