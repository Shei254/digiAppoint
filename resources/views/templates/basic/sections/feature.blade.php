@php
    $featureContent = getContent('feature.content', true);
    $featureElements = getContent('feature.element', orderById:true);
@endphp

<section class="feature-section pb-110 bg-img"
    data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/feature-bg.png') }}">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title" data-s-break="1">{{ __(@$featureContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-3">
            @foreach ($featureElements as $featureElement)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="feature-item text-center">
                        <span class="feature-item__icon">
                            <img src="{{ getImage('assets/images/frontend/feature/' . $featureElement->data_values->image, '65x60') }}" alt="image">
                        </span>
                        <h6 class="feature-item__title">{{ __(@$featureElement->data_values->title) }}</h6>
                        <p class="feature-item__desc">{{ __(@$featureElement->data_values->description) }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
