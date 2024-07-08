@php
    $coverageContent = getContent('coverage.content', true);
    $coverageElements = getContent('coverage.element', orderById: true);
@endphp
<div class="client">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-12">
                <div class="section-heading">
                    <h5 data-s-break="3" class="section-heading__title">{{ __(@$coverageContent->data_values->heading) }}
                    </h5>
                </div>
            </div>
        </div>
        <div class="client_slider owl-carousel">
            @foreach ($coverageElements as $key => $coverageElement)
                <img src="{{ getImage('assets/images/frontend/coverage/' . $coverageElement->data_values->image, '200x40') }}" alt="image">
            @endforeach
        </div>
    </div>
</div>

@push('script-lib')
    <script src="{{ getImage($activeTemplateTrue . 'js/owl.carousel.min.js') }}"></script>
    <script src="{{ getImage($activeTemplateTrue . 'js/owl.carousel.filter.js') }}"></script>
    <script src="{{ getImage($activeTemplateTrue . 'js/lightcase.js') }}"></script>
@endpush



@push('style-lib')
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/owl.theme.default.min.css') }}">
    <link rel="stylesheet" href="{{ getImage($activeTemplateTrue . 'css/owl.carousel.min.css') }}">
@endpush
