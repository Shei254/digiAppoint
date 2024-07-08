@php
    $beneficialContent = getContent('beneficial.content', true);
    $beneficialElements = getContent('beneficial.element', orderById: true);
@endphp

<section class="beneficial-section  pb-110 bg-img" data-background-image="{{ getImage('assets/images/frontend/beneficial/' . $beneficialContent->data_values->image, '1920x1115') }}">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-6 col-md-8 col-sm-9">
                <div class="section-heading">
                    <h2 class="section-heading__title" data-s-break="-1">{{ __(@$beneficialContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-3">
            @foreach ($beneficialElements as $key => $beneficialElement)
                <div class="col-xl-3 col-lg-4 col-sm-6 col-xsm-6">
                    <div class="beneficial-item text-center">
                        <div class="beneficial-item__thumb">
                            <img src="{{ getImage('assets/images/frontend/beneficial/' . @$beneficialElement->data_values->beneficial_image, '295x235') }}" alt="image">
                        </div>
                        <h6 class="beneficial-item__title">{{ __(@$beneficialElement->data_values->title) }}</h6>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
