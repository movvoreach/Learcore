@extends('frontend.layouts.master')

@section('title', 'Moodle LMS')

@section('content')
    @include('frontend.partials.slideshow.index')
    @include('frontend.partials.programs.index')
    @include('frontend.partials.courses.index')
    @include('frontend.partials.cta.index')
    @include('frontend.partials.news.index')
    @include('frontend.partials.faq.index')
@endsection
