@php
    $videoContent = getContent('video.content', true);
@endphp
<section class="video-section pb-110">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-lg-7 col-md-6">
                <div class="video-content">
                    <h2 class="video-content__title" data-s-break="2">{{ __(@$videoContent->data_values->heading) }}</h2>
                    <p class="video-content__desc">
                        {{ __(@$videoContent->data_values->description) }}
                    </p>
                </div>
            </div>
            <div class="col-xl-5 offset-xl-1 col-lg-5 col-md-6">
                <div class="video-thumb">
                    <img src="{{ getImage('assets/images/frontend/video/' . $videoContent->data_values->video_image, '550x550') }}" alt="image">
                    <a href="{{ __(@$videoContent->data_values->video_link) }}" class="play-btn popup_video"><i class="icon-play"></i></a>
                </div>
            </div>
        </div>
    </div>
</section>

@push('style-lib')
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/lightcase.css') }}">
@endpush
