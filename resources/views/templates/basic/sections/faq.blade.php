@php
    $faqContent = getContent('faq.content', true);
    $faqElements = getContent('faq.element', orderById: true);
@endphp

<section class="faq-section pb-110 bg-img" data-background-image="{{ getImage($activeTemplateTrue . 'images/thumbs/faq-bg.png') }}">
    <div class="container">
        <div class="row align-items-center justify-content-center">
            <div class="col-xl-6 col-md-7">
                <div class="faq-content">
                    <h2 class="faq-content__title" data-s-break="1">{{ __(@$faqContent->data_values->heading) }}</h2>
                    <div class="accordion custom--accordion" id="accordionExample">
                        @foreach ($faqElements as $key => $faqElement)
                            <div class="accordion-item {{ $key == 1 ? 'show' : '' }}">
                                <h6 class="accordion-header" id="acdnH{{ $key }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                        data-bs-target="#acdnDtArId{{ $key }}" aria-expanded="false"
                                        aria-controls="acdnDtArId{{ $key }}">
                                        {{ __(@$faqElement->data_values->question) }}
                                    </button>
                                </h6>
                                <div id="acdnDtArId{{ $key }}" class="accordion-collapse collapse {{ $key == 1 ? 'show' : '' }}"
                                    aria-labelledby="acdnH{{ $key }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        {{ __(@$faqElement->data_values->answer) }}
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

            </div>
            <div class="col-xl-5 offset-xl-1 col-md-5">
                <div class="faq-thumb">
                    <img src="{{ getImage('assets/images/frontend/faq/' . $faqContent->data_values->image, '530x530') }}" class="w-100"
                        alt="Image">
                </div>
            </div>
        </div>
    </div>
</section>
