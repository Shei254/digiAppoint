@php
    $aboutContent = getContent('about.content', true);
    $aboutElements = getContent('about.element', orderById: true);
@endphp

<section class="about-section py-110 bg-img" data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/about-bg.png') }}">
    <div class="container">
        <div class="row align-items-center flex-wrap-reverse">
            <div class="col-xl-6 col-lg-5">
                <div class="about-thumb">
                    <img src="{{ getImage('assets/images/frontend/about/'.@$aboutContent->data_values->about_image,"641x566") }}" alt="image">
                </div>
            </div>
            <div class="col-xl-6 col-lg-7">
                <div class="about-content">
                    <h2 class="about-content__title" data-s-break="2">{{ __(@$aboutContent->data_values->heading) }}</h2>
                    <p class="about-content__desc">
                        {{ __(@$aboutContent->data_values->description) }}
                    </p>
                    <ul class="about-content__list">
                        @foreach ($aboutElements as $key => $aboutElement)
                            <li class="about-content__list-item">
                                <span class="icon">
                                    @php echo $aboutElement->data_values->feature_icon @endphp
                                </span>
                                <div class="content">
                                    <h3 class="number">{{ __(@$aboutElement->data_values->title) }}</h3>
                                    <span class="desc">{{ __(@$aboutElement->data_values->subtitle) }}</span>
                                </div>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

@push('style')
    <style>
        .about-thumb{
            max-width: 570px
        }
    </style>
@endpush