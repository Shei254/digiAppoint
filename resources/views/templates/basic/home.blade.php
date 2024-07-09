@extends('Template::layouts.frontend')
@section('content')
    @php
        $bannerContent = getContent('banner.content', true);
    @endphp
    <section class="banner-section bg-img" data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/banner-bg.png') }}">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xl-11 text-center">
                    <div class="banner-content">
                        <span class="banner-shape one"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/1.png') }}" alt="image"></span>
                        <span class="banner-shape two"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/3.png') }}" alt="image"></span>
                        <span class="banner-shape three"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/4.png') }}" alt="image"></span>
                        <h1 data-s-break="1" class="banner-content__title">{{ __(@$bannerContent->data_values->heading) }}</h1>
                        <p class="banner-content__desc">{{ __(@$bannerContent->data_values->subheading) }}</p>
                    </div>
                    <div class="banner-screenshot">
                        <span class="banner-shape four"><img src="{{ getImage($activeTemplateTrue . 'images/shapes/2.png') }}" alt="image"></span>
                        <img src="{{ getImage('assets/images/frontend/banner/66797140df1331719234880.png', '1030x735') }}" alt="image">
                    </div>
                </div>
            </div>
        </div>
    </section>


    @if (@$sections->secs != null)
        @foreach (json_decode($sections->secs) as $sec)
            @include('Template::sections.' . $sec)
        @endforeach
    @endif

@endsection
