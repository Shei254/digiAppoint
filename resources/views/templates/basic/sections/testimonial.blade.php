@php
    $testimonialContent = getContent('testimonial.content', true);
    $testimonialElements = getContent('testimonial.element', orderById: true);
@endphp

<section class="testimonials pb-110 ">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <div class="section-heading">
                    <h2 class="section-heading__title" data-s-break="2">{{ __(@$testimonialContent->data_values->heading) }}</h2>
                </div>
            </div>
        </div>
        <div class="row justify-content-center g-3">
            @foreach ($testimonialElements as $key => $testimonialElement)
                <div class="col-lg-6 col-md-10">
                    <div class="testimonial-card h-100">
                        <div class="testimonial-card__top">
                            <div class="rating-wrapper">
                                @php
                                    $ratings = $testimonialElement->data_values->ratings;
                                @endphp

                                <ul class="rating-list">
                                    @php  echo avgRating((int)$ratings);  @endphp
                                </ul>
                                <h6 class="text">@lang('for') {{ __(@$testimonialElement->data_values->title) }}</h6>
                            </div>
                            <h6 class="testimonial-card__name">@lang('By') <span
                                    class="text--base">{{ __(@$testimonialElement->data_values->client) }}</span></h6>
                        </div>
                        <p class="testimonial-card__desc">
                            {{ __(@$testimonialElement->data_values->description) }}
                        </p>
                    </div>
                </div>
            @endforeach

        </div>
    </div>
</section>
