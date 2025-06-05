@extends('welcome')

@section('content')
    @include('partials.hero')
@endsection

@section('hero-image')
    <div class="-mx-[100px] ">
        <img src="{{ asset('images/hero-section.png') }}" alt="Hero Image" class="w-full h-[400px] object-cover">
    </div>
@endsection

@section('after-hero')
    @include('partials.what')
    @include('partials.question')
    @include('partials.room')
    @include('partials.testimonial')
@endsection
