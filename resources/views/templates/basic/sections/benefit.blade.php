@php
    $benefitContent  = getContent('benefit.content', true);
    $benefitElements = getContent('benefit.element', orderById: true);
@endphp

<section class="benefit-section pb-110">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xl-6 col-lg-6 col-md-7">
                <div class="benefit">
                    <h2 data-s-break="-1" class="benefit__title">{{ __(@$benefitContent->data_values->heading) }}</h2>
                    <p class="benefit__desc">
                        {{ __(@$benefitContent->data_values->subheading) }}
                    </p>
                    <ul class="benefit__list">
                        @foreach ($benefitElements as $benefitElement)
                            <li class="benefit__item">
                                <h6 class="title">{{ __(@$benefitElement->data_values->title) }}</h6>
                                <p class="desc">
                                    {{ __(@$benefitElement->data_values->description) }}
                                </p>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>
            <div class="col-xl-6 col-lg-6 col-md-5">
                <div class="benefit-thumb">
                    <span class="one">
                        <img src="{{ getImage('assets/images/frontend/benefit/' . @$benefitContent->data_values->benefit_image_two, '355x355') }}"
                            alt="image">
                    </span>
                    <span class="two">
                        <img src="{{ getImage('assets/images/frontend/benefit/' . @$benefitContent->data_values->benefit_image_one, '425x435') }}"
                            alt="image">
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>
