@extends('welcome')

@section('content')
    @include('partials.hero')
@endsection

@section('hero-image')
    <div class="-mx-[100px] overflow-hidden flex justify-center items-center h-[400px]">
        <img src="{{ asset('images/kost2.jpeg') }}" alt="Hero Image" class="w-full min-w-full object-cover">
    </div>
@endsection

@section('after-hero')
    @include('partials.what')
    @include('partials.question')
    @include('partials.room')
    @include('partials.testimonial')
@endsection
